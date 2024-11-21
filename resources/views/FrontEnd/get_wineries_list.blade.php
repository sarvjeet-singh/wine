@if (count($vendors))
    @php
        $enablehr = 0;
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
            <hr>
            @php
                $enablehr = 0;
            @endphp
        @endif
        <div class="col-lg-6">
            <div class="property-box px-3">
                <div class="property-slider">
                    @if ($vendor->mediaGallery->isNotEmpty())
                        @foreach ($vendor->mediaGallery as $media)
                            <div class="item">
                                @if ($media->vendor_media_type === 'youtube')
                                    <iframe width="100%" height="300px" src="{{ $media->vendor_media }}" frameborder="0"
                                        allowfullscreen></iframe>
                                @elseif ($media->vendor_media_type === 'image')
                                    <img src="{{ asset($media->vendor_media) }}" alt="Image" class="img-fluid">
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="item">
                            <img src="{{ asset('images/vendorbydefault.png') }}" class="img-fluid" alt="Property Image">
                        </div>
                    @endif
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
                    <h5 class="theme-color fs-6 mb-0">{{ !empty($vendor->sub_regions->name) ? $vendor->sub_regions->name : '' }}</h5>
                    <div class="rating-star d-flex align-items-center"
                        data-rating="{{ $vendor->reviews->avg('rating') ?? 0.0 }}"></div>
                </div>
                <div class="property-name">
                    <p class="fw-bold">{{ $vendor->vendor_name }} [{{ !empty($vendor->sub_category->name) ? $vendor->sub_category->name : ' ' }}]</p>
                </div>
                <div class="info d-flex align-items-baseline gap-2 mb-2">
                    <i class="fa-solid fa-location-dot theme-color"></i>
                    <p class="mb-0">
                        @if ($vendor->hide_street_address == 0)
                            {{ $vendor->street_address }},
                            <br>
                            @endif {{ $vendor->city }}, {{ $vendor->province }}, {{ $vendor->postalCode }}<br>
                            @if ($vendor->country == 'CA')
                                Canada
                            @endif
                    </p>
                </div>
                <div class="info d-flex align-items-baseline gap-2 mb-2">
                    <i class="fa-solid fa-phone theme-color"></i>
                    <p class="mb-0"><a class="text-decoration-none text-dark"
                            href="tel:{{ $vendor->vendor_phone }}">{{ $vendor->vendor_phone }}</a></p>
                </div>
                <p class="desc mb-3">{{ $vendor->description }}</p>
                <ul class="room-info-inner d-flex justify-content-between list-unstyled p-0 pt-3 gap-1">
                    <li><span class="theme-color"></span> Farming Practices</li>
                    <li>Max Group Size</li>
                    <li>Tasting</li>
                    <li>Price Point</li>
                </ul>
                <ul class="room-info-inner d-flex justify-content-between list-unstyled p-0 border-top pt-3 gap-1">
                    <li><span class="theme-color"></span>{{ !empty($vendor->wineryMetadata->farmingPractices->name) ? $vendor->wineryMetadata->farmingPractices->name : '' }}</li>
                    <li>{{ !empty($vendor->wineryMetadata->maxGroup->name) ? $vendor->wineryMetadata->maxGroup->name : '' }}</li>
                    <li>{{ !empty($vendor->wineryMetadata->tastingOptions->name) ? $vendor->wineryMetadata->tastingOptions->name : '' }}</li>
                    <li>$</li>
                </ul>
                <div class="d-flex gap-2">
                    @if ($vendor->business_hours_count > 0)
                        <button type="button" class="btn book-btn open-modal-btn" data-url="get-hours" data-id="{{ $vendor->id }}">
                            Hour’s
                        </button>
                    @endif
                    <button class="btn book-btn vendorinqurey" data-id="{{ $vendor->id }}">
                        <!-- Inquiry -->
                        <a href="javascript:void(0)" class="text-decoration-none text-white">Inquiry</a>
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
<div class="row">
    <div class="col-sm-12">
        <div class="pagination pagination-container">
            {{ $vendors->links() }}
        </div>
    </div>
</div>