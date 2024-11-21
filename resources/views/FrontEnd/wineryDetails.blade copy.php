@extends('FrontEnd.layouts.mainapp')

@section('content')

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
                                <div class="item">
                                  <img src="{{ asset('images/VendorImages/Prospect House Niagara Falls/2oSVyi0LsG.png') }}">
                                </div>
                                <div class="item">
                                  <img src="{{ asset('images/VendorImages/Prospect House Niagara Falls/hPoduClfGC.png') }}">
                                </div>
                                <div class="item">
                                  <img src="{{ asset('images/VendorImages/Prospect House Niagara Falls/MMeafqF3o2.png') }}">
                                </div>
                                <div class="item">
                                  <img src="{{ asset('images/VendorImages/Prospect House Niagara Falls/uTSuLZqSln.png') }}">
                                </div>
                                <div class="item">
                                  <img src="{{ asset('images/VendorImages/Prospect House Niagara Falls/zJxTVAoXSk.png') }}">
                                </div>
                              </div>
                            </div>

                            <div class="right child">
                              <div class="property-gallery-thumb">
                                <div class="item">
                                  <img src="{{ asset('images/VendorImages/Prospect House Niagara Falls/2oSVyi0LsG.png') }}">
                                </div>
                                <div class="item">
                                  <img src="{{ asset('images/VendorImages/Prospect House Niagara Falls/hPoduClfGC.png') }}">
                                </div>
                                <div class="item">
                                  <img src="{{ asset('images/VendorImages/Prospect House Niagara Falls/MMeafqF3o2.png') }}">
                                </div>
                                <div class="item">
                                  <img src="{{ asset('images/VendorImages/Prospect House Niagara Falls/uTSuLZqSln.png') }}">
                                </div>
                                <div class="item">
                                  <img src="{{ asset('images/VendorImages/Prospect House Niagara Falls/zJxTVAoXSk.png') }}">
                                </div>
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
                                {{ !empty($vendor->sub_regions->name) ? $vendor->sub_regions->name : '' }}</h2>
                            <div class="rating-star theme-color mb-md-0 mb-3"
                                data-rating="{{ $vendor->reviews->avg('rating') ?? 0.0 }}">
                            </div>
                        </div>
                        <h3 class="card-title fs-5">{{ $vendor->vendor_name }}
                            [{{ !empty($vendor->sub_category->name) ? $vendor->sub_category->name : '' }}]</h3>
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
                                <li class="fw-bold"><span class="theme-color"></span> Farming Practices</li>
                                <li class="fw-bold">Max Group Size</li>
                                <li class="fw-bold">Tasting</li>
                                <li class="fw-bold">Price Point</li>
                            </ul>
                            <ul class="room-info-inner d-flex justify-content-between list-unstyled p-0 border-top pt-2 gap-1">
                                <li><span class="theme-color"></span>Lorem</li>
                                <li>2</li>
                                <li>2</li>
                                <li>$</li>
                            </ul>
                        </div>

                        <div class="pt-3">
                            <button class="btn wine-btn"><a href="#curated-exp">Initiate Booking</a></button>
                        </div>
                            <div class="border-top py-5 mt-4" id="curated-exp">
                                <h3 class="theme-color">Curated Experiences</h3>
                                <p>Choose any Curated Experience</p>
                                <div class="curated-exp-sec">
                                    <!-- Tabs Headings -->
                                    <ul class="nav nav-pills flex-sm-row flex-column" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link w-100 text-capitalize active"
                                                id="tab-0" data-bs-toggle="pill" data-bs-target="#content-0" type="button" role="tab" aria-controls="content-0" aria-selected="true">
                                                Experience 1
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link w-100 text-capitalize"
                                                id="tab-1" data-bs-toggle="pill" data-bs-target="#content-1" type="button" role="tab" aria-controls="content-0" aria-selected="true">
                                                Experience 2
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link w-100 text-capitalize"
                                                id="tab-2" data-bs-toggle="pill" data-bs-target="#content-2" type="button" role="tab" aria-controls="content-0" aria-selected="true">
                                                Experience 3
                                            </button>
                                        </li>
                                    </ul>

                                    <!-- Tabs Content -->
                                    <div class="tab-content p-3" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="content-0" role="tabpanel" aria-labelledby="tab-0">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <p class="fw-bold theme-color mb-0">Personal Chef</p>
                                                <p class="fw-bold theme-color mb-0">$ 325/Session</p>
                                            </div>
                                            <p>Dining out can be grand but having that same quality meal and service in the comfort of your home is truly next level. Turn date night into a weekend getaway with a personalized multi-course dining experience.</p>
                                        </div>
                                        <div class="tab-pane fade" id="content-1" role="tabpanel" aria-labelledby="tab-1">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <p class="fw-bold theme-color mb-0">Personal Chef</p>
                                                <p class="fw-bold theme-color mb-0">$ 325/Session</p>
                                            </div>
                                            <p>Dining out can be grand but having that same quality meal and service in the comfort of your home is truly next level. Turn date night into a weekend getaway with a personalized multi-course dining experience.</p>
                                        </div>
                                        <div class="tab-pane fade" id="content-2" role="tabpanel" aria-labelledby="tab-2">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <p class="fw-bold theme-color mb-0">Personal Chef</p>
                                                <p class="fw-bold theme-color mb-0">$ 325/Session</p>
                                            </div>
                                            <p>Dining out can be grand but having that same quality meal and service in the comfort of your home is truly next level. Turn date night into a weekend getaway with a personalized multi-course dining experience.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 ">
                <div class="p-3 shadow rounded-4 bg-white">
                <h5 class="border-bottom pb-3 fw-bold">Things to Know</h5>
                <div class="pt-3">
                    <div class="d-flex justify-content-between">
                        <span class="fa-lg">Business Hours:</span>
                        <strong class="fa-lg text-muted"></strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="fa-lg">Cuisine Type:</span>
                        <strong class="fa-lg text-muted">Lorem</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="fa-lg">Tastings</span>
                        <strong
                            class="fa-lg text-muted">Lpsum Sid</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="fa-lg">Booking Rate:</span>
                        <strong
                            class="fa-lg text-muted">$999</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="fa-lg">Max Group Size:</span>
                        <strong class="fa-lg text-muted text-uppercase">2</strong>
                    </div>
                </div>
                <h5 class="mt-5">Refund Policy</h5>
                <p class="text-capitalize mb-0">Partial</p>
                <p>A full refund minus transaction fees will be issued upon request up to 7 days prior to the
                    check-in date indicated. No refund will be issued for cancellations that fall within that
                    7-day period prior to the check-in date. A credit or rain cheque may be issued to guests at
                    the vendor’s discretion.</p>
                </div>

                    <div class="p-3 mt-xxl-5 mt-4 border-0 bg-custom shadow rounded-4">
                        <div class="card-header bg-custom border-0">
                            <h5 class="border-bottom pb-3 fw-bold">Amenities</h5>
                        </div>
                        <div class="card-body bg-custom">
                            <div class="row">
                                <div class="col-6">
                                    <!-- Display only the first 7 amenities -->
                                    <p class="my-4 d-flex align-items-center gap-3">
                                        <i class="icon-espresso-machine theme-color"></i>
                                        Espresso Machine
                                    </p>
                                    <p class="my-4 d-flex align-items-center gap-3">
                                        <i class="icon-espresso-machine theme-color"></i>
                                        Espresso Machine
                                    </p>
                                    <p class="my-4 d-flex align-items-center gap-3">
                                        <i class="icon-espresso-machine theme-color"></i>
                                        Espresso Machine
                                    </p>
                                    <p class="my-4 d-flex align-items-center gap-3">
                                        <i class="icon-espresso-machine theme-color"></i>
                                        Espresso Machine
                                    </p>
                                    <!-- Split into two columns after 4 items -->
                                </div>
                                <div class="col-6">
                                    <p class="my-4 d-flex align-items-center gap-3">
                                        <i class="icon-espresso-machine theme-color"></i>
                                        Espresso Machine
                                    </p>
                                    <p class="my-4 d-flex align-items-center gap-3">
                                        <i class="icon-espresso-machine theme-color"></i>
                                        Espresso Machine
                                    </p>
                                    <p class="my-4 d-flex align-items-center gap-3">
                                        <i class="icon-espresso-machine theme-color"></i>
                                        Espresso Machine
                                    </p>
                                    <p class="my-4 d-flex align-items-center gap-3">
                                        <i class="icon-espresso-machine theme-color"></i>
                                        Espresso Machine
                                    </p>
                                </div>
                            </div>
                            <!-- Display "See All" button if there are more than 8 amenities -->
                            <div class="text-center pt-3">
                                <button type="button" class="btn wine-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">See
                                    All</button>
                            </div>
                        </div>
                    </div>

                <div class="p-3 mt-xxl-5 mt-4 shadow rounded-4 bg-white border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="border-bottom pb-3 fw-bold">Follow on Us</h5>
                    </div>
                    <div class="card-body">
                        <a href="#" class="btn p-0 btn-social-icon">
                            <img src="{{ asset('images/FrontEnd/facebook.png') }}" height="30" alt="Facebook">
                        </a>
                        <a href="#" class="btn p-0 btn-social-icon">
                            <img src="{{ asset('images/FrontEnd/twitter.png') }}" height="30" alt="Twitter">
                        </a>
                        <a href="#" class="btn p-0 btn-social-icon">
                            <img src="{{ asset('images/FrontEnd/instagram.png') }}" height="30" alt="Instagram">
                        </a>
                        <a href="#" class="btn p-0 btn-social-icon">
                            <img src="{{ asset('images/FrontEnd/linkedin.png') }}" height="30" alt="LinkedIn">
                        </a>
                        <a href="#" class="btn p-0 btn-social-icon">
                            <img src="{{ asset('images/FrontEnd/youtube.png') }}" height="30" alt="YouTube">
                        </a>
                        <a href="#
                        ." class="btn p-0 btn-social-icon">
                            <img src="{{ asset('images/FrontEnd/tiktok.png') }}" height="30" alt="TikTok">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wine-slider-outer mt-sm-0 mt-5 mb-5">
        <div class="container">
            <div class="sec-head">
                <h3 class="fw-bold fs-4">Wine Listing</h3>
            </div>
            <div class="wine-slider-wrapper">
                <div class="wine-item p-3">
                    <div class="wine-thumbnail text-center">
                        <a href="https://testing.winecountryweekends.ca/winery-shop/product-detail/28/129/93" tabindex="0">
                            <img src="https://testing.winecountryweekends.ca/storage/images/uMB1U9P53nOTkSPLS3JERhUhCCGaWAmeYojbb5TL.jpg" class="img-fluid" alt="Wine Image">
                        </a>
                    </div>
                    <div class="wine-info text-center mt-3">
                        <h5 class="fw-bold mb-1"><a href="#">Pesquie, Edition 1912M Red 2021(2021)</a></h5>
                        <p class="wine-price fw-bold theme-color">$234.00</p>
                    </div>
                </div>
                <div class="wine-item p-3">
                    <div class="wine-thumbnail text-center">
                        <a href="https://testing.winecountryweekends.ca/winery-shop/product-detail/28/129/93" tabindex="0">
                            <img src="https://testing.winecountryweekends.ca/storage/images/uMB1U9P53nOTkSPLS3JERhUhCCGaWAmeYojbb5TL.jpg" class="img-fluid" alt="Wine Image">
                        </a>
                    </div>
                    <div class="wine-info text-center mt-3">
                        <h5 class="fw-bold mb-1"><a href="#">Pesquie, Edition 1912M Red 2021(2021)</a></h5>
                        <p class="wine-price fw-bold theme-color">$234.00</p>
                    </div>
                </div>
                <div class="wine-item p-3">
                    <div class="wine-thumbnail text-center">
                        <a href="https://testing.winecountryweekends.ca/winery-shop/product-detail/28/129/93" tabindex="0">
                            <img src="https://testing.winecountryweekends.ca/storage/images/uMB1U9P53nOTkSPLS3JERhUhCCGaWAmeYojbb5TL.jpg" class="img-fluid" alt="Wine Image">
                        </a>
                    </div>
                    <div class="wine-info text-center mt-3">
                        <h5 class="fw-bold mb-1"><a href="#">Pesquie, Edition 1912M Red 2021(2021)</a></h5>
                        <p class="wine-price fw-bold theme-color">$234.00</p>
                    </div>
                </div>
                <div class="wine-item p-3">
                    <div class="wine-thumbnail text-center">
                        <a href="https://testing.winecountryweekends.ca/winery-shop/product-detail/28/129/93" tabindex="0">
                            <img src="https://testing.winecountryweekends.ca/storage/images/uMB1U9P53nOTkSPLS3JERhUhCCGaWAmeYojbb5TL.jpg" class="img-fluid" alt="Wine Image">
                        </a>
                    </div>
                    <div class="wine-info text-center mt-3">
                        <h5 class="fw-bold mb-1"><a href="#">Pesquie, Edition 1912M Red 2021(2021)</a></h5>
                        <p class="wine-price fw-bold theme-color">$234.00</p>
                    </div>
                </div>
                <div class="wine-item p-3">
                    <div class="wine-thumbnail text-center">
                        <a href="https://testing.winecountryweekends.ca/winery-shop/product-detail/28/129/93" tabindex="0">
                            <img src="https://testing.winecountryweekends.ca/storage/images/uMB1U9P53nOTkSPLS3JERhUhCCGaWAmeYojbb5TL.jpg" class="img-fluid" alt="Wine Image">
                        </a>
                    </div>
                    <div class="wine-info text-center mt-3">
                        <h5 class="fw-bold mb-1"><a href="#">Pesquie, Edition 1912M Red 2021(2021)</a></h5>
                        <p class="wine-price fw-bold theme-color">$234.00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>    

    <div class="container mb-5 mt-lg-0 mt-5 frontend">
        <div class="guest-favorite text-center">
            <h2>Review and Testimonial</h2>
            <p>This home is in the top 10% of eligible listings based on <br>ratings, reviews and reliability</p>
        </div>
        <div class="row">
            @if ($vendor->reviews->isNotEmpty())
                @foreach ($vendor->reviews as $review)
                    <div class="col-md-4 pb-4">
                        <div class="card guest-testi">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3 gap-3">
                                    <img src="{{ $review->user->profile_image ? asset('images/UserProfile/' . $review->user->profile_image) : asset('images/UserProfile/default-profile.png') }}"
                                        alt="User Image" style="height:60px; width:60px;" class="rounded-circle mr-3">
                                    <div>
                                        <h5 class="card-title mb-2">{{ $review->user->firstname }}
                                            {{ $review->user->lastname }}</h5>
                                        <h6 class="card-subtitle text-muted ">{{ $review->user->city }},
                                            {{ $review->user->state }}</h6>
                                        <div class="rating-star theme-color" data-rating="{{ $review->rating ?? 0.0 }}">
                                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                                <p class="card-text">{{ $review->review_description }}</p>

                            </div>
                        </div>
                    </div>
                @endforeach
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
                                <ul class="list-unstyled">
                                    @foreach ($amenities as $key => $amenity)
                                        @if ($key < $half)
                                            <li
                                                class="d-flex align-items-center gap-3 py-2 border-bottom">
                                                <i class="{{ $amenity->amenity_icons }} theme-color"></i> {{ $amenity->amenity_name }}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-12">
                                <h6 class="fw-bold">Premium</h6>
                                <ul class="list-unstyled">
                                    @foreach ($amenities as $key => $amenity)
                                        @if ($key >= $half)
                                            <li
                                                class="d-flex align-items-center gap-3 py-2 border-bottom">
                                                <i class="{{ $amenity->amenity_icons }} theme-color"></i> {{ $amenity->amenity_name }}
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
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
    
    <!-- Wine Slider -->
    <script>
        $('.wine-slider-wrapper').slick({
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            prevArrow: "<img class='a-left control-c prev slick-prev' src='{{ asset('images/prev-btn.png') }}'>",
            nextArrow: "<img class='a-right control-c next slick-next' src='{{ asset('images/next-btn.png') }}'>",
            responsive: [{
                    breakpoint: 1024,
                      settings: {
                        slidesToShow: 3
                    }
                },
                {

                breakpoint: 600,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });
    </script>

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
          responsive: [
            {
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

        $(".property-gallery-main .item").on("click", function () {
          const index = $(this).attr("data-slick-index");
          $gl2.slick("slickGoTo", index);
        });

        $gl2.on("afterChange", (event, slick, currentSlide) => {
          $photosCounterFirstSpan.text(`${slick.currentSlide + 1}/`);
        });

        $(function () {
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
