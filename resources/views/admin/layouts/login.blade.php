<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/wine-country-icon.png') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Wine Country Weekends - ')</title>
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

    @yield('content')
    
    <script src="{{ asset('asset/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('asset/fontawesome/js/all.min.js') }}"></script>
    @yield('js')

</body>

</html>