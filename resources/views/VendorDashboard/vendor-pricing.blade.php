@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Vendor Dashboard')

@section('content')
    <div class="col right-side">
        <div class="row">
            <div class="col-sm-12">
                <div class="information-box">
                    <div class="information-box-head">
                        <div class="box-head-heading d-flex">
                            <span class="box-head-label theme-color">Pricing</span>
                        </div>
                    </div>
                    <div class="information-box-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <form action="{{ route('vendor-pricing-update', ['vendorid' => $vendor->id]) }}" method="post">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Spring</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="text" class="form-control @error('spring') is-invalid @enderror" name="spring" id="spring" value="{{ old('spring', $vendor->pricing->spring ?? '') }}" placeholder="Enter Spring rate">
                                    </div>
                                    @error('spring')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Summer</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="text" class="form-control @error('summer') is-invalid @enderror" name="summer" id="summer" value="{{ old('summer', $vendor->pricing->summer ?? '') }}" placeholder="Enter Summer rate">
                                    </div>
                                    @error('summer')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Fall</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="text" class="form-control @error('fall') is-invalid @enderror" name="fall" id="fall" value="{{ old('fall', $vendor->pricing->fall ?? '') }}" placeholder="Enter Fall rate">
                                    </div>
                                    @error('fall')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Winter</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="text" class="form-control @error('winter') is-invalid @enderror" name="winter" id="winter" value="{{ old('winter', $vendor->pricing->winter ?? '') }}" placeholder="Enter Winter rate">
                                    </div>
                                    @error('winter')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <input type="checkbox" class="custom-checkbox" id="sale-pricing" name="special_price" value="1" @if(old('special_price', $vendor->pricing->special_price ?? false))  checked @endif>
                                    <label class="form-label" for="sale-pricing">Special Price <span class="theme-color">(Discount)</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="text" class="form-control @error('special_price_value') is-invalid @enderror" name="special_price_value" id="special_price_value" value="{{ old('special_price_value', $vendor->pricing->special_price_value ?? '') }}" placeholder="Enter Special rate">
                                    </div>
                                    @error('special_price_value')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-3 col-12">
                                    <label class="form-label">Current Rate</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="text" class="form-control currency-input" id="current_rate" name="current_rate" value="{{ old('current_rate', $vendor->pricing->current_rate ?? 0) }}" placeholder="Enter Current Rate">
                                    </div>
                                    @error('current_rate')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-3 col-12">
                                    <label class="form-label">Extension</label>
                                    <select name="extension" id="extension" class="form-control @error('extension') is-invalid @enderror">
                                        <option value="/Night" @if(old('extension', $vendor->pricing->extension ?? '') == '/Night') selected @endif>/Night</option>
                                    </select>
                                    @error('extension')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
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
    </div>

@endsection
@section('js')
<script>
        document.addEventListener('DOMContentLoaded', function () {
            var numericFields = ['spring', 'summer', 'fall', 'winter', 'special_price_value'];

            numericFields.forEach(function(fieldId) {
                var field = document.getElementById(fieldId);

                field.addEventListener('input', function (e) {
                    var value = e.target.value;

                    // Remove non-numeric characters except for the decimal point
                    value = value.replace(/[^0-9.]/g, '');

                    // Ensure only one decimal point and restrict to two decimal places
                    var parts = value.split('.');
                    if (parts.length > 2) {
                        value = parts[0] + '.' + parts[1];
                    }
                    if (parts.length > 1 && parts[1].length > 2) {
                        value = parts[0] + '.' + parts[1].slice(0, 2);
                    }

                    e.target.value = value;
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            var salePricingCheckbox = document.getElementById('sale-pricing');
            var specialPriceValue = document.getElementById('special_price_value');

            function toggleFields() {
                var isChecked = salePricingCheckbox.checked;
                specialPriceValue.disabled = !isChecked;
            }

            // Initial state based on the checkbox's state on page load
            toggleFields();

            // Toggle fields on checkbox change
            salePricingCheckbox.addEventListener('change', toggleFields);
        });
</script>