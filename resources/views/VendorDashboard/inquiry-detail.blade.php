@extends('VendorDashboard.layouts.vendorapp')



@section('title', 'Wine Country Weekends - Guest Registry')



@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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

                            <h2 class="fw-bold fs-4 mb-0">Inquiry Detail</h2>
                            <a href="javascript:void(0);" onclick="history.back();" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back</a>

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

                            <div class="guest-details border-bottom">

                                <div class="sec-head px-4 py-3">

                                    <h3 class="text-white fw-bold fs-6 mb-0"><i class="fa-solid fa-user-group"></i>

                                        Guest Details</h3>

                                </div>

                                <div class="px-4 py-3">

                                    <div class="row gx-5 gy-2">

                                        {{-- Guest Name --}}
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="info-label mb-0 fw-bold">Guest Name</p>
                                                <p class="mb-0">{{ $inquiry->name }}</p>
                                            </div>
                                        </div>

                                        {{-- Guest Email --}}
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="info-label mb-0 fw-bold">Guest Email</p>
                                                <p class="mb-0">{{ $inquiry->email }}</p>
                                            </div>
                                        </div>
                                        {{-- Contact Information --}}
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="info-label mb-0 fw-bold">Contact Number</p>
                                                <p class="mb-0">{{ $inquiry->phone }}</p>
                                            </div>
                                        </div>

                                        {{-- Address --}}
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="info-label mb-0 fw-bold">Street Address</p>
                                                <p class="mb-0">{{ $inquiry->street_address }}</p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="info-label mb-0 fw-bold">Suite</p>
                                                <p class="mb-0">{{ $inquiry->suite ?? 'N/A' }}</p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="info-label mb-0 fw-bold">City</p>
                                                <p class="mb-0">{{ $inquiry->city }}</p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="info-label mb-0 fw-bold">State</p>
                                                <p class="mb-0">{{ $inquiry->state }}</p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="info-label mb-0 fw-bold">Country</p>
                                                <p class="mb-0">{{ $inquiry->country }}</p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <p class="info-label mb-0 fw-bold">Postal Code</p>
                                                <p class="mb-0">{{ $inquiry->postal_code }}</p>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            @php

                                $experiences = json_decode($inquiry->experiences_selected);

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

                                            <div class="d-flex align-items-center justify-content-between mb-2">

                                                <p class="info-label mb-0 fw-bold">Pet Boarding</p>

                                                <p class="mb-0">${{ $inquiry->pet_fee }}</p>

                                            </div>

                                        </div>

                                    </div>

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
                                            $inquiry->rate_basic * $inquiry->nights_count +
                                            $inquiry->experiences_total +
                                            $inquiry->cleaning_fee +
                                            $inquiry->security_deposit +
                                            $inquiry->pet_fee;

                                        $tax = ($sub_total * $inquiry->tax_rate) / 100;

                                    @endphp

                                    <div class="d-flex align-items-center justify-content-between mb-2">

                                        <p class="fw-bold mb-0">Sub-Totals:</p>

                                        <p class="fw-bold mb-0">${{ number_format($sub_total, 2, '.', '') }}</p>

                                    </div>

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

                                        <p class="fw-bold mb-0 fs-6">Update Inquiry Status</p>
                                        @if ($inquiry->inquiry_status == 0)
                                            <p class="fw-bold mb-0 fs-6">
                                                <button id="approve-inquiry" type="button"
                                                    class="btn btn-success">Approve</button>
                                                <button id="reject-inquiry" type="button"
                                                    class="btn btn-danger">Reject</button>
                                            </p>
                                        @elseif($inquiry->inquiry_status == 1)
                                            <p class="fw-bold text-success mb-0 fs-6">Approved</p>
                                        @elseif($inquiry->inquiry_status == 2)
                                            <p class="fw-bold text-danger mb-0 fs-6">Rejected</p>
                                        @elseif($inquiry->inquiry_status == 3)
                                            <p class="fw-bold text-primary mb-0 fs-6">Paid</p>
                                        @endif
                                    </div>

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Approve inquiry
            $("#approve-inquiry").on("click", function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to approve this inquiry?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, approve it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let approveButton = $(this);
                        approveButton.prop('disabled', true); // Disable button
                        approveButton.html(
                        '<i class="fas fa-spinner fa-spin"></i> Approving...'); // Add spinner to button

                        $.ajax({
                            url: "{{ route('inquiry.approve', ['id' => $inquiry->id, 'vendorid' => $inquiry->vendor_id]) }}",
                            type: 'PUT',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Approved!',
                                        'The inquiry has been approved.',
                                        'success'
                                    );
                                    setTimeout(() => location.reload(),
                                    1500); // Reload after delay
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Error: ' + response.error,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr) {
                                console.error('Error:', xhr);
                                Swal.fire(
                                    'Error!',
                                    'An error occurred while approving the inquiry.',
                                    'error'
                                );
                            },
                            complete: function() {
                                approveButton.prop('disabled',
                                false); // Enable button again
                                approveButton.html('Approve'); // Reset button text
                            }
                        });
                    }
                });
            });

            // Reject inquiry
            $("#reject-inquiry").on("click", function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you want to reject this inquiry?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, reject it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let rejectButton = $(this);
                        rejectButton.prop('disabled', true); // Disable button
                        rejectButton.html(
                        '<i class="fas fa-spinner fa-spin"></i> Rejecting...'); // Add spinner to button

                        $.ajax({
                            url: "{{ route('inquiry.reject', ['id' => $inquiry->id, 'vendorid' => $inquiry->vendor_id]) }}",
                            type: 'PUT',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire(
                                        'Rejected!',
                                        'The inquiry has been rejected.',
                                        'success'
                                    );
                                    setTimeout(() => location.reload(),
                                    1500); // Reload after delay
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Error: ' + response.error,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr) {
                                console.error('Error:', xhr);
                                Swal.fire(
                                    'Error!',
                                    'An error occurred while rejecting the inquiry.',
                                    'error'
                                );
                            },
                            complete: function() {
                                rejectButton.prop('disabled',
                                false); // Enable button again
                                rejectButton.html('Reject'); // Reset button text
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
