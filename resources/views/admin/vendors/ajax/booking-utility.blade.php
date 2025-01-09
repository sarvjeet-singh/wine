<div class="tab-pane fade booking-utility-tab-sec show active" id="tab-pane-booking-utility" role="tabpanel"
    aria-labelledby="tab-booking-utility" tabindex="0">
    <div class="information-box mb-5">
        <div class="info-head p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text-white">Booking Utility</div>
            </div>
        </div>
        <div class="m-3">
            <div class="row g-4">
                <div class="box-body-label fw-bold fs-5">Booking Options</div>
                <form id="bookingUtilityForm" action="{{ route('admin.vendor.details.ajax-booking-utility-update', $vendor->id) }}" method="post">
                    @csrf
                    <div class="row mt-3">
                        <div class="col-sm-4 col-12">
                            <input type="radio" class="custom-radio" id="one-step" name="process_type"
                                value="one-step"
                                {{ old('process_type', !empty($vendor->metadata->process_type) ? $vendor->metadata->process_type : '') == 'one-step' ? 'checked' : '' }}>
                            <label class="form-label" for="one-step">One Step Process</label>
                        </div>
                        <div class="col-sm-4 col-12">
                            <input type="radio" class="custom-radio" id="two-step" name="process_type"
                                value="two-step"
                                {{ old('process_type', !empty($vendor->metadata->process_type) ? $vendor->metadata->process_type : '') == 'two-step' ? 'checked' : '' }}>
                            <label class="form-label" for="two-step">Two Step Process</label>
                        </div>
                        <div class="col-sm-4 col-12">
                            <input type="radio" class="custom-radio" id="redirect-url" name="process_type"
                                value="redirect-url"
                                {{ old('process_type', !empty($vendor->metadata->process_type) ? $vendor->metadata->process_type : '') == 'redirect-url' ? 'checked' : '' }}>
                            <label class="form-label" for="redirect-url">Redirect URL</label>
                            <div class="d-flex align-items-center">
                                <div class="me-2" style="flex: 0 0 auto;">
                                    <select class="form-select form-control" name="redirect_url_type"
                                        style="width: auto;">
                                        <option value="http://"
                                            {{ old('redirect_url_type', !empty($vendor->metadata->redirect_url) && strpos($vendor->metadata->redirect_url, 'https://') === 0 ? 'https://' : 'http://') === 'http://' ? 'selected' : '' }}>
                                            http://</option>
                                        <option value="https://"
                                            {{ old('redirect_url_type', !empty($vendor->metadata->redirect_url) && strpos($vendor->metadata->redirect_url, 'https://') === 0 ? 'https://' : 'http://') === 'https://' ? 'selected' : '' }}>
                                            https://</option>
                                    </select>
                                </div>
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('redirect_url') is-invalid @enderror"
                                        name="redirect_url"
                                        value="{{ old('redirect_url', preg_replace('#^https?://#', '', !empty($vendor->metadata->redirect_url) ? $vendor->metadata->redirect_url : '')) }}"
                                        placeholder="Enter your website URL">
                                    <label for="floatingInput">Enter your website URL</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (strtolower($vendor->vendor_type) == 'accommodation')
                        <div class="row mt-3">
                            <div class="col-sm-6 col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="booking-minimum"
                                        name="booking_minimum"
                                        value="{{ old('booking_minimum', !empty($vendor->accommodationMetadata->booking_minimum) ? $vendor->accommodationMetadata->booking_minimum : '') }}"
                                        placeholder="Enter Booking Minimum">
                                    <label for="floatingInput">Enter Booking Minimum</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="booking-maximum"
                                        name="booking_maximum"
                                        value="{{ old('booking_maximum', !empty($vendor->accommodationMetadata->booking_maximum) ? $vendor->accommodationMetadata->booking_maximum : '') }}"
                                        placeholder="Enter Booking Maximum">
                                    <label for="floatingInput">Enter Booking Maximum</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="box-body-label fw-bold fs-5 mb-2">Booking Options</div>

                            <div class="col-sm-3 col-12">
                                <input type="checkbox" class="custom-checkbox" id="security-deposit"
                                    name="apply_security_deposit"
                                    {{ old('apply_security_deposit', !empty($vendor->metadata->security_deposit_amount) ? 1 : 0) ? 'checked' : '' }}>
                                <label class="form-label" for="security-deposit">Apply Security
                                    Deposit</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="security-deposit-amount"
                                            name="security_deposit_amount"
                                            value="{{ old('security_deposit_amount', !empty($vendor->metadata->security_deposit_amount) ? $vendor->metadata->security_deposit_amount : '') }}"
                                            placeholder="Enter Security Deposit">
                                        <label for="floatingInputGroup1">Enter Amount</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3 col-12">
                                <input type="checkbox" class="custom-checkbox" id="applicable-taxes"
                                    name="apply_applicable_taxes"
                                    {{ old('apply_applicable_taxes', !empty($vendor->metadata->applicable_taxes_amount) ? 1 : 0) ? 'checked' : '' }}>
                                <label class="form-label" for="applicable-taxes">Apply Applicable
                                    Taxes</label>
                                <div class="input-group">
                                    <span class="input-group-text">%</span>
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="applicable-taxes-amount"
                                            name="applicable_taxes_amount"
                                            value="{{ old('applicable_taxes_amount', !empty($vendor->metadata->applicable_taxes_amount) ? $vendor->metadata->applicable_taxes_amount : '') }}"
                                            placeholder="Enter Applicable Taxes">
                                        <label for="floatingInputGroup1">Enter Percentage</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3 col-12">
                                <input type="checkbox" class="custom-checkbox" id="cleaning-fee"
                                    name="apply_cleaning_fee"
                                    {{ old('apply_cleaning_fee', !empty($vendor->metadata->cleaning_fee_amount) ? 1 : 0) ? 'checked' : '' }}>
                                <label class="form-label" for="cleaning-fee">Apply Cleaning
                                    Fee</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="cleaning-fee-amount"
                                            name="cleaning_fee_amount"
                                            value="{{ old('cleaning_fee_amount', !empty($vendor->metadata->cleaning_fee_amount) ? $vendor->metadata->cleaning_fee_amount : '') }}"
                                            placeholder="Enter Cleaning Fee">
                                        <label for="floatingInputGroup1">Enter Amount</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3 col-12">
                                <input type="checkbox" class="custom-checkbox" id="pet-boarding"
                                    name="apply_pet_boarding"
                                    {{ old('apply_pet_boarding', !empty($vendor->metadata->pet_boarding) ? 1 : 0) ? 'checked' : '' }}>
                                <label class="form-label" for="pet-boarding">Pet Boarding</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="pet-boarding-amount"
                                            name="pet_boarding"
                                            value="{{ old('pet_boarding', !empty($vendor->metadata->pet_boarding) ? $vendor->metadata->pet_boarding : '') }}"
                                            placeholder="Enter Pet Boarding Fee">
                                        <label for="floatingInputGroup1">Enter Amount</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-4 col-12">
                                <div class="form-floating">
                                    <input type="text" name="host"
                                        value="{{ old('host', !empty($vendor->host) ? $vendor->host : '') }}"
                                        class="form-control" id="host" placeholder="Host"
                                        @error('host') is-invalid @enderror>
                                    <label for="floatingInput">Host</label>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12">
                                <div class="form-floating">
                                    <input type="text" id="checkin_start_time"
                                        class="form-control @error('checkin_start_time') is-invalid @enderror"
                                        name="checkin_start_time"
                                        value="{{ old('checkin_start_time', !empty($vendor->accommodationMetadata->checkin_start_time) ? \Carbon\Carbon::createFromFormat('H:i:s', $vendor->accommodationMetadata->checkin_start_time)->format('h:i a') : '') }}"
                                        placeholder="Enter Check-in Start Time" readonly>
                                    <label for="floatingInput">Enter Check-in Time*</label>
                                </div>
                            </div>

                            <div class="col-sm-4 col-12">
                                <div class="form-floating">
                                    <input type="text" id="checkout_time"
                                        class="form-control @error('checkout_time') is-invalid @enderror"
                                        name="checkout_time"
                                        value="{{ old('checkout_time', !empty($vendor->accommodationMetadata->checkout_time) ? \Carbon\Carbon::createFromFormat('H:i:s', $vendor->accommodationMetadata->checkout_time)->format('h:i a') : '') }}"
                                        placeholder="Enter Checkout Time" readonly>
                                    <label for="floatingInput">Enter Checkout Time*</label>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row mt-3">
                            <div class="col-sm-12 col-12">
                                <input type="checkbox" class="custom-checkbox" id="applicable-taxes"
                                    name="apply_applicable_taxes"
                                    {{ old('apply_applicable_taxes', !empty($vendor->metadata->applicable_taxes_amount) ? 1 : 0) ? 'checked' : '' }}>
                                <label class="form-label" for="applicable-taxes">Apply Applicable Taxes</label>
                                <div class="input-group">
                                    <span class="input-group-text">%</span>
                                    <input type="number" class="form-control" id="applicable-taxes-amount"
                                        name="applicable_taxes_amount"
                                        value="{{ old('applicable_taxes_amount', !empty($vendor->metadata->applicable_taxes_amount) ? $vendor->metadata->applicable_taxes_amount : '') }}"
                                        placeholder="Enter Applicable Taxes">
                                </div>
                                @error('applicable_taxes_amount')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif
                    <div class="row mt-5">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn theme-btn px-5">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="information-box mb-3">
        <div class="info-head p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text-white">Refund Policy</div>
            </div>
        </div>
        <div class="m-3">
            <div class="row g-4">
                <form id="policyForm" action="{{ route('admin.vendor.details.ajax-settings-policy-update', $vendor->id) }}"
                    method="post">
                    @csrf
                    <div class="row mt-3">
                        <div class="col-12">
                            <input type="radio" class="custom-radio" id="open-policy" name="policy"
                                value="open" {{ old('policy', $vendor->policy) == 'open' ? 'checked' : '' }}>
                            <label class="form-label" for="open-policy">Open</label>
                            <p class="ps-4">A full refund minus transaction fees
                                will be issued upon request up to 24 hours prior to the check-in
                                date indicated.</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <input type="radio" class="custom-radio" id="partial-policy" name="policy"
                                value="partial" {{ old('policy', $vendor->policy) == 'partial' ? 'checked' : '' }}>
                            <label class="form-label" for="partial-policy">Partial</label>
                            <p class="ps-4">A full refund minus transaction fees
                                will be issued upon request up to 7 days prior to the check-in date
                                indicated. No
                                refund will be issued for cancellations that fall within that 7-day
                                period prior to
                                the check-in date. A credit or rain cheque may be issued to guests
                                at the vendor’s
                                discretion.</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <input type="radio" class="custom-radio" id="closed-policy" name="policy"
                                value="closed" {{ old('policy', $vendor->policy) == 'closed' ? 'checked' : '' }}>
                            <label class="form-label" for="closed-policy">Closed</label>
                            <p class="ps-4">All bookings are final. No portion of
                                your transaction will be refunded. A credit or rain cheque may be
                                issued by the
                                subject vendor at the vendor’s discretion.</p>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn theme-btn px-5">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#checkin_start_time').timepicker({
            timeFormat: 'hh:mm tt',
            interval: 60,
            // minTime: '3:00pm',
            // maxTime: '12:00am',
            startTime: '3:00pm',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

        $('#checkin_end_time').timepicker({
            timeFormat: 'hh:mm tt',
            interval: 60,
            // minTime: '3:00pm',
            // maxTime: '12:00am',
            startTime: '3:00pm',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

        $('#checkout_time').timepicker({
            timeFormat: 'hh:mm tt',
            interval: 60,
            // minTime: '11:00am',
            // maxTime: '12:00pm',
            startTime: '11:00am',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        var numericFields = ['security-deposit-amount', 'applicable-taxes-amount', 'cleaning-fee-amount'];

        numericFields.forEach(function(fieldId) {
            var field = document.getElementById(fieldId);

            field.addEventListener('input', function(e) {
                var value = e.target.value;
                var regex = /^\d+(\.\d{0,2})?$/;

                if (!regex.test(value)) {
                    e.target.value = value.slice(0, -1);
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var numericFields = ['booking-minimum', 'booking-maximum'];

        numericFields.forEach(function(fieldId) {
            var field = document.getElementById(fieldId);

            field.addEventListener('input', function(e) {
                var value = e.target.value;

                // Remove non-numeric characters
                value = value.replace(/[^0-9]/g, '');

                // Limit to 2 digits
                if (value.length > 2) {
                    value = value.slice(0, 2);
                }

                e.target.value = value;
            });
        });
    });
    $(document).ready(function() {
        $('#bookingUtilityForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'), // URL from the form action
                method: $(this).attr('method'), // Method from the form method
                data: $(this).serialize(), // Serialize the form data
                success: function(response) {
                    if (response.status) {
                        showToast("Success", response.message, "success");
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
                        // Other errors
                        showToast("Error", "An error occurred while updating experiences.", "error");
                    }
                },
            });
        });
        $('#policyForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'), // URL from the form action
                method: $(this).attr('method'), // Method from the form method
                data: $(this).serialize(), // Serialize the form data
                success: function(response) {
                    if (response.status) {
                        showToast("Success", response.message, "success");
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
                        // Other errors
                        showToast("Error", "An error occurred while updating experiences.", "error");
                    }
                },
            });
        });

    });
</script>
