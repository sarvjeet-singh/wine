@extends('FrontEnd.layouts.mainapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')
    <style>
        .rcrop-outer-wrapper {
            opacity: .75;
        }

        .rcrop-outer {
            background: #000
        }

        .rcrop-croparea-inner {
            border: 1px dashed #fff;
        }

        .rcrop-handler-corner {
            width: 12px;
            height: 12px;
            background: none;
            border: 0 solid #51aeff;
        }

        .rcrop-handler-top-left {
            border-top-width: 4px;
            border-left-width: 4px;
            top: -2px;
            left: -2px
        }

        .rcrop-handler-top-right {
            border-top-width: 4px;
            border-right-width: 4px;
            top: -2px;
            right: -2px
        }

        .rcrop-handler-bottom-right {
            border-bottom-width: 4px;
            border-right-width: 4px;
            bottom: -2px;
            right: -2px
        }

        .rcrop-handler-bottom-left {
            border-bottom-width: 4px;
            border-left-width: 4px;
            bottom: -2px;
            left: -2px
        }

        .rcrop-handler-border {
            display: none;
        }

        .error {
            color: #dc3545;
        }
    </style>
    <div class="container main-container">
        <div class="row flex-lg-nowrap flex-wrap g-4">
            @include('UserDashboard.includes.leftNav')
            <div class="col right-side">

                <section class="summary-content-sec invoice-sec my-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="main-head py-3 text-center">
                                    <h2 class="fw-bold">Order Detail</h2>
                                </div>
                                <div class="detail-outer-box border">
                                    <div class="booking-details border-bottom">
                                        <div class="sec-head px-4 py-3">
                                            <h3 class="text-white fw-bold fs-6 mb-0"><i
                                                    class="fa-solid fa-calendar-day"></i> Booking Details</h3>
                                        </div>
                                        <div class="px-4 py-3">
                                            <div class="row gx-5 gy-2">
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="info-label mb-0 fw-bold">Property Name</p>
                                                        <p class="mb-0">The Taj Resort</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="info-label mb-0 fw-bold">Sub-Region</p>
                                                        <p class="mb-0">Vacation Property</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="info-label mb-0 fw-bold">Phone Number</p>
                                                        <p class="mb-0">987-456-3210</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="info-label mb-0 fw-bold">Check-In Date/Time</p>
                                                        <p class="mb-0">24 Sep 2024</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="info-label mb-0 fw-bold">Check-Out Date/Time</p>
                                                        <p class="mb-0">27 Sep 2024</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="info-label mb-0 fw-bold">Number of Nights</p>
                                                        <p class="mb-0">3</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="info-label mb-0 fw-bold">Number in Travel Party</p>
                                                        <p class="mb-0">2</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="info-label mb-0 fw-bold">Nature of Visit</p>
                                                        <p class="mb-0">Pleasure</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="info-label mb-0 fw-bold">$1216.00</p>
                                                        <p class="mb-0">27 Sep 2024</p>
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
                                                        <p class="mb-0">Lorem Lpsum</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <p class="info-label mb-0 fw-bold">Guest Email</p>
                                                        <p class="mb-0">loremlpsum@gmai.com</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="exp-update border-bottom">
                                        <div class="sec-head px-4 py-3">
                                            <h3 class="text-white fw-bold fs-6 mb-0"><i
                                                    class="fa-solid fa-pen-to-square"></i>Curated Experience</h3>
                                        </div>
                                        <div class="px-4 py-3">
                                            <div class="row gx-5 gy-2">
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <p class="info-label mb-0 fw-bold">Experience 01</p>
                                                        <p class="mb-0">Upgrade Fee: $100.00</p>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <p class="info-label mb-0 fw-bold">Experience 02</p>
                                                        <p class="mb-0">Upgrade Fee: $100.00</p>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <p class="info-label mb-0 fw-bold">Experience 03</p>
                                                        <p class="mb-0">Upgrade Fee: $100.00</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sundry-charges border-bottom">
                                        <div class="sec-head px-4 py-3">
                                            <h3 class="text-white fw-bold fs-6 mb-0"><i
                                                    class="fa-solid fa-file-invoice-dollar"></i> Sundry Charges</h3>
                                        </div>
                                        <div class="px-4 py-3">
                                            <div class="row gx-5 gy-2">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="info-label mb-0 fw-bold">Cleaning Fees</p>
                                                        <p class="mb-0">$99.00</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="info-label mb-0 fw-bold">Transaction Tax</p>
                                                        <p class="mb-0">$99.00</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="info-label mb-0 fw-bold">Security Deposit</p>
                                                        <p class="mb-0">$99.00</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="refund-policies border-bottom">
                                        <div class="sec-head px-4 py-3">
                                            <h4 class="text-white fw-bold fs-6 mb-0"><i
                                                    class="fa-solid fa-file-shield"></i> Refund Policy</h4>
                                        </div>
                                        <div class="px-4 py-3">
                                            <ul class="mb-0">
                                                <li class="">Lorem ipsum dolor sit amet, consectetur adipisicing
                                                    elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="total-cost">
                                        <div class="sec-head px-4 py-3">
                                            <h3 class="text-white fw-bold fs-6 mb-0"><i
                                                    class="fa-solid fa-sack-dollar"></i> Totals</h3>
                                        </div>
                                        <div class="px-4 py-3">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="fw-bold mb-0">Sub-Totals:</p>
                                                <p class="fw-bold mb-0">$1900.00</p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="fw-bold mb-0">Taxes:<span>13%</span></p>
                                                <p class="fw-bold mb-0">$247.00</p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="fw-bold mb-0 fs-5">Total:</p>
                                                <p class="fw-bold mb-0 fs-5">$2147.00</p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between payment-status">
                                                <p class="fw-bold mb-0 fs-6">Payment Status</p>
                                                <p class="fw-bold mb-0 fs-6">Approved</p>
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
