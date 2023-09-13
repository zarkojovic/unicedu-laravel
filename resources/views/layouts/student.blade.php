@extends("layouts.app")


@section('main')

    <!-- PRELOADER -->
{{--    <div id="preloader">--}}
{{--        <img src="{{ asset("images/logos/polandstudylogo.png") }}" alt="spinner" class="rotate-hor-center"/>--}}
{{--    </div>--}}
    <!--  Body Wrapper -->
    <div
        class="page-wrapper"
        id="main-wrapper"
        data-layout="vertical"
        data-navbarbg="skin6"
        data-sidebartype="full"
        data-sidebar-position="fixed"
        data-header-position="fixed"
    >

        @include('components.sidebar')

        <!--  Main wrapper -->
        <div class="body-wrapper">
            @include("components.profile-header")

            @yield('main-content')
        </div>
    </div>


    <div id="myAlert"
         class="alert top-0 toast-notification mt-3 alert-notification alert-success fade show position-fixed px-sm-5 px-sm-3"
         role="alert">
    </div>



    <script src='https://salebot.pro/js/salebot.js' charset='utf-8'></script>
    <script>
        SaleBotPro.init({
            onlineChatId: '1584'
        });
    </script>

@endsection
