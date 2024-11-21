@csrf
{{ !empty($vendor) ? method_field('PUT') : method_field('POST') }}
<div class="information-box mb-3">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="info-head p-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="text-white">Business/Vendor Information</div>
        </div>
    </div>
    <div class="m-3 pb-4">
        <div class="row g-4">
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">Business/Vendor Name*</label>
                    <input type="text" class="form-control @error('vendor_name') is-invalid @enderror"
                        name="vendor_name" placeholder="Business/Vendor Name"
                        value="{{ !empty($vendor) ? $vendor->vendor_name : old('vendor_name') }}">
                    @error('vendor_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <!-- Another input can go here if needed -->
            </div>
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">Street Address*</label>
                    <input type="text" class="form-control @error('street_address') is-invalid @enderror"
                        name="street_address" placeholder="Street Address"
                        value="{{ !empty($vendor) ? $vendor->street_address : old('street_address') }}">
                    @error('street_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-check mt-2">
                        <input class="form-check-input @error('hide_street_address') is-invalid @enderror"
                            type="checkbox" id="hideStreetAddress" name="hide_street_address"
                            {{ !empty($vendor) && $vendor->hide_street_address ? 'checked' : (old('hide_street_address') ? 'checked' : '') }}>
                        <label class="check-label" for="form-check-label">Check this box to hide street address</label>
                        @error('hide_street_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">Unit/Suite#</label>
                    <input type="text" class="form-control @error('unitsuite') is-invalid @enderror" name="unitsuite"
                        placeholder="Unit/Suite#" value="{{ !empty($vendor) ? $vendor->unitsuite : old('unitsuite') }}">
                    @error('unitsuite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">City/Town*</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city"
                        placeholder="City/Town" value="{{ !empty($vendor) ? $vendor->city : old('city') }}">
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">Province/State*</label>
                    <input type="text" class="form-control @error('province') is-invalid @enderror" name="province"
                        placeholder="Province/State"
                        value="{{ !empty($vendor) ? $vendor->province : old('province') }}">
                    @error('province')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">Postal/Zip*</label>
                    <input type="text" class="form-control @error('postalCode') is-invalid @enderror"
                        name="postalCode" placeholder="Postal/Zip"
                        value="{{ !empty($vendor) ? $vendor->postalCode : old('postalCode') }}" maxlength="7"
                        oninput="formatPostalCode(this)">
                    @error('postalCode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="country" class="form-label fw-bold">Country*</label>
                    <select name="country" id="country" class="form-select" aria-label="Select a country">
                        <option value="">Select a country</option>
                        @foreach (getCountries() as $country)
                            <option value="{{ $country->id }}"
                                {{ (!empty($vendor) && $vendor->country == $country->id) || old('country') == $country->id || (empty($vendor) && old('country') === null && $country->id == 2) ? 'selected' : '' }}>
                                {{ $country->name }}
                        @endforeach
                    </select>
                    @error('country')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="region" class="form-label fw-bold">Region</label>
                    <select name="region" id="region" class="form-select" aria-label="Select a region">
                        <option value="">Select a region</option>
                        @foreach (getRegions() as $region)
                            <option value="{{ $region->id }}"
                                {{ (!empty($vendor) && $vendor->region == $region->id) || old('region') == $region->id ? 'selected' : '' }}>
                                {{ $region->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('sub_region')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="sub_region" class="form-label fw-bold">Sub-Region</label>
                    <select name="sub_region" id="sub_region" class="form-select" aria-label="Select a sub-region">
                        <option value="">Select a sub-region</option>
                        @if (!empty($vendor->region))
                            @foreach (getSubRegions($vendor->region) as $subRegion)
                                <option value="{{ $subRegion->id }}"
                                    {{ (!empty($vendor) && $vendor->sub_region == $subRegion->id) || old('sub_region') == $subRegion->id ? 'selected' : '' }}>
                                    {{ $subRegion->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('sub_region')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">Website</label>
                    <input type="text" class="form-control @error('website') is-invalid @enderror" name="website"
                        placeholder="Website url" value="{{ !empty($vendor) ? $vendor->website : old('website') }}">
                    @error('website')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">Business/Vendor Phone</label>
                    <input type="text" class="form-control @error('vendor_phone') is-invalid @enderror"
                        name="vendor_phone" id="vendor_phone" placeholder="Phone number"
                        value="{{ !empty($vendor) ? $vendor->vendor_phone : old('vendor_phone') }}">
                    @error('vendor_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">eMail</label>
                    <input type="text" class="form-control @error('vendor_email') is-invalid @enderror"
                        name="vendor_email" placeholder="Email address"
                        value="{{ !empty($vendor) ? $vendor->vendor_email : old('vendor_email') }}">
                    @error('vendor_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <div>
                    <label for="" class="form-label fw-bold">Description</label>
                    <div class="form-floating">
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3"
                            placeholder="Description" style="height: 100px">{{ !empty($vendor) ? $vendor->description : old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#vendor_phone').mask('000-000-0000');
        });
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
        $(document).ready(function() {
            const defaultRegionId = $('#region').val();
            const selectedSubRegionId =
            "{{ $vendor->sub_region ?? (old('sub_region') ?? '') }}"; // Use sub-region from DB or old value
            const subRegionDropdown = $('#sub_region');

            function loadSubRegions(regionId, selectedSubRegionId = null) {
                subRegionDropdown.html('<option value="">Loading...</option>'); // Show loading indicator

                if (regionId) {
                    $.ajax({
                        url: '/get-subregions/' + regionId, // Adjust this route as needed
                        type: 'GET',
                        success: function(response) {
                            let options = '<option value="">Select Sub-Region</option>';
                            response.forEach(subRegion => {
                                options += `<option value="${subRegion.id}" ${
                            subRegion.id == selectedSubRegionId ? 'selected' : ''
                        }>${subRegion.name}</option>`;
                            });
                            subRegionDropdown.html(options);
                        },
                        error: function() {
                            subRegionDropdown.html(
                                '<option value="">Error loading sub-regions</option>');
                        }
                    });
                } else {
                    subRegionDropdown.html('<option value="">Select Sub-Region</option>'); // Reset dropdown
                }
            }

            // Load sub-regions for default region on page load
            if (defaultRegionId) {
                loadSubRegions(defaultRegionId, selectedSubRegionId);
            }

            // Trigger on region change
            $('#region').on('change', function() {
                const regionId = $(this).val();
                loadSubRegions(regionId);
            });
        });
    </script>
@endpush
