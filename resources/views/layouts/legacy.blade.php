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

    {{-- flash messages (session) --}}
    <div style="max-width:1024px;margin:12px auto;padding:0 12px;">
      @if(session('msg'))
        <div style="background:#e6ffed;border:1px solid #c6f6d5;padding:10px;border-radius:4px;color:#065f46;margin-bottom:12px;">{{ session('msg') }}</div>
      @endif
      @if(session('error'))
        <div style="background:#fff1f2;border:1px solid #fecaca;padding:10px;border-radius:4px;color:#991b1b;margin-bottom:12px;">{{ session('error') }}</div>
      @endif
      @if(session('status'))
        <div style="background:#ebf8ff;border:1px solid #bee3f8;padding:10px;border-radius:4px;color:#0c4a6e;margin-bottom:12px;">{{ session('status') }}</div>
      @endif
    </div>

    <main>
      @yield('content')
    </main>

  @include('partials.legacy_footer')

  @include('partials.modals.login')
  @include('partials.modals.registration')
  @include('partials.modals.forgotpassword')

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
