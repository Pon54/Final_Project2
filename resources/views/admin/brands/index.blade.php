@extends('admin.layouts.master')

@section('title','Manage Brands')

@section('content')
<div class="panel panel-default">
  <div class="panel-heading" style="position:relative;min-height:48px;">
    Manage Vehicle Brands
    <a href="{{ route('admin.brands.create') }}" class="btn btn-secondary pull-right" style="background:#495057;border:none;font-size:1.1em;padding:8px 28px;min-width:170px;color:#fff;box-shadow:0 2px 8px rgba(0,0,0,0.04);border-radius:8px;position:absolute;top:50%;right:20px;transform:translateY(-50%);">
      <i class="fa fa-plus"></i> Add New Brand
    </a>
  </div>
  <div class="panel-body">
    @if(session('msg')) 
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session('msg') }}
      </div> 
    @endif

    @if($brands->count() > 0)
    <div class="table-responsive">
      <table class="table table-striped table-bordered" id="brands-table">
        <thead>
          <tr>
            <th width="80px">#</th>
            <th>Brand Name</th>
            <th width="120px">Total Vehicles</th>
            <th width="150px">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($brands as $brand)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
              <strong>{{ $brand->BrandName }}</strong>
            </td>
            <td>
              <span class="badge" style="background:#495057;color:#fff;font-size:1.05em;padding:10px 22px;border-radius:12px;min-width:90px;display:inline-block;">
                {{ \App\Models\Vehicle::where('VehiclesBrand', $brand->id)->count() }} vehicles
              </span>
            </td>
            <td>
              <div style="display: flex; gap: 12px; align-items: center; justify-content: flex-start;">
                <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-primary btn-lg" style="min-width: 90px; font-size: 1.1em; padding: 8px 20px;">Edit</a>
                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" style="display:inline;">
                  @csrf 
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-lg" style="min-width: 90px; font-size: 1.1em; padding: 8px 20px;">Delete</button>
                </form>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-3 text-center">
      {{ $brands->links() }}
    </div>
    @else
    <div class="alert alert-info text-center">
      <i class="fa fa-info-circle fa-2x"></i>
      <h4>No Brands Found</h4>
      <p>No vehicle brands have been added yet.</p>
      <a href="{{ route('admin.brands.create') }}" class="btn btn-success">
        <i class="fa fa-plus"></i> Add First Brand
      </a>
    </div>
    @endif
  </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable for better functionality
    $('#brands-table').DataTable({
        "responsive": true,
        "pageLength": 25,
        "order": [[1, "asc"]], // Sort by brand name
        "columnDefs": [
            { "orderable": false, "targets": 3 } // Disable sorting on Actions column
        ]
    });
});

function confirmDelete(brandName) {
    return confirm('Are you sure you want to delete the brand "' + brandName + '"?\n\nThis action cannot be undone and may affect associated vehicles.');
}
</script>
@endpush

<style>
.badge {
    font-size: 11px;
}
.btn-group-xs > .btn {
    margin-right: 2px;
}
.panel-heading {
    background: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
}
.table th {
    background: #f1f3f4;
    font-weight: 600;
}
.alert-dismissible {
    position: relative;
}
</style>
@endsection