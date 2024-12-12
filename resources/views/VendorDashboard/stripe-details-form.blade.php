@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')
    <div class="col right-side">
        <div class="row mt-5">
            <div class="col-sm-12">
                <div class="information-box payment-integration-sec">
                    <div class="information-box-head d-flex align-items-center justify-content-between">
                        <div class="box-head-heading">
                            <span class="box-head-label theme-color">Payment Integration</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-2">
                            <div class="">
                                <a href="#" class="" data-bs-toggle="modal" data-bs-target="#videoSetupModal">
                                    <i class="fa-solid fa-file-video"></i>
                                </a>
                            </div>
                            <div class="">
                                <a href="#" class="" data-bs-toggle="modal" data-bs-target="#GuideModal">
                                    <i class="fa-solid fa-file-arrow-down"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="information-box-body pb-5">
                        <form id="paymentIntegrationForm" method="POST"
                            action="{{ route('stripe.details.update', ['vendorid' => $vendor->id]) }}">
                            <div class="row mt-3">
                                <div class="col-12">
                                    <label class="form-label" for="secret_id">Stripe Secret ID</label>
                                    <div>
                                        <input type="text" class="form-control" id="stripe_publishable_key"
                                            name="stripe_publishable_key" value="{{ old('stripe_publishable_key', $stripeDetail->stripe_publishable_key ?? '') }}" placeholder="Enter Secret ID">
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label class="form-label" for="secret_key">Stripe Secret Key</label>
                                    <div>
                                        <input type="text" class="form-control" id="stripe_secret_key"
                                            name="stripe_secret_key" value="{{ old('stripe_secret_key', $stripeDetail->stripe_secret_key ?? '') }}" placeholder="Secret Key">
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <label class="form-label" for="webhook_url">Webhook Secret</label>
                                    <div>
                                        <input type="text" class="form-control" id="webhook_secret_key"
                                            name="webhook_secret_key" value="{{ old('webhook_secret_key', $stripeDetail->webhook_secret_key ?? '') }}" placeholder="Webhook Secret">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-12 text-center">
                                    {{-- <button type="submit" class="btn wine-btn px-5">Verify Integration</button> --}}
                                    <button type="submit" class="btn wine-btn px-5">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Setup Video Modal -->
    <div class="modal fade" id="videoSetupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Watch Setup Video</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="setup-vdo">
                        <video controls>
                            <source src="{{ asset('images/wine-dummy-vdo.mp4') }}" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Download Guide Modal -->
    <div class="modal fade" id="GuideModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Download Guide</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                        aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                        et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                        aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <script>
        $(document).ready(function() {
            // jQuery Validation for the form
            $("#paymentIntegrationForm").validate({
                rules: {
                    stripe_publishable_key: {
                        required: true,
                        minlength: 5
                    },
                    stripe_secret_key: {
                        required: true,
                        minlength: 10
                    },
                    webhook_secret_key: {
                        required: true,
                        minlength: 10
                    }
                },
                messages: {
                    stripe_publishable_key: {
                        required: "Stripe Publishable ID is required",
                        minlength: "Secret ID must be at least 5 characters long"
                    },
                    stripe_secret_key: {
                        required: "Stripe Secret Key is required",
                        minlength: "Secret Key must be at least 10 characters long"
                    },
                    webhook_secret_key: {
                        required: "Webhook Secret Key is required",
                        minlength: "Please enter a valid webhook secret key"
                    }
                },
                submitHandler: function(form) {
                    // Prevent default form submission
                    event.preventDefault();
                    var formData = $(form).serialize(); // Serialize form data

                    $.ajax({
                        url: '{{ route('stripe.details.update', ['vendorid' => $vendor->id]) }}', // Ensure your route is correct
                        method: 'POST', // Use POST or PUT depending on your route
                        data: formData, // Send serialized form data
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // Handle success
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message ||
                                    'Stripe credentials updated successfully!',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Optional: You can redirect to another page or perform an action after success
                                // window.location.reload(); // Uncomment if you want to reload the page
                            });
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON.errors;

                            // If validation errors exist
                            if (errors) {
                                // Create a message with all errors
                                let errorMessage = '';
                                $.each(errors, function(field, messages) {
                                    errorMessage += messages.join(', ') + '\n';
                                });

                                // Show SweetAlert2 error popup with the validation messages
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: errorMessage ||
                                        'An unknown error occurred.',
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                // Handle unexpected errors (if no validation errors are found)
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'An error occurred while updating the Stripe credentials. Please try again later.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
