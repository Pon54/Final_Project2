<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center" style="padding: 40px 20px;">
        <div style="margin-bottom: 20px;">
          <i class="fa fa-exclamation-triangle" style="font-size: 60px; color: #e74c3c;"></i>
        </div>
        <h3 style="color: #2c3e50; font-weight: 600; margin-bottom: 15px;">Confirm Logout</h3>
        <p style="color: #7f8c8d; font-size: 16px; margin-bottom: 30px;">
          Are you sure you want to log out? You will need to sign in again to access the system.
        </p>
        <div style="display: flex; justify-content: center; gap: 15px;">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding: 12px 40px; font-size: 16px; font-weight: 500; border-radius: 4px; background-color: #5a6c7d; border: none;">
            Cancel
          </button>
          <a href="{{ url('/logout') }}" class="btn btn-danger" style="padding: 12px 40px; font-size: 16px; font-weight: 500; border-radius: 4px; background-color: #e74c3c; border: none;">
            Logout
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
