@extends('admin.layouts.master')

@section('title','Booking Details')

@section('content')
<h2>Booking #{{ $b->BookingNumber }}</h2>

<div class="panel panel-default">
  <div class="panel-body">
    <p><strong>User:</strong> {{ $b->user->FullName ?? $b->userEmail }}</p>
    <p><strong>Vehicle:</strong> {{ $b->vehicle->VehiclesTitle ?? '—' }}</p>
    <p><strong>From:</strong> {{ $b->FromDate }}</p>
    <p><strong>To:</strong> {{ $b->ToDate }}</p>
    <p><strong>Message:</strong> {{ $b->message }}</p>
  <p><strong>Status:</strong> {{ ucfirst($b->status_text) }}</p>

    <form method="POST" action="{{ route('admin.bookings.setstatus', $b->id) }}">
      @csrf
      <div class="form-group">
        <label>Change status</label>
        <select name="status" class="form-control">
          <option value="new" @if($b->Status==0) selected @endif>New</option>
          <option value="confirmed" @if($b->Status==1) selected @endif>Confirmed</option>
          <option value="canceled" @if($b->Status==2) selected @endif>Canceled</option>
        </select>
      </div>
      <button class="btn btn-primary">Update</button>
      <a class="btn btn-default" href="{{ route('admin.bookings.index') }}">Back</a>
    </form>
  </div>
</div>

@endsection
