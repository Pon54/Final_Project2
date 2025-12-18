<!-- Legacy footer converted -->
<footer>
  <div style="background:#222; padding:18px 0 8px 0;">
    <div class="container" style="max-width:1100px;">
      <div style="display:flex;flex-wrap:wrap;justify-content:space-between;align-items:flex-start;gap:40px;">
        <!-- Subscribe Section -->
        <div style="flex:1 1 320px;min-width:260px;max-width:350px;">
          <h6 style="margin-bottom:8px;font-size:15px;letter-spacing:1px;color:#fff;">SUBSCRIBE TO OUR CAR RENTAL PORTAL</h6>
          <form method="post" action="{{ url('/subscribe') }}" style="margin-bottom:0;">
            @csrf
            <input type="email" name="subscriberemail" required placeholder="Enter Email Address"
              style="width:100%;height:30px;font-size:14px;padding:4px 10px;margin-bottom:8px;border-radius:2px;border:1px solid #444;">
            <button type="submit" name="emailsubscibe"
              style="width:100%;padding:8px 0;font-size:16px;border-radius:3px;background:#fa2837;color:#fff;border:none;font-weight:bold;">Subscribe <span><i class="fa fa-angle-right"></i></span></button>
          </form>
          <p style="font-size:12px;color:#888;margin:6px 0 0 0;">*We send great deals and latest auto news to our subscribed users every week.</p>
        </div>
        <!-- Navigation Links -->
        <nav style="flex:2 1 500px;display:flex;justify-content:space-between;align-items:center;gap:0;min-width:320px;">
          <a href="{{ url('page?type=aboutus') }}" style="color:#fa2837;text-decoration:none;font-size:15px;">About Us</a>
          <a href="{{ url('page?type=faqs') }}" style="color:#fa2837;text-decoration:none;font-size:15px;">FAQs</a>
          <a href="{{ url('page?type=privacy') }}" style="color:#fa2837;text-decoration:none;font-size:15px;">Privacy</a>
          <a href="{{ url('page?type=terms') }}" style="color:#fa2837;text-decoration:none;font-size:15px;">Terms of use</a>
          <a href="{{ url('admin') }}" style="color:#fa2837;text-decoration:none;font-size:15px;">Admin Login</a>
        </nav>
      </div>
    </div>
  </div>
  <div style="background:#1a1a1a;padding:4px 0 2px 0;">
    <div class="container">
      <div style="display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;">
        <div style="font-size:12px;color:#eee;">Car Rental Portal.</div>
        <div style="display:flex;align-items:center;gap:5px;">
          <span style="font-size:13px;margin-right:6px;">Connect:</span>
          <a href="#"><i class="fa fa-facebook-square" style="font-size:16px;color:#fff;"></i></a>
          <a href="#"><i class="fa fa-twitter-square" style="font-size:16px;color:#fff;"></i></a>
          <a href="#"><i class="fa fa-linkedin-square" style="font-size:16px;color:#fff;"></i></a>
          <a href="#"><i class="fa fa-google-plus-square" style="font-size:16px;color:#fff;"></i></a>
          <a href="#"><i class="fa fa-instagram" style="font-size:16px;color:#fff;"></i></a>
        </div>
      </div>
    </div>
  </div>
</footer>
