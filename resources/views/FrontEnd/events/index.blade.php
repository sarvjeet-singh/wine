@extends('FrontEnd.layouts.mainapp')
@section('content')
    <style>
        .image-loader {
            width: 400px;
            height: 200px;
        }

        /* Loader styling */
        .fb-loader {
            width: 336px;
            height: 252px;
            background: linear-gradient(90deg,
                    #e0e0e0 20%,
                    /* Light Gray */
                    #f5f5f5 40%,
                    /* Soft White */
                    #e0e0e0 60%
                    /* Light Gray */
                );
            background-size: 200% 100%;
            animation: fbShimmer 1.5s infinite;
            position: absolute;
            top: 0;
            left: 0;
        }

        /* Animation for loader */
        @keyframes fbShimmer {
            0% {
                background-position: 100% 0;
            }

            100% {
                background-position: -100% 0;
            }
        }
    </style>
    <section class="curated-event-sec my-sm-5 my-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2">
                    @include('FrontEnd.events.partials.filter')
                </div>
                <div class="col-lg-10 mt-lg-0 mt-5 d-none" id="eventList">
                    @if (!empty($featuredEvents) && count($featuredEvents) > 0)
                        <div class="row g-4 mb-3">
                            <div class="col-12">
                                <div
                                    class="event-head position-relative d-flex align-items-center justify-content-between gap-1 py-2">
                                    <h3 class="mb-0 fw-bold">Featured Events</h3>
                                </div>
                            </div>
                            @foreach ($featuredEvents as $featuredEvent)
                                @include('FrontEnd.events.partials.event-card', [
                                    'event' => $featuredEvent,
                                ])
                            @endforeach
                        </div>
                    @endif
                    <div class="row g-4 mb-3">
                        <div class="col-12">
                            <div
                                class="event-head position-relative d-flex align-items-center justify-content-between gap-1 py-2">
                                <h3 class="mb-0 fw-bold">Today Events</h3>
                                <div class="head-btn">
                                    <a href="{{ route('events') }}?date_filter[]=today" class="btn view-btn">View All</a>
                                </div>
                            </div>
                        </div>
                        @if (!empty($todayEvents) && count($todayEvents) > 0)
                            @foreach ($todayEvents as $todayEvent)
                                @include('FrontEnd.events.partials.event-card', ['event' => $todayEvent])
                            @endforeach
                        @else
                            <p>No events available.</p>
                        @endif
                    </div>
                    <div class="row g-4 mb-3">
                        <div class="col-12">
                            <div
                                class="event-head position-relative d-flex align-items-center justify-content-between gap-1 py-2">
                                <h3 class="mb-0 fw-bold">Tomorrow Events</h3>
                                <div class="head-btn">
                                    <a href="{{ route('events') }}?date_filter[]=tomorrow" class="btn view-btn">View
                                        All</a>
                                </div>
                            </div>
                        </div>
                        @if (!empty($tomorrowEvents) && count($tomorrowEvents) > 0)
                            @foreach ($tomorrowEvents as $tomorrowEvent)
                                @include('FrontEnd.events.partials.event-card', [
                                    'event' => $tomorrowEvent,
                                ])
                            @endforeach
                        @else
                            <p>No events available.</p>
                        @endif
                    </div>
                    <div class="row g-4 mb-3">
                        <div class="col-12">
                            <div
                                class="event-head position-relative d-flex align-items-center justify-content-between gap-1 py-2">
                                <h3 class="mb-0 fw-bold">Upcoming Events</h3>
                                <div class="head-btn">
                                    <a href="{{ route('events') }}?date_filter[]=upcoming" class="btn view-btn">View
                                        All</a>
                                </div>
                            </div>
                        </div>
                        @if (!empty($upcomingEvents) && count($upcomingEvents) > 0)
                            @foreach ($upcomingEvents as $upcomingEvent)
                                @include('FrontEnd.events.partials.event-card', [
                                    'event' => $upcomingEvent,
                                ])
                            @endforeach
                        @else
                            <p>No events available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
    <script>
        $(document).ready(function() {
            $(".image-loader").on("load", function() {
                $(".fb-loader").remove(); // Hide the loader
            });
        });
    </script>
    <script>
        let startDate = null;
        let endDate = null;
        let pricePicker = false;
        $(document).ready(function() {
            $('#searchInput').on('input', function() {
                let query = $(this).val();
                if (query.length < 2) {
                    $('#autocomplete-results').hide();
                    return;
                }

                $.ajax({
                    url: "{{ route('events.search') }}",
                    data: {
                        term: query
                    },
                    success: function(data) {
                        let dropdown = $('#autocomplete-results');
                        dropdown.empty().show();

                        let results = Object.values(data); // Extract values from object

                        if (results.length === 0) {
                            dropdown.append(
                                '<div class="dropdown-item">No results found</div>');
                        } else {
                            results.forEach(function(item) {
                                dropdown.append(
                                    `<div class="dropdown-item search-item">${item}</div>`
                                );
                            });

                            $('.search-item').click(function() {
                                $('#searchInput').val($(this).text());
                                dropdown.hide();
                                triggerFilter();
                            });
                        }
                    }
                });
            });

            $(document).click(function(e) {
                if (!$(e.target).closest('.search-bar').length) {
                    $('#autocomplete-results').hide();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.date-filter').on('change', function() {
                if ($(this).is(':checked') && $(this).val() == 'date_range') {
                    $('.date-filter').not(this).prop('checked', false);
                }
                if ($(this).val() != 'date_range') {
                    $("#date_range").prop('checked', false);
                }
                // Show Date Range Picker only if 'Date Range' is selected
                if ($('#date_range').is(':checked')) {
                    $('#dateRangePickerContainer').show();
                } else {
                    $('#dateRangePickerContainer').hide();
                    $('#dateRangePicker').val('');
                    startDate = null;
                    endDate = null;
                    triggerFilter();
                }
            });

            // Clear filter selections
            $('#clearDateFilters').on('click', function(e) {
                e.preventDefault();
                $('.date-filter').prop('checked', false);
                $('#dateRangePicker').val('');
                $('#dateRangePickerContainer').hide();
                triggerFilter();
            });
            $('#clearSearchFilters').on('click', function(e) {
                e.preventDefault();
                $('#searchInput').val('');
                triggerFilter();
            });
            $('#clearCategories').on('click', function(e) {
                e.preventDefault();
                $('.category-filter').prop('checked', false);
                triggerFilter();
            });
            $('#clearGenres').on('click', function(e) {
                e.preventDefault();
                $('.genre-filter').prop('checked', false);
                triggerFilter();
            });
            $('#clearRatings').on('click', function(e) {
                e.preventDefault();
                $('.rating-filter').prop('checked', false);
                triggerFilter();
            });
            $('#clearCities').on('click', function(e) {
                e.preventDefault();
                $('.city-filter').prop('checked', false);
            });
        });
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize Flatpickr Date Range Picker
            flatpickr("#dateRangePicker", {
                mode: "range",
                dateFormat: "Y-m-d",
                minDate: "today",
                maxDate: new Date().fp_incr(30), // Limit to 1 month
                onChange: function(selectedDates, dateStr) {
                    if (selectedDates.length === 2) {
                        startDate = formatDate(selectedDates[0]);
                        endDate = formatDate(selectedDates[1]);

                        console.log("Start Date:", startDate, "End Date:", endDate); // Debugging

                        triggerFilter();
                    }
                }
            });
        });

        function formatDate(date) {
            let year = date.getFullYear();
            let month = String(date.getMonth() + 1).padStart(2, '0'); // Ensure two digits
            let day = String(date.getDate()).padStart(2, '0'); // Ensure two digits
            return `${year}-${month}-${day}`;
        }
    </script>
    <script>
        function triggerFilter() {
            let selectedCategories = $('input[name="category"]:checked').map(function() {
                return $(this).val();
            }).get(); // Collect all checked categories as an array
            let selectedGenres = $('input[name="genre"]:checked').map(function() {
                return $(this).val();
            }).get(); // Collect all checked categories as an array
            let selectedCities = $('input[name="city"]:checked').map(function() {
                return $(this).val();
            }).get(); // Collect all checked categories as an array
            let selectedEventRatings = $('input[name="event_ratings"]:checked').map(function() {
                return $(this).val();
            }).get();
            let selectedDateFilter = $('input[name="date_filter[]"]:checked').map(function() {
                return $(this).val();
            }).get();

            let selectedDateRange = $('#dateRangePicker').val(); // Get date range if needed

            let isFree = $('#free-event').prop('checked') ? 1 : null; // Check if free event checkbox is checked
            let minPrice = $('#priceRange').attr('min');
            let maxPrice = $('#priceRange').val();
            let search = $('#searchInput').val();

            if (isFree || pricePicker === false || maxPrice == minPrice) {
                minPrice = null;
                maxPrice = null;
            }

            fetchFilteredEvents(selectedCategories, selectedDateFilter, selectedDateRange, isFree, minPrice,
                maxPrice, startDate, endDate, search, selectedGenres, selectedCities, selectedEventRatings);
        }
        $(document).ready(function() {
            // Function to trigger filtering on any change

            // Handle category filter change
            $('.category-filter').on('change', function() {
                triggerFilter();
            });

            $('.genre-filter').on('change', function() {
                triggerFilter();
            });

            $('.city-filter').on('change', function() {
                triggerFilter();
            });

            $('.rating-filter').on('change', function() {
                triggerFilter();
            });

            // When "Free" checkbox is selected, disable the price slider
            $('#free-event').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#priceRange').prop('disabled', true); // Disable slider
                } else {
                    $('#priceRange').prop('disabled', false); // Enable slider
                }

                triggerFilter();
            });

            // When price slider is used, uncheck the "Free" checkbox
            let priceTimer;

            $('#priceRange').on('input', function() {
                $('#free-event').prop('checked', false); // Uncheck free event checkbox
                $('#minValue').text(`$${$(this).val()}`); // Update price display

                clearTimeout(priceTimer);
                priceTimer = setTimeout(() => {
                    pricePicker = true;
                    triggerFilter();
                }, 500); // Adds a delay to avoid excessive calls while sliding
            });

            // Clear price filter
            $('#clearPriceFilter').on('click', function(e) {
                e.preventDefault();
                $('#free-event').prop('checked', false); // Uncheck free checkbox
                let minPrice = $('#priceRange').attr('min'); // Reset slider
                $('#priceRange').val(minPrice).prop('disabled', false);
                $('#minValue').text(`$${minPrice}`); // Update display
                pricePicker = false;
                triggerFilter();
            });
        });

        function fetchFilteredEvents(categories, dateFilter, dateRange, isFree, minPrice, maxPrice, startDate, endDate,
            searchTerm, genres, cities, eventRatings) {
            $.ajax({
                url: "{{ route('get-events') }}", // Replace with your actual route
                type: "GET",
                data: {
                    categories: categories,
                    date_filter: dateFilter,
                    // date_range: dateRange,
                    is_free: isFree,
                    min_price: minPrice,
                    max_price: maxPrice,
                    start_date: startDate,
                    end_date: endDate,
                    q: searchTerm,
                    genres: genres,
                    cities: cities,
                    event_ratings: eventRatings
                },
                success: function(response) {
                    $('#eventList').html(response.html); // Dynamically update event list

                    // ✅ Update URL with proper [] notation
                    let params = new URLSearchParams();

                    categories.forEach(category => params.append("categories[]", category));

                    dateFilter.forEach(date => params.append("date_filter[]", date));

                    if (dateRange.start && dateRange.end) {
                        params.append("start_date", dateRange.start);
                        params.append("end_date", dateRange.end);
                    }
                    if (isFree) params.set("is_free", 1);
                    if (minPrice) params.set("min_price", minPrice);
                    if (maxPrice) params.set("max_price", maxPrice);

                    if (startDate && endDate) {
                        params.set("start_date", startDate);
                        params.set("end_date", endDate);
                    }

                    if (searchTerm) params.set("q", searchTerm);

                    if (genres.length > 0) {
                        genres.forEach(genre => params.append("genres[]", genre));
                    }

                    if (cities.length > 0) {
                        cities.forEach(city => params.append("cities[]", city));
                    }

                    if (eventRatings.length > 0) {
                        eventRatings.forEach(event_rating => params.append("event_ratings[]", event_rating));
                    }

                    let newUrl = `${window.location.pathname}?${params.toString()}`;
                    history.pushState(null, "", newUrl);
                },
                error: function(xhr) {
                    console.error("Error fetching filtered events:", xhr);
                }
            });
        }
        $(document).ready(function() {
            let params = new URLSearchParams(window.location.search);

            let categories = params.getAll("categories[]") || [];
            let dateFilter = params.getAll("date_filter[]") || [];
            let eventRatings = params.getAll("event_ratings[]") || [];
            let genres = params.getAll("genres[]") || [];
            let cities = params.getAll("cities[]") || [];
            let startDate = params.get("start_date") || null;
            let endDate = params.get("end_date") || null;
            let isFree = params.get("is_free") ? 1 : null;
            let minPrice = params.get("min_price") || "";
            let maxPrice = params.get("max_price") || "";
            let searchTerm = params.get("q") || "";

            let dateRange = {
                start: startDate,
                end: endDate
            };

            // ✅ Restore UI elements
            categories.forEach(cat => $(`input[name="categories"][value="${cat}"]`).prop("checked", true));
            genres.forEach(genre => $(`input[name="genres"][value="${genre}"]`).prop("checked", true));
            cities.forEach(city => $(`input[name="cities"][value="${city}"]`).prop("checked", true));
            eventRatings.forEach(rating => $(`input[name="event_ratings"][value="${rating}"]`).prop("checked",
                true));
            dateFilter.forEach(df => $(`input[name="date_filter"][value="${df}"]`).prop("checked", true));

            if (startDate && endDate) {
                $("#dateRangePicker").val(`${startDate} to ${endDate}`);
            }

            if (isFree) $("#free-event").prop("checked", true);
            if (minPrice) $("#minValue").text(`$${minPrice}`);
            if (maxPrice) $("#maxValue").text(`$${maxPrice}`);
            if (params.size == 0) return false;
            // ✅ Fetch events with preloaded filters
            fetchFilteredEvents(categories, dateFilter, dateRange, isFree, minPrice, maxPrice, startDate, endDate,
                search, selectedGenres, selectedCities, selectedEventRatings);
        });

        // Load filters from URL on page refresh
        function loadFiltersFromURL() {
            let params = new URLSearchParams(window.location.search);
            let hasFilter = false; // Track if any param exists

            // Restore category selections
            params.getAll("categories[]").forEach(category => {
                $(`.category-filter[value="${category}"]`).prop("checked", true);
                hasFilter = true;
            });

            params.getAll("genres[]").forEach(category => {
                $(`.genre-filter[value="${category}"]`).prop("checked", true);
                hasFilter = true;
            });

            params.getAll("cities[]").forEach(category => {
                $(`.city-filter[value="${category}"]`).prop("checked", true);
                hasFilter = true;
            });

            params.getAll("event_ratings[]").forEach(event_rating => {
                $(`.rating-filter[value="${event_rating}"]`).prop("checked", true);
                hasFilter = true;
            });

            params.getAll("date_filter[]").forEach(date => {
                $(`.date-filter[value="${date}"]`).prop("checked", true);
                hasFilter = true;
            });

            if (params.has("min_price")) {
                $('#priceRange').val(params.get("min_price"));
                $('#minValue').text(`$${params.get("min_price")}`);
                hasFilter = true;
            }

            if (params.has("is_free")) {
                $('#free-event').prop("checked", params.get("is_free") === "1");
                hasFilter = true;
            }

            if (params.has("start_date") && params.has("end_date")) {
                $('#dateRangePicker').val(`${params.get("start_date")} - ${params.get("end_date")}`);
                $('#dateRangePickerContainer').show();
                $('#date_range').prop("checked", true);
                hasFilter = true;
            }

            if (params.has("q")) {
                $('#searchInput').val(params.get("q"));
                hasFilter = true;
            }

            // Trigger filter only if any param exists
            if (hasFilter) {
                triggerFilter();
            }
            setTimeout(() => {
                $("#eventList").removeClass("d-none");
            }, 500); // Hide the dropdown after 0.5 seconds
        }
        loadFiltersFromURL();
    </script>
@endsection
