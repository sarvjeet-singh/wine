<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/wine-country-icon.png') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="cache-control" content="private, max-age=0, no-cache">

    <meta http-equiv="pragma" content="no-cache">

    <meta http-equiv="expires" content="0">

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
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="{{ asset('asset/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/admin/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset/admin/css/responsive.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset/css/jquery-ui.min.css') }}">
    <script src="{{ asset('asset/js/jquery-3.6.0.min.js') }}"></script>
    <!-- jQuery -->

    <!--  -->
    @yield('css')
</head>

<body>
    <section class="main-outer-sec">
        @php($currentUrl = request()->url())

        @include('admin.includes.header')
        @include('admin.includes.sidebar')
        <div class="main-content-outer p-4">
            @include('admin.includes.topbar')
            @yield('content')
        </div>
        @include('admin.includes.footer')
    </section>
    <script src="{{ asset('asset/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('asset/fontawesome/js/all.min.js') }}"></script>
    <script>
        // Show Sub Menu on Sidebar JS
        const parentMenus = document.querySelectorAll('.parent-menu');

        parentMenus.forEach(menu => {
            menu.addEventListener('click', function() {
                // Toggle the class "show-menu" on click
                menu.classList.toggle('show-menu');
            });
        });
    </script>

    @stack('js')

</body>

</html>
