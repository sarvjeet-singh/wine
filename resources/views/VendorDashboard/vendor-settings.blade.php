@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Vendor Dashboard')

@section('css')
    <link rel="stylesheet" href="{{ asset('asset/css/select2.min.css') }}">
    <style>
        /* Style for the button loader */
        .loader-btn {
            position: absolute;
            /* Absolute positioning */
            top: 50%;
            /* Vertically center the loader */
            left: 50%;
            /* Horizontally center the loader */
            transform: translate(-50%, -50%);
            /* Fine-tune centering */
            width: 20px;
            height: 20px;
            display: none;
            /* Hidden by default */
        }

        /* Loader spinner style */
        .loader-btn .spinner {
            border: 2px solid #f3f3f3;
            /* Light grey */
            border-top: 2px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 100%;
            height: 100%;
            animation: spin 1s linear infinite;
        }

        /* Spinner animation */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Button with relative position to hold the spinner */
        .upload-image-youtube-button {
            position: relative;
            padding-right: 30px;
            /* Make room for the spinner */
            min-width: 100px;
            /* Ensure the button has a minimum width */
            height: 40px;
            /* Set a fixed height for consistency */
        }

        .select2 span.select2-selection {
            padding-bottom: 0;
            border-radius: 6px;
        }

        .select2 ul.select2-selection__rendered {
            padding: 0 !important;
        }

        .select2 span.select2-selection span.select2-search {
            height: 36px;
            display: inline-block;
        }

        .select2 span.select2-selection textarea.select2-search__field {
            margin-block: 0;
            height: 15px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            margin-bottom: 5px;
        }
    </style>
@endsection
@section('content')
    <div class="col right-side">

        <div class="row">
            <div class="col-sm-12">
                <div class="information-box">
                    <div class="information-box-head">
                        <div class="box-head-heading d-flex">
                            <span class="box-head-label theme-color">Business Information</span>
                        </div>
                    </div>
                    <div class="information-box-body">
                        @if (session('property-success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('property-success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form action="{{ route('vendor-settings-property-details', ['vendorid' => $vendor->id]) }}"
                            method="post">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Business/Vendor Name*</label>
                                    <input type="text" class="form-control @error('vendor_name') is-invalid @enderror"
                                        name="vendor_name" value="{{ old('vendor_name', $vendor->vendor_name) }}"
                                        placeholder="Please enter Property name">
                                    @error('vendor_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-6 col-12">
                                    <div>
                                        <label class="form-label">Business/Vendor Phone</label>
                                        <input type="text"
                                            class="form-control phone-number @error('vendor_phone') is-invalid @enderror"
                                            name="vendor_phone" value="{{ old('vendor_phone', $vendor->vendor_phone) }}"
                                            placeholder="Please enter Business Phone">
                                        @error('vendor_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Street Address*</label>
                                    <input type="text" class="form-control @error('street_address') is-invalid @enderror"
                                        name="street_address" value="{{ old('street_address', $vendor->street_address) }}"
                                        placeholder="Please enter Street Address">
                                    @error('street_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="mt-2">
                                        <input class="form-check-input @error('hide_street_address') is-invalid @enderror"
                                            type="checkbox" id="hideStreetAddress" name="hide_street_address" value="1"
                                            {{ old('hide_street_address', $vendor->hide_street_address) ? 'checked' : '' }}>
                                        <label class="check-label" for="form-check-label">Hide street address in
                                            profile</label>
                                        @error('hide_street_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Unit/Suite#</label>
                                    <input type="text" class="form-control @error('unitsuite') is-invalid @enderror"
                                        name="unitsuite" value="{{ old('unitsuite', $vendor->unitsuite) }}"
                                        placeholder="Please enter Unit/Suite">
                                    @error('unitsuite')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Country*</label>
                                    <select class="form-control @error('country') is-invalid @enderror" name="country"
                                        id="country">
                                        <option value="">Please select a country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ old('country', !empty($vendor->country) ? $vendor->country : '') == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label for="province" class="form-label fw-bold">Province/State*</label>
                                    <select class="form-control select2 @error('province') is-invalid @enderror"
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
                                    @error('province')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">City/Town*</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                                        name="city" value="{{ old('city', $vendor->city) }}"
                                        placeholder="Please enter City/Town">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Postal/Zip*</label>
                                    <input type="text" class="form-control @error('postalCode') is-invalid @enderror"
                                        name="postalCode" value="{{ old('postalCode', $vendor->postalCode) }}"
                                        placeholder="Please enter Postal/Zip" maxlength="7"
                                        oninput="formatPostalCode(this)">
                                    @error('postalCode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <div>
                                        <label class="form-label">Region</label>
                                        <select name="region" id="region" class="form-control">
                                            <option value="">Please select a Region</option>
                                            @foreach (getRegions() as $region)
                                                <option value="{{ $region->id }}"
                                                    {{ old('region', $vendor->region ?? '') == $region->id ? 'selected' : '' }}>
                                                    {{ $region->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('region')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mt-3">
                                        <label class="form-label">Sub-Region</label>
                                        <select name="sub_region" id="sub_region"
                                            class="form-control @error('sub_region') is-invalid @enderror">
                                            <option value="">Please select a sub-region</option>
                                            @foreach ($subRegions as $subRegion)
                                                <option value="{{ $subRegion->id }}"
                                                    {{ old('sub_region', $vendor->sub_region ?? '') == $subRegion->id ? 'selected' : '' }}>
                                                    {{ $subRegion->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sub_region')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">Website URL</label>
                                        <input type="text" class="form-control @error('website') is-invalid @enderror"
                                            name="website" value="{{ old('website', $vendor->website) }}"
                                            placeholder="Please enter Website Url">
                                        @error('website')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">eMail</label>
                                        <input type="text"
                                            class="form-control @error('vendor_email') is-invalid @enderror"
                                            name="vendor_email" value="{{ old('vendor_email', $vendor->vendor_email) }}"
                                            placeholder="Please enter Business Email">
                                        @error('vendor_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                                            $firstMedia = $VendorMediaGallery
                                                                ->where('is_default', 1)
                                                                ->first(); // Get the first media item
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
                            @if (strtolower($vendor->vendor_type) == 'licensed')
                                <div class="row mt-3">
                                    <div class="col-sm-6 col-12">
                                        <label class="form-label">Licensee #</label>
                                        <input type="text"
                                            class="form-control @error('license_number') is-invalid @enderror"
                                            name="license_number" maxlength="20"
                                            value="{{ old('license_number', !empty($metadata->license_number) ? $metadata->license_number : '') }}"
                                            placeholder="Please enter License Number">
                                        @error('license_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="form-label">License Expiry Date #</label>
                                        <input type="date"
                                            class="form-control @error('license_expiry_date') is-invalid @enderror"
                                            name="license_expiry_date"
                                            value="{{ old('license_expiry_date', !empty($metadata->license_expiry_date) ? $metadata->license_expiry_date : '') }}"
                                            placeholder="Please enter License Expiry Date">
                                        @error('license_expiry_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            <div class="row mt-3">
                                <div class="col-12">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description"
                                        placeholder="Please enter description">{{ old('description', $vendor->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
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
        @if (trim(strtolower($vendor->vendor_type)) == 'accommodation')
            <div class="row mt-5">
                <div class="col-sm-12">
                    <div class="information-box">
                        <div class="information-box-head">
                            <div class="box-head-heading d-flex">
                                <span class="box-head-label theme-color">Accommodation Details</span>
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
                            <div class="box-head-heading d-flex">
                                <span class="box-head-label theme-color">{{ ucfirst($vendor->vendor_type) }}
                                    Details</span>
                            </div>
                        </div>
                        <div class="information-box-body">
                            <form action="{{ route('vendor.metadata.update', $vendor->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <!-- Add method="PUT" if you are updating -->
                                <div class="row g-3 mt-1">
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="vendor_sub_category"
                                                class="form-label fw-bold">{{ ucfirst($vendor->vendor_type) }}
                                                Sub-Type*</label>
                                        </div>
                                        <div class="row">
                                            @if (count($subCategories) > 0)
                                                @foreach ($subCategories as $subCategory)
                                                    <div class="col-lg-6 col-12">
                                                        <div class="form-check mb-3">
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
                                                @if (count($farmingPractices) > 0)
                                                    @foreach ($farmingPractices as $farmingPractice)
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
                                                    @foreach ($tastingOptions as $tastingOption)
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
                                                    @foreach ($establishments as $establishment)
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
                                                @foreach ($maxGroups as $maxGroup)
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
                                                @foreach ($cuisines as $cuisine)
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
    <div class="modal mediaGalleryModal fade" id="editMediaModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-sm-4 p-2">
                <div class="modal-header border-0">
                    <h3 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Edit Media Gallery</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('vendor.upload_vendor_logo', ['vendorid' => $vendor->id]) }}"
                        id="upload_media">
                        @csrf
                        <input type="hidden" value="" name="vendorImage" class="base64imageupload">

                        <div class="mb-5 image_section">
                            <label class="form-label">Add Photo/Video</label>
                            <div class="position-relative select_image_section">
                                <label class="custom-file-label" for="upload_photo_video">
                                    <!-- <img src="{{ asset('images/media-gallary/plus-icon.png') }}" width="20"> -->
                                    <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                </label>
                                <input type="file" accept="image/*" class="custom-file-input"
                                    id="upload_photo_video">
                            </div>
                            <div class="profile-image-upload-section"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn save-btn upload-image-youtube-button">
                        <span class="btn-text">Save</span>
                        <div class="loader-btn" style="display: none;">
                            <div class="spinner"></div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cropImage" tabindex="-1" role="dialog" aria-labelledby="cropImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Profie Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 profile-image-upload-section">
                        <img class="image" style="Width:100%">
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                    <button type="button" class="btn btn-primary image-crop">Crop & Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        //function for Current rate
        $(document).ready(function() {
            $('.currency-input').on('input', function() {
                var value = $(this).val();

                // Remove non-numeric characters except for the decimal point
                value = value.replace(/[^0-9.]/g, '');

                // Ensure only one decimal point and restrict to two decimal places
                var parts = value.split('.');
                if (parts.length > 2) {
                    value = parts[0] + '.' + parts.slice(1).join('');
                }
                if (parts.length > 1 && parts[1].length > 2) {
                    value = parts[0] + '.' + parts[1].slice(0, 2);
                }

                $(this).val(value);
            });
        });

        //Function for square footage and bedroom
        $(document).ready(function() {
            $('.numeric-input').on('input', function() {
                // Remove non-numeric characters
                var sanitized = $(this).val().replace(/[^0-9]/g, '');

                // Update the input value
                $(this).val(sanitized);
            });
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
        $(document).ready(function() {
            $('#inventoryType').on('change', function() {
                var inventoryType = $(this).val();
                $('#roomsOptions').css('display', inventoryType === '1' ? 'block' : 'none');
                $('#premisesOptions').css('display', inventoryType === '2' ? 'block' : 'none');
            }).trigger('change'); // Initialize options based on the current selection
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('toggle-form');
            const formContainer = document.getElementById('form-container');
            const deleteButton = document.getElementById('delete-form');

            toggleButton.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default action of the anchor tag
                const form = document.getElementById('account-form');
                if (form.style.display === 'none' || form.style.display === '') {
                    form.style.display = 'block';
                } else {
                    form.style.display = 'none';
                }
            });

            deleteButton.addEventListener('click', function() {
                const form = document.getElementById('account-form');
                form.style.display = 'none'; // Hide the form instead of removing it
            });
        });
    </script>
    <script>
        $('.upload-button').click(function() {
            $('#upload_photo_video, .add_youtube_link, .base64imageupload').val('');
            $('.select_image_section, .or_section, .youtube_section').show();
            $('#editMediaModal .profile-image-upload-section').html('').hide();
            $('.upload-image-youtube-button').prop('disabled', true);
            $(".mediaGalleryModal").modal('show');
        });
        $(document).delegate("#upload_photo_video", "change", function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {

                    $("#cropImage").modal('show');
                    $('#cropImage .profile-image-upload-section').html(
                        '<img src="" id="image" class="image" style="Width:100%">');
                    var $image = $('#cropImage .profile-image-upload-section #image');
                    if ($image.data('rcrop')) {
                        $image.rcrop('destroy');
                    }
                    // var url  = e.target.result;
                    $image.attr('src', e.target.result);
                    // Initialize rcrop after the image is loaded
                    $image.on('load', function() {
                        setTimeout(() => {
                            // $image.rcrop('destroy').off('load');
                            // alert();
                            $(this).rcrop({
                                preserveAspectRatio: true,
                                minSize: [16, 10.2],
                                preserveAspectRatio: true,
                                preview: {
                                    display: true,
                                    size: [100, 100],
                                    wrapper: '#custom-preview-wrapper'
                                },
                            });
                        }, 500);
                    });

                };
                reader.readAsDataURL(file);
            }
        });
        $(document).delegate(".image-crop", "click", function() {
            var imagerurl = $('#image').rcrop('getDataURL');

            $('.select_image_section, .or_section, .youtube_section').hide();
            $('#editMediaModal .profile-image-upload-section').show();
            $('#editMediaModal .profile-image-upload-section').html(
                '<img src="" id="image" class="image" style="Width:100%">');
            var $image = $('#editMediaModal .profile-image-upload-section #image');
            $image.attr('src', imagerurl);
            $('.base64imageupload').val(imagerurl);
            $("#cropImage").modal('hide');
            $('.upload-image-youtube-button').prop('disabled', false);



            // $("#profile-image").val(imagerurl)
            // $("#cropImage").modal('hide');
            // // $('.profile-image-section').hide();
            // $('#cropped-original').show();
            // $('#cropped-original img').attr('src', imagerurl);
        });

        $(document).delegate('.upload-image-youtube-button', 'click', function() {
            var $button = $(this); // Get the clicked button
            var $loader = $button.find('.loader-btn'); // Find the loader inside the button
            var $btnText = $button.find('.btn-text'); // Find the text inside the button

            // Disable the button and show the loader
            $button.prop('disabled', true);
            $btnText.hide(); // Hide the button text
            $loader.show(); // Show the loader

            var formData = $("#upload_media").serialize();

            $.ajax({
                url: $("#upload_media").attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status == "success") {
                        window.location.reload();

                        var galleryHtml =
                            `<div class="box-gallary-images-column">
                        <a href="javascript:void(0)" class="dlt-icon vendor-media-delete" data-id="${response.mediaid}" data-type="${response.type}"><i class="fa-solid fa-trash"></i></a>`;

                        if (response.type == "image") {
                            galleryHtml +=
                                `<img src="/${response.path}" class="box-gallary-7-images rounded-4"></div>`;
                        }
                        if (response.type == "youtube") {
                            galleryHtml +=
                                `<iframe width="100%" src="${response.path}" frameborder="0" allowfullscreen></iframe></div>`;
                        }

                        $(".box-gallary-7-images-row").append(galleryHtml);

                        // Hide the loader and enable the button
                        $btnText.show(); // Show the button text
                        $loader.hide(); // Hide the loader
                        $button.prop('disabled', false); // Enable the button again
                        $(".mediaGalleryModal").modal('hide');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle any errors
                    $button.prop('disabled', false);
                    $btnText.show(); // Show the button text in case of error
                    $loader.hide(); // Hide the loader if error occurs
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
    <script src="{{ asset('asset/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#multiple-select').select2({
                placeholder: 'Select cuisines...',
                width: '100%'
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#province').select2({
                placeholder: "Select Province/State",
                allowClear: true,
                width: '100%',
                dropdownCssClass: 'select2-dropdown-searchable'
            });
        });
        $(document).ready(function() {
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
@endsection
