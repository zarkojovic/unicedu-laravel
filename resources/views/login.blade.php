<?php $pageTitle = "Login" ?>
@extends("layouts.app")

@section("main")
    <div class="vh-100 vw-100 bg-gradient d-flex align-items-center justify-content-center ">
        <div class="container">
            <div class="col-xl-4 offset-xl-4 col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-sm-10 offset-sm-1 col-12 bg-white p-sm-5 p-4 rounded-5">
                <div class="row">
                    <img src="{{asset("images/logos/polandstudylogo.png")}}" alt="Logo" class="w-50 mx-auto mb-3">
                </div>
                <h2 class="text-center text-dark">Welcome to platform!</h2>
                <p class="text-center text-dark">Please enter your details</p>
                <form action="/register" method="POST" id="registerForm">
                    @csrf
                    <div class="row  my-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="email" class="text-dark fw-medium">Email</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row  my-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="password" class="text-dark fw-medium">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="w-100 btn btn-primary mt-3">Submit</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="text-center m-0 mt-3">New to platform? <a href="{{route("register")}}"> Sign
                                    Up</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

