@extends('admin.layouts.master')

@section('title','Manage Vehicles')

@section('content')
<div class="panel panel-default">
  <div class="panel-heading">
    Manage Vehicles
    <a href="{{ route('admin.vehicles.create') }}" class="btn btn-success btn-xs pull-right">Add Vehicle</a>
  </div>
  <div class="panel-body">
    @if(session('msg')) <div class="alert alert-success">{{ session('msg') }}</div> @endif
    <form id="bulkForm" method="POST" action="{{ route('admin.vehicles.bulkDelete') }}">
      @csrf
      <div class="mb-2">
        <button type="button" id="selectAll" class="btn btn-sm btn-default">Select All</button>
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete selected?')">Delete Selected</button>
        <a href="{{ route('admin.vehicles.export') }}" class="btn btn-primary btn-sm">Export CSV</a>
      </div>
      <table class="table table-striped table-bordered" id="vehicles-table">
        <thead>
          <tr><th><input type="checkbox" id="masterCheck"></th><th>#</th><th>Title</th><th>Brand</th><th>Price/Day</th><th>Image</th><th>Actions</th></tr>
        </thead>
        <tbody>
          @foreach($vehicles as $v)
          <tr>
            <td><input type="checkbox" class="rowCheck" name="ids[]" value="{{ $v->id }}"></td>
            <td>{{ $v->id }}</td>
            <td>{{ $v->VehicleTitle }}</td>
            <td>{{ $v->brand->BrandName ?? '—' }}</td>
            <td>{{ $v->PricePerDay }}</td>
            <td><img src="{{ asset('legacy/admin/img/vehicleimages/'.$v->Vimage1) }}" style="height:50px"></td>
            <td>
              <a href="{{ route('admin.vehicles.edit',$v->id) }}" class="btn btn-primary btn-xs">Edit</a>
              <form action="{{ route('admin.vehicles.destroy',$v->id) }}" method="POST" style="display:inline">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-xs" onclick="return confirm('Delete vehicle?')">Delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </form>
    <div class="mt-3">{{ $vehicles->links() }}</div>
  </div>
</div>

@push('scripts')
<script>
document.getElementById('masterCheck')?.addEventListener('change', function(e){
  document.querySelectorAll('.rowCheck').forEach(cb => cb.checked = e.target.checked);
});
document.getElementById('selectAll')?.addEventListener('click', function(){
  const all = Array.from(document.querySelectorAll('.rowCheck'));
  const anyUnchecked = all.some(cb => !cb.checked);
  all.forEach(cb => cb.checked = anyUnchecked);
});
</script>
@endpush

<div class="panel panel-default">
  <div class="panel-heading">
    Manage Brands
    <a href="{{ route('admin.brands.create') }}" class="btn btn-success btn-xs pull-right">Add Brand</a>
  </div>
  <div class="panel-body">
    @if(session('msg')) <div class="alert alert-success">{{ session('msg') }}</div> @endif
    <table class="table table-striped">
      <thead><tr><th>#</th><th>Name</th><th>Actions</th></tr></thead>
      <tbody>
        @foreach($brands as $b)
        <tr>
          <td>{{ $b->id }}</td>
          <td>{{ $b->BrandName }}</td>
          <td>
            <a href="{{ route('admin.brands.edit',$b->id) }}" class="btn btn-primary btn-xs">Edit</a>
            <form action="{{ route('admin.brands.destroy',$b->id) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-xs" onclick="return confirm('Delete brand?')">Delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="mt-3">@if(is_object($brands) && method_exists($brands,'links')) {{ $brands->links() }} @endif</div>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    {{ isset($brand) ? 'Edit Brand' : 'Add Brand' }}
    <a href="{{ route('admin.brands.create') }}" class="btn btn-success btn-xs pull-right">Add Brand</a>
  </div>
  <div class="panel-body">
    @if($errors->any()) <div class="alert alert-danger">{{ implode(', ', $errors->all()) }}</div> @endif
    <form method="POST" action="{{ isset($brand) ? route('admin.brands.update',$brand->id) : route('admin.brands.store') }}">
      @csrf
      @if(isset($brand)) @method('PUT') @endif
      <div class="form-group">
        <label>Brand Name</label>
        <input class="form-control" name="BrandName" value="{{ old('BrandName', $brand->BrandName ?? '') }}">
      </div>
      <button class="btn btn-primary">Save</button>
      <a href="{{ route('admin.brands.index') }}" class="btn btn-default">Cancel</a>
    </form>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading">
    {{ isset($vehicle) ? 'Edit Vehicle' : 'Add Vehicle' }}
  </div>
  <div class="panel-body">
    @if($errors->any()) <div class="alert alert-danger">{{ implode(', ', $errors->all()) }}</div> @endif
    <form method="POST" action="{{ isset($vehicle) ? route('admin.vehicles.update',$vehicle->id) : route('admin.vehicles.store') }}" enctype="multipart/form-data">
      @csrf
      @if(isset($vehicle)) @method('PUT') @endif

      <div class="form-group">
        <label>Title</label>
        <input class="form-control" name="VehicleTitle" value="{{ old('VehicleTitle', $vehicle->VehicleTitle ?? '') }}">
      </div>
      <div class="form-group">
        <label>Price Per Day</label>
        <input class="form-control" name="PricePerDay" value="{{ old('PricePerDay', $vehicle->PricePerDay ?? '') }}">
      </div>
      <div class="form-group">
        <label>Brand</label>
        <select name="BrandId" class="form-control">
          <option value="">-- Select Brand --</option>
          @foreach($brands as $b)
            <option value="{{ $b->id }}" {{ (old('BrandId', $vehicle->BrandId ?? '') == $b->id) ? 'selected' : '' }}>{{ $b->BrandName }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Image</label>
        <input type="file" class="form-control" name="Vimage1" id="Vimage1Input">
        <div class="mt-2">
          <img id="Vimage1Preview" src="{{ isset($vehicle) && $vehicle->Vimage1 ? asset('legacy/admin/img/vehicleimages/'.$vehicle->Vimage1) : '' }}" style="max-height:150px; display: {{ isset($vehicle) && $vehicle->Vimage1 ? 'block' : 'none' }};">
        </div>
      </div>

      <button class="btn btn-primary">Save</button>
      <a href="{{ route('admin.vehicles.index') }}" class="btn btn-default">Cancel</a>
    </form>
  </div>
</div>

@push('scripts')
<script>
document.getElementById('Vimage1Input')?.addEventListener('change', function(e){
  const f = e.target.files[0];
  if(!f) return;
  const reader = new FileReader();
  reader.onload = function(ev){
    const img = document.getElementById('Vimage1Preview');
    img.src = ev.target.result;
    img.style.display = 'block';
  }
  reader.readAsDataURL(f);
});
</script>
@endpush
@endsection
