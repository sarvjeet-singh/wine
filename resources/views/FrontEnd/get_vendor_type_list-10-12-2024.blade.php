@if (count($vendors))
    @php
        $enablehr = 0;
        $enablehr1 = 0;
        $bedsheetarray = [
            '2' => '1 Bed / Sleeps 2',
            '4' => '2 Bed / Sleeps 4',
            '6' => '3 Bed / Sleeps 6',
            '8+' => '4+ Bed / Sleeps 8+',
        ];
    @endphp
    @foreach ($vendors as $vendorkey => $vendor)
        @if ($vendor->account_status == '1')
            @php
                $enablehr = 1;
            @endphp
        @endif

        @if ($enablehr == 1 && $vendor->account_status == '2')
            <div style="clear:both">
            </div>
            <!-- <hr> -->
            @php
                $enablehr = 0;
                $enablehr1 = 1;
            @endphp
        @endif
        @if (($enablehr1 == 1 || $enablehr == 1) && $vendor->account_status == '3')
            <div style="clear:both">
            </div>
            <!-- <hr> -->
            @php
                $enablehr = 0;
                $enablehr1 = 0;
            @endphp
        @endif
        <div class="col-lg-6">
            <div
                class="property-box {{ strtolower($vendor->vendor_type) == 'winery' ? 'wine' : '' }} {{ strtolower($vendor->vendor_type) == 'accommodation' || strtolower($vendor->vendor_type) == 'excursion' ? 'accommodation' : '' }}  {{ $vendor->account_status == '2' || $vendor->account_status == '1' ? 'has-after' : '' }}">
                <div class="property-slider">
                    @if ($vendor->mediaGallery->isNotEmpty() && $vendor->account_status == 1)
                        @foreach ($vendor->mediaGallery as $media)
                            <div class="item">
                                <div class="inner-box">
                                    @if ($media->vendor_media_type === 'youtube')
                                        <iframe width="100%" height="300px" src="{{ $media->vendor_media }}"
                                            frameborder="0" allowfullscreen></iframe>
                                    @elseif ($media->vendor_media_type === 'image')
                                        <img src="{{ asset($media->vendor_media) }}" alt="Image" class="img-fluid">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="item">
                            @if (!empty($vendor->mediaLogo))
                                <img src="{{ asset($vendor->mediaLogo->vendor_media) }}" class="img-fluid"
                                    alt="Property Image">
                            @elseif($vendor->mediaGallery->isNotEmpty())
                                <img src="{{ asset($vendor->mediaGallery[0]->vendor_media) }}" class="img-fluid"
                                    alt="Property Image">
                            @elseif ($vendor->vendor_media_logo)
                                <img src="{{ asset($vendor->vendor_media_logo) }}" class="img-fluid"
                                    alt="Property Image">
                            @else
                                <img src="{{ asset('images/vendorbydefault.png') }}" class="img-fluid"
                                    alt="Property Image">
                            @endif
                        </div>
                    @endif
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
                    <h5 class="theme-color fs-6 mb-0">
                        @if (strtolower($vendor->vendor_type) == 'winery')
                            {{ !empty($vendor->sub_regions->name) ? $vendor->sub_regions->name : '' }}
                        @else
                            {{ !empty($vendor->sub_category->name) ? $vendor->sub_category->name : '' }}
                        @endif
                    </h5>

                    <div class="rating-star d-flex align-items-center"
                        data-rating="{{ $vendor->reviews->avg('rating') ?? 0.0 }}"></div>
                </div>
                <div class="property-name">
                    @if ($vendor->account_status == '1')
                        @php
                            $urll = '';
                            if (strtolower($vendor->vendor_type) == 'accommodation') {
                                $urll = route('accommodation-details', ['vendorslug' => $vendor->vendor_slug]);
                            } elseif (strtolower($vendor->vendor_type) == 'winery') {
                                $urll = route('winery-details', ['vendorslug' => $vendor->vendor_slug]);
                            } elseif (strtolower($vendor->vendor_type) == 'excursion') {
                                $urll = route('excursion-details', ['vendorslug' => $vendor->vendor_slug]);
                            }
                        @endphp
                        <a href="{{ $urll }}" class="fw-bold">{{ $vendor->vendor_name }}
                            @if (strtolower($vendor->vendor_type) == 'winery')
                                {!! !empty($vendor->sub_category->name)
                                    ? '<span class="theme-color">[' . $vendor->sub_category->name . ']</span>'
                                    : '' !!}
                            @endif
                        </a>
                    @else
                        <a class="vendorinqurey fw-bold" data-id="{{ $vendor->id }}">
                            {{ $vendor->vendor_name }}
                            @if (strtolower($vendor->vendor_type) == 'winery')
                                {!! !empty($vendor->sub_category->name)
                                    ? '<span class="theme-color">[' . $vendor->sub_category->name . ']</span>'
                                    : '' !!}
                            @endif
                        </a>
                    @endif
                </div>
                <div class="info d-flex align-items-baseline gap-2 mb-2">
                    <i class="fa-solid fa-location-dot theme-color"></i>
                    <p class="mb-0">
                        @if ($vendor->hide_street_address == 0)
                            {{ $vendor->street_address }},
                            <br>
                        @endif {{ $vendor->city }}, {{ $vendor->province }},
                        {{ $vendor->postalCode }}<br>
                        {{ !empty($vendor->countryName->name) ? $vendor->countryName->name : '' }}
                    </p>
                </div>
                <div class="info d-flex align-items-baseline gap-2 mb-2">
                    <i class="fa-solid fa-phone theme-color"></i>
                    <p class="mb-0"><a class="text-decoration-none text-dark"
                            href="tel:{{ $vendor->vendor_phone }}">{{ $vendor->vendor_phone }}</a></p>
                </div>
                <p class="desc mb-3">{{ $vendor->description }}</p>
                <ul class="room-info-inner heading d-flex justify-content-between list-unstyled p-0 pt-3 gap-1">
                    @if (strtolower($vendor->vendor_type) == 'accommodation')
                        <li> Bedrooms</li>
                        <li>Washrooms</li>
                        <li>Beds / Sleeps</li>
                    @endif
                    @if (strtolower($vendor->vendor_type) == 'winery')
                        <li>Farming Practices</li>
                    @endif
                    @if (strtolower($vendor->vendor_type) == 'excursion' || strtolower($vendor->vendor_type) == 'winery')
                        <li>Max Group</li>
                    @endif
                    @if (strtolower($vendor->vendor_type) == 'excursion')
                        <li>Establishment/Facility</li>
                    @endif
                    @if (strtolower($vendor->vendor_type) == 'winery')
                        <li>Tasting</li>
                    @endif
                    @if (strtolower($vendor->vendor_type) == 'winery' ||
                            strtolower($vendor->vendor_type) == 'accommodation' ||
                            strtolower($vendor->vendor_type) == 'excursion')
                        <li>Price Point</li>
                    @endif
                </ul>
                <ul class="room-info-inner d-flex justify-content-between list-unstyled p-0 border-top pt-3 gap-1">

                    {{-- Accommodation Details --}}
                    @if (strtolower($vendor->vendor_type) == 'accommodation')
                        <li>
                            {{ !empty($vendor->accommodationMetadata->bedrooms) ? $vendor->accommodationMetadata->bedrooms : '-' }}
                        </li>
                        <li>
                            {{ !empty($vendor->accommodationMetadata->washrooms) ? $vendor->accommodationMetadata->washrooms : '-' }}
                        </li>
                        <li>
                            {{ !empty($vendor->accommodationMetadata->beds) && !empty($vendor->accommodationMetadata->sleeps)
                                ? $vendor->accommodationMetadata->beds . ' / ' . $vendor->accommodationMetadata->sleeps
                                : '-' }}
                        </li>
                    @endif

                    {{-- Winery Farming Practices --}}
                    @if (strtolower($vendor->vendor_type) == 'winery')
                        <li>
                            {{ !empty($vendor->wineryMetadata->farmingPractices->name) ? $vendor->wineryMetadata->farmingPractices->name : '-' }}
                        </li>
                    @endif

                    {{-- Max Group Size for Winery or Excursion --}}
                    @if (strtolower($vendor->vendor_type) == 'winery' || strtolower($vendor->vendor_type) == 'excursion')
                        <li>
                            {{ !empty($vendor->wineryMetadata->maxGroup->name) ? $vendor->wineryMetadata->maxGroup->name : '-' }}
                            {{ !empty($vendor->excursionMetadata->maxGroup->name) ? $vendor->excursionMetadata->maxGroup->name : '-' }}
                        </li>
                    @endif

                    {{-- Excursion Establishment --}}
                    @if (strtolower($vendor->vendor_type) == 'excursion')
                        <li>
                            {{ !empty($vendor->excursionMetadata->establishments->name) ? $vendor->excursionMetadata->establishments->name : '-' }}
                        </li>
                    @endif

                    {{-- Winery Tasting Options --}}
                    @if (strtolower($vendor->vendor_type) == 'winery')
                        <li>
                            {{ !empty($vendor->wineryMetadata->tastingOptions->name) ? $vendor->wineryMetadata->tastingOptions->name : '-' }}
                        </li>
                    @endif

                    {{-- Price Point --}}
                    @if (strtolower($vendor->vendor_type) == 'winery' ||
                            strtolower($vendor->vendor_type) == 'accommodation' ||
                            strtolower($vendor->vendor_type) == 'excursion')
                        <li>{{ !empty($vendor->pricePoint->name) ? explode(' ', $vendor->pricePoint->name)[0] : '-' }}
                        </li>
                    @endif
                </ul>
                <div class="d-flex gap-2">
                    @if ($vendor->business_hours_count > 0)
                        <button type="button" class="btn book-btn open-modal-btn" data-url="get-hours"
                            data-id="{{ $vendor->id }}">
                            Hour’s
                        </button>
                    @endif
                    {{-- @if (!Auth::check())
                    <button type="button" class="btn book-btn" id="login_form_btn"
                        data-bs-toggle="modal" data-bs-target="#loginPopup">Login</button>
                @else --}}
                    @if (!Auth::guard('vendor')->check())
                        @if ($vendor->account_status == '1')
                            <a href="{{ $urll }}" class="text-decoration-none text-white btn book-btn book-now-btn">Book
                                Now</a>
                        @else
                            <button class="btn book-btn vendorinqurey text-white" data-id="{{ $vendor->id }}">
                                Inquiry
                            </button>
                        @endif
                        @if (!Auth::guard('customer')->check())
                            <a href="{{ route('check-login') }}"
                                class="text-decoration-none text-white btn book-btn">Review</a>
                        @else
                            <a href="{{ route('user-review-submit') }}"
                                class="text-decoration-none text-white btn book-btn">Review</a>
                        @endif
                    @else
                        @if ($vendor->account_status == '1')
                            <a href="{{ $urll }}" class="text-decoration-none text-white btn book-btn">View
                                Detail</a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="col-lg-12">
        <div class="property-box px-3">
            @if (request('page') > 1)
                <p class="text-center no-more-records">No more records found.</p>
            @else
                <p class="text-center no-record-found">No records found.</p>
            @endif
        </div>
    </div>
@endif
</div>
{{-- <div class="row">
    <div class="col-sm-12">
        <div class="pagination pagination-container">
            {{ $vendors->links() }}
        </div>
    </div>
</div> --}}
