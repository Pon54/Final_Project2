@extends('admin.layouts.master')

@section('title','Manage Testimonials')

@section('content')
<h2>Testimonials</h2>
@if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif

<table class="table table-striped">
  <thead><tr><th>ID</th><th>User</th><th>Content</th><th>Status</th><th>Actions</th></tr></thead>
  <tbody>
    @forelse($testimonials as $t)
    <tr>
      <td>{{ $t->id }}</td>
      <td>{{ $t->UserEmail }}</td>
  <td>{{ \Illuminate\Support\Str::limit($t->Testimonial, 120) }}</td>
      <td>{{ $t->status }}</td>
      <td>
        <form method="POST" action="{{ route('admin.testimonials.setstatus', $t->id) }}" style="display:inline-block">
          @csrf
          <select name="status" class="form-control input-sm" style="display:inline-block; width:120px">
            <option value="0" @if($t->status==0) selected @endif>Pending</option>
            <option value="1" @if($t->status==1) selected @endif>Approved</option>
          </select>
          <button class="btn btn-sm btn-success">Set</button>
        </form>
        <form method="POST" action="{{ route('admin.testimonials.destroy', $t->id) }}" style="display:inline-block">@csrf @method('DELETE')
          <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
        </form>
      </td>
    </tr>
    @empty
    <tr><td colspan="5">No testimonials.</td></tr>
    @endforelse
  </tbody>
</table>

{{ $testimonials->links() }}

@endsection
