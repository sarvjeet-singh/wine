@extends('FrontEnd.layouts.mainapp')

@section('content')

    <style>
        .event-single-wrapper {
            padding: 0 15px;
        }
    </style>
    <!-- Event Single HTML Start -->
    @if (isset($preview) && $preview == 1)
        <div class="container-fluid" style="background-color: #fff3cd; color: #856404;">
            <div class="row">
                <div class="col-12" style="text-align: center;">
                    <div style="padding: 10px 15px; border: 1px solid #ffeeba; border-radius: 4px;">
                        <strong>Preview Mode:</strong> This is a preview of the event page. Changes are not live until
                        published and approved.
                    </div>
                </div>
            </div>
        </div>
    @endif
    <section class="event-single-wrapper my-5">

        <div class="container">

            <div class="row">
                <div class="col-12">
                    <h2 class="theme-color mb-3">{{ $event->name }}</h2>
                </div>
                <div class="col-lg-8">
                    <div class="event-featured-image mb-3">

                        @if (!empty($event->image) && Str::contains($event->image, 'youtube'))
                            @php

                                parse_str(parse_url($event->image, PHP_URL_QUERY), $youtubeParams);

                                $youtubeId = $youtubeParams['v'] ?? null;

                            @endphp

                            @if ($youtubeId)
                                <iframe style="border-radius: 20px" class="lazyload w-100" height="400"
                                    src="https://www.youtube.com/embed/{{ $youtubeId }}" allowfullscreen>

                                </iframe>
                            @endif
                        @else
                            <img src="{{ !empty($event->thumbnail_medium) ? Storage::url($event->thumbnail_medium) : asset('images/vendorbydefault.png') }}"
                                class="w-100 img-fluid" alt="Event Image" />
                        @endif

                    </div>
                    <div class="event-tags d-flex align-items-center gap-2">
                        @if (!empty($event->category->name))
                            <div>{{ $event->category->name ?? '' }}</div>
                        @endif
                        @if (!empty($event->genre->name))
                            <div>{{ $event->genre->name ?? '' }}</div>
                        @endif
                    </div>

                    <div class="about-event mt-sm-5 mt-4 pe-md-5">
                        <h4 class="mb-3 fw-bold">About The Event</h4>
                        <p>{{ $event->description ?? 'No description available.' }}</p>
                    </div>

                </div>

                <div class="col-lg-4">
                    <div class="event-info-box border rounded-4">
                        <ul class="list-unstyled">
                            <li class="organizer-name position-relative mb-3">
                                <i class="fa-regular fa-circle-user"></i>
                                {{ $event->vendor->vendor_name ?? 'Organizer' }}
                            </li>
                            <li class="event-timing position-relative mb-3">
                                <i class="fa-regular fa-calendar"></i>
                                <span>{{ !empty($event->start_date) ? \Carbon\Carbon::parse($event->start_date)->format('D d M Y') : 'No date specified' }}

                                    {{ !empty($event->end_date) && $event->end_date != $event->start_date ? ' - ' . \Carbon\Carbon::parse($event->end_date)->format('D d M Y') : '' }}</span>
                            </li>
                            <li class="start-timing position-relative mb-3">
                                <i class="fa-regular fa-clock"></i>
                                @if (!empty($event->booking_time))
                                    <span>Starts at
                                        {{ \Carbon\Carbon::parse($event->booking_time)->format('h:i A') }}</span>
                                @endif
                            </li>
                            <li class="event-duration position-relative mb-3">
                                <i class="fa-regular fa-hourglass-half"></i>
                                <span>
                                    @if ($event->duration > 0)
                                        {{ intdiv($event->duration, 60) }}
                                        {{ intdiv($event->duration, 60) == 1 ? 'hr' : 'hrs' }}

                                        @if ($event->duration % 60 > 0)
                                            {{ $event->duration % 60 }} {{ $event->duration % 60 == 1 ? 'min' : 'mins' }}
                                        @endif
                                    @else
                                        No duration specified
                                    @endif
                                </span>
                            </li>
                            <li class="age-restriction position-relative mb-3">
                                <i class="fa-solid fa-user"></i>
                                @if (!empty($event->event_rating))
                                    {{ $event->event_rating == 'family' ? 'Family' : 'Adult' }}
                                @else
                                    No Rating specified
                                @endif
                            </li>
                            <li class="event-type position-relative mb-3">
                                <i class="fa-solid fa-tag"></i>
                                {{ $event->category->name ?? '' }}
                            </li>
                            <li class="event-address position-relative mb-3">
                                <i class="fa-solid fa-location-dot"></i>
                                @if (!empty($event->address) || !empty($event->city) || !empty($event->state))
                                    {{ !empty($event->address) ? $event->address . ',' : '' }}
                                    {{ !empty($event->city) ? $event->city . ',' : '' }}
                                    {{ !empty($event->state) ? $event->state . ',' : '' }}
                                @else
                                    No address specified
                                @endif
                            </li>
                            <li class="venue-name position-relative mb-3">
                                <i class="fa-solid fa-map-location-dot"></i>
                                {{ $event->venue_name ?? 'No venue specified' }}
                            </li>
                        </ul>
                        <div class="d-flex align-items-center justify-content-between gap-1 border-top mt-4 pt-4">
                            <div class="event-price">
                                <p class="fw-bold mb-0">
                                    @if ($event->is_free == 1)
                                        Free Admittance
                                    @else
                                        @php
                                            $platform_fee =
                                                $event->vendor->event_platform_fee ??
                                                (config('site.platform_fee') ?? '0.00');
                                        @endphp
                                        {{ !empty($event->admittance) ? '$' . number_format($event->admittance + ($event->admittance * $platform_fee) / 100, 2, '.', '') : '' }}{!! !empty($event->extension) && !empty($event->admittance) ? '<span>' . $event->extension . '</span>' : '' !!}
                                    @endif
                                </p>
                            </div>
                            <div>
                                @if ($vendor->account_status == 1)
                                    @if (!Auth::guard('customer')->check())
                                        <a href="{{ route('check-login', 'book-now') }}" class="btn book-btn">Book Now</a>
                                    @else
                                        @if ($event->remaining_tickets > 0)
                                            <a href="{{ route('events.checkout', $event->id) }}" class="btn book-btn">Book
                                                Now</a>
                                        @else
                                            <a href="javascript:void(0);" class="btn book-btn disabled">Booking Not
                                                Available</a>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>

    @if ($relatedEvents->isNotEmpty())
        <section class="related-event-sec my-sm-5 my-4 pb-3">

            <div class="container">

                <div class="row">

                    <div class="col-12">

                        <div class="sec-head mb-3">

                            <h2 class="theme-color">Related Events</h2>

                        </div>

                    </div>

                    @foreach ($relatedEvents as $relatedEvent)
                        <div class="col-lg-4 col-md-6 mb-lg-0 mb-4">

                            <div class="event-card">

                                <div class="event-thumbnail position-relative">

                                    @if (!empty($relatedEvent->image) && Str::contains($relatedEvent->image, 'youtube'))
                                        @php

                                            parse_str(parse_url($relatedEvent->image, PHP_URL_QUERY), $youtubeParams);

                                            $youtubeId = $youtubeParams['v'] ?? null;

                                        @endphp

                                        @if ($youtubeId)
                                            <iframe style="border-radius: 20px" class="lazyload w-100" height="250"
                                                src="https://www.youtube.com/embed/{{ $youtubeId }}" allowfullscreen>

                                            </iframe>
                                        @endif
                                    @else
                                        <img src="{{ !empty($relatedEvent->thumbnail_medium) ? Storage::url($relatedEvent->thumbnail_medium) : asset('images/vendorbydefault.png') }}"
                                            class="w-100 img-fluid" alt="Event Image" />
                                    @endif

                                </div>

                                <div class="d-flex align-items-center justify-content-between gap-1 p-2">

                                    <div>

                                        <p class="event-date mb-0 fw-bold">

                                            {{ \Carbon\Carbon::parse($relatedEvent->start_date)->format('d M Y') }}

                                            {{ \Carbon\Carbon::parse($relatedEvent->start_time)->format('h:i A') }}

                                        </p>

                                    </div>

                                    <div>

                                        <p class="event-price fw-bold mb-0">

                                            @if ($relatedEvent->is_free == 1)
                                                Free
                                            @else
                                                ${{ $relatedEvent->admittance }}{{ $relatedEvent->extension }}
                                            @endif

                                        </p>

                                    </div>

                                </div>

                            </div>

                            <div class="event-info p-2 pt-0 d-flex flex-column justify-content-between">

                                <div>

                                    <p class="event-sub-head mb-1">

                                        {{ $relatedEvent->vendor->vendor_name ?? 'Unknown Vendor' }}</p>

                                    <div class="d-flex align-items-center justify-content-between gap-1 mb-2">

                                        <h5 class="theme-color fw-bold mb-0">{{ $relatedEvent->name }}</h5>

                                    </div>

                                    <p class="event-desc">{{ Str::limit($relatedEvent->description, 120, '...') }}</p>

                                </div>

                                <div>

                                    <a href="@if (!empty($relatedEvent->booking_url)) {{ $relatedEvent->booking_url }} @else {{ route('events.detail', $relatedEvent->id) }} @endif"
                                        class="btn px-3">Buy Now</a>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            </div>

        </section>
    @endif

    <!-- Event Single HTML End -->



    <!-- Event Single HTML End -->

@endsection
