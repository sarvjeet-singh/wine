@if (count($vendors))
    @php
        $enablehr = 0;
        $bedsheetarray = [
            '2' => '1 Bed / Sleeps 2',
            '4' => '2 Bed / Sleeps 4',
            '6' => '3 Bed / Sleeps 6',
            '8+' => '4+ Bed / Sleeps 8+',
        ];
    @endphp
    @foreach ($vendors as $vendorkey => $vendor)
        @if ($vendor->account_status == 'Full Profile')
            @php
                $enablehr = 1;
            @endphp
        @endif

        @if ($enablehr == 1 && $vendor->account_status == 'Preliminary Profile')
            <div style="clear:both">
            </div>
            <!-- <hr> -->
            @php
                $enablehr = 0;
            @endphp
        @endif
        <div class="col-lg-6">
            <div class="property-box">
                <div class="property-slider">
                    @if ($vendor->mediaGallery->isNotEmpty())
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
                            @if ($vendor->vendor_media_logo)
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
                    <h5 class="theme-color fs-6 mb-0">{{ !empty($vendor->sub_regions->name) ? $vendor->sub_regions->name : '' }}</h5>
                    <div class="rating-star d-flex align-items-center"
                        data-rating="{{ $vendor->reviews->avg('rating') ?? 0.0 }}"></div>
                </div>
                <div class="property-name">
                    <a href="{{ route('accommodation-details', ['vendorslug' => $vendor->vendor_slug]) }}"
                        class="fw-bold">{{ $vendor->vendor_name }} [{{ !empty($vendor->sub_category->name) ? $vendor->sub_category->name : '' }}]</a>
                </div>
                <div class="info d-flex align-items-baseline gap-2 mb-2">
                    <i class="fa-solid fa-location-dot theme-color"></i>
                    <p class="mb-0">
                        @if ($vendor->hide_street_address == 0)
                            {{ $vendor->street_address }},
                            <br>
                            @endif {{ $vendor->city }}, {{ $vendor->province }}, {{ $vendor->postalCode }}<br>
                            {{ !empty($vendor->countryName->name) ? $vendor->countryName->name : '' }}
                    </p>
                </div>
                <div class="info d-flex align-items-baseline gap-2 mb-2">
                    <i class="fa-solid fa-phone theme-color"></i>
                    <p class="mb-0"><a class="text-decoration-none text-dark"
                            href="tel:{{ $vendor->vendor_phone }}">{{ $vendor->vendor_phone }}</a></p>
                </div>
                <p class="desc mb-3">{{ $vendor->description }}</p>
                <ul class="room-info-inner d-flex justify-content-between list-unstyled p-0 pt-3 gap-1">
                    <li> Bedrooms</li>
                    <li>Washrooms</li>
                    <li>Beds / Sleeps</li>
                    <li>Price Point</li>
                </ul>
                <ul class="room-info-inner d-flex justify-content-between list-unstyled p-0 border-top pt-3 gap-1">
                    <li>{{ !empty($vendor->accommodationMetadata->bedrooms) ? $vendor->accommodationMetadata->bedrooms . '' : '' }}
                    </li>
                    <li>{{ !empty($vendor->accommodationMetadata->washrooms) ? $vendor->accommodationMetadata->washrooms . '' : '' }}
                    </li>
                    <li>{{ !empty($vendor->accommodationMetadata->beds) && !empty($vendor->accommodationMetadata->sleeps)
                        ? $vendor->accommodationMetadata->beds . ' / ' . $vendor->accommodationMetadata->sleeps
                        : '' }}
                    </li>
                    <li class="theme-color">-</li>
                </ul>
                <div class="d-flex gap-2">
                    @if ($vendor->account_status == 'Full Profile')
                        <button class="btn book-btn">
                            <a href="{{ route('accommodation-details', ['vendorslug' => $vendor->vendor_slug]) }}"
                                class="text-decoration-none text-white">Book Now</a>
                        @else
                            <button class="btn book-btn vendorinqurey" data-id="{{ $vendor->id }}">
                                <!-- Inquiry -->
                                <a href="javascript:void(0)" class="text-decoration-none text-white">Inquiry</a>
                    @endif
                    </button>
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
<div class="row">
    <div class="col-sm-12">
        <div class="pagination pagination-container">
            {{ $vendors->links() }}
        </div>
    </div>
</div>
