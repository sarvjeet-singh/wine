@extends('FrontEnd.layouts.mainapp')

@section('content')
    <style>
        .pagination .page-item.active .page-link {
            background-color: var(--theme-main-color);
            color: #fff;
        }
    </style>
    <!-- ========== Tab Sec Start ========== -->
    <section class="tab-content-sec listing-head-bar">
        <div class="container">
            <div class="inner-content">
                <ul class="list-unstyled d-flex justify-content-center align-items-center mb-0">
                    <li><a href="{{ route('excursion-listing') }}" class="text-decoration-none">Licensed</a></li>
                </ul>
            </div>
        </div>
    </section>
    <!-- ========== Tab Sec End ========== -->
    <section class="listing-outer my-sm-3 my-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-2 col-md-3 col-sm-4">
                    <div class="fixed-sidebar mb-sm-0 mb-4">
                        <div class="head pt-3">
                            {{-- <h2>Excursion</h2> --}}
                        </div>
                        <!-- Filter Search Box -->
                        <div class="filter-search-box mb-3">
                            <div class="input-group flex-nowrap">
                                <div class="form-outline w-100 search-container" data-mdb-input-init>
                                    <input type="search" id="search" placeholder="Search"
                                        class="form-control search-filter" />
                                    <span class="search-clear"><i class="fas fa-times"></i></span>
                                </div>
                                <button type="button" class="btn btn-primary search-button" data-mdb-ripple-init>
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /Filter Search Box -->
                        <div class="side-filter border rounded-3 p-3">
                            <div class="filter-box mb-3">
                                <h6>Licensed Sub-Category</h6>
                                @if (count($subCategories) > 0)
                                    @foreach ($subCategories as $subCategory)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="vendor_sub_category"
                                                value="{{ $subCategory->id }}" id="{{ $subCategory->slug }}">
                                            <label class="form-check-label"
                                                for="{{ $subCategory->slug }}">{{ $subCategory->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="filter-box mb-3">
                                <h6>City/Town</h6>
                                <!-- <div class="form-check">
                               <input class="form-check-input" type="checkbox" value="" id="Least">
                               <label class="form-check-label" for="Least">
                               $ Least Expensive
                               </label>
                               </div> -->
                                @php
                                    use App\Models\Vendor;
                                    $cities = Vendor::where('vendor_type', 'licensed')->distinct()->pluck('city');
                                @endphp
                                @foreach ($cities as $city)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="city"
                                            value="{{ $city }}" id="{{ $city }}">
                                        <label class="form-check-label" for="{{ $city }}">
                                            {{ $city }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="filter-box mb-3">
                                <h6>Cuisine</h6>
                                @if (count($cuisines) > 0)
                                    @foreach ($cuisines as $cuisine)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="cuisines"
                                                value="{{ $cuisine->id }}" id="{{ $cuisine->slug }}">
                                            <label class="form-check-label" for="{{ $cuisine->slug }}">
                                                {{ $cuisine->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="filter-box mb-3">
                                <h6>Hours of Operation</h6>

                                @php
                                    $daysOfWeek = [
                                        'monday',
                                        'tuesday',
                                        'wednesday',
                                        'thursday',
                                        'friday',
                                        'saturday',
                                        'sunday',
                                    ];
                                @endphp

                                @foreach ($daysOfWeek as $day)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="days"
                                            value="{{ $day }}" id="{{ $day }}">
                                        <label class="form-check-label" for="{{ $day }}">
                                            {{ ucfirst($day) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="filter-box mb-3">
                                <h6>Star Rating </h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="rating" value="1"
                                        id="1star">
                                    <label class="form-check-label" for="1star">
                                        *
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="rating" value="2"
                                        id="2star">
                                    <label class="form-check-label" for="2star">
                                        **
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="rating" value="3"
                                        id="3star">
                                    <label class="form-check-label" for="3star">
                                        ***
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="rating" value="4"
                                        id="4star">
                                    <label class="form-check-label" for="4star">
                                        ****
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="rating" value="5"
                                        id="5star">
                                    <label class="form-check-label" for="5star">
                                        *****
                                    </label>
                                </div>
                            </div>
                            <div class="filter-box mb-3">
                                <h6>Price Point Rating</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="Least">
                                    <label class="form-check-label" for="Least">
                                        $ Least
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="LowModerately">
                                    <label class="form-check-label" for="LowModerately">
                                        $$ Low Moderately
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="ModeratelyHigh">
                                    <label class="form-check-label" for="ModeratelyHigh">
                                        $$$ Moderately High
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="MostExpensive">
                                    <label class="form-check-label" for="MostExpensive">
                                        $$$$ Most Expensive
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-10 col-md-9 col-sm-8">
                    <div class="listing-inner mb-5">
                        <div class="row gy-4">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="fullpageloader"><img src="{{ asset('images/loader.svg') }}" class="loader"></div>

    <!-- Hours Popup -->
    <div class="modal fade hours-modal" id="hoursModal" tabindex="-1" aria-labelledby="hoursModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title fs-6" id="hoursModal">Chitra - Shaw Festival</h2>
                    <button type="button" class="btn-close p-2" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center mb-3 fs-6"><span class="d-block theme-color fw-bold fs-5 text-uppercase">Open
                            Now</span> Closes at 3:30 PM</h3>
                    <ul class="list-unstyled mb-0">
                        <li class="active">
                            <span class="weekday">Sunday</span>
                            <span class="avail">1:15 AM - 3:30 PM</span>
                        </li>
                        <li>
                            <span class="weekday">Monday</span>
                            <span class="avail">Closed</span>
                        </li>
                        <li>
                            <span class="weekday">Tuesday</span>
                            <span class="avail">Closed</span>
                        </li>
                        <li>
                            <span class="weekday">Wednesday</span>
                            <span class="avail">Closed</span>
                        </li>
                        <li>
                            <span class="weekday">Thursday</span>
                            <span class="avail">Closed</span>
                        </li>
                        <li>
                            <span class="weekday">Friday</span>
                            <span class="avail">Closed</span>
                        </li>
                        <li>
                            <span class="weekday">Saturday</span>
                            <span class="avail">Closed</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /Hours Popup -->
    <!-- Inquiry Fomr Popup -->
    <div class="modal fade enquiry-modal" id="enquiryModal" tabindex="-1" aria-labelledby="enquiryModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header flex-column text-center position-relative border-0">
                    <h2 class="modal-title fs-4 text-uppercase theme-color" id="enquiryModal">Excursion Inquiry</h2>
                    <p class="mb-0">To initiate an inquiry please complete and submit this form. An Experience Curator
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
                                    <input id="datepicker" class="form-control" placeholder="dd/mm/yyyy" name="check_in"
                                        type="date" data-fv-field="check_in" required="" min="2024-06-25">
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
                                    <label class="mb-1">What if any, type(s) of excursions are you considering?</label>
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
                                    <label class="mb-1">Will you require accommodations and if so, what is your preferred
                                        type?</label>
                                    <div class="require_acco">
                                        <ul class="list-unstyled mb-0 d-flex align-items-center gap-2">
                                            <li>
                                                <input type="radio" name="preferred_accommodation" id="preferred_yes"
                                                    value="Yes" onclick="handleCheckbox(this)"><label
                                                    for="preferred_yes">Yes </label>
                                            </li>
                                            <li>
                                                <input type="radio" name="preferred_accommodation" id="preferred_no"
                                                    value="No" onclick="handleCheckbox(this)"><label
                                                    for="preferred_no">No</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-1">In what sub-region would you prefer to be accommodated?</label>
                                    <select class="form-control" name="sub_region" id="sub_region_select">
                                        <option value="">--Select--</option>
                                        <option value="">--Select--</option>
                                        <option value="Niagara Falls">Niagara Falls</option>
                                        <option value="Niagara-on-the-Lake">Niagara-on-the-Lake</option>
                                        <option value="Niagara Escarpment / Twenty Valley">Niagara Escarpment / Twenty
                                            Valley</option>
                                        <option value="South Escarpment">South Escarpment</option>
                                        <option value="Fort Erie / Niagara’s South Coast">Fort Erie / Niagara’s South Coast
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
    <!-- /Inquiry Fomr Popup -->
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            var page = 1; // Keep track of the current page
            var load_More_Listings = true;

            function loadMoreListings(resetPage = false, url = null, page = 1) {
                // Reset page number if needed
                var search = $('.search-filter').val();

                // Gather filter criteria
                var filters = {
                    page: page,
                    vendor_sub_category: [],
                    city: [],
                    days: [],
                    cuisines: [],
                    price_point: [],
                    sub_region: [],
                    search: search,
                    avg_rating: [],
                };

                $('input[name="vendor_sub_category"]:checked').each(function() {
                    filters.vendor_sub_category.push($(this).val());
                });
                $('input[name="city"]:checked').each(function() {
                    filters.city.push($(this).val());
                });
                $('input[name="days"]:checked').each(function() {
                    filters.days.push($(this).val());
                });
                $('input[name="cuisines"]:checked').each(function() {
                    filters.cuisines.push($(this).val());
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
                var requestUrl = url ? url : "{{ route('get.licensed') }}";

                $.ajax({
                    url: requestUrl, // Replace with your endpoint
                    method: 'POST',
                    data: filters,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $('.fullpageloader').show();
                    },
                    success: function(response) {
                        setTimeout(() => {
                            // Append the new listings to the existing ones
                            $('.listing-inner .row').html(response.html);

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
                                $('.fullpageloader').hide();
                            }, 1000);

                            // Append pagination
                            $('.pagination-container').html(response
                                .pagination); // dynamically replace pagination
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

            // Handle pagination click events
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href'); // Get the URL for the next page
                var page = $(this).attr('href').split('page=')[1];
                loadMoreListings(false, url, page); // Call the AJAX load function with the new URL
            });

            $(document).delegate('.vendorinqurey', 'click', function() {
                $("#inquiryvendorid").val($(this).attr('data-id'));
                $('#enquiryModal').modal('show');
            })
            // Detect when the user has scrolled to the end of the listing-inner div
            // $(window).on('scroll', function() {
            //     if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
            //         console.log('Reached end of scroll.');
            //         if (load_More_Listings == true && $('.no-more-records').length == 0 && $(
            //                 '.no-record-found').length == 0) {
            //             load_More_Listings = false;
            //             loadMoreListings();
            //         }

            //     }
            // });
            $('input[type="checkbox"]').on('change', function() {
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
        });
    </script>
    <script>
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
        $(document).ready(function() {
            $('#search').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('filter.search') }}",
                        data: {
                            query: request.term,
                            type: 'licensed'
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
    </script>
@endsection