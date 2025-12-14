<div class="modal fade" id="signupform">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Sign Up</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="signup_wrap">
            <div class="col-md-12 col-sm-6">
              <form  method="post" action="{{ url('register') }}">
                @csrf
                <div class="form-group">
                  <input type="text" class="form-control" name="fullname" placeholder="Full Name" required>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="mobileno" placeholder="Mobile Number (Optional)" maxlength="10">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" name="emailid" id="emailid" placeholder="Email Address" required>
                </div>
                <div class="form-group" style="position:relative;">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password" required style="padding-right:40px;">
                  <i class="fa fa-eye" id="togglePassword" style="position:absolute;right:15px;top:50%;transform:translateY(-50%);cursor:pointer;color:#888;" onclick="togglePasswordVisibility('password', 'togglePassword')"></i>
                </div>
                <div class="form-group checkbox">
                  <input type="checkbox" id="terms_agree" required checked>
                  <label for="terms_agree">I Agree with <a href="#">Terms and Conditions</a></label>
                </div>
                <div class="form-group">
                  <input type="submit" value="Sign Up" name="signup" id="submit" class="btn btn-block">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer text-center">
        <p>Already got an account? <a href="#loginform" data-toggle="modal" data-dismiss="modal">Login Here</a></p>
      </div>
    </div>
  </div>
</div>
