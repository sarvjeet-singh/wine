@extends('FrontEnd.layouts.mainapp')
@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <style>
        .summary-content-sec .refund-policies ul {
            list-style: none;
            padding-left: 20px;
        }

        .error {
            color: red;
        }
    </style>
    <!--*********** SUMMARY DETAIL SEC START ***********-->
    <section class="summary-content-sec">
        <div class="container">
            <div class="row mt-md-5 mt-3">
                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="theme-color mb-0 fs-6">
                            {{ !empty($vendor->sub_category->name) ? $vendor->sub_category->name : '' }}</h5>
                        <!-- <div class="rating-star d-flex align-items-center"
                                                                                                                                                                                                                                data-rating="{{ $vendor->reviews->avg('rating') ?? 0.0 }}"></div> -->
                    </div>
                    <h3 class="card-title mt-2 mb-2 fw-bold" style="font-size: 15px;">{{ $vendor->vendor_name }}</h3>
                    <div class="info d-flex align-items-baseline gap-2 mb-2">
                        <i class="fa-solid fa-location-dot theme-color"></i>
                        <p class="mb-0">{{ $vendor->street_address }},<br> {{ $vendor->city }}, {{ $vendor->province }}
                        </p>
                    </div>
                    <div class="info d-flex align-items-baseline gap-2 mb-2">
                        <i class="fa-solid fa-phone theme-color"></i>
                        <p class="mb-0"><a class="text-decoration-none text-dark"
                                href="tel:{{ $vendor->vendor_phone }}">{{ $vendor->vendor_phone }}</a></p>
                    </div>
                    <!-- <p class="desc mb-3">{{ $vendor->description }}</p> -->
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                    {{-- <div class="summary-gallery-slider">
                        @if ($vendor->mediaGallery->isNotEmpty())
                            @foreach ($vendor->mediaGallery as $media)
                                <div class="item">
                                    @if ($media->vendor_media_type === 'youtube')
                                        <iframe width="100%" height="300px" src="{{ $media->vendor_media }}" frameborder="0"
                                            allowfullscreen></iframe>
                                    @elseif ($media->vendor_media_type === 'image')
                                        <img src="{{ asset($media->vendor_media) }}" alt="Image" class="img-fluid">
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div> --}}
                    <div class="summary-gallery-img text-sm-end text-center">
                        @if (!empty($vendor->mediaLogo))
                            <img src="{{ asset($vendor->mediaLogo->vendor_media) }}" class="img-fluid" alt="Property Image"
                                style="width: 250px;">
                        @elseif($vendor->mediaGallery->isNotEmpty())
                            <img src="{{ asset($vendor->mediaGallery[0]->vendor_media) }}" class="img-fluid"
                                alt="Property Image" style="width: 250px;">
                        @elseif ($vendor->vendor_media_logo)
                            <img src="{{ asset($vendor->vendor_media_logo) }}" class="img-fluid" alt="Property Image"
                                style="width: 250px;">
                        @else
                            <img src="{{ asset('images/vendorbydefault.png') }}" class="img-fluid" alt="Property Image">
                        @endif
                    </div>
                </div>
            </div>

            <div class="row mt-sm-5 mt-4">
                <div class="col-lg-8">
                    <div class="detail-outer-box border">
                        <div class="guest-details border-bottom p-sm-4 p-3">
                            <h3 class="text-dark fw-bold fs-5 mb-3"><i class="fa-solid fa-user-group"></i> Guest Details
                            </h3>
                            @if (empty($inquiry->apk))
                                <form id="checkout-form" method="post" action="">
                                    <div class="row mt-3">
                                        <div class="col-sm-6 col-12 mb-sm-0 mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}"
                                                placeholder="Enter Your Name">
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label class="form-label">eMail</label>
                                            <input type="email" class="form-control" name="email_address"
                                                value="{{ Auth::user()->email }}" placeholder="Enter Your eMail">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-6 col-12 mb-sm-0 mb-3">
                                            <label class="form-label">Contact Ph#</label>
                                            <input type="text" class="form-control  phone-number" name="contact_number"
                                                value="{{ Auth::user()->contact_number }}"
                                                placeholder="Enter Contact Phone">
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label class="form-label">Street Address:</label>
                                            <input type="text" class="form-control" name="street_address"
                                                value="{{ Auth::user()->street_address }}"
                                                placeholder="Enter Street Address:">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-6 col-12 mb-sm-0 mb-3">
                                            <label class="form-label">Unit/Suite#</label>
                                            <input type="text" class="form-control" name="suite"
                                                value="{{ Auth::user()->suite }}" placeholder="Enter Unit/Suite#">
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label class="form-label">City/Town<span class="required-filed">*</span></label>
                                            <input type="text" class="form-control" name="city"
                                                value="{{ Auth::user()->city }}" placeholder="Enter City/Town">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-6 col-12">
                                            <label class="form-label">Country</label>
                                            <select name="country" id="country" class="form-select">
                                                <option value="">Select Country</option>
                                                @foreach (getCountries() as $country)
                                                    <option data-id="{{ $country->id }}" value="{{ $country->name }}"
                                                        {{ old('country', Auth::user()->country ?? '') == $country->name ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                                <option value="Other"
                                                    {{ old('country', Auth::user()->is_other_country ? 'Other' : '') == 'Other' ? 'selected' : '' }}>
                                                    Other
                                                </option>
                                            </select>
                                            @error('country')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-sm-6 col-12 mb-sm-0 mb-3 mt-sm-0 mt-3" id="state-wrapper"
                                            style="display: none;">
                                            <label class="form-label">State</label>
                                            <select name="state" id="state" class="form-select">
                                                <option value="">Select State</option>
                                                {{-- States will be dynamically loaded via JS --}}
                                            </select>
                                            @error('state')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-sm-6 col-12 mb-sm-0 mb-3" id="other-country-wrapper"
                                            style="display: none;">
                                            <label class="form-label">Other Country</label>
                                            <input type="text" name="other_country" id="other-country"
                                                class="form-control"
                                                value="{{ old('other_country', Auth::user()->other_country ?? '') }}">
                                            @error('other_country')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-sm-6 col-12 mb-sm-0 mb-3" id="other-state-wrapper"
                                            style="display: none;">
                                            <label class="form-label">Other State</label>
                                            <input type="text" name="other_state" id="other-state"
                                                class="form-control"
                                                value="{{ old('other_state', Auth::user()->other_state ?? '') }}">
                                            @error('other_state')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-sm-3">
                                        <div class="col-sm-12 col-12">
                                            <label for="email" class="form-label">Postal Code/Zip<span
                                                    class="required-filed">*</span></label>
                                            <input type="text" class="form-control" name="postal_code" maxlength="7"
                                                oninput="formatPostalCode(this)" placeholder="Enter Postal Code/Zip"
                                                value="{{ Auth::user()->postal_code }}">
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                        <div class="booking-details border-bottom p-sm-4 p-3">
                            <h3 class="text-dark fw-bold fs-5 mb-3"><i class="fa-solid fa-calendar-day"></i> Booking
                                Details
                            </h3>
                            <h6 class="fw-bold mb-2 theme-color">Travel Dates:</h6>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <p class="info-label mb-0">Check-In Date/Time:</p>
                                <p class="mb-0">
                                    {{ Carbon::createFromFormat('Y-m-d', $booking->start_date)->format('Y-F-d') }}
                                    (After
                                    {{ !empty($vendor->accommodationMetadata->checkin_start_time) ? $vendor->accommodationMetadata->checkin_start_time : '' }})
                                    {{-- –
                                    {{ !empty($vendor->accommodationMetadata->checkin_end_time) ? $vendor->accommodationMetadata->checkin_end_time : '' }}) --}}
                                </p>
                                <!-- 2024-May-16  3:00 PM – 12:00 AM-->
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <p class="info-label mb-0">Check-out Date/Time</p>
                                <p class="mb-0">
                                    {{ Carbon::createFromFormat('Y-m-d', $booking->end_date)->format('Y-F-d') }} (Before
                                    {{ !empty($vendor->accommodationMetadata->checkout_time) ? $vendor->accommodationMetadata->checkout_time : '' }})
                                </p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <p class="info-label mb-0">Number of Nights</p>
                                <p class="mb-0">{{ $booking->days }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <p class="info-label mb-0">Number in Travel Party:</p>
                                <p class="mb-0">{{ $booking->number_travel_party }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <p class="info-label mb-0">Nature of visit:</p>
                                <p class="mb-0">{{ $booking->nature_of_visit }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <p class="info-label mb-0">Basic Rates:</p>
                                <p class="mb-0" id="base_price">
                                    @if ($inquiry && !empty($inquiry->rate_basic))
                                        {{ number_format($inquiry->rate_basic, 2, '.', '') }}
                                    @else
                                        ${{ isset($season['price']) ? number_format($season['price'], 2, '.', '') : number_format($vendor->pricing->current_rate ?? 0, 2, '.', '') }}
                                    @endif
                                    <b>/night</b>
                                </p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="info-label fw-bold mb-0">Sub-Total</p>
                                <p class="fw-bold mb-0"
                                    data-value="{{ number_format(($inquiry && !empty($inquiry->rate_basic) ? $inquiry->rate_basic : $season['price'] ?? ($vendor->pricing->current_rate ?? 0)) * $booking->days, 2, '.', '') }}"
                                    id="bookingTotal">
                                    ${{ number_format(($inquiry && !empty($inquiry->rate_basic) ? $inquiry->rate_basic : $season['price'] ?? $vendor->pricing->current_rate) * $booking->days, 2, '.', '') }}
                                </p>
                            </div>
                        </div>

                        @if ($inquiry && $inquiry->experiences_selected_arr)
                            <div class="exp-update border-bottom p-sm-4 p-3">
                                <h3 class="text-dark fw-bold fs-5 mb-3">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Curative Experience
                                </h3>
                                @foreach ($inquiry->experiences_selected_arr as $key => $experience)
                                    @php
                                        $upgradeFee = str_replace('$', '', $experience->value);
                                    @endphp
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input experience_upgrades"
                                                @if (in_array($experience->name, $booking->curative_exp)) checked disabled @endif type="checkbox"
                                                value="{{ number_format((float) $upgradeFee, 2, '.', '') }}"
                                                id="{{ strtolower(str_replace(' ', '_', $experience->name)) }}">
                                            <label class="form-check-label info-label"
                                                for="{{ strtolower(str_replace(' ', '_', $experience->name)) }}">
                                                {{ $experience->name }}
                                            </label>
                                        </div>
                                        <p>Upgrade Fee: ${{ number_format((float) $upgradeFee, 2, '.', '') }}</p>
                                    </div>
                                @endforeach
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="fw-bold mb-0">Sub-Total</p>
                                    <p class="fw-bold mb-0 " id="experiencetotal" data-value="0.00">
                                        ${{ number_format($inquiry->experiences_total, 2, '.', '') }}</p>
                                </div>
                            </div>
                        @else
                            <div class="exp-update border-bottom p-sm-4 p-3">
                                <h3 class="text-dark fw-bold fs-5 mb-3">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    Curative Experience
                                </h3>
                                @foreach ($vendor->experiences as $key => $experience)
                                    @php
                                        $upgradeFee = str_replace('$', '', $experience->upgradefee);
                                    @endphp
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input experience_upgrades"
                                                @if (in_array($experience->title, $booking->curative_exp)) checked @endif type="checkbox"
                                                value="{{ number_format((float) $upgradeFee, 2, '.', '') }}"
                                                id="{{ strtolower(str_replace(' ', '_', $experience->title)) }}">
                                            <label class="form-check-label info-label"
                                                for="{{ strtolower(str_replace(' ', '_', $experience->title)) }}">
                                                {{ $experience->title }}
                                            </label>
                                            <div class="content-section">
                                                <!-- Collapsible content -->
                                                <div class="collapse" id="collapseExample{{ $key }}">
                                                    <div class="w-50 p-1">
                                                        This is the additional content that is hidden by default and shown
                                                        when
                                                        "View More" is clicked.
                                                    </div>
                                                </div>
                                                <!-- View More / View Less button -->
                                                <a class="d-block theme-color text-decoration-none"
                                                    data-bs-toggle="collapse" href="#collapseExample{{ $key }}"
                                                    role="button" id="toggleContent{{ $key }}"
                                                    onclick="toggleContent({{ $loop->index }}) aria-expanded="false"
                                                    aria-controls="collapseExample{{ $key }}">
                                                    View More
                                                </a>
                                            </div>
                                        </div>
                                        <p>Upgrade Fee: ${{ number_format((float) $upgradeFee, 2, '.', '') }}</p>
                                    </div>
                                @endforeach
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="fw-bold mb-0">Sub-Total</p>
                                    <p class="fw-bold mb-0 " id="experiencetotal" data-value="0.00">$0.00</p>
                                </div>
                            </div>
                        @endif
                        <div class="sundry-charges p-sm-4 p-3">
                            <h3 class="text-dark fw-bold fs-5 mb-3"><i class="fa-solid fa-file-invoice-dollar"></i> Sundry
                                Charges</h3>
                            @if (
                                !empty($vendor->accommodationMetadata->cleaning_fee_amount) &&
                                    $vendor->accommodationMetadata->cleaning_fee_amount > 0)
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <p class="info-label mb-0">Cleaning Fees:</p>
                                    <p class="mb-0">
                                        ${{ number_format(
                                            $inquiry && !empty($inquiry->cleaning_fee)
                                                ? $inquiry->cleaning_fee
                                                : (!empty($vendor->accommodationMetadata->cleaning_fee_amount)
                                                    ? $vendor->accommodationMetadata->cleaning_fee_amount
                                                    : 0),
                                            2,
                                            '.',
                                            '',
                                        ) }}
                                    </p>
                                </div>
                            @endif
                            @if (
                                !empty($vendor->accommodationMetadata->security_deposit_amount) &&
                                    $vendor->accommodationMetadata->security_deposit_amount > 0)
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <p class="info-label mb-0">Security Deposit:</p>
                                    <p class="mb-0">
                                        ${{ number_format(
                                            $inquiry && !empty($inquiry->security_deposit)
                                                ? $inquiry->security_deposit
                                                : (!empty($vendor->accommodationMetadata->security_deposit_amount)
                                                    ? $vendor->accommodationMetadata->security_deposit_amount
                                                    : 0),
                                            2,
                                            '.',
                                            '',
                                        ) }}
                                </div>
                            @endif
                            @if (!empty($vendor->accommodationMetadata->pet_boarding) && $vendor->accommodationMetadata->pet_boarding > 0)
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <p class="info-label mb-0">Pet Boarding:</p>
                                    <p class="mb-0">
                                        ${{ number_format(
                                            $inquiry && !empty($inquiry->pet_fee)
                                                ? $inquiry->pet_fee
                                                : (!empty($vendor->accommodationMetadata->pet_boarding)
                                                    ? $vendor->accommodationMetadata->pet_boarding
                                                    : 0),
                                            2,
                                            '.',
                                            '',
                                        ) }}
                                    </p>
                                </div>
                            @endif
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="fw-bold mb-0">Sub-Total</p>
                                @php
                                    $sundry_subtotal = 0.0;

                                    // Add cleaning fee (use inquiry value if available, else fallback to vendor value)
                                    if (
                                        !is_null($inquiry) &&
                                        !is_null($inquiry->cleaning_fee) &&
                                        $inquiry->cleaning_fee > 0
                                    ) {
                                        $sundry_subtotal += $inquiry->cleaning_fee;
                                    } elseif (
                                        !empty($vendor->accommodationMetadata->cleaning_fee_amount) &&
                                        $vendor->accommodationMetadata->cleaning_fee_amount > 0
                                    ) {
                                        $sundry_subtotal += $vendor->accommodationMetadata->cleaning_fee_amount;
                                    }

                                    // Add security deposit (use inquiry value if available, else fallback to vendor value)
                                    if (
                                        !is_null($inquiry) &&
                                        !is_null($inquiry->security_deposit) &&
                                        $inquiry->security_deposit > 0
                                    ) {
                                        $sundry_subtotal += $inquiry->security_deposit;
                                    } elseif (
                                        !empty($vendor->accommodationMetadata->security_deposit_amount) &&
                                        $vendor->accommodationMetadata->security_deposit_amount > 0
                                    ) {
                                        $sundry_subtotal += $vendor->accommodationMetadata->security_deposit_amount;
                                    }

                                    // Add pet fee (use inquiry value if available, else fallback to vendor value)
                                    if (!is_null($inquiry) && !is_null($inquiry->pet_fee) && $inquiry->pet_fee > 0) {
                                        $sundry_subtotal += $inquiry->pet_fee;
                                    } elseif (
                                        !empty($vendor->accommodationMetadata->pet_boarding) &&
                                        $vendor->accommodationMetadata->pet_boarding > 0
                                    ) {
                                        $sundry_subtotal += $vendor->accommodationMetadata->pet_boarding;
                                    }
                                @endphp
                                <p class="fw-bold mb-0" id="sundryTotal"
                                    data-value="{{ number_format($sundry_subtotal, 2, '.', '') }}">
                                    ${{ number_format($sundry_subtotal, 2, '.', '') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="detail-outer-box border mt-lg-0 mt-4 mb-4">
                        <div class="refund-policies p-sm-4 p-3">
                            <h4 class="mt-5">Refund Policy</h4>
                            @if ($vendor->policy != '')
                                {!! refundContent($vendor->policy) !!}
                            @endif
                        </div>
                    </div>
                    @if ($vendor->accommodationMetadata->process_type == 'one-step' || !empty($booking->apk))
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
                                    value="0" min="0" max="{{ $wallet_balance ?? 0 }}" readonly
                                    style="width: 130px; font-size: 1.4rem;" disabled>

                                <button type="button" class="btn btn-outline-success fw-bold px-4 py-2"
                                    id="increase_wallet" disabled>+</button>
                            </div>
                        </div>
                    @endif
                    <div class="detail-outer-box border">
                        <div class="total-cost">
                            <div class="p-sm-4 p-3 pb-sm-2 pb-1 mb-3 border-bottom">
                                <h4 class="text-dark fw-bold fs-6">Totals</h4>
                            </div>
                            <div class="p-sm-4 p-3 pt-sm-0 pt-0">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <p class="mb-0">Booking Charges:</p>
                                    <p class="fw-bold mb-0" id="booking_total" data-value="">
                                        @if ($inquiry && $inquiry->rate_basic && $inquiry->nights_count)
                                            ${{ $booking_total = number_format($inquiry->rate_basic * $inquiry->nights_count, 2, '.', '') }}
                                        @else
                                            ${{ isset($season['price']) ? number_format($season['price'], 2, '.', '') : number_format($vendor->pricing->current_rate ?? 0, 2, '.', '') }}
                                        @endif
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <p class="mb-0">Curative Experience Charges:</p>
                                    <p class="fw-bold mb-0" id="experience_total" data-value="0.00">
                                        @if ($inquiry && $inquiry->experiences_total)
                                            ${{ number_format($inquiry->experiences_total, 2, '.', '') }}
                                        @else
                                            $0.00
                                        @endif
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <p class="mb-0">Sundry Charges:</p>
                                    <p class="fw-bold mb-0" id="sundry_total" data-value="0.00">
                                        @if ($sundry_subtotal > 0)
                                            ${{ number_format($sundry_subtotal, 2, '.', '') }}
                                        @else
                                            $0.00
                                        @endif
                                    </p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <p class="mb-0">Sub-Total:</p>
                                    <p class="fw-bold mb-0" id="sub_total" data-value="0.00">
                                        @if ($inquiry)
                                            ${{ number_format($booking_total + $inquiry->experiences_total + $sundry_subtotal, 2, '.', '') }}
                                        @else
                                            $0.00
                                        @endif
                                    </p>
                                </div>
                                <div class="align-items-center justify-content-between mb-2" style="display: none;"
                                    id="bottle_bucks_container">
                                    <p class="mb-0">Bottle Bucks:</p>
                                    <p class="fw-bold mb-0" id="bottle_bucks" data-value="0.00">
                                        0.00
                                    </p>
                                </div>
                                @if (
                                    !empty($vendor->accommodationMetadata->applicable_taxes_amount) &&
                                        $vendor->accommodationMetadata->applicable_taxes_amount > 0)
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <p class="fw-bold mb-0">Tax:<span></span>
                                        </p>
                                        <p class="fw-bold mb-0" id="taxTotal"
                                            data-value="{{ $inquiry && !empty($inquiry->tax_rate) && $inquiry->tax_rate > 0 ? $inquiry->tax_rate : $vendor->accommodationMetadata->applicable_taxes_amount }}">
                                            @if ($inquiry)
                                                ${{ number_format(($booking_total + $inquiry->experiences_total + $sundry_subtotal) * ($vendor->accommodationMetadata->applicable_taxes_amount / 100), 2, '.', '') }}
                                            @else
                                                $0.00
                                            @endif
                                        </p>
                                    </div>
                                @endif
                                <div class="d-flex align-items-center justify-content-between">
                                    <p class="fw-bold mb-0">Total:</p>
                                    <p class="fw-bold mb-0" id="fulltotal">
                                        ${{ number_format(!is_null($inquiry) && !is_null($inquiry->order_total) ? $inquiry->order_total : $booking->amount, 2, '.', '') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (
                        (!empty($vendor->accommodationMetadata->process_type) ? $vendor->accommodationMetadata->process_type : '') ==
                            'one-step' || !empty($booking->apk))
                        <!-- Stripe Payment Sec Start -->
                        <div id="payment-methods-container" class="mt-4">
                            <h4 class="fw-bold">Saved Payment Methods</h4>
                            <input type="hidden" id="selectedPaymentMethodId" name="payment_method_id" value="">
                            <!-- Payment Methods List (Will be populated by AJAX) -->
                            <ul id="payment-methods-list" class="list-group"></ul>
                            <!-- "Use a New Card" Option -->
                            <div class="form-check my-2">
                                <input type="radio" name="payment_method_select" value="new" id="use-new-card"
                                    class="form-check-input">
                                <label for="use-new-card" class="form-check-label fw-bold">Use a New
                                    Card</label>
                            </div>
                        </div>
                        <div id="checkout-payment-form" class="d-none">
                            <!-- "Back to Saved Cards" Option -->
                            <div class="form-check mb-2">
                                <input type="radio" name="payment_method_select" value="saved" id="back-to-saved"
                                    class="form-check-input">
                                <label for="back-to-saved" class="form-check-label fw-bold">Use a Saved
                                    Card</label>
                            </div>
                            <div class="cart-box p-4">

                                <h4 class="fw-bold">Checkout Payment Form</h4>

                                <div class="checkout-box border-top mt-3 pt-3">

                                    <form action="">

                                        <div class="row g-sm-3 g-2">

                                            <div id="card-container">

                                                <div class="row">

                                                    <div class="col-12">

                                                        <div id="card-errors" style="color:red"></div>

                                                    </div>

                                                </div>

                                                <div class="mb-2">

                                                    <label for="cc-name">Card Holder Name</label>

                                                    <input type="text" class="form-control mt-2" id="cc-name"
                                                        placeholder="Card Holder Name">

                                                </div>

                                                <div class="row">

                                                    <div class="col-12 col-md-12">

                                                        <div class="form-floating mb-2">

                                                            <div id="cc-number"></div>

                                                            <label for="cc-number">Card number</label>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <div class="col-md-6">

                                                        <div class="form-floating">

                                                            <div id="cc-expiry"></div>

                                                            <label for="cc-expiry">MM/AA</label>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="form-floating">

                                                            <div id="cc-cvc"></div>

                                                            <label for="cc-cvc">CVV</label>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </form>

                                </div>

                            </div>
                        </div>
                        <div class="col-12">

                            <button id="submit-button" type="button"
                                class="btn book-btn wine-btn w-100 text-uppercase mt-2">Pay</button>

                        </div>
                        <!-- Stripe Payment Sec End -->
                    @else
                        <div class="detail-outer-box border mt-4">
                            <button type="button" id="send-inquiry" class="btn book-btn w-100">Send Inquiry</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!--*********** SUMMARY DETAIL SEC END ***********-->
@endsection

@section('js')
    <script>
        const submitButton = document.getElementById('submit-button');
        const originalButtonText = submitButton ? submitButton.textContent : '';
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <script>
        $('.summary-gallery-slider').slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1
            // prevArrow: "<img class='a-left control-c prev slick-prev' src='images/prev-btn.png'>",
            // nextArrow: "<img class='a-right control-c next slick-next' src='images/next-btn.png'>"
        });
    </script>
    @if (
        (!empty($vendor->accommodationMetadata->process_type) ? $vendor->accommodationMetadata->process_type : '') ==
            'one-step' || !empty($booking->apk))
        <script src="https://js.stripe.com/v3/"></script>
        {{-- <script src="{{ asset('asset/js/select2.min.js') }}"></script> --}}


        <script>
            var stripe = Stripe("{{ env('STRIPE_KEY') }}");

            var elements = stripe.elements();

            var style = {

                // base: {

                //     border: '1px solid #E8E8E8',

                // },

            };



            var cardNumber = elements.create('cardNumber', {

                style: style,

                classes: {

                    base: 'form-control w-full'

                }

            });



            var cardExpiry = elements.create('cardExpiry', {

                style: style,

                classes: {

                    base: 'form-control'

                }

            });



            var cardCvc = elements.create('cardCvc', {

                style: style,

                classes: {

                    base: 'form-control'

                }

            });

            cardNumber.mount('#cc-number');

            cardExpiry.mount('#cc-expiry');

            cardCvc.mount('#cc-cvc');
        </script>
    @endif

    {{-- @if ($vendor->accommodationMetadata->process_type == 'one-step' || !empty($booking->apk)) --}}
    <script>
        $('.experience_upgrades').change(function() {
            experienceCalculation();
        });

        function experienceCalculation() {
            var experience_total = 0;
            var sub_total = parseFloat($("#sub_total").attr('data-value'));

            // Iterate over all checked checkboxes and sum their values
            $('.experience_upgrades:checked').each(function() {
                experience_total += parseFloat($(this).val());
            });

            // Calculate the total based on the summed experience_total
            var total = experience_total + sub_total;

            // Update the data-value attribute and the displayed total
            $("#experiencetotal").attr('data-value', experience_total.toFixed(2));
            $("#experiencetotal").html('$' + experience_total.toFixed(2));
            $("#total").html('$' + total.toFixed(2)); // Assuming you have an element with id 'total' for the final total

            priceCalculation(); // Call your price calculation function
        }

        function priceCalculation() {
            var booking_total = parseFloat($("#bookingTotal").attr('data-value')) || 0;
            var experience_total = parseFloat($("#experiencetotal").attr('data-value')) || 0;
            var sundry_total = parseFloat($("#sundryTotal").attr('data-value')) || 0;
            var tax_rate = parseFloat($("#taxTotal").attr('data-value')) || 0;

            var wallet_used = parseFloat($('#wallet_used').val()) || 0;

            $("#bottle_bucks").text('$' + wallet_used.toFixed(2));

            // Calculate the subtotal before tax
            var subtotal = booking_total + experience_total + sundry_total - wallet_used;

            // Calculate the tax based on the subtotal
            var taxtotal = subtotal * (tax_rate / 100);

            // Calculate the final total including tax
            var total = subtotal + taxtotal;
            $("#booking_total").text('$' + booking_total.toFixed(2));
            $("#experience_total").text('$' + experience_total.toFixed(2));
            $("#sundry_total").text('$' + sundry_total.toFixed(2));
            $("#sub_total").text('$' + subtotal.toFixed(2));
            $("#taxTotal").text('$' + taxtotal.toFixed(2));
            $("#fulltotal").html('$' + total.toFixed(2));
        }
        $(function() {
            experienceCalculation();
            priceCalculation();
        })

        function toggleContent(index) {
            var content = document.getElementById('collapseExample' + index);
            var link = document.getElementById('toggleContent' + index);
            if (content.style.display === "none") {
                content.style.display = "block";
                link.textContent = "View Less";
            } else {
                content.style.display = "none";
                link.textContent = "View More";
            }
        }
    </script>
    {{-- @endif --}}
    <script>
        $(document).ready(function() {
            $("#send-inquiry").on("click", async function() {
                try {
                    let selectedExperiences = [];
                    $('.experience_upgrades:checked').each(function() {
                        selectedExperiences.push({
                            name: $(this).next('label').text()
                                .trim(), // Get experience title
                            value: $(this).val() // Get upgrade fee
                        });
                    });

                    if ($("#checkout-form").valid()) {
                        let formData = new FormData(document.getElementById("checkout-form"));
                        formData.append('selectedExperiences', JSON.stringify(selectedExperiences));
                        formData.append('_token',
                            '{{ csrf_token() }}'); // Ensure CSRF token is included

                        $("#send-inquiry").prop("disabled", true).html('Sending...');

                        const response = await fetch('{{ route('orders.send-inquiry') }}', {
                            method: 'POST',
                            body: formData, // Do NOT set Content-Type (browser handles it for FormData)
                        });

                        const result = await response.json();
                        $("#send-inquiry").prop("disabled", false).html('Send Inquiry');

                        if (result.success) {
                            alert('Inquiry sent successfully!');
                            window.location.href = result.redirect_url;
                        } else {
                            alert(result.message || "Something went wrong! Please try again.");
                        }
                    }
                } catch (error) {
                    console.log(error);
                    $("#send-inquiry").prop("disabled", false).html('Send Inquiry');
                    alert("An error occurred. Please check your connection and try again.");
                }
            });
        });
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



        function capitalizeFirstLetter(string) {
            if (!string) return ''; // Handle empty or null strings
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

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
    </script>
    <script>
        var walletBalance = {{ $wallet->balance ?? 0.0 }};
        $("#wallet_balance").text('$' + walletBalance.toFixed(2));
        $(document).ready(function() {
            var walletUsed = 0;

            $('#use_wallet').change(function() {
                let isChecked = $(this).is(':checked');

                $('#wallet_used, #increase_wallet, #decrease_wallet').prop('disabled', !isChecked);
                if (isChecked) {
                    $("#bottle_bucks_container").addClass('d-flex').show();
                } else {
                    $("#bottle_bucks_container").removeClass('d-flex').hide();
                }
                if (!isChecked) {
                    walletUsed = 0;
                    $("#wallet_used").val(walletUsed);
                    priceCalculation();
                }
            });

            $('#increase_wallet').click(function() {
                let total = parseFloat($("#fulltotal").text().replace('$', '')) || 0;

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
    </script>
    <script>
        async function savePaymentMethod(paymentMethodId) {
            const response = await fetch("{{ route('customer.save-payment-method') }}", {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content'),
                },
                body: JSON.stringify({
                    payment_method_id: paymentMethodId
                }),
            });

            const data = await response.json();

            if (data.success) {
                console.log("Payment method saved successfully.");
            } else {
                console.error("Failed to save payment method:", data.error);
            }
        }
        async function createPaymentIntent(paymentMethodId, order_id) {
            try {
                const response = await fetch(
                    "{{ route('customer.create-payment-intent', $vendor->id) }}", {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        body: JSON.stringify({
                            payment_method_id: paymentMethodId,
                            order_id: order_id,
                        }),
                    });

                const data = await response.json();
                if (data.client_secret) {
                    return data; // Return the payment intent data
                } else {
                    console.error("Error creating payment intent:", data.error);
                    return null;
                }
            } catch (error) {
                console.error("Request failed:", error);
                return null;
            }
        }

        async function handlePayment(clientSecret, order_id, intentType) {
            const paymentMethodId = $("#selectedPaymentMethodId").val(); // Get selected payment method ID
            let paymentMethod = null;

            if (paymentMethodId) {
                // Use saved payment method
                paymentMethod = paymentMethodId;
            } else {
                try {
                    // Create a new payment method
                    let result = await stripe.createPaymentMethod({
                        type: 'card',
                        card: cardNumber, // Use your Stripe Elements card element here
                        billing_details: {
                            name: $('#cc-name').val(), // Cardholder name
                        }
                    });

                    if (result.error) {
                        Swal.fire({
                            title: "Payment failed",
                            text: result.error.message,
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                        restorePayButton();
                        return; // Stop execution if there's an error
                    }

                    paymentMethod = result.paymentMethod.id; // Get the created payment method ID
                    savePaymentMethod(paymentMethod); // Save the payment method if needed
                } catch (error) {
                    console.error("Error creating payment method:", error);
                    Swal.fire({
                        title: "Error",
                        text: "There was an error creating the payment method.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    restorePayButton();
                    return;
                }
            }

            try {
                let intent = await createPaymentIntent(paymentMethod, order_id);

                console.log("✅ Payment Intent Created:", intent);

                if (!intent || !intent.client_secret) {
                    console.error("❌ Missing client_secret in PaymentIntent response.");
                    throw new Error("Missing client_secret in PaymentIntent response.");
                }

                console.log("🚀 Proceeding with Payment Intent...");
                await proceedWithPayment(paymentMethod, intent, order_id);
            } catch (error) {
                console.error("⚠️ Error creating PaymentIntent:", error);
                Swal.fire({
                    title: "Error",
                    text: error.message || "There was an issue creating the payment intent.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
                restorePayButton();
            }
        }

        async function proceedWithPayment(paymentMethod, intent, order_id) {
            try {
                if (intent.error) {
                    await Swal.fire({
                        title: "Payment failed",
                        text: intent.error.message,
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    restorePayButton();
                    return;
                }

                if (intent.status === "requires_action") {
                    const result = await stripe.confirmCardPayment(intent.client_secret);
                    console.log("requires_action");

                    if (result.error) {
                        await Swal.fire({
                            title: "Authentication failed",
                            text: result.error.message,
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                        restorePayButton();
                        return;
                    }

                    await storeTransactionDetails({
                        order_id: order_id,
                        payment_intent_id: intent.id,
                        status: "succeeded",
                    });

                    await Swal.fire({
                        title: "Payment successful!",
                        text: "Your payment has been processed successfully.",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });

                    window.location.href = '{{ route('order.thankyou', ['id' => ':id']) }}'.replace(':id', order_id);
                    // resetCheckoutForm();
                    restorePayButton();
                } else if (intent.status === "succeeded") {
                    await storeTransactionDetails({
                        order_id: order_id,
                        payment_intent_id: intent.id,
                        status: "succeeded",
                    });

                    await Swal.fire({
                        title: "Payment successful!",
                        text: "Your payment has been processed successfully.",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });

                    window.location.href = '{{ route('order.thankyou', ['id' => ':id']) }}'.replace(':id', order_id);
                    // resetCheckoutForm();
                    restorePayButton();
                } else if (intent.status === "requires_capture") {
                    await storeTransactionDetails({
                        order_id: order_id,
                        payment_intent_id: intent.id,
                        status: "requires_capture",
                    });

                    await Swal.fire({
                        title: "Payment authorized!",
                        text: "Your payment has been authorized successfully.",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });

                    window.location.href = '{{ route('order.thankyou', ['id' => ':id']) }}'.replace(':id', order_id);
                    // resetCheckoutForm();
                    restorePayButton();
                }
            } catch (error) {
                console.error("Error in proceedWithPayment:", error);

                await Swal.fire({
                    title: "Error",
                    text: "There was an issue processing your payment.",
                    icon: "error",
                    confirmButtonText: "OK"
                });

                restorePayButton();
            }
        }


        function confirmPayment(paymentIntentId, order_id) {
            fetch('{{ route('customer.confirm-payment') }}', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
                    },
                    body: JSON.stringify({
                        payment_intent_id: paymentIntentId,
                        order_id: order_id,
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        // Payment was successful
                        storeTransactionDetails({
                            order_id: order_id,
                            payment_intent_id: paymentIntentId,
                            status: "requires_capture",
                        });

                        Swal.fire({
                            title: "Payment confirmed successfully!",
                            text: "Your payment has been confirmed.",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href =
                                '{{ route('order.thankyou', ['id' => ':orderid']) }}'.replace(':orderid',
                                    order_id);
                            // resetCheckoutForm(); // Reset the checkout form
                            restorePayButton(); // Restore the button after success
                        });
                    } else if (data.requires_action) {
                        // If 3D Secure or any additional authentication is needed
                        handlePayment(data.client_secret, order_id, "paymentIntent");
                    } else {
                        // Payment confirmation failed
                        Swal.fire({
                            title: "Payment confirmation failed",
                            text: "Please try again.",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                        restorePayButton(); // Restore the button after failure
                    }
                })
                .catch((error) => {
                    console.error("Confirmation Error:", error);
                    Swal.fire({
                        title: "Error",
                        text: "There was an error confirming the payment.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    restorePayButton(); // Restore the button after error
                });
        }

        function restorePayButton() {
            const $payButton = $("#submit-button");
            $payButton.html(originalButtonText);
            $payButton.prop('disabled', false);
        }

        $("#checkout-form").validate({

            rules: {

                // Guest Information

                name: {

                    required: true,

                    minlength: 2

                },

                email_address: {
                    required: true,
                    email: true
                },

                contact_number: {

                    required: true,

                },


                street_address: "required",

                city: "required",

                country: "required",

                state: "required",

                postal_code: {

                    required: true,

                    minlength: 5

                }

            },

            messages: {
                // Guest Information

                name: {

                    required: "Please enter your first name.",

                    minlength: "First name must be at least 2 characters."

                },

                email_address: {

                    required: "Please enter your email address.",

                    email: "Please enter a valid email address."

                },

                contact_number: {

                    required: "Please enter your phone number.",
                },

                street_address: "Please enter your street address.",

                city: "Please enter your city.",

                state: "Please enter your state.",

                country: "Please enter your country.",

                postal_code: {

                    required: "Please enter your postal code.",

                    minlength: "Postal code must be at least 5 characters."

                }

            },

            errorElement: "div" //, // error element as span



            // errorPlacement: function(error, element) {
            //     error.insertAfter(element); // Insert error after the element
            // }
        });

        $("#submit-button").on("click", async function(event) {
            event.preventDefault();
            let selectedExperiences = [];
            $('.experience_upgrades:checked').each(function() {
                selectedExperiences.push({
                    name: $(this).next('label').text()
                        .trim(), // Get the name (title) of the experience
                    value: $(this).val() // Get the upgrade fee
                });
            });
            // if ($("#cc-name").val() == "") {
            //     document.getElementById('card-errors').textContent = "Name is required";
            //     $("#card-errors").removeClass('d-none');
            //     return false;
            // }
            const formData = new FormData();
            @if (isset($inquiry) && !empty($inquiry->apk))
                const $payButton = $(this);
                // Save the original button text globally

                // Change button to show spinner
                $payButton.html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                );
                $payButton.prop('disabled', true); // Disable button to prevent multiple clicks

                // Append data from both forms

                if ($("#selectedPaymentMethodId").val() != null) {
                    formData.append("payment_method_id", $("#selectedPaymentMethodId").val());
                }
                formData.append('wallet_used', $('#wallet_used').val() || 0.00);
                fetch('{{ route('orders.authorize-payment') }}', {
                        method: "POST",
                        headers: {
                            "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content'),
                            "Accept": "application/json"
                        },
                        body: formData
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        // if (data.client_secret && data.order_id) {
                        handlePayment(data.client_secret, data.order_id, data.intent_type);
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        restorePayButton(); // Restore the button on error
                    });
            @else
                if ($("#checkout-form").valid()) {
                    const $payButton = $(this);
                    // Save the original button text globally

                    // Change button to show spinner
                    $payButton.html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                    );
                    $payButton.prop('disabled', true); // Disable button to prevent multiple clicks

                    // Append data from both forms
                    const checkoutFormData = new FormData(document.getElementById("checkout-form"));
                    for (let [key, value] of checkoutFormData.entries()) {
                        formData.append(key, value);
                    }

                    if ($("#selectedPaymentMethodId").val() != null) {
                        formData.append("payment_method_id", $("#selectedPaymentMethodId").val());
                    }
                    formData.append('selectedExperiences', JSON.stringify(selectedExperiences));
                    formData.append('wallet_used', $('#wallet_used').val() || 0.00);
                    fetch('{{ route('orders.authorize-payment') }}', {
                            method: "POST",
                            headers: {
                                "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content'),
                                "Accept": "application/json"
                            },
                            body: formData
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            // if (data.client_secret && data.order_id) {
                            handlePayment(data.client_secret, data.order_id, data.intent_type);
                            // } else {
                            //     console.error("Missing client_secret or order_id in response:", data);
                            //     restorePayButton(); // Restore the button if data is missing
                            // }
                        })
                        .catch((error) => {
                            console.error("Error:", error);
                            restorePayButton(); // Restore the button on error
                        });
                }
            @endif
        });

        function storeTransactionDetails(details = null) {
            fetch('{{ route('store-order-transaction-details') }}', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content'),
                    },
                    body: JSON.stringify(details),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        console.log("Transaction details stored successfully.");
                    } else {
                        console.error("Failed to store transaction details:", data.error);
                    }
                })
                .catch((error) => {
                    console.error("Error storing transaction details:", error);
                });
        }
    </script>
    <script>
        $(document).ready(function() {
            // Fetch and display saved payment methods
            // Switch to new card form
            $("#use-new-card").on("change", function() {
                $("#checkout-payment-form").removeClass("d-none");
                $("#payment-methods-container").addClass("d-none");
                $("#selectedPaymentMethodId").val('');
            });

            // Switch back to saved cards
            $("#back-to-saved").on("change", function() {
                $("#payment-methods-container").removeClass("d-none");
                $("#checkout-payment-form").addClass("d-none");

                const selectedPaymentMethodId = $("input[name='payment-method']:checked").val();

                // Set the hidden field with the selected payment method ID
                if (selectedPaymentMethodId) {
                    $("#selectedPaymentMethodId").val(selectedPaymentMethodId);
                }
            });

            // AJAX call to load payment methods
            function loadPaymentMethods() {
                $.ajax({
                    url: "{{ route('customer.list-payment-methods') }}",
                    type: "GET",
                    success: function(data) {
                        let response = data.data;
                        let methodsList = $("#payment-methods-list");
                        methodsList.empty(); // Clear existing payment methods

                        if (response.length === 0) {
                            methodsList.append(
                                '<li class="list-group-item">No saved payment methods.</li>');
                        } else {
                            response.forEach(function(method) {
                                // Check if it's the default method
                                let isDefault = method.is_default;
                                $("#selectedPaymentMethodId").val(method.id);
                                // If the payment method is default, show a badge and disable the buttons
                                let defaultBadge = isDefault ?
                                    '<span class="badge bg-success">Default</span>' : '';

                                let buttonSection = !isDefault ? `
                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn btn-sm btn-primary make-default-payment" data-id="${method.id}">
                                <i class="fa-solid fa-star"></i>
                            </button>
                            <button class="btn btn-sm btn-danger remove-payment" data-id="${method.id}">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    ` : ''; // If default, no buttons will be shown

                                // Format the expiry date
                                let expDate = method.exp_month && method.exp_year ?
                                    `${method.exp_month}/${method.exp_year}` :
                                    'N/A';

                                // Add the payment method list item
                                methodsList.append(`
                        <li class="list-group-item">
                            <!-- Button Section (only for non-default methods) -->
                            ${buttonSection}
                            <!-- Radio Button + Card Details -->
                            <div class="d-flex align-items-center">
                                <input type="radio" name="payment-method" value="${method.id}" id="payment-method-${method.id}" 
                                    class="select-payment-method me-2" ${isDefault ? 'checked' : ''}>
                                <span class="fw-bold">${method.brand} •••• ${method.last4} ${defaultBadge}</span>
                            </div>
                            <!-- Expiry Date -->
                            <div class="mt-2">
                                <span>Expiry: ${expDate}</span>
                            </div>
                        </li>
                    `);
                            });
                        }
                    },
                    error: function() {
                        $("#payment-methods-list").html(
                            '<li class="list-group-item text-danger">Failed to load payment methods.</li>'
                        );
                    }
                });
            }

            // Call function to load payment methods
            loadPaymentMethods();

            // Remove payment method
            $(document).on("click", ".remove-payment", function() {
                let methodId = $(this).data("id");

                Swal.fire({
                    title: "Are you sure?",
                    text: "This payment method will be removed permanently.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, remove it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('vendor.remove-payment-method', ':vendorid') }}"
                                .replace(':vendorid', vendorId),
                            type: "POST",
                            data: {
                                payment_method_id: methodId
                            },
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    "content") // For Laravel CSRF protection
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your payment method has been removed.",
                                    icon: "success",
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                loadPaymentMethods(); // Refresh the list
                            },
                            error: function() {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to remove payment method.",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });
            $(document).on("click", ".make-default-payment", function() {
                let methodId = $(this).data("id");

                Swal.fire({
                    title: "Set as Default?",
                    text: "Do you want to set this card as your default payment method?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Set as Default"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('vendor.set-default-payment-method', ':vendorid') }}"
                                .replace(':vendorid', vendorId),
                            type: "POST",
                            data: {
                                payment_method_id: methodId
                            },
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    "content") // CSRF Protection
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: "Updated!",
                                    text: "Your default payment method has been updated.",
                                    icon: "success",
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                loadPaymentMethods(); // Refresh the list
                            },
                            error: function() {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to update default payment method.",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });
            $(document).on('change', '.select-payment-method', function() {
                let selectedPaymentMethodId = $(this).val();

                // Optionally, update some element or send an AJAX request to set the selected payment method
                $("#selectedPaymentMethodId").val(selectedPaymentMethodId);
                // You can use AJAX here to update the backend or handle further logic
            });
        });
    </script>
@endsection
