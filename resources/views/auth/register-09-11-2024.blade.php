@extends('FrontEnd.layouts.mainapp')

@section('content')
<style>
    .over-flow-register{
        overflow:hidden;
    }
    .weak-password {
    background-color: #978b67 !important;
    }

    </style>
    <div class="container-fluid over-flow-register">
        <div class="row justify-content-center">
            <div class="col-sm-6 padding-left-0 register-left-section">
                <img src="{{asset('images/FrontEnd/login_register.jpg')}}">
            </div>
            <div class="col-sm-6 login-register-right-section">
                <div class="login-register-mobile-version">
                    <h2>{{ __('Join Our Guest Rewards Program') }}</h2>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                    <form method="POST" action="{{ route('registertion') }}" id="guestregisterform">
                        @csrf
                        @if(request()->query('slug'))
                            <input type="hidden" name="refer_by" value="{{ request()->query('slug') }}">
                        @endif
                        <div class="row mb-3 mt-4">
                            <div class="col-md-6" style="position:relative">
                                <label for="firstname" class="col-form-label">{{ __('Given Name(s)') }}</label>
                                <input id="firstname" type="text" class="form-control required @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" autocomplete="firstname" autofocus placeholder="Enter your Given Name(s)">

                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6" style="position:relative">
                                <label for="lastname" class="col-form-label">{{ __('Last/Surname') }}</label>
                                <input id="lastname" type="lastname" class="form-control required @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" autocomplete="lastname" autofocus placeholder="Enter your Last/Surname">

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 mt-4">
                            <label for="email" class="col-form-label">{{ __('eMail Address') }}</label>
                            <div class="col-md-12" style="position:relative">
                                <i class="fa-solid fa-envelope login-custom-icon"></i>
                                <input id="email" type="email" class="form-control left-with-icon required @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus placeholder="Enter your eMail Address">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="col-form-label">{{ __('Create Password') }}</label>
                                <div style="position:relative">
                                    <i class="fa-solid fa-lock login-custom-icon"></i>
                                    <input id="password" type="password" class="form-control left-with-icon gpassword @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter your password" oninput="validatePasswordStrength()">
                                    <i class="fa-solid fa-eye togglePassword3 password-custom-icon" onclick="togglePasswordVisibility('password')"></i>
                                    <span id="password-strength" style="position:relative; top:100%; left:0; font-size:0.8em; color:red;"></span>
                                </div>  
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6" style="position:relative">
                                <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label>
                                <div style="position:relative">
                                    <i class="fa-solid fa-lock register-custom-icon"></i>
                                    <input id="password-confirm" type="password" class="form-control left-with-icon required" name="password_confirmation" autocomplete="new-password" placeholder="Enter your confirm password" >
                                    <i class="fa-solid fa-eye togglePassword3 password-custom-icon" onclick="togglePasswordVisibility('password-confirm')"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="button" class="wine-btn register-continue">
                                    {{ __('Continue') }}
                                </button>
                            </div>
                        </div>

                        <div class="row mt-5 mb-5">
                            <div class="col-md-12 text-center">
                                OR
                            </div>
                        </div>
                        <div class="row mt-5 mb-5">
                            <div class="col-md-12 text-center">
                                Already Have an account? <a href="{{route('login')}}">Sign In</a>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="current-benifits mb-5">
                        <h3 class="text-center">Current Benefits</h3>

                        <ul>

                  <li>Get $25 in bonus Bottle Bucks rewards just for joining our Guest Rewards program.</li>

                  <li>Save third-party booking fees, win prizes and earn more rewards.</li>

                  <li>Get access to exclusive guest lists, special events and functions.</li>

                  <li>Book a minimum of six (6) nights’ accommodations and get two (2) complimentary excursion activities.  Only with participating vendors.  Subject to availability.</li>

               </ul>
                       <!-- <div class="text-left mt-4"><b>Some benefits may not be valid in conjunction with other offers.</div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="registerterms" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-body">
                <div class="modal-heading-box mb-4">
                    Please read and agree to the stated terms then correctly answer the following skill testing question to qualify for contests and periodic giveaways.
                </div>


                <p>
                The wine country rewards programs and affiliate promotions are administered by the Wine Country Weekends marketing team (hereafter: The WCW Team). Participants must be 19 years of age or older and must not reside inthe province of Quebec.
                </p>

                <p>
                Initiating a registered user (i.e. member) account will enable participants to access a variety of online utilities, programs and help facilitate transactions directly with vendor partners. Personally identifying information collected will be used to enhance the online and in-person experience of registered users.
                </p>

                <p>
                Registered participants agree to the use of their likeness (i.e. still or video images) in various advertising and promotional content. Participants may also receive periodic email notifications and are free to opt out of receiving said notifications at any time.
                </p>
                <p>
                The WCW Team reserves the right to cancel or suspend any program or contest, modify the rules, particularly if there is some factor that interferes with the proper administration of the contest. Additionally, The WCW Team may substitute all or part of a prize, including for cash equal to the stated value of the prize in the rules, if all or part of the prize becomes unavailable for any reason.
                </p>
                <br>
                <label class="form-check-label" for="">
                    <input type="checkbox" class="form-check-input required" id="agreeterms" name="terms"> <b>I Agree to the stated Terms of Participation</b>
                </label>
                <br>
                <div class="row enablecaptha mt-4">
                    <div class="col-sm-3">
                        <label style="font-weight: 600;">Skill Testing: </label><br>
                        <img src="{{ captcha_src('default') }}" alt="CAPTCHA">
                    </div>
                    <div class="col-sm-6">
                    <label for="captcha"></label>
                        <input type="text" name="captcha" id="captcha" class="form-control required" data-error-id="#CAPTCHAError" placeholder="Enter skill testing code" form="guestregisterform" required>
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
    </div>
@endsection

@section('js')

<script>
    // Function for password field eye icon
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

        //Function for strong password
        function togglePasswordVisibility(id) 
        {
            const passwordField = document.getElementById(id);
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
        }

        function validatePasswordStrength() {
            const password = document.getElementById('password').value;
            const registerContinueButtons = document.getElementsByClassName('register-continue');
            const strengthText = document.getElementById('password-strength');
            const strongPasswordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            
            if (strongPasswordRegex.test(password)) {
                strengthText.style.color = 'green';
                strengthText.textContent = 'Strong password';
                // Enable all elements with class 'register-continue' and apply strong password background color
                Array.from(registerContinueButtons).forEach(button => {
                    button.disabled = false;
                    button.classList.remove('weak-password');
                    button.classList.add('strong-password');
                });
            } else {
                strengthText.style.color = 'red';
                strengthText.textContent = 'Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character';
                // Disable all elements with class 'register-continue' and apply weak password background color
                Array.from(registerContinueButtons).forEach(button => {
                    button.disabled = true;
                    button.classList.remove('strong-password');
                    button.classList.add('weak-password');
                });
            }
        }

</script>


