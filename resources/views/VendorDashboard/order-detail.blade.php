@extends('VendorDashboard.layouts.vendorapp')



@section('title', 'Wine Country Weekends - Guest Registry')



@section('content')

    <style>
        .summary-content-sec.invoice-sec {

            max-width: 980px;

            margin: 0 auto;

        }



        .summary-content-sec.invoice-sec .sec-head {

            background-color: #348a96;

        }

        .summary-content-sec.invoice-sec .detail-outer-box {
            border-radius: 24px;
        }

        .summary-content-sec.invoice-sec .booking-details .sec-head {

            border-radius: 24px 24px 0 0;

        }


        .summary-content-sec.invoice-sec .sec-head h3 svg {
            padding-right: 5px;
        }

        .summary-content-sec.invoice-sec .detail-outer-box svg path {

            fill: #ffffff;

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



    <div class="col right-side">



        <section class="summary-content-sec invoice-sec">

            <div class="container">

                <div class="row">

                    <div class="col-12">

                        <div class="main-head py-3 text-center position-relative">

                            <h2 class="fw-bold fs-4 mb-0">Order Detail</h2>
                            <a href="javascript:void(0);" onclick="history.back()" class="back-btn"><i
                                    class="fa-solid fa-arrow-left"></i> Back</a>

                        </div>

                        <div class="detail-outer-box border">

                            <div class="booking-details border-bottom">

                                <div class="sec-head px-4 py-3">

                                    <h3 class="text-white fw-bold fs-6 mb-0"><i class="fa-solid fa-calendar-day"></i>

                                        Booking Details</h3>

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

                            <div class="guest-details border-bottom">

                                <div class="sec-head px-4 py-3">

                                    <h3 class="text-white fw-bold fs-6 mb-0"><i class="fa-solid fa-user-group"></i>

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

                            @php

                                $experiences = json_decode($order->experiences_selected);

                            @endphp

                            <div class="exp-update border-bottom">

                                <div class="sec-head px-4 py-3">

                                    <h3 class="text-white fw-bold fs-6 mb-0"><i
                                            class="fa-solid fa-pen-to-square"></i>Curated Experience</h3>

                                </div>

                                <div class="px-4 py-3">

                                    <div class="row gx-5 gy-2">

                                        @foreach ($experiences as $experience)
                                            <div class="col-12">

                                                <div class="d-flex align-items-center justify-content-between">

                                                    <p class="info-label mb-0 fw-bold">{{ $experience->name }}</p>

                                                    <p class="mb-0">Upgrade Fee: ${{ $experience->value }}</p>

                                                </div>

                                            </div>
                                        @endforeach

                                    </div>

                                </div>

                            </div>

                            <div class="sundry-charges border-bottom">

                                <div class="sec-head px-4 py-3">

                                    <h3 class="text-white fw-bold fs-6 mb-0"><i class="fa-solid fa-file-invoice-dollar"></i>

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

                                            <div class="d-flex align-items-center justify-content-between mb-2">

                                                <p class="info-label mb-0 fw-bold">Pet Boarding</p>

                                                <p class="mb-0">${{ $order->pet_fee }}</p>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="refund-policies">

                                <div class="sec-head px-4 py-3">

                                    <h4 class="text-white fw-bold fs-6 mb-0"><i class="fa-solid fa-file-shield"></i>

                                        Refund Policy</h4>

                                </div>

                                <div class="px-4 py-3">

                                    @if ($vendor->policy != '')

                                        <ul class="">

                                            <li class="mb-0">

                                                @if ($vendor->policy == 'partial')
                                                    A full refund minus transaction fees will be issued upon request

                                                    up to 7 days

                                                    prior to the check-in date indicated. No refund will be issued

                                                    for cancellations

                                                    that fall within that 7-day period prior to the check-in date. A

                                                    credit or rain

                                                    cheque may be issued to guests at the vendor’s discretion.
                                                @elseif($vendor->policy == 'open')
                                                    A full refund minus transaction fees will be issued upon request

                                                    up to 24 hours

                                                    prior to the check-in date indicated.
                                                @elseif($vendor->policy == 'closed')
                                                    All bookings are final. No portion of your transaction will be

                                                    refunded. A

                                                    credit or rain cheque may be issued by the subject vendor at the

                                                    vendor’s

                                                    discretion.
                                                @endif

                                            </li>

                                        </ul>

                                    @endif

                                </div>

                            </div>

                            <div class="total-cost">

                                <div class="sec-head px-4 py-3">

                                    <h3 class="text-white fw-bold fs-6 mb-0"><i class="fa-solid fa-sack-dollar"></i>

                                        Totals</h3>

                                </div>

                                <div class="px-4 py-3">

                                    @php

                                        $sub_total =
                                            $order->rate_basic * $order->nights_count +
                                            $order->experiences_total +
                                            $order->cleaning_fee +
                                            $order->security_deposit +
                                            $order->pet_fee - $order->wallet_used;

                                        $tax = ($sub_total * $order->tax_rate) / 100;

                                    @endphp

                                    <div class="d-flex align-items-center justify-content-between mb-2">

                                        <p class="fw-bold mb-0">Sub-Totals:</p>

                                        <p class="fw-bold mb-0">${{ number_format($sub_total, 2, '.', '') }}</p>

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

                                        <p class="fw-bold mb-0 fs-5">Total:</p>

                                        <p class="fw-bold mb-0 fs-5">

                                            ${{ number_format($sub_total + $tax, 2, '.', '') }}</p>

                                    </div>

                                    <div class="d-flex align-items-center justify-content-between payment-status">

                                        <p class="fw-bold mb-0 fs-6">Payment Status</p>

                                        <p class="fw-bold mb-0 fs-6">Approved</p>

                                    </div>

                                </div>

                            </div>

                            <div class="refund-policies">

                                <div class="sec-head px-4 py-3">

                                    <h4 class="text-white fw-bold fs-6 mb-0"><i class="fa-solid fa-file-shield"></i>

                                        Order Transactions</h4>

                                </div>

                                <div class="table-responsive">

                                    <table class="table table-bordered">

                                        <thead></thead>

                                        <tr>

                                            <th>Transaction ID</th>

                                            <th>Transaction Date</th>

                                            <th>Transaction Amount</th>

                                        </tr>

                                        </thead>

                                        <tbody>

                                            @if (count($order->orderTransactions) > 0)

                                                @foreach ($order->orderTransactions as $key => $orderTransaction)
                                                    <tr>

                                                        <td>{{ $orderTransaction->transaction_id }}</td>

                                                        <td>{{ date('m/d/Y', strtotime($orderTransaction->created_at)) }}
                                                        </td>

                                                        <td>${{ number_format($orderTransaction->transaction_amount, 2, '.', '') }}
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>

                                                    <td colspan="3" class="text-center">No Transactions Found</td>

                                                </tr>

                                            @endif

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>





    </div>

@endsection



@section('js')

@endsection
