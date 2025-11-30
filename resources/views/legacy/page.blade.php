@extends('layouts.legacy')

@section('title', $page->PageName ?? 'Page')

@section('content')

<section class="page-header aboutus_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>{{ $page->PageName }}</h1>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="#">Home</a></li>
        <li>{{ $page->PageName }}</li>
      </ul>
    </div>
  </div>
  <!-- Dark Overlay-->
  <div class="dark-overlay"></div>
</section>
<section class="about_us section-padding">
  <div class="container">
    <div class="section-header text-center">
      <h2>{{ $page->PageName }}</h2>
      <div style="text-align: justify;">{!! $page->detail !!}</div>
    </div>
  </div>
</section>

<style>
.section-header p,
.section-header div {
  text-align: justify !important;
  text-justify: inter-word;
  line-height: 1.8 !important;
  margin-bottom: 15px !important;
}

.section-header div p {
  margin-bottom: 20px !important;
  line-height: 1.8 !important;
}

.section-header h2 {
  margin-bottom: 30px !important;
}

.section-header ul,
.section-header ol {
  text-align: justify !important;
  margin-bottom: 20px !important;
  line-height: 1.8 !important;
  padding-left: 20px !important;
}

.section-header li {
  margin-bottom: 20px !important;
  padding-left: 10px !important;
  line-height: 1.8 !important;
}

/* FAQ specific styling */
.section-header ol li {
  margin-bottom: 25px !important;
  padding: 0 !important;
  background: transparent;
  border: none;
}

.section-header ol li:last-child {
  margin-bottom: 0 !important;
}
</style>

@endsection
