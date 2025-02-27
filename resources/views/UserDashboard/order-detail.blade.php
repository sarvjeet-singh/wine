@extends('FrontEnd.layouts.mainapp')



@section('title', 'Wine Country Weekends - Guest Registry')



@section('content')

    <style>
        .summary-content-sec.invoice-sec {

            max-width: 980px;

            margin: 0 auto;

        }



        /*.summary-content-sec.invoice-sec .sec-head {
                                                                        background-color: #f9f9f9;
                                                                    }*/
        .summary-content-sec.invoice-sec .booking-details .sec-head {
            border-radius: 24px 24px 0 0;
        }

        .summary-content-sec.invoice-sec .sec-head h3 {
            font-size: 18px;
            color: #c0a144;
        }

        .summary-content-sec.invoice-sec .detail-outer-box svg path {
            fill: #c0a144;
        }


        .summary-content-sec.invoice-sec .sec-head h3 svg {
            padding-right: 5px;
        }

        .summary-content-sec.invoice-sec .detail-outer-box svg {

            width: 20px;

            height: 20px;

        }

        .summary-content-sec.invoice-sec.payment-status p:last-child {
            color: #129647;
        }

        .summary-content-sec.invoice-sec .main-head {
            padding-inline: 70px;
        }

        a.back-btn {
            position: absolute;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            z-index: 1;
            font-size: 18px;
        }

        a.back-btn svg {
            padding-right: 2px;
            height: 16px;
        }
    </style>

    <div class="container main-container">

        <div class="row flex-lg-nowrap flex-wrap g-4">

            @include('UserDashboard.includes.leftNav')

            <div class="col right-side">



                <section class="summary-content-sec invoice-sec">

                    <div class="container">

                        <div class="row">

                            <div class="col-12">

                                <div class="main-head py-3 text-center position-relative">

                                    <h2 class="fw-bold fs-4 mb-0" style="color: #c0a144;">Order Detail #{{ $order->id }}
                                    </h2>
                                    <a href="javascript:void(0);" onclick="history.back()" class="back-btn"><i
                                            class="fa-solid fa-arrow-left"></i> Back</a>

                                </div>

                                <div class="">
                                    <div class="information-box mb-3">
                                        <div class="booking-details">

                                            <div class="sec-head border-bottom px-4 py-3">

                                                <h3 class="fw-bold mb-0"><i class="fa-solid fa-calendar-day"></i> Booking
                                                    Details</h3>

                                            </div>

                                            <div class="px-4 py-3">

                                                <div class="row gx-5 gy-2">

                                                    <div class="col-12">

                                                        <div class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Property Name</p>

                                                            <p class="mb-0">{{ $vendor->vendor_name }}</p>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Sub-Region</p>

                                                            <p class="mb-0">{{ $vendor->vendor_sub_category }}</p>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Phone Number</p>

                                                            <p class="mb-0">{{ $vendor->vendor_phone }}</p>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Check-In Date/Time</p>

                                                            <p class="mb-0">

                                                                {{ date('jS M Y', strtotime($order->check_in_at)) }}</p>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Check-Out Date/Time</p>

                                                            <p class="mb-0">

                                                                {{ date('jS M Y', strtotime($order->check_out_at)) }}</p>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Number of Nights</p>

                                                            <p class="mb-0">{{ $order->nights_count }}</p>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Number in Travel Party</p>

                                                            <p class="mb-0">{{ $order->travel_party_size }}</p>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Nature of Visit</p>

                                                            <p class="mb-0">{{ $order->visit_purpose }}</p>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Base Rate</p>

                                                            <p class="mb-0">${{ $order->rate_basic }}/Night</p>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="information-box mb-3">
                                        <div class="guest-details">

                                            <div class="sec-head border-bottom px-4 py-3">

                                                <h3 class="fw-bold mb-0"><i class="fa-solid fa-user-group"></i>

                                                    Guest Details</h3>

                                            </div>

                                            <div class="px-4 py-3">

                                                <div class="row gx-5 gy-2">

                                                    <div class="col-md-6">

                                                        <div class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Guest Name</p>

                                                            <p class="mb-0">{{ $order->guest_name }}</p>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="d-flex align-items-center justify-content-between">

                                                            <p class="info-label mb-0 fw-bold">Guest Email</p>

                                                            <p class="mb-0">{{ $order->guest_email }}</p>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    @php

                                        $experiences = json_decode($order->experiences_selected);

                                    @endphp

                                    <div class="information-box mb-3">
                                        <div class="exp-update">

                                            <div class="sec-head border-bottom px-4 py-3">

                                                <h3 class="fw-bold mb-0"><i class="fa-solid fa-pen-to-square"></i>Curated
                                                    Experience</h3>

                                            </div>

                                            <div class="px-4 py-3">

                                                <div class="row gx-5 gy-2">

                                                    @foreach ($experiences as $experience)
                                                        <div class="col-12">

                                                            <div class="d-flex align-items-center justify-content-between">

                                                                <p class="info-label mb-0 fw-bold">{{ $experience->name }}
                                                                </p>

                                                                <p class="mb-0">Upgrade Fee: ${{ $experience->value }}
                                                                </p>

                                                            </div>

                                                        </div>
                                                    @endforeach

                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="information-box border-bottom mb-3">
                                        <div class="sundry-charges">

                                            <div class="sec-head px-4 py-3">

                                                <h3 class="fw-bold mb-0"><i class="fa-solid fa-file-invoice-dollar"></i>
                                                    Sundry Charges</h3>

                                            </div>

                                            <div class="px-4 py-3">

                                                <div class="row gx-5 gy-2">

                                                    <div class="col-md-6">

                                                        <div class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Cleaning Fees</p>

                                                            <p class="mb-0">${{ $order->cleaning_fee }}</p>

                                                        </div>

                                                    </div>

                                                    {{-- <div class="col-md-6">

                                                    <div class="d-flex align-items-center justify-content-between mb-2">

                                                        <p class="info-label mb-0 fw-bold">Transaction Tax</p>

                                                        <p class="mb-0">{{ $order->tax_rate }}%</p>

                                                    </div>

                                                </div> --}}

                                                    <div class="col-md-6">

                                                        <div class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Security Deposit</p>

                                                            <p class="mb-0">${{ $order->security_deposit }}</p>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div
                                                            class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Pet Boarding</p>

                                                            <p class="mb-0">${{ $order->pet_fee }}</p>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="information-box mb-3">
                                        <div class="refund-policies">

                                            <div class="sec-head border-bottom px-4 py-3">

                                                <h3 class="fw-bold mb-0"><i class="fa-solid fa-file-shield"></i>

                                                    Refund Policy</h3>

                                            </div>

                                            <div class="px-4 py-3">

                                                @if ($vendor->policy != '')
                                                    {!! refundContent($vendor->policy) !!}
                                                @endif

                                            </div>

                                        </div>
                                    </div>

                                    <div class="information-box mb-3">
                                        <div class="total-cost">

                                            <div class="sec-head border-bottom px-4 py-3">

                                                <h3 class="fw-bold mb-0"><i class="fa-solid fa-sack-dollar"></i> Totals
                                                </h3>

                                            </div>

                                            <div class="px-4 py-3">

                                                @php

                                                    $sub_total =
                                                        $order->rate_basic * $order->nights_count +
                                                        $order->experiences_total +
                                                        $order->cleaning_fee +
                                                        $order->security_deposit +
                                                        $order->pet_fee -
                                                        $order->wallet_used;

                                                    $tax = ($sub_total * $order->tax_rate) / 100;

                                                @endphp

                                                <div class="d-flex align-items-center justify-content-between mb-2">

                                                    <p class="fw-bold mb-0">Sub-Totals:</p>

                                                    <p class="fw-bold mb-0">${{ number_format($sub_total, 2, '.', '') }}
                                                    </p>

                                                </div>
                                                @if ($order->wallet_used != 0)
                                                    <div class="d-flex align-items-center justify-content-between mb-2">

                                                        <p class="fw-bold mb-0">Bottle Bucks Used:</p>

                                                        <p class="fw-bold mb-0">
                                                            ${{ number_format($order->wallet_used, 2, '.', '') }}</p>

                                                    </div>
                                                @endif
                                                <div class="d-flex align-items-center justify-content-between mb-2">

                                                    <p class="fw-bold mb-0">Taxes:</p>

                                                    <p class="fw-bold mb-0">${{ number_format($tax, 2, '.', '') }}</p>

                                                </div>

                                                <div class="d-flex align-items-center justify-content-between mb-2">

                                                    <p class="fw-bold mb-0 fs-5" style="color: #c0a144;">Total:</p>

                                                    <p class="fw-bold mb-0 fs-5" style="color: #c0a144;">

                                                        ${{ number_format($sub_total + $tax, 2, '.', '') }}</p>

                                                </div>

                                                <div
                                                    class="d-flex align-items-center justify-content-between payment-status">

                                                    <p class="fw-bold mb-0 fs-6">Payment Status</p>

                                                    <p class="fw-bold mb-0 fs-6">{{ ucfirst($order->payment_status) }}</p>

                                                </div>
                                                @if ($order->payment_status === 'pending')
                                                    <div class="alert alert-warning mt-2">
                                                        <p class="mb-1">Your payment is currently pending. Please
                                                            complete your payment to avoid booking cancellation issues.</p>

                                                    </div>
                                                    <div id="payment-methods-container">
                                                        <h4 class="fw-bold">Saved Payment Methods</h4>
                                                        <input type="hidden" id="selectedPaymentMethodId"
                                                            name="payment_method_id" value="">
                                                        <!-- Payment Methods List (Will be populated by AJAX) -->
                                                        <ul id="payment-methods-list" class="list-group"></ul>
                                                        <!-- "Use a New Card" Option -->
                                                        <div class="form-check mb-2">
                                                            <input type="radio" name="payment_method_select"
                                                                value="new" id="use-new-card"
                                                                class="form-check-input">
                                                            <label for="use-new-card" class="form-check-label fw-bold">Use
                                                                a New
                                                                Card</label>
                                                        </div>
                                                    </div>
                                                    <div id="checkout-payment-form" class="d-none">
                                                        <!-- "Back to Saved Cards" Option -->
                                                        <div class="form-check mb-2">
                                                            <input type="radio" name="payment_method_select"
                                                                value="saved" id="back-to-saved"
                                                                class="form-check-input">
                                                            <label for="back-to-saved"
                                                                class="form-check-label fw-bold">Use a Saved
                                                                Card</label>
                                                        </div>
                                                        <div class="cart-box p-4">

                                                            <h4 class="fw-bold">Add a New Card</h4>

                                                            <div class="checkout-box border-top mt-3 pt-3">

                                                                <form action="">

                                                                    <div class="row g-sm-3 g-2">

                                                                        <div id="card-container">

                                                                            <div class="row">

                                                                                <div class="col-12">

                                                                                    <div id="card-errors"
                                                                                        style="color:red"></div>

                                                                                </div>

                                                                            </div>

                                                                            <div class="mb-2">

                                                                                <label for="cc-name">Card Holder
                                                                                    Name</label>

                                                                                <input type="text"
                                                                                    class="form-control mt-2"
                                                                                    id="cc-name"
                                                                                    placeholder="Card Holder Name">

                                                                            </div>

                                                                            <div class="row">

                                                                                <div class="col-12 col-md-12">

                                                                                    <div class="form-floating mb-2">

                                                                                        <div id="cc-number"></div>

                                                                                        <label for="cc-number">Card
                                                                                            number</label>

                                                                                    </div>

                                                                                </div>

                                                                            </div>

                                                                            <div class="row">

                                                                                <div class="col-md-6">

                                                                                    <div class="form-floating">

                                                                                        <div id="cc-expiry"></div>

                                                                                        <label
                                                                                            for="cc-expiry">MM/AA</label>

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
                                                            class="btn book-btn wine-btn w-100 text-uppercase mt-2">Repay</button>

                                                    </div>
                                                    <!-- Stripe Payment Sec End -->
                                                @endif

                                            </div>

                                        </div>
                                    </div>
                                    <div class="information-box">
                                        <div class="guest-details">

                                            <div class="sec-head border-bottom px-4 py-3">

                                                <h3 class="fw-bold mb-0"><i class="fa-solid fa-user-group"></i>

                                                    Cancel Order</h3>

                                            </div>

                                            <div class="px-4 py-3">

                                                <div class="row gx-5 gy-2">

                                                    <div class="col-md-6">

                                                        <div class="d-flex align-items-start justify-content-between mb-2">
                                                            @if ($order->cancelled_at != null)
                                                                <div class="d-flex flex-column">
                                                                    <p class="info-label mb-0 fw-bold">Cancel Reason</p>
                                                                    @if (!empty($order->vendor_cancelled))
                                                                        <p class="mb-0"><b>Order Cancelled By Vendor</b>
                                                                        </p>
                                                                    @else
                                                                        <p class="mb-0"><b>Order Cancelled By You</b></p>
                                                                    @endif
                                                                    <p class="mb-0">{{ $order->cancel_reason }}</p>
                                                                </div>
                                                            @else
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#cancelOrderModal">
                                                                    Cancel Order
                                                                </button>
                                                            @endif
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </section>





            </div>

        </div>

    </div>
    <!-- Cancel Order Modal -->
    <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelOrderModalLabel">Cancel Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="cancelOrderForm">
                        <input type="hidden" id="order_id" value="{{ $order->id }}">
                        <div class="mb-3">
                            <label for="cancel_reason" class="form-label">Reason for Cancellation</label>
                            <textarea class="form-control" id="cancel_reason" rows="3" placeholder="Enter cancellation reason"></textarea>
                            <span class="text-danger" id="cancel_reason_error"></span>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Cancel Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('UserDashboard.includes.logout_modal')

@endsection



@section('js')
    <script>
        $(document).ready(function() {
            $("#cancelOrderForm").submit(function(e) {
                e.preventDefault(); // Prevent default form submission

                let orderId = $("#order_id").val();
                let cancelReason = $("#cancel_reason").val();
                let url = "{{ route('orders.cancel') }}"; // Ensure this matches your route

                // Clear previous errors
                $("#cancel_reason_error").text("");

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        order_id: orderId,
                        cancel_reason: cancelReason
                    },
                    beforeSend: function() {
                        $("#cancelOrderForm button[type='submit']")
                            .prop("disabled", true)
                            .text("Cancelling...");
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: response.message,
                                confirmButtonText: "OK"
                            }).then(() => {
                                $("#cancelOrderModal").modal("hide");
                                window.location.href = window.location
                                    .href; // Local reload
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: response.message,
                                confirmButtonText: "OK"
                            });
                            $("#cancelOrderForm button[type='submit']")
                                .prop("disabled", false)
                                .text("Cancel Order");
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        if (errors && errors.cancel_reason) {
                            $("#cancel_reason_error").text(errors.cancel_reason[0]);
                            $("#cancelOrderForm button[type='submit']")
                                .prop("disabled", false)
                                .text("Cancel Order");
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: errors.cancel_reason[0],
                                confirmButtonText: "OK"
                            });
                        }
                    },
                    complete: function() {
                        $("#cancelOrderForm button[type='submit']")
                            .prop("disabled", false)
                            .text("Cancel Order");
                    }
                });
            });
        });
    </script>
    @if ($order->payment_status == 'pending')
        <script>
            const submitButton = document.getElementById('submit-button');
            const originalButtonText = submitButton ? submitButton.textContent : '';
        </script>
        <script src="https://js.stripe.com/v3/"></script>
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
                                url: "{{ route('customer.remove-payment-method') }}",
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
                                url: "{{ route('customer.set-default-payment-method') }}",
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

                        location.reload();
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

                        location.reload();
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

                        location.reload();
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
                                location.reload();
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
            $("#submit-button").on("click", async function(event) {
                event.preventDefault();


                const $payButton = $(this);
                // Save the original button text globally

                // Change button to show spinner
                $payButton.html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                );
                $payButton.prop('disabled', true); // Disable button to prevent multiple clicks
                fetch('{{ route('orders.reauthorize-payment', $order->id) }}', {
                        method: "POST",
                        headers: {
                            "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content'),
                            "Accept": "application/json"
                        }
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


            });
        </script>
    @endif
@endsection
