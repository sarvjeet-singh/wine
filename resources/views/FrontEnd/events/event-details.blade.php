@extends('FrontEnd.layouts.mainapp')
@section('content')
    <style>
        body :is(p, h1, h2, h3, h4, h5, h6) {
            color: #212529;
        }

        .theme-color {
            color: #c0a144 !important;
        }

        a.book-btn,
        a.book-btn:hover {
            background-color: #c0a144;
            color: #fff;
            padding: 10px 20px;
            border: 1px solid #c0a144;
            border-radius: 12px;
        }

        .event-single-wrapper,
        .related-event-sec {
            max-width: 1180px;
            margin-inline: auto;
        }

        .event-single-wrapper .event-featured-image img {
            height: 250px;
            object-fit: cover;
            border-radius: 15px;
        }

        .event-single-wrapper .event-price {
            font-size: 18px;
        }

        .event-single-wrapper .about-event {
            border-top: 0.5px solid #bba2535c;
        }

        /* Related Events CSS */
        .related-event-sec .event-thumbnail img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 20px;
        }

        .related-event-sec p.event-date,
        .related-event-sec .event-price {
            font-size: 15px;
        }

        .related-event-sec .event-info h5 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .related-event-sec p.event-desc {
            font-size: 15px;
            line-height: normal;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .related-event-sec .event-info a.btn {
            font-size: 15px;
            background-color: #3b8343;
            color: #fff;
        }


        @media screen and (max-width: 1024px) {
            .event-single-wrapper .event-featured-image img {
                height: 400px;
            }
        }

        @media screen and (max-width: 991px) {}

        @media screen and (max-width: 767px) {
            .event-single-wrapper .event-featured-image img {
                height: 180px;
            }

            .event-single-wrapper .event-price {
                font-size: 16px;
            }

            .event-single-wrapper .event-address,
            .event-single-wrapper .event-timing {
                font-size: 15px;
            }

            .event-single-wrapper .event-address {
                border-bottom: 0.5px solid #f4f4f4;
                padding-bottom: 6px;
            }
        }
    </style>
    <!-- Event Single HTML Start -->
    {{-- <section class="event-single-wrapper my-5">
        <div class="container">
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
                    <img src="{{ !empty($event->thumbnail_large) ? Storage::url($event->thumbnail_large) : asset('images/vendorbydefault.png') }}"
                        class="w-100 img-fluid" alt="Event Image" />
                @endif
            </div>

            <div class="event-info px-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="vendor-name mb-0 fw-bold">{{ $event->vendor->vendor_name }}</h6>
                    <p class="event-price mb-0 fw-bold">
                        @if ($event->is_free == 1)
                            Free
                        @else
                            ${{ $event->admittance }}{{ $event->extension }}
                        @endif
                    </p>
                </div>

                <div class="row align-items-center g-2">
                    <div class="col-md-9">
                        <h3 class="theme-color">{{ $event->name }}</h3>
                        <p class="mb-sm-0 mb-2 event-address">{{ $event->location ?? 'Location not available' }}</p>
                        <p class="mb-0 event-timing">
                            <span>{{ \Carbon\Carbon::parse($event->start_date)->format('D d M Y') }} -
                                {{ \Carbon\Carbon::parse($event->end_date)->format('D d M Y') }}</span> |
                            <span>{{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }} -
                                {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</span>
                        </p>
                    </div>
                    <div class="col-md-3 text-sm-end">
                        <form action="{{ route('events.checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <button type="submit" class="btn book-btn">Book Now</button>
                        </form>
                    </div>
                </div>

                <div class="about-event pt-3 mt-3">
                    <h4 class="fw-bold">About</h4>
                    <p>{{ $event->description ?? 'No description available.' }}</p>
                </div>
            </div>
        </div>
    </section> --}}


    <section class="event-single-wrapper my-sm-5 my-4">
        <div class="container">
            <div class="row flex-lg-row flex-column-reverse">
                <div class="col-lg-8">
                    <div class="event-info">
                        <div>
                            <h6 class="vendor-name mb-0 fw-bold">{{ $event->vendor->vendor_name }}</h6>
                        </div>
                        <h2 class="theme-color mb-0">{{ $event->name }}</h2>
                        <p class="mb-sm-0 mb-2 event-address">{{ $event->address }}, {{ $event->city }},
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
                        <p class="event-price fw-bold my-1">
                            @if ($event->is_free == 1)
                                Free
                            @else
                                ${{ $event->admittance }}{{ $event->extension }}
                            @endif
                        </p>
                        <div class="mt-3">
                            <form action="{{ route('events.checkout') }}" method="POST">
                                @csrf
                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                <button type="submit" class="btn book-btn">Book Now</button>
                            </form>
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
                    <div class="about-event pt-3 mt-3">
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
                                    <a href="@if (!empty($relatedEvent->booking_url)) {{ $relatedEvent->booking_url }} @else {{ route('events.detail', $relatedEvent->id) }} @endif" class="btn px-3">Buy Now</a>
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
