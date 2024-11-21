@extends('VendorDashboard.layouts.vendorapp')
@section('title', 'Wine Country Weekends - Winery Shop')
@section('content')
    <style>
        /* Don't Use This CSS */
        @font-face {
            font-family: 'Inter_Tight';
            src: url('../fonts/InterTight-Regular.ttf') format('truetype');
        }

        @font-face {
            font-family: 'Inter_Tight_bold';
            src: url('../fonts/InterTight-Bold.ttf') format('truetype');
        }

        *,
        body {
            font-family: 'Inter_Tight';
            letter-spacing: 0.8px;
        }

        .theme-color {
            color: #118c97 !important;
        }

        .hours-outer {
            max-width: 1000px;
            margin: 0 auto;
        }

        .information-box {
            width: 100%;
            border: 1px solid #CBCBCB;
            background-color: #F9F9F9;
            border-radius: 15px;
        }

        .information-box-head {
            border-bottom: 1px solid #CBCBCB;
            padding: 20px 30px;
            border-radius: 15px 15px 0px 0px;
            background: #118c9730;
        }

        .box-head-heading {
            font-size: 20px;
        }

        .box-head-label {
            width: 90%;
        }

        .information-box-body {
            padding: 15px 30px;
        }

        .wine-btn {
            background-color: #118c97;
            color: #fff;
            border-radius: 50px;
            text-decoration: none;
            padding: 6px 20px;
            position: relative;
            overflow: hidden;
            z-index: 9;
            border: none;
        }

        .wine-btn:hover {
            background-color: #118c97;
            color: #fff;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #408a95 !important;
            box-shadow: unset;
        }

        /* Use the Below CSS Only */
        .cart-btn button {
            font-size: 14px;
            border: 2px solid #538893;
        }

        .cart-btn button:hover {
            border-color: #538893;
            color: #fff;
        }

        .wine-club-listing-sec .wine-inner-sec {
            border: 1px solid #d6e4e6;
            background-color: #fff;
        }

        .wine-club-listing-sec .wine-inner-sec img {
            height: 250px;
        }

        .wine-club-listing-sec .input-group {
            width: 35%;
        }

        .wine-club-listing-sec .cart-btn {
            width: 65%;
        }

        .wine-club-listing-sec .input-group button.btn-number,
        .wine-detail-sec .input-group button.btn-number {
            padding: 4px 10px;
            width: 30px;
            background-color: #408a95;
            border-color: #408a95;
        }

        .wine-club-listing-sec .input-group button.quantity-left-minus,
        .wine-detail-sec .input-group button.quantity-left-minus {
            border-radius: 4px 0 0 4px;
        }

        .wine-club-listing-sec .input-group button.quantity-right-plus,
        .wine-detail-sec .input-group button.quantity-right-plus {
            border-radius: 0 4px 4px 0;
        }

        .wine-club-listing-sec .input-group input,
        .wine-detail-sec .input-group input {
            font-size: 15px;
            text-align: center;
            padding: 4px;
        }

        .wine-club-listing-sec .input-group input:focus,
        .wine-detail-sec .input-group input:focus {
            border-color: #408a95 !important;
        }

        .wine-club-listing-sec .wine-title {
            font-size: 15px;
            color: #408a95;
        }

        .wine-club-listing-sec .wine-info h5 {
            font-size: 18px;
            color: #000;
        }

        .wine-club-listing-sec .wine-price,
        .wine-detail-sec .wine-price,
        .wine-recommend-sec .wine-price {
            font-size: 18px;
            color: #408a95;
        }

        .wine-detail-sec .input-group {
            width: 15%;
        }

        .wine-detail-sec .rating svg {
            color: #408a95;
        }

        .wine-detail-sec .wine-thumbnail img {
            width: 100%;
            height: 600px;
            object-fit: contain;
            border-radius: 10px;
            border: 1px solid #408a9526;
        }

        .wine-detail-sec .wine-feature p,
        .invoice-detail-modal .wine-feature p {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 15px;
        }

        .wine-detail-sec .wine-feature p:nth-child(even),
        .invoice-detail-modal .wine-feature p:nth-child(even) {
            background-color: #d6e4e630;
            border-top: 1px solid #e0e8ea73;
            border-bottom: 1px solid #e0e8ea73;
        }

        .wine-detail-sec .wine-feature p span {
            display: inline-block;
            width: 30%;
        }

        .wine-inner-sec .wine-info h5 {
            font-size: 16px;
        }

        .wine-recommend-slider .wine-thumbnail {
            border: 1px solid #408a9526;
            border-radius: 10px;
        }

        .wine-recommend-slider .wine-thumbnail img {
            width: 120px;
            margin-inline: auto;
        }

        .wine-recommend-slider .slick-arrow {
            width: 30px;
            height: 30px;
            z-index: 1;
        }

        .wine-detail-sec .wine-notes p {
            font-size: 14px;
        }

        #reviewModal svg {
            color: #408a95;
        }

        #reviewModal form label {
            font-size: 15px;
        }

        #reviewModal button.btn-close {
            background-size: 40%;
        }

        .cart-sec .pro-img img {
            width: 70px;
            height: 70px;
            object-fit: contain;
            border: 1px solid #d9e4e6;
            border-radius: 4px;
        }

        .cart-sec thead tr th:first-child {
            width: 60%;
        }

        .cart-sec thead tr th:last-child {
            width: 10%;
        }

        .cart-sec thead {
            border-top: 1px solid #e0e8ea;
            border-bottom: 1px solid #e0e8ea;
        }

        .cart-sec thead th {
            padding: 6px 10px;
        }

        .cart-sec tbody td {
            padding: 15px 10px;
        }

        .cart-sec .prod-title {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 4px;
        }

        .cart-sec .remove-prod {
            color: #408a95;
            text-transform: uppercase;
            font-size: 13px;
        }

        .cart-sec .remove-prod a:hover {
            color: red !important;
        }

        .cart-sec .subtotal-cost p {
            font-size: 20px;
        }

        .cart-sec .cart-box {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 6px;
        }

        .cart-sec .subtotal-count {
            border-top: 1px solid #00000024;
        }

        .cart-sec .cart-box h4 {
            font-size: 18px;
            font-weight: bold;
        }



        .vendor-payment-form .form-control::placeholder {
            font-size: 15px;
        }

        #tyModal .modal-body img {
            width: 130px;
        }

        #tyModal p:not(:last-child) {
            font-size: 15px;
            font-style: italic;
        }
    </style>
    <div class="col right-side">
        <div class="row">
            <div class="information-box p-0">
                <div class="information-box-head">
                    <div class="box-head-heading d-flex">
                        <span class="box-head-label theme-color fw-bold">Wine Club Listing</span>
                    </div>
                </div>
                <div class="information-box-body">
                    <div class="wine-club-listing-sec py-3">
                        <div class="wine-filtar-bar d-flex align-items-center justify-content-end gap-2 mb-4">
                            <form action="" method="GET" class="d-flex align-items-center gap-2">
                                <!-- Search Input -->
                                <div>
                                    <input type="search" id="search" name="search" class="form-control"
                                        placeholder="Search" value="{{ old('search', request()->get('search')) }}">
                                </div>

                                <!-- Date Dropdown -->
                                <div>
                                    <select class="form-select" id="date" name="date"
                                        aria-label="Default select example">
                                        <option value="">Select Date</option>
                                        @if (count($dates) > 0)
                                            @foreach ($dates as $date)
                                                <option value="{{ $date }}"
                                                    {{ old('date', request()->get('date')) == $date ? 'selected' : '' }}>
                                                    {{ $date }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <!-- Submit Button -->
                                <div>
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                        </div>
                        <div class="row g-4">
                            @if (count($wines) > 0)
                                @foreach ($wines as $wine)
                                    <div class="col-md-4">
                                        <div class="wine-inner-sec p-3 rounded">
                                            <div class="wine-thumbnail text-center">
                                                <a
                                                    href="{{ route('winery-shop.detail', ['wineid' => $wine->id, 'shopid' => $wine->vendor_id, 'vendorid' => $vendorid]) }}">
                                                    @if ($wine->image)
                                                        <img src="{{ asset('storage/' . $wine->image) }}" class="img-fluid"
                                                            alt="Wine Image">
                                                    @else
                                                        <img src="{{ asset('images/vendorbydefault.png') }}"
                                                            class="img-fluid" alt="Wine Image">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="wine-info mt-2">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h6 class="wine-title mb-0 fw-bold"><a
                                                            href="{{ route('winery-shop.detail', ['wineid' => $wine->id, 'shopid' => $wine->vendor_id, 'vendorid' => $vendorid]) }}">{{ $vendor->vendor_name }}</a>
                                                    </h6>
                                                    <p class="mb-0 wine-rating">
                                                        @if ($wine->reviews->count() > 0)
                                                            {{ number_format($wine->reviews->avg('rating'), 1) }}
                                                        @else
                                                            No ratings yet
                                                        @endif
                                                    </p>
                                                </div>
                                                <h5 class="fw-bold mb-1">{{ $wine->series }}
                                                    {{ !empty($wine->vintage_date) ? '(' . $wine->vintage_date . ')' : '' }}
                                                </h5>
                                                <p class="wine-price fw-bold">${{ $wine->price }}</p>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button type="button"
                                                                class="quantity-left-minus btn btn-danger btn-number"
                                                                data-type="minus" data-field="">
                                                                <span class="glyphicon glyphicon-minus">-</span>
                                                            </button>
                                                        </span>
                                                        <input type="text" id="quantity" name="quantity"
                                                            class="form-control input-number quantity" value="1"
                                                            min="1" max="100">
                                                        <span class="input-group-btn">
                                                            <button type="button"
                                                                class="quantity-right-plus btn btn-success btn-number"
                                                                data-type="plus" data-field="">
                                                                <span class="glyphicon glyphicon-plus">+</span>
                                                            </button>
                                                        </span>
                                                    </div>
                                                    <div class="cart-btn text-end">
                                                        <!-- <button type="button" class="btn wine-btn">Add to Cart</button> -->
                                                        <a href="javascript:void(0)" data-id="{{ $wine->id }}"
                                                            class="btn wine-btn add-to-cart">Add to Cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="d-flex justify-content-end">
                                    {{ $wines->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            @else
                                No Wine Found
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
        $(document).ready(function() {
            $('.quantity-right-plus').on("click", function(e) {
                e.preventDefault();

                // Find the closest input field to the clicked button
                var quantityInput = $(this).closest('.input-group').find('.quantity');
                var quantity = parseInt(quantityInput.val());

                // Increment the value
                quantityInput.val(quantity + 1);
            });

            $('.quantity-left-minus').on("click", function(e) {
                e.preventDefault();

                // Find the closest input field to the clicked button
                var quantityInput = $(this).closest('.input-group').find('.quantity');
                var quantity = parseInt(quantityInput.val());

                // Decrement the value if greater than 0
                if (quantity > 0) {
                    quantityInput.val(quantity - 1);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on("click", ".add-to-cart", function() {
                var productId = $(this).data('id'); // Get product ID from button
                var quantity = $(this).closest('.d-flex').find('.input-group .quantity')
            .val(); // Get quantity from input
                $.ajax({
                    url: '{{ route('cart.add', ['shopid' => $shopid,'vendorid' => $vendorid]) }}', // URL to your route for adding to cart
                    type: 'POST',
                    data: {
                        id: productId,
                        quantity: quantity
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // CSRF token for security
                    },
                    success: function(response) {
                        // Show SweetAlert success message
                        Swal.fire({
                            title: 'Added to Cart!',
                            text: response.message, // Message from server response
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        $('#cartItemCount').text(response.cartItemCount);
                    },
                    error: function(xhr) {
                        // Show SweetAlert error message
                        Swal.fire({
                            title: 'Error',
                            text: 'Failed to add item to cart. Please try again.',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                    }
                });
            });
        });
    </script>
@endsection
