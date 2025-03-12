<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/wine-country-icon.png') }}" />
    <meta http-equiv="cache-control" content="private, max-age=0, no-cache">

    <meta http-equiv="pragma" content="no-cache">

    <meta http-equiv="expires" content="0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Wine Country Weekends - ')</title>
    <style>
        :root {
            --theme-main-color: #c0a144;
            /* Your color code */
            --theme-text-color: #ffffff;
            /* White color for text */
            --theme-secondary-color: #fcf8e4;
        }
    </style>
    <meta name="title" content="Book Accommodations, Wineries, and Excursions - Wine Country Weekends">
    <meta name="description"
        content="Discover and book unique accommodations, exclusive winery tours, and exciting excursions. Plan your perfect getaway with us!">
    <meta name="keywords" content="accommodation booking, winery tours, excursions, travel packages, luxury stays">
    <meta name="author" content="Wine Country Weekends">
    <meta property="og:title" content="Book Unique Stays and Experiences">
    <meta property="og:description"
        content="Experience luxury accommodations, exclusive winery visits, and thrilling excursions. Book now for an unforgettable adventure!">
    <meta property="og:image" content="https://winecountryweekends.ca/images/FrontEnd/wine.jpg">
    <meta property="og:url" content="https://winecountryweekends.ca/accommodations">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Wine Country Weekends">
    <meta property="og:image:alt" content="Preview of accommodation, winery, and excursion">
    <meta property="og:image:width" content="1920">
    <meta property="og:image:height" content="1281">

    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="{{ asset('asset/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('asset/FrontEnd/css/rcrop.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/dataTables.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/star-rating-svg.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset/css/select2.min.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('asset/FrontEnd/css/owl.carousel.min.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('asset/FrontEnd/css/owl.theme.default.min.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" />
    <link rel="stylesheet" href="{{ asset('asset/FrontEnd/css/daterangepicker2.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('asset/FrontEnd/css/styles-global.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('asset/FrontEnd/css/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('asset/FrontEnd/css/reponsive.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('asset/FrontEnd/css/frontend.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('asset/FrontEnd/css/userdashboard.css') }}?v={{ time() }}">
    <link rel="stylesheet"
        href="{{ asset('asset/FrontEnd/css/userdashboard-responsive.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('asset/FrontEnd/css/jquery-ui.min.css') }}">

    <script src="{{ asset('asset/js/jquery-3.6.0.min.js') }}"></script>
    <!-- jQuery -->

    <!--  -->
    @yield('css')
</head>

<body>
    @php($currentUrl = request()->url())

    @if (request()->is('vendor/login'))
        @include('FrontEnd.includes.vendor-header')
    @else
        @include('FrontEnd.includes.header')
    @endif

    @yield('content')

    @if (request()->is('vendor/login'))
        @include('FrontEnd.includes.vendor-footer')
    @else
        @include('FrontEnd.includes.footer')
    @endif

    <!-- Include your JavaScript file -->
    <script src="{{ asset('asset/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Include the latest version of jQuery -->

    <script
        src="{{ asset('asset/FrontEnd/js/rcrop.js') }}">
    </script>
    <script src="{{ asset('asset/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('asset/js/select2.min.js') }}"></script>
    <script src="{{ asset('asset/js/jquery.star-rating-svg.js') }}"></script>
    <script src="{{ asset('asset/js/select2.min.js') }}"></script>
    <!-- Owl Carousel JS -->
    <script src="{{ asset('asset/FrontEnd/js/owl.carousel.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
    <script src="{{ asset('asset/fontawesome/js/all.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="{{ asset('asset/FrontEnd/js/daterange-2.js') }}"></script>
    <script src="{{ asset('asset/FrontEnd/js/scripts.js') }}"></script>
    <script src="{{ asset('asset/FrontEnd/js/jquery-ui.min.js') }}"></script>
    @yield('js')

</body>

</html>
