<div class="tab-pane fade show active" id="tab-pane-setting" role="tabpanel" aria-labelledby="tab-pane-setting" tabindex="0">
    <!-- Social Media -->
    <div class="information-box mb-3">
        <div class="info-head p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text-white">Social Media</div>
            </div>
        </div>
        <div class="m-3 pb-3">
            <div class="row g-4">
                <form class="row g-3" action="{{ route('admin.vendor.details.ajax-social-media-update', $vendor->id) }}" id="vendorSocialMediaForm" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="facebook" id="facebook" value="{{ $vendor->socialMedia->facebook ?? '' }}"
                                        placeholder="Please enter Facebook link">
                                    <label for="facebook">Please enter Facebook link</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="instagram" name="instagram" value="{{ $vendor->socialMedia->instagram ?? '' }}"
                                        placeholder="Please enter Instagram link">
                                    <label for="instagram">Please enter Instagram link</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div class="form-floating">
                                    <input type="text" name="twitter" class="form-control" id="twitter" value="{{ $vendor->socialMedia->twitter ?? '' }}"
                                        placeholder="Please enter Twitter link">
                                    <label for="twitter">Please enter Twitter link</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div class="form-floating">
                                    <input type="text" name="youtube" class="form-control" id="youtube" value="{{ $vendor->socialMedia->youtube ?? '' }}"
                                        placeholder="Please enter YouTube link">
                                    <label for="youtube">Please enter YouTube link</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div class="form-floating">
                                    <input type="text" name="pinterest" class="form-control" id="pinterest" value="{{ $vendor->socialMedia->pinterest ?? '' }}"
                                        placeholder="Please enter Pinterest link">
                                    <label for="pinterest">Please enter Pinterest link</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="tiktok" id="tiktok" value="{{ $vendor->socialMedia->tiktok ?? '' }}"
                                        placeholder="Please enter TikTok link">
                                    <label for="tiktok">Please enter TikTok link</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" id="saveSocialMediaForm" class="btn theme-btn px-5">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Initialize form validation
        $('#vendorSocialMediaForm').validate({
            rules: {
                
            },
            messages: {
                
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
                        $('#saveSocialMediaForm').prop('disabled', true).text('Updating...');
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Details updated successfully!',
                            confirmButtonText: 'OK',
                        }).then(() => {
                            // Optional: Perform any additional action after the alert
                        });
                        $('#saveSocialMediaForm').prop('disabled', false).text('Update');
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred. Please try again.',
                            confirmButtonText: 'Retry',
                        });
                        $('#saveSocialMediaForm').prop('disabled', false).text('Update');
                    }
                });
                return false; // Prevent default form submission
            }
        });
    });
</script>
