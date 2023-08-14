<?php $pageTitle = "Login" ?>
@extends("layouts.app")

@section("main")
    @if(isset($success))
        <div class="alert alert-success">{{$success}}</div>
    @endif

    <div class="container-fluid min-vh-100 py-sm-5 py-4 px-4 vw-100 bg-gradient d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center align-items-center">
            <div
                class="col-lg-10 bg-white bg-white p-sm-5 p-4 rounded-5">
                <div class="row">
                    <img src="{{asset("images/logos/polandstudylogo.png")}}" alt="Logo" class="w-50 mx-auto mb-3">
                </div>
                <h2 class="text-center text-dark">Welcome to platform!</h2>
                <p class="text-center text-dark">Please enter your details</p>
                <form action="/login" method="POST" id="loginForm">
                    @csrf
                    <div class="row  my-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="email" class="text-dark fw-medium">Email</label>
                                <input type="email" value="{{old("email")}}" name="email" id="email" class="form-control">
                            </div>
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row  my-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="password" class="text-dark fw-medium">Password</label>
                                <input type="password"  value="{{old("password")}}" name="password" id="password" class="form-control">
                            </div>
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
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

