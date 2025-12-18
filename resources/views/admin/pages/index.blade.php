@extends('admin.layouts.master')

@section('title','Manage Pages')

@section('content')
<h2>Manage Pages</h2>

@if(session('status'))
  <div class="alert alert-success">{{ session('status') }}</div>
@endif

<table class="table table-striped">
  <thead><tr><th>ID</th><th>Name</th><th>Type</th><th>Actions</th></tr></thead>
  <tbody>
    @forelse($pages as $p)
    <tr>
      <td>{{ $p->id }}</td>
      <td>{{ $p->PageName }}</td>
      <td>{{ $p->type }}</td>
      <td>
        <div style="display: flex; gap: 12px; align-items: center; justify-content: flex-start;">
          <a href="{{ route('admin.pages.edit', $p->id) }}" class="btn btn-secondary btn-lg" style="min-width: 90px; font-size: 1.1em; padding: 8px 20px;">Edit</a>
          <form method="POST" action="{{ route('admin.pages.destroy', $p->id) }}" style="display:inline-block">
            @csrf @method('DELETE')
            <button class="btn btn-danger btn-lg" style="min-width: 90px; font-size: 1.1em; padding: 8px 20px;" onclick="return confirm('Delete page?')">Delete</button>
          </form>
        </div>
      </td>
    </tr>
    @empty
    <tr><td colspan="4">No pages found.</td></tr>
    @endforelse
  </tbody>
</table>

{{ $pages->links() }}

@endsection
