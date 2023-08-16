<?php $pageTitle = "Notification" ?>
@extends("layouts.app")

@section("main")
    @if(isset($success))
        <div class="alert alert-success">{{$success}}</div>
    @endif
    <div class="vh-100 vw-100 bg-gradient d-flex align-items-center justify-content-center ">
        <div class="container">
            <div
                class="col-xl-4 offset-xl-4 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12 bg-white p-sm-5 p-4 rounded-5">
                <div class="row">
                    <img src="{{asset("images/logos/polandstudylogo.png")}}" alt="Logo" class="w-50 mx-auto mb-3">
                </div>
                @if(isset($type))
                    @switch($type)
                        @case("success_registration")
                            <h1 class="text-center">You registered successfully!</h1>
                            <p class="text-center">We sent you a confirmation link to activate your account!</p>
                            <p class="text-center"><a href="{{route("login")}}">Go to login page</a></p>
                            @break
                        @case("profile_activated")
                            <h1 class="text-center">You activated your account!</h1>
                            <p class="text-center"><a href="{{route("login")}}">Go to login page</a></p>
                            @break
                        @case("activation_failed")
                            <h1 class="text-center">Activation code is invalid!</h1>
                            <p class="text-center"><a href="{{route("login")}}">Go to login page</a></p>
                            @break
                        @case("404")
                            <h1 class="text-center">Oops! Something went wrong...</h1>
                            <p class="text-center"><a href="{{route("home")}}">Go back to safety</a></p>
                            @break
                        @default
                            <script>
                                window.location.href = "{{ route('login') }}";
                            </script>
                            @break
                    @endswitch
                @else
                    <script>
                        window.location.href = "{{ route('login') }}";
                    </script>
                @endif
            </div>
        </div>
    </div>
@endsection

