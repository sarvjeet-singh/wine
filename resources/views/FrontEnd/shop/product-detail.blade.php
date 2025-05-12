@extends('FrontEnd.layouts.mainapp')

@section('content')
    <style>
        .cart-btn button {
            font-size: 14px;
            border: 2px solid #538893;
        }

        .cart-btn button:hover {
            border-color: #538893;
            color: #fff;
        }

        .wine-club-listing-sec .wine-btn {
            padding: 6px 20px;
        }

        .wine-club-listing-sec .wine-inner-sec {
            border: 1px solid #d6e4e6;
            background-color: #fff;
            height: 100%;
        }

        .wine-club-listing-sec .wine-inner-sec img {
            height: 250px;
        }

        .wine-inner-sec .wine-size {
            position: absolute;
            bottom: 4px;
            right: 0;
            z-index: 2;
        }

        .wine-inner-sec .wine-size:empty {
            display: none;
        }

        .wishlist-icon svg {
            position: absolute;
            top: 0;
            right: 0;
            width: 20px;
            height: 20px;
            z-index: 2;
        }

        .wine-club-listing-sec .input-group {
            width: 35%;
        }

        .wine-club-listing-sec .cart-btn {
            width: 65%;
        }

        .wine-club-listing-sec .input-group button.btn-number,
        .wine-detail-sec .input-group button.btn-number,
        .wine-recommend-slider .input-group button.btn-number,
        .cart-sec .input-group button.btn-number {
            padding: 4px 10px;
            width: 30px;
            background-color: #bba253;
            border-color: #bba253;
        }

        .wine-club-listing-sec .input-group button.quantity-left-minus,
        .wine-detail-sec .input-group button.quantity-left-minus,
        .wine-recommend-slider .input-group button.quantity-left-minus,
        .cart-sec .input-group button.quantity-left-minus {
            border-radius: 4px 0 0 4px;
        }

        .wine-club-listing-sec .input-group button.quantity-right-plus,
        .wine-detail-sec .input-group button.quantity-right-plus,
        .wine-recommend-slider .input-group button.quantity-right-plus,
        .cart-sec .input-group button.quantity-right-plus {
            border-radius: 0 4px 4px 0;
        }

        .wine-club-listing-sec .input-group input,
        .wine-detail-sec .input-group input,
        .wine-recommend-slider .input-group input,
        .cart-sec .input-group input {
            font-size: 15px;
            text-align: center;
            padding: 4px;
        }

        .wine-club-listing-sec .input-group input:focus,
        .wine-detail-sec .input-group input:focus,
        .wine-recommend-slider .input-group input:focus,
        .cart-sec .input-group input {
            border-color: #bba253 !important;
        }

        .cart-sec .update-quantity {
            background-color: transparent;
            border: none;
            padding: 4px;
            color: #bba253;
            font-size: 20px;
        }

        .wine-club-listing-sec .wine-title {
            font-size: 15px;
            color: #bba253;
        }

        .wine-club-listing-sec .wine-info h5 {
            font-size: 18px;
            color: #000;
        }

        .wine-recommend-sec .wine-price {
            font-size: 18px;
        }

        .wine-club-listing-sec .wine-price {
            font-size: 20px;
        }

        .wine-detail-sec .wine-price {
            font-size: 24px;
        }

        .wine-detail-sec .input-group {
            width: 15%;
        }

        .wine-detail-sec .rating svg {
            color: #bba253;
        }

        .wine-detail-sec .wine-thumbnail {
            z-index: 2 !important;
        }

        .wine-detail-sec .wine-thumbnail img {
            width: 100%;
            height: 550px;
            object-fit: contain;
            border-radius: 10px;
            border: 1px solid #bba25326;
        }

        .wine-detail-sec .wine-feature p,
        .invoice-detail-modal .wine-feature p {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 15px;
        }

        .wine-detail-sec .wine-feature-inner:nth-child(even),
        .invoice-detail-modal .wine-feature p:nth-child(even) {
            background-color: #d6e4e630;
            border-top: 1px solid #e0e8ea73;
            border-bottom: 1px solid #e0e8ea73;
        }

        .wine-detail-sec .feature-head {
            width: 30%;
        }

        .wine-detail-sec .featured-value {
            width: 70%;
        }

        .wine-detail-sec .featured-value span {
            padding-right: 6px;
        }

        .wine-inner-sec .wine-info h5:not(.wine-listing-view .wine-info h5) {
            font-size: 16px;
            height: 40px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .wine-inner-sec.wine-listing-view h5 {
            font-size: 16px;
        }

        .wine-club-listing-sec.wine-listing-view .wine-info svg {
            position: relative;
            top: 4px;
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

        .wine-detail-sec .wine-btn.add-to-cart {
            padding: 6px 20px;
            min-width: 150px;
        }

        .wine-detail-sec .wine-feature table {
            font-size: 15px;
            width: 70%;
        }

        .wine-detail-sec .wine-feature table th,
        .wine-detail-sec .wine-feature table td {
            padding: 6px;
        }

        .wine-detail-sec .wine-feature table th {
            padding-left: 0;
            vertical-align: top;
        }

        .wine-detail-sec .wine-feature table tr:not(:last-child) {
            border-bottom: 1px solid #e0e8ea73;
        }

        .wine-recommend-slider .wine-thumbnail {
            border: 1px solid #bba25326;
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
            filter: brightness(0.9);
            z-index: 1;
        }

        .wine-recommend-slider .wine-btn {
            padding: 6px 20px;
        }

        .wine-recommend-slider .wine-btn:before {
            content: unset;
        }

        .wine-detail-sec .wine-notes p {
            font-size: 14px;
        }

        .add-wines-cart .form-check {
            min-height: unset;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .add-wines-cart .form-check .form-check-input {
            left: 0;
            box-shadow: unset;
            cursor: pointer;
        }

        .add-wines-cart .form-check-label {
            cursor: pointer;
        }

        #reviewModal svg {
            color: #bba253;
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
            color: #bba253;
            text-transform: uppercase;
            font-size: 13px;
        }

        .cart-sec .remove-prod a:hover {
            color: red !important;
        }

        .cart-sec .subtotal-cost p {
            font-size: 20px;
        }

        .cart-sec .cart-box,
        .checkout-address-sec {
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

        .cart-sec .form-check-input {
            box-shadow: unset;
            cursor: pointer;
        }

        .cart-sec .form-check-label {
            cursor: pointer;
            font-weight: 400;
        }

        .checkout-box .form-control::placeholder {
            font-size: 15px;
        }

        .cart-sec .sticky-top {
            top: 100px;
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
        }

        .wine-vintage-table td img {
            object-fit: contain;
        }

        .cellaring-value-sec input,
        .cellaring-value-sec label {
            cursor: pointer;
        }

        .cellaring-value-sec .form-check img,
        .wine-feature.cellaring-value-sec td img {
            width: 40px;
            aspect-ratio: 1/1;
            object-fit: contain;
        }

        .cellaring-value-sec .cellaring-value-1 img {
            rotate: 45deg;
        }

        .cellaring-value-sec .cellaring-value-3 img {
            rotate: 90deg;
            position: relative;
            top: 10px;
        }

        .cellaring-value-sec .form-check-label p {
            font-size: 14px;
        }

        .dt-search [type="search"] {
            outline: none;
        }

        .dt-length label {
            padding-left: 10px;
            text-transform: capitalize;
        }

        .wine-vintage-table a {
            color: #348a96;
        }

        .wine-vintage-table th {
            white-space: nowrap;
            border-bottom: none !important;
            outline: none !important;
            text-align: left !important;
            vertical-align: middle;
        }

        .wine-vintage-table tbody td {
            padding: 20px 8px;
            color: #757575;
            text-align: left !important;
            vertical-align: middle;
        }

        #addWine-modal .form-label {
            font-weight: bold;
        }

        #addWine-modal .modal-title {
            color: #348a96;
        }

        #addWine-modal .fa-circle-plus {
            width: 20px;
            height: 20px;
            color: #348a96;
        }

        .amenities-modal ul {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        @media screen and (max-width: 767px) {
            .wine-detail-sec .add-wines-cart {
                flex-wrap: wrap;
            }

            .wine-detail-sec .input-group {
                width: 40%;
            }

            .wine-recommend-slider .slick-arrow {
                width: 24px;
                height: 24px;
                top: 28%;
            }

            .wine-recommend-slider .slick-arrow.slick-prev {
                left: 0;
            }

            .wine-recommend-slider .slick-arrow.slick-next {
                right: 0;
            }

            .wine-detail-sec .wine-feature table {
                width: 100%;
            }
        }
    </style>

    <div class="container">
        <div class="wine-detail-sec py-4">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('frontend-shop') }}">Wine Shop</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('frontend-shop.wines', $vendor->id) }}">{{ $vendor->vendor_name }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $wine->winery_name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="wine-thumbnail sticky-top text-center">
                        @if ($wine->image)
                            <img src="{{ asset('storage/' . $wine->image) }}" class="img-fluid" alt="Wine Image">
                        @else
                            <img src="{{ asset('images/vendorbydefault.png') }}" class="img-fluid" alt="Wine Image">
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="wine-info px-3 mt-md-0 mt-4">
                        <h3 class="fw-bold theme-color">{{ $wine->winery_name }}
                            @if (!empty($wine->pdf))
                                <a href="{{ url(Storage::url($wine->pdf)) }}" target="_blank"><i
                                        class="fas fa-file-pdf"></i>
                                </a>
                            @endif
                        </h3>
                        <p class="wine-price mb-3">${{ winery_b2c_price($vendor, $wine) }}</p>
                        <div class="wine-feature cellaring-value-sec mt-4">
                            <table>
                                <tbody>
                                    <tr>
                                        <th><span class="theme-color fw-bold">Region:</span></th>
                                        <td><span>{{ ucfirst(optional($wine->regions)->name ?? ($wine->custom_region ?? '-')) }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><span class="theme-color fw-bold">Sub-Region:</span></th>
                                        <td><span>{{ ucfirst(optional($wine->subregions)->name ?? ($wine->custom_sub_region ?? '-')) }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><span class="theme-color fw-bold">Series:</span></th>
                                        <td><span>{{ $wine->series }}</span></td>
                                    </tr>
                                    @if (!empty($wine->cellar))
                                        <tr>
                                            <th><span class="theme-color fw-bold">Cellaring Value:</span></th>
                                            <!-- <td><span>{{ $wine->cellar }}</span></td> -->
                                            <td>
                                                <div class="d-inline">
                                                    <img src="{{ asset('images/wine-drink.png') }}" class="img-fluid"
                                                        alt="Wine Image">
                                                </div>
                                                <span>
                                                    @if ($wine->cellar == 'Drink Now')
                                                        Drink Now (1-3yrs)
                                                    @elseif($wine->cellar == 'Drink or Cellar')
                                                        Drink or Hold (4-6yrs)
                                                    @else
                                                        Cellar (9+yrs)
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th><span class="theme-color fw-bold">Vintage Date:</span></th>
                                        <td><span>{{ $wine->vintage_date }}</span></td>
                                    </tr>
                                    <tr>
                                        <th><span class="theme-color fw-bold">Bottle Size:</span></th>
                                        <td><span>{{ $wine->bottle_size }}</span></td>
                                    </tr>
                                    <tr>
                                        <th><span class="theme-color fw-bold">Alcohol By Volume:</span>
                                        </th>
                                        <td><span>{{ $wine->abv }}%</span></td>
                                    </tr>
                                    <tr>
                                        <th><span class="theme-color fw-bold">Residual Sugars:</span></th>
                                        <td><span>
                                                @php
                                                    $residualSugar = $wine->rs; // Replace with the actual variable holding the value

                                                    switch ($residualSugar) {
                                                        case '0-1':
                                                            echo $wine->rs_value . ' g/l (Bone Dry)';
                                                            break;
                                                        case '1-9':
                                                            echo $wine->rs_value . ' g/l (Dry)';
                                                            break;
                                                        case '10-49':
                                                            echo $wine->rs_value . ' g/l (Off Dry)';
                                                            break;
                                                        case '50-120':
                                                            echo $wine->rs_value . ' g/l (Semi-Sweet)';
                                                            break;
                                                        case '120+':
                                                            echo $wine->rs_value . ' g/l (Sweet)';
                                                            break;
                                                        default:
                                                            echo '';
                                                    }
                                                @endphp</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><span class="theme-color fw-bold">Varietal:</span></th>
                                        <td>
                                            @if ($wine->varietal_blend)
                                                @php
                                                    // Decode the varietal blend JSON data
                                                    $varietals = json_decode($wine->varietal_blend);
                                                @endphp

                                                @if (is_array($varietals))
                                                    @foreach ($varietals as $varietal)
                                                        <div>
                                                            {{-- Display blend percentage and mapped varietal type --}}
                                                            <span>{{ $varietal->blend ?? 'N/A' }}%</span>
                                                            <span>{{ getGrapeVarietalsById($varietal->type) ?? 'Unknown Type' }}</span>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div>Invalid varietal blend data</div>
                                                @endif
                                            @else
                                                <div>No varietal blend information available</div>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="wine-notes my-3 py-3 border-top border-bottom">
                        <p class="mb-1"><span class="theme-color fw-bold">Bottle Notes:
                            </span>
                        </p>
                        <p class="mb-0">
                            <strong>Wine Spectator Notes:</strong>
                            {!! str_replace("\r\n", '</p><p class="mt-1 mb-0">', $wine->description) !!}
                        </p>
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

        <!-- Slider Sec Start -->
        <div class="wine-recommend-sec my-5">
            <div class="sec-head">
                <h3 class="fw-bold theme-color fs-4">You May Also Like</h3>
            </div>

            <div class="wine-recommend-slider">
                @if (count($sliders))
                    @foreach ($sliders as $wine)
                        <div class="wine-inner-sec text-center p-3 rounded"> <!-- Wine Thumbnail -->

                            <div class="wine-thumbnail text-center">

                                <a
                                    href="{{ route('frontend-shop.wine-detail', ['id' => $wine->id, 'shopid' => $wine->vendor_id]) }}">

                                    @if ($wine->image)
                                        <img src="{{ asset('storage/' . $wine->image) }}" class="img-fluid"
                                            alt="Wine Image">
                                    @else
                                        <img src="{{ asset('images/vendorbydefault.png') }}" class="img-fluid"
                                            alt="Wine Image">
                                    @endif

                                </a>

                            </div> <!-- Wine Information -->

                            <div class="wine-info mt-3">

                                <h5 class="fw-bold mb-1"><a
                                        href="{{ route('frontend-shop.wine-detail', ['id' => $wine->id, 'shopid' => $wine->vendor_id]) }}">{{ $wine->series }}

                                        ({{ $wine->vintage_date ?? 'N/A' }})
                                    </a>

                                </h5>

                                <p class="wine-price fw-bold">${{ number_format(winery_b2c_price($vendor, $wine), 2) }}</p>

                                <!-- Add to Cart Button -->
                                <div class="text-center"> <a
                                        href="{{ route('frontend-shop.wine-detail', ['id' => $wine->id, 'shopid' => $wine->vendor_id]) }}"
                                        class="btn wine-btn" data-quantity="1">View Details</a>
                                </div>
                            </div>

                        </div>
                    @endforeach
                @endif

            </div>
        </div>
        <!-- Slider Sec Start -->

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

                        <input type="hidden" name="vendor_id" value="{{ $vendor->id }}"> <!-- Star Rating Selection -->

                        <!-- Star Rating Selection --> <label for="rating">Rating:</label>

                        <div class="star-rating-container">

                            <div class="star-rating"> <input type="radio" id="star5" name="rating"
                                    value="5" />
                                <label for="star5" title="5 stars">★</label> <input type="radio" id="star4"
                                    name="rating" value="4" /> <label for="star4" title="4 stars">★</label>
                                <input type="radio" id="star3" name="rating" value="3" /> <label
                                    for="star3" title="3 stars">★</label>

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
        $(document).ready(function() {
            $('.wine-recommend-slider').slick({
                dots: false,
                infinite: true,
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 4,
                prevArrow: "<img class='a-left control-c prev slick-prev' src='/images/prev-btn.png'>",
                nextArrow: "<img class='a-right control-c next slick-next' src='/images/next-btn.png'>",
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
        });
    </script>
@endsection
