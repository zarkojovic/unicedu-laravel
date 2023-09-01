@extends("layouts.app")


@section('main')

    <!-- PRELOADER -->
    <div id="preloader">
        <img src="{{ asset("images/logos/spinner.gif") }}" alt="spinner"/>
    </div>
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
         class="alert top-0 toast-notification mt-3 alert-notification alert-success fade show position-fixed px-5"
         role="alert">
    </div>



    <!-- Deal Modal -->
    <div class="modal fade" id="dealModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Make New Application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="fieldsModalWrap">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <script src='https://salebot.pro/js/salebot.js' charset='utf-8'></script>
    <script>
        SaleBotPro.init({
            onlineChatId: '1584'
        });
    </script>

@endsection
