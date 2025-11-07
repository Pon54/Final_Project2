@extends('admin.layouts.master')

@section('title','Manage Bookings')

@section('content')
<h2>Manage Bookings</h2>

<div class="panel panel-default">
  <div class="panel-body">
    <table class="table table-striped">
      <thead>
        <tr><th>#</th><th>Booking No</th><th>User</th><th>Vehicle</th><th>From</th><th>To</th><th>Status</th><th>Actions</th></tr>
      </thead>
      <tbody>
        @forelse($bookings as $b)
        <tr>
          <td>{{ $b->id }}</td>
          <td>{{ $b->BookingNumber }}</td>
          <td>{{ $b->user->FullName ?? $b->userEmail }}</td>
          <td>{{ $b->vehicle->VehiclesTitle ?? '—' }}</td>
          <td>{{ $b->FromDate }}</td>
          <td>{{ $b->ToDate }}</td>
          <td>{{ ucfirst($b->status_text) }}</td>
          <td>
            <a href="{{ route('admin.bookings.show', $b->id) }}" class="btn btn-sm btn-primary">View</a>
            <form method="POST" action="{{ route('admin.bookings.setstatus', $b->id) }}" style="display:inline-block">
              @csrf
              <select name="status" class="form-control input-sm" style="display:inline-block; width:120px">
                <option value="new" @if($b->Status==0) selected @endif>New</option>
                <option value="confirmed" @if($b->Status==1) selected @endif>Confirmed</option>
                <option value="canceled" @if($b->Status==2) selected @endif>Canceled</option>
              </select>
              <button class="btn btn-sm btn-success">Set</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="8">No bookings found.</td></tr>
        @endforelse
      </tbody>
    </table>

    {{ $bookings->withQueryString()->links() }}
  </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  // delegate submit for status forms
  document.querySelectorAll('form[action*="/manage-bookings/"]')?.forEach(function(form){
    form.addEventListener('submit', function(e){
      e.preventDefault();
      if (!confirm('Change booking status?')) return;
      var url = form.action;
      var data = new FormData(form);
      var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      fetch(url, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': token,
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: data
      }).then(function(res){
        if(res.ok) return res.text();
        throw new Error('Network response not ok');
      }).then(function(){
        // reload to reflect change
        window.location.reload();
      }).catch(function(err){
        alert('Could not update status: '+err.message);
      });
    });
  });
});
</script>
@endpush

