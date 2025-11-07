@extends('layouts.legacy')

@section('title', 'Car Listing')

@section('content')
<section class="listing-page">
  <div class="container">
    <div class="row">
      <div class="col-md-9 col-md-push-3">
        <div class="result-sorting-wrapper">
          <div class="sorting-count">
            <p><span>{{ $count ?? 0 }} Listings found against search "{{ $search ?? '' }}"</span></p>
          </div>
        </div>

        @if(isset($vehicles) && count($vehicles))
          @foreach($vehicles as $result)
            <div class="product-listing-m gray-bg">
              <div class="product-listing-img">
                @php
                  $img = $result->Vimage1 ?? '';
                  $paths = [
                    "legacy/admin-img/vehicleimages/{$img}",
                    "legacy/admin/img/vehicleimages/{$img}",
                    "legacy/img/vehicleimages/{$img}",
                    "legacy/admin-img/{$img}",
                    "legacy/admin/{$img}",
                    "legacy/img/{$img}",
                    "legacy/assets/images/{$img}",
                  ];
                  $src = asset('legacy/assets/images/car_755x430.png');
                  foreach($paths as $p){ $full = public_path($p); if($img && file_exists($full)){ $src = asset($p); break; } }
                @endphp
                <img src="{{ $src }}" class="img-responsive" alt="Image" />
              
              </div>
              <div class="product-listing-content">
                <h5><a href="{{ url('vehicle/' . ($result->id ?? 0)) }}">{{ $result->BrandName ?? '' }} , {{ $result->VehiclesTitle ?? '' }}</a></h5>
                <p class="list-price">${{ $result->PricePerDay ?? '' }} Per Day</p>
                <ul>
                  <li><i class="fa fa-user" aria-hidden="true"></i>{{ $result->SeatingCapacity ?? '' }} seats</li>
                  <li><i class="fa fa-calendar" aria-hidden="true"></i>{{ $result->ModelYear ?? '' }} model</li>
                  <li><i class="fa fa-car" aria-hidden="true"></i>{{ $result->FuelType ?? '' }}</li>
                </ul>
                <a href="{{ url('vehicle/' . ($result->id ?? 0)) }}" class="btn">View Details <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></a>
              </div>
            </div>
          @endforeach
        @else
          <p>No vehicles found. Please try another search.</p>
        @endif

        {{-- pagination for full listing (car-listing) --}}
        @if(is_object($vehicles) && method_exists($vehicles, 'links'))
          <div class="pagination-wrapper">{{ $vehicles->links() }}</div>
        @endif
      </div>

      <aside class="col-md-3 col-md-pull-9">
        <div class="sidebar_widget">
          <div class="widget_heading">
            <h5><i class="fa fa-filter" aria-hidden="true"></i> Find Your  Car </h5>
          </div>
          <div class="sidebar_filter">
            <form action="{{ url('search') }}" method="get">
              <div class="form-group select">
                <select class="form-control" name="brand">
                  <option value="">Select Brand</option>
                </select>
              </div>
              <div class="form-group select">
                <select class="form-control" name="fuel">
                  <option value="">Select Fuel Type</option>
                  <option value="Petrol">Petrol</option>
                  <option value="Diesel">Diesel</option>
                  <option value="CNG">CNG</option>
                </select>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-block"><i class="fa fa-search" aria-hidden="true"></i> Search Car</button>
              </div>
            </form>
          </div>
        </div>

        <div class="sidebar_widget">
          <div class="widget_heading">
            <h5><i class="fa fa-car" aria-hidden="true"></i> Recently Listed Cars</h5>
          </div>
          <div class="recent_addedcars">
            <ul>
              @forelse((array)($recent ?? []) as $r)
              <li class="gray-bg">
                <div class="recent_post_img"> <a href="{{ url('vehicle/' . ($r->id ?? 0)) }}">
                  @php
                    $img = $r->Vimage1 ?? '';
                    $paths = [
                      "/legacy/admin-img/vehicleimages/{$img}",
                      "/legacy/img/vehicleimages/{$img}",
                      "/legacy/admin-img/{$img}",
                      "/legacy/img/{$img}",
                      "/legacy/assets/images/{$img}",
                    ];
                    $src = '/legacy/assets/images/car_755x430.png';
                    foreach($paths as $p){ if($img && file_exists(public_path($p))){ $src = $p; break; } }
                  @endphp
                  <img src="{{ $src }}" alt="image">
                </a> </div>
                <div class="recent_post_title"> <a href="{{ url('vehicle/' . ($r->id ?? 0)) }}">{{ $r->BrandName ?? '' }}, {{ $r->VehiclesTitle ?? '' }}</a>
                  <p class="widget_price">${{ $r->PricePerDay ?? '' }} Per Day</p>
                </div>
              </li>
              @empty
              <li>No recent cars.</li>
              @endforelse
            </ul>
          </div>
        </div>
      </aside>
    </div>
  </div>
</section>

@endsection
