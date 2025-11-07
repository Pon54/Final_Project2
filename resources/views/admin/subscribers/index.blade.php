@extends('admin.layouts.master')

@section('title','Subscribers')

@section('content')
<h2>Subscribers</h2>
@if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif

<table class="table table-striped">
  <thead><tr><th>ID</th><th>Email</th><th>Actions</th></tr></thead>
  <tbody>
    @forelse($subscribers as $s)
    <tr>
      <td>{{ $s->id }}</td>
      <td>{{ $s->SubscriberEmail }}</td>
      <td>
        <form method="POST" action="{{ route('admin.subscribers.destroy', $s->id) }}">@csrf @method('DELETE')
          <button class="btn btn-sm btn-danger" onclick="return confirm('Remove subscriber?')">Remove</button>
        </form>
      </td>
    </tr>
    @empty
    <tr><td colspan="3">No subscribers.</td></tr>
    @endforelse
  </tbody>
</table>

{{ $subscribers->links() }}

@endsection
