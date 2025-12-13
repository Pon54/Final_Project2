@extends('admin.layouts.master')

@section('title', isset($page) && $page->id ? 'Edit Page' : 'Create Page')

@section('content')
<h2>{{ isset($page) && $page->id ? 'Edit Page' : 'Create Page' }}</h2>

@if($errors->any())
  <div class="alert alert-danger"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif

<form method="POST" action="{{ isset($page) && $page->id ? route('admin.pages.update', $page->id) : route('admin.pages.store') }}">
  @csrf
  @if(isset($page) && $page->id) @method('PUT') @endif

  <div class="form-group">
    <label>Name</label>
    <input name="PageName" class="form-control" value="{{ old('PageName', $page->PageName ?? '') }}" required>
  </div>
  <div class="form-group">
    <label>Type</label>
    <input name="type" class="form-control" value="{{ old('type', $page->type ?? '') }}">
  </div>
  <div class="form-group">
    <label>Detail</label>
    <textarea name="detail" class="form-control" rows="15" style="font-family: monospace;">{{ old('detail', $page->detail ?? '') }}</textarea>
  </div>

  <button class="btn btn-primary">Save</button>
</form>

@endsection
