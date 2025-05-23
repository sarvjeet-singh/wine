@extends('FrontEnd.layouts.mainapp')

@section('content')
    <style>
        .wine-club-listing-sec .wine-btn {
            padding: 6px 20px;
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
            color: #bba253;
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

        .wine-detail-sec .wine-feature p {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 15px;
        }

        .wine-detail-sec .wine-feature p:nth-child(even) {
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

        .wine-inner-sec .wine-info .info p {
            color: #000;
        }

        .wine-inner-sec .wine-info .info svg {
            padding-top: 6px;
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

        @media screen and (max-width: 767px) {
            .wine-club-listing-sec form.wine-filtar-bar {
                flex-wrap: wrap;
            }

            .wine-club-listing-sec form.wine-filtar-bar>div,
            .wine-club-listing-sec form.wine-filtar-bar button {
                width: 100%;
            }
        }
    </style>

    <div class="container">
        <div class="wine-club-listing-sec py-3 mt-3 mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Wine Shop</li>
                </ol>
            </nav>
            <form action="" method="GET"
                class="wine-filtar-bar d-flex align-items-center justify-content-end gap-2 mb-4">

                <!-- Search Input -->
                {{-- <div>

                    <input type="search" id="search" class="form-control" name="search" placeholder="Winery Search"
                        value="{{ request('search') }}">

                </div>

                <div>

                    <input type="search" id="wine_search" class="form-control" name="wine_search" placeholder="Wine Search"
                        value="{{ request('wine_search') }}">

                </div> --}}

                <!-- Sub Category Dropdown -->

                {{-- <div>

                    <select class="form-select" name="sub_category" aria-label="Default select example">

                        <option value="">Select Sub Category</option>

                        @php $subCategories = getSubCategories(3); @endphp

                        @if (count($subCategories) > 0)
                            @foreach ($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}"
                                    {{ request('sub_category') == $subCategory->id ? 'selected' : '' }}>

                                    {{ $subCategory->name }}

                                </option>
                            @endforeach
                        @endif

                    </select>

                </div> --}}



                <!-- Sub Region Dropdown -->

                <div>

                    <select name="sub_region" class="form-select" aria-label="Default select example">

                        <option value="">Select Sub Region</option>

                        @php $subRegions = getSubRegions(1); @endphp

                        @if (count($subRegions) > 0)
                            @foreach ($subRegions as $subRegion)
                                <option value="{{ $subRegion->id }}"
                                    {{ request('sub_region') == $subRegion->id ? 'selected' : '' }}>

                                    {{ $subRegion->name }}

                                </option>
                            @endforeach
                        @endif

                    </select>

                </div>



                <div>

                    <button type="submit" class="btn btn-primary wine-btn rounded">Search</button>

                </div>

            </form>
            <div class="row g-4">
                @if (count($wineries) > 0)
                    @foreach ($wineries as $vendor)
                        <div class="col-lg-4 col-md-6">
                            <div class="wine-inner-sec p-3 rounded">
                                <a href="{{ route('frontend-shop.wines', $vendor->id) }}">
                                    <div class="wine-thumbnail text-center">
                                        @if ($vendor->mediaGallery->isNotEmpty())
                                            @php

                                                $defaultMedia = $vendor->mediaGallery->firstWhere(
                                                    'is_default',

                                                    1,
                                                );

                                            @endphp



                                            @if ($defaultMedia && $defaultMedia->vendor_media_type == 'image')
                                                <img src="{{ asset($defaultMedia->vendor_media) }}" class="img-fluid"
                                                    alt="Property Image">
                                            @else
                                                <img src="{{ asset('images/vendorbydefault.png') }}" class="img-fluid"
                                                    alt="Property Image">
                                            @endif
                                        @else
                                            <img src="{{ asset('images/vendorbydefault.png') }}" class="img-fluid"
                                                alt="Property Image">
                                        @endif
                                    </div>
                                    <div class="wine-info py-3 mt-2">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h6 class="wine-title mb-0 fw-bold">
                                                {{ $region->name ?? '' }}
                                            </h6>
                                        </div>
                                        <h5 class="fw-bold mb-1">{{ $vendor->vendor_name }} <span
                                                class="theme-color">[{{ $vendor->sub_regions->name ?? '' }}]</span>
                                        </h5>
                                        <div class="info d-flex gap-2 mb-2">
                                            <svg class="svg-inline--fa fa-location-dot theme-color" aria-hidden="true"
                                                focusable="false" data-prefix="fas" data-icon="location-dot" role="img"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                                <path fill="currentColor"
                                                    d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z">
                                                </path>
                                            </svg>
                                            <p class="mb-0">
                                                {{ $vendor->street_address }}<br>{{ $vendor->city }},

                                                {{ $vendor->province }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-end">
                        {{ $wineries->links('vendor.pagination.bootstrap-5') }}
                    </div>
                @else
                    <div class="col-md-12">

                        <div class="property-box px-3">

                            <p class="text-center no-record-found">No records found.</p>

                        </div>

                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
