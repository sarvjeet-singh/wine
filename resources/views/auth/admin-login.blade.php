<!doctype html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">



<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ asset('images/wine-country-icon.png') }}" />



    <!-- CSRF Token -->

    <meta name="csrf-token" content="{{ csrf_token() }}">



    <title>@yield('title', 'Admin Login - Wine Country Weekends')</title>

    <!-- Link to your CSS file -->

    <link rel="stylesheet" href="{{ asset('asset/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('asset/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('asset/admin/css/style.css') }}" />

    <link rel="stylesheet" href="{{ asset('asset/admin/css/responsive.css') }}" />



    <script src="{{ asset('asset/js/jquery-3.6.0.min.js') }}"></script>

    <!-- jQuery -->



    <!--  -->

    @yield('css')

</head>



<body>

    @php($currentUrl = request()->url())



    <section class="login-sec p-lg-5 p-3">

        <div class="container-fluid h-100">

            <div class="row g-0 h-100">

                <div class="col-md-6">

                    <div class="logo-desc-outer dark-bg d-flex align-items-center justify-content-center p-3 h-100">

                        <div class="logo-desc text-center">

                            <img src="{{ asset('asset/admin/images/logo-white.png') }}" class="img-fluid w-75 mb-3"

                                alt="Logo" />

                            <p class="text-white mb-0">Welcome to Wine Country Weekends Admin Panel! Log in to access your admin tools.</p>

                        </div>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="login-form d-flex justify-content-center flex-column h-100">
                        <h2 class="fw-bold">Welcome</h2>

                        <p>Sign in to your account</p>



                        <!-- Laravel Form -->

                        <form method="POST" action="{{ route('admin.login') }}">

                            @csrf <!-- Laravel CSRF protection -->



                            <div class="row g-3">

                                <div class="col-12">

                                    <div class="form-field position-relative">

                                        <input type="email" class="form-control @error('email') is-invalid @enderror"

                                            name="email" value="{{ old('email') }}" placeholder="Email Address"

                                            required autofocus>

                                        <i class="fa-regular fa-user"></i>



                                        @error('email')

                                            <span class="invalid-feedback" role="alert">

                                                <strong>{{ $message }}</strong>

                                            </span>

                                        @enderror

                                    </div>

                                </div>



                                <div class="col-12">

                                    <div class="form-field position-relative">

                                        <input type="password"

                                            class="form-control @error('password') is-invalid @enderror" name="password"

                                            placeholder="Password" required>

                                        <i class="fa-solid fa-lock"></i>



                                        @error('password')

                                            <span class="invalid-feedback" role="alert">

                                                <strong>{{ $message }}</strong>

                                            </span>

                                        @enderror

                                    </div>

                                </div>

                            </div>



                            <div class="stay-login d-flex justify-content-between py-3">

                                <div class="form-check">

                                    <input class="form-check-input" type="checkbox" id="gridCheck1" name="remember">

                                    <label class="form-check-label" for="gridCheck1">

                                        Remember Me

                                    </label>

                                </div>
                            </div>



                            <div class="login-btn">

                                <button type="submit" class="btn theme-btn w-100">Login Now</button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </section>



    <script src="{{ asset('asset/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('asset/fontawesome/js/all.min.js') }}"></script>

    @yield('js')



</body>



</html>

