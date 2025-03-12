@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Vendor Dashboard')

@section('content')

    <style>
        label {
            font-weight: 400;
        }

        .form-control:focus,
        .form-check-input:focus {
            box-shadow: unset;
            border-color: #408a95;
        }
    </style>

    <div class="col right-side">
        <div class="row">
            <div class="col-sm-12">
                <div class="information-box">
                    <div class="information-box-head">
                        <div class="box-head-heading d-flex align-items-center justify-content-between gap-2">
                            <span class="box-head-label theme-color">Curated Experience</span>
                            <a href="#" class="btn wine-btn px-4">Create</a>
                        </div>
                    </div>
                    
                    <form
                        action="{{ isset($experience) ? route('curative-experiences.update', [$experience->id, $vendor->id]) : route('curative-experiences.store', $vendor->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @if (isset($experience))
                            @method('PUT')
                        @endif

                        <div class="information-box-body py-4">
                            <div class="row g-3">
                                <!-- Experience Type -->
                                <div class="col-lg-4 col-12">
                                    <div class="form-floating">
                                        <select name="category_id" class="form-control form-select" id="seasonSelect">
                                            @if ($categories->isEmpty())
                                                <option value="">No Category Found</option>
                                            @else
                                                @foreach ($categories as $key => $category)
                                                    <option value="{{ $key }}"
                                                        {{ old('category_id', isset($experience) ? $experience->category_id : '') == $key ? 'selected' : '' }}>
                                                        {{ $category }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <label class="form-label">Experience Type</label>
                                    </div>
                                </div>

                                <!-- Experience Name -->
                                <div class="col-lg-4 col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name', isset($experience) ? $experience->name : '') }}"
                                            placeholder="Experience Name">
                                        <label>Experience Name</label>
                                    </div>
                                </div>

                                <!-- Admittance + Free -->
                                <div class="col-lg-4 col-12">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" name="admittance"
                                                        value="{{ old('admittance', isset($experience) ? $experience->admittance : '') }}"
                                                        placeholder="Enter Admittance Fee">
                                                    <label>Admittance</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3 d-flex align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="free"
                                                    value="1" id="flexCheckDefault"
                                                    {{ old('free', isset($experience) ? $experience->free : 0) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Free
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Extension -->
                                <div class="col-lg-4 col-12">
                                    <div class="form-floating">
                                        <select name="extension" class="form-control">
                                            @php
                                                $selectedExtension = old(
                                                    'extension',
                                                    isset($experience) ? $experience->extension : '',
                                                );
                                            @endphp
                                            <option value="+" {{ $selectedExtension == '+' ? 'selected' : '' }}>+
                                            </option>
                                            <option value="/Hr" {{ $selectedExtension == '/Hr' ? 'selected' : '' }}>/Hr
                                            </option>
                                            <option value="/Person" {{ $selectedExtension == '/Person' ? 'selected' : '' }}>
                                                /Person</option>
                                            <option value="/Night" {{ $selectedExtension == '/Night' ? 'selected' : '' }}>
                                                /Night</option>
                                            <option value="/Session"
                                                {{ $selectedExtension == '/Session' ? 'selected' : '' }}>/Session</option>
                                        </select>
                                        <label>Extension</label>
                                    </div>
                                </div>

                                <!-- URL (Booking Platform) -->
                                <div class="col-lg-4 col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="url"
                                            value="{{ old('url', isset($experience) ? $experience->url : '') }}"
                                            placeholder="URL (Booking Platform)">
                                        <label>URL (Booking Platform)</label>
                                    </div>
                                </div>

                                <!-- Inventory -->
                                <div class="col-lg-4 col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="inventory"
                                            value="{{ old('inventory', isset($experience) ? $experience->inventory : '') }}"
                                            placeholder="Quantity">
                                        <label>Inventory</label>
                                    </div>
                                </div>

                                <!-- Start Date -->
                                <div class="col-lg-4 col-12">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" name="start_date"
                                            value="{{ old('start_date', isset($experience) ? $experience->start_date : '') }}">
                                        <label>Start Date</label>
                                    </div>
                                </div>

                                <!-- End Date -->
                                <div class="col-lg-4 col-12">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" name="end_date"
                                            value="{{ old('end_date', isset($experience) ? $experience->end_date : '') }}">
                                        <label>End Date</label>
                                    </div>
                                </div>

                                <!-- Start Time -->
                                <div class="col-lg-4 col-12">
                                    <div class="form-floating">
                                        <input type="time" class="form-control" name="start_time"
                                            value="{{ old('start_time', isset($experience) ? $experience->start_time : '') }}">
                                        <label>Start Time</label>
                                    </div>
                                </div>

                                <!-- End Time -->
                                <div class="col-lg-4 col-12">
                                    <div class="form-floating">
                                        <input type="time" class="form-control" name="end_time"
                                            value="{{ old('end_time', isset($experience) ? $experience->end_time : '') }}">
                                        <label>End Time</label>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" name="description" style="height: 100px">{{ old('description', isset($experience) ? $experience->description : '') }}</textarea>
                                        <label>Description</label>
                                    </div>
                                </div>

                                <!-- Media Upload -->
                                <div class="col-12">
                                    <div class="profile-img-sec">
                                        <label for="profileImage" class="position-relative">
                                            <img id="profilePreview"
                                                src="{{ isset($experience) && $experience->media ? asset($experience->media->url) : asset('/images/placeholder.png') }}"
                                                class="profile-img rounded-3"
                                                style="width: 200px; height: 130px; object-fit: cover; border: 1px solid #408a95;">
                                            <p class="text-center"
                                                style="font-size: 14px; margin-top: 10px; color: #408a95; cursor: pointer;">
                                                <i class="fa-solid fa-arrow-up-from-bracket"></i> Upload Media
                                            </p>
                                        </label>
                                        <input type="file" id="profileImage" name="media" class="file-input"
                                            accept="image/*" style="display: none;">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="col-sm-12 text-center">
                                    <button type="submit"
                                        class="btn wine-btn">{{ isset($experience) ? 'Update' : 'Create' }}</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
