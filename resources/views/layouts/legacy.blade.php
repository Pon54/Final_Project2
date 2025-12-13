<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Legacy Site') - Final Project</title>
  <!-- Legacy assets -->
  <link rel="stylesheet" href="/legacy/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="/legacy/assets/css/style.css">
  <link rel="stylesheet" href="/legacy/assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="/legacy/assets/css/overrides.css">
  </head>
  <body>
    @include('partials.legacy_header')

    {{-- Success Modal Pop-up (centered) --}}
    @if(session('success_modal'))
    <div id="successModal" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:99999;display:flex;align-items:center;justify-content:center;">
      <div style="background:white;padding:40px;border-radius:8px;box-shadow:0 4px 20px rgba(0,0,0,0.3);text-align:center;max-width:400px;animation:slideIn 0.3s ease-out;">
        <div style="margin-bottom:20px;">
          <i class="fa fa-smile-o" style="font-size:60px;color:#4caf50;"></i>
        </div>
        <h3 style="color:#2c3e50;margin-bottom:15px;font-weight:600;">Notice</h3>
        <p style="color:#7f8c8d;font-size:16px;margin-bottom:30px;">{{ session('success_modal') }}</p>
        <button onclick="document.getElementById('successModal').style.display='none'" class="btn btn-primary" style="padding:10px 40px;font-size:16px;background:#4caf50;border:none;border-radius:4px;cursor:pointer;">
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
      // Auto-close after 5 seconds
      setTimeout(function(){ 
        var modal = document.getElementById('successModal');
        if(modal) {
          modal.style.opacity = '0';
          modal.style.transition = 'opacity 0.3s';
          setTimeout(function(){ modal.style.display = 'none'; }, 300);
        }
      }, 5000);
    </script>
    @endif

    {{-- Error notifications --}}
    @if(session('error'))
    <div style="position:fixed;top:20px;right:20px;z-index:9999;min-width:300px;max-width:400px;">
      <div class="alert alert-danger alert-dismissible" style="background:#f44336;color:white;padding:15px 20px;border-radius:4px;box-shadow:0 4px 6px rgba(0,0,0,0.1);display:flex;align-items:center;gap:10px;">
        <i class="fa fa-exclamation-circle" style="font-size:24px;"></i>
        <span style="flex:1;">{{ session('error') }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color:white;opacity:1;font-size:24px;padding:0;margin:0;background:none;border:none;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
    <script>
      setTimeout(function(){ 
        $('.alert').fadeOut('slow'); 
      }, 3000);
    </script>
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
  <script>
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
