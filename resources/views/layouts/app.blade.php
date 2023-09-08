<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('appHeader')
    <title>{{$pageTitle}}</title>
    <link
        rel="shortcut icon"
        type="image/png"
        href="{{asset("images/logos/polandstudylogo.png")}}"
    />
    @vite(['resources/scss/styles.scss'])
</head>

<body class="overflow-x-hidden">
<!-- PRELOADER -->
<div id="preloader">
    <img src="{{ asset("images/logos/polandstudylogo.png") }}" alt="spinner" class="rotate-hor-center"/>
</div>
@yield('main')

@vite(['resources/scss/styles.scss',
            'resources/libs/jquery/dist/jquery.min.js',
            'resources/libs/bootstrap/dist/js/bootstrap.bundle.min.js',
            'resources/js/dashboard.js',
            'resources/js/main.js',
            'resources/js/app.min.js',
            'resources/libs/apexcharts/dist/apexcharts.min.js',
            'resources/libs/simplebar/dist/simplebar.js',
            'resources/js/jquery.ui_1.13.2.js'])

@yield('scripts')

</body>
</html>


