@extends('FrontEnd.layouts.mainapp')
@section('content')
    <style>
        body :is(p, h1, h2, h3, h4, h5, h6) {
            color: #212529;
        }

        .theme-color {
            color: #c0a144 !important;
        }

        a.book-btn,
        a.book-btn:hover {
            background-color: #c0a144;
            color: #fff;
            padding: 10px 20px;
            border: 1px solid #c0a144;
            border-radius: 12px;
        }

        .event-checkout-wrapper .add-btn {
            background-color: #b4a468;
            color: #fff;
        }

        .event-checkout-wrapper .dlt-btn svg {
            color: #dc3545;
        }

        .event-checkout-wrapper .event-thumbnail img {
            width: 80%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
        }

        .event-checkout-wrapper .row-container:has(#row-2) .row:first-child {
            padding-right: 44px;
        }

        .event-checkout-wrapper .total-bb,
        .event-checkout-wrapper .event-total-cost {
            background-color: #fff;
        }

        .event-checkout-wrapper .total-bb input.form-check-input {
            border-color: #bba253;
            width: 18px;
            height: 18px;
            box-shadow: unset;
        }

        .event-checkout-wrapper .form-check-input {
            border-color: #bba253;
            box-shadow: unset;
        }

        .event-checkout-wrapper .form-check-input:checked {
            background-color: #bba253;
        }

        .event-checkout-wrapper .quantity-field {
            width: 36%;
            margin-inline: auto;
            background-color: #bba253;
        }

        .event-checkout-wrapper .quantity-field button {
            font-size: 24px;
            color: #fff !important;
            line-height: 30px;
        }

        .event-checkout-wrapper .quantity-field button.quantity-left-minus,
        .event-checkout-wrapper .quantity-field button.quantity-right-plus {
            border-width: 0 1px 0 0;
            border-style: solid;
            border-color: #ffffff3d !important;
        }

        .event-checkout-wrapper .quantity-field button.quantity-right-plus {
            border-width: 0 0 0 1px;
        }

        .event-checkout-wrapper .quantity-field input {
            background-color: #b7a35f;
            color: #fff;
        }

        @media screen and (max-width: 1299px) {
            .event-checkout-wrapper .quantity-field {
                width: 50%;
            }
        }

        @media screen and (max-width: 1024px) {
            .event-checkout-wrapper .event-thumbnail img {
                width: 100%;
            }
        }

        @media screen and (max-width: 767px) {
            .event-checkout-wrapper .row-container:has(#row-2) .row:first-child {
                padding-right: 0;
            }

            .event-checkout-wrapper .row-container .row {
                justify-content: end;
            }

            .event-checkout-wrapper .row-container .row .col-1 {
                padding: 0 30px 10px 0;
            }

            .event-checkout-wrapper .event-address,
            .event-checkout-wrapper .event-timing {
                font-size: 15px;
            }
        }
    </style>
    <!-- Event Checkout HTML Start -->
    <section class="event-checkout-wrapper my-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-8 col-md-6">
                    <div class="event-info mb-sm-0 mb-3">
                        <h6 class="vendor-name mb-0 fw-bold">{{ $event->vendor->vendor_name }}</h6>
                        <h3 class="theme-color">{{ $event->name }}</h3>
                        <p class="mb-sm-0 mb-2 event-address">{{ $event->address }}, {{ $event->city }},
                            {{ $event->state }}, {{ $event->zipcode }}</p>
                        <p class="mb-0 event-timing">
                            <span>{{ \Carbon\Carbon::parse($event->start_date)->format('D d M Y') }} -
                                {{ \Carbon\Carbon::parse($event->end_date)->format('D d M Y') }}</span> | Starts at
                            <span>{{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}</span> |
                            <span>
                                {{ intdiv($event->duration, 60) }} {{ intdiv($event->duration, 60) == 1 ? 'hr' : 'hrs' }}
                                {{ $event->duration % 60 }} {{ $event->duration % 60 == 1 ? 'min' : 'mins' }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="event-thumbnail text-center">
                        @if (!empty($event->image) && Str::contains($event->image, 'youtube'))
                            @php
                                parse_str(parse_url($event->image, PHP_URL_QUERY), $youtubeParams);
                                $youtubeId = $youtubeParams['v'] ?? null;
                            @endphp
                            @if ($youtubeId)
                                <iframe style="border-radius: 20px" class="lazyload w-100" height="180"
                                    src="https://www.youtube.com/embed/{{ $youtubeId }}" allowfullscreen>
                                </iframe>
                            @endif
                        @else
                            <img src="{{ !empty($event->thumbnail_medium) ? Storage::url($event->thumbnail_medium) : asset('images/vendorbydefault.png') }}"
                                class="img-fluid" alt="Event Image" />
                        @endif
                    </div>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('events.checkout.process') }}" method="post">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <input type="hidden" id="wallet_amount" name="wallet_amount" value="">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="event-detail-fields pt-3">
                            <div class="guest-details">
                                <div class="sec-head">
                                    <h3 class="theme-color">Guest Details</h3>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="fullname" name="fullname"
                                                placeholder="Name">
                                            <label for="fullname">Name</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Email">
                                            <label for="email">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control phone-number" id="contact_number"
                                                name="contact_number" placeholder="Contact Number">
                                            <label for="contact_number">Contact Number</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="street_address"
                                                name="street_address" placeholder="Street Address">
                                            <label for="street_address">Street Address</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="unit_suite" name="unit_suite"
                                                placeholder="Unit Suite">
                                            <label for="unit_suite">Unit Suite</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="city" name="city"
                                                placeholder="City/Town">
                                            <label for="city">City/Town</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-floating mb-3">
                                            <select name="country" id="country" class="form-select">
                                                <option value="">Select Country</option>
                                                @foreach (getCountries() as $country)
                                                    <option data-id="{{ $country->id }}" value="{{ $country->name }}"
                                                        {{ old('country', Auth::user()->country ?? '') == $country->name ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                                <option value="Other"
                                                    {{ old('country', Auth::check() && Auth::user()->is_other_country ? 'Other' : '') == 'Other' ? 'selected' : '' }}>
                                                    Other
                                                </option>
                                            </select>
                                            <label for="country">Country</label>
                                            @error('country')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6" id="state-wrapper" style="display: none;">
                                        <div class="form-floating mb-3">
                                            <select name="state" id="state" class="form-select">
                                                <option value="">Select State</option>
                                                {{-- States will be dynamically loaded via JS --}}
                                            </select>
                                            <label class="form-label">State<span class="required-filed">*</span></label>
                                            @error('state')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-12 mb-sm-0 mb-3" id="other-country-wrapper"
                                        style="display: none;">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="other_country" id="other-country"
                                                class="form-control"
                                                value="{{ old('other_country', Auth::user()->other_country ?? '') }}">
                                            <label class="form-label">Other Country</label>
                                            @error('other_country')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-4 col-12 mb-sm-0 mb-3" id="other-state-wrapper"
                                        style="display: none;">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="other_state" id="other-state"
                                                class="form-control"
                                                value="{{ old('other_state', Auth::user()->other_state ?? '') }}">
                                            <label class="form-label">Other State</label>
                                            @error('other_state')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="postal_code"
                                                name="postal_code" maxlength="7" oninput="formatPostalCode(this)"
                                                placeholder="Postal Code">
                                            <label for="postal_code">Postal Code</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="joinee-details mb-4">
                                <div class="sec-head d-flex align-items-center justify-content-between mb-2">
                                    <h3 class="theme-color mb-0">Joinee Details</h3>
                                    <a href="#" class="btn add-btn px-3">Add +</a>
                                </div>
                                <div class="row-container">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="checkout-sidebar sticky-lg-top p-sm-3 mt-sm-0 mt-3">
                            <div class="detail-outer-box border p-4 mb-4">
                                <h4 class="text-dark fw-bold fs-5 text-center mb-3">
                                    Total Bottle Bucks: <span id="wallet_balance">$0.00</span>
                                </h4>

                                <div class="form-check text-center mb-3">
                                    <input class="form-check-input" type="checkbox" id="use_wallet">
                                    <label class="form-check-label fw-bold" for="use_wallet">
                                        Use Bottle Bucks for this booking
                                    </label>
                                </div>

                                <div class="d-flex align-items-center justify-content-center">
                                    <button type="button" class="btn btn-outline-danger fw-bold px-4 py-2"
                                        id="decrease_wallet" disabled>−</button>

                                    <input type="number" id="wallet_used" class="form-control text-center fw-bold mx-3"
                                        value="0" min="0" max="{{ $wallet->balance ?? 0 }}" readonly
                                        style="width: 130px; font-size: 1.4rem;" disabled>

                                    <button type="button" class="btn btn-outline-success fw-bold px-4 py-2"
                                        id="increase_wallet" disabled>+</button>
                                </div>
                            </div>
                            <div class="event-total-cost border rounded-4 p-4 shadow-sm">
                                <h6 class="theme-color text-center fs-5 mb-1">{{ $event->name }}</h6>
                                <h6 class="text-center mb-0"><span id="ticket_count">1</span> Ticket's</h6>
                                <div class="subtotal-count py-3 my-3 border-top border-bottom">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span>Sub-Total</span>
                                        <span id="subtotal">$0.00</span>
                                    </div>
                                    {{-- <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span>Applicable Tax</span>
                                        <span id="applicable_tax">13%</span>
                                    </div> --}}
                                    <div class="d-flex align-items-center justify-content-between mb-2 d-none"
                                        id="bottle_bucks_container">
                                        <span>Bottle Bucks Used</span>
                                        <span id="walletused">$0.00</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span>Total Charges</span>
                                        <span id="total">$0.00</span>
                                    </div>
                                </div>
                                <button id="submit-button" type="submit"
                                    class="btn book-btn wine-btn w-100 text-uppercase mt-2">Click to pay</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Event Checkout HTML End -->
    <!-- Event Checkout HTML End -->
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script>
        function capitalizeFirstLetter(string) {
            if (!string) return ''; // Handle empty or null strings
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
        document.querySelectorAll('.phone-number').forEach(function(input) {
            input.addEventListener('input', function(e) {
                const value = e.target.value.replace(/\D/g, ''); // Remove all non-digit characters
                let formattedValue = '';
                if (value.length > 3 && value.length <= 6) {
                    formattedValue = value.slice(0, 3) + '-' + value.slice(3);
                } else if (value.length > 6) {
                    formattedValue = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
                } else {
                    formattedValue = value;
                }
                e.target.value = formattedValue;
            });
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
        $(document).ready(function() {
            $('#state').select2({
                placeholder: "Select Province/State",
                allowClear: true,
                width: '100%',
                dropdownCssClass: 'select2-dropdown-searchable'
            });
        });
        $(document).ready(function() {
            const countryDropdown = $('#country');
            const stateDropdown = $('#state');
            const stateWrapper = $('#state-wrapper');
            const otherCountryWrapper = $('#other-country-wrapper');
            const otherStateWrapper = $('#other-state-wrapper');

            // Function to toggle visibility of fields based on country selection
            function toggleFields(country) {
                if (country === 'Other') {
                    stateWrapper.hide();
                    stateDropdown.val('');
                    otherCountryWrapper.show();
                    otherStateWrapper.show();
                } else {
                    stateWrapper.show();
                    otherCountryWrapper.hide();
                    otherStateWrapper.hide();
                }
            }

            // Function to load states dynamically and preselect a state if provided
            function loadStates(countryId, selectedState = null) {
                if (countryId) {
                    $.ajax({
                        url: '{{ route('get.states') }}',
                        type: 'GET',
                        data: {
                            country_id: countryId
                        },
                        success: function(response) {
                            stateDropdown.empty().append('<option value="">Select State</option>');
                            if (response.success) {
                                $.each(response.states, function(type, states) {
                                    const optgroup = $('<optgroup>').attr('label',
                                        capitalizeFirstLetter(type));
                                    $.each(states, function(index, state) {
                                        const option = $('<option>')
                                            .val(state.name)
                                            .text(state.name)
                                            .prop('selected', state.name ==
                                                selectedState);
                                        optgroup.append(option);
                                    });
                                    stateDropdown.append(optgroup);
                                });
                            }
                        },
                        error: function() {
                            alert('Failed to load states.');
                        }
                    });
                }
            }

            // Handle initial page load
            const savedCountry = '{{ old('country', Auth::user()->country ?? '') }}';
            const savedState = '{{ old('state', Auth::user()->state ?? '') }}';
            const isOtherCountry = savedCountry === 'Other';
            toggleFields(savedCountry);

            if (!isOtherCountry && savedCountry) {
                const selectedCountryId = countryDropdown.find(`option[value="${savedCountry}"]`).data('id');
                loadStates(selectedCountryId, savedState);
            }

            // Handle country dropdown change
            countryDropdown.change(function() {
                const selectedOption = $(this).find(':selected');
                const country = $(this).val();
                const countryId = selectedOption.data('id');

                toggleFields(country);

                //if (country !== 'Other') {
                loadStates(countryId);
                //}
                if (country !== 'Other') {
                    $("#other-country").val('');
                    $("#other-state").val('');
                }
            });
        });
    </script>

    <!-- Add and Remove Joinee Details Row -->
    <script>
        function addNewRow(e) {
            const rowContainer = document.querySelector('.row-container');
            const maxRows = Math.max({{ $event->quantity }} - 2, 0);
            console.log(rowContainer.querySelectorAll('.row').length);
            console.log(maxRows);
            if (rowContainer.querySelectorAll('.row').length > maxRows) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'You have reached the maximum number of joinees for this event.',
                });
                return;
            }
            const rowCount = rowContainer.querySelectorAll('.row').length + 1;

            // Create a new row element
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'mb-sm-3');
            newRow.id = 'row_' + rowCount;

            newRow.innerHTML = `
        <div class="col-sm mb-sm-0 mb-3">
            <div class="form-floating">
                <input type="email" class="form-control search-email" id="joinee_email_${rowCount}" name="joinee[${rowCount - 1}][email]" data-msg-required="Please enter your email" data-msg-email="Please enter a valid email address" required placeholder="Email">
                <label for="joinee_email_${rowCount}">Email</label>
            </div>
        </div>
        <div class="col-sm mb-sm-0 mb-3">
            <div class="form-floating">
                <input type="text" class="form-control" id="joinee_first_name_${rowCount}" name="joinee[${rowCount - 1}][first_name]" data-msg-required="Please enter your first name" required placeholder="First Name">
                <label for="joinee_first_name_${rowCount}">First Name</label>
            </div>
        </div>
        <div class="col-sm mb-sm-0 mb-3">
            <div class="form-floating">
                <input type="text" class="form-control" id="joinee_last_name_${rowCount}" required name="joinee[${rowCount - 1}][last_name]" data-msg-required="Please enter your last name" placeholder="Last Name">
                <label for="joinee_last_name_${rowCount}">Last Name</label>
            </div>
        </div>
        <div class="col-1 d-flex align-items-center justify-content-center">
            <a href="#" class="dlt-btn"><i class="fa-solid fa-trash-can"></i></a>
        </div>
    `;

            // Append the new row to the container
            rowContainer.appendChild(newRow);
            e.preventDefault();
            tickets += 1;
            $("#ticket_count").text(tickets);
            priceCalculation();

            // Add event listener to delete button
            newRow.querySelector('.dlt-btn').addEventListener('click', function(e) {
                e.preventDefault();
                newRow.remove();
            });
        }
        document.querySelector('.add-btn').addEventListener('click', function(e) {
            e.preventDefault();
            addNewRow(e);
        });
    </script>
    <script>
        var walletBalance = {{ $wallet->balance ?? 0.0 }};
        var tickets = 1;
        var price = parseFloat(
            "{{ number_format($event->admittance + ($event->admittance * ($event->vendor->platform_fee ?? (config('site.platform_fee') ?? 1.0))) / 100, 2, '.', '') }}"
        );
        var tax = 0.00;
        var total = 0.00;
        var subtotal = 0.00;
        var walletUsed = 0;
        var extension = "{{ strtolower(str_replace('/', '', $event->extension)) }}";
        var duration = 1;
        $("#wallet_balance").text('$' + walletBalance.toFixed(2));
        $(document).ready(function() {
            $('#use_wallet').change(function() {
                let isChecked = $(this).is(':checked');

                $('#wallet_used, #increase_wallet, #decrease_wallet').prop('disabled', !isChecked);
                if (isChecked) {
                    $("#bottle_bucks_container").removeClass('d-none');
                } else {
                    $("#bottle_bucks_container").addClass('d-none');
                }
                if (!isChecked) {
                    walletUsed = 0;
                    $("#wallet_used").val(walletUsed);
                    priceCalculation();
                }
            });

            $('#increase_wallet').click(function() {
                if (walletUsed < walletBalance && total > 2) {
                    walletUsed += 1;
                    $("#wallet_used").val(walletUsed);
                    priceCalculation();
                }
            });

            $('#decrease_wallet').click(function() {
                if (walletUsed > 0) {
                    walletUsed -= 1;
                    $("#wallet_used").val(walletUsed);
                    priceCalculation();
                }
            });
        });
        $(document).ready(function() {
            // $(".add-btn").on("click", function(e) {
            //     e.preventDefault();
            //     tickets += 1;
            //     $("#ticket_count").text(tickets);
            //     priceCalculation();
            // });
            $(document).on("click", ".dlt-btn", function(e) {
                e.preventDefault();
                tickets -= 1;
                $("#ticket_count").text(tickets);
                priceCalculation();
            });
        });

        function priceCalculation() {
            if (extension == 'hr') {
                subtotal = tickets * (price * duration);
            } else {
                subtotal = tickets * price;
            }
            if ($("#use_wallet").is(":checked")) {
                $("#walletused").text("$" + walletUsed.toFixed(2));
                $("#wallet_amount").val(walletUsed);
                total = parseFloat(subtotal) - parseFloat(walletUsed);
            } else {
                $("#walletused").text("$" + "0.00");
                $("#wallet_amount").val(0);
                total = parseFloat(subtotal);
            }
            $("#subtotal").text('$' + subtotal.toFixed(2));
            $("#total").text('$' + total.toFixed(2));
        }
    </script>
    <script>
        $(document).ready(function() {
            // Initialize validation on the form
            $("form").validate({
                rules: {
                    "joinee_email[]": {
                        required: true,
                        email: true
                    },
                    "joinee_first_name[]": {
                        required: true
                    },
                    "joinee_last_name[]": {
                        required: true
                    },
                    fullname: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    contact_number: {
                        required: true,
                        minlength: 12,
                        maxlength: 15
                    },
                    street_address: {
                        required: true
                    },
                    unit_suite: {
                        required: false
                    },
                    city: {
                        required: true
                    },
                    country: {
                        required: true
                    },
                    state: {
                        required: function() {
                            return $("#state-wrapper").is(":visible");
                        }
                    },
                    other_country: {
                        required: function() {
                            return $("#other-country-wrapper").is(":visible");
                        }
                    },
                    other_state: {
                        required: function() {
                            return $("#other-state-wrapper").is(":visible");
                        }
                    },
                    postal_code: {
                        required: true,
                        minlength: 5,
                        maxlength: 7
                    }
                },
                messages: {
                    "joinee_email[]": {
                        required: "Please enter an email",
                        email: "Please enter a valid email"
                    },
                    "joinee_first_name[]": {
                        required: "Please enter first name"
                    },
                    "joinee_last_name[]": {
                        required: "Please enter last name"
                    },
                    fullname: {
                        required: "Please enter your full name",
                        minlength: "Name must be at least 3 characters"
                    },
                    email: {
                        required: "Please enter your email",
                        email: "Please enter a valid email"
                    },
                    contact_number: {
                        required: "Please enter your contact number",
                        minlength: "Contact number should be at least 10 digits",
                        maxlength: "Contact number should not exceed 15 digits"
                    },
                    street_address: {
                        required: "Please enter your street address"
                    },
                    city: {
                        required: "Please enter your city"
                    },
                    country: {
                        required: "Please select your country"
                    },
                    state: {
                        required: "Please select your state"
                    },
                    other_country: {
                        required: "Please enter the other country name"
                    },
                    other_state: {
                        required: "Please enter the other state name"
                    },
                    postal_code: {
                        required: "Please enter your postal code",
                        minlength: "Postal code should be at least 5 characters",
                        maxlength: "Postal code should not exceed 7 characters"
                    }
                },
                errorElement: "div",
                errorPlacement: function(error, element) {
                    error.addClass("text-danger");
                    element.closest(".form-floating").append(error);
                },
                highlight: function(element) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function(element) {
                    $(element).removeClass("is-invalid");
                }
            });

            // Prevent form submission if validation fails
            $("#submit-button").on("click", function() {
                $("form").submit();
            });
            priceCalculation();
        });
    </script>
    <script>
        $(document).on('blur', '.search-email', function() {
            let emailInput = $(this);
            let email = emailInput.val().trim();
            if (!email) return;

            let row = emailInput.closest('.row');
            let firstNameInput = row.find('input[name*="[first_name]"]');
            let lastNameInput = row.find('input[name*="[last_name]"]');

            $.ajax({
                url: "{{ route('check.email.details') }}",
                method: "GET",
                data: {
                    email: email
                },
                success: function(response) {
                    if (response.exists) {
                        firstNameInput.val(response.first_name);
                        lastNameInput.val(response.last_name);
                    }
                },
                error: function() {
                    console.warn("Error checking email.");
                }
            });
        });
    </script>
@endsection
