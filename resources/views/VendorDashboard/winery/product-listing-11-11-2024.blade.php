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
                            <span class="box-head-label theme-color fw-bold">{{ ucfirst($vendor->vendor_name) }}
                                Listing</span>
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

                                        <button type="submit" class="btn btn-primary wine-btn rounded">Search</button>

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
                                                            <img src="{{ asset('storage/' . $wine->image) }}"
                                                                class="img-fluid" alt="Wine Image">
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
                                                        <p class="wine-size fw-bold mb-0">{{ $wine->bottle_size }}</p>

                                                    </div>

                                                    <h5 class="fw-bold my-1">{{ $wine->series }}

                                                        {{ !empty($wine->vintage_date) ? '(' . $wine->vintage_date . ')' : '' }}

                                                    </h5>

                                                    <div>
                                                        <div
                                                            class="d-flex align-items-center justify-content-between gap-2 mt-2">
                                                            <div class="input-group">
                                                                <span class="input-group-btn">
                                                                    <button type="button"
                                                                        class="quantity-left-minus btn btn-danger btn-number"
                                                                        data-type="minus" data-field="">
                                                                        <span class="glyphicon glyphicon-minus">-</span>
                                                                    </button>
                                                                </span>

                                                                <input type="text" id="quantity" name="quantity"
                                                                    class="form-control input-number quantity"
                                                                    value="1" min="1"
                                                                    max="{{ $wine->inventory }}">
                                                                <span class="input-group-btn">
                                                                    <button type="button"
                                                                        class="quantity-right-plus btn btn-success btn-number"
                                                                        data-type="plus" data-field="">
                                                                        <span class="glyphicon glyphicon-plus">+</span>
                                                                    </button>
                                                                </span>
                                                            </div>
                                                            <p class="wine-price theme-color mb-0">${{ $wine->price }}</p>
                                                        </div>
                                                        <div
                                                            class="d-flex align-items-center justify-content-between gap-2 mt-3">
                                                            <div class="cart-btn text-end">
                                                                <!-- <button type="button" class="btn wine-btn">Add to Cart</button> -->

                                                                <a href="javascript:void(0)" data-type="bottle"
                                                                    data-id="{{ $wine->id }}"
                                                                    class="btn wine-btn add-to-cart w-100">Add Bottle</a>
                                                            </div>
                                                            <div class="cart-btn text-end">
                                                                <!-- <button type="button" class="btn wine-btn">Add to Cart</button> -->
                                                                @if($wine->inventory > 12)
                                                                <a href="javascript:void(0)" data-type="case"
                                                                    data-id="{{ $wine->id }}"
                                                                    class="btn wine-btn add-to-cart w-100">Add Case</a>
                                                                @else 
                                                                <a href="javascript:void(0)" title="Low Inventory" class="btn wine-btn w-100 disabled">Add Case</a>
                                                                @endif
                                                            </div>
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
                var max = parseInt(quantityInput.attr('max')) ||
                    0; // Get max value or set to Infinity if not set

                // Increment the value if it's less than max
                if (quantity < max) {
                    quantityInput.val(quantity + 1);
                }
            });

            $('.quantity-left-minus').on("click", function(e) {
                e.preventDefault();

                // Find the closest input field to the clicked button
                var quantityInput = $(this).closest('.input-group').find('.quantity');
                var quantity = parseInt(quantityInput.val());
                var min = parseInt(quantityInput.attr('min')) || 0; // Get min value or set to 0 if not set

                // Decrement the value if it's greater than min
                if (quantity > min) {
                    quantityInput.val(quantity - 1);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $(document).on("click", ".add-to-cart", function() {

                var productId = $(this).data('id'); // Get product ID from button
                var quantity_type = $(this).data('type'); // Get quantity type (bottle or case)

                // Find the quantity input relative to the clicked button
                var quantity = $(this).closest('.d-flex').prev('.d-flex').find('.quantity').val();

                
                // Adjust quantity if type is 'case'
                if (quantity_type == 'case') {
                    quantity = 12 * parseInt(quantity);
                }
                // console.log(quantity); // Check if quantity is retrieved correctly
                $.ajax({

                    url: '{{ route('cart.add', ['shopid' => $shopid, 'vendorid' => $vendorid]) }}', // URL to your route for adding to cart

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
                        $("#cartItemCount").text(response.cartItemCount);

                        // Show SweetAlert success message

                        Swal.fire({

                            title: 'Added to Cart!',

                            text: response.message, // Message from server response

                            icon: 'success',

                            confirmButtonText: 'OK'

                        });

                    },

                    error: function(xhr) {
                        var response = xhr.responseJSON;
                        // Show SweetAlert error message

                        Swal.fire({

                            title: 'Error',

                            text: response.message,

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
