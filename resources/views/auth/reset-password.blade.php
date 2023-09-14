<?php $pageTitle = "Password Reset" ?>
@extends("layouts.app")

@section("main")
    @if(isset($success))
        <div class="alert alert-success">{{$success}}</div>
    @endif

    <div
        class="container-fluid min-vh-100 py-sm-5 py-4 px-4 vw-100 bg-gradient d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center align-items-center">
            <div
                class="col-lg-10 col-md-8 bg-white bg-white p-sm-5 p-4 rounded-5">
                <div class="row justify-content-center">
                    <div class="col-5 mx-auto">
                        <img src="{{asset("images/logos/polandstudylogo.png")}}" alt="Logo" class="img-fluid mx-auto mb-3">
                    </div>
                </div>
                <h2 class="text-center text-dark">Welcome to Password Reset Panel!</h2>
                <p class="text-center text-dark">Please enter your details</p>
                <form action="/reset-password" method="POST" id="passwordResetForm">
                    @csrf
                    <div class="row  my-3">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="email" class="text-dark fw-medium">Email</label>
                                <input type="email" value="{{old("email")}}" name="email" id="email"
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
                                <label for="password" class="text-dark fw-medium">Password</label>
                                <input type="password" value="{{old("password")}}" name="password" id="password"
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
                                <label for="password_confirmation" class="text-dark fw-medium">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            </div>

                            <input type="hidden" name="token" value="{{ $token  }}"/>

                            <div id="repeatMessageWrap">
                                @error('repeat_password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" id="passwordResetSubmit" name="submitBtn" class=" w-100 btn btn-primary mt-3"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

        function hideSpinner() {
            $("#preloader").fadeOut();
        }

        function showSpinner() {
            $("#preloader").fadeIn();
        }

        // Function to validate an email address using a regular expression
        // function validateEmail() {
        //     // Get the form elements
        //     const emailInput = document.getElementById('email');
        //     // Your regex pattern for email validation
        //     const emailPattern = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
        //     const email = emailInput.value;
        //     if (!emailPattern.test(email)) {
        //         document.getElementById("emailMessageWrap").innerHTML = `<span class="text-danger">Invalid email address. Please enter a valid email address.</span>`;
        //         return 0;
        //     } else {
        //         document.getElementById("emailMessageWrap").innerHTML = '';
        //         return 1;
        //     }
        // }

        function validatePassword() {
            const passwordInput = document.getElementById('password');

            // Get the values entered by the user
            const password = passwordInput.value;
            const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
            if (password === '') {
                document.getElementById("passwordMessageWrap").innerHTML = `<span class="text-danger">Password is empty!</span>`;
                return 0;
            } else {
                document.getElementById("passwordMessageWrap").innerHTML = '';
                return 1;
            }
        }

        // Function to handle form submission
        {{--function handleSubmit(event) {--}}
        {{--    var err = 0;--}}
        {{--    // Validate the email input--}}
        {{--    // if (!validateEmail()) {--}}
        {{--    //     err = 1;--}}
        {{--    // }--}}
        {{--    if (!validatePassword()) {--}}
        {{--        err = 1;--}}
        {{--    }--}}
        {{--    if (!err) {--}}
        {{--        showSpinner()--}}
        {{--        // event.preventDefault();--}}
        {{--        --}}{{--grecaptcha.ready(function () {--}}
        {{--        --}}{{--    grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {action: 'submit'}).then(function (token) {--}}
        {{--        --}}{{--        document.getElementById('g-recaptcha-response').value = token;--}}
        {{--        --}}{{--        document.getElementById("passwordResetForm").submit();--}}
        {{--        --}}{{--    });--}}
        {{--        --}}{{--});--}}
        {{--    }--}}
        {{--}--}}


        // const passwordResetForm = document.getElementById('passwordResetForm');
        // // document.getElementById('email').addEventListener('change', validateEmail);
        // // document.getElementById('passwordResetSubmit').addEventListener('click', handleSubmit);
        //
        // passwordResetForm.addEventListener('keypress', function (event) {
        //     if (event.key === 'Enter') {
        //         event.preventDefault(); // Prevent the default Enter key behavior
        //         handleSubmit();
        //     }
        // });
    </script>
@endsection
