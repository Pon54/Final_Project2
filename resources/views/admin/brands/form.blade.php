
@extends('admin.layouts.master')

@section('title', isset($brand) ? 'Edit Brand' : 'Create Brand')

@section('content')
<div class="panel panel-default">
  <div class="panel-heading">{{ isset($brand) ? 'Edit Brand' : 'Create Brand' }}</div>
  <div class="panel-body">
    @if($errors->any()) <div class="alert alert-danger">{{ implode(', ', $errors->all()) }}</div> @endif
    <form method="POST" action="{{ isset($brand) ? route('admin.brands.update',$brand->id) : route('admin.brands.store') }}">
      @csrf
      @if(isset($brand)) @method('PUT') @endif

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>Brand Name</label>
            <input type="text" name="BrandName" class="form-control" value="{{ old('BrandName', $brand->BrandName ?? '') }}" required>
          </div>
        </div>
      </div>

      <div class="text-center mt-3">
        <button class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
</div>

@endsection
