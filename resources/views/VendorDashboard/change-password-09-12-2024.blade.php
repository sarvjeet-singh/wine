@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Vendor Dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('asset/css/select2.min.css') }}">
@endsection
@section('content')
    <div class="col-sm-12">
        <div class="row mt-5 d-flex justify-content-center">
            <div class="col-sm-12 col-md-6">
                <div class="information-box p-0">
                    <div class="information-box-head">
                        <div class="box-head-heading d-flex">
                            <span
                                class="box-head-label theme-color">{{ $hideSidebar ? 'Update Your Password or Skip This Step' : 'Change Password' }}</span>
                        </div>
                    </div>
                    <div class="information-box-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form action="{{ route('vendor-password-update', ['vendorid' => $vendor->id]) }}" method="post"
                            id="account-form">
                            @csrf
                            <div class="row g-3 mb-2">
                                <div class="col-12">
                                    <div>
                                        <label for="new_password" class="form-label fw-bold">Old Password</label>
                                        <input type="password" class="form-control" name="old_password" id="old_password"
                                            placeholder="Old Password" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div>
                                        <label for="new_password" class="form-label fw-bold">New Password</label>
                                        <input type="password" class="form-control" name="new_password" id="new_password"
                                            placeholder="New Password" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div>
                                        <label for="confirm_password" class="form-label fw-bold">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirm_password"
                                            id="confirm_password" placeholder="Confirm Password" required>
                                    </div>
                                </div>
                                <div class="col-sm-12 text-center">
                                    {{ $hideSidebar ? '<button type="button" class="btn wine-btn px-5" id="skip-btn">Skip</button>' : '' }}
                                    <button type="submit" class="btn wine-btn px-5" id="update-btn">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            $.validator.addMethod(
                "notEqualToOldPassword",
                function(value, element, param) {
                    return this.optional(element) || value !== $(param).val();
                },
                "New password must not match the old password."
            );
            $.validator.addMethod("strongPassword", function(value, element) {

                return this.optional(element) ||

                    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);

            }, "Password must include uppercase, lowercase, a number, and a special character.");
            let validationRules = {
                new_password: {
                    required: true,
                    minlength: 8,
                    strongPassword: true
                },
                confirm_password: {
                    required: true,
                    equalTo: "#new_password"
                }
            };

            // Check if #old_password field exists and add its validation rule
            if ($("#old_password").length) {
                validationRules.old_password = {
                    required: true,
                    minlength: 8
                };
                validationRules.new_password = {
                    required: true,
                    minlength: 8,
                    strongPassword: true,
                    notEqualToOldPassword: "#old_password"
                };
            }

            // jQuery Validation setup
            $("#account-form").validate({
                rules: validationRules,
                messages: {
                    old_password: {
                        required: "Please enter your old password",
                        minlength: "Old password must be at least 8 characters long"
                    },
                    new_password: {
                        required: "Please enter a new password.",
                        minlength: "Password must be at least 8 characters.",
                        strongPassword: "Password must include uppercase, lowercase, a number, and a special character."
                    },
                    confirm_password: {
                        required: "Please confirm your password.",
                        equalTo: "Passwords do not match."
                    }
                },
                errorElement: "div",
                errorPlacement: function(error, element) {
                    error.addClass("text-danger mt-1");
                    error.insertAfter(element);
                },
                submitHandler: function(form) {
                    // Serialize form data
                    var formData = $(form).serialize();

                    // Perform AJAX request
                    $.ajax({
                        url: "{{ route('vendor-password-update', ['vendorid' => $vendor->id]) }}", // Replace with your route
                        method: "POST",
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content') // Add CSRF token for security
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message ||
                                    'Password updated successfully.',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                // Redirect to the dashboard or perform another action
                                window.location.href =
                                    "{{ route('vendor-dashboard', ['vendorid' => $vendor->id]) }}";
                            });
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON.errors;

                            // Show validation errors if they exist
                            if (errors) {
                                // console.log(errors);
                                // let errorMessage = '';
                                // $.each(errors, function(field, messages) {
                                //     errorMessage += messages.join(', ') + '\n';
                                // });

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: errors ||
                                        'An error occurred. Please try again.',
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                // Handle unexpected errors
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'An error occurred while updating the password. Please try again later.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    });
                }
            });

            // Optional skip button functionality
            $("#skip-btn").on("click", function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to skip updating the password. This action can be updated later.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, skip it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, proceed with the skip action
                        $.ajax({
                            url: "{{ route('vendor-skip-password', ['vendorid' => $vendor->id]) }}", // Replace with your actual route
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content') // CSRF token for security
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Skipped!',
                                    text: response.message ||
                                        'You have successfully skipped the password update.',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    // Redirect to the vendor dashboard after success
                                    window.location.href =
                                        "{{ route('vendor-dashboard', ['vendorid' => $vendor->id]) }}";
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Unable to skip the password update. Please try again.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
