@extends('admin.layouts.master')

@section('title','Manage Bookings')

@section('content')
<h2>Manage Bookings</h2>

<div class="panel panel-default">
  <div class="panel-body">
    <table class="table table-striped">
      <thead>
        <tr><th>#</th><th>Booking No</th><th>User</th><th>Vehicle</th><th>From</th><th>To</th><th>Message</th><th>Status</th><th>Actions</th></tr>
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
          <td>{{ Str::limit($b->message ?? 'No message', 30) }}</td>
          <td>{{ ucfirst($b->status_text) }}</td>
          <td>
            <div style="display: flex; gap: 10px; align-items: center;">
              <a href="{{ route('admin.bookings.show', $b->id) }}" class="btn btn-primary btn-lg" style="min-width: 70px; font-size: 1.1em; padding: 8px 20px;">View</a>
              <form method="POST" action="{{ route('admin.bookings.setstatus', $b->id) }}" style="display:inline-block">
                @csrf
                <select name="status" class="form-control" style="display:inline-block; width:140px; height:44px; font-size:1.1em;">
                  <option value="new" @if($b->Status==0) selected @endif>New</option>
                  <option value="confirmed" @if($b->Status==1) selected @endif>Confirmed</option>
                  <option value="canceled" @if($b->Status==2) selected @endif>Canceled</option>
                </select>
                <button class="btn btn-success btn-lg" style="min-width: 60px; font-size: 1.1em; padding: 8px 20px;">Set</button>
              </form>
              <form method="POST" action="{{ route('admin.bookings.destroy', $b->id) }}" style="display:inline-block" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-lg" style="min-width: 70px; font-size: 1.1em; padding: 8px 20px;">Delete</button>
              </form>
            </div>
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
<style>
#statusConfirmModal {
  display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100vw; height: 100vh;
  background: rgba(0,0,0,0.35); align-items: center; justify-content: center;
}
#statusConfirmModal .modal-content {
  background: #fff; padding: 36px 32px 28px 32px; border-radius: 14px; box-shadow: 0 6px 32px rgba(0,0,0,0.18);
  text-align: center; min-width: 320px; max-width: 90vw;
}
#statusConfirmModal .modal-content button { margin: 0 18px; min-width: 80px; font-size: 1.1em; }
</style>
<div id="statusConfirmModal">
  <div class="modal-content">
    <h4 style="margin-bottom: 18px;">Change booking status?</h4>
    <button id="statusConfirmYes" class="btn btn-success">Yes</button>
    <button id="statusConfirmNo" class="btn btn-danger">No</button>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function(){
  // Custom modal for status change
  let pendingForm = null;
  document.querySelectorAll('form[action*="/manage-bookings/"]')?.forEach(function(form){
    form.addEventListener('submit', function(e){
      e.preventDefault();
      pendingForm = form;
      document.getElementById('statusConfirmModal').style.display = 'flex';
    });
  });
  document.getElementById('statusConfirmYes').onclick = function(){
    if (!pendingForm) return;
    var url = pendingForm.action;
    var data = new FormData(pendingForm);
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
      window.location.reload();
    }).catch(function(err){
      alert('Could not update status: '+err.message);
    });
    document.getElementById('statusConfirmModal').style.display = 'none';
    pendingForm = null;
  };
  document.getElementById('statusConfirmNo').onclick = function(){
    document.getElementById('statusConfirmModal').style.display = 'none';
    pendingForm = null;
  };
});
</script>
@endpush

