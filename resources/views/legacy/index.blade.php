@extends('layouts.legacy')

@section('title', 'Home')

@section('content')
<!-- Banners -->
<section id="banner" class="banner-section">
<div class="container">
<div class="div_zindex">
<div class="row">
<div class="col-md-5 col-md-push-7">
<div class="banner_content">
<h1>&nbsp;</h1>
<p>&nbsp; </p>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- /Banners --> 


<!-- Resent Cat-->
<section class="section-padding gray-bg">
<div class="container">
<div class="section-header text-center">
<h2>Find the Best <span>CarForYou</span></h2>
<p>Nothing beats jet2 holiday</p>
</div>
<div class="hero-cta">
  <a href="{{ url('car-listing') }}" class="btn-cta">New Car</a>
</div>
<div class="row"> 
      
<!-- Recently Listed New Cars -->
<div class="tab-content">
<div role="tabpanel" class="tab-pane active" id="resentnewcar">

@if(isset($vehicles) && count($vehicles))
  @foreach($vehicles as $result)
  <div class="col-list-3">
  <div class="recent-car-list">
  <div class="car-info-box"> <a href="{{ url('vehicle/' . ($result->id ?? 0)) }}">
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
    <img src="{{ $src }}" class="img-responsive" alt="image">
  </a>
  <ul>
  <li><i class="fa fa-car" aria-hidden="true"></i>{{ $result->FuelType ?? '' }}</li>
  <li><i class="fa fa-calendar" aria-hidden="true"></i>{{ $result->ModelYear ?? '' }} Model</li>
  <li><i class="fa fa-user" aria-hidden="true"></i>{{ $result->SeatingCapacity ?? '' }} seats</li>
  </ul>
  </div>
  <div class="car-title-m">
  <h6><a href="{{ url('vehicle/' . ($result->id ?? 0)) }}"> {{ $result->VehiclesTitle ?? '' }}</a></h6>
  <span class="price">${{ $result->PricePerDay ?? '' }} /Day</span> 
  </div>
  <div class="inventory_info_m">
  <p>{{ Str::limit($result->VehiclesOverview ?? '', 70) }}</p>
  </div>
  </div>
  </div>
  @endforeach
@else
  <p>wala pa mahuman.</p>
@endif
       
      </div>
    </div>
  </div>
</section>
<!-- /Resent Cat --> 

@endsection
