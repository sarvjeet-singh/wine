@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Winery Shop')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css" />

    <div class="col right-side">

        <div class="row">

            <div class="col-sm-12">
                <div class="information-box p-0">

                    <div class="information-box-head d-flex align-items-center gap-3">
                        <button class="btn back-btn d-flex align-items-center p-0" onclick="window.history.back()">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                        <div class="box-head-heading"> <span class="box-head-label theme-color fw-bold">{{ $wine->series }}
                                Details</span> </div>
                    </div>

                    <div class="information-box-body">

                        <div class="wine-detail-sec py-4">

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="wine-thumbnail sticky-top text-center">

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

                                    <div class="wine-info px-3">

                                        <h3 class="fw-bold theme-color">{{ $wine->series }}</h3>

                                        <p class="wine-price mb-3">${{ $wine->price }}</p>
                                        @if ($vendor->account_status == 1)
                                            <div class="add-wines-cart d-flex align-items-center gap-3">
                                                <div class="input-group"> <span class="input-group-btn"> <button
                                                            type="button"
                                                            class="quantity-left-minus btn btn-danger btn-number"
                                                            data-type="minus" data-field=""> <span
                                                                class="glyphicon glyphicon-minus">-</span> </button> </span>

                                                    <input type="text" class="form-control input-number quantity"
                                                        min="1" max="{{ $wine->inventory }}" oninput="this.value = this.value < this.min ? this.min : this.value" value="1"> <span
                                                        class="input-group-btn"> <button type="button"
                                                            class="quantity-right-plus btn btn-success btn-number"
                                                            data-type="plus" data-field=""> <span
                                                                class="glyphicon glyphicon-plus">+</span> </button> </span>
                                                </div>

                                                <div class="d-flex align-items-center">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input p-0"
                                                            {{ $wine->inventory > 12 ? 'checked' : '' }} type="radio"
                                                            name="wineOptions" id="inlineRadio2" value="case">
                                                        <label class="form-check-label d-flex align-items-center"
                                                            for="inlineRadio2">
                                                            Case
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input p-0"
                                                            {{ $wine->inventory < 12 ? 'checked' : '' }} type="radio"
                                                            name="wineOptions" id="inlineRadio1" value="bottle">
                                                        <label class="form-check-label" for="inlineRadio1">
                                                            Bottle
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="cart-btn">
                                                    {{-- @if ($wine->inventory > 12) --}}
                                                    <a href="javascript:void(0)" data-id="{{ $wine->id }}"
                                                        data-quantity="{{$wine->inventory > 12 ? 12 : 1}}" class="btn wine-btn add-to-cart">Add
                                                        to Cart</a>
                                                    {{-- @else
                                                    <a href="javascript:void(0)" class="btn wine-btn disabled">Add to
                                                        Cart</a>
                                                @endif --}}
                                                </div>

                                                <!-- <div class="d-flex align-items-center gap-2">
                                                            <div class="cart-btn">
                                                                <a href="javascript:void(0)" data-type="bottle"
                                                                    data-id="{{ $wine->id }}" class="btn wine-btn add-to-cart">Add
                                                                    Bottle</a>
                                                            </div>
                                                            <div class="cart-btn">
                                                                @if ($wine->inventory > 12)
    <a href="javascript:void(0)" data-type="case"
                                                                        data-id="{{ $wine->id }}"
                                                                        class="btn wine-btn add-to-cart">Add
                                                                        Case</a>
@else
    <a href="javascript:void(0)" class="btn wine-btn disabled">Add
                                                                        Case</a>
    @endif
                                                            </div>
                                                        </div> -->

                                            </div>
                                        @endif
                                        <div class="wine-feature cellaring-value-sec mt-4">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <th><span class="theme-color fw-bold">Business/Vendor Name:</span>
                                                        </th>
                                                        <td><span>{{ $wine->vendor->vendor_name }}</span></td>
                                                    </tr>
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
                                                    <tr>
                                                        <th><span class="theme-color fw-bold">Cellaring Value:</span></th>
                                                        <!-- <td><span>{{ $wine->cellar }}</span></td> -->
                                                        <td>
                                                            <div class="d-inline">
                                                                <img src="{{ asset('images/wine-drink.png') }}"
                                                                    class="img-fluid" alt="Wine Image">
                                                            </div>
                                                            <span>{{ $wine->cellar }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><span class="theme-color fw-bold">Vintage Date:</span></th>
                                                        <td><span>{{ $wine->vintage_date }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th><span class="theme-color fw-bold">Bottle Size:</span></th>
                                                        <td><span>{{ $wine->bottle_size }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th><span class="theme-color fw-bold">Alcohol By Volume:</span></th>
                                                        <td><span>{{ $wine->abv }}%</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th><span class="theme-color fw-bold">Residual Sugars:</span></th>
                                                        <td><span>

                                                                @php
                                                                    $residualSugar = $wine->rs; // Replace with the actual variable holding the value

                                                                    switch ($residualSugar) {
                                                                        case '0-1':
                                                                            echo '0 - 1 g/l (Bone Dry)';
                                                                            break;
                                                                        case '1-9':
                                                                            echo '1 - 9 g/l (Dry)';
                                                                            break;
                                                                        case '10-49':
                                                                            echo '10 - 49 g/l (Off Dry)';
                                                                            break;
                                                                        case '50-120':
                                                                            echo '50 - 120 g/l (Semi-Sweet)';
                                                                            break;
                                                                        case '120+':
                                                                            echo '120+ g/l (Sweet)';
                                                                            break;
                                                                        default:
                                                                            echo '';
                                                                    }
                                                                @endphp</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th><span class="theme-color fw-bold">Blend:</span></th>
                                                        @php
                                                            // Map select option values to varietal types
                                                            $varietalTypes = [
                                                                1 => 'Varietal',
                                                                2 => 'Riesling',
                                                                3 => 'Chardonnay',
                                                                4 => 'Gewürztraminer',
                                                                5 => 'Merlot',
                                                                6 => 'Gamay Noir',
                                                                7 => 'Pinot Noir',
                                                                8 => 'Cabernet Franc',
                                                                9 => 'Cabernet Sauvignon',
                                                            ];
                                                        @endphp

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
                                                                            <span>{{ $varietal->blend ?? 'N/A' }}%</span> -
                                                                            <span>{{ $varietalTypes[$varietal->type] ?? 'Unknown Type' }}</span>
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

                                        <!-- <div class="wine-feature mt-4">

                                                                                    <p class="my-1 p-2"><span class="theme-color fw-bold">Business/Vendor

                                                                                            Name:</span> {{ $wine->vendor->vendor_name }}</p>

                                                                                    <p class="my-1 p-2"><span class="theme-color fw-bold">Region: </span>

                                                                                        {{ ucfirst($wine->region) }} </p>

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

                                                                                        {{ $wine->abv }}%</p>

                                                                                    <p class="my-1 p-2"><span class="theme-color fw-bold">Residual Sugars: </span>

                                                                                        @php

                                                                                            $residualSugar = $wine->rs; // Replace with the actual variable holding the value

                                                                                            switch ($residualSugar) {
                                                                                                case '0-1':
                                                                                                    echo '0 - 1 g/l (Bone Dry)';

                                                                                                    break;

                                                                                                case '1-9':
                                                                                                    echo '1 - 9 g/l (Dry)';

                                                                                                    break;

                                                                                                case '10-49':
                                                                                                    echo '10 - 49 g/l (Off Dry)';

                                                                                                    break;

                                                                                                case '50-120':
                                                                                                    echo '50 - 120 g/l (Semi-Sweet)';

                                                                                                    break;

                                                                                                case '120+':
                                                                                                    echo '120+ g/l (Sweet)';

                                                                                                    break;

                                                                                                default:
                                                                                                    echo 'Unknown';
                                                                                            }

                                                                                        @endphp

                                                                                </div> -->

                                    </div>

                                </div>
                                <div class="col-12">
                                    <div class="wine-notes my-3 py-3 border-top border-bottom">
                                        <p class="mb-1"><span class="theme-color fw-bold">Bottle Notes:
                                            </span></p>
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

                        <div class="wine-recommend-sec my-5" style="max-width:1100px">

                            <div class="sec-head">

                                <h3 class="fw-bold theme-color fs-4">You May Also Like</h3>

                            </div> <!-- Wine Slider Start -->

                            <div class="wine-recommend-slider">
                                @if (count($sliders))
                                    @foreach ($sliders as $wine)
                                        <div class="wine-inner-sec text-center p-3 rounded"> <!-- Wine Thumbnail -->

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

                                            </div> <!-- Wine Information -->

                                            <div class="wine-info mt-3">

                                                <h5 class="fw-bold mb-1"><a
                                                        href="{{ route('winery-shop.detail', ['wineid' => $wine->id, 'shopid' => $wine->vendor_id, 'vendorid' => $vendorid]) }}">{{ $wine->series }}

                                                        ({{ $wine->vintage_date ?? 'N/A' }})
                                                    </a>

                                                </h5>

                                                <p class="wine-price fw-bold">${{ number_format($wine->price, 2) }}</p>

                                                <!-- Add to Cart Button -->
                                                @if ($vendor->account_status == 1)
                                                    <div
                                                        class="d-flex align-items-center justify-content-center gap-2 flex-column ">
                                                        <div class="add-wines-cart d-flex align-items-center">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input p-0 wine-type-slider"
                                                                    type="radio" name="wineOptions{{ $loop->index }}"
                                                                    id="inlineRadio2_{{ $loop->index }}" value="case">
                                                                <label class="form-check-label d-flex align-items-center"
                                                                    for="inlineRadio2_{{ $loop->index }}">
                                                                    Case
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input p-0 wine-type-slider"
                                                                    type="radio" name="wineOptions{{ $loop->index }}"
                                                                    id="inlineRadio1_{{ $loop->index }}" value="bottle">
                                                                <label class="form-check-label"
                                                                    for="inlineRadio1_{{ $loop->index }}">
                                                                    Bottle
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="input-group w-50 mb-2">
                                                            <span class="input-group-btn">
                                                                <button type="button"
                                                                    class="quantity-left-minus btn btn-danger btn-number"
                                                                    data-type="minus" data-field="">
                                                                    <span class="glyphicon glyphicon-minus">-</span>
                                                                </button>
                                                            </span>
                                                            <input type="text" id="quantity" name="quantity"
                                                                class="form-control input-number quantity" value="1"
                                                                min="1" max="{{ $wine->inventory }}">
                                                            <span class="input-group-btn">
                                                                <button type="button"
                                                                    class="quantity-right-plus btn btn-success btn-number"
                                                                    data-type="plus" data-field="">
                                                                    <span class="glyphicon glyphicon-plus">+</span>
                                                                </button>
                                                            </span>
                                                        </div>
                                                        <div class="cart-btn text-end"> <a href="javascript:void(0)"
                                                                data-id="{{ $wine->id }}"
                                                                class="btn wine-btn add-to-cart-slider"
                                                                data-quantity="{{$wine->inventory > 12 ? 12 : 1}}">Add to Cart</a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="text-center"> <a href="{{ route('winery-shop.detail', ['wineid' => $wine->id, 'shopid' => $wine->vendor_id, 'vendorid' => $vendorid]) }}"
                                                            class="btn wine-btn" data-quantity="1">View Details</a>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    @endforeach
                                @endif

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
            $(document).on("click", "input[name='wineOptions']", function() {
                var wineType = $(this).val();
                var quantity = wineType === "case" ? 12 : 1;

                // Find the specific product container (adjust this selector if needed)
                var addToCartButton = $(".add-to-cart");

                // Set data-quantity on the Add to Cart button based on wine type
                addToCartButton.attr('data-quantity', quantity);
            });
            $(document).on("click", ".add-to-cart", function() {

                var productId = $(this).data('id');

                var quantity_type = $(this).attr('data-quantity');

                var quantity = $(this).closest('.d-flex').find('.quantity').val();

                quantity = parseInt(quantity_type) * parseInt(quantity);

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
                        var response = xhr.responseJSON;
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


            $(document).on("click", ".wine-type-slider", function() {
                var wineType = $(this).val();
                var $currentWineContainer = $(this).closest('.d-flex').parent()
                    .parent(); // Locate the current wine item container

                // Find the specific "Add to Cart" button within this wine item container
                var $addToCartBtn = $currentWineContainer.find('.add-to-cart-slider');

                // console.log("Selected wine type:", wineType);
                // console.log("Add to Cart button found:", $addToCartBtn.length > 0);

                if ($addToCartBtn.length > 0) {
                    if (wineType === 'bottle') {
                        $addToCartBtn.attr('data-quantity', 1);
                    } else if (wineType === 'case') {
                        $addToCartBtn.attr('data-quantity', 12);
                    }
                    // console.log("Updated data-quantity:", $addToCartBtn.attr('data-quantity'));
                } else {
                    // console.log("Error: Add to Cart button not found.");
                }
            });
            $(document).on("click", ".add-to-cart-slider", function() {

                var productId = $(this).data('id');

                var quantity_type = $(this).attr('data-quantity');
                var quantity = $(this).closest('.d-flex').find('.quantity').val();
                quantity = parseInt(quantity_type) * parseInt(quantity);

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
                        var response = xhr.responseJSON;
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
