<div class="tab-pane fade show active" id="tab-pane-setting" role="tabpanel" aria-labelledby="tab-pane-setting"
    tabindex="0">
    <!-- Social Media -->
    <div class="information-box mb-3">
        <div class="info-head p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text-white">System Admin</div>
            </div>
        </div>
        <div class="alert alert-warning mt-3 d-none" id="platformFeeAlert" role="alert">
            Kindly add the platform fee under the Platform Fee section.
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
                        </div>
                    </div>
                    <!-- Account Status Sec End -->
                    <div class="text-center mb-3">
                        <button type="submit" class="btn theme-btn px-5">Update</button>
                    </div>
                </form>
                <form id="pricePointForm"
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
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="errorModalLabel">Your profile is incomplete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="errorIntro">
                    Your profile is incomplete. Please complete the following required sections to get Vendor Partner
                    status:
                </p>
                <ul id="errorMessage" class="mb-0 list-unstyled"></ul>
            </div>
            <div class="modal-footer">
                <p id="completionNote">
                    Once all sections are complete, your account can be upgraded to “Vendor Partner”, with full access
                    to all utilities and a “Dedicated Vendor Page”.
                </p>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                }
            },
            messages: {
                account_status: {
                    required: "Please select an account status."
                }
            },
            errorPlacement: function(error, element) {
                // Append the error message to the parent container of the closest row
                error.appendTo(element.closest('.row').parent());
            },
            submitHandler: function(form, event) {
                event.preventDefault(); // Prevent normal form submission

                let vendorid = "{{ $vendor->id }}"; // Get vendor ID

                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.vendor.details.ajax-account-status-update', $vendor->id) }}",
                    data: {
                        vendorid: vendorid,
                        account_status: $('input[name="account_status"]:checked').val()
                    },
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        let selectedStatus = $('input[name="account_status"]:checked')
                            .val();

                        if (selectedStatus === '1') {
                            let messages = '';

                            if (response.message && Array.isArray(response.message)) {
                                messages = response.message.map(item => {
                                    let color = item.completed ? 'green' : item
                                        .is_optional ? 'orange' : 'red';
                                    let icon = item.completed ? '✅' : item
                                        .is_optional ? '⚠️' : '❌';
                                    return `<li style="color: ${color};">${icon} ${item.message}</li>`;
                                }).join('');
                            } else {
                                messages =
                                    `<li style="color: green;">✅ Vendor is eligible for activation</li>`;
                            }

                            $('#errorMessage').html(messages);

                            if (response.success) {
                                $('#errorModalLabel').text(
                                    'Your profile is complete ✅');
                                $("#errorIntro").text('Your profile is complete now!');
                                $("#completionNote").text(
                                    'All sections are completed, your profile will be upgraded to Vendor Partner status.'
                                );
                                $('#checkActivationBtn').remove();
                                $(".modal-header").removeClass("bg-danger").addClass(
                                    "bg-success");
                            } else {
                                $('#errorModalLabel').text(
                                    'Your profile is incomplete ❌');
                            }

                            $('#errorModal').modal('show');
                        } else {
                            if (response.status === "true") {
                                showToast("Success", response.message, "success");
                            } else {
                                showToast("Error", response.message, "error");
                            }
                        }
                    },
                    error: function() {
                        let selectedStatus = $('input[name="account_status"]:checked')
                            .val();

                        if (selectedStatus === '1') {
                            $('#errorMessage').html(
                                "<li style='color: red;'>❌ Something went wrong. Please try again.</li>"
                            );
                            $('#errorModalLabel').text('Error ❌');
                            $("#errorIntro").text('An unexpected error occurred.');
                            $("#completionNote").text(
                                'Please try again later or contact support.');
                            $(".modal-header").removeClass("bg-success").addClass(
                                "bg-danger");
                            $('#errorModal').modal('show');
                        } else {
                            showToast("Error",
                                "Something went wrong. Please try again.", "error");
                        }
                    }
                });
            }
        });
        $('#pricePointForm').validate({
            rules: {
                price_point: {
                    // required: true
                }
            },
            messages: {
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
                    url: "{{ route('admin.vendor.details.ajax-price-point-update', $vendor->id) }}",
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
                                "An error occurred while updating price point.",
                                "error"
                            );
                        }
                    }
                });
            }
        });
    });
    $(document).ready(function() {
        function toggleAlert() {
            var selectedValue = $('input[name="account_status"]:checked').val();
            if (selectedValue == 1) {
                checkPlatformFees();
            } else {
                $('#platformFeeAlert').addClass('d-none');
            }
        }

        // Run on page load
        toggleAlert();

        // Run on change
        $('input[name="account_status"]').on('change', function() {
            toggleAlert();
        });
    });
    $(document).ready(function() {
        $('#errorModal').on('hidden.bs.modal', function() {
            location.reload();
        });
    });
</script>
<script>
    if (typeof vendorData === 'undefined') {
        var vendorData = {
            vendorType: "{{ $vendor->vendor_type }}",
            eventPlatformFee: "{{ $vendor->event_platform_fee }}",
            accommodationPlatformFee: "{{ $vendor->accommodation_platform_fee }}",
            accommodationEventPlatformFee: "{{ $vendor->accommodation_event_platform_fee }}",
            wineryB2BPlatformFee: "{{ $vendor->winery_b2b_platform_fee }}",
            wineryB2CPlatformFee: "{{ $vendor->winery_b2c_platform_fee }}",
            excursionPlatformFee: "{{ $vendor->excursion_platform_fee }}"
        };
    } else {
        // Optionally update it instead of skipping
        Object.assign(vendorData, {
            vendorType: "{{ $vendor->vendor_type }}",
            eventPlatformFee: "{{ $vendor->event_platform_fee }}",
            accommodationPlatformFee: "{{ $vendor->accommodation_platform_fee }}",
            accommodationEventPlatformFee: "{{ $vendor->accommodation_event_platform_fee }}",
            wineryB2BPlatformFee: "{{ $vendor->winery_b2b_platform_fee }}",
            wineryB2CPlatformFee: "{{ $vendor->winery_b2c_platform_fee }}",
            excursionPlatformFee: "{{ $vendor->excursion_platform_fee }}"
        });
    }

    function checkPlatformFees() {
        const type = vendorData.vendorType;

        let missingFee = false;

        switch (type) {
            case 'winery':
                missingFee = !vendorData.wineryB2BPlatformFee ||
                    !vendorData.wineryB2CPlatformFee ||
                    !vendorData.eventPlatformFee;
                break;

            case 'excursion':
                missingFee = !vendorData.excursionPlatformFee ||
                    !vendorData.eventPlatformFee;
                break;

            case 'licensed':
            case 'non-licensed':
                missingFee = !vendorData.eventPlatformFee;
                break;

            case 'accommodation':
                missingFee = !vendorData.accommodationPlatformFee ||
                    !vendorData.accommodationEventPlatformFee ||
                    !vendorData.eventPlatformFee;
                break;

            default:
                missingFee = true;
        }

        if (missingFee) {
            $('#platformFeeAlert').removeClass('d-none');
        } else {
            $('#platformFeeAlert').addClass('d-none');
        }
    }
    $(document).ready(function() {
        if ($('input[name="account_status"]:checked').val() === '1') {
            checkPlatformFees();
        }
    });
</script>
