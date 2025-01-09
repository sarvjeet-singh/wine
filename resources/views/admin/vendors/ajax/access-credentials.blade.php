<div class="tab-pane fade show active" id="tab-pane-setting" role="tabpanel" aria-labelledby="tab-pane-setting"
    tabindex="0">
    <!-- Access Credentials -->
    <div class="information-box mb-3">
        <div class="info-head p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text-white">Access Credentials</div>
            </div>
        </div>
        <div class="m-3 pb-3">
            <div class="row g-4">
                <form id="userDetailsForm" method="POST"
                    action="{{ route('admin.vendor.details.ajax-access-credentials-update', $vendor->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div>
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                                        name="firstname" value="{{ old('firstname', $vendor->user->firstname ?? '') }}"
                                        placeholder="Enter first name">
                                    <label for="givenName">Given Name(s)</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                                        name="lastname" value="{{ old('lastname', $vendor->user->lastname ?? '') }}"
                                        placeholder="Enter last name">
                                    <label for="lastName">Surname / Last Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="email"
                                        value="{{ $vendor->user->email ?? '' }}" placeholder="Enter email address"
                                        disabled>
                                    <label for="email">Enter eMail/Username</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <div class="form-floating">
                                    <input type="text"
                                        class="phone-number form-control @error('contact_number') is-invalid @enderror"
                                        name="contact_number"
                                        value="{{ old('contact_number', $vendor->user->contact_number ?? '') }}"
                                        placeholder="Enter Phone number">
                                    <label for="phone">Contact Phone</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn theme-btn px-5">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.phone-number').on('input', function() {
            const $input = $(this);
            const cursorPosition = $input.prop('selectionStart');
            const rawValue = $input.val().replace(/\D/g, ''); // Remove all non-digit characters
            let formattedValue = '';

            // Format the phone number
            if (rawValue.length > 3 && rawValue.length <= 6) {
                formattedValue = rawValue.slice(0, 3) + '-' + rawValue.slice(3);
            } else if (rawValue.length > 6) {
                formattedValue =
                    rawValue.slice(0, 3) +
                    '-' +
                    rawValue.slice(3, 6) +
                    '-' +
                    rawValue.slice(6, 10);
            } else {
                formattedValue = rawValue;
            }

            // Update the input value
            $input.val(formattedValue);

            // Restore cursor position
            const adjustedPosition =
                cursorPosition + (formattedValue.length - rawValue.length);
            $input[0].setSelectionRange(adjustedPosition, adjustedPosition);
        });
    });
    $(document).ready(function() {
        $('#userDetailsForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            $.ajax({
                url: $(this).attr('action'), // URL from the form action
                method: $(this).attr('method'), // HTTP method from the form
                data: $(this).serialize(), // Serialize the form data
                success: function(response) {
                    if (response.success) {
                        // Show success message using SweetAlert2
                        showToast("Success", response.message, "success");
                    } else {
                        // Show error message
                        showToast("Error", response.message, "error");
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Validation errors
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = Object.values(errors).map(errorArray =>
                            errorArray.join(', ')
                        );

                        showToast("Error", errorMessages.join('<br>'), "error");
                    } else {
                        // General error
                        showToast("Error", "An error occurred while updating user details.", "error");
                    }
                },
            });
        });
    });
</script>
