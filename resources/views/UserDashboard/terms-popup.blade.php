@extends('FrontEnd.layouts.mainapp')



@section('title', 'Wine Country Weekends - Guest Registry')



@section('content')

    <style>

        .error {

            color: red;

            font-size: 13px;

        }

    </style>

    <div class="container main-container">

        <div class="row flex-lg-nowrap flex-wrap g-4">

            @include('UserDashboard.includes.leftNav')

            <div class="col right-side">

                <div class="terms-container px-sm-4 p-2">

                    <form action="" id="terms-form" method="POST">

                        @csrf

                        <div class="form-body">

                            <div class="form-heading-box rounded mb-4 px-3 py-2 text-white" style="background-color: #bba253;">

                                Please read and agree to the stated terms then correctly answer the following skill testing

                                question to qualify for contests and periodic giveaways.

                            </div>



                            <p>

                                The wine country rewards programs and affiliate promotions are administered by the Wine

                                Country

                                Weekends marketing team (hereafter: The WCW Team). Participants must be 19 years of age or

                                older

                                and must not reside in the province of Quebec.

                            </p>



                            <p>

                                Initiating a registered user (i.e. member) account will enable participants to access a

                                variety

                                of online utilities, programs and help facilitate transactions directly with vendor

                                partners.

                                Personally identifying information collected will be used to enhance the online and

                                in-person

                                experience of registered users.

                            </p>



                            <p>

                                Registered participants agree to the use of their likeness (i.e. still or video images) in

                                various advertising and promotional content. Participants may also receive periodic email

                                notifications

                                and are free to opt out of receiving said notifications at any time.

                            </p>

                            <p>

                                The WCW Team reserves the right to cancel or suspend any program or contest, modify the

                                rules,

                                particularly if there is some factor that interferes with the proper administration of the

                                contest.

                                Additionally, The WCW Team may substitute all or part of a prize, including for cash equal

                                to

                                the stated value of the prize in the rules, if all or part of the prize becomes unavailable

                                for any

                                reason.

                            </p>



                            <br>



                            <div class="form-check mb-4">

                                <label class="form-check-label fw-normal" for="agreeterms">

                                    <input type="checkbox" class="form-check-input required" id="agreeterms" name="terms"

                                        required>

                                    I Agree to the stated <a href="{{route('terms')}}" target="blank">Terms of Participation</a>

                                </label>

                            </div>



                            <div class="row enablecaptha mt-4">

                                <div class="col-sm-3">

                                    <label class="pe-2 pb-2" style="font-weight: 600;">Skill Testing: </label>

                                    <i id="refresh-captcha" class="fas fa-sync-alt"

                                        style="cursor: pointer; font-size: 20px;"></i><br>
                                    <img id="captcha-image" src="{{ captcha_src('default') }}" alt="CAPTCHA">

                                </div>

                                <div class="col-sm-6">

                                    <label for="captcha"></label>

                                    <input type="text" name="captcha" id="captcha" class="form-control required"

                                        placeholder="Enter Answer" required>

                                </div>

                            </div>

                        </div>



                        <div class="form-footer mt-4">

                            <button type="submit" class="btn wine-btn user-register">Update</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    @include('UserDashboard.includes.logout_modal')

@endsection

@section('js')

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <script>

        $(document).ready(function() {

            $('#customerterms').modal('show');

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

        $('#terms-form').validate({

            rules: {

                captcha: {

                    required: true,

                    remote: {

                        url: "{{ route('validate-captcha') }}",

                        type: "POST",

                        headers: {

                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                        },

                        data: {

                            captcha: function() {

                                return $('#captcha').val();

                            }

                        }

                    }

                },

                terms: {

                    required: true

                }

            },

            messages: {

                captcha: {

                    required: "Please enter skill testing Question.",

                    remote: "Incorrect calculation."

                },

                terms: {

                    required: "Please select Terms and participant."

                }

            },

            errorElement: "div",

            errorClass: "error",

            errorPlacement: function(error, element) {

                if (element.attr("name") == "terms") {

                    error.appendTo(element.parent()); // Place error next to the checkbox

                } else {

                    error.insertAfter(element); // Default placement

                }

            },

            submitHandler: function(form) {

                const $submitButton = $(form).find('button[type="submit"]'); // Select the submit button

                $submitButton.prop('disabled', true); // Disable the button



                const formData = $(form).serialize();

                $.ajax({

                    url: "{{ route('customer.terms.popup.post') }}",

                    type: "POST",

                    data: formData,

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    },

                    success: function(response) {

                        Swal.fire({

                            title: 'Success!',

                            text: response.message,

                            icon: 'success',

                            timer: 2000,

                            showConfirmButton: false

                        });

                        window.location.href = "{{ route('user.referrals') }}";

                    },

                    error: function(xhr) {

                        Swal.fire({

                            title: 'Error',

                            text: xhr.responseJSON?.message || 'Form submission failed.',

                            icon: 'error',

                            showConfirmButton: true

                        });

                        $submitButton.prop('disabled',

                        false); // Re-enable the button if an error occurs

                    },

                    complete: function() {

                        // Ensure the button is re-enabled in case of other unexpected scenarios

                        $submitButton.prop('disabled', false);

                    }

                });

            }

        });

    </script>

@endsection

