@extends('layouts.legacy')

@section('title', 'Contact Us')

@section('content')
<section class="contact_us section-padding">
  <div class="container">
    <div  class="row">
      <div class="col-md-6">
        <h3>Get in touch using the form below</h3>
        @if(session('error'))<div class="errorWrap"><strong>ERROR</strong>:{{ session('error') }}</div>@endif
        @if(session('msg'))<div class="succWrap"><strong>SUCCESS</strong>:{{ session('msg') }}</div>@endif
        <div class="contact_form gray-bg">
          <form  method="post" action="{{ url('contact') }}">
            @csrf
            <div class="form-group">
              <label class="control-label">Full Name <span>*</span></label>
              <input type="text" name="fullname" class="form-control white_bg" id="fullname" required>
            </div>
            <div class="form-group">
              <label class="control-label">Email Address <span>*</span></label>
              <input type="email" name="email" class="form-control white_bg" id="emailaddress" required>
            </div>
            <div class="form-group">
              <label class="control-label">Phone Number <span>*</span></label>
              <input type="text" name="contactno" class="form-control white_bg" id="phonenumber" required maxlength="10" pattern="[0-9]+">
            </div>
            <div class="form-group">
              <label class="control-label">Message <span>*</span></label>
              <textarea class="form-control white_bg" name="message" rows="4" required></textarea>
            </div>
            <div class="form-group">
              <button class="btn" type="submit" name="send">Send Message <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-6">
        <h3>Contact Info</h3>
        <div class="contact_detail">
          @if(isset($user) && ($user->Address || $user->ContactNo || $user->EmailId))
          <ul>
            <li>
              <div class="icon_wrap"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
              <div class="contact_info_m">{{ $user->Address ?? 'Not set' }}</div>
            </li>
            <li>
              <div class="icon_wrap"><i class="fa fa-phone" aria-hidden="true"></i></div>
              <div class="contact_info_m">{{ $user->ContactNo ?? 'Not set' }}</div>
            </li>
            <li>
              <div class="icon_wrap"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
              <div class="contact_info_m">{{ $user->EmailId ?? 'Not set' }}</div>
            </li>
          </ul>
          @else
          <p class="text-muted" style="padding: 20px;">No contact information available. Please update your profile settings to add your contact details.</p>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
