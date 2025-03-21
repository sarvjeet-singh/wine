@extends('FrontEnd.layouts.mainapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')
    <style>
        .error {
            color: #dc3545;
        }

        .update-pwd-sec form div:has(.invalid-feedback) svg {
            right: 35px !important;
            top: 20px !important;
        }

        .update-pwd-sec form div:has(.invalid-feedback) input {
            padding-right: 60px;
        }
    </style>
    <div class="container main-container">
        <div class="row flex-lg-nowrap flex-wrap g-4">
            @include('UserDashboard.includes.leftNav')
            <div class="col right-side">
                <!-- User Update Password Start -->

                <div class="row mt-5">
                    <div class="col-sm-12">
                        <div class="information-box update-pwd-sec">
                            <div class="information-box-head">
                                <div class="box-head-heading d-flex">
                                    <span class="box-head-label theme-color">Password</span>
                                </div>
                            </div>
                            <div class="information-box-body">
                                @if (session('password-success'))
                                    <div class="alert alert-success">
                                        {{ session('password-success') }}
                                    </div>
                                @endif
                                <form method="post" action="{{ route('user-settings-update-password') }}">
                                    @csrf
                                    @if (Auth::user()->password != null)
                                        <div class="row mt-3">
                                            <div class="col-md-6 col-12">
                                                <label class="form-label">Current Password<span
                                                        class="required-filed">*</span></label>
                                                <div style="position:relative;">
                                                    <input type="password"
                                                        class="form-control @error('current_password') is-invalid @enderror"
                                                        name="current_password" placeholder="Enter your current password"
                                                        id="current_password">
                                                    <i class="fa-solid fa-eye toggle-password"
                                                        onclick="togglePasswordVisibility('current_password')"
                                                        style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;"></i>
                                                    @error('current_password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row mt-md-3 mt-0 g-3">
                                        <div class="col-md-6 col-12">
                                            <label class="form-label">New Password<span
                                                    class="required-filed">*</span></label>
                                            <div style="position:relative;">
                                                <input type="password"
                                                    class="form-control @error('new_password') is-invalid @enderror"
                                                    name="new_password" placeholder="Enter your new password"
                                                    id="new_password">
                                                <i class="fa-solid fa-eye toggle-password"
                                                    onclick="togglePasswordVisibility('new_password')"
                                                    style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;"></i>
                                                @error('new_password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <label class="form-label">Confirm New Password<span
                                                    class="required-filed">*</span></label>
                                            <div style="position:relative;">
                                                <input type="password"
                                                    class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                                    name="new_password_confirmation"
                                                    placeholder="Enter your new confirm password"
                                                    id="new_password_confirmation">
                                                <i class="fa-solid fa-eye toggle-password"
                                                    onclick="togglePasswordVisibility('new_password_confirmation')"
                                                    style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;"></i>
                                                @error('new_password_confirmation')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Logout after change password option -->
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="logout_checkbox">
                                                <input type="checkbox" class="form-check-input" name="logout_after_change"
                                                    id="logout_checkbox">
                                                Test new password
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row mt-5">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" class="btn wine-btn">Update Password</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Update Password End -->
            </div>
        </div>
    </div>
    @include('UserDashboard.includes.logout_modal')
@endsection

@section('js')
    <script>
        function togglePasswordVisibility(id) {
            var passwordField = document.getElementById(id);
            var eyeIcon = passwordField.nextElementSibling;
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
@endsection
