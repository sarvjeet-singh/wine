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

                                    <h2 class="fw-bold fs-4 mb-0" style="color: #c0a144;">Inquiry Detail</h2>
                                    <a href="javascript:void(0)" onclick="history.back()" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back</a>

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

                                                                {{ date('jS M Y', strtotime($inquiry->check_in_at)) }}</p>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Check-Out Date/Time</p>

                                                            <p class="mb-0">

                                                                {{ date('jS M Y', strtotime($inquiry->check_out_at)) }}</p>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Number of Nights</p>

                                                            <p class="mb-0">{{ $inquiry->nights_count }}</p>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Number in Travel Party</p>

                                                            <p class="mb-0">{{ $inquiry->travel_party_size }}</p>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Nature of Visit</p>

                                                            <p class="mb-0">{{ $inquiry->visit_purpose }}</p>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Base Rate</p>

                                                            <p class="mb-0">${{ $inquiry->rate_basic }}/Night</p>

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

                                                            <p class="mb-0">{{ $inquiry->guest_name }}</p>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div class="d-flex align-items-center justify-content-between">

                                                            <p class="info-label mb-0 fw-bold">Guest Email</p>

                                                            <p class="mb-0">{{ $inquiry->guest_email }}</p>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    @php

                                        $experiences = json_decode($inquiry->experiences_selected);

                                    @endphp
                                    @if (count($experiences) > 0)
                                        <div class="information-box mb-3">
                                            <div class="exp-update">

                                                <div class="sec-head border-bottom px-4 py-3">

                                                    <h3 class="fw-bold mb-0"><i
                                                            class="fa-solid fa-pen-to-square"></i>Curated
                                                        Experience</h3>

                                                </div>

                                                <div class="px-4 py-3">

                                                    <div class="row gx-5 gy-2">

                                                        @foreach ($experiences as $experience)
                                                            <div class="col-12">

                                                                <div
                                                                    class="d-flex align-items-center justify-content-between">

                                                                    <p class="info-label mb-0 fw-bold">
                                                                        {{ $experience->name }}
                                                                    </p>

                                                                    <p class="mb-0">Upgrade Fee:
                                                                        ${{ $experience->value }}
                                                                    </p>

                                                                </div>

                                                            </div>
                                                        @endforeach

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    @endif
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

                                                            <p class="mb-0">${{ $inquiry->cleaning_fee }}</p>

                                                        </div>

                                                    </div>

                                                    {{-- <div class="col-md-6">

                                                        <div class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Transaction Tax</p>

                                                            <p class="mb-0">{{ $inquiry->tax_rate }}%</p>

                                                        </div>

                                                    </div> --}}

                                                    <div class="col-md-6">

                                                        <div class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Security Deposit</p>

                                                            <p class="mb-0">${{ $inquiry->security_deposit }}</p>

                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">

                                                        <div
                                                            class="d-flex align-items-center justify-content-between mb-2">

                                                            <p class="info-label mb-0 fw-bold">Pet Boarding</p>

                                                            <p class="mb-0">${{ $inquiry->pet_fee }}</p>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="information-box">
                                        <div class="total-cost">

                                            <div class="sec-head border-bottom px-4 py-3">

                                                <h3 class="fw-bold mb-0"><i class="fa-solid fa-sack-dollar"></i> Totals
                                                </h3>

                                            </div>

                                            <div class="px-4 py-3">

                                                @php

                                                    $sub_total =
                                                        $inquiry->rate_basic * $inquiry->nights_count +
                                                        $inquiry->experiences_total +
                                                        $inquiry->cleaning_fee +
                                                        $inquiry->security_deposit +
                                                        $inquiry->pet_fee;

                                                    $tax = ($sub_total * $inquiry->tax_rate) / 100;

                                                @endphp

                                                <div class="d-flex align-items-center justify-content-between mb-2">

                                                    <p class="fw-bold mb-0">Sub-Totals:</p>

                                                    <p class="fw-bold mb-0">${{ number_format($sub_total, 2, '.', '') }}
                                                    </p>

                                                </div>

                                                <div class="d-flex align-items-center justify-content-between mb-2">

                                                    <p class="fw-bold mb-0">Taxes:
                                                    </p>

                                                    <p class="fw-bold mb-0">${{ number_format($tax, 2, '.', '') }}</p>

                                                </div>

                                                <div class="d-flex align-items-center justify-content-between mb-2">

                                                    <p class="fw-bold mb-0 fs-5" style="color: #c0a144;">Total:</p>

                                                    <p class="fw-bold mb-0 fs-5" style="color: #c0a144;">

                                                        ${{ number_format($sub_total + $tax, 2, '.', '') }}</p>

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

    @include('UserDashboard.includes.logout_modal')

@endsection



@section('js')

@endsection
