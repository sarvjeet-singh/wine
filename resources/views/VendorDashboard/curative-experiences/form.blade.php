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

        #imageUploadWrapper {
            width: fit-content;
        }

        #admittance-error {
            position: absolute;
            left: -34px;
        }

        @media screen and (max-width: 991px) {
            .input-group:has(#admittance-error) {
                padding-bottom: 26px;
            }
        }
    </style>



    <div class="col right-side">

        <div class="row">

            <div class="col-sm-12">

                <div class="information-box">

                    <form
                        action="{{ isset($experience) ? route('curative-experiences.update', [$experience->id, $vendor->id]) : route('curative-experiences.store', $vendor->id) }}"
                        method="POST" id="experienceForm" enctype="multipart/form-data">

                        <div class="information-box-head">

                            <div class="box-head-heading d-flex align-items-center justify-content-between gap-2">

                                <span class="box-head-label theme-color">{{ isset($experience) ? 'Update' : 'Create' }}
                                    Event</span>
                                @if (isset($experience))
                                    <a target="_blank"
                                        href="{{ isset($experience) ? route('curative-experiences.preview', [$experience->id, $vendor->id]) : route('curative-experiences.preview', $vendor->id) }}"
                                        class="btn wine-btn">Preview</a>
                                @endif
                                <div class="form-check form-switch ms-3 d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox"
                                        @if (isset($experience)) {{ $experience->is_published == 1 && $experience->status == 'active' ? 'disabled' : '' }} @endif
                                        id="statusToggle" value="1"
                                        {{ old('status', isset($experience) ? $experience->is_published == 1 : 0) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="statusToggle"
                                        id="toggleLabel">{{ isset($experience) ? ($experience->is_published == 1 ? 'Publish' : 'Draft') : 'Draft' }}</label>
                                </div>
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



                        @csrf

                        @if (isset($experience))
                            @method('PUT')
                        @endif



                        <div class="information-box-body py-4">

                            <div class="row g-3">

                                <!-- Experience Type -->

                                <div class="col-lg-3 col-12">

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

                                        <label class="form-label">Event Type</label>

                                    </div>

                                </div>

                                <!-- Genre -->
                                <div class="col-lg-3 col-12">

                                    <div class="form-floating">

                                        <select name="genre_id" class="form-control form-select" id="experienceGenre">

                                            <option value="">Select Genre</option>

                                            @if ($genres->isEmpty())

                                                <option value="">No Genre Found</option>
                                            @else
                                                @foreach ($genres as $key => $genre)
                                                    <option value="{{ $key }}"
                                                        {{ old('genre_id', isset($experience) ? $experience->genre_id : '') == $key ? 'selected' : '' }}>

                                                        {{ $genre }}

                                                    </option>
                                                @endforeach

                                            @endif

                                        </select>

                                        <label class="form-label">Genre</label>

                                    </div>

                                </div>

                                <!-- Experience Name -->

                                <div class="col-lg-3 col-12">

                                    <div class="form-floating">

                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name', isset($experience) ? $experience->name : '') }}"
                                            placeholder="Experience Name">

                                        <label>Event Name</label>

                                    </div>

                                </div>

                                <!-- Start Date -->

                                <div class="col-lg-3 col-12">

                                    <div class="form-floating">

                                        <input type="date" class="form-control" name="start_date"
                                            value="{{ old('start_date', isset($experience) ? $experience->start_date : '') }}">

                                        <label>Date</label>

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

                                        <input type="time" id="booking_time" name="booking_time" class="form-control"
                                            value="{{ old('booking_time', !empty($experience) && !empty($experience->booking_time) ? \Carbon\Carbon::parse($experience->booking_time)->format('H:i') : '') }}">

                                        <label>Start Time</label>

                                    </div>

                                </div>

                                <!-- Duration -->
                                <div class="col-lg-3 col-12">

                                    <div class="form-floating">

                                        <select class="form-select" name="duration">

                                            <option value="">Select Duration</option>

                                            @for ($i = 15; $i <= 1440; $i += 15)
                                                @php

                                                    $hours = floor($i / 60);

                                                    $minutes = $i % 60;

                                                    if ($hours == 1) {
                                                        $displayValue =
                                                            '1 hour' . ($minutes ? " $minutes minutes" : '');
                                                    } elseif ($hours > 1) {
                                                        $displayValue =
                                                            "$hours hours" . ($minutes ? " $minutes minutes" : '');
                                                    } else {
                                                        $displayValue = "$minutes minutes";
                                                    }

                                                @endphp

                                                <option value="{{ $i }}"
                                                    {{ old('duration', isset($experience) && $experience->duration == $i ? 'selected' : '') }}>

                                                    {{ $displayValue }}

                                                </option>
                                            @endfor

                                        </select>

                                        <label>Duration</label>

                                    </div>

                                </div>

                                <!-- URL (Booking Platform) -->

                                <div class="col-lg-3 col-12">

                                    <div class="form-floating">

                                        <input type="text" class="form-control" name="booking_url"
                                            value="{{ old('booking_url', isset($experience) ? $experience->booking_url : '') }}"
                                            placeholder="URL (Booking Platform)">

                                        <label>URL (Payment Gateway)</label>

                                    </div>

                                </div>

                                <!-- List Price + Free -->

                                <div class="col-lg-3 col-12">

                                    <div class="row">

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

                                        <div class="col-9">

                                            <div class="input-group pb-lg-0 pb-4">

                                                <span class="input-group-text">$</span>

                                                <div class="form-floating">

                                                    <input type="number" id="admittance" class="form-control"
                                                        name="admittance"
                                                        value="{{ old('admittance', isset($experience) ? $experience->admittance : '') }}"
                                                        placeholder="Enter Admittance Fee">

                                                    <label>List Price</label>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- Platform Fee -->

                                <div class="col-lg-3 col-12">

                                    <div class="row">

                                        <div class="col-12">

                                            <div class="input-group">

                                                <span class="input-group-text">$</span>

                                                <div class="form-floating">

                                                    <input type="number" class="form-control" id="platform_fee"
                                                        value="" placeholder="Platform Fee" readonly>

                                                    <label>Platform Fee</label>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- Platform Price -->

                                <div class="col-lg-3 col-12">

                                    <div class="row">

                                        <div class="col-12">

                                            <div class="input-group">

                                                <span class="input-group-text">$</span>

                                                <div class="form-floating">

                                                    <input type="number" class="form-control" id="listed_price"
                                                        value="" placeholder="Quantity" readonly>

                                                    <label>Platform Price</label>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <!-- Price Type -->

                                <div class="col-lg-3 col-12">

                                    <div class="form-check">
                                        @php
                                            $isVariable =
                                                old('price_type', isset($experience) ? $experience->price_type : '') ==
                                                '1';
                                        @endphp

                                        <input type="checkbox" class="form-check-input" id="price_type_variable"
                                            name="price_type" value="1" {{ $isVariable ? 'checked' : '' }}>

                                        <label class="form-check-label" for="price_type_variable">Is Variable
                                            Price?</label>
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

                                            <option value="">Select Extension</option>

                                            <option value="+" {{ $selectedExtension == '+' ? 'selected' : '' }}>+
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

                                <!-- Inventory -->

                                <div class="col-lg-4 col-12">

                                    <div class="form-floating">

                                        <input type="number" class="form-control" name="inventory"
                                            value="{{ old('inventory', isset($experience) ? $experience->inventory : '') }}"
                                            placeholder="Inventory">

                                        <label>Inventory (per day)</label>

                                    </div>

                                </div>

                                <!-- Quantity -->

                                <div class="col-lg-4 col-12">

                                    <div class="form-floating">

                                        <input type="number" class="form-control" name="quantity"
                                            value="{{ old('quantity', isset($experience) ? $experience->quantity : '') }}"
                                            placeholder="Quantity">

                                        <label>Number of guest allowed</label>

                                    </div>

                                </div>

                                <!-- Venue Name -->

                                <div class="col-lg-4 col-12">

                                    <div class="form-floating">

                                        <input type="text" class="form-control" name="venue_name"
                                            value="{{ old('venue_name', isset($experience) ? $experience->venue_name : '') }}"
                                            placeholder="Venue Name">

                                        <label>Venue Name</label>

                                    </div>

                                </div>

                                <!-- Venue Phone -->

                                <div class="col-lg-4 col-12">

                                    <div class="form-floating">

                                        <input type="text" class="form-control phone-number" name="venue_phone"
                                            value="{{ old('venue_phone', isset($experience) ? $experience->venue_phone : '') }}"
                                            placeholder="Venue Phone">

                                        <label>Venue Phone</label>

                                    </div>

                                </div>

                                <!-- Event Rating -->

                                <div class="col-lg-4 col-12">

                                    <div class="form-floating">

                                        <select name="event_rating" class="form-control">

                                            @php

                                                $selectedExtension = old(
                                                    'event_rating',

                                                    isset($experience) ? $experience->event_rating : '',
                                                );

                                            @endphp

                                            <option value="">Select Rating</option>
                                            <option value="family" {{ $selectedExtension == 'family' ? 'selected' : '' }}>
                                                Family</option>
                                            <option value="19" {{ $selectedExtension == '19' ? 'selected' : '' }}>19+
                                            </option>

                                        </select>

                                        <label>Event Rating</label>

                                    </div>

                                </div>

                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" value="1" id="sameAsVendor"
                                        onclick="fillAddressIfChecked()">
                                    <label class="form-check-label" for="sameAsVendor">
                                        Same as Vendor Address
                                    </label>
                                </div>

                                <!-- Address -->
                                <div class="col-lg-4 col-12">

                                    <div class="form-floating">

                                        <input type="text" id="address" name="address" class="form-control"
                                            value="{{ old('address', !empty($experience) && !empty($experience->address) ? $experience->address : '') }}">

                                        <label>Venue Address</label>

                                    </div>

                                </div>

                                <!-- City, State, Zipcode -->
                                <div class="col-lg-4 col-12">

                                    <div class="form-floating">

                                        <input type="text" id="city" name="city" class="form-control"
                                            value="{{ old('city', !empty($experience) && !empty($experience->city) ? $experience->city : '') }}">

                                        <label>City</label>

                                    </div>

                                </div>

                                <div class="col-lg-4 col-12">

                                    <div class="form-floating">

                                        <input type="text" id="state" name="state" class="form-control"
                                            value="{{ old('state', !empty($experience) && !empty($experience->state) ? $experience->state : '' ?? '') }}">

                                        <label>Province/State</label>

                                    </div>

                                </div>

                                {{-- <div class="col-lg-3 col-12">

                                    <div class="form-floating">

                                        <input type="text" oninput="formatPostalCode(this)" id="zipcode"
                                            maxlength="7" name="zipcode" class="form-control"
                                            value="{{ old('zipcode', !empty($experience) && !empty($experience->zipcode) ? $experience->zipcode : '') }}">

                                        <label>Postal/Zip</label>

                                    </div>

                                </div> --}}



                                <!-- Experience Description -->

                                <div class="col-12">

                                    <div class="form-floating">

                                        <textarea class="form-control" name="description" style="height: 100px">{{ old('description', isset($experience) ? $experience->description : '') }}</textarea>

                                        <label>Experience Description</label>

                                    </div>

                                </div>

                                <!-- Media Upload -->
                                <div class="col-12">







                                    <!-- Radio Buttons to Select Media Type -->







                                    <div class="mb-2 d-flex align-items-center gap-2">







                                        <label class="fw-bold">Choose Media Type:</label>


                                        @php
                                            $selectedMediaType = 'image'; // default

                                            if (!empty($experience)) {
                                                if (!empty($experience->youtube_url)) {
                                                    $selectedMediaType = 'youtube';
                                                } elseif (!empty($experience->image)) {
                                                    $selectedMediaType = 'image';
                                                }
                                            }
                                        @endphp

                                        <div class="form-check form-check-inline mb-0">
                                            <input class="form-check-input" type="radio" name="media_type"
                                                id="imageOption" value="image"
                                                {{ $selectedMediaType === 'image' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="imageOption">Image</label>
                                        </div>

                                        <div class="form-check form-check-inline m-0">
                                            <input class="form-check-input" type="radio" name="media_type"
                                                id="youtubeOption" value="youtube"
                                                {{ $selectedMediaType === 'youtube' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="youtubeOption">YouTube Link</label>
                                        </div>







                                        <!-- YouTube URL Input -->



                                        <div id="youtubeWrapper" class="d-none d-flex align-items-center gap-2">



                                            <input type="text" id="youtubeUrl" name="youtube_url"
                                                class="form-control"
                                                value="{{ old('youtube_url', $experience->youtube_url ?? '') }}"
                                                placeholder="Enter YouTube Video URL">

                                        </div>







                                    </div>





                                    <!-- Image Upload Preview -->

                                    <div id="imageUploadWrapper" class="d-flex flex-wrap gap-2"
                                        style="{{ !empty($experience->youtube_url) ? 'display: none;' : '' }}">







                                        @if (!empty($experience) && !empty($experience->image))
                                            <img src="{{ Storage::url($experience->image) }}"
                                                class="profile-img rounded-3"
                                                style="width: 200px; height: 130px; object-fit: cover; border: 1px solid #408a95;">
                                        @endif







                                        <div class="d-flex justify-content-center align-items-center rounded-3"
                                            style="width: 200px; height: 130px; border: 1px solid #408a95; background-color: #f8f9fa; cursor: pointer;">







                                            <i class="fa-solid fa-camera fa-2x text-muted"></i>







                                            <input type="file" id="profileImage" name="image" class="file-input"
                                                accept="image/*" style="display: none;">







                                        </div>







                                    </div>



                                    <!-- YouTube Preview -->

                                    <div id="youtubePreview" class="mt-2">

                                        <iframe class="rounded-3" width="200" height="130" frameborder="0"
                                            allowfullscreen></iframe>

                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="col-12 text-center mb-2">
                            <input type="hidden" name="is_published" id="publishStatus" value="0">
                            <button type="submit"
                                class="btn wine-btn px-4">{{ isset($experience) ? 'Update' : 'Create' }}</button>
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
                ignore: ":hidden:not(#profileImage)",
                rules: {

                    category_id: {

                        required: true

                    },

                    name: {

                        required: true,

                        maxlength: 255

                    },

                    genre_id: {

                        required: true

                    },

                    // admittance: {

                    //     required: {
                    //         depends: function() {
                    //             const isFreeChecked = $('#flexCheckDefault').is(':checked');
                    //             const bookingUrl = $('input[name="booking_url"]').val().trim();
                    //             return !isFreeChecked && bookingUrl === '' && $("#publishStatus")
                    //                 .val() == 1;
                    //         }
                    //     }

                    // },

                    is_free: {

                        required: false

                    },

                    // extension: {

                    //     required: true

                    // },

                    booking_url: {

                        url: true

                    },

                    inventory: {

                        number: true,

                        min: 1

                    },

                    start_date: {

                        required: {

                            depends: function() {
                                return $("#publishStatus").val() == 1;
                            }
                        },

                        date: true

                    },

                    end_date: {

                        // required: true,

                        date: true

                    },

                    image: {

                        required: {
                            depends: function() {
                                let hasExistingImage = @json(isset($experience) && $experience->image);
                                const isImageType = $("input[name='media_type']:checked").val() ===
                                    'image';
                                const isPublished = $("#publishStatus").val() == 1;

                                return isImageType && isPublished && !hasExistingImage;
                            }
                        }

                    },
                    youtube_url: {
                        required: {
                            depends: function() {
                                return $("input[name='media_type']:checked").val() === 'youtube';
                            }
                        },

                        url: true
                    },

                    description: {

                        required: {
                            depends: function() {
                                return $("#publishStatus").val() == 1;
                            }
                        },

                        maxlength: 1000

                    },
                    venue_name: {

                        required: {
                            depends: function() {
                                return $("#publishStatus").val() == 1;
                            }
                        },

                        maxlength: 255

                    },
                    venue_phone: {

                        required: {
                            depends: function() {
                                return $("#publishStatus").val() == 1;
                            }
                        }

                    },
                    address: {

                        required: {
                            depends: function() {
                                return $("#publishStatus").val() == 1;
                            }
                        },

                        maxlength: 255

                    },
                    city: {

                        required: {
                            depends: function() {
                                return $("#publishStatus").val() == 1;
                            }
                        },

                        maxlength: 255

                    },
                    state: {

                        required: {
                            depends: function() {
                                return $("#publishStatus").val() == 1;
                            }
                        },

                        maxlength: 255

                    },
                    // zipcode: {

                    //     required: {
                    //         depends: function() {
                    //             return $("#publishStatus").val() == 1;
                    //         }
                    //     },

                    //     maxlength: 7

                    // },
                    event_rating: {

                        required: {
                            depends: function() {
                                return $("#publishStatus").val() == 1;
                            }
                        },

                    },
                    booking_time: {

                        // required: true;

                    },
                    duration: {

                        // required: {
                        //     depends: function() {
                        //         return $("#publishStatus").val() == 1;
                        //     }
                        // }

                    },
                    quantity: {

                        // required: {

                        //     depends: function() {
                        //         return $("#publishStatus").val() == 1;
                        //     }
                        // },

                        number: true,

                        min: 1

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

                    image: {

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

            const profileInput = $("#profileImage");

            const previewWrapper = $("#imageUploadWrapper");



            // Handle image selection and preview

            profileInput.on("change", function(event) {

                const file = event.target.files[0];



                if (file) {

                    const reader = new FileReader();



                    reader.onload = function(e) {

                        // Replace existing preview or append new one

                        previewWrapper.find(".profile-img").remove();

                        previewWrapper.prepend(`

                    <img src="${e.target.result}" class="profile-img rounded-3"

                        style="width: 200px; height: 130px; object-fit: cover; border: 1px solid #408a95;">

                `);

                    };



                    reader.readAsDataURL(file);

                }

            });



            // Trigger file input on wrapper click (prevent infinite loop)

            previewWrapper.on("click", function(event) {

                if (!$(event.target).is("#profileImage")) {

                    profileInput.trigger("click");

                }

            });

        });
    </script>

    <script>
        $(document).ready(function() {

            const $imageOption = $("#imageOption");

            const $youtubeOption = $("#youtubeOption");

            const $imageUploadWrapper = $("#imageUploadWrapper");

            const $youtubeWrapper = $("#youtubeWrapper");

            const $youtubeUrlInput = $("#youtubeUrl");

            const $youtubePreview = $("#youtubePreview");

            const $youtubeIframe = $("#youtubePreview iframe");



            function toggleFields() {

                if ($imageOption.is(":checked")) {

                    $imageUploadWrapper.removeClass("d-none").addClass("d-flex");

                    $youtubeWrapper.addClass("d-none");

                    $youtubePreview.addClass("d-none");

                } else if ($youtubeOption.is(":checked")) {

                    $imageUploadWrapper.addClass("d-none").removeClass("d-flex");

                    $youtubeWrapper.removeClass("d-none");

                    $youtubePreview.removeClass("d-none");

                } else {

                    $imageUploadWrapper.addClass("d-none");

                    $youtubeWrapper.addClass("d-none");

                    $youtubePreview.addClass("d-none");

                }

            }



            function showYouTubePreview() {

                const url = $youtubeUrlInput.val().trim();

                const videoId = extractYouTubeID(url);



                if (videoId) {

                    $youtubeIframe.attr("src", `https://www.youtube.com/embed/${videoId}`);

                    $youtubePreview.removeClass("d-none");

                } else {

                    $youtubeIframe.attr("src", "");

                    $youtubePreview.addClass("d-none");

                }

            }



            function extractYouTubeID(url) {

                const regex =

                    /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/;

                const match = url.match(regex);

                return match ? match[1] : null;

            }



            // Event Listeners

            $imageOption.on("change", toggleFields);

            $youtubeOption.on("change", toggleFields);

            $youtubeUrlInput.on("blur", showYouTubePreview);



            // Initial State

            toggleFields();

            showYouTubePreview();

        });
    </script>

    <script>
        $(document).ready(function() {

            function toggleAdmittance() {

                if ($('#flexCheckDefault').is(':checked')) {

                    $('input[name="admittance"]').prop('readonly', true).val(''); // Make readonly and clear value

                    $('#listed_price').prop('readonly', true).val(''); // Make readonly and clear value
                    $('#platform_fee').prop('readonly', true).val(''); // Make readonly and clear value

                } else {

                    $('input[name="admittance"]').prop('readonly', false);

                }

            }



            // Check on page load (edit case)

            toggleAdmittance();



            // Handle checkbox change event

            $('#flexCheckDefault').change(function() {

                toggleAdmittance();

            });

        });

        $("#admittance").on("input", function() {
            var inputValue = parseFloat($(this).val());

            let platformFee = parseFloat(
                "{{ $vendor->event_platform_fee ?? (config('site.platform_fee') ?? '0.00') }}"
            );

            if (!isNaN(inputValue) && inputValue > 0 && !isNaN(platformFee)) {
                let feeAmount = inputValue * (platformFee / 100);
                let totalPrice = inputValue + feeAmount;

                $("#platform_fee").val(feeAmount.toFixed(2));
                $("#listed_price").val(totalPrice.toFixed(2));
            } else {
                $("#platform_fee").val('');
                $("#listed_price").val('');
            }
        });

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

        $("#admittance").trigger("input");
    </script>
    <script>
        function fillAddressIfChecked() {
            const checkbox = document.getElementById('sameAsVendor');
            const addressField = document.getElementById('address');
            const cityField = document.getElementById('city');
            const stateField = document.getElementById('state');
            const zipcodeField = document.getElementById('zipcode');
            const vendorAddress = @json($vendor->street_address ?? '');
            const vendorCity = @json($vendor->city ?? '');
            const vendorState = @json($vendor->state->name ?? '');
            const vendorZipcode = @json($vendor->postalCode ?? '');

            if (checkbox.checked) {
                addressField.value = vendorAddress;
                cityField.value = vendorCity;
                stateField.value = vendorState;
                zipcodeField.value = vendorZipcode;

            } else {
                addressField.value = '';
                cityField.value = '';
                stateField.value = '';
                zipcodeField.value = '';
            }
        }
    </script>
    <script>
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
        $(document).on('click', '#statusToggle', function() {
            const $toggle = $('#statusToggle');
            const $label = $('#toggleLabel');
            const $statusInput = $("#publishStatus");

            function updateLabel() {
                const isChecked = $toggle.is(':checked');
                $label.text(isChecked ? 'Publish' : 'Draft');
                $statusInput.val(isChecked ? 1 : 0);
            }

            // Attach change event (once modal content is visible)
            $toggle.off('change').on('change', updateLabel);

            // Set initial label
            updateLabel();
        });
    </script>
@endsection
