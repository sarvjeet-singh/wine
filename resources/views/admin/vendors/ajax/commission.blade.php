<div class="tab-pane fade show active" id="tab-pane-setting" role="tabpanel" aria-labelledby="tab-pane-setting"
    tabindex="0">
    <!-- Social Media -->
    <div class="information-box mb-3">
        <div class="info-head p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text-white">Platform Fee Commission in (%)</div>
            </div>
        </div>
        <div class="m-3 pb-3">
            <div class="row g-4">
                <form id="platformFeeForm"
                    action="{{ route('admin.vendor.details.ajax-platform-fee-update', $vendor->id) }}" method="POST">
                    <!-- Account Status Sec Start -->
                    @method('PUT')
                    @csrf

                    <div class="m-3 pb-4">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="row g-4">
                            <div class="col-sm-4 col-12">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('event_platform_fee') is-invalid @enderror"
                                        name="event_platform_fee"
                                        value="{{ old('event_platform_fee', !empty($vendor->event_platform_fee) ? $vendor->event_platform_fee : '') }}"
                                        placeholder="Enter event Platform Fee">
                                    <label for="floatingInput">Event Platform Fee</label>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('accommodation_platform_fee') is-invalid @enderror"
                                        name="accommodation_platform_fee"
                                        value="{{ old('accommodation_platform_fee', !empty($vendor->accommodation_platform_fee) ? $vendor->accommodation_platform_fee : '') }}"
                                        placeholder="Enter Accommodation Platform Fee">
                                    <label for="floatingInput">Accommodation Platform Fee</label>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('accommodation_event_platform_fee') is-invalid @enderror"
                                        name="accommodation_event_platform_fee"
                                        value="{{ old('accommodation_event_platform_fee',!empty($vendor->accommodation_event_platform_fee) ? $vendor->accommodation_event_platform_fee : '') }}"
                                        placeholder="Enter accommodation event Platform Fee">
                                    <label for="floatingInput">Accommodation Event Platform Fee</label>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('winery_b2b_platform_fee') is-invalid @enderror"
                                        name="winery_b2b_platform_fee"
                                        value="{{ old('winery_b2b_platform_fee', !empty($vendor->winery_b2b_platform_fee) ? $vendor->winery_b2b_platform_fee : '') }}"
                                        placeholder="Enter Winery B2B Platform Fee">
                                    <label for="floatingInput">Winery B2B Platform Fee</label>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('winery_b2c_platform_fee') is-invalid @enderror"
                                        name="winery_b2c_platform_fee"
                                        value="{{ old('winery_b2c_platform_fee', !empty($vendor->winery_b2c_platform_fee) ? $vendor->winery_b2c_platform_fee : '') }}"
                                        placeholder="Enter Winery B2C Platform Fee">
                                    <label for="floatingInput">Winery B2C Platform Fee</label>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('excursion_platform_fee') is-invalid @enderror"
                                        name="excursion_platform_fee"
                                        value="{{ old('excursion_platform_fee', !empty($vendor->excursion_platform_fee) ? $vendor->excursion_platform_fee : '') }}"
                                        placeholder="Enter Excursion Platform Fee">
                                    <label for="floatingInput">Excursion Platform Fee</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Account Status Sec End -->
                    <div class="text-center mb-3">
                        <button type="submit" class="btn theme-btn px-5">Update</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Initialize form validation
        $('#platformFeeForm').validate({
            rules: {
                account_status: {
                    required: true
                },
                price_point: {
                    // required: true
                }
            },
            messages: {
                account_status: {
                    required: "Please select an account status."
                },
                price_point: {
                    // required: "Please select a price point."
                }
            },
            errorPlacement: function(error, element) {
                // Append the error message to the parent container of the closest row
                error.appendTo(element.closest('.row').parent());
            },
            submitHandler: function(form, event) {
                event.preventDefault(); // Prevent normal form submission

                $.ajax({
                    url: "{{ route('admin.vendor.details.ajax-platform-fee-update', $vendor->id) }}",
                    method: "PUT", // Matches @method('PUT') in the form
                    data: $(form).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Add CSRF token
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showToast("Success", response.message, "success");
                        } else {
                            showToast("Error", response.message, "error");
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 404) {
                            // Vendor not found
                            showToast("Error", "Vendor not found.", "error");
                        } else if (xhr.status === 422) {
                            // Validation errors
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = '<div class="alert alert-danger"><ul>';
                            for (let field in errors) {
                                errorMessage += `<li>${errors[field][0]}</li>`;
                            }
                            errorMessage += '</ul></div>';
                            showToast("Error", errorMessage, "error");
                        } else {
                            // General error message for unexpected errors
                            showToast(
                                "Error",
                                "An error occurred while updating account details.",
                                "error"
                            );
                        }
                    }
                });
            }
        });
    });
</script>
