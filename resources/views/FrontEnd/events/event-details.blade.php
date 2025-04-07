@extends('FrontEnd.layouts.mainapp')

@section('content')


    <!-- Event Single HTML Start -->
    <section class="event-single-wrapper my-sm-5 my-4">

        <div class="container">

            <div class="row flex-lg-row flex-column-reverse">

                <div class="col-lg-8">

                    <div class="event-info">

                        <div>

                            <h6 class="vendor-name mb-0 fw-bold">{{ $event->vendor->vendor_name }}</h6>

                        </div>

                        <h2 class="theme-color my-2">{{ $event->name }}</h2>

                        <p class="mb-sm-1 mb-2 event-address">{{ $event->address }}, {{ $event->city }},

                            {{ $event->state }}, {{ $event->zipcode }}</p>

                        <p class="mb-0 event-timing">

                            <span>{{ \Carbon\Carbon::parse($event->start_date)->format('D d M Y') }} -

                                {{ \Carbon\Carbon::parse($event->end_date)->format('D d M Y') }}</span> | Starts at

                            <span>{{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}</span> |

                            <span>

                                {{ intdiv($event->duration, 60) }} {{ intdiv($event->duration, 60) == 1 ? 'hr' : 'hrs' }}

                                {{ $event->duration % 60 }} {{ $event->duration % 60 == 1 ? 'min' : 'mins' }}

                            </span>

                        </p>

                        <p class="event-price fw-bold my-2">

                            @if ($event->is_free == 1)
                                Free
                            @else
                                @php
                                    $platform_fee =
                                        $event->vendor->platform_fee ?? (config('site.platform_fee') ?? '1.00');
                                @endphp
                                ${{ number_format($event->admittance + ($event->admittance * $platform_fee) / 100, 2, '.', '') }}{{ $event->extension }}
                            @endif

                        </p>

                        <div class="mt-4">

                            @if (!Auth::guard('customer')->check())
                                <a href="{{ route('check-login', 'book-now') }}" class="btn book-btn">Book Now</a>
                            @else
                                @if ($event->remaining_tickets > 0)
                                    <a href="{{ route('events.checkout', $event->id) }}" class="btn book-btn">Book Now</a>
                                @else
                                    <a href="javascript:void(0);" class="btn book-btn disabled">Booking Not Available</a>
                                @endif
                            @endif

                        </div>

                    </div>

                </div>

                <div class="col-lg-4">

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

                </div>

            </div>

            <div class="row">

                <div class="col-12">

                    <div class="about-event pt-4 mt-4">

                        <h4 class="fw-bold">About</h4>

                        <p>{{ $event->description ?? 'No description available.' }}</p>

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
