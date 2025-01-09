<div class="tab-pane fade show active payment-integration-tab" id="tab-pane-vendor-stripe" role="tabpanel"
    aria-labelledby="tab-pane-vendor-stripe" tabindex="0">
    <!-- Business Information -->
    <div class="information-box mb-3">
        <div class="info-head p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text-white">Payment Integration</div>
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
        </div>
        <div class="m-3 pb-3">
            <div class="row g-4">
                <form id="stripeForm" action="{{ route('admin.vendor.details.ajax-stripe-update', $vendor->id) }}"
                    method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-12">
                            <div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="stripe_publishable_key"
                                        name="stripe_publishable_key" placeholder="Enter Publishable Key"
                                        value="{{ old('stripe_publishable_key', $stripeDetail->stripe_publishable_key ?? '') }}">
                                    <label for="stripe_publishable_key">Publishable Key</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="stripe_secret_key"
                                        name="stripe_secret_key" placeholder="Enter Secret Key"
                                        value="{{ old('stripe_secret_key', $stripeDetail->stripe_secret_key ?? '') }}">
                                    <label for="stripe_secret_key">Secret Key</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="webhook_secret_key"
                                        name="webhook_secret_key" placeholder="Enter Webhook Secret"
                                        value="{{ old('webhook_secret_key', $stripeDetail->webhook_secret_key ?? '') }}">
                                    <label for="webhook_secret_key">Webhook Secret</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" id="saveStripeForm" class="btn theme-btn px-5">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Initialize form validation
        $('#stripeForm').validate({
            rules: {
                stripe_publishable_key: {
                    required: true,
                },
                stripe_secret_key: {
                    required: true,
                },
                webhook_secret_key: {
                    required: true,
                },
            },
            messages: {
                stripe_publishable_key: {
                    required: "Publishable Key is required.",
                },
                stripe_secret_key: {
                    required: "Secret Key is required.",
                },
                webhook_secret_key: {
                    required: "Webhook Secret is required.",
                },
            },
            errorClass: 'text-danger',
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                // AJAX submission
                $.ajax({
                    url: form.action,
                    method: 'POST',
                    data: $(form).serialize(),
                    beforeSend: function() {
                        $('#saveStripeForm').prop('disabled', true).text('Saving...');
                    },
                    success: function(response) {
                        showToast("Success", "Details updated successfully!.", "success");
                        $('#saveStripeForm').prop('disabled', false).text('Save');
                    },
                    error: function(xhr) {
                        showToast("Error", "An error occurred. Please try again.", "error");
                        $('#saveStripeForm').prop('disabled', false).text('Save');
                    }
                });
                return false; // Prevent default form submission
            }
        });
    });
</script>
