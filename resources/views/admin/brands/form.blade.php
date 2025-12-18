
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

@php
  $brands = \App\Models\Brand::orderBy('BrandName')->get();
@endphp

@if($brands->count() > 0)
<div class="panel panel-default" style="margin-top: 24px;">
  <div class="panel-heading">Already Posted Brands</div>
  <div class="panel-body" style="padding: 10px 18px;">
    <div class="table-responsive">
      <table class="table table-sm table-bordered" style="background:#fff; margin-bottom:0;">
        <thead>
          <tr>
            <th style="width:60px;">#</th>
            <th>Brand Name</th>
          </tr>
        </thead>
        <tbody>
          @foreach($brands as $b)
          <tr>
            <td>{{ $b->id }}</td>
            <td>{{ $b->BrandName }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endif

@endsection
