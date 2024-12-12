@extends('FrontEnd.layouts.mainapp')



@section('content')

    <section class="forgot-pwd-sec border-top">

        <div class="container">

            <div class="inner-sec text-center">

                <img src="{{ asset('images/icons/reset-pwd.png') }}" class="w-25">

                <h3 class="fs-4 fw-bold mt-4">Create Your Password</h3>

                <p class="mb-4">Your new password should different from old password</p>

                <form method="POST" action="{{ route('customer.password.update') }}" id="passwordResetForm">

                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">



                    <div class="mb-2">

                        <input id="email" type="email" placeholder="Enter your eMail address" class="form-control @error('email') is-invalid @enderror"

                            name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                        @error('email')

                            <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror

                    </div>



                    <div class="mb-2 position-relative">

                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"

                            name="password" required autocomplete="new-password" placeholder="Password">
                            <i class="fa-solid fa-eye togglePassword3 password-custom-icon"
                                    onclick="togglePasswordVisibility('password')"></i>

                        <small id="passwordHelp" class="form-text text-muted">

                            {{-- Password must include uppercase, lowercase, a number, and a special character. --}}

                        </small>

                        @error('password')

                            <span class="invalid-feedback" role="alert">

                                <strong>{{ $message }}</strong>

                            </span>

                        @enderror

                    </div>



                    <div class="mb-2 position-relative">

                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"

                            required autocomplete="new-password" placeholder="Confirm Password">
                            <i class="fa-solid fa-eye togglePassword3 password-custom-icon"
                                    onclick="togglePasswordVisibility('password')"></i>

                    </div>



                    <div>

                        <button type="submit" class="btn theme-btn w-100">

                            {{ __('Reset Password') }}

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>



    <script>

        $(document).ready(function() {

            // Add custom method for strong password validation

            $.validator.addMethod("strongPassword", function(value, element) {

                return this.optional(element) ||

                    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);

            }, "Password must include uppercase, lowercase, a number, and a special character.");



            // Initialize form validation

            $("#passwordResetForm").validate({

                rules: {

                    email: {

                        required: true,

                        email: true

                    },

                    password: {

                        required: true,

                        strongPassword: true

                    },

                    password_confirmation: {

                        required: true,

                        equalTo: "#password"

                    }

                },

                messages: {

                    email: {

                        required: "Please enter your email address.",

                        email: "Please enter a valid email address."

                    },

                    password: {

                        required: "Please provide a password.",

                    },

                    password_confirmation: {

                        required: "Please confirm your password.",

                        equalTo: "Passwords do not match."

                    }

                },

                errorElement: "span",

                errorPlacement: function(error, element) {

                    error.addClass("invalid-feedback");

                    element.closest("div").append(error);

                },

                highlight: function(element) {

                    $(element).addClass("is-invalid");

                },

                unhighlight: function(element) {

                    $(element).removeClass("is-invalid").addClass("is-valid");

                }

            });

        });

    </script>

    <script>
        function togglePasswordVisibility(id) {
            // Identify the password field dynamically using the event target
            var clickedIcon = event.target; // The clicked <i> element
            var passwordField = clickedIcon.previousElementSibling; // Target the preceding <input> element

            // Toggle the input type and icon classes
            if (passwordField.type === "password") {
                passwordField.type = "text";
                clickedIcon.classList.remove("fa-eye");
                clickedIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                clickedIcon.classList.remove("fa-eye-slash");
                clickedIcon.classList.add("fa-eye");
            }
        }
    </script>

@endsection

