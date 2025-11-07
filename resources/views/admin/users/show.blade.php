@extends('admin.layouts.master')

@section('title','User details')

@section('content')
<h2>User details</h2>

<table class="table table-striped">
  <tr><th>ID</th><td>{{ $user->id }}</td></tr>
  <tr><th>Name</th><td>{{ $user->FullName }}</td></tr>
  <tr><th>Email</th><td>{{ $user->EmailId }}</td></tr>
  <tr><th>Contact</th><td>{{ $user->ContactNo }}</td></tr>
  <tr><th>Registered</th><td>{{ $user->created_at ?? 'N/A' }}</td></tr>
</table>

<p><a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back</a></p>

@endsection
@extends('admin.layouts.master')

@section('title','User detail')

@section('content')
<h2>User</h2>

<table class="table">
  <tr><th>ID</th><td>{{ $user->id }}</td></tr>
  <tr><th>Full Name</th><td>{{ $user->FullName }}</td></tr>
  <tr><th>Email</th><td>{{ $user->EmailId }}</td></tr>
  <tr><th>Contact</th><td>{{ $user->ContactNo }}</td></tr>
  <tr><th>Registered</th><td>{{ $user->created_at ?? 'n/a' }}</td></tr>
</table>

<a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back</a>

@endsection
