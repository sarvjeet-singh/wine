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

                                                <p class="info-label mb-0 fw-bold">Vendor Name</p>

                                                <p class="mb-0">{{ $order->vendor->vendor_name ?? '' }}</p>

                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="d-flex align-items-center justify-content-between mb-2">

                                                <p class="info-label mb-0 fw-bold">Event Name</p>

                                                <p class="mb-0">{{ $order->eventOrderDetail->name ?? '' }}</p>

                                            </div>

                                        </div>

                                        <div class="col-md-6">

                                            <div class="d-flex align-items-center justify-content-between mb-2">

                                                <p class="info-label mb-0 fw-bold">Sub-Region</p>

                                                <p class="mb-0">{{ $order->vendor->sub_regions->name ?? '' }}</p>

                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="info-label mb-0 fw-bold">Full Name</p>
                                                <p class="mb-0">
                                                    {{ $order->eventOrderDetail->full_name ?? '' }}</p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="info-label mb-0 fw-bold">Email</p>
                                                <p class="mb-0">{{ $order->eventOrderDetail->email ?? '' }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="info-label mb-0 fw-bold">Contact Number</p>
                                                <p class="mb-0">
                                                    {{ $order->eventOrderDetail->contact_number ?? '' }}</p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="info-label mb-0 fw-bold">Street Address</p>
                                                <p class="mb-0">
                                                    {{ $order->eventOrderDetail->street_address ?? '' }}</p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="info-label mb-0 fw-bold">Unit/Suite</p>
                                                <p class="mb-0">
                                                    {{ $order->eventOrderDetail->unit_suite ?? '' }}</p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="info-label mb-0 fw-bold">City</p>
                                                <p class="mb-0">{{ $order->eventOrderDetail->city ?? '' }}</p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="info-label mb-0 fw-bold">State</p>
                                                <p class="mb-0">{{ $order->eventOrderDetail->state ?? '' }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="info-label mb-0 fw-bold">Country</p>
                                                <p class="mb-0">{{ $order->eventOrderDetail->country ?? '' }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="info-label mb-0 fw-bold">Postal Code</p>
                                                <p class="mb-0">
                                                    {{ $order->eventOrderDetail->postal_code ?? '' }}</p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="info-label mb-0 fw-bold">Start Date</p>
                                                <p class="mb-0">
                                                    {{ date('jS M Y', strtotime($order->eventOrderDetail->start_date)) }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <p class="info-label mb-0 fw-bold">End Date</p>
                                                <p class="mb-0">
                                                    {{ date('jS M Y', strtotime($order->eventOrderDetail->end_date)) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="d-flex align-items-center justify-content-between mb-2">

                                                <p class="info-label mb-0 fw-bold">Base Rate</p>

                                                <p class="mb-0">${{ $order->listed_price }}</p>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            @if (count($order->eventGuestDetails) > 0)
                                @foreach ($order->eventGuestDetails as $index => $guest)
                                    <div class="guest-details border-bottom">

                                        <div class="sec-head px-4 py-3">

                                            <h3 class="text-white fw-bold fs-6 mb-0"><i class="fa-solid fa-user-group"></i>

                                                Guest Details</h3>

                                        </div>

                                        <div class="px-4 py-3">

                                            <div class="row gx-5 gy-2 mb-3 border-bottom pb-2">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="info-label mb-0 fw-bold">First Name</p>
                                                        <p class="mb-0">{{ $guest->first_name ?? '-' }}</p>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                                        <p class="info-label mb-0 fw-bold">Last Name</p>
                                                        <p class="mb-0">{{ $guest->last_name ?? '-' }}</p>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <p class="info-label mb-0 fw-bold">Email</p>
                                                        <p class="mb-0">{{ $guest->email ?? '-' }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                @endforeach
                            @endif

                            <div class="refund-policies">

                                <div class="sec-head px-4 py-3">

                                    <h4 class="text-white fw-bold fs-6 mb-0"><i class="fa-solid fa-file-shield"></i>

                                        Refund Policy</h4>

                                </div>

                                <div class="px-4 py-3">

                                    @if ($order->vendor->policy != '')
                                        {!! refundContent($order->vendor->policy) !!}
                                    @endif

                                </div>

                            </div>

                            <div class="total-cost">

                                <div class="sec-head px-4 py-3">

                                    <h3 class="text-white fw-bold fs-6 mb-0"><i class="fa-solid fa-sack-dollar"></i>

                                        Totals</h3>

                                </div>

                                <div class="px-4 py-3">           

                                    <div class="d-flex align-items-center justify-content-between mb-2">

                                        <p class="fw-bold mb-0">Sub-Totals:</p>

                                        <p class="fw-bold mb-0">${{ number_format($order->sub_total, 2, '.', '') }}</p>

                                    </div>
                                    @if ($order->wallet_used != 0)
                                        <div class="d-flex align-items-center justify-content-between mb-2">

                                            <p class="fw-bold mb-0">Bottle Bucks Used:</p>

                                            <p class="fw-bold mb-0">
                                                ${{ number_format($order->wallet_amount, 2, '.', '') }}</p>

                                        </div>
                                    @endif
                                    <div class="d-flex align-items-center justify-content-between mb-2">

                                        <p class="fw-bold mb-0">Taxes:</p>

                                        <p class="fw-bold mb-0">${{ number_format($order->tax, 2, '.', '') }}</p>

                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mb-2">

                                        <p class="fw-bold mb-0 fs-5">Total:</p>

                                        <p class="fw-bold mb-0 fs-5">

                                            ${{ number_format($order->total, 2, '.', '') }}</p>

                                    </div>

                                    <div class="d-flex align-items-center justify-content-between payment-status">

                                        <p class="fw-bold mb-0 fs-6">Payment Status</p>

                                        <p class="fw-bold mb-0 fs-6">{{ ucfirst($order->payment_status) }}</p>

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

                                            @if (count($order->eventOrderTransactions) > 0)

                                                @foreach ($order->eventOrderTransactions as $key => $orderTransaction)
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
@endsection

{{-- @section('js')
    <script>
        $(document).ready(function() {
            $("#cancelOrderForm").submit(function(e) {
                e.preventDefault(); // Prevent default form submission

                let orderId = $("#order_id").val();
                let cancelReason = $("#cancel_reason").val();
                let url =
                    "{{ route('orders.vendor-cancel', $vendor->id) }}"; // Ensure this matches your route

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
@endsection --}}
