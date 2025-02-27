@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')
    <style>
        /* Style the dates that are part of the package */

        .daterangepicker td div {
            pointer-events: none;
        }

        .daterangepicker .ends {
            visibility: hidden;
            /* Hides dates from previous/next months */
        }

        .cojoinDates div {
            position: relative;
            display: inline-block;
            text-align: center;
            width: 30px;
            /* Width of the circle */
            height: 30px;
            /* Height of the circle */
            line-height: 30px;
            /* Vertical centering */
            border-radius: 0%;
            /* Makes the date a circle */
            border: 2px solid var(--theme-main-color);
            /* Circle border */
        }

        /* Add a line to the left of the <div>, except for the first cell */
        .cojoinDates:not(.start-package) div::before {
            content: '';
            position: absolute;
            top: 50%;
            left: -20px;
            width: 20px;
            height: 2px;
            background-color: black;
            transform: translateY(-50%);
        }

        /* Add a line to the right of the <div>, except for the last cell */
        .cojoinDates:not(.end-package) div::after {
            content: '';
            position: absolute;
            top: 50%;
            right: -20px;
            /* Adjust based on spacing between cells */
            width: 20px;
            height: 2px;
            background-color: black;
            transform: translateY(-50%);
        }
    </style>
    <div class="col right-side">
        <div class="row">
            <div class="col-sm-12">
                <div class="information-box">
                    <div class="information-box-head">
                        <div class="box-head-heading d-flex">
                            <span class="box-head-label theme-color w-50">Inventory Manage</span>
                            <button class="btn btn-primary wine-btn manage_dates ms-auto px-4">Manage Dates</button>
                        </div>
                    </div>
                    <div class="information-box-body pb-5">
                        <form name="frmain" id="dateform" action="" method="POST">
                            @csrf
                            <input type="hidden" name="vendor_id" value="1">
                            <input type="hidden" name="start_date" value="" id="firstdate">
                            <input type="hidden" name="end_date" value="" id="seconddate">
                            <input type="hidden" name="booking_type" value="" id="booking_type">
                            <input type="hidden" name="type_reason" value="" id="type_reason">
                            <input type="hidden" name="type" value="vendor">
                            <div class="row align-items-end mt-3">
                                <!-- <div class="col-sm-4 col-12">
                                                                <label class="form-label">Apply Value</label>
                                                                <select class="form-control" name="booking_date_option">
                                                                    <option value="booked">Booked Dates</option>
                                                                    <option value="packaged">Package Dates</option>
                                                                    <option value="blocked">Blocked Dates</option>
                                                                </select>
                                                            </div> -->
                                <div class="col-sm-4 col-12">
                                    <label class="form-label">Select Season</label>
                                    @php
                                        $currentYear = date('Y');
                                        $currentMonth = date('m');
                                        $nextYear = $currentYear + 1;

                                        $seasons = [
                                            'winter' => [
                                                'name' => 'Winter',
                                                'start' => 'Dec 21',
                                                'end' => 'Mar 20',
                                                'year' =>
                                                    $currentMonth == 12 || $currentMonth <= 3
                                                        ? $currentYear
                                                        : $nextYear,
                                            ],
                                            'spring' => [
                                                'name' => 'Spring',
                                                'start' => 'Mar 21',
                                                'end' => 'Jun 20',
                                                'year' =>
                                                    $currentMonth >= 3 && $currentMonth <= 6 ? $currentYear : $nextYear,
                                            ],
                                            'summer' => [
                                                'name' => 'Summer',
                                                'start' => 'Jun 21',
                                                'end' => 'Sept 20',
                                                'year' =>
                                                    $currentMonth >= 6 && $currentMonth <= 9 ? $currentYear : $nextYear,
                                            ],
                                            'fall' => [
                                                'name' => 'Fall',
                                                'start' => 'Sept 21',
                                                'end' => 'Dec 20',
                                                'year' =>
                                                    $currentMonth >= 9 && $currentMonth <= 12
                                                        ? $currentYear
                                                        : $nextYear,
                                            ],
                                        ];

                                        // Special logic for winter:
                                        if ($currentMonth == 12) {
                                            $seasons['winter']['year'] = $currentYear; // Dec 21 of this year to Mar 20 of next year
                                        } elseif ($currentMonth <= 3) {
                                            $seasons['winter']['year'] = $currentYear - 1; // Carryover from last year to this year
                                        } else {
                                            $seasons['winter']['year'] = $nextYear; // Future winter season
                                        }
                                    @endphp
                                    <select class="form-control form-select season-clender" id="seasonSelect">
                                        @foreach ($seasons as $key => $season)
                                            <option value="{{ $key }}">
                                                {{ $season['name'] }} {{ $season['year'] }} ({{ $season['start'] }} -
                                                {{ $season['end'] }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4 col-12">
                                    <button type="button" id="publish_dates" class="btn wine-btn px-5">Publish
                                        Sesson</button>
                                </div>
                                <div class="col-sm-4 col-12 text-right">

                                </div>
                            </div>

                            <div class="row datefilter_input position-relative mt-3">
                                <div class="col-xl-12 col-lg-12 col-sm-12 col-md-12" id="datepicker-container">
                                    <input type="text" name="datefilter" value="" placeholder="Select the Dates"
                                        id="datefilter_input" readonly />
                                </div>
                                <div class="batch-sec">
                                    @if (count($publishedSeasons) > 0)
                                        @foreach ($publishedSeasons as $publishedSeason)
                                            @if ($publishedSeason->season_type == 'summer')
                                                <img class="publish-season summer"
                                                    src="{{ asset('images/summer-published-batch.png') }}"
                                                    alt="Summer Published">
                                            @elseif($publishedSeason->season_type == 'winter')
                                                <img class="publish-season winter"
                                                    src="{{ asset('images/winter-published-batch.png') }}"
                                                    alt="Winter Published">
                                            @elseif($publishedSeason->season_type == 'spring')
                                                <img class="publish-season spring"
                                                    src="{{ asset('images/spring-published-batch.png') }}"
                                                    alt="Spring Published">
                                            @elseif($publishedSeason->season_type == 'fall')
                                                <img class="publish-season fall"
                                                    src="{{ asset('images/fall-published-batch.png') }}"
                                                    alt="Fall Published">
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <!-- <div class="row mt-5">
                                                            <div class="col-sm-12 text-center">
                                                                <button type="submit" class="btn wine-btn" id="dateform_submit"
                                                                    disabled>Update</button>
                                                            </div>
                                                        </div> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="MangeDatesPopUp" tabindex="-1" role="dialog" aria-labelledby="MangeDatesLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="MangeDatesLabel">All Dates</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-5">
                    <!-- Add your form or content here -->
                    <div style="position: absolute;top:10px;right: 15px;z-index: 9999;">
                        <select class="filterDateTypes form-control">
                            <option value="All">All</option>
                            <option value="booked">Booked Dates</option>
                            <option value="blocked">Blocked Dates</option>
                            <option value="packaged">Package Dates</option>
                        </select>
                    </div>
                    <table id="myTable">
                        <thead>
                            <tr>
                                <th>S. No.</th>
                                <th>Dates</th>
                                <th>Value</th>
                                <th>Reason</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @php($vendorid = request()->route('vendorid'));
    <script>
        function wrapDatesWithDiv() {
            $('.daterangepicker td').each(function() {
                if (!$(this).find('div').length) {
                    $('.cojoinDates.available').removeClass('available');
                    $(this).html('<div>' + $(this).html() + '</div>');
                }
            });
        }

        function daterangepickerDesktop(target, seasonDate, seasonEndDate, allcojoinDates = "", unavailableDates = "",
            bookedAndBlockeddates = "", checkOutOnly = "", checkInOnly = "") {

            // unavailableDates = unavailableDates.concat(allcojoinDates);
            // alert(seasonEndDate);
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
                    for (let i = 0; i < allcojoinDates.length; i++) {
                        for (let j = 0; j < allcojoinDates[i].length; j++) {
                            if (currDate == allcojoinDates[i][j] && $.inArray(allcojoinDates[i][j],
                                    unavailableDates) ==
                                -1) {
                                if (allcojoinDates[i][j] == allcojoinDates[i][0]) {
                                    return "cojoinDates start-package";
                                } else if (allcojoinDates[i][j] == allcojoinDates[i][allcojoinDates[i].length -
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

                    for (let i = 0; i < checkInOnly.length; i++) {
                        if (currDate == checkInOnly[i] && $.inArray(checkInOnly[i], unavailableDates) == -1) {
                            return "checkinonly";
                        }
                    }
                }

            }).on('show.daterangepicker', function(ev, picker) {
                setTimeout(function() {
                    wrapDatesWithDiv();
                }, 0);
            });;
        }

        function daterangepickerMobile(target, seasonDate, seasonEndDate, allcojoinDates = "", unavailableDates = "",
            bookedAndBlockeddates = "", checkOutOnly = "", checkInOnly = "") {
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

                    for (let i = 0; i < allcojoinDates.length; i++) {
                        if (currDate == allcojoinDates[i] && $.inArray(allcojoinDates[i], unavailableDates) == -
                            1) {
                            return "cojoinDates";
                        }
                    }
                    for (let i = 0; i < checkOutOnly.length; i++) {
                        if (currDate == checkOutOnly[i] && $.inArray(checkOutOnly[i], unavailableDates) == -1) {
                            return "checkoutonly";
                        }
                    }

                    for (let i = 0; i < checkInOnly.length; i++) {
                        if (currDate == checkInOnly[i] && $.inArray(checkInOnly[i], unavailableDates) == -1) {
                            return "checkinonly";
                        }
                    }
                }
            });
        }

        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var currentDate = new Date();
        var currentMonth = currentDate.getMonth();
        var currentDay = currentDate.getDate();
        var currentSeason = "";
        if (
            (currentMonth === 11 && currentDay >= 21) || // Winter (Dec 21 - Dec 31)
            (currentMonth === 0 || currentMonth === 1) || // Winter (Jan 1 - Feb 28/29)
            (currentMonth === 2 && currentDay <= 20) // Winter (Mar 1 - Mar 20)
        ) {
            currentSeason = "winter";
        } else if (
            (currentMonth === 2 && currentDay >= 21) || // Spring (Mar 21 - Mar 31)
            (currentMonth === 3 || currentMonth === 4) || // Spring (Apr 1 - May 31)
            (currentMonth === 5 && currentDay <= 20) // Spring (Jun 1 - Jun 20)
        ) {
            currentSeason = "spring";
        } else if (
            (currentMonth === 5 && currentDay >= 21) || // Summer (Jun 21 - Jun 30)
            (currentMonth === 6 || currentMonth === 7) || // Summer (Jul 1 - Aug 31)
            (currentMonth === 8 && currentDay <= 20) // Summer (Sep 1 - Sep 20)
        ) {
            currentSeason = "summer";
        } else {
            currentSeason = "fall";
        }

        // Set the selected option in the dropdown based on the current season
        $("#seasonSelect").val(currentSeason);



        var currentYear = new Date().getFullYear();
        var NextYear = currentYear + 1;
        var seasonDate = new Date("March 21, " + currentYear);
        var seasonEndDate = new Date("June 20, " + currentYear);
        var vendor_id = "{{ $vendorid }}";

        function updateSeasonDates(value, vendor_id, click) {
            $(".overlay-loader").show();
            $.ajax({
                type: 'GET',
                url: "{{ route('manage.booking.utility.ajax', ['vendorid' => $vendorid]) }}",
                data: {
                    "season_type": value
                },
                success: function(response) {

                    var data = response.data;
                    var allcojoinDates = data.cojoinDates;
                    var unavailableDates = data.dates;
                    var bookedAndBlockeddates = data.bookedAndBlockeddates;
                    var checkOutOnly = data.checkOutOnly;
                    var checkInOnly = data.checkInOnly;

                    var seasonDate, seasonEndDate;
                    var today = new Date(); // Get today's date
                    var currentYear = today.getFullYear();
                    var currentMonth = today.getMonth();
                    var currentDay = today.getDate();
                    var nextYear = currentYear + 1;

                    if (value == 'spring') {
                        seasonDate = new Date(currentYear, 2, 21); // March 21
                        seasonEndDate = new Date(currentYear, 5, 20); // June 20

                        // If today's date is after the spring end date, set spring for next year
                        if (today > seasonEndDate) {
                            seasonDate = new Date(nextYear, 2, 21); // March 21 next year
                            seasonEndDate = new Date(nextYear, 5, 20); // June 20 next year
                        }
                    } else if (value == 'summer') {
                        seasonDate = new Date(currentYear, 5, 21); // June 21
                        seasonEndDate = new Date(currentYear, 8, 20); // September 20

                        // If today's date is after the summer end date, set summer for next year
                        if (today > seasonEndDate) {
                            seasonDate = new Date(nextYear, 5, 21); // June 21 next year
                            seasonEndDate = new Date(nextYear, 8, 20); // September 20 next year
                        }
                    } else if (value == 'fall') {
                        seasonDate = new Date(currentYear, 8, 21); // September 21
                        seasonEndDate = new Date(currentYear, 11, 20); // December 20

                        // If today's date is after the fall end date, set fall for next year
                        if (today > seasonEndDate) {
                            seasonDate = new Date(nextYear, 8, 21); // September 21 next year
                            seasonEndDate = new Date(nextYear, 11, 20); // December 20 next year
                        }
                    } else if (value === 'winter') {
                        if (currentMonth < 2 || (currentMonth === 2 && currentDay <= 20)) {
                            // Current winter (Dec last year to Mar this year)
                            seasonDate = new Date(currentYear - 1, 11, 21); // Dec 21 of last year
                            seasonEndDate = new Date(currentYear, 2, 20); // March 20 of current year
                        } else if (currentMonth >= 11) {
                            // Current winter (Dec this year to Mar next year)
                            seasonDate = new Date(currentYear, 11, 21); // Dec 21 of current year
                            seasonEndDate = new Date(nextYear, 2, 20); // March 20 of next year
                        } else {
                            // Next winter (Dec this year to Mar next year)
                            seasonDate = new Date(currentYear, 11, 21); // Dec 21 of this year
                            seasonEndDate = new Date(nextYear, 2, 20); // March 20 of next year
                        }
                    }

                    // Handle the case where the current season is selected (set today as start)
                    if (value == currentSeason) {
                        seasonDate = today; // Set today as the season date
                    }

                    // Call the appropriate date range picker based on window width (responsive)
                    if ($(window).width() < 768) {
                        daterangepickerMobile('#datefilter_input', seasonDate, seasonEndDate, allcojoinDates,
                            unavailableDates, bookedAndBlockeddates, checkOutOnly, checkInOnly);
                    } else {
                        daterangepickerDesktop('#datefilter_input', seasonDate, seasonEndDate, allcojoinDates,
                            unavailableDates, bookedAndBlockeddates, checkOutOnly, checkInOnly);
                    }

                    // Trigger the date range picker click if needed
                    if (click == 1) {
                        setTimeout(() => {
                            $('#datefilter_input').trigger('click');
                        }, 100);
                    }

                    // Hide the overlay loader after a short delay
                    setTimeout(() => {
                        $(".overlay-loader").hide();
                    }, 500);

                    // Event handling for date selection in the date range picker
                    $('input[name="datefilter"]').on("clickDate.daterangepicker", function(ev, picker) {
                        if (picker.endDate !== null) {
                            Swal.fire({
                                title: 'Provide a Reason',
                                html: `
                                    <label for="reason_dropdown">Reason:</label>
                                    <select id="reason_dropdown" class="swal2-input">
                                        <option value="" disabled selected>Select Reason</option>
                                        <option value="booked">Booked Dates</option>
                                        <option value="packaged">Package Dates</option>
                                        <option value="blocked">Blocked Dates</option>
                                    </select><br>
                                    <label for="reason_field">Details:</label>
                                    <textarea id="reason_field" class="swal2-textarea" placeholder="Provide additional details..."></textarea>
                                `,
                                focusConfirm: false,
                                preConfirm: () => {
                                    const reason = $('#reason_dropdown').val();
                                    const details = $('#reason_field').val();
                                    if (!reason) {
                                        Swal.showValidationMessage(
                                            'Please select a reason');
                                    }
                                    return {
                                        reason,
                                        details
                                    };
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $("#booking_type").val(result.value.reason);
                                    $("#type").val(result.value.details);
                                    // console.log('Start Date:', startDate);
                                    // console.log('End Date:', endDate);
                                    // console.log('Selected Reason:', result.value.reason);
                                    // console.log('Details:', result.value.details);
                                    // Swal.fire('Saved!', 'Your reason has been submitted.',
                                    //     'success');
                                    $(".overlay-loader").show();
                                    $.ajax({
                                        type: 'POST',
                                        url: "{{ route('check.availability', ['vendorid' => $vendorid]) }}",
                                        data: $('#dateform').serialize(),
                                        dataType: "json",
                                        success: function(response) {

                                            if (response.status == "error") {
                                                $(".overlay-loader").hide();
                                                alert(response.message);
                                                return false;

                                            }
                                            $(".overlay-loader").hide();

                                            Swal.fire({
                                                title: 'Do you want to save the dates?',
                                                showCancelButton: true,
                                                confirmButtonText: 'Save',
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $.ajax({
                                                        url: "{{ route('addbookingdate.form', ['vendorid' => $vendorid]) }}",
                                                        data: $(
                                                                '#dateform'
                                                            )
                                                            .serialize(),
                                                        type: 'post',
                                                        success: function(
                                                            response
                                                        ) {
                                                            Swal.fire({
                                                                    title: 'Saved!',
                                                                    text: 'Your booking date has been successfully saved.',
                                                                    icon: 'success',
                                                                    confirmButtonText: 'Okay'
                                                                })
                                                                .then(
                                                                    (
                                                                        result
                                                                    ) => {
                                                                        if (result
                                                                            .isConfirmed
                                                                        ) {
                                                                            location
                                                                                .reload();
                                                                        }
                                                                    }
                                                                );
                                                        },
                                                        error: function(
                                                            xhr
                                                        ) {
                                                            Swal.fire({
                                                                title: 'Error',
                                                                text: 'There was an issue saving your booking date. Please try again.',
                                                                icon: 'error',
                                                                confirmButtonText: 'Okay'
                                                            });
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    });
                                }
                            });
                            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate
                                .format('MM/DD/YYYY'));
                            $('#firstdate').val(picker.startDate.format('YYYY-MM-DD'));
                            $('#seconddate').val(picker.endDate.format('YYYY-MM-DD'));
                            if ($('select[name="booking_date_option"] option:selected').length > 0) {
                                $("#dateform_submit").prop("disabled", false);
                            }
                        }
                        setTimeout(function() {
                            wrapDatesWithDiv();
                        }, 0);
                    });

                    // Reset date inputs if the selection is canceled
                    $('input[name="datefilter"]').on("cancel.daterangepicker", function(ev, picker) {
                        $('input[name="start_date"]').val('');
                        $('input[name="end_date"]').val('');
                        setTimeout(function() {
                            wrapDatesWithDiv();
                        }, 0);
                    });
                }
            });
        }

        $(function() {

            var season_type = $('.season-clender').val();
            // alert(season_types);
            updateSeasonDates(season_type, vendor_id, 1);

            $('.season-clender').on('change', function() {

                $("#datefilter_input").val('');
                var value = $('.season-clender').val();
                $(".daterangepicker.dropdown-menu").remove();
                updateSeasonDates(value, vendor_id, 1);

            });

            $('#dateform_submit').click(function(e) {
                e.preventDefault();

                $(".overlay-loader").show();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('check.availability', ['vendorid' => $vendorid]) }}",
                    data: $('#dateform').serialize(),
                    dataType: "json",
                    success: function(response) {

                        if (response.status == "error") {
                            $(".overlay-loader").hide();
                            alert(response.message);
                            return false;

                        }
                        $(".overlay-loader").hide();

                        Swal.fire({
                            title: 'Do you want to save the dates?',
                            showCancelButton: true,
                            confirmButtonText: 'Save',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "{{ route('addbookingdate.form', ['vendorid' => $vendorid]) }}",
                                    data: $('#dateform').serialize(),
                                    type: 'post',
                                    success: function(success) {
                                        Swal.fire('Saved!', '', 'success');
                                    }
                                });
                            }
                        });
                    }
                });
            });

            // Update data of accommodation form
            $("#update_accommodation_data").click(function() {

                Swal.fire({
                    title: 'Do you want to save the changes?',
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {

                        var booking_utility_form = $('#booking_utility_form')[0];
                        var formValues1 = new FormData(booking_utility_form);
                        // $(button).prop('disabled',true);
                        $(".overlay-loader").show();

                        $.ajax({
                            type: 'POST',
                            url: "{{ route('booking_utility.save', ['vendorid' => $vendorid]) }}",
                            data: formValues1,
                            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                            processData: false,
                            success: function(data) {
                                $(".overlay-loader").hide();
                                Swal.fire('Saved!', '', 'success');
                            }
                        });
                    }
                });

            });
            dt = null;

            function datatableshow(type, action = "") {
                if (dt != null) {
                    dt.destroy();
                }
                dt = $('#myTable').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    ajax: {
                        url: "{{ route('get.Manage.Dates', ['vendorid' => $vendorid]) }}",
                        type: "GET",
                        data: {
                            filterDateTypes: type
                        },
                        dataSrc: function(json) {
                            $(".overlay-loader").hide();
                            if (action == "delete") {
                                Swal.fire('Deleted!', '', 'success').then(() => {
                                    location.reload();
                                });
                            }
                            return json.data;
                        }
                    },
                    columns: [{
                            data: 'id',
                            name: 'id',
                            searchable: false
                        },
                        {
                            data: 'date',
                            name: 'date',
                            searchable: false
                        },
                        {
                            data: 'booking_type',
                            name: 'booking_type',
                            searchable: false,
                            render: function(data, type, row) {
                                let DatesLabel = {
                                    "booked": "Booked Dates",
                                    "packaged": "Package Dates",
                                    "blocked": "Blocked Dates"
                                };
                                return DatesLabel[data];
                            }
                        },
                        {
                            data: 'reason',
                            name: 'reason',
                            searchable: false
                        },
                        {
                            data: 'action',
                            name: 'action',
                            searchable: false,
                            orderable: false
                        },
                    ]
                });
            }
            $(".manage_dates").click(function(e) {
                e.preventDefault();
                $(".overlay-loader").show();
                $("#MangeDatesPopUp").modal('show');
                datatableshow("All");
            });
            $(document).delegate(".filterDateTypes", "change", function() {
                $(".overlay-loader").show();
                datatableshow($(this).val());
            });
            $(document).delegate(".delete-dates", "click", function() {
                bookingDateID = $(this).attr('data-id');
                Swal.fire({
                    title: 'Do you want to delete these dates?',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $(".overlay-loader").show();
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('dates.delete', ['vendorid' => $vendorid]) }}",
                            data: {
                                bookingDateID: bookingDateID
                            },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            success: function(data) {
                                datatableshow($(".filterDateTypes").val(), "delete");
                            }
                        });
                    }
                });
            });

            $('select[name="booking_date_option"]').change(function() {
                if ($('input[name="start_date"]').val() && $('input[name="end_date"]').val()) {
                    $("#dateform_submit").prop("disabled", false);
                }
            });

            $("#publish_dates").click(function(e) {
                seasonClender = $(".season-clender").val();
                Swal.fire({
                    title: 'Do you want to publish ' + seasonClender.toUpperCase() + ' season?',
                    showCancelButton: true,
                    confirmButtonText: 'Publish',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var season_type = $(".season-clender").val();
                        var vendorID = $("#vendorID").val();
                        $(".overlay-loader").show();
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('publish_dates.update', ['vendorid' => $vendorid]) }}",
                            data: {
                                season_type: season_type,
                                vendorID: vendorID
                            },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            success: function(data) {
                                $(".overlay-loader").hide();
                                Swal.fire({
                                    title: 'Published!',
                                    icon: 'success',
                                    showConfirmButton: true,
                                    timer: 2000
                                }).then(function() {
                                    location.reload(); // Reload the page
                                });
                            },
                            error: function(xhr) {
                                $(".overlay-loader").hide();
                                let errorMessage =
                                    'An error occurred while publishing the season.';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                Swal.fire({
                                    title: 'Error!',
                                    text: errorMessage,
                                    icon: 'error',
                                    showConfirmButton: true,
                                });
                            }
                        });
                    }
                });
            });
        });
        $("#seasonSelect").on("change", function() {
            var selectedSeason = $(this).val();
            $(".publish-season").hide();
            $(".publish-season." + selectedSeason).show();
        })
        $(document).ready(function() {
            $(".publish-season").hide();
            $(".publish-season." + currentSeason).show();
        })
    </script>

@endsection
