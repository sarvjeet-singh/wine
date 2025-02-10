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
    </style>
    <!--*********** SUMMARY DETAIL SEC START ***********-->
    <section class="summary-content-sec">
        <div class="container">
            <div class="row mt-md-5 mt-3">
                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center my-3">
                        <h5 class="theme-color mb-0">
                            {{ !empty($vendor->sub_category->name) ? $vendor->sub_category->name : '' }}</h5>
                        <!-- <div class="rating-star d-flex align-items-center"
                                                    data-rating="{{ $vendor->reviews->avg('rating') ?? 0.0 }}"></div> -->
                    </div>
                    <h3 class="card-title">{{ $vendor->vendor_name }}
                        [{{ !empty($vendor->sub_regions->name) ? $vendor->sub_regions->name : '' }}]</h3>
                    <div class="info d-flex align-items-baseline gap-2 mb-2">
                        <i class="fa-solid fa-location-dot theme-color"></i>
                        <p class="mb-0">{{ $vendor->street_address }},<br> {{ $vendor->city }}, {{ $vendor->province }}
                        </p>
                    </div>
                    <div class="info d-flex align-items-baseline gap-2 mb-2">
                        <i class="fa-solid fa-phone theme-color"></i>
                        <p class="mb-0"><a class="text-decoration-none"
                                href="tel:{{ $vendor->vendor_phone }}">{{ $vendor->vendor_phone }}</a></p>
                    </div>
                    <p class="desc mb-3">{{ $vendor->description }}</p>
                </div>
                <div class="col-md-6">
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
                    <div class="summary-gallery-img">
                        @if (!empty($vendor->mediaLogo))
                            <img src="{{ asset($vendor->mediaLogo->vendor_media) }}" class="img-fluid"
                                alt="Property Image">
                        @elseif($vendor->mediaGallery->isNotEmpty())
                            <img src="{{ asset($vendor->mediaGallery[0]->vendor_media) }}" class="img-fluid"
                                alt="Property Image">
                        @elseif ($vendor->vendor_media_logo)
                            <img src="{{ asset($vendor->vendor_media_logo) }}" class="img-fluid" alt="Property Image">
                        @else
                            <img src="{{ asset('images/vendorbydefault.png') }}" class="img-fluid" alt="Property Image">
                        @endif
                    </div>
                </div>
            </div>

            <div class="row mt-sm-5 mt-4">
                <div class="col-lg-8">
                    <div class="detail-outer-box border">
                        <div class="booking-details border-bottom p-sm-4 p-3">
                            <h3 class="text-dark fw-bold fs-5 mb-3"><i class="fa-solid fa-calendar-day"></i> Booking Details
                            </h3>
                            <h6 class="fw-bold mb-2 theme-color">Travel Dates:</h6>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <p class="info-label mb-0">Check-In Date/Time:</p>
                                <p class="mb-0">
                                    {{ Carbon::createFromFormat('Y-m-d', $booking->start_date)->format('Y-F-d') }}
                                    ({{ !empty($vendor->accommodationMetadata->checkin_start_time) ? $vendor->accommodationMetadata->checkin_start_time : '' }}
                                    –
                                    {{ !empty($vendor->accommodationMetadata->checkin_end_time) ? $vendor->accommodationMetadata->checkin_end_time : '' }})
                                </p>
                                <!-- 2024-May-16  3:00 PM – 12:00 AM-->
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <p class="info-label mb-0">Check-out Date/Time</p>
                                <p class="mb-0">
                                    {{ Carbon::createFromFormat('Y-m-d', $booking->end_date)->format('Y-F-d') }} ( Before
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
                                        ${{ $vendor->pricing->current_rate ? number_format($vendor->pricing->current_rate, 2, '.', '') : '0.00' }}
                                    @endif
                                    <b>/night</b>
                                </p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="info-label fw-bold mb-0">Sub-Total</p>
                                <p class="fw-bold mb-0"
                                    data-value="{{ number_format(($inquiry && !empty($inquiry->rate_basic) ? $inquiry->rate_basic : $vendor->pricing->current_rate) * $booking->days, 2, '.', '') }}"
                                    id="bookingTotal">
                                    ${{ number_format(($inquiry && !empty($inquiry->rate_basic) ? $inquiry->rate_basic : $vendor->pricing->current_rate) * $booking->days, 2, '.', '') }}
                                </p>
                            </div>
                        </div>
                        <div class="guest-details border-bottom p-sm-4 p-3">
                            <h3 class="text-dark fw-bold fs-5 mb-3"><i class="fa-solid fa-user-group"></i> Guest Details
                            </h3>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <p class="info-label mb-0">Guest Name</p>
                                <p class="mb-0">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <p class="info-label mb-0">Guest Email</p>
                                <p class="mb-0">{{ Auth::user()->email }}</p>
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
                            <h4 class="text-dark fw-bold fs-6 mb-3">Refund Policy</h4>
                            @if ($vendor->policy != '')
                                <ul class="">
                                    <li class="mb-2">
                                        @if ($vendor->policy == 'partial')
                                            A full refund minus transaction fees will be issued upon request up to 7 days
                                            prior to the check-in date indicated. No refund will be issued for cancellations
                                            that fall within that 7-day period prior to the check-in date. A credit or rain
                                            cheque may be issued to guests at the vendor’s discretion.
                                        @elseif($vendor->policy == 'open')
                                            A full refund minus transaction fees will be issued upon request up to 24 hours
                                            prior to the check-in date indicated.
                                        @elseif($vendor->policy == 'closed')
                                            All bookings are final. No portion of your transaction will be refunded. A
                                            credit or rain cheque may be issued by the subject vendor at the vendor’s
                                            discretion.
                                        @endif
                                    </li>
                                </ul>
                            @endif
                        </div>
                    </div>
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
                                            $0.00
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
                    {{-- <div class="sec-btn text-center mt-4">
                        <button class="btn book-btn w-100">Make Payment</button>
                    </div> --}}
                    @if (
                        (!empty($vendor->accommodationMetadata->process_type) ? $vendor->accommodationMetadata->process_type : '') ==
                            'one-step' || !empty($booking->apk))
                        <!-- Stripe Payment Sec Start -->
                        <div class="detail-outer-box border mt-4">
                            <div class="stripe-payment-sec">
                                <div class="p-sm-4 p-3 pb-sm-2 pb-1 mb-3 border-bottom">
                                    <h4 class="text-dark fw-bold fs-6">Payment Form</h4>
                                </div>
                                <div class="p-sm-4 p-3 pt-sm-0 pt-0">
                                    <form action="" id="payment-form">
                                        <div class="row g-sm-3 g-2 mb-3">
                                            <div id="card-errors" style="color: red"></div>
                                            <div class="col-12">
                                                <label for="" class="form-label">Name</label>
                                                <input type="text" name="cc-name" id="cc-name" class="form-control"
                                                    placeholder="Name" id="">
                                            </div>
                                            <div class="col-12">
                                                <label for="" class="form-label">Card Number</label>
                                                <div id="cc-number">

                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="" class="form-label">Expiration Date</label>
                                                <div id="cc-expiry">

                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="" class="form-label">CVV</label>
                                                <div id="cc-cvc"></div>
                                            </div>
                                            <div class="col-12">
                                                <button id="submit-button" type="submit"
                                                    class="btn book-btn w-100 text-uppercase mt-2">Pay</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
    @if (
        (!empty($vendor->accommodationMetadata->process_type) ? $vendor->accommodationMetadata->process_type : '') ==
            'one-step' || !empty($booking->apk))
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            const stripe = Stripe('{{ $vendor->stripeDetails->stripe_publishable_key }}');
            const elements = stripe.elements();
            var cardNumber = elements.create('cardNumber', {
                classes: {
                    base: 'form-control'
                }
            });

            var cardExpiry = elements.create('cardExpiry', {
                classes: {
                    base: 'form-control'
                }
            });

            var cardCvc = elements.create('cardCvc', {
                classes: {
                    base: 'form-control'
                }
            });
            cardNumber.mount('#cc-number');
            cardExpiry.mount('#cc-expiry');
            cardCvc.mount('#cc-cvc');

            $("#payment-form").on('submit', async (event) => {
                event.preventDefault();
                let selectedExperiences = [];
                $('.experience_upgrades:checked').each(function() {
                    selectedExperiences.push({
                        name: $(this).next('label').text()
                            .trim(), // Get the name (title) of the experience
                        value: $(this).val() // Get the upgrade fee
                    });
                });
                if ($("#cc-name").val() == "") {
                    document.getElementById('card-errors').textContent = "Name is required";
                    $("#card-errors").removeClass('d-none');
                    return false;
                }
                $("#submit-button").prop("disabled", true);
                $("#submit-button").html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>'
                );
                const {
                    paymentMethod,
                    error
                } = await stripe.createPaymentMethod({
                    type: 'card',
                    card: cardNumber,
                    billing_details: {
                        name: $("#cc-name").val(),
                    }
                });

                if (error) {
                    // Display error to the user
                    document.getElementById('card-errors').textContent = error.message;
                    $("#card-errors").removeClass('d-none');
                } else {
                    // Send the PaymentMethod id to your server
                    const response = await fetch('{{ route('orders.authorize-payment') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            paymentMethodId: paymentMethod.id,
                            selectedExperiences: selectedExperiences,
                            _token: '{{ csrf_token() }}',
                        }),
                    });

                    const result = await response.json();
                    if (result.success) {
                        $("#submit-button").prop("disabled", false);
                        $("#submit-button").html('Pay');
                        // Payment method added successfully
                        $('#add-payment-method-modal').modal('hide');
                        alert('Payment method added successfully!');
                        window.location.href = result.redirect_url;
                        // location.reload();
                    } else {
                        $("#submit-button").prop("disabled", false);
                        $("#submit-button").html('Pay');
                        // Handle server-side errors
                        alert("Something went wrong! try again later");
                    }
                }
            });
            @endif
        </script>
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
        @if (!$inquiry)
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

                    // Calculate the subtotal before tax
                    var subtotal = booking_total + experience_total + sundry_total;

                    // Calculate the tax based on the subtotal
                    var taxtotal = subtotal * (tax_rate / 100);
                    console.log(taxtotal);

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
        @endif
        <script>
            $(document).ready(function() {
                $("#send-inquiry").on("click", async function() {
                    try {
                        let selectedExperiences = [];
                        $('.experience_upgrades:checked').each(function() {
                            selectedExperiences.push({
                                name: $(this).next('label').text()
                                    .trim(), // Get the name (title) of the experience
                                value: $(this).val() // Get the upgrade fee
                            });
                        });
                        const response = await fetch('{{ route('orders.send-inquiry') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                selectedExperiences: selectedExperiences, // Ensure this is defined
                                _token: '{{ csrf_token() }}',
                            }),
                        });

                        const result = await response.json();

                        $("#submit-button").prop("disabled", false).html('Pay');

                        if (result.success) {
                            // Payment method added successfully
                            alert('Inquiry sent successfully!');
                            window.location.href = result.redirect_url;
                        } else {
                            // Handle server-side errors
                            alert("Something went wrong! Please try again later.");
                        }
                    } catch (error) {
                        // Handle fetch or network errors
                        $("#submit-button").prop("disabled", false).html('Pay');
                        alert("An error occurred. Please check your connection and try again.");
                    }
                });
            });
        </script>
    @endsection
