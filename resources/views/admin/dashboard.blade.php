@extends('admin.layouts.master')

@section('title','Dashboard')

@section('content')
<div class="page-title">
    <h1>Admin Dashboard</h1>
    <p>Welcome, {{ session('alogin') }}</p>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body text-center">
                <h4>Vehicles</h4>
                <p class="h3">{{ $vehiclesCount }}</p>
                <a href="{{ route('admin.vehicles.index') }}" class="btn btn-sm btn-primary">Manage Vehicles</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body text-center">
                <h4>Bookings</h4>
                <p class="h3">{{ $bookingsCount }}</p>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-primary">Manage Bookings</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body text-center">
                <h4>Users</h4>
                <p class="h3">{{ $usersCount }}</p>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">Registered Users</a>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">Recent Bookings</div>
    <div class="panel-body">
        @if($recentBookings->count())
        <table class="table table-striped">
            <thead>
                <tr><th>#</th><th>Booking No</th><th>User</th><th>Vehicle</th><th>From</th><th>To</th><th>Status</th></tr>
            </thead>
            <tbody>
                @foreach($recentBookings as $b)
                <tr>
                    <td>{{ $b->id }}</td>
                    <td>{{ $b->BookingNumber }}</td>
                    <td>{{ $b->userEmail }}</td>
                    <td>{{ $b->vehicle->VehicleTitle ?? '—' }}</td>
                    <td>{{ $b->FromDate }}</td>
                    <td>{{ $b->ToDate }}</td>
                    <td>{{ $b->Status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <p>No recent bookings.</p>
        @endif
    </div>
</div>

@endsection
