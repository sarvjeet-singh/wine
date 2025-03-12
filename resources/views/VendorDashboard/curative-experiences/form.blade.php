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
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
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
                    <form
                        action="{{ isset($experience) ? route('curative-experiences.update', [$experience->id, $vendor->id]) : route('curative-experiences.store', $vendor->id) }}"
                        method="POST" id="experienceForm" enctype="multipart/form-data">
                        @csrf
                        @if (isset($experience))
                            @method('PUT')
                        @endif

                        <div class="information-box-body py-4">
                            <div class="row g-3">
                                <!-- Experience Type -->
                                <div class="col-lg-4 col-12">
                                    <div class="form-floating">
                                        <select name="category_id" class="form-control form-select" id="experienceType">
                                            <option value="">Select type</option>
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
                                                <input class="form-check-input" type="checkbox" name="is_free"
                                                    value="1" id="flexCheckDefault"
                                                    {{ old('is_free', isset($experience) ? $experience->is_free : 0) ? 'checked' : '' }}>
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
                                            <option value="">+
                                            </option>
                                            <option value="/Hr" {{ $selectedExtension == '/Hr' ? 'selected' : '' }}>/Hr
                                            </option>
                                            <option value="/Person"
                                                {{ $selectedExtension == '/Person' ? 'selected' : '' }}>
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
                                        <input type="text" class="form-control" name="booking_url"
                                            value="{{ old('booking_url', isset($experience) ? $experience->booking_url : '') }}"
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
                                <div class="col-lg-3 col-12">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" name="start_date"
                                            value="{{ old('start_date', isset($experience) ? $experience->start_date : '') }}">
                                        <label>Start Date</label>
                                    </div>
                                </div>

                                <!-- End Date -->
                                <div class="col-lg-3 col-12">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" name="end_date"
                                            value="{{ old('end_date', isset($experience) ? $experience->end_date : '') }}">
                                        <label>End Date</label>
                                    </div>
                                </div>

                                <!-- Start Time -->
                                <div class="col-lg-3 col-12">
                                    <div class="form-floating">
                                        <input type="time" id="start_time" name="start_time" class="form-control"
                                            value="{{ old('start_time', !empty($experience) && !empty($experience->start_time) ? \Carbon\Carbon::parse($experience->start_time)->format('H:i') : '') }}">

                                        <label>Start Time</label>
                                    </div>
                                </div>

                                <!-- End Time -->
                                <div class="col-lg-3 col-12">
                                    <div class="form-floating">
                                        <input type="time" id="end_time" name="end_time" class="form-control"
                                            value="{{ old('end_time', !empty($experience) && !empty($experience->end_time) ? \Carbon\Carbon::parse($experience->end_time)->format('H:i') : '') }}">
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
                                    <div id="profilePreviewWrapper" class="d-flex flex-wrap gap-2">
                                        @if (isset($experience) && count($experience->medias) > 0)
                                            @foreach ($experience->medias as $media)
                                                <img src="{{ Storage::url($media->file_path) }}"
                                                    class="profile-img rounded-3"
                                                    style="width: 200px; height: 130px; object-fit: cover; border: 1px solid #408a95;">
                                            @endforeach
                                        @endif
                                        <div class="d-flex justify-content-center align-items-center rounded-3"
                                            style="width: 200px; height: 130px; border: 1px solid #408a95; background-color: #f8f9fa;">
                                            <i class="fa-solid fa-camera fa-2x text-muted"></i>
                                            <!-- Camera Icon -->
                                            <input type="file" id="profileImage" name="medias[]" class="file-input"
                                                accept="image/*" multiple style="display: none;">
                                        </div>
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
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"
        integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            let $startDate = $("input[name='start_date']");
            let $endDate = $("input[name='end_date']");
            let $startTime = $("input[name='start_time']");
            let $endTime = $("input[name='end_time']");

            // Restrict End Date to be same or after Start Date
            $startDate.on("change", function() {
                $endDate.attr("min", $(this).val());
                if ($endDate.val() < $(this).val()) {
                    $endDate.val($(this).val());
                }
            });

            // Restrict End Time if Start Date and End Date are the same
            $startTime.on("change", function() {
                console.log($(this).val());
                $endTime.attr("min", $(this).val());
                $endTime.attr("max", "23:59");
                if ($endTime.val() < $(this).val()) {
                    $endTime.val($(this).val());
                }
            });

            // Reset End Time restriction if End Date is changed
            $endDate.on("change", function() {
                if ($startDate.val() !== $(this).val()) {
                    $endTime.removeAttr("min");
                } else {
                    $endTime.attr("min", $startTime.val());
                }
            });

            $.validator.addMethod("timeGreater", function(value, element, param) {
                return this.optional(element) || value > $(param).val();
            }, "End time must be greater than start time");


            $("#experienceForm").validate({
                rules: {
                    category_id: {
                        required: true
                    },
                    name: {
                        required: true,
                        maxlength: 255
                    },
                    admittance: {
                        required: true
                    },
                    is_free: {
                        required: false, // Nullable
                    },
                    extension: {
                        required: true
                    },
                    booking_url: {
                        url: true
                    },
                    inventory: {
                        required: true,
                        number: true,
                        min: 1
                    },
                    start_date: {
                        required: true,
                        date: true
                    },
                    end_date: {
                        required: true,
                        date: true
                    },
                    start_time: {
                        required: true
                    },
                    end_time: {
                        required: true,
                        timeGreater: "#start_time" // Custom rule
                    },
                    "medias[]": {
                        extension: "jpg|jpeg|png|gif|mp4",
                        filesize: 2048 * 1024 // 2MB limit
                    }
                },
                messages: {
                    category_id: {
                        required: "The category field is required."
                    },
                    inventory: {
                        required: "Inventory is required.",
                        number: "Please enter a valid number.",
                        min: "Inventory must be at least 1."
                    },
                    end_time: {
                        required: "End time is required.",
                        timeGreater: "End time must be greater than Start time."
                    },
                    "medias[]": {
                        extension: "Only JPG, JPEG, PNG, GIF, and MP4 files are allowed.",
                        filesize: "File size must not exceed 2MB."
                    }
                },
                errorElement: "div",
                errorPlacement: function(error, element) {
                    error.addClass("text-danger mt-1");
                    error.insertAfter(element);
                }
            });
        });
        $(document).ready(function() {
            $("#profileImage").change(function(event) {
                let input = event.target;
                let reader = new FileReader();

                reader.onload = function() {
                    let previewWrapper = $("#profilePreviewWrapper");
                    let imagePreview = $("#profilePreview");

                    if (!imagePreview.length) {
                        // If img tag doesn't exist, create it
                        previewWrapper.html(`<img id="profilePreview" class="profile-img rounded-3" 
                    style="width: 100%; height: 100%; object-fit: cover;">`);
                        imagePreview = $("#profilePreview");
                    }

                    // Set new image source
                    imagePreview.attr("src", reader.result);
                };

                if (input.files && input.files[0]) {
                    reader.readAsDataURL(input.files[0]); // Read file as Data URL
                }
            });
        });
    </script>
@endsection
