<div class="col-lg-4 col-sm-6">
    <div class="event-card">
        <div class="event-thumbnail position-relative">
            @php $youtubeId = ''; @endphp

            @if (!empty($event->image) && Str::contains($event->image, 'youtube'))
                @php
                    parse_str(parse_url($event->image, PHP_URL_QUERY), $youtubeParams);
                    $youtubeId = $youtubeParams['v'] ?? null;
                @endphp
                @if ($youtubeId)
                    <iframe style="border-radius: 20px" class="lazyload" width="100%" height="250"
                        src="https://www.youtube.com/embed/{{ $youtubeId }}" allowfullscreen></iframe>
                @endif
            @else
                @if (!empty($event->thumbnail_small))
                    <img src="{{ Storage::url($event->thumbnail_small) }}"
                        data-src="{{ !empty($event->thumbnail_medium) ? Storage::url($event->thumbnail_medium) : Storage::url($event->thumbnail_small) }}"
                        alt="Event Image" class="img-fluid image-loader lazyload" />
                @elseif(!empty($event->vendor->mediaLogo->vendor_media))
                    <img src="{{ asset($event->vendor->mediaLogo->vendor_media) }}"
                        data-src="{{ asset($event->vendor->mediaLogo->vendor_media) }}"
                        alt="Event Image" class="img-fluid image-loader lazyload" />
                @else
                    <img src="{{ asset('images/vendorbydefault.png') }}" alt="Event Image"
                        class="img-fluid image-loader lazyload" />
                @endif
            @endif

            <div class="d-flex align-items-center justify-content-between gap-1 p-2">
                <div>
                    <p class="event-date mb-0 fw-bold" @if ($youtubeId) style="bottom:6px;" @endif>
                        @php
                            $startDate = $event->start_date ? \Carbon\Carbon::parse($event->start_date) : null;
                            $endDate = $event->end_date ? \Carbon\Carbon::parse($event->end_date) : null;
                        @endphp
                        @if ($startDate)
                            {{ $startDate->format('d M Y') }}
                            @if ($endDate && $endDate->gt($startDate)) onwards @endif
                        @endif

                        @if (!empty($event->start_time))
                            {{ \Carbon\Carbon::parse($event->start_time)->format('H:i A') }}
                        @endif
                    </p>
                </div>
                <div>
                    @if ($event->is_free == 1)
                        <p class="event-price fw-bold mb-0">Free</p>
                    @else
                        <p class="event-price fw-bold mb-0">
                            @php
                                $platform_fee = $event->vendor->event_platform_fee ?? '0.00';
                            @endphp
                            {{ !empty($event->price_type == 1) ? 'Variable Pricing' : '' }}
                            {{ !empty($event->admittance) ? '$' . number_format($event->admittance + ($event->admittance * $platform_fee) / 100, 2, '.', '') : '' }}{{ $event->extension }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <div class="event-info p-2 pt-0 d-flex flex-column justify-content-between">
            <div>
                <p class="event-sub-head mb-1">{{ $event->vendor->vendor_name }} </p>
                <div class="d-flex align-items-center justify-content-between gap-1 mb-2">
                    <h5 class="theme-color fw-bold mb-0">{{ $event->name }}</h5>
                </div>
                <p class="event-desc">{{ Str::limit($event->description, 100) }}</p>
            </div>
            <div>
                @if (!empty($event->booking_url))
                    <a href="{{ $event->booking_url }}" target="_blank"
                        class="btn px-3">{{ $event->vendor->account_status == 1 ? 'Buy Now' : 'View Details' }}</a>
                @else
                    <a href="{{ route('events.detail', $event->id) }}"
                        class="btn px-3">{{ $event->vendor->account_status == 1 ? 'Buy Now' : 'View Details' }}</a>
                @endif
            </div>
        </div>
    </div>
</div>
