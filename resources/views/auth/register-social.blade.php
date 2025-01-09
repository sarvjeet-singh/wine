@extends('FrontEnd.layouts.mainapp')

@section('content')
    <style>
        .over-flow-register {
            overflow: hidden;
        }

        .weak-password {
            background-color: #978b67 !important;
        }

        .error {
            color: red;
            font-size: 14px;
            font-weight: 400;
        }

        body.modal-open {
            padding-right: 0 !important;
        }

        .password-error {
            border: 1px solid red !important;
        }
    </style>
    <div class="container-fluid over-flow-register">
        <div class="row justify-content-center">
            <div class="col-sm-6 padding-left-0 register-left-section">
                <img src="{{ asset('images/FrontEnd/login_register.jpg') }}">
            </div>
            <div class="col-sm-6 login-register-right-section">
                <div class="login-register-mobile-version">
                    @if (request()->query('slug') && !empty($vendor->vendor_name))
                        <div class="ty-notify">
                            <p class="mb-2"><i class="fa-solid fa-circle-check"></i> You are registering courtesy of
                                <span class="fw-bold theme-color">{{ $vendor->vendor_name ?? '' }}.</span>
                            </p>
                        </div>
                    @endif
                    <h2>{{ __('Join Our Guest Rewards Program') }}</h2>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    <form method="POST" action="{{ route('register.social') }}" id="guestregisterform">
                        @csrf
                        @if (request()->query('slug'))
                            <input type="hidden" name="refer_by" value="{{ request()->query('slug') }}">
                        @endif
                        <div class="row mb-md-3 mb-2 mt-4">
                            <div class="col-md-6 mb-md-0 mb-2" style="position:relative">
                                <label for="firstname" class="col-form-label">{{ __('Given Name(s)') }}</label>
                                <input id="firstname" type="text" class="form-control"
                                    value="{{ $user->firstname ?? '' }}" disabled>
                            </div>
                            <div class="col-md-6" style="position:relative">
                                <label for="lastname" class="col-form-label">{{ __('Last/Surname') }}</label>
                                <input id="lastname" type="text" class="form-control" name="lastname"
                                    value="{{ $user->lastname ?? '' }}" disabled>
                            </div>
                        </div>

                        <div class="row mb-md-3 mb-2 mt-md-4">
                            <label for="email" class="col-form-label">{{ __('eMail Address') }}</label>
                            <div class="col-md-12" style="position:relative">
                                <i class="fa-solid fa-envelope login-custom-icon"></i>
                                <input id="email" type="email" class="form-control left-with-icon required"
                                    name="email" value="{{ $user->email ?? '' }}" disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 mb-md-0 mb-2">
                                <label for="password" class="col-form-label">{{ __('Create Password') }}</label>
                                <div style="position:relative">
                                    <i class="fa-solid fa-lock login-custom-icon"></i>
                                    <input id="password" type="password"
                                        class="form-control left-with-icon gpassword @error('password') is-invalid @enderror"
                                        name="password" autocomplete="new-password">
                                    <i class="fa-solid fa-eye togglePassword password-custom-icon"></i>
                                    {{-- <span id="password-strength"
                                        style="position:relative; top:100%; left:0; font-size:0.8em; color:red;"></span> --}}
                                </div>
                                {{-- @error('password') --}}
                                <span class="theme-color mt-1" role="alert"
                                    style="display: inline-block;line-height: normal;font-size: 14px;">
                                    Password must contain uppercase, lowercase, number, and special character
                                </span>
                                {{-- @enderror --}}
                            </div>
                            <div class="col-md-6" style="position:relative">
                                <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label>
                                <div style="position:relative">
                                    <i class="fa-solid fa-lock register-custom-icon"></i>
                                    <input id="password-confirm" type="password" class="form-control left-with-icon"
                                        name="password_confirmation" autocomplete="new-password">
                                    <i class="fa-solid fa-eye togglePassword password-custom-icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3 mb-4">
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="terms" id="terms">
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a target="_blank" href="{{ URL::to('/terms') }}">terms and
                                            conditions</a>.
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="wine-btn register-continue">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="current-benifits mb-5">
                        <h3 class="text-center">Benefits Include:</h3>

                        <ul>

                            <li>Receive <b>$25</b> in bonus <b>Bottle Bucks</b> rewards just for registering.</li>
                            <li>Earn additional cash back reward dollars for submitting verifiable testimonials & reviews.
                            </li>
                            <li>Save third-party booking fees and win periodic getaways to wine country.</li>
                            <li>Get access to exclusive guest lists, special events and functions.</li>
                            <li>Book a minimum of six (6) nights’ accommodations and get two (2) complimentary excursion
                                activities. Only with participating vendors. Subject to availability.</li>
                        </ul>
                        <div class="text-center mt-2"><b>Some benefits may not be valid in conjunction with other offers.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"
        integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            // Add custom password validation method
            $.validator.addMethod("strongPassword", function(value) {
                return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);
            }, "Password must contain uppercase, lowercase, number, and special character");

            // Initialize jQuery Validation for the registration form
            $('#guestregisterform').validate({
                rules: {
                    terms: {
                        required: true // Always required
                    },
                    password: {
                        minlength: {
                            param: 8,
                            depends: function(element) {
                                return $(element).val() !== ""; // Validate only if not empty
                            }
                        },
                        strongPassword: {
                            depends: function(element) {
                                return $(element).val() !== ""; // Validate only if not empty
                            }
                        }
                    },
                    password_confirmation: {
                        equalTo: {
                            param: "#password",
                            depends: function(element) {
                                return $("#password").val() !==
                                ""; // Validate only if password field is not empty
                            }
                        }
                    }
                },
                messages: {
                    terms: "Please accept the terms and conditions.",
                    password: {
                        minlength: "Password must be at least 8 characters long",
                        strongPassword: "Password must contain uppercase, lowercase, number, and special character"
                    },
                    password_confirmation: {
                        equalTo: "Passwords do not match"
                    }
                },
                errorElement: "div",
                errorPlacement: function(error, element) {
                    if (element.attr("name") === "password") {
                        // Highlight the password field
                        $("#password").addClass("password-error");
                    } else if (element.attr("name") === "terms") {
                        // Position error message below terms checkbox
                        error.appendTo(element.parent());
                    } else {
                        error.insertAfter(element); // Default error message positioning
                    }
                },
                // Remove error on keyup
                onkeyup: function(element) {
                    $(element).valid();
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });

            // Show/Hide Password Toggle
            // Toggle password visibility and icon for both password fields
            $(document).ready(function() {
                $('.togglePassword').click(function() {
                    const inputField = $(this).siblings('input'); // Find the related input field
                    const isPasswordVisible = inputField.attr('type') === 'text';

                    // Toggle the input field type between text and password
                    inputField.attr('type', isPasswordVisible ? 'password' : 'text');
                });
            });
        });
    </script>
@endsection
