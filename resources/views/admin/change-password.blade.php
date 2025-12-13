@extends('admin.layouts.master')

@section('title', 'Change Password')

@section('content')
<div class="page-title">
    <h1>Change Password</h1>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">Update Your Password</h4>
    </div>
    <div class="panel-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.change-password') }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <div style="position: relative;">
                            <input type="password" 
                                   id="current_password" 
                                   name="current_password" 
                                   class="form-control" 
                                   required
                                   style="padding-right: 40px;">
                            <i class="fa fa-eye toggle-password" 
                               style="position: absolute; right: 12px; top: 12px; cursor: pointer; color: #999;"
                               onclick="togglePassword('current_password', this)"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <div style="position: relative;">
                            <input type="password" 
                                   id="new_password" 
                                   name="new_password" 
                                   class="form-control" 
                                   required
                                   minlength="6"
                                   style="padding-right: 40px;">
                            <i class="fa fa-eye toggle-password" 
                               style="position: absolute; right: 12px; top: 12px; cursor: pointer; color: #999;"
                               onclick="togglePassword('new_password', this)"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="new_password_confirmation">Confirm New Password</label>
                        <div style="position: relative;">
                            <input type="password" 
                                   id="new_password_confirmation" 
                                   name="new_password_confirmation" 
                                   class="form-control" 
                                   required
                                   minlength="6"
                                   style="padding-right: 40px;">
                            <i class="fa fa-eye toggle-password" 
                               style="position: absolute; right: 12px; top: 12px; cursor: pointer; color: #999;"
                               onclick="togglePassword('new_password_confirmation', this)"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Change Password
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function togglePassword(inputId, icon) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Password confirmation validation
    var newPassword = document.getElementById('new_password');
    var confirmPassword = document.getElementById('new_password_confirmation');
    
    function validatePassword() {
        if (newPassword.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity("Passwords don't match");
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
    
    newPassword.addEventListener('change', validatePassword);
    confirmPassword.addEventListener('keyup', validatePassword);
});
</script>
@endpush