<div class="tab-pane fade show active" id="tab-pane-setting" role="tabpanel" aria-labelledby="tab-pane-setting"
    tabindex="0">
    <!-- Social Media -->
    <div class="information-box mb-3">
        <div class="info-head p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text-white">System Admin</div>
            </div>
        </div>
        <div class="m-3 pb-3">
            <div class="row g-4">
                <form id="accountForm"
                    action="{{ route('admin.vendor.details.ajax-account-status-update', $vendor->id) }}" method="POST">
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
                            <div class="col-12">
                                <div><label for="" class="form-label fw-bold">Account Status</label>
                                </div>
                                <div class="row g-2">
                                    @foreach (getAccountStatus() as $accountstatus)
                                        <div class="col-md-4">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="account_status"
                                                    id="status_{{ $accountstatus->id }}"
                                                    value="{{ $accountstatus->id }}"
                                                    {{ $vendor->account_status == $accountstatus->id ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="status_{{ $accountstatus->id }}">{{ $accountstatus->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-12">
                                <div><label for="" class="form-label fw-bold">Price Point</label></div>
                                <div class="row g-2">
                                    @foreach (getPricePoints() as $pricePoint)
                                        <div class="col-md-4">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="price_point"
                                                    id="point_{{ $pricePoint->id }}" value="{{ $pricePoint->id }}"
                                                    {{ $vendor->price_point == $pricePoint->id ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="point_{{ $pricePoint->id }}">{{ $pricePoint->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
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
        $('#accountForm').validate({
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
                    url: "{{ route('admin.vendor.details.ajax-account-status-update', $vendor->id) }}",
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
