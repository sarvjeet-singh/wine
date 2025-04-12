@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Vendor Dashboard')
@php
    use Carbon\Carbon;
@endphp
@section('content')
    <div class="col right-side">
        <div class="row">
            <div class="col-sm-12">
                <div class="information-box">
                    <div class="information-box-head">
                        <div class="box-head-heading d-flex">
                            <span class="box-head-label theme-color">Booking Utility</span>
                        </div>
                    </div>
                    <div class="information-box-body">
                        @if (session('success-booking-utility'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success-booking-utility') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="box-body-label">Booking Option</div>
                        <form action="{{ route('vendor-settings-booking-utility', ['vendorid' => $vendor->id]) }}"
                            method="post">
                            @csrf
                            <div class="row mt-3">
                                @if (strtolower($vendor->vendor_type) != 'winery')
                                    <div class="col-sm-4 col-12">
                                        <input type="radio" class="custom-radio" id="one-step" name="process_type"
                                            value="one-step"
                                            {{ old('process_type', !empty($vendor->metadata->process_type) ? $vendor->metadata->process_type : '') == 'one-step' ? 'checked' : '' }}>
                                        <label class="form-label" for="one-step">One Step Process!</label>
                                    </div>
                                    <div class="col-sm-4 col-12">
                                        <input type="radio" class="custom-radio" id="two-step" name="process_type"
                                            value="two-step"
                                            {{ old('process_type', !empty($vendor->metadata->process_type) ? $vendor->metadata->process_type : '') == 'two-step' ? 'checked' : '' }}>
                                        <label class="form-label" for="two-step">Two Step Process</label>
                                    </div>
                                @elseif(strtolower($vendor->vendor_type) == 'winery')
                                    <div class="col-sm-4 col-12">
                                        <input type="radio" class="custom-radio" id="one-step" name="process_type"
                                            value="one-step"
                                            {{ old('process_type', $vendor->metadata->process_type ?? 'one-step') == 'one-step' ? 'checked' : '' }}>
                                        <label class="form-label" for="one-step">Process payment with Our Platform
                                            (Recommended)!</label>
                                    </div>
                                @endif
                                <div class="col-sm-4 col-12">
                                    <input type="radio" class="custom-radio" id="redirect-url" name="process_type"
                                        value="redirect-url"
                                        {{ old('process_type', !empty($vendor->metadata->process_type) ? $vendor->metadata->process_type : '') == 'redirect-url' ? 'checked' : '' }}>
                                    <label class="form-label" for="redirect-url">Redirect URL</label>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2" style="flex: 0 0 auto;">
                                            <select class="form-select" name="redirect_url_type" style="width: auto;">
                                                <option value="http://"
                                                    {{ old('redirect_url_type', !empty($vendor->metadata->redirect_url) && strpos($vendor->metadata->redirect_url, 'https://') === 0 ? 'https://' : 'http://') === 'http://' ? 'selected' : '' }}>
                                                    http://</option>
                                                <option value="https://"
                                                    {{ old('redirect_url_type', !empty($vendor->metadata->redirect_url) && strpos($vendor->metadata->redirect_url, 'https://') === 0 ? 'https://' : 'http://') === 'https://' ? 'selected' : '' }}>
                                                    https://</option>
                                            </select>
                                        </div>

                                        <!-- Strip 'http://' or 'https://' from the URL when showing in the input field -->
                                        <input type="text"
                                            class="form-control @error('redirect_url') is-invalid @enderror"
                                            name="redirect_url"
                                            value="{{ old('redirect_url', preg_replace('#^https?://#', '', !empty($vendor->metadata->redirect_url) ? $vendor->metadata->redirect_url : '')) }}"
                                            placeholder="Enter your website URL">

                                        @error('redirect_url')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @error('process_type')
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                </div>
                            @enderror
                            @if (strtolower($vendor->vendor_type) == 'accommodation')
                                <div class="row mt-3">
                                    <div class="col-sm-6 col-12">
                                        <label class="form-label">Booking Minimum</label>
                                        <input type="text" class="form-control" id="booking-minimum"
                                            name="booking_minimum"
                                            value="{{ old('booking_minimum', !empty($vendor->accommodationMetadata->booking_minimum) ? $vendor->accommodationMetadata->booking_minimum : '') }}"
                                            placeholder="Enter Booking Minimum">
                                        @error('booking_minimum')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="form-label">Booking Maximum</label>
                                        <input type="text" class="form-control" id="booking-maximum"
                                            name="booking_maximum"
                                            value="{{ old('booking_maximum', !empty($vendor->accommodationMetadata->booking_maximum) ? $vendor->accommodationMetadata->booking_maximum : '') }}"
                                            placeholder="Enter Booking Maximum">
                                        @error('booking_maximum')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="box-body-label mb-2">Booking Option</div>

                                    <div class="col-sm-3 col-12">
                                        <input type="checkbox" class="custom-checkbox" id="security-deposit"
                                            name="apply_security_deposit"
                                            {{ old('apply_security_deposit', !empty($vendor->metadata->security_deposit_amount) ? 1 : 0) ? 'checked' : '' }}>
                                        <label class="form-label" for="security-deposit">Apply Security Deposit</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="security-deposit-amount"
                                                name="security_deposit_amount"
                                                value="{{ old('security_deposit_amount', !empty($vendor->metadata->security_deposit_amount) ? $vendor->metadata->security_deposit_amount : '') }}"
                                                placeholder="Enter Security Deposit" step="0.01">
                                        </div>
                                        @error('security_deposit_amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-3 col-12">
                                        <input type="checkbox" class="custom-checkbox" id="applicable-taxes"
                                            name="apply_applicable_taxes"
                                            {{ old('apply_applicable_taxes', !empty($vendor->metadata->applicable_taxes_amount) ? 1 : 0) ? 'checked' : '' }}>
                                        <label class="form-label" for="applicable-taxes">Apply Applicable Taxes</label>
                                        <div class="input-group">
                                            <span class="input-group-text">%</span>
                                            <input type="number" class="form-control" id="applicable-taxes-amount"
                                                name="applicable_taxes_amount"
                                                value="{{ old('applicable_taxes_amount', !empty($vendor->metadata->applicable_taxes_amount) ? $vendor->metadata->applicable_taxes_amount : '') }}"
                                                placeholder="Enter Applicable Taxes" step="0.01">
                                        </div>
                                        @error('applicable_taxes_amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-3 col-12">
                                        <input type="checkbox" class="custom-checkbox" id="cleaning-fee"
                                            name="apply_cleaning_fee"
                                            {{ old('apply_cleaning_fee', !empty($vendor->metadata->cleaning_fee_amount) ? 1 : 0) ? 'checked' : '' }}>
                                        <label class="form-label" for="cleaning-fee">Apply Cleaning Fee</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="cleaning-fee-amount"
                                                name="cleaning_fee_amount"
                                                value="{{ old('cleaning_fee_amount', !empty($vendor->metadata->cleaning_fee_amount) ? $vendor->metadata->cleaning_fee_amount : '') }}"
                                                placeholder="Enter Cleaning Fee" step="0.01">
                                        </div>
                                        @error('cleaning_fee_amount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-3 col-12">
                                        <input type="checkbox" class="custom-checkbox" id="pet-boarding"
                                            name="apply_pet_boarding"
                                            {{ old('apply_pet_boarding', !empty($vendor->metadata->pet_boarding) ? 1 : 0) ? 'checked' : '' }}>
                                        <label class="form-label" for="pet-boarding">Pet Boarding</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="pet-boarding-amount"
                                                name="pet_boarding"
                                                value="{{ old('pet_boarding', !empty($vendor->metadata->pet_boarding) ? $vendor->metadata->pet_boarding : '') }}"
                                                placeholder="Enter Pet Boarding Fee" step="0.01">
                                        </div>
                                        @error('pet_boarding')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-sm-4 col-12">
                                        <label class="form-label">Host*</label>
                                        <input type="text" name="host"
                                            value="{{ old('host', !empty($vendor->host) ? $vendor->host : '') }}"
                                            class="form-control" id="host" placeholder="Host"
                                            @error('host') is-invalid @enderror>
                                        @error('host')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-4 col-12">
                                        <label class="form-label">Check-in Start Time*</label>
                                        <input type="text" id="checkin_start_time"
                                            class="form-control @error('checkin_start_time') is-invalid @enderror"
                                            name="checkin_start_time"
                                            value="{{ old('checkin_start_time', !empty($vendor->accommodationMetadata->checkin_start_time) ? Carbon::createFromFormat('H:i:s', $vendor->accommodationMetadata->checkin_start_time)->format('h:i a') : '') }}"
                                            placeholder="Enter Check-in Start Time" readonly>
                                        @error('checkin_start_time')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-sm-4 col-12">
                                        <label class="form-label">Checkout Time*</label>
                                        <input type="text" id="checkout_time"
                                            class="form-control @error('checkout_time') is-invalid @enderror"
                                            name="checkout_time"
                                            value="{{ old('checkout_time', !empty($vendor->accommodationMetadata->checkout_time) ? Carbon::createFromFormat('H:i:s', $vendor->accommodationMetadata->checkout_time)->format('h:i a') : '') }}"
                                            placeholder="Enter Checkout Time" readonly>
                                        @error('checkout_time')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @else
                                <div class="row mt-3">
                                    <div class="col-sm-6 col-12">
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
                                    @if (strtolower($vendor->vendor_type) == 'winery')
                                        <div class="col-sm-6 col-12">
                                            <input type="checkbox" class="custom-checkbox" id="applicable-vendor-taxes"
                                                name="apply_applicable_taxes"
                                                {{ old('apply_applicable_taxes', !empty($vendor->metadata->applicable_vendor_taxes_amount) ? 1 : 0) ? 'checked' : '' }}>
                                            <label class="form-label" for="applicable-vendor-taxes">Alcohol Taxes</label>
                                            <div class="input-group">
                                                <span class="input-group-text">%</span>
                                                <input type="number" class="form-control" id="applicable-taxes-amount"
                                                    name="applicable_vendor_taxes_amount"
                                                    value="{{ old('applicable_vendor_taxes_amount', !empty($vendor->metadata->applicable_vendor_taxes_amount) ? $vendor->metadata->applicable_vendor_taxes_amount : '') }}"
                                                    placeholder="Enter B2C Applicable Taxes">
                                            </div>
                                            @error('applicable_vendor_taxes_amount')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif
                                </div>
                            @endif
                            <div class="row mt-5">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn wine-btn">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-sm-12">
                <div class="information-box">
                    <div class="information-box-head">
                        <div class="box-head-heading d-flex">
                            <span class="box-head-label theme-color">Refund Policy</span>
                        </div>
                    </div>
                    <div class="information-box-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form action="{{ route('vendor-settings-policy', ['vendorid' => $vendor->id]) }}" method="post">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-12">
                                    <input type="radio" class="custom-radio" id="no-cancel-policy" name="policy"
                                        value="no-cancel"
                                        {{ old('policy', $vendor->policy) == 'no-cancel' ? 'checked' : '' }}>
                                    <label class="form-label" for="no-cancel-policy">No Cancellation</label>
                                    <p style="font-size: 16px;padding-left: 30px;">A full refund minus transaction fees
                                        will be issued upon request up to 24 hours prior to the check-in date indicated.</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <input type="radio" class="custom-radio" id="one-day-policy" name="policy"
                                        value="one-day"
                                        {{ old('policy', $vendor->policy) == 'one-day' ? 'checked' : '' }}>
                                    <label class="form-label" for="one-day-policy">24 Hours Cancellation</label>
                                    <p style="font-size: 16px;padding-left: 30px;">A full refund minus transaction fees
                                        will be issued upon request up to 7 days prior to the check-in date indicated. No
                                        refund will be issued for cancellations that fall within that 7-day period prior to
                                        the check-in date. A credit or rain cheque may be issued to guests at the vendor’s
                                        discretion.</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <input type="radio" class="custom-radio" id="seven-day-policy" name="policy"
                                        value="seven-day"
                                        {{ old('policy', $vendor->policy) == 'seven-day' ? 'checked' : '' }}>
                                    <label class="form-label" for="seven-day-policy">7 Days Cancellation</label>
                                    <p style="font-size: 16px;padding-left: 30px;">All bookings are final. No portion of
                                        your transaction will be refunded. A credit or rain cheque may be issued by the
                                        subject vendor at the vendor’s discretion.</p>
                                </div>
                            </div>
                            @error('policy')
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <span class="text-danger">{{ $message }}</span>
                                    </div>
                                </div>
                            @enderror
                            <div class="row mt-5">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn wine-btn">Save</button>
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
    </script>


@endsection
@section('js')
    <script>
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
    </script>
