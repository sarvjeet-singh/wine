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
                    <li><a href="{{ route('accommodations') }}" class="text-decoration-none">Accommodations</a></li>
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
                            {{-- <h2>Accommodations</h2> --}}
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
                                <h6>Sub-Category</h6>
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
                                <h6>Sub-Region</h6>
                                @if (count($subRegions) > 0)
                                    @foreach ($subRegions as $subRegion)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="sub_region"
                                                value="{{ $subRegion->id }}" id="{{ $subRegion->slug }}">
                                            <label class="form-check-label" for="{{ $subRegion->slug }}">
                                                {{ $subRegion->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="filter-box mb-3">

                                <h6>City/Town </h6>
                                <!-- <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="2" name="bedrooms" id="2Bedrooms">
                                        <label class="form-check-label" for="2Bedrooms">
                                         2 Bedrooms
                                        </label>
                                       </div> -->
                                @php
                                    use App\Models\Vendor;
                                    $cities = Vendor::where('vendor_type', 'accommodation')->distinct()->pluck('city');
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
                                <h6>Bedrooms</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" name="bedrooms"
                                        id="1Bedroom">
                                    <label class="form-check-label" for="1Bedroom">
                                        1 Bedroom(s)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="2" name="bedrooms"
                                        id="2Bedrooms">
                                    <label class="form-check-label" for="2Bedrooms">
                                        2 Bedroom(s)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="3" name="bedrooms"
                                        id="3Bedrooms">
                                    <label class="form-check-label" for="3Bedrooms">
                                        3 Bedroom(s)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="4+" name="bedrooms"
                                        id="4Bedrooms">
                                    <label class="form-check-label" for="4Bedrooms">
                                        4+ Bedroom(s)
                                    </label>
                                </div>
                            </div>
                            <div class="filter-box mb-3">
                                <h6>Beds / Sleeps</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="2" name="person"
                                        id="1Person">
                                    <label class="form-check-label" for="1Persons">
                                        1 Bed / Sleeps 2
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="4" name="person"
                                        id="4Persons">
                                    <label class="form-check-label" for="4Persons">
                                        2 Beds / Sleeps 4
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="6" name="person"
                                        id="6Persons">
                                    <label class="form-check-label" for="6Persons">
                                        3 Beds / Sleeps 6
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="8+" name="person"
                                        id="8Persons">
                                    <label class="form-check-label" for="8Persons">
                                        4+ Beds / Sleeps 8+
                                    </label>
                                </div>
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
                                <h6>Price Point</h6>
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
                <div class="col-xl-10 col-md-9 col-sm-8" style="position: relative;">
                    <div class="listing-inner mb-5">
                        <div class="row gy-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="fullpageloader"><img src="{{ asset('images/loader.svg') }}" class="loader"></div>
    <div class="modal fade enquiry-modal" id="enquiryModal" tabindex="-1" aria-labelledby="enquiryModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header flex-column text-center position-relative border-0">
                    <h2 class="modal-title fs-4 text-uppercase theme-color" id="enquiryModal">Accommodaion Inquiry</h2>
                    <p class="mb-0">To initiate an inquiry please complete and submit this form. An Experience Curator
                        will follow up shortly.</p>
                    <button type="button" class="btn-close p-2" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div id="successMessage" style="display:none">
                        <div class="alert alert-success">
                            Inquiry Submit Successfully.
                        </div>
                    </div>
                    <form class="container" id="accommodationFrom" method="post" enctype="multipart/form-data"
                        action="{{ route('accommodation.inquiry') }}">
                        @csrf
                        <input type="hidden" name="vendor_id" id="inquiryvendorid" value="">
                        <div class="row mb-3">
                            <div class="col-lg-6 mb-lg-0 mb-3">
                                <div class="form-group">
                                    <label class="mb-1">What is your tentative travel/check-in date?</label>
                                    <input id="datepicker" class="form-control" name="check_in" type="date" required
                                        min="2024-06-25">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-1">What is your tentative travel/check-out date?</label>
                                    <input id="datepicker2" class="form-control" name="check_out" type="date"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6 mb-lg-0 mb-3">
                                <div class="form-group">
                                    <label class="mb-1">What is the nature of your visit?</label>
                                    <select class="form-control" name="visit_nature" required>
                                        <option value="">--Select--</option>
                                        <option value="Business">Business</option>
                                        <option value="Pleasure">Pleasure</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-1">How many guests are in your travel party?</label>
                                    <input type="number" class="form-control" name="guest_no" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-6 mb-lg-0 mb-3">
                                <div class="form-group">
                                    <label class="mb-1">What is your preferred accommodation type?</label>
                                    <select class="form-control" name="vendor_sub_category" required>
                                        <option value="">--Select--</option>
                                        <option value="Hotel">Hotel</option>
                                        <option value="Motel">Motel</option>
                                        <option value="Inn">Inn</option>
                                        <option value="B&B">B&B</option>
                                        <option value="Vacation Property (Entire Home)">Vacation Property (Entire Home)
                                        </option>
                                        <option value="Vacation Property (Guest House)">Vacation Property (Guest House)
                                        </option>
                                        <option value="Serviced Apartment">Serviced Apartment</option>
                                        <option value="Furnished Room">Furnished Room</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="mb-1">What sub-region would you prefer to be located?</label>
                                    <select class="form-control" name="sub_region" required>
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
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="mb-1">Please indicate the number of rooms required.</label>
                                    <input type="number" class="form-control" name="rooms_required" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="mb-1">Additional Comments:</label>
                                    <textarea name="additional_comments_inquiry" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="col-md-12 text-center formbtn">
                                    <button type="submit" id="execursionInqBtn">Submit</button>
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
                    bedrooms: [],
                    person: [],
                    price_point: [],
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
                var requestUrl = url ? url : "{{ route('get.accommodation') }}";

                $.ajax({
                    url: requestUrl, // Replace with your endpoint
                    method: 'POST',
                    data: filters,
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

            // Detect when the user has scrolled to the end of the listing-inner div
            // $(window).on('scroll', function() {

            //     if (($(window).scrollTop() + $(window).height() + $('header').height()) >= ($(document)
            //             .height() - $('footer').height())) {
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
        });
        $(document).ready(function() {
            $('#search').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('filter.search') }}",
                        data: {
                            query: request.term,
                            type: 'Accommodation'
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
