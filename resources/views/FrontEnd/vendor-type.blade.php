@extends('FrontEnd.layouts.mainapp')
@section('content')
    <style>
        /* Loader CSS Start */
        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .grape-cluster {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* transform: translate(-50%, -50%); */
        }

        .grape-outer {
            display: flex;
        }

        .grape {
            width: 26px;
            height: 26px;
            border: 3px solid #000;
            border-radius: 50%;
            animation: bounce 1.5s infinite ease-in-out;
        }

        .grape:nth-child(2) {
            animation-delay: 0.2s;
        }

        .grape:nth-child(3) {
            animation-delay: 0.4s;
        }

        .grape img {
            position: absolute;
            top: -43px !important;
            left: -13px !important;
            width: 44px;
        }

        .loginPopup .form-field svg {
            position: absolute;
            top: 10px;
            left: 10px;
            color: #c0a144;
        }

        .loginPopup .form-field input {
            padding-left: 35px;
        }

        .loginPopup .form-field input::placeholder {
            font-size: 15px;
        }


        /* Loader CSS End */
    </style>
    <!-- ========== Tab Sec Start ========== -->
    <section class="tab-content-sec listing-head-bar">
        <div class="container">
            <div class="inner-content">
                <ul class="list-unstyled d-flex justify-content-center align-items-center mb-0">
                    @php
                        switch ($type):
                            case 'accommodations':
                                $routepath = 'accommodations';
                                break;

                            case 'excursion':
                                $routepath = 'excursion-listing';
                                break;

                            case 'wineries':
                                $routepath = 'wineries-listing';
                                break;

                            case 'licensed':
                                $routepath = 'licensed';
                                break;
                            case 'non-licensed':
                                $routepath = 'non-licensed';
                                break;

                            default:
                        endswitch;
                    @endphp
                    <li><a href="{{ route($routepath) }}" class="text-decoration-none">{{ ucfirst($type) }} Directory</a></li>
                </ul>
            </div>
        </div>
    </section>
    <section class="listing-outer my-sm-3 my-2">
        <div class="container-fluid">
            <div class="row">
                @include('FrontEnd.partials.filters-section')
                <div class="col-xl-10 col-md-9 col-sm-8" style="position: relative;">
                    <div class="listing-inner mb-5">
                        <div class="row gy-4"></div>
                    </div>
                    <div id="scroll-loader" class="grape-cluster loader" style="display: none;">
                        <div class="grape-outer">
                            <div class="grape" style="background-color: #4eabe9;"></div>
                            <div class="grape" style="background-color: #df6336;"><img
                                    src="{{ asset('images/leaf.png') }}"></div>
                            <div class="grape" style="background-color: #b8d153;"></div>
                        </div>
                        <div class="grape-outer">
                            <div class="grape" style="background-color: #f6c746;"></div>
                            <div class="grape" style="background-color: #de67a0;"></div>
                        </div>
                        <div class="grape-outer">
                            <div class="grape" style="background-color: #da3e32;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========== Tab Sec End ========== -->
    <!-- Infinite Scroll Spinner Loader -->
    @if (!Auth::check())
        <!-- Login Popup -->
        <div class="modal fade enquiry-modal loginPopup" id="enquiryModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
                                    required autocomplete="email" autofocus placeholder="Enter your Email address">
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
    @elseif ($type == 'accommodations')
        @include('FrontEnd.partials.accommodation-inquiry')
    @elseif($type == 'wineries')
        @include('FrontEnd.partials.winery-inquiry')
    @elseif($type == 'excursion')
        @include('FrontEnd.partials.excursion-inquiry')
    @elseif($type == 'licensed')
        <div class="modal fade enquiry-modal" id="enquiryModal" tabindex="-1" aria-labelledby="enquiryModal"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header flex-column text-center position-relative border-0">
                        <h2 class="modal-title fs-4 text-uppercase theme-color" id="enquiryModal">Excursion Inquiry</h2>
                        <p class="mb-0">To initiate an inquiry please complete and submit this form. An Experience
                            Curator
                            will follow up shortly.</p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="container" id="accommodationFrom" method="post" enctype="multipart/form-data"
                            action="{{ route('excursion.inquiry') }}">
                            @csrf
                            <input type="hidden" name="vendor_id" id="inquiryvendorid" value="">
                            <div class="row mb-3">
                                <div class="col-lg-6 mb-lg-0 mb-3">
                                    <div class="form-group">
                                        <label class="mb-1">What is your tentative arrival date?</label>
                                        <input id="datepicker" class="form-control" placeholder="dd/mm/yyyy"
                                            name="check_in" type="date" data-fv-field="check_in" required=""
                                            min="2024-06-25">
                                        <small class="help-block" data-fv-validator="notEmpty" data-fv-for="check_in"
                                            data-fv-result="NOT_VALIDATED" style="display: none;">Travel/check-in date is
                                            required</small>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="mb-1">What is your tentative departure date?</label>
                                        <input id="datepicker2" class="form-control" placeholder="dd/mm/yyyy"
                                            name="check_out" type="date" data-fv-field="check_out" required="">
                                        <small class="help-block" data-fv-validator="notEmpty" data-fv-for="check_out"
                                            data-fv-result="NOT_VALIDATED" style="display: none;">travel/check-out date is
                                            required</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 mb-lg-0 mb-3">
                                    <div class="form-group">
                                        <label class="mb-1">What is the nature of your visit?</label>
                                        <select class="form-control" name="visit_nature">
                                            <option value="">--Select--</option>
                                            <option value="Business">Business</option>
                                            <option value="Pleasure">Pleasure</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="mb-1">How many guests are in your travel party?</label>
                                        <input type="text" class="form-control" placeholder="" name="guest_no"
                                            value="" data-fv-field="guest_no">
                                        <small class="help-block" data-fv-validator="integer" data-fv-for="guest_no"
                                            data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a valid
                                            number</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="excursion_activity_sec check-list">
                                        <label class="mb-1">What if any, type(s) of excursions are you
                                            considering?</label>
                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <input type="checkbox" name="excursion_activities[]"
                                                    id="excursion_activities" value="Adult Entertainment "><label
                                                    for="excursion_activities">Adult Entertainment </label>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="excursion_activities[]"
                                                    id="excursion_activities1" value="Family Entertainment"><label
                                                    for="excursion_activities1">Family Entertainment</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="excursion_activities[]"
                                                    id="excursion_activities2" value="Arts/Culture"><label
                                                    for="excursion_activities2">Arts/Culture</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="excursion_activities[]"
                                                    id="excursion_activities3" value="Sports &amp; Adventuring"><label
                                                    for="excursion_activities3">Sports &amp; Adventuring</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="excursion_activities[]"
                                                    id="excursion_activities4" value="Culinary"><label
                                                    for="excursion_activities4">Culinary</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="excursion_activities[]"
                                                    id="excursion_activities5" value="Stand-Up Paddle Boards"><label
                                                    for="excursion_activities5">Thrill Seeking</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 mb-lg-0 mb-3">
                                    <div class="form-group" id="inquery-type">
                                        <label class="mb-1">Will you require accommodations and if so, what is your
                                            preferred
                                            type?</label>
                                        <div class="require_acco">
                                            <ul class="list-unstyled mb-0 d-flex align-items-center gap-2">
                                                <li>
                                                    <input type="radio" name="preferred_accommodation"
                                                        id="preferred_yes" value="Yes"
                                                        onclick="handleCheckbox(this)"><label for="preferred_yes">Yes
                                                    </label>
                                                </li>
                                                <li>
                                                    <input type="radio" name="preferred_accommodation"
                                                        id="preferred_no" value="No"
                                                        onclick="handleCheckbox(this)"><label
                                                        for="preferred_no">No</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="mb-1">In what sub-region would you prefer to be
                                            accommodated?</label>
                                        <select class="form-control" name="sub_region" id="sub_region_select">
                                            <option value="">--Select--</option>
                                            <option value="">--Select--</option>
                                            <option value="Niagara Falls">Niagara Falls</option>
                                            <option value="Niagara-on-the-Lake">Niagara-on-the-Lake</option>
                                            <option value="Niagara Escarpment / Twenty Valley">Niagara Escarpment / Twenty
                                                Valley</option>
                                            <option value="South Escarpment">South Escarpment</option>
                                            <option value="Fort Erie / Niagara’s South Coast">Fort Erie / Niagara’s South
                                                Coast
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="mb-1">Additional Comments:</label>
                                        <textarea name="additional_comments_inquiry" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center formbtn">
                                    <button type="submit" id="execursionInqBtn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @elseif($type == 'non-licensed')
        <div class="modal fade enquiry-modal" id="enquiryModal" tabindex="-1" aria-labelledby="enquiryModal"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header flex-column text-center position-relative border-0">
                        <h2 class="modal-title fs-4 text-uppercase theme-color" id="enquiryModal">Excursion Inquiry</h2>
                        <p class="mb-0">To initiate an inquiry please complete and submit this form. An Experience
                            Curator
                            will follow up shortly.</p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="container" id="accommodationForm" method="post" enctype="multipart/form-data"
                            action="{{ route('excursion.inquiry') }}">
                            @csrf
                            <input type="hidden" name="vendor_id" id="inquiryvendorid" value="">
                            <div class="row mb-3">
                                <div class="col-lg-6 mb-lg-0 mb-3">
                                    <div class="form-group">
                                        <label class="mb-1">What is your tentative arrival date?</label>
                                        <input id="datepicker" class="form-control" placeholder="dd/mm/yyyy"
                                            name="check_in" type="date" data-fv-field="check_in" required=""
                                            min="2024-06-25">
                                        <small class="help-block" data-fv-validator="notEmpty" data-fv-for="check_in"
                                            data-fv-result="NOT_VALIDATED" style="display: none;">Travel/check-in date is
                                            required</small>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="mb-1">What is your tentative departure date?</label>
                                        <input id="datepicker2" class="form-control" placeholder="dd/mm/yyyy"
                                            name="check_out" type="date" data-fv-field="check_out" required="">
                                        <small class="help-block" data-fv-validator="notEmpty" data-fv-for="check_out"
                                            data-fv-result="NOT_VALIDATED" style="display: none;">travel/check-out date is
                                            required</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 mb-lg-0 mb-3">
                                    <div class="form-group">
                                        <label class="mb-1">What is the nature of your visit?</label>
                                        <select class="form-control" name="visit_nature">
                                            <option value="">--Select--</option>
                                            <option value="Business">Business</option>
                                            <option value="Pleasure">Pleasure</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="mb-1">How many guests are in your travel party?</label>
                                        <input type="text" class="form-control" placeholder="" name="guest_no"
                                            value="" data-fv-field="guest_no">
                                        <small class="help-block" data-fv-validator="integer" data-fv-for="guest_no"
                                            data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a valid
                                            number</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="excursion_activity_sec check-list">
                                        <label class="mb-1">What if any, type(s) of excursions are you
                                            considering?</label>
                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <input type="checkbox" name="excursion_activities[]"
                                                    id="excursion_activities" value="Adult Entertainment "><label
                                                    for="excursion_activities">Adult Entertainment </label>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="excursion_activities[]"
                                                    id="excursion_activities1" value="Family Entertainment"><label
                                                    for="excursion_activities1">Family Entertainment</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="excursion_activities[]"
                                                    id="excursion_activities2" value="Arts/Culture"><label
                                                    for="excursion_activities2">Arts/Culture</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="excursion_activities[]"
                                                    id="excursion_activities3" value="Sports &amp; Adventuring"><label
                                                    for="excursion_activities3">Sports &amp; Adventuring</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="excursion_activities[]"
                                                    id="excursion_activities4" value="Culinary"><label
                                                    for="excursion_activities4">Culinary</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="excursion_activities[]"
                                                    id="excursion_activities5" value="Stand-Up Paddle Boards"><label
                                                    for="excursion_activities5">Thrill Seeking</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-6 mb-lg-0 mb-3">
                                    <div class="form-group" id="inquery-type">
                                        <label class="mb-1">Will you require accommodations and if so, what is your
                                            preferred
                                            type?</label>
                                        <div class="require_acco">
                                            <ul class="list-unstyled mb-0 d-flex align-items-center gap-2">
                                                <li>
                                                    <input type="radio" name="preferred_accommodation"
                                                        id="preferred_yes" value="Yes"
                                                        onclick="handleCheckbox(this)"><label for="preferred_yes">Yes
                                                    </label>
                                                </li>
                                                <li>
                                                    <input type="radio" name="preferred_accommodation"
                                                        id="preferred_no" value="No"
                                                        onclick="handleCheckbox(this)"><label
                                                        for="preferred_no">No</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="mb-1">In what sub-region would you prefer to be
                                            accommodated?</label>
                                        <select class="form-control" name="sub_region" id="sub_region_select">
                                            <option value="">--Select--</option>
                                            <option value="">--Select--</option>
                                            <option value="Niagara Falls">Niagara Falls</option>
                                            <option value="Niagara-on-the-Lake">Niagara-on-the-Lake</option>
                                            <option value="Niagara Escarpment / Twenty Valley">Niagara Escarpment / Twenty
                                                Valley</option>
                                            <option value="South Escarpment">South Escarpment</option>
                                            <option value="Fort Erie / Niagara’s South Coast">Fort Erie / Niagara’s South
                                                Coast
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="mb-1">Additional Comments:</label>
                                        <textarea name="additional_comments_inquiry" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center formbtn">
                                    <button type="submit" id="execursionInqBtn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="modal fade hours-modal" id="hoursModal" tabindex="-1" aria-labelledby="hoursModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://unpkg.com/infinite-scroll@4/dist/infinite-scroll.pkgd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script>
        $(document).ready(function() {
            var page = 1; // Keep track of the current page
            let isLoading = false;
            var load_More_Listings = true;

            function loadMoreListings(resetPage = false, url = null, page = 1) {
                if (resetPage) {
                    $('.listing-inner .row').html('');
                    $('html, body').animate({
                        scrollTop: 0
                    }, 100);
                    page = 1;
                }
                // Reset page number if needed
                var search = $('.search-filter').val();

                // Gather filter criteria
                var filters = {
                    page: page,
                    vendor_sub_category: [],
                    bedrooms: [],
                    person: [],
                    cuisines: [],
                    days: [],
                    establishment: [],
                    tasting_options: [],
                    farming_practices: [],
                    sub_region: [],
                    city: [],
                    price_point: [],
                    search: search,
                    avg_rating: [],
                };

                $('input[name="vendor_sub_category"]:checked').each(function() {
                    filters.vendor_sub_category.push($(this).val());
                });
                $('input[name="bedrooms"]:checked').each(function() {
                    filters.bedrooms.push($(this).val());
                });
                $('input[name="city"]:checked').each(function() {
                    filters.city.push($(this).val());
                });
                $('input[name="person"]:checked').each(function() {
                    filters.person.push($(this).val());
                });
                $('input[name="price_point"]:checked').each(function() {
                    filters.price_point.push($(this).val());
                });
                $('input[name="sub_region"]:checked').each(function() {
                    filters.sub_region.push($(this).val());
                });
                $('input[name="rating"]:checked').each(function() {
                    filters.avg_rating.push($(this).val());
                });

                $('input[name="cuisines"]:checked').each(function() {
                    filters.cuisines.push($(this).val());
                });

                $('input[name="days"]:checked').each(function() {
                    filters.days.push($(this).val());
                });

                $('input[name="tasting_options"]:checked').each(function() {
                    filters.tasting_options.push($(this).val());
                });

                $('input[name="establishment"]:checked').each(function() {
                    filters.establishment.push($(this).val());
                });

                $('input[name="farming_practices"]:checked').each(function() {
                    filters.farming_practices.push($(this).val());
                });

                // Send the AJAX request
                var requestUrl = url ? url : "{{ route('vendor.type.list') }}/{{ $vendor_type }}";

                $.ajax({
                    url: requestUrl, // Replace with your endpoint
                    method: 'POST',
                    data: filters,
                    beforeSend: function() {
                        $('#scroll-loader').show();
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        setTimeout(() => {
                            // Append the new listings to the existing ones
                            if (resetPage) {
                                $('.listing-inner .row').html(response.html);
                            } else {
                                if (!checkStringForRecords(response.html)) {
                                    load_More_Listings = false;
                                    $('#scroll-loader').hide();
                                    return;
                                }
                                $('.listing-inner .row').append(response.html);
                            }

                            setTimeout(() => {
                                var numSlick = 0;
                                $('.property-slider').each(function() {

                                    if (!$(this).hasClass('slick-slider')) {
                                        numSlick++;
                                        $(this).addClass('slider-' + numSlick)
                                            .slick({
                                                dots: true,
                                                infinite: true,
                                                speed: 300,
                                                slidesToShow: 1,
                                                slidesToScroll: 1,
                                                prevArrow: "<img class='a-left control-c prev slick-prev' src='images/prev-btn.png'>",
                                                nextArrow: "<img class='a-right control-c next slick-next' src='images/next-btn.png'>"
                                            });
                                    }
                                });
                                if ($(".rating-star").length > 0) {

                                    $('.rating-star').starRating({
                                        readOnly: true,
                                        initialRating: function(index, el) {
                                            // Set the initial rating based on your data
                                            return parseFloat($(el).attr(
                                                'data-rating'));
                                        },
                                        starSize: 15
                                    });
                                }
                                $('#scroll-loader').hide();
                                // isLoading = false;
                                load_More_Listings = true;
                            }, 1000);

                            // Append pagination
                            // $('.pagination-container').html(response
                            //     .pagination); // dynamically replace pagination
                        }, 1000);
                    },
                    error: function(error) {
                        console.error('Error loading more listings:', error);
                        // $('.loader').remove();
                    }
                });
            }

            if (load_More_Listings == true) {
                load_More_Listings = false;
                loadMoreListings();
            }

            // Detect when the user has scrolled to the end of the listing-inner div
            $(window).on('scroll', function() {

                if (($(window).scrollTop() + $(window).height() + $('header').height()) >= ($(document)
                        .height() - $('footer').height())) {
                    if (load_More_Listings == true && $('.no-more-records').length == 0 && $(
                            '.no-record-found').length == 0) {
                        load_More_Listings = false;
                        // Increment the page count
                        page++;
                        loadMoreListings(false, null, page);
                    }
                }
            });

            $('input[type="checkbox"].filter').on('change', function() {
                // Reset the page number and clear current listings
                loadMoreListings(true); // Pass true to reset the page number and replace content
            });
            $(document).delegate('.search-clear', "click", function() {
                if ($('.search-filter').val() != "") {
                    $('.search-filter').val('');
                    // Reset the page number and clear current listings
                    loadMoreListings(true); // Pass true to reset the page number and replace content
                }
            });
            $(document).delegate('.search-button', "click", function() {
                if ($('.search-filter').val() != "") {
                    // Reset the page number and clear current listings
                    loadMoreListings(true); // Pass true to reset the page number and replace content
                }
            });
            $('#search').keydown(function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault(); // Prevent form submission if inside a form
                    if ($('.search-filter').val() != "") {
                        loadMoreListings(true); // Pass true to reset the page number and replace content
                    }
                }
            });
            $(document).delegate('.vendorinqurey', 'click', function() {
                $("#inquiryvendorid").val($(this).attr('data-id'));
                $('#enquiryModal').modal('show');
            })
            $('#accommodationForm').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.success) {
                            $('#successMessage').show();
                            form.trigger('reset');
                            setTimeout(() => {
                                $('#successMessage').hide();
                            }, 3000);
                        } else {
                            alert('Error submitting form');
                        }
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });

            $('#search').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('filter.search') }}",
                        data: {
                            query: request.term,
                            type: "{{ $type }}"
                        },
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.name,
                                    value: item.name,
                                    id: item.id
                                };
                            }));
                        }
                    });
                },
                minLength: 2, // Trigger after 2 characters
                select: function(event, ui) {
                    // Optional: Do something with the selected vendor (ui.item)
                    console.log(ui.item.id + ": " + ui.item.value);
                }
            });
        });

        function checkStringForRecords(text) {
            // Check if the string 'records found' is present (case-insensitive)
            if (text.toLowerCase().includes('no more records found')) {
                return false; // Return false if the string is found
            }
            return true; // Return true if the string is not found
        }
        $(document).ready(function() {
            $(document).on('click', '.open-modal-btn', function() {
                // Get the URL or data-id to load content (if needed)
                var url = $(this).data('url') + '/' + $(this).data('id');

                // Clear previous modal content
                $('#hoursModal .modal-content').html('');

                // Make the AJAX request
                $.ajax({
                    url: url, // URL to fetch the data from
                    type: 'GET',
                    dataType: 'html', // Expect HTML response
                    beforeSend: function() {
                        // Optionally show a loader before sending the request
                        $('#hoursModal .modal-content').html(
                            '<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>'
                        );
                    },
                    success: function(response) {
                        // Insert the fetched HTML into the modal's body
                        $('#hoursModal .modal-content').html(response);

                        // Show the modal after data is fully loaded
                        $('#hoursModal').modal('show');
                    },
                    error: function(xhr) {
                        // Handle error
                        $('#hoursModal .modal-content').html(
                            '<p>Error loading data. Please try again later.</p>');
                    }
                });
            });
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
@endsection
