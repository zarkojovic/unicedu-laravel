<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$pageTitle}}</title>
    <link
        rel="shortcut icon"
        type="image/png"
        href="{{asset("images/logos/polandstudylogo.png")}}"
    />
    @vite(['resources/scss/styles.scss'])
</head>

<body class="overflow-x-hidden">

@yield('main')

@vite(['resources/scss/styles.scss',
            'resources/libs/jquery/dist/jquery.min.js',
            'resources/libs/bootstrap/dist/js/bootstrap.bundle.min.js',
            'resources/js/dashboard.js',
            'resources/js/main.js',
            'resources/libs/apexcharts/dist/apexcharts.min.js',
            'resources/libs/simplebar/dist/simplebar.js'])

@yield('scripts')

</body>
</html>

