<?php $pageTitle = "Register" ?>
@extends("layouts.app")

@section("main")
    <div
        class="container-fluid min-vh-100 py-sm-5 py-4 px-4 vw-100 bg-gradient d-flex align-items-center justify-content-center w-100 overflow-x-hidden">
        <div class="row justify-content-center align-items-center">
            <div
                class="col-lg-10 bg-white p-sm-5 p-4 rounded-5">
                <div class="row">
                    <img src="{{asset("images/logos/polandstudylogo.png")}}" alt="Logo" class="w-50 mx-auto mb-3">
                </div>
                <h2 class="text-center text-dark">Welcome to platform!</h2>
                <p class="text-center text-dark">Please enter your details</p>
                <form action="/register" method="POST" id="registerForm">
                    @csrf
                    <div class="row my-3">
                        <div class="col-sm-6 col-12">
                            <div class="form-group">
                                <label for="first_name" class="text-dark fw-medium">First Name</label>
                                <input type="text" value="{{ old('first_name') }}" name="first_name" id="first_name"
                                       class="form-control">
                            </div>

                            <div id="firstNameMessageWrap">
                                @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 col-12 mt-sm-0 mt-3">
                            <div class="form-group">
                                <label for="last_name" class="text-dark fw-medium">Last Name</label>
                                <input type="text" name="last_name" value="{{old('last_name')}}" id="last_name"
                                       class="form-control">
                            </div>
                            <div id="lastNameMessageWrap">
                                @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row  my-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="email" class="text-dark fw-medium">Email</label>
                                <input type="text" name="email" value="{{old('email')}}" id="email"
                                       class="form-control">
                            </div>
                            <div id="emailMessageWrap">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row  my-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="phone" class="text-dark fw-medium">Phone</label>
                                <input type="text" name="phone" id="phone" value="{{old('phone')}}"
                                       class="form-control">
                            </div>

                            <div id="phoneMessageWrap">
                                @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row  my-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="password" class="text-dark fw-medium">Password</label>
                                <input type="password" name="password" value="{{old('password')}}" id="password"
                                       class="form-control">
                            </div>

                            <div id="passwordMessageWrap">
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row  my-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="password" class="text-dark fw-medium">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="form-control">
                            </div>

                            <div id="repeatMessageWrap">
                                @error('repeat_password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <button type="button" id="registrationSubmit" class="w-100 btn btn-primary mt-3">Submit
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="text-center m-0 mt-3">Already have an account? <a href="{{route("login")}}">
                                    Sign
                                    In</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

