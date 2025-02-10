@extends('FrontEnd.layouts.mainapp')

@section('content')
    <style>
        nav.navbar {
            border-bottom: 2px solid #bba253;
        }

        .wine-btn,
        .wine-btn:hover {
            background-color: #c0a144;
            color: #fff;
            border-radius: 50px;
            text-decoration: none;
            padding: 10px 80px;
            position: relative;
            overflow: hidden;
            z-index: 9;
            border: none;
        }

        /* Use below css only */
        .otp-sec {
            padding: 100px 30px;
            min-height: 70vh;
        }

        .otp-sec input.form-control {
            border: none;
            border-bottom: 1px solid;
            border-radius: 0;
        }

        .otp-sec .card {
            border: none;
        }

        .otp-sec .otp-main-img img {
            width: 36%;
        }

        @media screen and (max-width: 600px) {
            .otp-sec {
                padding: 50px 0;
            }
        }
    </style>
    <!-- OTP Section Start -->
    <section class="otp-sec">
        <div class="container d-flex justify-content-center align-items-center">
            <div class="card text-center p-4" style="max-width: 400px; width: 100%;">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <h3 class="fs-4 fw-bold mt-4 mb-2">OTP Verification</h3>
                <p class="text-muted">Enter the 6-digit code sent to your phone</p>
                <form action="{{ route('verify-phone-otp-post') }}" method="post">
                    @csrf
                    <div class="row gx-2 justify-content-center">
                        <!-- OTP Input Fields -->
                        <div class="col-2">
                            <input type="text" class="form-control text-center otp-input" maxlength="1" required>
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control text-center otp-input" maxlength="1" required>
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control text-center otp-input" maxlength="1" required>
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control text-center otp-input" maxlength="1" required>
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control text-center otp-input" maxlength="1" required>
                        </div>
                        <div class="col-2">
                            <input type="text" class="form-control text-center otp-input" maxlength="1" required>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <input type="hidden" name="otp" id="hiddenOtp" />
                        <button type="submit" id="verifyButton" disabled class="btn wine-btn w-100 ">Verify</button>
                    </div>

                    <div class="mt-3 text-center">
                        <p class="mb-0 text-muted">Didn't receive the code?</p>
                        <a href="{{ route('resend-otp') }}" class="theme-color text-decoration-none">Resend OTP</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- OTP Section End -->
@endsection
@section('js')
    <script>
        function togglePasswordVisibility(id) {
            var passwordField = document.getElementById(id);
            var eyeIcon = passwordField.nextElementSibling;
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input');

            otpInputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    const currentInput = e.target;
                    const nextInput = otpInputs[index + 1];
                    const prevInput = otpInputs[index - 1];

                    // Move to the next input if the current input has a value
                    if (currentInput.value.length === 1 && nextInput) {
                        nextInput.focus();
                    }
                });

                input.addEventListener('keydown', (e) => {
                    const currentInput = e.target;
                    const prevInput = otpInputs[index - 1];
                    const nextInput = otpInputs[index + 1];

                    if (e.key === 'Backspace') {
                        // Clear the current input and move to the previous input
                        if (currentInput.value === '' && prevInput) {
                            prevInput.focus();
                            prevInput.value = ''; // Clear the previous input
                        }
                    } else if (e.key === 'ArrowRight' && nextInput) {
                        // Move to the next input on ArrowRight
                        nextInput.focus();
                    } else if (e.key === 'ArrowLeft' && prevInput) {
                        // Move to the previous input on ArrowLeft
                        prevInput.focus();
                    }
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input');
            const hiddenOtp = document.getElementById('hiddenOtp');
            const verifyButton = document.getElementById('verifyButton');

            function updateOtpAndButtonState() {
                // Get values of all OTP input fields
                let otpValue = '';
                otpInputs.forEach((input) => {
                    otpValue += input.value;
                });
                // Update the hidden OTP field
                hiddenOtp.value = otpValue;

                // Enable or disable the verify button
                if (otpValue.length === otpInputs.length) {
                    verifyButton.disabled = false; // Enable button
                } else {
                    verifyButton.disabled = true; // Disable button
                }
            }

            otpInputs.forEach((input) => {
                input.addEventListener('input', (e) => {
                    const currentInput = e.target;
                    const nextInput = currentInput.nextElementSibling;

                    // Allow only numeric input
                    currentInput.value = currentInput.value.replace(/[^0-9]/g, '');

                    // Move to the next input if the current input has a value
                    if (currentInput.value.length === 1 && nextInput && nextInput.classList
                        .contains('otp-input')) {
                        nextInput.focus();
                    }

                    // Update the hidden OTP field and button state
                    updateOtpAndButtonState();
                });

                input.addEventListener('keydown', (e) => {
                    const currentInput = e.target;
                    const prevInput = currentInput.previousElementSibling;

                    if (e.key === 'Backspace') {
                        // Clear the current input and move to the previous input
                        if (currentInput.value === '' && prevInput && prevInput.classList.contains(
                                'otp-input')) {
                            prevInput.focus();
                        }
                    }
                });

                input.addEventListener('keypress', (e) => {
                    // Allow only numeric keys
                    const key = e.key;
                    if (!/^\d$/.test(key)) {
                        e.preventDefault();
                    }
                });

                input.addEventListener('keyup', updateOtpAndButtonState);
            });
        });
    </script>
@endsection
