@extends('FrontEnd.layouts.mainapp')

@section('content')

<div class="vendor-login-sec py-5">
    <div class="container">
            <div class="inner-content">
                <form method="POST" action="{{ route('login') }}">
                    <div class="login-img text-center mb-4">
                        <img src="{{ asset('images/login-img.png') }}" class="img-fluid" alt="Vendor Login">
                        <h3 class="fw-bold fs-4">Vendor Login</h3>
                    </div>
                    @csrf
                    <div class="row mb-3 mt-4">
                        <label for="email" class="col-form-label">{{ __('eMail Address') }}</label>
                        <div class="col-md-12 position-relative form-field">
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
                        <div class="col-md-12 position-relative form-field">
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
                </form>
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
