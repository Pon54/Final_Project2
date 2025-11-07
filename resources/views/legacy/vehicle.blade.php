@extends('layouts.legacy')

@section('title', 'Vehicle Details')

@section('content')
<section id="listing_img_slider">
  @if($vehicle)
    @foreach([$vehicle->Vimage1,$vehicle->Vimage2,$vehicle->Vimage3,$vehicle->Vimage4,$vehicle->Vimage5] as $img)
      @if($img)
        @php
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
        <div><img src="{{ $src }}" class="img-responsive" alt="image" width="900" height="560"></div>
      @endif
    @endforeach
  @else
    <div><img src="/legacy/admin-img/placeholder.jpg" class="img-responsive" alt="image" width="900" height="560"></div>
  @endif
</section>

<section class="listing-detail">
  <div class="container">
    <div class="listing_detail_head row">
      <div class="col-md-9">
        <h2>{{ $vehicle->BrandName ?? 'Brand' }} , {{ $vehicle->VehiclesTitle ?? 'Title' }}</h2>
      </div>
      <div class="col-md-3">
        <div class="price_info">
          <p>${{ $vehicle->PricePerDay ?? '0' }} </p>Per Day
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-9">
        <div class="main_features">
          <ul>
            <li> <i class="fa fa-calendar" aria-hidden="true"></i>
              <h5>{{ $vehicle->ModelYear ?? '' }}</h5>
              <p>Reg.Year</p>
            </li>
            <li> <i class="fa fa-cogs" aria-hidden="true"></i>
              <h5>{{ $vehicle->FuelType ?? '' }}</h5>
              <p>Fuel Type</p>
            </li>
            <li> <i class="fa fa-user-plus" aria-hidden="true"></i>
              <h5>{{ $vehicle->SeatingCapacity ?? '' }}</h5>
              <p>Seats</p>
            </li>
          </ul>
        </div>
        <div class="listing_more_info">
          <div class="listing_detail_wrap"> 
            <ul class="nav nav-tabs gray-bg" role="tablist">
              <li role="presentation" class="active"><a href="#vehicle-overview " aria-controls="vehicle-overview" role="tab" data-toggle="tab">Vehicle Overview </a></li>
              <li role="presentation"><a href="#accessories" aria-controls="accessories" role="tab" data-toggle="tab">Accessories</a></li>
            </ul>
            <div class="tab-content"> 
              <div role="tabpanel" class="tab-pane active" id="vehicle-overview">
                <p>{{ $vehicle->VehiclesOverview ?? 'Overview will appear here.' }}</p>
              </div>
              <div role="tabpanel" class="tab-pane" id="accessories"> 
                <table>
                  <thead>
                    <tr>
                      <th colspan="2">Accessories</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach(['AirConditioner','AntiLockBrakingSystem','PowerSteering','PowerWindows','CDPlayer','LeatherSeats','CentralLocking','PowerDoorLocks','BrakeAssist','DriverAirbag','PassengerAirbag','CrashSensor'] as $acc)
                    <tr>
                      <td>{{ $acc }}</td>
                      <td>@if(!empty($vehicle->$acc))<i class="fa fa-check" aria-hidden="true"></i>@else<i class="fa fa-close" aria-hidden="true"></i>@endif</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <aside class="col-md-3">
        <div class="share_vehicle">
          <p>Share: <a href="#"><i class="fa fa-facebook-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a> <a href="#"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a> </p>
        </div>
        <div class="sidebar_widget">
          <div class="widget_heading">
            <h5><i class="fa fa-envelope" aria-hidden="true"></i>Book Now</h5>
          </div>
          <form method="post" action="{{ url('vehicle/' . $id . '/book') }}">
            @csrf
            <div class="form-group">
              <label>From Date:</label>
              <input type="date" class="form-control" name="fromdate" placeholder="From Date" required>
            </div>
            <div class="form-group">
              <label>To Date:</label>
              <input type="date" class="form-control" name="todate" placeholder="To Date" required>
            </div>
            <div class="form-group">
              <textarea rows="4" class="form-control" name="message" placeholder="Message" required></textarea>
            </div>
            @auth
              <div class="form-group">
                <input type="submit" class="btn"  name="submit" value="Book Now">
              </div>
            @else
              <a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Login For Book</a>
            @endauth
          </form>
        </div>
      </aside>
    </div>
    <div class="space-20"></div>
    <div class="divider"></div>
    <div class="similar_cars">
      <h3>Similar Cars</h3>
      <div class="row">
        @forelse((array)($similar ?? []) as $s)
        <div class="col-md-3 grid_listing">
          <div class="product-listing-m gray-bg">
            <div class="product-listing-img"> <a href="{{ url('vehicle/' . ($s->id ?? 0)) }}">
              @php
                $img = $s->Vimage1 ?? '';
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
              <img src="{{ $src }}" class="img-responsive" alt="image" /> </a>
            </div>
            <div class="product-listing-content">
              <h5><a href="{{ url('vehicle/' . ($s->id ?? 0)) }}">{{ $s->BrandName ?? '' }} , {{ $s->VehiclesTitle ?? '' }}</a></h5>
              <p class="list-price">${{ $s->PricePerDay ?? '' }}</p>
            </div>
          </div>
        </div>
        @empty
        <p>No similar cars available.</p>
        @endforelse
      </div>
    </div>
  </div>
</section>

@endsection
