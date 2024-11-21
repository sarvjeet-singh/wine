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
                                    <label class="form-label">Business/Vendor Name</label>
                                    <input type="text" class="form-control @error('vendor_name') is-invalid @enderror"
                                        name="vendor_name" value="{{ old('vendor_name', $vendor->vendor_name) }}"
                                        placeholder="Please enter Property name">
                                    @error('vendor_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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
                                        <label class="check-label" for="form-check-label">Check this box to hide street
                                            address</label>
                                        @error('hide_street_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Unit/Suite</label>
                                    <input type="text" class="form-control @error('unitsuite') is-invalid @enderror"
                                        name="unitsuite" value="{{ old('unitsuite', $vendor->unitsuite) }}"
                                        placeholder="Please enter Unit/Suite">
                                    @error('unitsuite')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">City/Town*</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                                        name="city" value="{{ old('city', $vendor->city) }}"
                                        placeholder="Please enter City/Town">
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Province/State*</label>
                                    <input type="text" class="form-control @error('province') is-invalid @enderror"
                                        name="province" value="{{ old('province', $vendor->province) }}"
                                        placeholder="Please enter Province/State">
                                    @error('province')
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
                                    <div class="">
                                        <label class="form-label">Sub-Region</label>
                                        <select name="sub_region"
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
                                        <label class="form-label">Country</label>
                                        <select class="form-control @error('country') is-invalid @enderror" name="country">
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
                                    <div class="mt-3">
                                        <label class="form-label">Business Phone</label>
                                        <input type="text"
                                            class="form-control phone-number @error('vendor_phone') is-invalid @enderror"
                                            name="vendor_phone" value="{{ old('vendor_phone', $vendor->vendor_phone) }}"
                                            placeholder="Please enter Business Phone">
                                        @error('vendor_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">Business Email</label>
                                        <input type="text"
                                            class="form-control @error('vendor_email') is-invalid @enderror"
                                            name="vendor_email" value="{{ old('vendor_email', $vendor->vendor_email) }}"
                                            placeholder="Please enter Business Email">
                                        @error('vendor_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                        <label class="form-label">Website</label>
                                        <input type="text" class="form-control @error('website') is-invalid @enderror"
                                            name="website" value="{{ old('website', $vendor->website) }}"
                                            placeholder="Please enter Website Url">
                                        @error('website')
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
                                            <div class="box-head-description mt-3">
                                                Images are limited to a 50kb file size in png or jpg formats
                                            </div>
                                        </div>
                                        <div class="information-box-body">
                                            <div class="row mt-3">
                                                <div class="col-sm-12">
                                                    <div class="box-gallary-7-images-row">
                                                        <div
                                                            class="box-gallary-images-column select-box-gallary-images-column">
                                                            <label for="front_License_image"
                                                                class="custom-file-label upload-button">
                                                                <!-- <img src="{{ asset('images/media-gallary/plus-icon.png') }}"
                                                                                                            width="20"> -->
                                                                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                                            </label>
                                                        </div>
                                                        @php
                                                            $firstMedia = $VendorMediaGallery->first(); // Get the first media item
                                                        @endphp

                                                        @if ($firstMedia)
                                                            <div class="box-gallary-images-column position-relative">
                                                                <a href="javascript:void(0)"
                                                                    class="dlt-icon vendor-media-delete"
                                                                    data-id="{{ $firstMedia->id }}"
                                                                    data-type="{{ $firstMedia->vendor_media_type }}">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </a>
                                                                @if ($firstMedia->vendor_media_type == 'image')
                                                                    <img src="{{ asset($firstMedia->vendor_media) }}"
                                                                        class="box-gallary-7-images rounded-4">
                                                                @elseif($firstMedia->vendor_media_type == 'youtube')
                                                                    <iframe width="135px"
                                                                        src="{{ $firstMedia->vendor_media }}"
                                                                        frameborder="0" allowfullscreen></iframe>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @if ($vendor->vendor_media_logo)
                                                            <div class="box-gallary-images-column position-relative">
                                                                <a href="javascript:void(0)"
                                                                    class="dlt-icon vendor-media-delete"
                                                                    data-type="image"><svg class="svg-inline--fa fa-trash"
                                                                        aria-hidden="true" focusable="false"
                                                                        data-prefix="fas" data-icon="trash"
                                                                        role="img" xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 448 512" data-fa-i2svg="">
                                                                        <path fill="currentColor"
                                                                            d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z">
                                                                        </path>
                                                                    </svg><!-- <i class="fa-solid fa-trash"></i> Font Awesome fontawesome.com --></a>
                                                                <img src="{{ asset($vendor->vendor_media_logo) }}"
                                                                    class="box-gallary-7-images rounded-4">
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
                                <span class="box-head-label theme-color">Booking Availability (Accommodation
                                    Details)</span>
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
                                        <label class="form-label">Square Footage</label>
                                        <input type="text"
                                            class="form-control numeric-input @error('square_footage') is-invalid @enderror"
                                            name="square_footage"
                                            value="{{ old('square_footage', !empty($metadata->square_footage) ? $metadata->square_footage : '') }}"
                                            placeholder="Please enter square footage">
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
                                            placeholder="Please enter bedrooms">
                                        @error('bedrooms')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="sleeps" class="form-label">Sleeps*</label>
                                        <input type="text" name="sleeps"
                                            class="form-control @error('sleeps') is-invalid @enderror"
                                            value="{{ old('sleeps', !empty($metadata->sleeps) ? $metadata->sleeps : '') }}"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        @error('sleeps')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="beds" class="form-label">Beds*</label>
                                        <input type="text" name="beds"
                                            class="form-control @error('beds') is-invalid @enderror"
                                            value="{{ old('beds', !empty($metadata->beds) ? $metadata->beds : '') }}"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        @error('beds')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-6 col-12">
                                            <label class="form-label">Washrooms*</label>
                                            <input type="text"
                                                class="form-control numeric-input @error('washrooms') is-invalid @enderror"
                                                name="washrooms"
                                                value="{{ old('washrooms', !empty($metadata->washrooms) ? $metadata->washrooms : '') }}"
                                                placeholder="Please enter washrooms">

                                            @error('washrooms')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
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
                                <div class="row g-3 mt-3">
                                    <div class="col-md-6">
                                        <div>
                                            <label for="vendor_sub_category"
                                                class="form-label fw-bold">{{ ucfirst($vendor->vendor_type) }}
                                                Sub-Type*</label>
                                            @if (count($subCategories) > 0)
                                                <select class="form-select" name="vendor_sub_category"
                                                    id="vendor_sub_category">
                                                    <option value="">Please Select</option>
                                                    @foreach ($subCategories as $subCategory)
                                                        <option value="{{ $subCategory->id }}"
                                                            {{ old('vendor_sub_category', $vendor->vendor_sub_category) == $subCategory->id ? 'selected' : '' }}>
                                                            {{ $subCategory->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    </div>

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
                                    @if (strtolower($vendor->vendor_type) != 'licensed')
                                        <div class="col-md-6">
                                            <div>
                                                <label for="farming_practices" class="form-label fw-bold">Farming
                                                    Practices</label>
                                                <select class="form-select" name="farming_practices"
                                                    id="farming_practices">
                                                    <option value="">Select a farming practice</option>
                                                    @foreach ($farmingPractices as $farmingPractice)
                                                        <option value="{{ $farmingPractice['id'] }}"
                                                            {{ old('farming_practices', isset($metadata->farming_practices) ? $metadata->farming_practices : '') == $farmingPractice['id'] ? 'selected' : '' }}>
                                                            {{ $farmingPractice['name'] }}
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
        <div class="row mt-5">
            <div class="col-sm-12">
                <div class="information-box">
                    <div class="information-box-head">
                        <div class="box-head-heading d-flex">
                            <span class="box-head-label theme-color">Social Media</span>
                        </div>
                    </div>
                    <div class="information-box-body">
                        @if (session('social-media-success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('social-media-success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form action="{{ route('vendor-social-media-update', ['vendorid' => $vendor->id]) }}"
                            method="post">
                            @csrf
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Facebook</label>
                                    <input type="text" class="form-control @error('facebook') is-invalid @enderror"
                                        name="facebook"
                                        value="{{ old('facebook', $vendor->socialMedia->facebook ?? '') }}"
                                        placeholder="Please enter Facebook link">
                                    @error('facebook')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Instagram</label>
                                    <input type="text" class="form-control @error('instagram') is-invalid @enderror"
                                        name="instagram"
                                        value="{{ old('instagram', $vendor->socialMedia->instagram ?? '') }}"
                                        placeholder="Please enter Instagram link">
                                    @error('instagram')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Twitter</label>
                                    <input type="text" class="form-control @error('twitter') is-invalid @enderror"
                                        name="twitter" value="{{ old('twitter', $vendor->socialMedia->twitter ?? '') }}"
                                        placeholder="Please enter Twitter link">
                                    @error('twitter')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">YouTube</label>
                                    <input type="text" class="form-control @error('youtube') is-invalid @enderror"
                                        name="youtube" value="{{ old('youtube', $vendor->socialMedia->youtube ?? '') }}"
                                        placeholder="Please enter YouTube link">
                                    @error('youtube')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">LinkedIn</label>
                                    <input type="text" class="form-control @error('linkedin') is-invalid @enderror"
                                        name="linkedin"
                                        value="{{ old('linkedin', $vendor->socialMedia->linkedin ?? '') }}"
                                        placeholder="Please enter LinkedIn link">
                                    @error('linkedin')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">TikTok</label>
                                    <input type="text" class="form-control @error('tiktok') is-invalid @enderror"
                                        name="tiktok" value="{{ old('tiktok', $vendor->socialMedia->tiktok ?? '') }}"
                                        placeholder="Please enter TikTok link">
                                    @error('tiktok')
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
        @if (trim(strtolower($vendor->vendor_type)) == 'accommodation' ||
                trim(strtolower($vendor->vendor_type)) == 'winery' ||
                trim(strtolower($vendor->vendor_type)) == 'excursion')
            @if (count($questionnaires))
                <div class="row mt-5">
                    <div class="col-sm-12">
                        <div class="information-box">
                            <div class="information-box-head">
                                <div class="box-head-heading d-flex">
                                    <span class="box-head-label theme-color">Questionnaire</span>
                                </div>
                            </div>
                            <div class="information-box-body">
                                @if (session('questionnaire-success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('questionnaire-success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                <form action="{{ route('vendor-questionnaire-update', ['vendorid' => $vendor->id]) }}"
                                    method="post">
                                    @csrf
                                    @foreach ($questionnaires as $key => $questionnaire)
                                        <div class="row mt-3">
                                            <div class="col-12">

                                                <label class="form-label">{{ $key + 1 }}.
                                                    {{ $questionnaire->question }}</label>

                                                @php
                                                    $vendorQuestionnaire = $questionnaire->vendorQuestionnaires->firstWhere(
                                                        'vendor_id',
                                                        $vendor->id,
                                                    );
                                                    $answers = $vendorQuestionnaire
                                                        ? json_decode($vendorQuestionnaire->answer, true)
                                                        : [];
                                                    $options = json_decode($questionnaire->options, true);
                                                @endphp

                                                @if ($questionnaire->question_type === 'radio')
                                                    <!-- Single choice (Radio buttons) -->
                                                    <div class="row g-3 mt-3">
                                                        @foreach ($options as $key => $option)
                                                            <div class="col-lg-4 col-md-6">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="answer[{{ $questionnaire->id }}]"
                                                                        id="question_{{ $questionnaire->id }}_{{ $key }}"
                                                                        value="{{ $key }}"
                                                                        {{ old('answer.' . $questionnaire->id, $vendorQuestionnaire->answer ?? '') == $key ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="question_{{ $questionnaire->id }}_{{ $key }}">
                                                                        {!! $option !!}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @elseif($questionnaire->question_type === 'checkbox')
                                                    <!-- Multiple choice (Checkboxes) -->
                                                    @foreach ($options as $key => $option)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="answer[{{ $questionnaire->id }}][]"
                                                                id="question_{{ $questionnaire->id }}_{{ $key }}"
                                                                value="{{ $option }}"
                                                                {{ in_array($option, $answers) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="question_{{ $questionnaire->id }}_{{ $key }}">
                                                                {!! $option !!}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <!-- Default: Text input -->
                                                    <input type="text"
                                                        class="form-control @error('answer.' . $questionnaire->id) is-invalid @enderror"
                                                        name="answer[{{ $questionnaire->id }}]" placeholder="Answer"
                                                        value="{{ old('answer.' . $questionnaire->id, $vendorQuestionnaire->answer ?? '') }}">
                                                @endif

                                                @error('answer.' . $questionnaire->id)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    @endforeach

                                    @error('answer')
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <div class="alert alert-danger">{{ $message }}</div>
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
            @endif
        @endif

        <div class="row mt-5">
            <div class="col-sm-12">
                <div class="information-box">
                    <div class="information-box-head">
                        <div class="box-head-heading d-flex">
                            <span class="box-head-label theme-color">Access Credentials</span>
                        </div>
                    </div>
                    <div class="information-box-body">
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
                        <form method="POST" action="{{ route('user.details.update', ['vendorid' => $vendor->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Given Name(s)</label>
                                    <div>
                                        <input type="text"
                                            class="form-control @error('firstname') is-invalid @enderror"
                                            name="firstname" value="{{ old('firstname', Auth::user()->firstname) }}"
                                            placeholder="Enter first name">
                                        @error('firstname')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Surname / Last Name</label>
                                    <div>
                                        <input type="text"
                                            class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                                            value="{{ old('lastname', Auth::user()->lastname) }}"
                                            placeholder="Enter last name">
                                        @error('lastname')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">eMail / Username</label>
                                    <div>
                                        <input type="text" class="form-control" name="email"
                                            value="{{ Auth::user()->email }}" placeholder="Enter email address"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Contact Phone</label>
                                    <div>
                                        <input type="text"
                                            class="form-control @error('contact_number') is-invalid @enderror"
                                            name="contact_number"
                                            value="{{ old('contact_number', Auth::user()->contact_number) }}"
                                            placeholder="Enter Phone number">
                                        @error('contact_number')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Add Account Btn Section -->
                            {{-- <div class="row mt-3">
                                <div class="col-12 text-end">
                                    <a href="#" id="toggle-form" class="btn wine-btn">Add Account</a>
                                </div>
                            </div> --}}
                            {{-- <div id="form-container">
                                <form id="account-form" style="display: none;">
                                    <div class="row mt-3">
                                        <div class="col-sm-6 col-12">
                                            <label class="form-label">Given Name(s)</label>
                                            <input type="text" class="form-control" name="firstname"
                                                value="{{ Auth::user()->firstname }}" placeholder="Enter first name">
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label class="form-label">Surname / Last Name</label>
                                            <input type="text" class="form-control" name="lastname"
                                                value="{{ Auth::user()->lastname }}" placeholder="Enter last name">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-6 col-12">
                                            <label class="form-label">Title</label>
                                            <select name="title"
                                                class="form-control @error('title') is-invalid @enderror">
                                                <option value="Chief Executive Officer (CEO)"
                                                    @if (old('title') == 'Chief Executive Officer (CEO)') selected @endif>Chief Executive
                                                    Officer (CEO)</option>
                                                <option value="President"
                                                    @if (old('title') == 'President') selected @endif>President</option>
                                                <option value="Chief Financial Officer"
                                                    @if (old('title') == 'Chief Financial Officer') selected @endif>Chief Financial
                                                    Officer</option>
                                                <option value="Chief Information Officer"
                                                    @if (old('title') == 'Chief Information Officer') selected @endif>Chief Information
                                                    Officer</option>
                                                <option value="Vice-President"
                                                    @if (old('title') == 'Vice-President') selected @endif>Vice-President
                                                </option>
                                                <option value="Director"
                                                    @if (old('title') == 'Director') selected @endif>Director</option>
                                                <option value="Manager"
                                                    @if (old('title') == 'Manager') selected @endif>Manager</option>
                                                <option value="Chief Marketing Officer"
                                                    @if (old('title') == 'Chief Marketing Officer') selected @endif>Chief Marketing
                                                    Officer</option>
                                                <option value="Chairman of the Board"
                                                    @if (old('title') == 'Chairman of the Board') selected @endif>Chairman of the
                                                    Board</option>
                                                <option value="Admin Staff"
                                                    @if (old('title') == 'Admin Staff') selected @endif>Admin Staff</option>
                                            </select>
                                            @error('title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label class="form-label">Position</label>
                                            <input type="text" class="form-control" name="position"
                                                placeholder="Enter Position">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-6 col-12">
                                            <label class="form-label">eMail / Username</label>
                                            <input type="text" class="form-control" name="email"
                                                value="{{ Auth::user()->email }}" placeholder="Enter email address">
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label class="form-label">Contact Phone</label>
                                            <input type="text" class="form-control phone-number" name="contact_number"
                                                value="{{ Auth::user()->contact_number }}"
                                                placeholder="Enter Phone number">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-6 col-12">
                                            <label class="form-label">Password</label>
                                            <input type="password" class="form-control" placeholder="Password">
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" placeholder="Confirm Password">
                                        </div>
                                    </div>
                                    <!-- <div class="row mt-5">
                                                <div class="col-sm-12 text-center">
                                                    <button type="submit" class="btn wine-btn">Update</button>
                                                </div>
                                            </div>  -->
                                </form>
                            </div> --}}
                            <!-- /Add Account Btn Section -->
                            <div class="row mt-5">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn wine-btn">Update</button>
                                    {{-- <button type="button" id="delete-form" class="btn btn-danger">Delete</button> --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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

        $(document).delegate('.vendor-media-delete', 'click', function() {
            var mediaId = $(this).attr('data-id');
            $.ajax({
                url: "{{ route('vendor-logo-delete', ['vendorid' => $vendor->id]) }}",
                type: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == "success") {
                        window.location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    // Handle any errors
                    $('.upload-image-youtube-button').prop('disabled', false);
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
@endsection
