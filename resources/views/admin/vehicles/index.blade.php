@extends('admin.layouts.master')

@section('title','Manage Vehicles')

@section('content')
<div class="panel panel-default">
  <div class="panel-heading">
    Manage Vehicles
    <a href="{{ route('admin.vehicles.create') }}" class="btn btn-success btn-xs pull-right">Add Vehicle</a>
  </div>
  <div class="panel-body">
    @if(session('msg')) <div class="alert alert-success">{{ session('msg') }}</div> @endif
    <form id="bulkForm" method="POST" action="{{ route('admin.vehicles.bulkDelete') }}">
      @csrf
      <div class="mb-2">
        <button type="button" id="selectAll" class="btn btn-sm btn-default">Select All</button>
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete selected?')">Delete Selected</button>
        <a href="{{ route('admin.vehicles.export') }}" class="btn btn-primary btn-sm">Export CSV</a>
      </div>
      <table class="table table-striped table-bordered" id="vehicles-table">
        <thead>
          <tr><th><input type="checkbox" id="masterCheck"></th><th>#</th><th>Title</th><th>Brand</th><th>Price/Day</th><th>Image</th><th>Actions</th></tr>
        </thead>
        <tbody>
          @foreach($vehicles as $v)
          <tr>
            <td><input type="checkbox" class="rowCheck" name="ids[]" value="{{ $v->id }}"></td>
            <td>{{ $v->id }}</td>
            <td>{{ $v->VehiclesTitle }}</td>
            <td>{{ $v->brand->BrandName ?? '—' }}</td>
            <td>{{ $v->PricePerDay }}</td>
            <td><img src="{{ asset('legacy/admin/img/vehicleimages/'.$v->Vimage1) }}" style="height:50px"></td>
            <td>
              <a href="{{ route('admin.vehicles.edit',$v->id) }}" class="btn btn-primary btn-xs">Edit</a>
              <button type="button" class="btn btn-danger btn-xs delete-vehicle" data-id="{{ $v->id }}" data-url="{{ route('admin.vehicles.destroy',$v->id) }}">Delete</button>
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
