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

                                    <h2 class="fw-bold fs-4 mb-0" style="color: #c0a144;">Order Detail</h2>
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

                                                        <div
                                                            class="d-flex align-items-center justify-content-between mb-2">

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

                                                        <div
                                                            class="d-flex align-items-center justify-content-between mb-2">

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

                                                    <ul class="">

                                                        <li class="mb-0">

                                                            @if ($vendor->policy == 'partial')
                                                                A full refund minus transaction fees will be issued upon
                                                                request

                                                                up to 7 days

                                                                prior to the check-in date indicated. No refund will be
                                                                issued

                                                                for cancellations

                                                                that fall within that 7-day period prior to the check-in
                                                                date. A

                                                                credit or rain

                                                                cheque may be issued to guests at the vendor’s discretion.
                                                            @elseif($vendor->policy == 'open')
                                                                A full refund minus transaction fees will be issued upon
                                                                request

                                                                up to 24 hours

                                                                prior to the check-in date indicated.
                                                            @elseif($vendor->policy == 'closed')
                                                                All bookings are final. No portion of your transaction will
                                                                be

                                                                refunded. A

                                                                credit or rain cheque may be issued by the subject vendor at
                                                                the

                                                                vendor’s

                                                                discretion.
                                                            @endif

                                                        </li>

                                                    </ul>

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
                                                                        <p class="mb-0"><b>Order Cancelled By Vendor</b></p>
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
@endsection
