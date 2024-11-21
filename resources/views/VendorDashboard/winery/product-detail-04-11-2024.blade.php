@extends('VendorDashboard.layouts.vendorapp')
@section('title', 'Wine Country Weekends - Winery Shop')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" />
    <style>
        /* Don't Use This CSS */
        /* @font-face {                                                                        font-family: 'Inter_Tight';                                                                        src: url('../fonts/InterTight-Regular.ttf') format('truetype');                                                                    }                                                                    @font-face {                                                                        font-family: 'Inter_Tight_bold';                                                                        src: url('../fonts/InterTight-Bold.ttf') format('truetype');                                                                    } */
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
            height: 240px;
            object-fit: contain;
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

        .star-rating-container {
            display: flex;
            justify-content: center;
            /* Center aligns the star rating */
            margin-top: 10px;
        }

        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            gap: 5px;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            font-size: 2rem;
            color: #ccc;
            cursor: pointer;
        }

        .star-rating input:checked~label,
        .star-rating label:hover,
        .star-rating label:hover~label {
            color: #f5a623;
            /* Color for selected stars */
        }
    </style>
    <div class="col right-side">
        <div class="row">
            <div class="col-sm-12">
                <div class="mb-3">
                    <button class="btn wine-btn" onclick="window.history.back()">Go Back</button>
                </div>
                <div class="information-box p-0">
                    <div class="information-box-head">
                        <div class="box-head-heading d-flex"> <span class="box-head-label theme-color fw-bold">Wine
                                Details</span> </div>
                    </div>
                    <div class="information-box-body">
                        <div class="wine-detail-sec py-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="wine-thumbnail text-center">
                                        @if ($wine->image)
                                            <img src="{{ asset('storage/' . $wine->image) }}" class="img-fluid"
                                                alt="Wine Image">
                                        @else
                                            <img src="{{ asset('images/vendorbydefault.png') }}" class="img-fluid"
                                                alt="Wine Image">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="wine-info">
                                        <h3 class="fw-bold">{{ $wine->series }}</h3>
                                        <div class="d-flex align-items-center gap-2">
                                            @php
                                                $averageRating = $wine->reviews()->avg('rating');
                                                $wholeStars = floor($averageRating); // Integer part of the rating
                                                $fractionalStar = $averageRating - $wholeStars; // Fractional part (0 - 1)
                                                $totalStars = 5;
                                            @endphp
                                            <div class="rating d-flex align-items-center">
                                                @for ($i = 1; $i <= $totalStars; $i++)
                                                    @if ($i <= $wholeStars)
                                                        {{-- Full Star --}} <i class="fa-solid fa-star"
                                                            style="color: gold;"></i>
                                                    @elseif ($i === $wholeStars + 1 && $fractionalStar > 0)
                                                        {{-- Partially Filled Star --}} <i class="fa-solid fa-star"
                                                            style="color: gold; position: relative;"> <span
                                                                class="partial-star"
                                                                style="width: {{ $fractionalStar * 100 }}%;"></span> </i>
                                                    @else
                                                        {{-- Empty Star --}} <i class="fa-solid fa-star"
                                                            style="color: lightgray;"></i>
                                                    @endif
                                                @endfor
                                                <span
                                                    class="d-inline-block ps-2 fw-bold">{{ number_format($averageRating, 1) }}</span>
                                            </div>
                                            <div>|</div>
                                            <div> <a href="#" class="text-decoration-none theme-color"
                                                    data-bs-toggle="modal" data-bs-target="#reviewModal"> Write a Review
                                                </a> </div>
                                        </div>
                                        <p class="wine-price fw-bold mt-3">${{ $wine->price }}</p>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="input-group"> <span class="input-group-btn"> <button type="button"
                                                        class="quantity-left-minus btn btn-danger btn-number"
                                                        data-type="minus" data-field=""> <span
                                                            class="glyphicon glyphicon-minus">-</span> </button> </span>
                                                <input type="text" class="form-control input-number quantity"
                                                    min="1" max="{{ $wine->inventory }}" value="1"> <span
                                                    class="input-group-btn"> <button type="button"
                                                        class="quantity-right-plus btn btn-success btn-number"
                                                        data-type="plus" data-field=""> <span
                                                            class="glyphicon glyphicon-plus">+</span> </button> </span>
                                            </div>
                                            <div class="cart-btn text-end">
                                                <!-- <button type="button" class="btn wine-btn">Add to Cart</button> --> <a
                                                    href="javascript:void(0)" data-id="{{ $wine->id }}"
                                                    class="btn wine-btn add-to-cart">Add to Cart</a>
                                            </div>
                                        </div>
                                        <div class="wine-feature my-4">
                                            <p class="my-1 p-2"><span class="theme-color fw-bold">Business/Vendor
                                                    Name:</span> {{ $wine->vendor->vendor_name }}</p>
                                            <p class="my-1 p-2"><span class="theme-color fw-bold">Region: </span>
                                                {{ $wine->region }} </p>
                                            <p class="my-1 p-2"><span class="theme-color fw-bold">Sub-Region: </span>
                                                {{ $wine->sub_region }} </p>
                                            <p class="my-1 p-2"><span class="theme-color fw-bold">Series: </span>
                                                {{ $wine->series }} </p>
                                            <p class="my-1 p-2"><span class="theme-color fw-bold">Varietal/Bland: </span>
                                                Erem Lpsum</p>
                                            <p class="my-1 p-2"><span class="theme-color fw-bold">Grape Varietals: </span>
                                                Mrrem psum</p>
                                            <p class="my-1 p-2"><span class="theme-color fw-bold">Cellaring Value: </span>
                                                {{ $wine->cellar }}</p>
                                            <p class="my-1 p-2"><span class="theme-color fw-bold">Vintage Date: </span>
                                                {{ $wine->vintage_date }} </p>
                                            <p class="my-1 p-2"><span class="theme-color fw-bold">Bottle Size: </span>
                                                {{ $wine->bottle_size }}</p>
                                            <p class="my-1 p-2"><span class="theme-color fw-bold">Alcohol By Volume: </span>
                                                {{ $wine->abv }}</p>
                                            <p class="my-1 p-2"><span class="theme-color fw-bold">Residual Sugars: </span>
                                                {{ $wine->rs }}</p>
                                            <p class="my-1 p-2"><span class="theme-color fw-bold">Stocking/Delivery Fee:
                                                </span> ${{ $wine->commission_delivery_fee }}</p>
                                        </div>
                                        <div class="wine-notes my-3 py-3 border-top border-bottom">
                                            <p class="mb-0"><strong>Wine Spectator Notes:
                                                </strong>{{ $wine->description }}</p>
                                        </div>
                                        <div class="review-sec">
                                            <h6 class="fw-bold fs-5">Reviews</h6>
                                            <div>
                                                <div>
                                                    @foreach ($wine->reviews as $review)
                                                        <div> <strong>{{ $review->user->name }}</strong> <span> -
                                                                {{ $review->rating }}★</span>
                                                            <p>{{ $review->review_description }}</p>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wine-recommend-sec my-5" style="max-width:1100px">
                            <div class="sec-head">
                                <h3 class="fw-bold theme-color fs-4">You May Also Like</h3>
                            </div> <!-- Wine Slider Start -->
                            <div class="wine-recommend-slider">
                                @foreach ($sliders as $wine)
                                    <div class="wine-inner-sec text-center p-3 rounded"> <!-- Wine Thumbnail -->
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
                                        </div> <!-- Wine Information -->
                                        <div class="wine-info mt-3">
                                            <h5 class="fw-bold mb-1"><a
                                                    href="{{ route('winery-shop.detail', ['wineid' => $wine->id, 'shopid' => $wine->vendor_id, 'vendorid' => $vendorid]) }}">{{ $wine->series }}
                                                    ({{ $wine->vintage_date ?? 'N/A' }})
                                                </a>
                                            </h5>
                                            <p class="wine-price fw-bold">${{ number_format($wine->price, 2) }}</p>
                                            <!-- Add to Cart Button -->
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="cart-btn text-end"> <a href="javascript:void(0)"
                                                        data-id="{{ $wine->id }}"
                                                        class="btn wine-btn add-to-cart-slider">Add to Cart</a> </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div> <!-- Wine Slider End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header px-4">
                    <h2 class="modal-title fw-bold fs-5" id="exampleModalLabel">Add a Review</h2> <button type="button"
                        class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center pt-4 px-4">
                    <h3 class="fs-5 fw-bold theme-color">{{ $wine->series }}</h3> {{-- <form>                        <div>                            <label>Your Rating*</label>                            <div class="rating d-flex align-items-center justify-content-center gap-1">                                <a href="#"><i class="fa-solid fa-star"></i></a>                                <a href="#"><i class="fa-solid fa-star"></i></a>                                <a href="#"><i class="fa-solid fa-star"></i></a>                                <a href="#"><i class="fa-solid fa-star"></i></a>                                <a href="#"><i class="fa-solid fa-star"></i></a>                            </div>                        </div>                        <div class="my-3">                            <div class="form-floating">                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>                                <label for="floatingTextarea2">Comments</label>                            </div>                        </div>                        <div class="text-center">                            <button type="submit" class="btn submit-btn wine-btn w-50 text-uppercase">Submit</button>                        </div>                    </form> --}} <form
                        id="reviewForm"> @csrf <input type="hidden" name="product_id" value="{{ $wine->id }}">
                        <input type="hidden" name="vendor_id" value="{{ $vendorid }}">
                        <!-- Star Rating Selection --> <label for="rating">Rating:</label>
                        <div class="star-rating-container">
                            <div class="star-rating"> <input type="radio" id="star5" name="rating"
                                    value="5" /> <label for="star5" title="5 stars">★</label> <input
                                    type="radio" id="star4" name="rating" value="4" /> <label
                                    for="star4" title="4 stars">★</label> <input type="radio" id="star3"
                                    name="rating" value="3" /> <label for="star3" title="3 stars">★</label>
                                <input type="radio" id="star2" name="rating" value="2" /> <label
                                    for="star2" title="2 stars">★</label> <input type="radio" id="star1"
                                    name="rating" value="1" /> <label for="star1" title="1 star">★</label>
                            </div>
                        </div> <!-- Review Text Area --> <label for="review">Review:</label>
                        <textarea name="review" id="review" class="form-control" rows="3"></textarea> <button type="submit" class="btn btn-primary mt-3">Submit
                            Review</button>
                    </form>
                    <div id="responseMessage" class="mt-2"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://devwine2.winecountryweekends.ca/asset/fontawesome/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.quantity-right-plus').click(function(e) {
                e.preventDefault();

                var quantityInput = $(this).closest('.input-group').find('.quantity');
                var quantity = parseInt(quantityInput.val());
                var max = parseInt(quantityInput.attr('max')) ||
                    Infinity; // Get max value or default to Infinity

                // Increment the value if it's less than the max
                if (quantity < max) {
                    quantityInput.val(quantity + 1);
                }
            });

            $('.quantity-left-minus').click(function(e) {
                e.preventDefault();

                var quantityInput = $(this).closest('.input-group').find('.quantity');
                var quantity = parseInt(quantityInput.val());
                var min = parseInt(quantityInput.attr('min')) || 0; // Get min value or default to 0

                // Decrement the value if it's greater than the min
                if (quantity > min) {
                    quantityInput.val(quantity - 1);
                }
            });
        });
    </script>

    <script>
        $('.wine-recommend-slider').slick({
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            prevArrow: "<img class='a-left control-c prev slick-prev' src='{{ asset('images/prev-btn.png') }}'>",
            nextArrow: "<img class='a-right control-c next slick-next' src='{{ asset('images/next-btn.png') }}'>",
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on("click", ".add-to-cart", function() {
                var productId = $(this).data('id');
                var quantity = $(this).closest('.cart-btn').prev('.input-group').find('.quantity').val();
                $.ajax({
                    url: '{{ route('cart.add', ['shopid' => $shopid, 'vendorid' => $vendorid]) }}',
                    type: 'POST',
                    data: {
                        id: productId,
                        quantity: quantity
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Added to Cart!',
                            text: response.message,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        $('#cartItemCount').text(response.cartItemCount);
                    },
                    error: function(xhr) {
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

            $(document).on("click", ".add-to-cart-slider", function() {
                var productId = $(this).data('id');
                var quantity = 1;
                $.ajax({
                    url: '{{ route('cart.add', ['shopid' => $shopid, 'vendorid' => $vendorid]) }}',
                    type: 'POST',
                    data: {
                        id: productId,
                        quantity: quantity
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Added to Cart!',
                            text: response.message,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
                        $('#cartItemCount').text(response.cartItemCount);
                    },
                    error: function(xhr) {
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

    <script>
        $(document).ready(function() {
            $('#reviewForm').on('submit', function(event) {
                event.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('winery.reviews.store', $vendorid) }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        $('#reviewModal').modal('hide');
                        Swal.fire({
                            title: 'Review Submitted!',
                            text: 'Your review has been successfully submitted.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Submission Failed',
                            text: 'There was an error submitting your review. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
@endsection
