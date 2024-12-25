@extends('FrontEnd.layouts.mainapp')

@section('content')
    <style>
        .quantity-control {
            display: flex;
            align-items: center;
        }

        .quantity-control .btn {
            background-color: #ddd;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .quantity-control .room-quantity-input {
            width: 50px;
            text-align: center;
            border: 1px solid #ddd;
            margin: 0 5px;
        }

        .theme-btn {
            background-color: #c0a144;
            color: #fff;
        }

        .theme-btn:hover {
            background-color: #c0a144;
            color: #fff;
        }

        .form-check-input {
            box-shadow: unset !important;
        }

        .f-15 {
            font-size: 15px;
        }


        #loginPopup .form-field svg {
            position: absolute;
            top: 10px;
            left: 10px;
            color: #c0a144;
        }

        #loginPopup .form-field input {
            padding-left: 35px;
        }

        #loginPopup .form-field input::placeholder {
            font-size: 15px;
        }

        .daterangepicker .ends {
            visibility: hidden;
            /* Hides dates from previous/next months */
        }

        .cojoinDates::before {
            border: 2px solid #c0a144;
            position: absolute;
            left: 50%;
            right: 0;
            top: 50%;
            bottom: 0;
            width: 30px;
            height: 30px;
            content: "";
            z-index: -1;
            transform: translate(-50%, -50%);
        }

        .cojoinDates:not(.start-package)::after {
            content: "";
            background: #c0a144;
            height: 2px;
            width: 41%;
            position: absolute;
            top: 50%;
            left: -11px;
        }

        td.off.disabled.bookedAndBlockeddates {
            background: #eee;
            text-decoration: none;
        }

        .amenities-modal ul {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
    </style>
    <div class="container mt-5 frontend detail-page">
        <div class="row g-xxl-5">
            <div class="col-lg-8">
                <div class="card mb-4 border-0">
                    <!-- <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">

                                        <div id="propertyCarouse3" class="" data-ride="carousel">

                                            <div class="owl-carousel owl-theme">
                                                @if ($vendor->mediaGallery->isNotEmpty())
    @foreach ($vendor->mediaGallery as $media)
    <div class="item">
                                                            @if ($media->vendor_media_type === 'youtube')
    <iframe width="100%" height="300px" src="{{ $media->vendor_media }}"
                                                                    frameborder="0" allowfullscreen></iframe>
@elseif ($media->vendor_media_type === 'image')
    <img src="{{ asset($media->vendor_media) }}" alt="Image"
                                                                    class="img-fluid">
    @endif
                                                        </div>
    @endforeach
    @endif
                                            </div>
                                        </div>
                                    </div> -->

                    <div class="single-main-slider">
                        <div class="container">
                            <div class="synch-carousels">
                                <div class="left child">
                                    <div class="property-gallery-main">
                                        @if ($vendor->mediaGallery->isNotEmpty())
                                            @foreach ($vendor->mediaGallery as $media)
                                                <div class="item">
                                                    <img src="{{ asset($media->vendor_media) }}">
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <div class="right child">
                                    <div class="property-gallery-thumb">
                                        @if ($vendor->mediaGallery->isNotEmpty())
                                            @foreach ($vendor->mediaGallery as $media)
                                                <div class="item">
                                                    <img src="{{ asset($media->vendor_media) }}">
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="nav-arrows">
                                        <button class="arrow-left">
                                            <img src="{{ asset('images/prev-btn.png') }}">
                                        </button>
                                        <button class="arrow-right">
                                            <img src="{{ asset('images/next-btn.png') }}">
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="d-flex flex-md-nowrap flex-wrap justify-content-between align-items-center">
                            <h2 class="text-primary theme-color fs-5">
                                {{ !empty($vendor->sub_category->name) ? $vendor->sub_category->name : '' }}</h2>
                            <div class="rating-star theme-color mb-md-0 mb-3"
                                data-rating="{{ $vendor->reviews->avg('rating') ?? 0.0 }}">
                            </div>
                        </div>
                        <h3 class="card-title fs-5">{{ $vendor->vendor_name }}</h3>
                        <p class="mb-1"><i class="fas fa-map-marker-alt theme-color"></i>
                            @if ($vendor->hide_street_address == 0)
                                <span>{{ $vendor->street_address }}</span><br>
                            @endif
                            <span class="mx-3">{{ $vendor->city }}, {{ $vendor->province }},
                                {{ $vendor->postalCode }}<br> <span style="margin-left: 2rem !important;">
                                    @if ($vendor->country == 'CA')
                                        Canada
                                    @endif
                                </span></span>
                        </p>
                        <p class="mb-1"><i class="fas fa-phone theme-color"></i> {{ $vendor->vendor_phone }}</p>
                        <p class="" id="cardText">
                            {{ $vendor->description }}
                        </p>
                        <a href="javascript:void(0)" class="cursor-pointer" id="readMoreBtn">Read More</a>

                        <div class="property-feature">
                            <ul class="room-info-inner d-flex justify-content-between list-unstyled p-0 pt-3 gap-1 mb-2">
                                <li class="fw-bold"><span class="theme-color"></span> Bedrooms</li>
                                <li class="fw-bold">Washrooms</li>
                                <li class="fw-bold">Beds / Sleeps</li>
                                <li class="fw-bold">Price Point</li>
                            </ul>
                            <ul
                                class="room-info-inner d-flex justify-content-between list-unstyled p-0 border-top pt-2 gap-1">
                                <li><span
                                        class="theme-color"></span>{{ !empty($vendor->accommodationMetadata->bedrooms) ? $vendor->accommodationMetadata->bedrooms : '' }}
                                </li>
                                <li>{{ !empty($vendor->accommodationMetadata->washrooms) ? $vendor->accommodationMetadata->washrooms : '' }}
                                </li>
                                <li>{{ !empty($vendor->accommodationMetadata->beds) ? $vendor->accommodationMetadata->beds : '' }}
                                    /
                                    {{ !empty($vendor->accommodationMetadata->sleeps) ? $vendor->accommodationMetadata->sleeps : '' }}
                                </li>
                                <li>{{ !empty($vendor->pricePoint->name) ? explode(' ', $vendor->pricePoint->name)[0] : '-' }}
                                </li>
                            </ul>
                        </div>

                        @if (
                            !empty($vendor->accommodationMetadata->process_type) &&
                                $vendor->accommodationMetadata->process_type != 'redirect-url')
                            <div class="pt-3">
                                <button class="btn wine-btn"><a href="#datepicker-container">Check Availability</a></button>
                            </div>
                        @else
                            <div class="text-start pt-3">
                                <button type="button" class="btn btn-success"><a target="_blank" class="link-light"
                                        href="{{ !empty($vendor->accommodationMetadata->redirect_url) ? $vendor->accommodationMetadata->redirect_url : '' }}">Make
                                        Direct Booking</a></button>
                            </div>
                        @endif
                        @if ($vendor->experiences->isNotEmpty())
                            <div class="border-top border-bottom py-5 mt-4">
                                <h3 class="theme-color">Curated Experiences</h3>
                                <p>Choose any Curated Experience</p>
                                <div class="curated-exp-sec">
                                    <!-- Tabs Headings -->
                                    <ul class="nav nav-pills flex-sm-row flex-column" id="pills-tab" role="tablist">
                                        @foreach ($vendor->experiences as $key => $experience)
                                            <li class="nav-item" role="presentation">
                                                <button
                                                    class="nav-link w-100 text-capitalize @if ($key == 0) active @endif"
                                                    id="tab-{{ $key }}" data-bs-toggle="pill"
                                                    data-bs-target="#content-{{ $key }}" type="button"
                                                    role="tab" aria-controls="content-{{ $key }}"
                                                    aria-selected="{{ $key == 0 ? 'true' : 'false' }}">
                                                    Experience {{ $key + 1 }}
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>


                                    <!-- Tabs Content -->
                                    <div class="tab-content p-3" id="pills-tabContent">
                                        @foreach ($vendor->experiences as $key => $experience)
                                            <div class="tab-pane fade @if ($key == 0) show active @endif"
                                                id="content-{{ $key }}" role="tabpanel"
                                                aria-labelledby="tab-{{ $key }}">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <p class="fw-bold theme-color mb-0">{{ $experience->title }}</p>
                                                    <p class="fw-bold theme-color mb-0">$
                                                        {{ $experience->upgradefee }}{{ $experience->currenttype }}</p>
                                                </div>
                                                <p>{{ $experience->description }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (
                            !empty($vendor->accommodationMetadata->process_type) &&
                                $vendor->accommodationMetadata->process_type != 'redirect-url')
                            <form method="post" id="process_payment" action="{{ route('checkout.process') }}">
                                @csrf
                                <input type="hidden" name="vendor_id" class="v_id" value="{{ $vendor->id }}">
                                <input type="hidden" name="start_date" id="fromdate" value="">
                                <input type="hidden" name="end_date" id="todate" value="">
                                <input type="hidden" name="booking_date_option" value="">
                                <div class="checkin-dates mt-4">
                                    <h3 class="fs-5 mb-sm-3 mb-2">Select Check-In Dates</h3>
                                    <div class="date-fields">
                                        <div>
                                            <label for="" class="form-label">Number In Travel Party</label>
                                            <input type="text" name="number_travel_party" class="form-control"
                                                placeholder="Number In Travel Party" id="Travelvalue">
                                        </div>
                                        <div>
                                            <label for="" class="form-label">Nature of Visit</label>
                                            <select class="form-select" name="nature_of_visit" id="visitvalue">
                                                <option value="">Select</option>
                                                <option value="Pleasure">Pleasure</option>
                                                <option value="Business">Business</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                @if (Auth::check())
                                @else
                                    <p class="mt-3 mb-0">You must be logged-in to initiate a booking</p>
                                @endif

                                <div class="col-lg-12 pt-2 scroll-offset" id="datepicker-container">
                                    <input type="text" class="form-control" name="datefilter" value=""
                                        style="opacity: 0; font-size: 0;" readonly />
                                </div>
                                <div style="clear: both;"></div>
                                <div class="form-check m-3">
                                    <input class="form-check-input" type="checkbox" value="" id="guest-registry">
                                    <label class="form-check-label" for="guest-registry"
                                        style="font-size: 15px; font-weight: 400; cursor: pointer;">
                                        My Guest Registry section is completed
                                    </label>
                                </div>
                                <div class="text-end">
                                    @if (!Auth::guard('vendor')->check())
                                        @if (Auth::check())
                                            <button type="button" class="btn book-btn" id="confirm_booking_btn">Process
                                                Payment</button>
                                        @else
                                            <div class="d-flex align-items-center justify-content-end gap-3">
                                                <!-- <p class="mb-0 fw-bold">You must be logged-in to initiate a booking</p> -->
                                                <button type="button" class="btn book-btn" id="login_form_btn"
                                                    data-bs-toggle="modal" data-bs-target="#loginPopup">Login</button>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4 ">
                <div class="p-3 shadow rounded-4 bg-white">
                    <h5 class="border-bottom pb-3 fw-bold">Things to Know</h5>
                    <div class="pt-3">
                        <div class="d-flex justify-content-between">
                            <span class="fa-lg">Host(s):</span>
                            <strong class="fa-lg text-muted">{{ $vendor->host ? ucwords($vendor->host) : '' }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="fa-lg">Booking Rate:</span>
                            <strong class="fa-lg text-muted">${{ $vendor->pricing->current_rate ?? 0 }}/Night</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="fa-lg">Square Footage:</span>
                            <strong class="fa-lg text-muted">{{ $vendor->accommodationMetadata->square_footage ?? 0 }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="fa-lg">Minimum Booking:</span>
                            <strong
                                class="fa-lg text-muted">{{ !empty($vendor->accommodationMetadata->booking_minimum) ? $vendor->accommodationMetadata->booking_minimum . ' nights' : 0 }}
                            </strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="fa-lg">Maximum Booking:</span>
                            <strong
                                class="fa-lg text-muted">{{ !empty($vendor->accommodationMetadata->booking_maximum) ? $vendor->accommodationMetadata->booking_maximum . ' nights' : 0 }}
                            </strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="fa-lg">Check-In After:</span>
                            <strong
                                class="fa-lg text-muted text-uppercase">{{ !empty($vendor->accommodationMetadata->checkin_start_time) ? \Carbon\Carbon::createFromFormat('H:i:s', $vendor->accommodationMetadata->checkin_start_time)->format('h:i A') : 'N/A' }}</strong>
                        </div>
                        <div class="d-flex  justify-content-between">
                            <span class="fa-lg">Check-Out Before:</span>
                            <strong
                                class="fa-lg text-muted text-uppercase">{{ !empty($vendor->accommodationMetadata->checkout_time) ? \Carbon\Carbon::createFromFormat('H:i:s', $vendor->accommodationMetadata->checkout_time)->format('h:i A') : 'N/A' }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Special request may be accommodated</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Website: {!! $vendor->website ? '<a href="' . $vendor->website . '" target="_blank">' . $vendor->website . '</a>' : 'N/A' !!}</p>
                        </div>
                    </div>
                    @if ($vendor->policy != '')
                        <h5 class="mt-5">Refund Policy</h5>
                        <p class="text-capitalize mb-0">{{ $vendor->policy }}</p>
                        @if ($vendor->policy == 'partial')
                            <p>A full refund minus transaction fees will be issued upon request up to 7 days prior to the
                                check-in date indicated. No refund will be issued for cancellations that fall within that
                                7-day period prior to the check-in date. A credit or rain cheque may be issued to guests at
                                the vendor’s discretion.</p>
                        @elseif($vendor->policy == 'open')
                            <p>A full refund minus transaction fees will be issued upon request up to 24 hours prior to the
                                check-in date indicated.</p>
                        @else
                            <p>All bookings are final. No portion of your transaction will be refunded. A credit or rain
                                cheque may be issued by the subject vendor at the vendor’s discretion.</p>
                        @endif
                    @endif
                </div>
                @if (count($amenities) > 0)
                    <div class="p-3 mt-xxl-5 mt-4 border-0 bg-custom shadow rounded-4">
                        <div class="card-header bg-custom border-0">
                            <h5 class="border-bottom pb-3 fw-bold">Amenities</h5>
                        </div>
                        <div class="card-body bg-custom">
                            <div class="row">
                                <div class="col-6">
                                    @if (count($amenities) > 0)
                                        @foreach ($amenities as $key => $amenity)
                                            @if ($key < 8)
                                                <!-- Display only the first 7 amenities -->
                                                <p class="my-4 d-flex align-items-center gap-3">
                                                    <i class="{{ $amenity->amenity_icons }} theme-color"></i>
                                                    {{ $amenity->amenity_name }}
                                                </p>
                                            @endif
                                            @if ($key == 3)
                                                <!-- Split into two columns after 4 items -->
                                </div>
                                <div class="col-6">
                @endif
                @endforeach
                @endif
            </div>
        </div>

        @if (count($amenities) > 8)
            <!-- Display "See All" button if there are more than 8 amenities -->
            <div class="text-center pt-3">
                <button type="button" class="btn wine-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">See
                    All</button>
            </div>
        @endif
    </div>
    </div>
    @endif
    @if (
        !empty($socialLinks->facebook) ||
            !empty($socialLinks->twitter) ||
            !empty($socialLinks->instagram) ||
            !empty($socialLinks->linkedin) ||
            !empty($socialLinks->youtube) ||
            !empty($socialLinks->tiktok))
        <div class="p-3 mt-xxl-5 mt-4 shadow rounded-4 bg-white border-0">
            <div class="card-header bg-white border-0 pb-0">
                <h5 class="border-bottom pb-3 fw-bold">Follow on Us</h5>
            </div>
            <div class="card-body">
                @if (!empty($socialLinks->facebook))
                    <a href="{{ $socialLinks->facebook }}" class="btn p-0 btn-social-icon">
                        <img src="{{ asset('images/FrontEnd/facebook.png') }}" height="30" alt="Facebook">
                    </a>
                @endif

                @if (!empty($socialLinks->twitter))
                    <a href="{{ $socialLinks->twitter }}" class="btn p-0 btn-social-icon">
                        <img src="{{ asset('images/FrontEnd/twitter.png') }}" height="30" alt="Twitter">
                    </a>
                @endif

                @if (!empty($socialLinks->instagram))
                    <a href="{{ $socialLinks->instagram }}" class="btn p-0 btn-social-icon">
                        <img src="{{ asset('images/FrontEnd/instagram.png') }}" height="30" alt="Instagram">
                    </a>
                @endif

                @if (!empty($socialLinks->linkedin))
                    <a href="{{ $socialLinks->linkedin }}" class="btn p-0 btn-social-icon">
                        <img src="{{ asset('images/FrontEnd/linkedin.png') }}" height="30" alt="LinkedIn">
                    </a>
                @endif

                @if (!empty($socialLinks->youtube))
                    <a href="{{ $socialLinks->youtube }}" class="btn p-0 btn-social-icon">
                        <img src="{{ asset('images/FrontEnd/youtube.png') }}" height="30" alt="YouTube">
                    </a>
                @endif

                @if (!empty($socialLinks->tiktok))
                    <a href="{{ $socialLinks->tiktok }}" class="btn p-0 btn-social-icon">
                        <img src="{{ asset('images/FrontEnd/tiktok.png') }}" height="30" alt="TikTok">
                    </a>
                @endif
            </div>
        </div>
    @endif
    </div>
    </div>
    </div>

    <div class="container mb-5 mt-lg-0 mt-5 frontend">
        <div class="guest-favorite text-center">
            <h2>Review and Testimonial</h2>
            <p>This is a signature property that ranks in the top 10% of all eligible listings based on guest testimonials
                and our own rigorous vetting process</p>
        </div>
        <div class="row">
            @if ($vendor->reviews->isNotEmpty())
                @foreach ($vendor->reviews as $review)
                    <div class="col-md-4 pb-4">
                        <div class="card guest-testi">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3 gap-3">
                                    <img src="{{ !empty($review->customer->profile_image) ? asset('images/UserProfile/' . $review->customer->profile_image) : asset('images/UserProfile/default-profile.png') }}"
                                        alt="User Image" style="height:60px; width:60px;" class="rounded-circle mr-3">
                                    <div>
                                        <h5 class="card-title mb-2">{{ $review->customer->firstname ?? '' }}
                                            {{ $review->customer->lastname ?? '' }}</h5>
                                        <h6 class="card-subtitle text-muted ">{{ $review->customer->city ?? '' }},
                                            {{ $review->customer->state ?? '' }}</h6>
                                        <div class="rating-star theme-color" data-rating="{{ $review->rating ?? 0.0 }}">
                                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                                <p class="card-text">{{ $review->review_description ?? '' }}</p>

                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>No review has added</p>
            @endif
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-custom amenities-modal" style="border-radius: 20px;">
                <div class="modal-header border-0 p-4 pb-0">
                    <div class="">
                        <h5 class="modal-title" id="exampleModalLabel">What this place offers</h5>
                        <h6>Amenities</h6>
                    </div>
                    <button type="button" class="btn-close border rounded-circle" data-bs-dismiss="modal"
                        aria-label="Close">x</button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        @if (count($amenities) > 0)
                            @php $half = ceil(count($amenities) / 2); @endphp
                            <div class="col-12">
                                <h6 class="fw-bold">Basic</h6>
                                @if (count($amenities) > 0)
                                    <ul class="list-unstyled">
                                        @foreach ($amenities as $key => $amenity)
                                            @if ($amenity->amenity_type == 'Basic')
                                                <li class="d-flex align-items-center gap-3 py-2 border-bottom">
                                                    <i class="{{ $amenity->amenity_icons }} theme-color"></i>
                                                    {{ $amenity->amenity_name }}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <div class="col-12">
                                <h6 class="fw-bold">Premium</h6>
                                @if (count($amenities) > 0)
                                    <ul class="list-unstyled">
                                        @foreach ($amenities as $key => $amenity)
                                            @if ($amenity->amenity_type == 'Premium')
                                                <li class="d-flex align-items-center gap-3 py-2 border-bottom">
                                                    <i class="{{ $amenity->amenity_icons }} theme-color"></i>
                                                    {{ $amenity->amenity_name }}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @else
                            <p>No amenities available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="RoomsModal" tabindex="-1" aria-labelledby="RoomsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-custom" style="border-radius: 20px;">
                <div class="modal-header border-0 p-4">
                    <h5 class="modal-title" id="exampleModalLabel">Availability</h5>
                    <button type="button" class="btn-close  border rounded-circle" data-bs-dismiss="modal"
                        aria-label="Close">x</button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <!-- Room Available Sec Start -->
                        <div class="room-avail-sec my-3">
                            <div class="table-responsive">
                                <table class="table room-table text-center">
                                    <thead>
                                        <tr class="border-0">
                                            <th scope="col">Room Photos</th>
                                            <th scope="col">Room Type</th>
                                            <th scope="col">Availability</th>
                                            <th scope="col">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class="roomList">

                                        <!-- <tr>
                                                                                                                                                                <td class="room-img"><img src="/images/FrontEnd/pexels-pixabay-271624.jpg"></td>
                                                                                                                                                                <td>Standard</td>
                                                                                                                                                                <td class="room-avail">Available</td>
                                                                                                                                                                <td>
                                                                                                                                                                    <span class="room-price d-block fw-bold mb-2">$499/per night</span>
                                                                                                                                                                    <button class="btn">Select Room</button>
                                                                                                                                                                </td>
                                                                                                                                                            </tr>
                                                                                                                                                            <tr>
                                                                                                                                                            <td class="room-img"><img src="/images/FrontEnd/pexels-pixabay-271624.jpg"></td>
                                                                                                                                                                <td>Standard</td>
                                                                                                                                                                <td class="room-not-avail">Not Available</td>
                                                                                                                                                                <td>
                                                                                                                                                                    <span class="room-price d-block fw-bold mb-2">$499/per night</span>
                                                                                                                                                                    <button class="btn">Select Room</button>
                                                                                                                                                                </td>
                                                                                                                                                            </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Room Available Sec End -->

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Popup -->
    <div class="modal fade" id="loginPopup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="f-15">You must be logged-in to access this content</p>
                    <h3 class="fs-4 fw-bold mb-4 theme-color">Login</h3>
                    <form method="POST" action="{{ route('login.ajax') }}" id="loginForm">
                        @csrf
                        <div class="form-field mb-2 position-relative">
                            <input type="email" id="email" class="form-control"
                                @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required
                                autocomplete="email" autofocus placeholder="Enter your Email address">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-field mb-2 position-relative">
                            <input id="password" type="password"
                                class="form-control left-with-icon gpassword @error('password') is-invalid @enderror"
                                name="password" required autocomplete="current-password"
                                placeholder="Enter your current password">
                            <i class="fa-solid fa-unlock"></i>
                        </div>
                        <div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="d-flex align-items-center justify-content-between my-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="Hotel">
                                <label class="form-check-label f-15" for="Hotel">
                                    Remember Me
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="f-15 text-decoration-none" href="{{ route('password.request') }}">
                                    {{ __('Forgot Password?') }}
                                </a>
                            @endif
                        </div>
                        <div>
                            <button type="submit" class="btn theme-btn w-100">Login</button>
                            <p class="my-3">OR</p>
                            <p class="f-15">Join Our <a href="{{ route('register') }}"
                                    class="text-decoration-none theme-color">Guest
                                    Rewards</a> Program</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Login Popup -->
@endsection

@section('js')
    <script>
        $(document).ready(function() {

            const $readMoreBtn = $('#readMoreBtn');
            const $cardText = $('#cardText');

            const fullText = $cardText.text();
            const wordLimit = 60;
            const words = fullText.split(' ');

            if (words.length > wordLimit) {
                const truncatedText = words.slice(0, wordLimit).join(' ') + '...';
                $cardText.text(truncatedText);

                $readMoreBtn.click(function() {
                    const isTruncated = $cardText.text() === truncatedText;
                    $cardText.text(isTruncated ? fullText : truncatedText);
                    $readMoreBtn.text(isTruncated ? 'Read Less' : 'Read More');
                });
            } else {
                $readMoreBtn.hide();
            }

            $(".owl-carousel").owlCarousel({
                nav: true,
                loop: true,
                margin: 10,
                dots: true,
                items: 1,
                navText: ["<img src='{{ asset('images/prev-btn.png') }}'>",
                    "<img src='{{ asset('images/next-btn.png') }}'>"
                ]
            });
        });

        function bookingdates(allcojoinDates, unavailableDates, bookedAndBlockeddates, checkOutOnly, allcojoinDatess) {
            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            seasonDate = new Date();
            var currentYear = new Date().getFullYear();
            var NextYear = currentYear + 1;
            seasonEndDate = new Date(monthNames[seasonDate.getMonth()] + seasonDate.getDate() + ", " + NextYear);

            if ($(window).width() < 768) {
                daterangepickerMobile('input[name="datefilter"]', seasonDate, seasonEndDate, allcojoinDates,
                    unavailableDates, bookedAndBlockeddates, checkOutOnly, allcojoinDatess);
            } else {
                daterangepickerDesktop('input[name="datefilter"]', seasonDate, seasonEndDate, allcojoinDates,
                    unavailableDates, bookedAndBlockeddates, checkOutOnly, allcojoinDatess);
            }

            $('input[name="datefilter"]').click();
            $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                $('#fromdate').val(picker.startDate.format('YYYY-MM-DD'));
                $('#todate').val(picker.endDate.format('YYYY-MM-DD'));
            });
            $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            $('input[name="datefilter"]').on("clickDate.daterangepicker", function(ev, picker) {
                if (picker.endDate !== null) {
                    var startDate = picker.startDate.format('YYYY-MM-DD');
                    var endDate = picker.endDate.format('YYYY-MM-DD');
                    var rangeContainsInvalidDates = false;

                    var currentDate = moment(startDate);
                    while (currentDate.isSameOrBefore(moment(endDate))) {
                        var formattedDate = currentDate.format('YYYY-MM-DD');
                        if (bookedAndBlockeddates.includes(formattedDate)) {
                            rangeContainsInvalidDates = true;
                            break;
                        }
                        currentDate.add(1, 'day');
                    }

                    if (rangeContainsInvalidDates) {
                        alert(
                            'The selected date range includes unavailable dates. Please choose a different range.'
                        );
                        var daterangepicker = $('input[name="datefilter"]').data('daterangepicker');
                        if (daterangepicker) {
                            // Reset the date range picker
                            daterangepicker.setStartDate(daterangepicker
                                .startDate); // Set to a default start date if needed
                            daterangepicker.setEndDate(daterangepicker
                                .startDate); // Set to a default end date if needed

                            // Optionally clear the input field
                            $('input[name="datefilter"]').val('');

                            // Optionally hide the date picker
                            daterangepicker.hide();
                        }
                    } else {
                        $('#fromdate').val(picker.startDate.format('YYYY-MM-DD'));
                        $('#todate').val(picker.endDate.format('YYYY-MM-DD'));
                    }
                }
                // $.each(bookedAndBlockeddates, function(index, value) {
                //     var startDate = moment(value.start_date).add(1, 'day');
                //     console.log(moment(startDate).format('MM/DD/YYYY'));

                //     if(moment(startDate).format('MM/DD/YYYY') == picker.startDate.format('MM/DD/YYYY')){
                //         alert();
                //     }
                // });

                $.each(cojoinDates, function(index, value) {
                    var datecojoinenable = 0;
                    if (moment(value.start_date).format('MM/DD/YYYY') <= picker.startDate.format(
                            'MM/DD/YYYY') && moment(value.end_date).format('MM/DD/YYYY') >= picker.startDate
                        .format(
                            'MM/DD/YYYY')) {
                        datecojoinenable = 1;
                    } else if (picker.endDate !== null && moment(value.start_date).format('MM/DD/YYYY') <=
                        picker.endDate.format('MM/DD/YYYY') && moment(value.end_date).format(
                            'MM/DD/YYYY') >=
                        picker.endDate.format('MM/DD/YYYY')) {
                        datecojoinenable = 1;
                    }

                    if (datecojoinenable == 1) {
                        startDate = picker.startDate.format('MM/DD/YYYY');
                        if (moment(value.start_date).format('MM/DD/YYYY') < picker.startDate.format(
                                'MM/DD/YYYY')) {
                            startDate = moment(value.start_date).format('MM/DD/YYYY');
                        }
                        $('input[name="datefilter"]').val(startDate + ' - ' + moment(value.end_date).format(
                            'MM/DD/YYYY'));
                        $(".applyBtn").prop("disabled", false);
                        $('input[name="datefilter"]').data('daterangepicker').setStartDate(startDate);
                        $('input[name="datefilter"]').data('daterangepicker').setEndDate(moment(value
                                .end_date)
                            .format('MM/DD/YYYY'));
                        $('.applyBtn').click();
                        $('input[name="datefilter"]').click();
                    }

                });
            });
            $(".overlay-loader").hide();
        }

        function daterangepickerDesktop(target, seasonDate, seasonEndDate, allcojoinDates = "", unavailableDates = "",
            bookedAndBlockeddates = "", checkOutOnly = "", allcojoinDatess = "") {
            $(target).daterangepicker({
                parentEl: "#datepicker-container",
                startDate: seasonDate,
                endDate: seasonDate,
                minDate: seasonDate,
                maxDate: seasonEndDate,
                showCustomRangeLabel: true,
                autoUpdateInput: true,
                alwaysShowCalendars: true,
                locale: {
                    cancelLabel: 'Clear'
                },

                isInvalidDate: function(date) {
                    var currDate = moment(date._d).format('YYYY-MM-DD');
                    for (let i = 0; i < unavailableDates.length; i++) {
                        if (currDate == unavailableDates[i]) {
                            return true;
                        }
                    }
                },
                isCustomDate: function(date) {
                    var currDate = moment(date._d).format('YYYY-MM-DD');

                    for (let i = 0; i < bookedAndBlockeddates.length; i++) {
                        if (currDate == bookedAndBlockeddates[i] && $.inArray(bookedAndBlockeddates[i],
                                unavailableDates) == -1) {
                            return "bookedAndBlockeddates";
                        }
                    }
                    for (let i = 0; i < allcojoinDatess.length; i++) {
                        for (let j = 0; j < allcojoinDatess[i].length; j++) {
                            if (currDate == allcojoinDatess[i][j] && $.inArray(allcojoinDatess[i][j],
                                    unavailableDates) ==
                                -1) {
                                if (allcojoinDatess[i][j] == allcojoinDatess[i][0]) {
                                    return "cojoinDates start-package";
                                } else if (allcojoinDatess[i][j] == allcojoinDatess[i][allcojoinDatess[i]
                                        .length -
                                        1
                                    ]) {
                                    return "cojoinDates end-package";
                                } else {
                                    return "cojoinDates";
                                }
                            }
                        }
                    }
                    for (let i = 0; i < checkOutOnly.length; i++) {
                        if (currDate == checkOutOnly[i] && $.inArray(checkOutOnly[i], unavailableDates) == -1) {
                            return "checkoutonly";
                        }
                    }
                }

            });
        }

        function daterangepickerMobile(target, seasonDate, seasonEndDate, allcojoinDates = "", unavailableDates = "",
            bookedAndBlockeddates = "", checkOutOnly = "") {
            $(target).daterangepicker({
                parentEl: "#datepicker-container",
                startDate: seasonDate,
                endDate: seasonDate,
                minDate: seasonDate,
                maxDate: seasonEndDate,
                showCustomRangeLabel: true,
                autoUpdateInput: true,
                alwaysShowCalendars: true,
                MobileCalendar: true,
                // drops: 'up',
                locale: {
                    cancelLabel: 'Clear'
                },
                isInvalidDate: function(date) {
                    var currDate = moment(date._d).format('YYYY-MM-DD');
                    for (let i = 0; i < unavailableDates.length; i++) {
                        if (currDate == unavailableDates[i]) {
                            return true;
                        }
                    }
                },
                isCustomDate: function(date) {
                    var currDate = moment(date._d).format('YYYY-MM-DD');

                    for (let i = 0; i < bookedAndBlockeddates.length; i++) {
                        if (currDate == bookedAndBlockeddates[i] && $.inArray(bookedAndBlockeddates[i],
                                unavailableDates) == -1) {
                            return "bookedAndBlockeddates";
                        }
                    }
                    for (let i = 0; i < allcojoinDatess.length; i++) {
                        for (let j = 0; j < allcojoinDatess[i].length; j++) {
                            if (currDate == allcojoinDatess[i][j] && $.inArray(allcojoinDatess[i][j],
                                    unavailableDates) ==
                                -1) {
                                if (allcojoinDatess[i][j] == allcojoinDatess[i][0]) {
                                    return "cojoinDates start-package";
                                } else if (allcojoinDatess[i][j] == allcojoinDatess[i][allcojoinDatess[i]
                                        .length -
                                        1
                                    ]) {
                                    return "cojoinDates end-package";
                                } else {
                                    return "cojoinDates";
                                }
                            }
                        }
                    }
                    for (let i = 0; i < checkOutOnly.length; i++) {
                        if (currDate == checkOutOnly[i] && $.inArray(checkOutOnly[i], unavailableDates) == -1) {
                            return "checkoutonly";
                        }
                    }
                }
            });
        }

        $.ajax({
            type: 'get',
            url: "{{ route('manage.dates') }}",
            data: {
                vendor_id: '{{ $vendor->id }}'
            },
            dataType: "json",
            success: function(response) {
                var data = response.data;
                cojoinDates = data.cojoin;
                var VendorBookingAllSeason = data.VendorBookingAllSeason;


                unavailableDates = data.dates;
                bookedAndBlockeddates = data.bookedAndBlockeddates;
                allcojoinDates = data.cojoinDates;
                allcojoinDatess = data.cojoinDatess;
                checkOutOnly = data.checkOutOnly;
                bookingdates(allcojoinDates, unavailableDates, bookedAndBlockeddates, checkOutOnly,
                    allcojoinDatess);
            }
        });

        $(document).delegate("#confirm_booking_btn", "click", function(event) {
            var startDate = $("#fromdate").val();
            var endDate = $("#todate").val();
            var Travelvalue = $("#Travelvalue").val();
            var visitvalue = $("#visitvalue").val();
            var vendor_id = $(".v_id").val();

            if (startDate == 0 & endDate == 0) {
                alert("Please Select check-in Dates!");
                return false;
            }
            if (Travelvalue == 0) {
                alert("Please Fill Number in Travel Party!");
                return false;
            }
            if (visitvalue == 0) {
                alert("Please Select Nature of visit!");
                return false;
            }

            // $(".overlay-loader").show();
            $.ajax({
                type: 'POST',
                url: "{{ route('check.availability', ['vendorid' => $vendor->id]) }}",
                data: $('#process_payment').serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.inventory_type == "2") {
                        if (response.status == "error") {
                            alert(response.message);
                            return false;
                        }
                        $("#process_payment").submit();
                    } else {
                        $('.roomList').html(response.view);
                        $("#RoomsModal").modal('show');
                    }
                }
            });
        });
        $(document).on('click', '.btn-increase', function() {
            var roomId = $(this).data('room-id');
            var input = $('input[data-room-id="' + roomId + '"]');
            var currentValue = parseInt(input.val());
            var maxValue = parseInt(input.data('max'));

            if (currentValue < maxValue) {
                input.val(currentValue + 1);
            }
        });

        // Handle decrease button click
        $(document).on('click', '.btn-decrease', function() {
            var roomId = $(this).data('room-id');
            var input = $('input[data-room-id="' + roomId + '"]');
            var currentValue = parseInt(input.val());

            if (currentValue > 0) {
                input.val(currentValue - 1);
            }
        });

        // Handle direct input change
        $(document).on('change', '.room-quantity-input', function() {
            var maxValue = parseInt($(this).data('max'));
            var value = parseInt($(this).val());

            if (value > maxValue) {
                $(this).val(maxValue);
            } else if (value < 0 || isNaN(value)) {
                $(this).val(0);
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                var form = $(this);
                var url = form.attr('action'); // Get the action URL from the form
                var token = $('input[name="token"]').val(); // Assume token is in a hidden input field

                $.ajax({
                    url: url, // Adjust the URL as necessary
                    method: 'POST',
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token for Laravel
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            location.reload();
                        } else {
                            alert(response.message); // Display the error message
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422 || xhr.status === 403) {
                            var response = xhr.responseJSON;
                            alert(response.message);
                        }
                    }
                });
            });
        });
    </script>

    <script>
        const $left = $(".left");
        const $gl = $(".property-gallery-main");
        const $gl2 = $(".property-gallery-thumb");
        const $photosCounterFirstSpan = $(".photos-counter span:nth-child(1)");

        $gl2.on("init", (event, slick) => {
            $photosCounterFirstSpan.text(`${slick.currentSlide + 1}/`);
            $(".photos-counter span:nth-child(2)").text(slick.slideCount);
        });

        $gl.slick({
            rows: 0,
            slidesToShow: 2,
            arrows: false,
            draggable: false,
            useTransform: false,
            mobileFirst: true,
            responsive: [{
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 1023,
                    settings: {
                        slidesToShow: 1,
                        vertical: true
                    }
                }
            ]
        });

        $gl2.slick({
            rows: 0,
            useTransform: false,
            prevArrow: ".arrow-left",
            nextArrow: ".arrow-right",
            fade: true,
            asNavFor: $gl
        });

        function handleCarouselsHeight() {
            if (window.matchMedia("(min-width: 1024px)").matches) {
                const gl2H = $(".property-gallery-thumb").height();
                $left.css("height", gl2H);
            } else {
                $left.css("height", "auto");
            }
        }

        $(window).on("load", () => {
            handleCarouselsHeight();
            setTimeout(() => {
                $(".loading").fadeOut();
                $("body").addClass("over-visible");
            }, 300);
        });

        $(window).on(
            "resize",
            _.debounce(() => {
                handleCarouselsHeight();
                /*You might need this code in your projects*/
                //$gl1.slick("resize");
                //$gl2.slick("resize");
            }, 200)
        );

        $(".property-gallery-main .item").on("click", function() {
            const index = $(this).attr("data-slick-index");
            $gl2.slick("slickGoTo", index);
        });

        $gl2.on("afterChange", (event, slick, currentSlide) => {
            $photosCounterFirstSpan.text(`${slick.currentSlide + 1}/`);
        });

        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <!-- Calender Target on Click of Check Avail Btn -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener("click", function(e) {
                e.preventDefault();
                const targetID = this.getAttribute("href").substring(1);
                const target = document.getElementById(targetID);

                window.scrollTo({
                    top: target.offsetTop - document.querySelector(".sticky").offsetHeight,
                    behavior: "smooth"
                });
            });
        });
    </script>
@endsection
