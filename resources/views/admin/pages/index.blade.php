@extends('admin.layouts.master')

@section('title','Manage Pages')

@section('content')
<h2>Manage Pages</h2>

<table class="table table-striped">
  <thead><tr><th>ID</th><th>Name</th><th>Type</th><th>Actions</th></tr></thead>
  <tbody>
    @forelse($pages as $p)
    <tr>
      <td>{{ $p->id }}</td>
      <td>{{ $p->PageName }}</td>
      <td>{{ $p->type }}</td>
      <td>
        <a href="{{ route('admin.pages.edit', $p->id) }}" class="btn btn-sm btn-secondary">Edit</a>
      </td>
    </tr>
    @empty
    <tr><td colspan="4">No pages found.</td></tr>
    @endforelse
  </tbody>
</table>

{{ $pages->links() }}

@endsection
