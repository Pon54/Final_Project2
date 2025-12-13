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

    {{-- Success message modal popup --}}
    @if(session('msg'))
    <div id="successModal" style="display:flex;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
      <div style="background:white;border-radius:8px;box-shadow:0 4px 20px rgba(0,0,0,0.3);max-width:450px;width:90%;padding:0;overflow:hidden;">
        <div style="background:#10b981;padding:20px;text-align:center;">
          <i class="fa fa-check-circle" style="font-size:48px;color:white;"></i>
        </div>
        <div style="padding:30px;text-align:center;">
          <h3 style="margin:0 0 15px 0;color:#333;font-size:24px;">Success!</h3>
          <p style="margin:0;color:#666;font-size:16px;line-height:1.5;">{{ session('msg') }}</p>
        </div>
        <div style="padding:0 30px 30px 30px;text-align:center;">
          <button onclick="closeSuccessModal()" style="background:#10b981;color:white;border:none;padding:12px 40px;border-radius:6px;font-size:16px;cursor:pointer;font-weight:500;">OK</button>
        </div>
      </div>
    </div>
    <script>
      function closeSuccessModal() {
        document.getElementById('successModal').style.display = 'none';
      }
      // Auto close after 3 seconds
      setTimeout(closeSuccessModal, 3000);
      // Close on outside click
      document.getElementById('successModal').addEventListener('click', function(e) {
        if (e.target.id === 'successModal') {
          closeSuccessModal();
        }
      });
    </script>
    @endif

    {{-- Error message modal popup --}}
    @if(session('error'))
    <div id="errorModal" style="display:flex;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
      <div style="background:white;border-radius:8px;box-shadow:0 4px 20px rgba(0,0,0,0.3);max-width:450px;width:90%;padding:0;overflow:hidden;">
        <div style="background:#ef4444;padding:20px;text-align:center;">
          <i class="fa fa-times-circle" style="font-size:48px;color:white;"></i>
        </div>
        <div style="padding:30px;text-align:center;">
          <h3 style="margin:0 0 15px 0;color:#333;font-size:24px;">Error</h3>
          <p style="margin:0;color:#666;font-size:16px;line-height:1.5;">{{ session('error') }}</p>
        </div>
        <div style="padding:0 30px 30px 30px;text-align:center;">
          <button onclick="closeErrorModal()" style="background:#ef4444;color:white;border:none;padding:12px 40px;border-radius:6px;font-size:16px;cursor:pointer;font-weight:500;">OK</button>
        </div>
      </div>
    </div>
    <script>
      function closeErrorModal() {
        document.getElementById('errorModal').style.display = 'none';
      }
      // Close on outside click
      document.getElementById('errorModal').addEventListener('click', function(e) {
        if (e.target.id === 'errorModal') {
          closeErrorModal();
        }
      });
    </script>
    @endif

    <main>
      @yield('content')
    </main>

  @include('partials.legacy_footer')

  @include('partials.modals.login')
  @include('partials.modals.registration')
  @include('partials.modals.forgotpassword')

  <!-- Logout Confirmation Modal -->
  <div id="logoutModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:white;border-radius:8px;padding:30px;max-width:450px;width:90%;box-shadow:0 4px 20px rgba(0,0,0,0.3);text-align:center;">
      <div style="margin-bottom:20px;">
        <i class="fa fa-exclamation-triangle" style="font-size:48px;color:#ff2e3c;"></i>
      </div>
      <h3 style="margin-bottom:15px;color:#2c3e50;font-size:24px;">Confirm Logout</h3>
      <p style="color:#666;margin-bottom:30px;font-size:16px;line-height:1.5;">Are you sure you want to log out? You will need to sign in again to access the system.</p>
      <div style="display:flex;gap:10px;justify-content:center;">
        <button onclick="closeLogoutModal()" style="padding:12px 30px;background:#6c757d;color:white;border:none;border-radius:5px;cursor:pointer;font-size:16px;font-weight:600;">Cancel</button>
        <a id="logoutConfirmBtn" href="#" style="padding:12px 30px;background:#ff2e3c;color:white;border:none;border-radius:5px;cursor:pointer;font-size:16px;font-weight:600;text-decoration:none;display:inline-block;">Logout</a>
      </div>
    </div>
  </div>

  <script>
    function showLogoutModal(logoutUrl) {
      document.getElementById('logoutConfirmBtn').href = logoutUrl;
      document.getElementById('logoutModal').style.display = 'flex';
    }
    function closeLogoutModal() {
      document.getElementById('logoutModal').style.display = 'none';
    }
    // Close modal on outside click
    document.getElementById('logoutModal')?.addEventListener('click', function(e) {
      if (e.target.id === 'logoutModal') {
        closeLogoutModal();
      }
    });
  </script>

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
