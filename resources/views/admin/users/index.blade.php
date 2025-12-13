@extends('admin.layouts.master')

@section('title','Registered Users')

@section('content')
<h2>Registered Users</h2>

<table class="table table-striped">
  <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Contact</th><th>Actions</th></tr></thead>
  <tbody>
    @forelse($users as $u)
    <tr>
      <td>{{ $u->id }}</td>
      <td>{{ $u->FullName }}</td>
      <td>{{ $u->EmailId }}</td>
      <td>{{ $u->ContactNo }}</td>
      <td>
        <a class="btn btn-sm btn-primary" href="{{ route('admin.users.show', $u->id) }}">View</a>
        <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" style="display:inline-block">@csrf @method('DELETE')
          <button class="btn btn-sm btn-danger" onclick="return confirm('Delete user?')">Delete</button>
        </form>
      </td>
    </tr>
    @empty
    <tr><td colspan="5">No users.</td></tr>
    @endforelse
  </tbody>
</table>

{{ $users->links() }}

@endsection
