@extends('admin.layouts.master')

@section('title','Manage Vehicles')

@section('content')
<div class="panel panel-default">
  <div class="panel-heading" style="position:relative;min-height:48px;">
    Manage Vehicles
    <a href="{{ route('admin.vehicles.create') }}" class="btn btn-secondary pull-right" style="background:#495057;border:none;font-size:1.1em;padding:8px 28px;min-width:150px;color:#fff;box-shadow:0 2px 8px rgba(0,0,0,0.04);border-radius:16px;position:absolute;top:50%;right:20px;transform:translateY(-50%);">Add Vehicle</a>
  </div>
  <div class="panel-body">
    <form id="bulkForm" method="POST" action="{{ route('admin.vehicles.bulkDelete') }}">
      @csrf
      <div class="mb-2" style="display: flex; gap: 16px; align-items: flex-start; margin-top: -8px;">
        <button type="button" id="selectAll" class="btn btn-dark btn-lg" style="min-width: 120px; font-size: 1.1em; padding: 10px 24px;">Select All</button>
        <button type="submit" class="btn btn-danger btn-lg" style="min-width: 160px; font-size: 1.1em; padding: 10px 24px;" onclick="return confirm('Delete selected?')">Delete Selected</button>
        <a href="{{ route('admin.vehicles.export') }}" class="btn btn-primary btn-lg" style="min-width: 140px; font-size: 1.1em; padding: 10px 24px;">Export CSV</a>
      </div>
      <table class="table table-striped table-bordered" id="vehicles-table">
        <thead>
          <tr><th><input type="checkbox" id="masterCheck"></th><th>#</th><th>Title</th><th>Brand</th><th>Price/Day</th><th>Rating</th><th>Image</th><th>Actions</th></tr>
        </thead>
        <tbody>
          @foreach($vehicles as $v)
          <tr>
            <td><input type="checkbox" class="rowCheck" name="ids[]" value="{{ $v->id }}"></td>
            <td>{{ $v->id }}</td>
            <td>{{ $v->VehiclesTitle }}</td>
            <td>{{ $v->brand->BrandName ?? '—' }}</td>
            <td>{{ $v->PricePerDay }}</td>
            <td>
              @if(isset($v->rating))
                <span style="color: #ffb400; font-size: 1.1em; font-weight: 600;">&#9733; {{ number_format($v->rating, 1) }}</span>
              @else
                <span style="color: #bbb;">N/A</span>
              @endif
            </td>
            <td style="text-align:center;vertical-align:middle;"><img src="{{ asset('uploads/vehicles/'.$v->Vimage1) }}" style="height:50px;display:inline-block;"></td>
            <td>
              <div style="display: flex; gap: 12px; align-items: center; justify-content: flex-start;">
                <a href="{{ route('admin.vehicles.edit',$v->id) }}" class="btn btn-primary btn-lg" style="min-width: 70px; font-size: 1.1em; padding: 8px 20px;">Edit</a>
                <button type="button" class="btn btn-danger btn-lg delete-vehicle" style="min-width: 90px; font-size: 1.1em; padding: 8px 20px;" data-id="{{ $v->id }}" data-url="{{ route('admin.vehicles.destroy',$v->id) }}">Delete</button>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </form>
    <div class="mt-3">{{ $vehicles->links() }}</div>
  </div>
</div>

@push('scripts')
<script>
// Master checkbox to select/deselect all
document.getElementById('masterCheck')?.addEventListener('change', function(e){
  document.querySelectorAll('.rowCheck').forEach(cb => cb.checked = e.target.checked);
});

// Select All button toggle
document.getElementById('selectAll')?.addEventListener('click', function(){
  const all = Array.from(document.querySelectorAll('.rowCheck'));
  const anyUnchecked = all.some(cb => !cb.checked);
  all.forEach(cb => cb.checked = anyUnchecked);
  // Update master checkbox to match
  document.getElementById('masterCheck').checked = anyUnchecked;
  // Update button text
  this.textContent = anyUnchecked ? 'Deselect All' : 'Select All';
});

// Update master checkbox when individual checkboxes change
document.querySelectorAll('.rowCheck').forEach(function(checkbox) {
  checkbox.addEventListener('change', function() {
    const all = Array.from(document.querySelectorAll('.rowCheck'));
    const allChecked = all.every(cb => cb.checked);
    document.getElementById('masterCheck').checked = allChecked;
  });
});

// Individual delete button handler
document.querySelectorAll('.delete-vehicle').forEach(function(btn) {
  btn.addEventListener('click', function() {
    if (confirm('Delete this vehicle?')) {
      const url = this.getAttribute('data-url');
      const csrfToken = document.querySelector('meta[name="csrf-token"]');
      
      console.log('Delete URL:', url);
      console.log('CSRF Token:', csrfToken ? csrfToken.getAttribute('content') : 'NOT FOUND');
      
      if (!csrfToken) {
        alert('CSRF token not found. Cannot delete.');
        return;
      }
      
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = url;
      
      const csrfInput = document.createElement('input');
      csrfInput.type = 'hidden';
      csrfInput.name = '_token';
      csrfInput.value = csrfToken.getAttribute('content');
      
      const methodInput = document.createElement('input');
      methodInput.type = 'hidden';
      methodInput.name = '_method';
      methodInput.value = 'DELETE';
      
      form.appendChild(csrfInput);
      form.appendChild(methodInput);
      document.body.appendChild(form);
      
      console.log('Form HTML:', form.outerHTML);
      form.submit();
    }
  });
});
</script>
@endpush
@endsection
