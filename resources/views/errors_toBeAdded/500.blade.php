<?php $pageTitle = "Notification" ?>
@extends("layouts.app")

@section("main")
    <div class="vh-100 vw-100 bg-gradient d-flex align-items-center justify-content-center ">
        <div class="container">
            <div
                class="col-xl-4 offset-xl-4 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12 bg-white p-sm-5 p-4 rounded-5">
                <div class="row">
                    <img src="{{asset("images/logos/polandstudylogo.png")}}" alt="Logo" class="w-50 mx-auto mb-3">
                </div>
                    <h1 class="text-center">Something went wrong on the server...</h1>
                    <h2 class="text-center">Please try again later.</h2>
                    <p class="text-center"><a href="{{route("home")}}">Go back to safety</a></p>
            </div>
        </div>
    </div>
@endsection

