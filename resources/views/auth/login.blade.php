@extends('FrontEnd.layouts.mainapp')

@section('content')


    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm-6 padding-left-0 login-left-section">
                <img src="{{ asset('images/FrontEnd/login_register.jpg') }}">

            </div>
            <div class="col-sm-6 login-register-right-section">
                <div class="login-register-mobile-version">
                    <h2>{{ __('Login') }}</h2>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                            @if (session('show_resend_link'))
                                <form action="{{ route('verification.resend') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ session('unverified_email') }}">
                                    <button type="submit" class="btn btn-link text-decoration-none theme-btn">Resend Verification Email</button>
                                </form>
                            @endif
                        </div>
                    @endif
                    <form method="POST" action="{{ route('customer.login.post') }}">
                        @csrf
                        <div class="row mb-3 mt-4">
                            <label for="email" class="col-form-label">{{ __('eMail Address') }}</label>
                            <div class="col-md-12" style="position:relative">
                                <i class="fa-solid fa-envelope login-custom-icon"></i>
                                <input id="email" type="email"
                                    class="form-control left-with-icon @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="Enter your eMail address">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-form-label">{{ __('Password') }}</label>
                            <div class="col-md-12" style="position:relative">
                                <i class="fa-solid fa-lock login-custom-icon"></i>
                                <input id="password" type="password"
                                    class="form-control left-with-icon gpassword @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="current-password"
                                    placeholder="Enter your current password">
                                <i class="fa-solid fa-eye togglePassword3 password-custom-icon"
                                    onclick="togglePasswordVisibility('password')"></i>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 col-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 col-7 text-end">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="wine-btn">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>

                        <div class="row mt-3 mb-3">
                            <div class="col-md-12 text-center">
                                OR
                            </div>
                        </div>
                        <div class="row mt-3 mb-3">
                            <div class="col-md-12 text-center">
                                JOIN OUR <a href="{{ route('register') }}">GUEST REWARDS</a> PROGRAM
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
