@extends('VendorDashboard.layouts.vendorapp')







@section('title', 'Wine Country Weekends - Winery Shop')







@section('content')

    <div class="col right-side">

        <div class="row">

            <div class="col-sm-12">

                <div class="information-box p-0">

                    <div class="information-box-head d-flex align-items-center gap-3">
                        <button class="btn back-btn d-flex align-items-center p-0" onclick="window.history.back()">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                        <div class="box-head-heading">
                            <span class="box-head-label theme-color">Wine Order Detail</span>
                        </div>

                    </div>

                    <div class="information-box-body pt-4">

                        <div class="bg-white p-3 rounded pb-4 mb-4">

                            <div class="sec-head mb-3">

                                <h3 class="theme-color fw-bold mb-0" style="font-size: 18px;"><i

                                        class="fa-solid fa-calendar-day pe-2"></i> Vendor Details</h3>

                            </div>

                            <div class="row gx-5 gy-3">

                                <div class="col-md-6">

                                    <div class="d-flex align-items-center justify-content-between">

                                        <p class="info-label mb-0 fw-bold">Vendor Name</p>

                                        <p class="mb-0 text-end">{{ $order->vendorBuyer->vendor_name }}</p>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="d-flex align-items-center justify-content-between">

                                        <p class="info-label mb-0 fw-bold">Vendor Contact Name </p>

                                        <p class="mb-0 text-end">

                                            {{ $order->vendorBuyer->user->first_name . ' ' . $order->vendorBuyer->user->last_name }}

                                        </p>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="d-flex align-items-center justify-content-between">

                                        <p class="info-label mb-0 fw-bold">Vendor Contact Number</p>

                                        <p class="mb-0 text-end">{{ $order->vendorBuyer->vendor_phone }}</p>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="d-flex align-items-center justify-content-between">

                                        <p class="info-label mb-0 fw-bold">Vendor Email Address</p>

                                        <p class="mb-0 text-end">{{ $order->vendorBuyer->vendor_email }}</p>

                                    </div>

                                </div>

                            </div>

                        </div>

                        @if ($order->delivery == 1)

                            <div class="bg-white p-3 rounded pb-4 mb-4">

                                <div class="sec-head mb-3">

                                    <h3 class="theme-color fw-bold mb-0" style="font-size: 18px;"><i

                                            class="fa-solid fa-location-dot pe-2"></i> Shipping Address</h3>

                                </div>

                                <div class="row gx-5 gy-3">

                                    <div class="col-md-6">

                                        <div class="d-flex align-items-center justify-content-between">

                                            <p class="info-label mb-0 fw-bold">First Name</p>

                                            <p class="mb-0 text-end">{{ $order->shipping_first_name }}</p>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="d-flex align-items-center justify-content-between">

                                            <p class="info-label mb-0 fw-bold">Last Name</p>

                                            <p class="mb-0 text-end">{{ $order->shipping_last_name }}</p>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="d-flex align-items-center justify-content-between">

                                            <p class="info-label mb-0 fw-bold">Phone</p>

                                            <p class="mb-0 text-end">{{ $order->shipping_phone }}</p>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="d-flex align-items-center justify-content-between">

                                            <p class="info-label mb-0 fw-bold">Email Address</p>

                                            <p class="mb-0">{{ $order->shipping_email }}</p>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="d-flex align-items-center justify-content-between">

                                            <p class="info-label mb-0 fw-bold">Street Address</p>

                                            <p class="mb-0 text-end">{{ $order->shipping_street }}</p>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="d-flex align-items-center justify-content-between">

                                            <p class="info-label mb-0 fw-bold">City/Town</p>

                                            <p class="mb-0 text-end">{{ $order->shipping_city }}</p>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="d-flex align-items-center justify-content-between">

                                            <p class="info-label mb-0 fw-bold">Unit/Suite#</p>

                                            <p class="mb-0 text-end">{{ $order->shipping_unit }}</p>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="d-flex align-items-center justify-content-between">

                                            <p class="info-label mb-0 fw-bold">Provience/State</p>

                                            <p class="mb-0 text-end">{{ $order->shipping_state }}</p>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="d-flex align-items-center justify-content-between">

                                            <p class="info-label mb-0 fw-bold">Postal/Zip</p>

                                            <p class="mb-0 text-end">{{ $order->shipping_postal_code }}</p>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="d-flex align-items-center justify-content-between">

                                            <p class="info-label mb-0 fw-bold">Country</p>

                                            <p class="mb-0 text-end">{{ $order->shipping_country }}</p>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @endif

                        <div class="bg-white p-3 rounded pb-4 mb-4">

                            <div class="row gx-5 gy-3">

                                <div class="sec-head mb-3">

                                    <h3 class="theme-color fw-bold mb-0" style="font-size: 18px;"><i

                                            class="fa-solid fa-location-dot pe-2"></i> Billing Address</h3>

                                </div>

                                <div class="col-md-6">

                                    <div class="d-flex align-items-center justify-content-between">

                                        <p class="info-label mb-0 fw-bold">First Name</p>

                                        <p class="mb-0 text-end">{{ $order->billing_first_name }}</p>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="d-flex align-items-center justify-content-between">

                                        <p class="info-label mb-0 fw-bold">Last Name</p>

                                        <p class="mb-0 text-end">{{ $order->billing_last_name }}</p>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="d-flex align-items-center justify-content-between">

                                        <p class="info-label mb-0 fw-bold">Phone</p>

                                        <p class="mb-0 text-end">{{ $order->billing_phone }}</p>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="d-flex align-items-center justify-content-between">

                                        <p class="info-label mb-0 fw-bold">Email Address</p>

                                        <p class="mb-0">{{ $order->billing_email }}</p>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="d-flex align-items-center justify-content-between">

                                        <p class="info-label mb-0 fw-bold">Street Address</p>

                                        <p class="mb-0 text-end">{{ $order->billing_street }}</p>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="d-flex align-items-center justify-content-between">

                                        <p class="info-label mb-0 fw-bold">City/Town</p>

                                        <p class="mb-0 text-end">{{ $order->billing_city }}</p>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="d-flex align-items-center justify-content-between">

                                        <p class="info-label mb-0 fw-bold">Unit/Suite#</p>

                                        <p class="mb-0 text-end">{{ $order->billing_unit }}</p>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="d-flex align-items-center justify-content-between">

                                        <p class="info-label mb-0 fw-bold">Provience/State</p>

                                        <p class="mb-0 text-end">{{ $order->billing_state }}</p>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="d-flex align-items-center justify-content-between">

                                        <p class="info-label mb-0 fw-bold">Postal/Zip</p>

                                        <p class="mb-0 text-end">{{ $order->billing_postal_code }}</p>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="d-flex align-items-center justify-content-between">

                                        <p class="info-label mb-0 fw-bold">Country</p>

                                        <p class="mb-0 text-end">{{ $order->billing_country }}</p>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="bg-white rounded p-4 mb-4">

                            <div class="sec-head mb-3">

                                <h3 class="theme-color fw-bold mb-0" style="font-size: 18px;"><i

                                        class="fa-solid fa-wine-bottle pe-2"></i> Wine Details</h3>

                            </div>

                            <table class="table table-striped">

                                <thead>

                                    <tr>

                                        <th>Wine Name</th>

                                        <th class="text-center">Quantity</th>

                                        <th class="text-end">Unit Price</th>

                                        <th class="text-end">Wine Total</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($order->wines as $wine)

                                        <tr>

                                            <td>{{ $wine->wine_name }}</td>

                                            <td class="text-center">{{ $wine->quantity }}</td>

                                            <td class="text-end">${{ number_format($wine->price, 2) }}</td>

                                            <td class="text-end">${{ number_format($wine->price * $wine->quantity, 2) }}

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                        <div class="bg-white rounded p-4">

                            <div class="sec-head mb-3">

                                <h3 class="theme-color fw-bold mb-0" style="font-size: 18px;"><i

                                        class="fa-solid fa-sack-dollar pe-2"></i> Total</h3>

                            </div>

                            <div>

                                <div class="d-flex align-items-center justify-content-between mb-2">

                                    <p class="fw-bold mb-0">Sub Total Price </p>

                                    <p class="fw-bold mb-0">${{ $order->subtotal_price }}</p>

                                </div>

                                @if ($order->delivery == 1)

                                    <div class="d-flex align-items-center justify-content-between mb-2">

                                        <p class="fw-bold mb-0">Delivery Charges</p>

                                        <p class="fw-bold mb-0">${{ $order->delivery_charges }}</p>

                                    </div>

                                @endif

                                <div class="d-flex align-items-center justify-content-between mb-2">

                                    <p class="fw-bold mb-0">Total Price</p>

                                    <p class="fw-bold mb-0">${{ $order->total_price }}</p>

                                </div>

                            </div>

                        </div>

                        <div class="bg-white rounded p-4">

                            <div class="sec-head mb-3">

                                <h3 class="theme-color fw-bold mb-0" style="font-size: 18px;"><i

                                        class="fa-solid fa-sack-dollar pe-2"></i> Transaction Details</h3>

                            </div>

                            <div>

                                <div class="d-flex align-items-center justify-content-between mb-2">

                                    <p class="fw-bold mb-0">Transaction No.</p>

                                    <p class="fw-bold mb-0">

                                        {{ !empty($order->transaction->transaction_id) ? $order->transaction->transaction_id : null }}

                                    </p>

                                </div>

                            </div>

                        </div>

                        @if ($order->delivery == 1)

                            <div class="bg-white rounded p-4 mt-4">

                                <div class="sec-head mb-3">

                                    <h3 class="theme-color fw-bold mb-0" style="font-size: 18px;">

                                        <i class="fa-solid fa-truck pe-2"></i> Delivery Status

                                    </h3>

                                </div>

                                <div>

                                    <div class="d-flex align-items-center justify-content-between">

                                        <p class="fw-bold mb-0">Current Status</p>

                                        <select @if ($order->status == 'completed') disabled @endif class="update-status form-select" data-id="{{ $order->id }}"

                                            style="width: auto;">

                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>

                                                Pending</option>

                                            <option value="in_progress"

                                                {{ $order->status == 'in_progress' ? 'selected' : '' }}>In Progress

                                            </option>

                                            <option value="completed"

                                                {{ $order->status == 'completed' ? 'selected' : '' }}>

                                                Completed</option>

                                        </select>

                                    </div>

                                </div>

                            </div>

                        @else

                            <div class="bg-white rounded p-4 mt-4">

                                <div class="sec-head mb-3">

                                    <h3 class="theme-color fw-bold mb-0" style="font-size: 18px;">

                                        <i class="fa-solid fa-truck pe-2"></i> Pickup Status

                                    </h3>

                                </div>

                                <div>

                                    <div class="d-flex align-items-center justify-content-between">

                                        <p class="fw-bold mb-0">Current Status</p>

                                        <select class="update-status form-select" data-id="{{ $order->id }}"

                                            style="width: auto;">

                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>

                                                Pending</option>

                                            <option value="in_progress"

                                                {{ $order->status == 'in_progress' ? 'selected' : '' }}>In Progress

                                            </option>

                                            <option value="completed"

                                                {{ $order->status == 'completed' ? 'selected' : '' }}>

                                                Completed</option>

                                        </select>

                                    </div>

                                </div>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection



@section('js')

    <script>

        $(document).ready(function() {

            $('.update-status').on('change', function() {

                let orderId = $(this).data('id');

                let status = $(this).val();



                // Confirmation dialog before proceeding with the AJAX request

                Swal.fire({

                    title: 'Are you sure?',

                    text: 'Do you want to change the status to ' + status + '?',

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonColor: '#3085d6',

                    cancelButtonColor: '#d33',

                    confirmButtonText: 'Yes, change it!'

                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({

                            url: '{{ route('winery.shop.order.update-status', ['orderid' => $order->id, 'vendorid' => $vendorid]) }}',

                            type: 'POST',

                            data: {

                                _token: '{{ csrf_token() }}',

                                status: status

                            },

                            success: function(response) {

                                if (response.success) {

                                    Swal.fire({

                                        icon: 'success',

                                        title: 'Status Updated!',

                                        text: response.message,

                                        timer: 2000,

                                        showConfirmButton: false

                                    });

                                } else {

                                    Swal.fire({

                                        icon: 'error',

                                        title: 'Update Failed',

                                        text: 'Unable to update delivery status.'

                                    });

                                }

                            },

                            error: function(xhr, status, error) {

                                Swal.fire({

                                    icon: 'error',

                                    title: 'Update Failed',

                                    text: 'An error occurred while updating the delivery status.'

                                });

                            }

                        });

                    } else {

                        // Revert the dropdown selection if the user cancels

                        $(this).val($(this).data('current-status'));

                    }

                });

            });

        });

    </script>

@endsection

