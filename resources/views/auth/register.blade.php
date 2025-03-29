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
    <section class="register-top-bar tab-content-sec">
        <div class="container">
            <div class="inner-content">
                <ul class="list-unstyled d-flex justify-content-between align-items-center mb-0">
                    <li><a href="/accommodations" class="text-decoration-none"><i class="fa-solid fa-building"></i><span>Accommodations</span></a></li>
                    <li><a href="/excursion" class="text-decoration-none"><i class="fa-solid fa-people-group"></i><span>Excursions</span></a></li>
                    <li><a href="/wineries" class="text-decoration-none"><i class="fa-solid fa-wine-glass"></i><span>Wineries</span></a></li>
                    <li><a href="/events" class="text-decoration-none"><i class="fa-solid fa-calendar-days"></i><span>Events</span></a></li>
                </ul>
            </div>
        </div>
    </section>
    <div class="container-fluid over-flow-register">
        <div class="row justify-content-center">
            <div class="col-sm-6 padding-left-0 register-left-section">
                <img src="{{ asset('images/FrontEnd/login_register.jpg') }}">
            </div>
            <div class="col-sm-6 login-register-right-section">
                <div class="login-register-mobile-version">
                    @if (request()->query('sc') && !empty($vendor->vendor_name))
                        <div class="ty-notify">
                            <p class="mb-2"><i class="fa-solid fa-circle-check"></i> You are registering courtesy of
                                <span class="fw-bold theme-color">{{ $vendor->vendor_name ?? '' }}.</span>
                            </p>
                        </div>
                    @endif
                    <h2>{{ __('Join Our Guest Rewards Program') }}</h2>
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <form method="POST" action="{{ route('registertion') }}" id="guestregisterform">
                        @csrf
                        @if (request()->query('sc'))
                            <input type="hidden" name="refer_by" value="{{ request()->query('sc') }}">
                        @endif
                        <div class="row mb-3 mt-4">
                            <div class="col-md-6" style="position:relative">
                                <label for="firstname" class="col-form-label">{{ __('Given Name(s)') }}<span
                                        style="color:red;padding-left: 1px;">*</span></label>
                                <input id="firstname" type="text"
                                    class="form-control required @error('firstname') is-invalid @enderror" name="firstname"
                                    value="{{ old('firstname') }}" autocomplete="firstname" autofocus placeholder="">

                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6" style="position:relative">
                                <label for="lastname" class="col-form-label">{{ __('Last/Surname') }}<span
                                        style="color:red;padding-left: 1px;">*</span></label>
                                <input id="lastname" type="text"
                                    class="form-control required @error('lastname') is-invalid @enderror" name="lastname"
                                    value="{{ old('lastname') }}" autocomplete="lastname" autofocus placeholder="">

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 mt-4">
                            <div class="col-md-6">
                                <label for="email" class="col-form-label">{{ __('eMail Address') }}<span
                                        style="color:red;padding-left: 1px;">*</span></label>
                                <div style="position:relative">
                                    <i class="fa-solid fa-envelope login-custom-icon"></i>
                                    <input id="email" type="email"
                                        class="form-control left-with-icon required @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" autocomplete="email" autofocus
                                        placeholder="">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="col-form-label">{{ __('Phone Number') }}</label>
                                <div style="position:relative">
                                    <i class="fa-solid fa-phone login-custom-icon"></i>
                                    <input id="phone" type="tel"
                                        class="form-control phone-number left-with-icon @error('phone') is-invalid @enderror"
                                        name="phone" value="{{ old('phone') }}" autocomplete="phone" autofocus
                                        placeholder="">

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="col-form-label">{{ __('Create Password') }}<span
                                        style="color:red;padding-left: 1px;">*</span></label>
                                <div style="position:relative">
                                    <i class="fa-solid fa-lock login-custom-icon"></i>
                                    <input id="password" type="password"
                                        class="form-control left-with-icon gpassword @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="new-password" placeholder="">
                                    <i class="fa-solid fa-eye togglePassword password-custom-icon"></i>
                                    {{-- <span id="password-strength"
                                        style="position:relative; top:100%; left:0; font-size:0.8em; color:red;"></span> --}}
                                </div>
                                {{-- @error('password') --}}
                                {{-- <span class="theme-color mt-1" role="alert"
                                    style="display: inline-block;line-height: normal;font-size: 13px;">
                                    <strong>Password must contain uppercase, lowercase, number, and special
                                        character</strong>
                                </span> --}}
                                {{-- @enderror --}}
                            </div>
                            <div class="col-md-6" style="position:relative">
                                <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}<span
                                        style="color:red;padding-left: 1px;">*</span></label>
                                <div style="position:relative">
                                    <i class="fa-solid fa-lock register-custom-icon"></i>
                                    <input id="password-confirm" type="password"
                                        class="form-control left-with-icon required" name="password_confirmation"
                                        autocomplete="new-password" placeholder="">
                                    <i class="fa-solid fa-eye togglePassword password-custom-icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <input type="hidden" name="g-recaptcha-response" id="recaptcha-token">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="wine-btn">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>

                        <div class="row my-2">
                            <div class="col-md-12 text-center">
                                OR
                            </div>
                        </div>
                        <div class="row mt-2 mb-3">
                            <div class="col-md-12 text-center">
                                <div class="social-login-sec d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{ url('auth/google') }}"><i class="fa-brands fa-google"></i></a>
                                    {{-- <a href="#"><i class="fa-brands fa-facebook"></i></a>
                                    <a href="#"><i class="fa-brands fa-instagram"></i></a> --}}
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row mb-5">
                                            <div class="col-md-12 text-center">
                                                Already Have an account? <a href="{{ route('login') }}" class="fw-bold">Sign In</a>
                                            </div>
                                        </div> -->
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


    <!-- Modal -->
    {{-- <div class="modal fade" id="registerterms" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-heading-box mb-4">
                        Please read and agree to the stated terms then correctly answer the following skill testing question
                        to qualify for contests and periodic giveaways.
                    </div>


                    <p>
                        The wine country rewards programs and affiliate promotions are administered by the Wine Country
                        Weekends marketing team (hereafter: The WCW Team). Participants must be 19 years of age or older and
                        must not reside inthe province of Quebec.
                    </p>

                    <p>
                        Initiating a registered user (i.e. member) account will enable participants to access a variety of
                        online utilities, programs and help facilitate transactions directly with vendor partners.
                        Personally identifying information collected will be used to enhance the online and in-person
                        experience of registered users.
                    </p>

                    <p>
                        Registered participants agree to the use of their likeness (i.e. still or video images) in various
                        advertising and promotional content. Participants may also receive periodic email notifications and
                        are free to opt out of receiving said notifications at any time.
                    </p>
                    <p>
                        The WCW Team reserves the right to cancel or suspend any program or contest, modify the rules,
                        particularly if there is some factor that interferes with the proper administration of the contest.
                        Additionally, The WCW Team may substitute all or part of a prize, including for cash equal to the
                        stated value of the prize in the rules, if all or part of the prize becomes unavailable for any
                        reason.
                    </p>
                    <br>
                    <label class="form-check-label fw-normal" for="agreeterms">
                        <input type="checkbox" class="form-check-input required" id="agreeterms" name="terms"
                            required> I Agree to the stated Terms of Participation
                    </label>
                    <br>
                    <div class="row enablecaptha mt-4">
                        <div class="col-sm-3">
                            <label class="pe-2 pb-2" style="font-weight: 600;">Skill Testing: </label><i
                                id="refresh-captcha" class="fas fa-sync-alt"
                                style="cursor: pointer; font-size: 20px;"></i><br>
                            <img id="captcha-image" src="{{ captcha_src('default') }}" alt="CAPTCHA">
                        </div>
                        <div class="col-sm-6">
                            <label for="captcha"></label>
                            <input type="text" name="captcha" id="captcha" class="form-control required"
                                data-error-id="#CAPTCHAError" placeholder="Enter skill testing code"
                                form="guestregisterform" required>
                            <!-- <div class="alert alert-danger msg" id="CAPTCHAError" style="display:none;">Skill Testing code is required.</div> -->
                            <!-- @error('captcha')
        <div class="alert alert-danger">Skill Testing code is required.</div>
        @enderror -->
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn wine-btn-cancel" data-bs-dismiss="modal">Back</button>
                    <button type="button" class="btn wine-btn user-register">Register</button>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"
        integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('.phone-number').on('input', function() {
                const $input = $(this);
                const cursorPosition = $input.prop('selectionStart');
                const rawValue = $input.val().replace(/\D/g, ''); // Remove all non-digit characters
                let formattedValue = '';

                // Format the phone number
                if (rawValue.length > 3 && rawValue.length <= 6) {
                    formattedValue = rawValue.slice(0, 3) + '-' + rawValue.slice(3);
                } else if (rawValue.length > 6) {
                    formattedValue =
                        rawValue.slice(0, 3) +
                        '-' +
                        rawValue.slice(3, 6) +
                        '-' +
                        rawValue.slice(6, 10);
                } else {
                    formattedValue = rawValue;
                }

                // Update the input value
                $input.val(formattedValue);

                // Restore cursor position
                const adjustedPosition =
                    cursorPosition + (formattedValue.length - rawValue.length);
                $input[0].setSelectionRange(adjustedPosition, adjustedPosition);
            });
            // Add custom password validation method
            $.validator.addMethod("strongPassword", function(value, element) {
                if (value.length > 12) {
                    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d!@#$%^&*()_+={}\[\]:;<>,.?~\\/-]{12,}$/
                        .test(value);
                } else {
                    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+={}\[\]:;<>,.?~\\/-])[A-Za-z\d!@#$%^&*()_+={}\[\]:;<>,.?~\\/-]{8,}$/
                        .test(value);
                }
            }, function(value, element) {
                if (value.length > 12) {
                    return "Password must contain at least one uppercase letter, one lowercase letter, and one number.";
                } else {
                    return "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
                }
            });
            $.validator.addMethod(
                "phoneNumberFormat",
                function(value, element) {
                    const rawValue = value.replace(/\D/g, ''); // Remove all non-digit characters
                    // Check if the number follows the desired format (e.g., ###-###-####)
                    const isValidFormat = /^\d{3}-\d{3}-\d{4}$/.test(value);
                    return this.optional(element) || (rawValue.length === 10 && isValidFormat);
                },
                "Please enter a valid phone number in the format ###-###-####"
            );
            // Initialize jQuery Validation for the registration form
            $('#guestregisterform').validate({
                rules: {
                    firstname: "required",
                    lastname: "required",
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: "{{ route('check.email') }}", // Correct route to check email uniqueness
                            type: "post",
                            data: {
                                _token: "{{ csrf_token() }}", // Send CSRF token for security
                                email: function() {
                                    return $("#email")
                                        .val(); // Send email value to backend for uniqueness check
                                }
                            }
                        }
                    },
                    phone: {
                        // required: true,
                        phoneNumberFormat: true,
                        remote: {
                            url: "{{ route('check.phone') }}", // Correct route to check email uniqueness
                            type: "post",
                            data: {
                                _token: "{{ csrf_token() }}", // Send CSRF token for security
                                phone: function() {
                                    return $("#phone")
                                        .val(); // Send email value to backend for uniqueness check
                                }
                            }
                        }
                    },
                    password: {
                        required: true,
                        minlength: 8,
                        strongPassword: true // Use custom password validation rule
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    firstname: "Please enter your first name",
                    lastname: "Please enter your last name",
                    email: {
                        required: "Please enter an email address",
                        email: "Please enter a valid email address",
                        remote: "Email already exists try another one"
                    },
                    phone: {
                        required: "Please enter your phone number",
                        phoneNumberFormat: "Please enter a valid phone number in the format ###-###-####",
                        remote: "Phone number already exists try another one"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Password must be at least 8 characters long",
                        strongPassword: "Password must contain uppercase, lowercase, number, and special character"
                    },
                    password_confirmation: {
                        required: "Please confirm your password",
                        equalTo: "Passwords do not match"
                    }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                    // if (element.attr("name") === "password") {
                    //     // highlight the password field
                    //     $("#password").addClass("password-error");
                    // } else {
                    //     error.insertAfter(element); // Default error message positioning
                    // }
                },
                // Remove error on keyup
                onkeyup: function(element) {
                    $(element).valid();
                },
                submitHandler: function(form) {
                    // Show the terms modal when the form passes the initial validation
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

            // Trigger validation when clicking the "Register" button in the modal
            // Event listener for the register button click
            // Event listener for the register button click
            $('.user-register').click(function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Clear previous error messages
                $('.error-message').hide();

                if ($('#guestregisterform').valid()) {
                    let isValid = true;

                    // Check if terms are agreed
                    if (!$('#agreeterms').is(':checked')) {
                        if ($('#terms-error').length === 0) {
                            // Append the error message next to the label, not the checkbox
                            $('#agreeterms').closest('label').append(
                                '<div id="terms-error" class="error-message" style="color:red; font-weight:400; margin-left: 10px;">Please accept terms of participant</div>'
                            );
                        }
                        $("#terms-error").show();
                        isValid = false;
                    }

                    // Check if CAPTCHA is filled
                    if ($('#captcha').val().length === 0) {
                        if ($('#captcha-error').length === 0) {
                            $('#captcha').after(
                                '<div id="captcha-error" class="error-message" style="color:red;font-weight:400;">Please complete the CAPTCHA</div>'
                            );
                        }
                        isValid = false;
                    } else {
                        // Show spinner and disable the button
                        toggleButtonSpinner(true);

                        // Check CAPTCHA with AJAX if it's filled
                        var captchaValue = $('#captcha').val();
                        $.ajax({
                            url: '{{ route('validate-captcha') }}', // The endpoint to check CAPTCHA
                            type: 'POST',
                            data: {
                                captcha: captchaValue,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    // CAPTCHA is valid, hide error and proceed with form submission
                                    $('#captcha-error').hide();
                                    if (isValid) {
                                        $('#guestregisterform')[0]
                                            .submit(); // Submit form after successful CAPTCHA validation
                                    }
                                } else {
                                    // Show error message if CAPTCHA is invalid
                                    if ($('#captcha-error').length === 0) {
                                        $('#captcha').after(
                                            '<div id="captcha-error" class="error-message" style="color:red;">Invalid CAPTCHA</div>'
                                        );
                                    } else {
                                        $('#captcha-error').text('Invalid CAPTCHA').show();
                                    }
                                    isValid = false;
                                    toggleButtonSpinner(false);
                                }
                            },
                            error: function() {
                                // Handle AJAX errors
                                alert(
                                    'There was an error while validating the CAPTCHA. Please try again.'
                                );
                                isValid = false;
                                toggleButtonSpinner(false);
                            }
                        });
                    }

                    // Prevent form submission if validation fails
                    if (!isValid) {
                        toggleButtonSpinner(false);
                        return false;
                    }
                }
            });


            // Real-time validation for CAPTCHA (keyup event)
            $('#captcha').on('keyup', function() {
                if ($(this).val().length > 0) {
                    $('#captcha-error').remove(); // Remove error when user types in the field
                }
            });

            // Real-time validation for the Terms checkbox (change event)
            $('#agreeterms').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#terms-error').remove(); // Remove error when checkbox is checked
                }
            });

            // Password strength validation feedback
            $('#password').on('input', function() {
                const password = $(this).val();
                const strengthText = $('#password-strength');
                if (/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(password)) {
                    //strengthText.css('color', 'green').text('Strong password');
                }
            });
            $(document).on('click', '#refresh-captcha', function() {
                // Send AJAX request to the server to generate a new CAPTCHA
                $.get('{{ route('refresh-captcha') }}', function(response) {
                    // Update the CAPTCHA image source with the new image
                    $('#captcha-image').attr('src', response
                        .captcha);

                    // Optionally clear the CAPTCHA input field
                    $('#captcha').val('');

                    // If you want to remove the error message, you can do that as well
                    $('#captcha-error').remove();
                });
            });
        });
        /**
         * Function to toggle spinner and button state.
         * @param {boolean} isLoading - Whether to show spinner and disable the button.
         */
        function toggleButtonSpinner(isLoading) {
            const $button = $('.user-register');
            if (isLoading) {
                $button.html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Registering...'
                );
                $button.prop('disabled', true);
            } else {
                $button.html('Register');
                $button.prop('disabled', false);
            }
        }
    </script>
    <script src="https://www.google.com/recaptcha/api.js?render={{ env('GOOGLE_RECAPTCHA_KEY') }}"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute("{{ env('GOOGLE_RECAPTCHA_KEY') }}", {
                    action: 'contact_form'
                })
                .then(function(token) {
                    document.getElementById('recaptcha-token').value = token;
                });
        });
    </script>
@endsection
