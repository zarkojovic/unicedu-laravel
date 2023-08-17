@extends("layouts.app")


@section('main')
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


    <script src='https://salebot.pro/js/salebot.js' charset='utf-8'></script>
    <script>
        SaleBotPro.init({
            onlineChatId: '1584'
        });
    </script>
@endsection
