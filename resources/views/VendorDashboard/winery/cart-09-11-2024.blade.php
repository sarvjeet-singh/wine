@extends('VendorDashboard.layouts.vendorapp')
@section('title', 'Wine Country Weekends - Cart')
@section('content')
    <div class="col right-side">

        <div class="row">
            <div class="col-sm-12">
                <div class="mb-3">
                    <button class="btn wine-btn" onclick="window.history.back()">Go Back</button>
                </div>
                <div class="information-box p-0">
                    <div class="information-box-head">
                        <div class="box-head-heading d-flex">
                            <span class="box-head-label theme-color fw-bold">Cart</span>
                        </div>
                    </div>
                    <div class="information-box-body">
                        <div class="cart-sec px-xl-5 py-xl-4 py-2">
                            {{-- ({{ ($cart && $cart->items->count()) ? $cart->items->count() : 0 }}) --}}
                            <h3 class="fs-5 fw-bold mb-3">Your Cart </h3>
                            @if ($cart && $cart->items->count() > 0)
                                <div class="row g-5">
                                    <div class="col-md-8">
                                        <!-- Cart Table Start -->
                                        <div class="table-responsive">
                                            <table width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Item</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th>Item Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $cartTotal = 0;
                                                    @endphp
                                                    @if (!empty($cart))
                                                        @foreach ($cart->items as $item)
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex gap-3">
                                                                        <div class="pro-img">
                                                                            @if ($item->product->image)
                                                                                <img width="100px"
                                                                                    src="{{ asset('storage/' . $item->product->image) }}"
                                                                                    class="img-fluid" alt="Wine Image">
                                                                            @else
                                                                                <img width="100px"
                                                                                    src="{{ asset('images/vendorbydefault.png') }}"
                                                                                    class="img-fluid" alt="Wine Image">
                                                                            @endif
                                                                        </div>
                                                                        <div class="prod-title">
                                                                            <div class="fw-bold">
                                                                                {{ $item->product->series }}
                                                                            </div>
                                                                            <div class="remove-prod">
                                                                                <a href="javascript:void(0);"
                                                                                    data-product-id="{{ $item->product->id }}"
                                                                                    data-vendor-id="{{ $vendorid }}"
                                                                                    data-shop-id="{{ $item->product->vendor_id }}"
                                                                                    class="text-decoration-none theme-color remove-from-cart">
                                                                                    Remove
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="prod-price">
                                                                        ${{ number_format($item->product->price, 2) }}</div>
                                                                </td>
                                                                <td>
                                                                    <select class="form-select update-quantity"
                                                                        data-product-id="{{ $item->product->id }}"
                                                                        data-vendor-id="{{ $vendorid }}"
                                                                        data-shop-id="{{ $item->product->vendor_id }}"
                                                                        aria-label="Select quantity">
                                                                        @for ($i = 1; $i <= $item->product->inventory; $i++)
                                                                            <option value="{{ $i }}"
                                                                                {{ $item->quantity == $i ? 'selected' : '' }}>
                                                                                {{ $i }}
                                                                            </option>
                                                                        @endfor
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    @php
                                                                        $itemTotal =
                                                                            $item->product->price * $item->quantity;
                                                                        $cartTotal += $itemTotal;
                                                                    @endphp
                                                                    <div class="prod-total">
                                                                        ${{ number_format($itemTotal, 2) }}
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Cart Table End -->
                                        <div class="subtotal-cost border-top border-bottom py-3 my-3 text-end">
                                            <p class="mb-0">Subtotal: <strong>${{ number_format($cartTotal, 2) }}</strong>
                                            </p>
                                            </strong></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="cart-box p-4">
                                            @php $total = $cart->items->count() @endphp
                                            <h4>Summary ({{ $total }} {{ $total > 0 ? 'items' : 'item' }})</h4>
                                            <div class="subtotal-count pt-3 mt-3">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span>Total</span>
                                                    <span>${{ number_format($cartTotal, 2) }}</span>
                                                </div>
                                                <div class="checkout-btn mt-4">
                                                    <!-- <button type="button" class="btn wine-btn w-100" data-bs-toggle="modal" data-bs-target="#checkoutModal">Checkout</button> -->
                                                    <a href="{{ route('winery.checkout', ['shopid' => $cart->shop_id, 'vendorid' => $vendorid]) }}"
                                                        class="btn wine-btn w-100">Checkout</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center">
                                    <h3 class="theme-color">Your cart is empty.</h3>
                                    <a href="{{ route('winery-shop.index') }}" class="theme-btn">Shop Now</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script>
        $('.remove-from-cart').click(function() {
            var productId = $(this).data('product-id');
            var vendorId = $(this).data('vendor-id');
            var shopId = $(this).data('shop-id');


            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to remove this item from the cart?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/winery-shop/cart/remove/' + productId + '/' + shopId + '/' +
                            vendorId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: response.message,
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                willClose: () => {
                                    location.reload();
                                }
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Failed to remove item from cart.',
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true
                            });
                        }
                    });
                }
            });
        });
        $('.update-quantity').on("change", function() {
            var productId = $(this).data('product-id');
            var vendorId = $(this).data('vendor-id');
            var shopId = $(this).data('shop-id');
            var quantity = $(this).val();

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to update the quantity for this item?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/winery-shop/cart/update/' + productId + '/' + shopId + '/' +
                            vendorId,
                        type: 'PATCH',
                        data: {
                            quantity: quantity
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: response.message,
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                willClose: () => {
                                    location.reload();
                                }
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Failed to update cart.',
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection