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
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="invalid-feedback" style="display:block">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                                @endif
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
@section('scripts')
    <script src="https://www.google.com/recaptcha/api.js?render={{config('services.recaptcha.site_key')}}"></script>

    <script>


        function hideSpinner() {
            $("#preloader").fadeOut();
        }

        function showSpinner() {
            $("#preloader").fadeIn();
        }

        // registration

        function validatePhoneNumber() {
            // Get the form elements
            const phoneNumberInput = document.getElementById('phone');

            // Your regex pattern for phone number validation
            const phoneNumberPattern = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;

            const phoneNumber = phoneNumberInput.value;

            if (!phoneNumberPattern.test(phoneNumber)) {
                document.getElementById("phoneMessageWrap").innerHTML = `<span class="text-danger">Invalid phone number. Please enter a valid phone number.</span>`;
                return 0;
            } else {
                document.getElementById("phoneMessageWrap").innerHTML = '';
                return 1;
            }
        }

        function validateName(type) {
            var nameInput;
            if (type === 'first') {
                // Get the form elements
                nameInput = document.getElementById('first_name');
            } else {
                // Get the form elements
                nameInput = document.getElementById('last_name');
            }

            // Your regex pattern for last name validation
            const namePattern = /^[\w'\-,.][^0-9_!¡?÷?¿/\\+=@#$%ˆ&*(){}|~<>;:[\]]{2,}$/;

            const name = nameInput.value;


            if (!namePattern.test(name)) {
                if (type === 'first') {
                    document.getElementById("firstNameMessageWrap").innerHTML = `<span class="text-danger">Invalid first name. Please enter a valid first name.</span>`;
                } else {
                    document.getElementById("lastNameMessageWrap").innerHTML = `<span class="text-danger">Invalid last name. Please enter a valid last name.</span>`;
                }
                return 0;
            } else {

                if (type === 'first') {
                    document.getElementById("firstNameMessageWrap").innerHTML = '';
                } else {
                    document.getElementById("lastNameMessageWrap").innerHTML = '';
                }
                return 1;
            }
        }

        function validateEmail() {
            // Get the form elements
            const emailInput = document.getElementById('email');
            // Your regex pattern for email validation
            const emailPattern = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
            const email = emailInput.value;
            if (!emailPattern.test(email)) {
                document.getElementById("emailMessageWrap").innerHTML = `<span class="text-danger">Invalid email address. Please enter a valid email address.</span>`;
                return 0;
            } else {
                document.getElementById("emailMessageWrap").innerHTML = '';
                return 1;
            }
        }

        function validatePassword() {
            const passwordInput = document.getElementById('password');

            // Get the values entered by the user
            const password = passwordInput.value;
            const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
            if (!passwordPattern.test(password)) {
                document.getElementById("passwordMessageWrap").innerHTML = `<span class="text-danger">Password must have at least 8 characters (One big, one small and one number)</span>`;
                return 0;
            } else {
                document.getElementById("passwordMessageWrap").innerHTML = '';
                return 1;
            }
        }

        function validateRepeatPassword() {
            // Get the form elements
            const passwordInput = document.getElementById('password');
            const repeatPasswordInput = document.getElementById('password_confirmation');

            const password = passwordInput.value;
            const repeatPassword = repeatPasswordInput.value;

            if (password !== repeatPassword) {
                document.getElementById("repeatMessageWrap").innerHTML = `<span class="text-danger">Passwords do not match. Please re-enter the password.</span>`;
                return 0;
            } else {
                document.getElementById("repeatMessageWrap").innerHTML = '';
                return 1;
            }
        }

        function handleSubmit() {
            var err = 0;
            // Validate the email input
            if (!validateEmail()) {
                err = 1;
            }
            if (!validatePassword()) {
                err = 1;
            }
            if (!validateRepeatPassword()) {
                err = 1;
            }
            if (!validateName('first')) {
                err = 1;
            }
            if (!validateName('last')) {
                err = 1;
            }
            if (!validatePhoneNumber()) {
                err = 1;
            }

            if (!err) {
                showSpinner()
                grecaptcha.ready(function () {
                    grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {action: 'submit'}).then(function (token) {
                        document.getElementById('g-recaptcha-response').value = token;
                        document.getElementById("registerForm").submit();
                    });
                });
            }
        }


        const registerForm = document.getElementById('registerForm');
        document.getElementById('email').addEventListener('change', validateEmail);
        document.getElementById('password').addEventListener('change', validatePassword);
        document.getElementById('password_confirmation').addEventListener('change', validateRepeatPassword);
        document.getElementById('phone').addEventListener('change', validatePhoneNumber);
        document.getElementById('last_name').addEventListener('change', function () {
            validateName('last')
        });
        document.getElementById('first_name').addEventListener('change', function () {
            validateName('first')
        });
        document.getElementById('registrationSubmit').addEventListener('click', handleSubmit);


        registerForm.addEventListener('keypress', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Prevent the default Enter key behavior
                handleSubmit();
            }
        });


    </script>
@endsection

