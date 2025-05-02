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

        @media screen and (max-width: 767px) {
            .wine-club-listing-sec form {
                flex-wrap: wrap;
            }

            .wine-club-listing-sec form>div,
            .wine-club-listing-sec form button {
                width: 100%;
            }
        }
    </style>
    <div class="container">
        <div class="wine-club-listing-sec py-3 mt-3 mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('frontend-shop') }}">Wine Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $vendor->vendor_name }}</li>
                </ol>
            </nav>
            <div class="wine-filtar-bar d-flex align-items-center justify-content-md-end justify-content-start gap-2 mb-4">
                <form action="" method="GET" class="d-flex align-items-center gap-2">
                    <!-- Search Input -->

                    <div>
                        <input type="search" id="search" name="search" class="form-control" placeholder="Search"
                            value="{{ old('search', request()->get('search')) }}">
                    </div>
                    <!-- Date Dropdown -->

                    <div>
                        <select class="form-select" id="varietals" name="varietals[]" aria-label="Default select example"
                            multiple>
                            @if (count(getGrapeVarietals()) > 0)
                                @foreach (getGrapeVarietals() as $varietal)
                                    <option value="{{ $varietal->name }}"
                                        {{ is_array(request()->get('varietals')) && in_array($varietal->name, request()->get('varietals')) ? 'selected' : '' }}>
                                        {{ $varietal->name }}
                                    </option>
                                @endforeach
                            @endif

                        </select>
                    </div>

                    <div>
                        <select class="form-select" id="date" name="date" aria-label="Default select example">

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
                        <div class="col-lg-4 col-md-6">
                            <div class="wine-inner-sec p-3 rounded">
                                <div class="wine-thumbnail position-relative text-center">
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
                                    <p class="wine-size fw-bold fs-7 mb-0">{{ $wine->bottle_size }}</p>
                                </div>
                                <div class="wine-info add-wines-cart mt-2">
                                    <h5 class="fw-bold mb-1">{{ $wine->winery_name }}
                                        {{ !empty($wine->vintage_date) ? '(' . $wine->vintage_date . ')' : '' }}
                                    </h5>
                                    <div class="abv-value d-flex align-items-center justify-content-between gap-1">
                                        <h6 class="fs-7 mb-0 fw-bold">ABV</h6>
                                        <p class="fs-7 mb-0">{{ $wine->abv ? $wine->abv . '%' : '-' }}</p>
                                    </div>
                                    <div class="rs-value d-flex align-items-center justify-content-between gap-1">
                                        <h6 class="fs-7 mb-0 fw-bold">Residual Sugars</h6>
                                        <p class="fs-7 mb-0">
                                            @php
                                                $residualSugar = $wine->rs; // Residual sugar category
                                                $rsValue = $wine->rs_value; // Actual numeric value
                                                $rsValue =
                                                    $rsValue == (int) $rsValue
                                                        ? (int) $rsValue
                                                        : rtrim(rtrim($rsValue, '0'), '.');
                                                $label = '';
                                                switch ($residualSugar) {
                                                    case '0-1':
                                                        $label = 'Bone Dry';
                                                        break;
                                                    case '1-9':
                                                        $label = 'Dry';
                                                        break;
                                                    case '10-49':
                                                        $label = 'Off Dry';
                                                        break;
                                                    case '50-120':
                                                        $label = 'Semi-Sweet';
                                                        break;
                                                    case '120+':
                                                        $label = 'Sweet';
                                                        break;
                                                }

                                                if (!empty($rsValue)) {
                                                    echo $rsValue . 'g/l' . ($label ? " ({$label})" : '');
                                                } elseif ($label) {
                                                    echo $label;
                                                }
                                            @endphp
                                        </p>
                                    </div>
                                    <div class="varietal-values d-flex align-items-center justify-content-between gap-1">
                                        <h6 class="fs-7 mb-0 fw-bold">Varietal</h6>
                                        @php
                                            $grape_varietals = '-';
                                            if (!empty($wine->grape_varietals)) {
                                                $grape_varietals = explode(',', $wine->grape_varietals);
                                                $grape_varietals = $grape_varietals[0];
                                            }
                                        @endphp
                                        <p class="fs-7 mb-0">{{ $grape_varietals }}</p>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mt-3">
                                        <a href="{{ route('frontend-shop.wine-detail', ['id' => $wine->id, 'shopid' => $wine->vendor_id]) }}"
                                            class="btn wine-btn">View Details</a>
                                        <p class="wine-price fw-bold mb-0">
                                            ${{ number_format(winery_b2c_price($vendor, $wine), 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-end">
                    </div>
                @else
                    <div class="col-12" style="text-align: center;height: 100vh;">
                        No Wine Found
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#varietals').select2({
                placeholder: "Select Varietals",
                allowClear: true
            });
        });
    </script>
@endsection
