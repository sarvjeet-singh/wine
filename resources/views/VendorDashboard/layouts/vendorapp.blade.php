<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/wine-country-icon.png') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Wine Country Weekends - ')</title>
    <style>
        :root {
            --theme-main-color: #118C97;
            /* Your color code */
            --theme-text-color: #ffffff;
            /* White color for text */
            --theme-secondary-color: #118c9730;
        }
    </style>

    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="{{ asset('asset/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://www.jqueryscript.net/demo/Responsive-Mobile-friendly-Image-Cropper-With-jQuery-rcrop/dist/rcrop.min.css">
    <link rel="stylesheet" href="{{ asset('asset/css/dataTables.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/star-rating-svg.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset/VendorDashboard/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/VendorDashboard/css/jquery-ui-timepicker-addon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/dataTables.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/VendorDashboard/css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/FrontEnd/css/styles-global.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('asset/VendorDashboard/css/style.css') }}?v={{ time() }}">

    <style>
        .wine-btn:before {
            background: #118C97;
        }
    </style>
    @yield('css')
</head>

<body>
    @php($currentUrl = request()->url())

    @include('VendorDashboard.includes.header')
    <div class="container-fluid main-container">
        <div class="row flex-nowrap">
            @if (!isset($hideSidebar) || !$hideSidebar)
                @include('VendorDashboard.includes.leftNav').
            @endif
            @yield('content')
        </div>
    </div>

    <!-- Include your JavaScript file -->
    <script src="{{ asset('asset/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Include the latest version of jQuery -->
    <script src="{{ asset('asset/js/jquery-3.6.0.min.js') }}"></script>
    <script
        src="https://www.jqueryscript.net/demo/Responsive-Mobile-friendly-Image-Cropper-With-jQuery-rcrop/dist/rcrop.min.js">
    </script>


    <script src="{{ asset('asset/VendorDashboard/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('asset/VendorDashboard/js/jquery-ui-timepicker-addon.min.js') }}"></script>
    <script src="{{ asset('asset/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('asset/js/jquery.star-rating-svg.js') }}"></script>
    <script src="{{ asset('asset/fontawesome/js/all.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('asset/VendorDashboard/js/moment.min.js') }}"></script>
    <script src="{{ asset('asset/VendorDashboard/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('asset/VendorDashboard/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('asset/FrontEnd/js/scripts.js') }}"></script>
    @yield('js')
</body>

</html>
