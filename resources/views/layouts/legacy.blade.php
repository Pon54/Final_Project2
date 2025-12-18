<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Legacy Site') - Final Project</title>
  <!-- Legacy assets -->
  <link rel="stylesheet" href="/legacy/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="/legacy/assets/css/style.css">
  <link rel="stylesheet" href="/legacy/assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="/legacy/assets/css/overrides.css">
   <!-- <link rel="stylesheet" href="/legacy/assets/css/homepage-bg.css"> -->
  <link rel="stylesheet" href="/legacy/assets/css/custom-bigger-pages.css">
  </head>
  <body class="@yield('body_class')">
   <body>
    @include('partials.legacy_header')

    {{-- Success notifications --}}
    @if(session('success'))
    <div id="successAlert" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:99999;display:flex;align-items:center;justify-content:center;">
      <div style="background:white;padding:40px;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,0.3);text-align:center;max-width:450px;animation:slideIn 0.3s ease-out;">
        <div style="margin-bottom:20px;">
          <i class="fa fa-smile-o" style="font-size:70px;color:#4CAF50;"></i>
        </div>
        <h3 style="color:#2c3e50;margin-bottom:15px;font-weight:600;font-size:24px;">Success!</h3>
        <p style="color:#7f8c8d;font-size:16px;margin-bottom:30px;line-height:1.5;">{{ session('success') }}</p>
        <button onclick="closeSuccessAndShowLogin()" class="btn btn-success" style="padding:12px 50px;font-size:16px;background:#4CAF50;border:none;border-radius:6px;cursor:pointer;color:white;font-weight:600;">
          OK
        </button>
      </div>
    </div>
    <style>
      @keyframes slideIn {
        from {
          transform: translateY(-50px);
          opacity: 0;
        }
        to {
          transform: translateY(0);
          opacity: 1;
        }
      }
    </style>
    <script>
      function closeSuccessAndShowLogin() {
        document.getElementById('successAlert').style.display='none';
        @if(session('show_login_modal'))
          // Open the login modal after closing success popup
          $('#loginform').modal('show');
        @endif
      }
    </script>
    @endif

    {{-- Error notifications --}}
    @if(session('error'))
    <div id="errorAlert" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:99999;display:flex;align-items:center;justify-content:center;">
      <div style="background:white;padding:40px;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,0.3);text-align:center;max-width:450px;animation:slideIn 0.3s ease-out;">
        <div style="margin-bottom:20px;">
          <i class="fa fa-frown-o" style="font-size:70px;color:#f44336;"></i>
        </div>
        <h3 style="color:#2c3e50;margin-bottom:15px;font-weight:600;font-size:24px;">Oops!</h3>
        <p style="color:#7f8c8d;font-size:16px;margin-bottom:30px;line-height:1.5;">{{ session('error') }}</p>
        <button onclick="document.getElementById('errorAlert').style.display='none'" class="btn btn-danger" style="padding:12px 50px;font-size:16px;background:#f44336;border:none;border-radius:6px;cursor:pointer;color:white;font-weight:600;">
          OK
        </button>
      </div>
    </div>
    @endif

    <main>
      @yield('content')
    </main>

  @include('partials.legacy_footer')

  @include('partials.modals.login')
  @include('partials.modals.registration')
  @include('partials.modals.forgotpassword')
  @include('partials.modals.logout_confirm')

  <!-- Legacy scripts -->
  <script src="/legacy/assets/js/jquery.min.js"></script>
  <script src="/legacy/assets/js/bootstrap.min.js"></script>
  <script src="/legacy/assets/js/interface.js"></script>
  <!-- Custom script for bigger About/FAQ/Terms pages if needed -->
  <script>
    // Toggle password visibility
    function togglePasswordVisibility(inputId, iconId) {
      var passwordInput = document.getElementById(inputId);
      var toggleIcon = document.getElementById(iconId);
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
      }
    }

    // Auto-hide success and error alerts after 5 seconds
    $(document).ready(function() {
      setTimeout(function() {
        $('#successAlert').fadeOut('slow');
        $('#errorAlert').fadeOut('slow');
      }, 5000);
    });

    // Make product/listing cards clickable: clicking anywhere on the card follows the first link inside it.
    document.addEventListener('DOMContentLoaded', function(){
      function makeCardsClickable(){
        document.querySelectorAll('.product-listing-m, .col-list-3').forEach(function(card){
          // avoid attaching multiple handlers
          if (card.dataset.clickableAttached) return;
          card.dataset.clickableAttached = '1';
          card.addEventListener('click', function(e){
            // if user clicked a real interactive element (button, a with target) let it be
            var tag = e.target.tagName.toLowerCase();
            if (tag === 'a' || tag === 'button' || e.target.closest('a.btn')) return;
            var link = card.querySelector('a[href]');
            if (link) {
              window.location = link.getAttribute('href');
            }
          });
          // change cursor for card children
          card.style.cursor = 'pointer';
        });
      }
      makeCardsClickable();
      // re-run after AJAX or dynamic content loads (lightweight)
      setTimeout(makeCardsClickable, 500);
    });
  </script>
  </body>
</html>
