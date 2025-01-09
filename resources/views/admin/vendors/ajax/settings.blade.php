<div class="tab-pane fade show active" id="tab-pane-setting" role="tabpanel" aria-labelledby="tab-pane-setting"
    tabindex="0">
    <!-- Business Information -->
    <div class="information-box mb-3">
        <div class="info-head p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text-white">Business Information</div>
            </div>
        </div>
        <div class="m-3 pb-3">
            <div class="row g-4">
                <form action="{{ route('admin.vendor.details.ajax-settings-update', $vendor->id) }}" method="post">
                    @csrf
                    <div class="row mt-3">
                        <div class="col-sm-6 col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('vendor_name') is-invalid @enderror"
                                    name="vendor_name" value="{{ old('vendor_name', $vendor->vendor_name) }}"
                                    placeholder="Please enter Property name">
                                <label for="vendor_name">Business/Vendor Name</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="form-floating">
                                <input type="text"
                                    class="form-control phone-number @error('vendor_phone') is-invalid @enderror"
                                    name="vendor_phone" value="{{ old('vendor_phone', $vendor->vendor_phone) }}"
                                    placeholder="Please enter Business Phone">
                                <label for="vendor_phone">Business Phone</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-6 col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('street_address') is-invalid @enderror"
                                    name="street_address" value="{{ old('street_address', $vendor->street_address) }}"
                                    placeholder="Please enter Street Address">
                                <label for="street_address">Street Address*</label>
                            </div>
                            <div class="mt-2">
                                <input class="form-check-input @error('hide_street_address') is-invalid @enderror"
                                    type="checkbox" id="hideStreetAddress" name="hide_street_address" value="1"
                                    {{ old('hide_street_address', $vendor->hide_street_address) ? 'checked' : '' }}>
                                <label class="form-check-label" for="hideStreetAddress">Check this box to hide street
                                    address</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('unitsuite') is-invalid @enderror"
                                    name="unitsuite" value="{{ old('unitsuite', $vendor->unitsuite) }}"
                                    placeholder="Please enter Unit/Suite">
                                <label for="unitsuite">Unit/Suite</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-6 col-12">
                            <div class="form-floating">
                                <select class="form-control form-select @error('country') is-invalid @enderror"
                                    name="country" id="country">
                                    <option value="">Please select a country</option>
                                    @foreach (getCountries() as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country', !empty($vendor->country) ? $vendor->country : '') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="country">Please select a country</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="form-floating">
                                <select class="form-control form-select select2 @error('province') is-invalid @enderror"
                                    name="province" id="province">
                                    @foreach (getStates(2) as $type => $items)
                                        <optgroup label="{{ ucfirst($type) }}">
                                            @foreach ($items as $state)
                                                <option value="{{ $state->name }}"
                                                    {{ collect(old('province', $vendor->province ?? 'Ontario'))->contains($state->name) ? 'selected' : '' }}>
                                                    {{ $state->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <label for="province">Province/State*</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-6 col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('city') is-invalid @enderror"
                                    name="city" value="{{ old('city', $vendor->city) }}"
                                    placeholder="Please enter City/Town">
                                <label for="city">City/Town*</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control @error('postalCode') is-invalid @enderror"
                                    name="postalCode" value="{{ old('postalCode', $vendor->postalCode) }}"
                                    placeholder="Please enter Postal/Zip" maxlength="7"
                                    oninput="formatPostalCode(this)">
                                <label for="postalCode">Postal/Zip*</label>
                            </div>
                        </div>
                    </div>



                    <div class="row mt-3">
                        <div class="col-sm-6 col-12">
                            <div class="form-floating">
                                <select name="region" id="region" class="form-control">
                                    <option value="">Please select a Region</option>
                                    @foreach (getRegions() as $region)
                                        <option value="{{ $region->id }}"
                                            {{ old('region', $vendor->region ?? '') == $region->id ? 'selected' : '' }}>
                                            {{ $region->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="region">Please select a region</label>
                            </div>
                            <div class="form-floating">
                                <select name="sub_region" id="sub_region"
                                    class="form-control @error('sub_region') is-invalid @enderror">
                                    <option value="">Please select a sub-region</option>
                                    @foreach (getSubRegions(1) as $subRegion)
                                        <option value="{{ $subRegion->id }}"
                                            {{ old('sub_region', $vendor->sub_region ?? '') == $subRegion->id ? 'selected' : '' }}>
                                            {{ $subRegion->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="region">Please select a sub-region</label>
                            </div>
                            <div class="form-floating mt-3">
                                <input type="text"
                                    class="form-control @error('vendor_email') is-invalid @enderror"
                                    name="vendor_email" value="{{ old('vendor_email', $vendor->vendor_email) }}"
                                    placeholder="Please enter Business Email">
                                <label for="vendor_email">Business Email</label>
                            </div>

                            <div class="form-floating mt-3">
                                <input type="text" class="form-control @error('website') is-invalid @enderror"
                                    name="website" value="{{ old('website', $vendor->website) }}"
                                    placeholder="Please enter Website Url">
                                <label for="website">Website URL</label>
                            </div>
                        </div>

                        <div class="col-sm-6 col-12">
                            <div class="information-box">
                                <div class="information-box-head">
                                    <div class="box-head-heading d-flex">
                                        <span class="box-head-label theme-color">Logo/Graphic</span>
                                    </div>
                                    <!--<div class="box-head-description mt-3">-->
                                    <!--    Images are limited to a 50kb file size in png or jpg formats-->
                                    <!--</div>-->
                                </div>
                                <div class="information-box-body">
                                    <div class="row mt-3">
                                        <div class="col-sm-12">
                                            <div class="box-gallary-7-images-row vendor-default-logo">
                                                <div
                                                    class="box-gallary-images-column select-box-gallary-images-column">
                                                    <label for="front_License_image" {{-- upload-button --}}
                                                        class="custom-file-label">
                                                        <!-- <img src="{{ asset('images/media-gallary/plus-icon.png') }}"
                                                                                                                                                                                    width="20"> -->
                                                        <a href="{{ route('vendor-media-gallary') }}">
                                                            <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                                        </a>
                                                    </label>
                                                </div>
                                                @php
                                                    $firstMedia = $VendorMediaGallery->where('is_default', 1)->first(); // Get the first media item
                                                @endphp

                                                @if ($firstMedia)
                                                    <div class="box-gallary-images-column position-relative">
                                                        @if ($firstMedia->vendor_media_type == 'image')
                                                            <img src="{{ asset($firstMedia->vendor_media) }}"
                                                                class="box-gallary-7-images rounded-4">
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                                    placeholder="Please enter description">{{ old('description', $vendor->description) }}</textarea>
                                <label for="description">Description</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn theme-btn px-5">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Booking Availability -->
    @if (trim(strtolower($vendor->vendor_type)) == 'accommodation')
        <div class="row mt-5">
            <div class="col-sm-12">
                <div class="information-box">
                    <div class="info-head p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="text-white">{{ ucfirst($vendor->vendor_type) ?? '' }} Details</div>
                        </div>
                    </div>
                    <div class="information-box-body">
                        @if (session('booking-success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('booking-success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form action="{{ route('vendor-settings-booking', ['vendorid' => $vendor->id]) }}"
                            method="post">
                            @csrf
                            @php
                                $disableSelect = !empty(old('inventory_type', $vendor->inventory_type));
                            @endphp
                            <div class="col-md-6">
                                <label for="inventoryType" class="form-label">Inventory Type*</label>
                                <select class="form-control @error('inventory_type') is-invalid @enderror"
                                    name="inventory_type" id="inventoryType"
                                    @if ($disableSelect) disabled @endif>
                                    <option value="">Select Inventory Type</option>
                                    @foreach ($inventoryTypes as $inventoryType)
                                        <option value="{{ $inventoryType->id }}"
                                            @if (old('inventory_type', $vendor->inventory_type) == $inventoryType->id) selected @endif>
                                            {{ $inventoryType->name }} <!-- Corrected this line -->
                                        </option>
                                    @endforeach
                                </select>
                                @error('inventory_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="roomsOptions" style="display: none;">
                                <div class="row mt-3">
                                    @if ($inventoryTypes->count() > 0 && $inventoryTypes[0]->subCategories->count() > 0)
                                        @foreach ($inventoryTypes[0]->subCategories as $subCategory)
                                            <div class="col-sm-3 col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="vendor_sub_category"
                                                        id="booking-{{ Str::slug($subCategory->name) }}"
                                                        value="{{ $subCategory->id }}"
                                                        @if (old('vendor_sub_category', $vendor->vendor_sub_category) == $subCategory->id) checked @endif>
                                                    <label class="form-check-label"
                                                        for="booking-{{ Str::slug($subCategory->name) }}">{{ $subCategory->name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div id="premisesOptions" style="display: none;">
                                <div class="row mt-3">
                                    @if ($inventoryTypes->count() > 0 && $inventoryTypes[1]->subCategories->count() > 0)
                                        @foreach ($inventoryTypes[1]->subCategories as $subCategory)
                                            <div class="col-sm-3 col-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                        name="vendor_sub_category"
                                                        id="booking-{{ Str::slug($subCategory->name) }}"
                                                        value="{{ $subCategory->id }}"
                                                        @if (old('vendor_sub_category', $vendor->vendor_sub_category) == $subCategory->id) checked @endif>
                                                    <label class="form-check-label"
                                                        for="booking-{{ Str::slug($subCategory->name) }}">{{ $subCategory->name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Total Square Footage</label>
                                    <input type="text"
                                        class="form-control numeric-input @error('square_footage') is-invalid @enderror"
                                        name="square_footage"
                                        value="{{ old('square_footage', !empty($metadata->square_footage) ? $metadata->square_footage : '') }}"
                                        placeholder="Total Square Footage">
                                    @error('square_footage')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Bedrooms*</label>
                                    <input type="text"
                                        class="form-control numeric-input @error('bedrooms') is-invalid @enderror"
                                        name="bedrooms"
                                        value="{{ old('bedrooms', !empty($metadata->bedrooms) ? $metadata->bedrooms : '') }}"
                                        placeholder="Bedrooms">
                                    @error('bedrooms')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Washrooms*</label>
                                    <input type="text"
                                        class="form-control numeric-input @error('washrooms') is-invalid @enderror"
                                        name="washrooms"
                                        value="{{ old('washrooms', !empty($metadata->washrooms) ? $metadata->washrooms : '') }}"
                                        placeholder="Washrooms">

                                    @error('washrooms')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="beds" class="form-label">Beds*</label>
                                    <input type="text" name="beds"
                                        class="form-control @error('beds') is-invalid @enderror"
                                        value="{{ old('beds', !empty($metadata->beds) ? $metadata->beds : '') }}"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    @error('beds')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label for="sleeps" class="form-label">Sleeps*</label>
                                    <input type="text" name="sleeps"
                                        class="form-control @error('sleeps') is-invalid @enderror"
                                        value="{{ old('sleeps', !empty($metadata->sleeps) ? $metadata->sleeps : '') }}"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    @error('sleeps')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
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
    @endif
    @if (trim(strtolower($vendor->vendor_type)) != 'accommodation')
        <div class="row mt-5">
            <div class="col-sm-12">
                <div class="information-box p-0">
                    @if (session('booking-success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('booking-success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="information-box-head">
                        <div class="info-head p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-white">{{ ucfirst($vendor->vendor_type) ?? '' }} Details</div>
                            </div>
                        </div>
                    </div>
                    <div class="information-box-body">
                        <form action="{{ route('vendor.metadata.update', $vendor->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <!-- Add method="PUT" if you are updating -->
                            <div class="row g-3 mt-1">
                                <div class="col-12">
                                    <div>
                                        <label for="vendor_sub_category"
                                            class="form-label fw-bold">{{ ucfirst($vendor->vendor_type) }}
                                            Sub-Type*</label>
                                    </div>
                                    <div class="row">
                                        @if (count($subCategories) > 0)
                                            @foreach ($subCategories as $subCategory)
                                                <div class="col-lg-6 col-12">
                                                    <div class="form-check mb-3" style="min-height: 70px;">
                                                        <input class="form-check-input" type="radio"
                                                            name="vendor_sub_category"
                                                            id="vendor_sub_category_{{ $subCategory->id }}"
                                                            value="{{ $subCategory->id }}"
                                                            {{ old('vendor_sub_category', $vendor->vendor_sub_category) == $subCategory->id ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="vendor_sub_category_{{ $subCategory->id }}">
                                                            {{ $subCategory->name }}
                                                        </label>
                                                        <div class="fs-7">
                                                            <!-- You can customize this description or add more subcategory details -->
                                                            {{ $subCategory->description ?? '' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                @if (strtolower($vendor->vendor_type) != 'licensed')
                                    <div class="col-12">
                                        <div>
                                            <label for="farming_practices" class="form-label fw-bold">Farming
                                                Practices</label>
                                        </div>
                                        <div class="row">
                                            @if (count(getFarmingPractices()) > 0)
                                                @foreach (getFarmingPractices() as $farmingPractice)
                                                    <div class="col-lg-6 col-12">
                                                        <div class="form-check mb-3" style="min-height: 70px;">
                                                            <input class="form-check-input" type="radio"
                                                                name="farming_practices"
                                                                id="farming_practice_{{ $farmingPractice['id'] }}"
                                                                value="{{ $farmingPractice['id'] }}"
                                                                {{ old('farming_practices', isset($metadata->farming_practices) ? $metadata->farming_practices : '') == $farmingPractice['id'] ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="farming_practice_{{ $farmingPractice['id'] }}">
                                                                {{ $farmingPractice['name'] }}
                                                            </label>
                                                            <div class="fs-7">
                                                                <!-- Add a description if available -->
                                                                {{ $farmingPractice['description'] ?? 'No additional details available.' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @if (strtolower($vendor->vendor_type) == 'winery')
                                    <div class="col-md-6">
                                        <div>
                                            <label for="tasting_options" class="form-label fw-bold">Tasting
                                                Options</label>
                                            <select class="form-select" name="tasting_options" id="tasting_options">
                                                <option value="">Select</option>
                                                @foreach (getTastingOptions() as $tastingOption)
                                                    <option value="{{ $tastingOption['id'] }}"
                                                        {{ old('tasting_options', isset($metadata->tasting_options) ? $metadata->tasting_options : '') == $tastingOption['id'] ? 'selected' : '' }}>
                                                        {{ $tastingOption['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                @if (strtolower($vendor->vendor_type) == 'excursion')
                                    <div class="col-md-6">
                                        <div>
                                            <label for="establishment"
                                                class="form-label fw-bold">Establishment/Facility</label>
                                            <select class="form-select" name="establishment" id="establishment">
                                                <option value="">Select</option>
                                                @foreach (getEstablishments() as $establishment)
                                                    <option value="{{ $establishment['id'] }}"
                                                        {{ old('establishment', isset($metadata->establishment) ? $metadata->establishment : '') == $establishment['id'] ? 'selected' : '' }}>
                                                        {{ $establishment['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <div>
                                        <label for="max_group" class="form-label fw-bold">Max Group</label>
                                        <select class="form-select" name="max_group" id="max_group">
                                            <option value="">Select group</option>
                                            @foreach (getMaxGroups() as $maxGroup)
                                                <option value="{{ $maxGroup['id'] }}"
                                                    {{ old('max_group', isset($metadata->max_group) ? $metadata->max_group : '') == $maxGroup['id'] ? 'selected' : '' }}>
                                                    {{ $maxGroup['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div>
                                        <label for="multiple-select" class="form-label fw-bold">Cuisine</label>
                                        <select id="multiple-select" class="form-select" name="cuisines[]" multiple>
                                            @foreach (getCuisines() as $cuisine)
                                                <option value="{{ $cuisine['id'] }}"
                                                    {{ collect(old('cuisines', !empty($vendor) && isset($metadata->cuisines) ? json_decode($metadata->cuisines, true) : []))->contains($cuisine['id']) ? 'selected' : '' }}>
                                                    {{ $cuisine['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn wine-btn">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
<script src="{{ asset('asset/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#multiple-select').select2({
            placeholder: 'Select cuisines...',
            width: '100%'
        });
        $('#province').select2({
            placeholder: "Select Province/State",
            allowClear: true,
            width: '100%',
            dropdownCssClass: 'select2-dropdown-searchable'
        });
        // Listen for country dropdown change
        $('#country').change(function() {
            let countryId = $(this).val();

            if (countryId) {
                $.ajax({
                    url: '{{ route('get.states') }}', // Endpoint for fetching states
                    type: 'GET',
                    data: {
                        country_id: countryId
                    },
                    success: function(response) {
                        let stateDropdown = $('#province');
                        stateDropdown.empty(); // Clear existing options

                        if (response.success) {
                            // Populate states
                            $.each(response.states, function(type, states) {
                                // Add optgroup for each type (province, state)
                                let group = $('<optgroup>', {
                                    label: capitalizeFirstLetter(type)
                                });
                                $.each(states, function(index, state) {
                                    group.append($('<option>', {
                                        value: state.id,
                                        text: state.name
                                    }));
                                });
                                stateDropdown.append(group);
                            });
                        } else {
                            stateDropdown.append('<option>No states available</option>');
                        }
                    },
                    error: function() {
                        alert('Failed to load states. Please try again.');
                    }
                });
            }
        });
    });

    function capitalizeFirstLetter(string) {
        if (!string) return ''; // Handle empty or null strings
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
    $(document).ready(function() {
        $('#region').on('change', function() {
            var regionId = $(this).val(); // Get selected region ID
            var subRegionSelect = $('#sub_region'); // Sub-region dropdown
            subRegionSelect.empty(); // Clear the current options
            subRegionSelect.append('<option value="">Loading...</option>'); // Show loading text

            if (regionId) {
                $.ajax({
                    url: '{{ route('get.subregions', ['regionId' => ':regionId']) }}'.replace(
                        ':regionId', regionId), // Adjust the URL to your route
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        subRegionSelect.empty(); // Clear and load new options
                        subRegionSelect.append(
                            '<option value="">Please select a sub-region</option>');

                        $.each(data, function(key, subRegion) {
                            subRegionSelect.append('<option value="' + subRegion
                                .id + '">' + subRegion.name + '</option>');
                        });
                    },
                    error: function() {
                        subRegionSelect.empty();
                        subRegionSelect.append(
                            '<option value="">Failed to load sub-regions</option>');
                    }
                });
            } else {
                subRegionSelect.empty();
                subRegionSelect.append('<option value="">Please select a sub-region</option>');
            }
        });
    });
</script>
