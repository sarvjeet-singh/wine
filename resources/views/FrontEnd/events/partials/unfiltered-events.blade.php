<div class="row g-4 mb-3">
    <div class="col-12">
        <div
            class="event-head position-relative d-flex align-items-center justify-content-between gap-1 py-2">
            <h3 class="mb-0 fw-bold">Today Events</h3>
            <div class="head-btn">
                <a href="{{ route('events') }}?date_filter[]=today" class="btn view-btn">View All</a>
            </div>
        </div>
    </div>
    @if (!empty($todayEvents) && count($todayEvents) > 0)
        @foreach ($todayEvents as $todayEvent)
            <div class="col-lg-4 col-sm-6">
                <div class="event-card">
                    <div class="event-thumbnail position-relative">
                        {{-- <div class="fb-loader"></div> --}}
                        @php
                            $youtubeId = '';
                        @endphp
                        @if (!empty($todayEvent->image) && Str::contains($todayEvent->image, 'youtube'))
                            @php
                                // Extract YouTube video ID
                                parse_str(
                                    parse_url($todayEvent->image, PHP_URL_QUERY),
                                    $youtubeParams,
                                );
                                $youtubeId = $youtubeParams['v'] ?? null;
                            @endphp
                            @if ($youtubeId)
                                <iframe style="border-radius: 20px" class="lazyload" width="100%"
                                    height="250"
                                    src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                    allowfullscreen>
                                </iframe>
                            @endif
                        @else
                            @if (!empty($todayEvent->thumbnail_small))
                                <img src="{{ Storage::url($todayEvent->thumbnail_small) }}"
                                    data-src="{{ !empty($todayEvent->thumbnail_medium) ? Storage::url($todayEvent->thumbnail_medium) : Storage::url($todayEvent->thumbnail_small) }}"
                                    alt="Event Image" class="img-fluid image-loader lazyload" />
                            @elseif(!empty($todayEvent->vendor->mediaLogo->vendor_media))
                                <img src="{{ asset($todayEvent->vendor->mediaLogo->vendor_media) }}"
                                    data-src="{{ asset($todayEvent->vendor->mediaLogo->vendor_media) }}"
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
                                        $startDate = $todayEvent->start_date ? \Carbon\Carbon::parse($todayEvent->start_date) : null;
                                        $endDate = $todayEvent->end_date ? \Carbon\Carbon::parse($todayEvent->end_date) : null;
                                    @endphp
                                
                                    @if ($startDate)
                                        {{ $startDate->format('d M Y') }}
                                
                                        @if ($endDate && $endDate->gt($startDate))
                                            onwards
                                        @endif
                                    @endif
                                
                                    @if (!empty($todayEvent->start_time))
                                        {{ \Carbon\Carbon::parse($todayEvent->start_time)->format('H:i A') }}
                                    @endif
                                </p>
                            </div>
                            <div>
                                @if ($todayEvent->is_free == 1)
                                    <p class="event-price fw-bold mb-0">
                                        Free
                                    </p>
                                @else
                                    <p class="event-price fw-bold mb-0">
                                        @php
                                            $platform_fee =
                                                $todayEvent->vendor->event_platform_fee ??
                                                '0.00';
                                        @endphp
                                        {{ !empty($todayEvent->admittance) ? '$'. number_format($todayEvent->admittance + ($todayEvent->admittance * $platform_fee) / 100, 2, '.', '') : '' }}{{ $todayEvent->extension }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="event-info p-2 pt-0 d-flex flex-column justify-content-between">
                    <div>
                        <p class="event-sub-head mb-1">{{ $todayEvent->vendor->vendor_name }} </p>
                        <div class="d-flex align-items-center justify-content-between gap-1 mb-2">
                            <h5 class="theme-color fw-bold mb-0">{{ $todayEvent->name }}</h5>
                        </div>
                        <p class="event-desc">{{ Str::limit($todayEvent->description, 100) }}</p>
                    </div>
                    <div>
                        @if (!empty($todayEvent->booking_url))
                            <a href="{{ $todayEvent->booking_url }}"  target="_blank" class="btn px-3">{{ $todayEvent->vendor->account_status == 1 ? 'Buy Now' : 'View Details' }}</a>
                        @else
                            <a href="{{ route('events.detail', $todayEvent->id) }}"
                                class="btn px-3">{{ $todayEvent->vendor->account_status == 1 ? 'Buy Now' : 'View Details' }}</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>No events available.</p>
    @endif
</div>
<div class="row g-4 mb-3">
    <div class="col-12">
        <div
            class="event-head position-relative d-flex align-items-center justify-content-between gap-1 py-2">
            <h3 class="mb-0 fw-bold">Tomorrow Events</h3>
            <div class="head-btn">
                <a href="{{ route('events') }}?date_filter[]=tomorrow" class="btn view-btn">View
                    All</a>
            </div>
        </div>
    </div>
    @if (!empty($tomorrowEvents) && count($tomorrowEvents) > 0)
        @foreach ($tomorrowEvents as $tomorrowEvent)
            <div class="col-lg-4 col-sm-6">
                <div class="event-card">
                    <div class="event-thumbnail position-relative">
                        @php
                            $youtubeId = '';
                        @endphp
                        @if (!empty($tomorrowEvent->image) && Str::contains($tomorrowEvent->image, 'youtube'))
                            @php
                                // Extract YouTube video ID
                                parse_str(
                                    parse_url($tomorrowEvent->image, PHP_URL_QUERY),
                                    $youtubeParams,
                                );
                                $youtubeId = $youtubeParams['v'] ?? null;
                            @endphp
                            @if ($youtubeId)
                                <iframe style="border-radius: 20px" class="lazyload" width="100%"
                                    height="250"
                                    src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                    allowfullscreen>
                                </iframe>
                            @endif
                        @else
                            @if (!empty($tomorrowEvent->thumbnail_small))
                                <img src="{{ Storage::url($tomorrowEvent->thumbnail_small) }}"
                                    data-src="{{ !empty($tomorrowEvent->thumbnail_medium) ? Storage::url($tomorrowEvent->thumbnail_medium) : Storage::url($tomorrowEvent->thumbnail_small) }}"
                                    alt="Event Image" class="img-fluid image-loader lazyload" />
                            @elseif(!empty($tomorrowEvent->vendor->mediaLogo->vendor_media))
                                <img src="{{ asset($tomorrowEvent->vendor->mediaLogo->vendor_media) }}"
                                    data-src="{{ asset($tomorrowEvent->vendor->mediaLogo->vendor_media) }}"
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
                                        $startDate = $tomorrowEvent->start_date ? \Carbon\Carbon::parse($tomorrowEvent->start_date) : null;
                                        $endDate = $tomorrowEvent->end_date ? \Carbon\Carbon::parse($tomorrowEvent->end_date) : null;
                                    @endphp
                                
                                    @if ($startDate)
                                        {{ $startDate->format('d M Y') }}
                                
                                        @if ($endDate && $endDate->gt($startDate))
                                            onwards
                                        @endif
                                    @endif
                                
                                    @if (!empty($tomorrowEvent->start_time))
                                        {{ \Carbon\Carbon::parse($tomorrowEvent->start_time)->format('H:i A') }}
                                    @endif
                                </p>
                            </div>
                            <div>
                                @if ($tomorrowEvent->is_free == 1)
                                    <p class="event-price fw-bold mb-0">
                                        Free
                                    </p>
                                @else
                                    <p class="event-price fw-bold mb-0">
                                        @php
                                            $platform_fee =
                                                $tomorrowEvent->vendor->event_platform_fee ??
                                                '0.00';
                                        @endphp
                                        {{ !empty($tomorrowEvent->admittance) ? '$'. number_format($tomorrowEvent->admittance + ($tomorrowEvent->admittance * $platform_fee) / 100, 2, '.', '') : '' }}{{ $tomorrowEvent->extension }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="event-info p-2 pt-0 d-flex flex-column justify-content-between">
                    <div>
                        <p class="event-sub-head mb-1">{{ $tomorrowEvent->vendor->vendor_name }} </p>
                        <div class="d-flex align-items-center justify-content-between gap-1 mb-2">
                            <h5 class="theme-color fw-bold mb-0">{{ $tomorrowEvent->name }}</h5>
                        </div>
                        <p class="event-desc">{{ Str::limit($tomorrowEvent->description, 100) }}</p>
                    </div>
                    <div>
                        @if (!empty($tomorrowEvent->booking_url))
                            <a href="{{ $tomorrowEvent->booking_url }}"  target="_blank" class="btn px-3">{{ $tomorrowEvent->vendor->account_status == 1 ? 'Buy Now' : 'View Details' }}</a>
                        @else
                            <a href="{{ route('events.detail', $tomorrowEvent->id) }}"
                                class="btn px-3">{{ $tomorrowEvent->vendor->account_status == 1 ? 'Buy Now' : 'View Details' }}</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>No events available.</p>
    @endif
</div>
<div class="row g-4 mb-3">
    <div class="col-12">
        <div
            class="event-head position-relative d-flex align-items-center justify-content-between gap-1 py-2">
            <h3 class="mb-0 fw-bold">Upcoming Events</h3>
            <div class="head-btn">
                <a href="{{ route('events') }}?date_filter[]=upcoming" class="btn view-btn">View
                    All</a>
            </div>
        </div>
    </div>
    @if (!empty($upcomingEvents) && count($upcomingEvents) > 0)
        @foreach ($upcomingEvents as $upcomingEvent)
            <div class="col-lg-4 col-sm-6">
                <div class="event-card">
                    <div class="event-thumbnail position-relative">
                        @php
                            $youtubeId = '';
                        @endphp
                        @if (!empty($upcomingEvent->image) && Str::contains($upcomingEvent->image, 'youtube'))
                            @php
                                // Extract YouTube video ID
                                parse_str(
                                    parse_url($upcomingEvent->image, PHP_URL_QUERY),
                                    $youtubeParams,
                                );
                                $youtubeId = $youtubeParams['v'] ?? null;
                            @endphp
                            @if ($youtubeId)
                                <iframe style="border-radius: 20px" class="lazyload" width="100%"
                                    height="250"
                                    src="https://www.youtube.com/embed/{{ $youtubeId }}"
                                    allowfullscreen>
                                </iframe>
                            @endif
                        @else
                            @if (!empty($upcomingEvent->thumbnail_small))
                                <img src="{{ Storage::url($upcomingEvent->thumbnail_small) }}"
                                    data-src="{{ !empty($upcomingEvent->thumbnail_medium) ? Storage::url($upcomingEvent->thumbnail_medium) : Storage::url($upcomingEvent->thumbnail_small) }}"
                                    alt="Event Image" class="img-fluid image-loader lazyload" />
                            @elseif(!empty($upcomingEvent->vendor->mediaLogo->vendor_media))
                                <img src="{{ asset($upcomingEvent->vendor->mediaLogo->vendor_media) }}"
                                    data-src="{{ asset($upcomingEvent->vendor->mediaLogo->vendor_media) }}"
                                    alt="Event Image" class="img-fluid image-loader lazyload" />
                            @else
                                <img src="{{ asset('images/vendorbydefault.png') }}"
                                    alt="Event Image" class="img-fluid image-loader lazyload" />
                            @endif
                        @endif
                        <div class="d-flex align-items-center justify-content-between gap-1 p-2">
                            <div>
                                <p class="event-date mb-0 fw-bold" @if ($youtubeId) style="bottom:6px;" @endif>
                                    @php
                                        $startDate = $upcomingEvent->start_date ? \Carbon\Carbon::parse($upcomingEvent->start_date) : null;
                                        $endDate = $upcomingEvent->end_date ? \Carbon\Carbon::parse($upcomingEvent->end_date) : null;
                                    @endphp
                                
                                    @if ($startDate)
                                        {{ $startDate->format('d M Y') }}
                                
                                        @if ($endDate && $endDate->gt($startDate))
                                            onwards
                                        @endif
                                    @endif
                                
                                    @if (!empty($upcomingEvent->start_time))
                                        {{ \Carbon\Carbon::parse($upcomingEvent->start_time)->format('H:i A') }}
                                    @endif
                                </p>
                            </div>
                            <div>
                                @if ($upcomingEvent->is_free == 1)
                                    <p class="event-price fw-bold mb-0">
                                        Free
                                    </p>
                                @else
                                    <p class="event-price fw-bold mb-0">
                                        @php
                                            $platform_fee =
                                                $upcomingEvent->vendor->event_platform_fee ??
                                                '0.00';
                                        @endphp
                                        {{ !empty($upcomingEvent->admittance)
                                            ? '$' . number_format($upcomingEvent->admittance + ($upcomingEvent->admittance * $platform_fee) / 100, 2, '.', '')
                                            : '' }}
                                        {{ $upcomingEvent->extension }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="event-info p-2 pt-0 d-flex flex-column justify-content-between">
                    <div>
                        <p class="event-sub-head mb-1">{{ $upcomingEvent->vendor->vendor_name }} </p>
                        <div class="d-flex align-items-center justify-content-between gap-1 mb-2">
                            <h5 class="theme-color fw-bold mb-0">{{ $upcomingEvent->name }}</h5>
                        </div>
                        <p class="event-desc">{{ Str::limit($upcomingEvent->description, 100) }}</p>
                    </div>
                    <div>
                        @if (!empty($upcomingEvent->booking_url))
                            <a href="{{ $upcomingEvent->booking_url }}" target="_blank" class="btn px-3">{{ $upcomingEvent->vendor->account_status == 1 ? 'Buy Now' : 'View Details' }}</a>
                        @else
                            <a href="{{ route('events.detail', $upcomingEvent->id) }}"
                                class="btn px-3">{{ $upcomingEvent->vendor->account_status == 1 ? 'Buy Now' : 'View Details' }}</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>No events available.</p>
    @endif
</div>