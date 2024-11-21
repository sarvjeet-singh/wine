@extends('FrontEnd.layouts.mainapp')

@section('content')
    <style>
        .detail-form-sec .sub-type-radio {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 30px 10px;
        }
    </style>
    <div class="main-container">
        <form class="row g-sm-3 g-2" action="{{ route('save.winery') }}" method="post">
            @csrf
            <!--========== Business/Vendor Detail Form Start ==========-->
            <section class="detail-form-sec mt-5 mb-md-5 mb-4">
                <div class="container">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="sec-head px-md-5 px-4 py-3">
                        <h6 class="theme-color mb-0 fw-bold">Business/Vendor Details</h6>
                    </div>
                    <div class="sec-form px-md-5 px-4 py-4">
                        <div class="row g-sm-3 g-2 mb-3">
                            <div class="col-md-6">
                                <label for="businessName" class="form-label">Business/Vendor Name*</label>
                                <input type="text" class="form-control @error('vendor_name') is-invalid @enderror"
                                    name="vendor_name" placeholder="Business/Vendor Name" value="{{ old('vendor_name') }}">
                                @error('vendor_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="streetAddress" class="form-label">Street Address*</label>
                                    <input type="text" class="form-control @error('street_address') is-invalid @enderror"
                                        name="street_address" placeholder="Street Address"
                                        value="{{ old('street_address') }}">
                                    @error('street_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <input class="form-check-input @error('hide_street_address') is-invalid @enderror"
                                        type="checkbox" id="hideStreetAddress" name="hide_street_address"
                                        {{ old('hide_street_address') ? 'checked' : '' }}>
                                    <label class="check-label" for="form-check-label">Check this box to hide street
                                        address</label>
                                    @error('hide_street_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="unitsuite" class="form-label">Unit/Suite#</label>
                                <input type="text" class="form-control @error('unitsuite') is-invalid @enderror"
                                    name="unitsuite" placeholder="Unit/Suite#" value="{{ old('unitsuite') }}">
                                @error('unitsuite')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="city" class="form-label">City/Town*</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror"
                                    name="city" placeholder="City/Town" value="{{ old('city') }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="province" class="form-label">Provience/State*</label>
                                <input type="text" class="form-control @error('province') is-invalid @enderror"
                                    name="province" placeholder="Province/State" value="{{ old('province') }}">
                                @error('province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="postalCode" class="form-label">Postal/Zip*</label>
                                <input type="text" class="form-control @error('postalCode') is-invalid @enderror"
                                    name="postalCode" placeholder="Postal/Zip"
                                    value="{{ old('postalCode') }}"placeholder="Please enter Postal/Zip" maxlength="7"
                                    oninput="formatPostalCode(this)">
                                @error('postalCode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="country" class="form-label">Country*</label>
                                <input type="text" class="form-control" name="country"
                                    value="{{ old('country', Auth::user()->country ?? 'CA') }}" placeholder="Enter Country"
                                    readonly>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--========== Business/Vendor Detail Form End ==========-->

            <!--========== Sub Region Form Start ==========-->
            <section class="detail-form-sec mb-5">
                <div class="container">
                    <div class="sec-head px-md-5 px-4 py-3">
                        <h6 class="theme-color mb-0 fw-bold">Sub Region*</h6>
                    </div>
                    <div class="sec-form px-md-5 px-4 py-4">
                        <div class="row g-sm-3 g-2 mb-3">
                            <div class="col-md-4">
                                <div class="sub-type-radio d-block">
                                    <div class="d-flex align-items-baseline gap-2 mb-3">
                                        <input class="form-check-input @error('sub_region') is-invalid @enderror"
                                            type="radio" name="sub_region" id="niagara_falls" value="Niagara Falls"
                                            {{ old('sub_region') == 'Niagara Falls' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="niagara_falls">Niagara Falls</label>
                                    </div>
                                    <div class="d-flex align-items-baseline gap-2 mb-3">
                                        <input class="form-check-input @error('sub_region') is-invalid @enderror"
                                            type="radio" name="sub_region" id="SouthEscarpment"
                                            value="South Escarpment"
                                            {{ old('sub_region') == 'South Escarpment' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="SouthEscarpment">South Escarpment</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="sub-type-radio d-block">
                                    <div class="d-flex align-items-baseline gap-2 mb-3">
                                        <input class="form-check-input @error('sub_region') is-invalid @enderror"
                                            type="radio" name="sub_region" id="niagara_lake"
                                            value="Niagara-on-the-Lake"
                                            {{ old('sub_region') == 'Niagara-on-the-Lake' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="niagara_lake">Niagara-on-the-Lake</label>
                                    </div>
                                    <div class="d-flex align-items-baseline gap-2">
                                        <input class="form-check-input @error('sub_region') is-invalid @enderror"
                                            type="radio" name="sub_region" id="Fort_niagara_south_coast"
                                            value="Fort Erie/ Niagara South Coast"
                                            {{ old('sub_region') == 'Fort Erie/ Niagara South Coast' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="Fort_niagara_south_coast">Fort Erie/ Niagara
                                            South Coast</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="sub-type-radio d-block">
                                    <div class="d-flex align-items-baseline gap-2">
                                        <input class="form-check-input @error('sub_region') is-invalid @enderror"
                                            type="radio" name="sub_region" id="niagara_escarpment_twenty"
                                            value="Niagara Escarpment/ Twenty Valley"
                                            {{ old('sub_region') == 'Niagara Escarpment/ Twenty Valley' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="niagara_escarpment_twenty">Niagara
                                            Escarpment/ Twenty Valley</label>
                                    </div>
                                </div>
                            </div>
                            @error('sub_region')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </section>
            <!--========== Sub Region Details Form End ==========-->

            <!--========== Accommodation Detail Form Start ==========-->
            <section class="detail-form-sec mb-5">
                <div class="container">
                    <div class="sec-head px-md-5 px-4 py-3">
                        <h6 class="theme-color mb-0 fw-bold">Winery Details*</h6>
                    </div>
                    <div class="sec-form px-md-5 px-4 py-4">

                        <div class="row g-sm-3 g-2 mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Winery Sub Type</label>
                                <div class="sub-type-radio">
                                    <div class="d-flex align-items-baseline gap-2">
                                        <input class="form-check-input @error('vendor_sub_category') is-invalid @enderror"
                                            type="radio" name="vendor_sub_category" id="destination"
                                            value="Destination"
                                            {{ old('vendor_sub_category') == 'Destination' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="destination">Destination</label>
                                    </div>
                                    <div class="d-flex align-items-baseline gap-2">
                                        <input class="form-check-input @error('vendor_sub_category') is-invalid @enderror"
                                            type="radio" name="vendor_sub_category" id="vineyard" value="Vineyard"
                                            {{ old('vendor_sub_category') == 'Vineyard' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="vineyard">Vineyard</label>
                                    </div>
                                    <div class="d-flex align-items-baseline gap-2">
                                        <input class="form-check-input @error('vendor_sub_category') is-invalid @enderror"
                                            type="radio" name="vendor_sub_category" id="cellar" value="Cellar"
                                            {{ old('vendor_sub_category') == 'Vacation Property (Entire Home)' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cellar">Cellar</label>
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="sub-type-radio">
                                    <div class="d-flex align-items-baseline gap-2">
                                        <input class="form-check-input @error('vendor_sub_category') is-invalid @enderror"
                                            type="radio" name="vendor_sub_category" id="farm" value="Farm"
                                            {{ old('vendor_sub_category') == 'Farm' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="farm">Farm</label>
                                    </div>
                                    <div class="d-flex align-items-baseline gap-2">
                                        <input class="form-check-input @error('vendor_sub_category') is-invalid @enderror"
                                            type="radio" name="vendor_sub_category" id="microurban"
                                            value="Micro / Urban"
                                            {{ old('vendor_sub_category') == 'Motel' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="micro_urban">Micro / Urban</label>
                                    </div>

                                </div>
                                @error('vendor_sub_category')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <label class="form-label">Tasting Options</label>
                            <div class="col-md-12">
                                <div class="sub-type-radio">
                                    <div class="d-flex align-items-baseline gap-2">

                                        <input class="form-check-input @error('tasting_options') is-invalid @enderror"
                                            type="radio" name="tasting_options" id="appointment_only"
                                            value="Appointment Only"
                                            {{ old('tasting_options') == 'Appointment Only' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="appointment_only">Appointment Only</label>

                                    </div>
                                    <div class="d-flex align-items-baseline gap-2">
                                        <input class="form-check-input @error('tasting_options') is-invalid @enderror"
                                            type="radio" name="tasting_options" id="drop_welcome"
                                            value="Drop-Ins Welcome"
                                            {{ old('tasting_options') == 'Drop-Ins Welcome' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="drop_welcome">Drop-Ins Welcome</label>
                                    </div>
                                    <div class="d-flex align-items-baseline gap-2">
                                        <input class="form-check-input @error('tasting_options') is-invalid @enderror"
                                            type="radio" name="tasting_options" id="reservations_recommended"
                                            value="Reservations Recommended"
                                            {{ old('tasting_options') == 'Reservations Recommended' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="reservations_recommended">Tasting
                                            w/Pairings</label>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="sub-type-radio">
                                    <div class="d-flex align-items-baseline gap-2">

                                        <input class="form-check-input @error('tasting_options') is-invalid @enderror"
                                            type="radio" name="tasting_options" id="not_offered" value="Not Offered"
                                            {{ old('tasting_options') == 'Not Offered' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="not_offered">Not Offered</label>

                                    </div>


                                </div>
                                @error('tasting_options')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3"
                                    placeholder="Description" style="height: 100px">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
            </section>
            <!--========== Accommodation Details Form End ==========-->


            <!--========== Vendor detail Form Start ==========-->
            <section class="detail-form-sec mb-md-5 mb-4">
                <div class="container">
                    <div class="sec-head px-md-5 px-4 py-3">
                        <h6 class="theme-color mb-0 fw-bold">Vendor Detail</h6>
                    </div>
                    <div class="sec-form px-md-5 px-4 py-4">
                        <div class="row g-sm-3 g-2 mb-3">
                            <div class="col-md-6">
                                <label for="vendor_first_name" class="form-label">Given Name(s)</label>
                                <input type="text"
                                    class="form-control @error('vendor_first_name') is-invalid @enderror"
                                    name="vendor_first_name" placeholder="Given Name(s)"
                                    value="{{ old('first_name') }}">
                                @error('vendor_first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="vendorlastname" class="form-label"> Last/Surname</label>
                                <input type="text"
                                    class="form-control @error('vendor_last_name') is-invalid @enderror"
                                    name="vendor_last_name" placeholder="Last/Surname"
                                    value="{{ old('vendor_last_name') }}">
                                @error('vendor_last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="businessEmail" class="form-label">eMail Address</label>
                                <input type="email" class="form-control @error('vendor_email') is-invalid @enderror"
                                    name="vendor_email" placeholder="eMail Address" value="{{ old('vendor_email') }}">
                                @error('vendor_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="vendorPhone" class="form-label">Vendor Phone number</label>
                                <input type="text"
                                    class="form-control phone-number @error('vendor_phone') is-invalid @enderror"
                                    name="vendor_phone" placeholder="Business/Vendor Phone"
                                    value="{{ old('vendor_phone') }}">
                                @error('vendor_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn book-btn">Submit</button>
                        </div>
                    </div>
                </div>

            </section>
            <!--========== Vendor Detail Form End ==========-->

        </form>
    </div>
@endsection

@section('js')
    <script>
        //Function for Postal code
        function formatPostalCode(input) {
            // Remove all non-alphanumeric characters and convert to uppercase
            let value = input.value.replace(/\W/g, '').toUpperCase();

            // Add a space after every 3 characters
            if (value.length > 3) {
                value = value.slice(0, 3) + ' ' + value.slice(3);
            }

            // Update the input value
            input.value = value;
        }
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.phone-number').forEach(function(input) {
                input.addEventListener('input', function(e) {
                    const value = e.target.value.replace(/\D/g,
                    ''); // Remove all non-digit characters
                    let formattedValue = '';
                    if (value.length > 3 && value.length <= 6) {
                        formattedValue = value.slice(0, 3) + '-' + value.slice(3);
                    } else if (value.length > 6) {
                        formattedValue = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value
                            .slice(6, 10);
                    } else {
                        formattedValue = value;
                    }
                    e.target.value = formattedValue;
                });
            });
        });
    </script>
