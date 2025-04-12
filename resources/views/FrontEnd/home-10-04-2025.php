@extends('FrontEnd.layouts.mainapp')

@section('content')
    <!-- ========== Tab Sec Start ========== -->
    <!-- <section class="tab-content-sec px-sm-4 px-2">
        <div class="container-fluid">
            <div class="inner-content">
                <ul class="list-unstyled d-flex justify-content-between align-items-center mb-0 gap-3">
                    <li><a href="{{ route('accommodations') }}" class="text-decoration-none">Directories</a></li>
                    <li><a href="{{ route('accommodations') }}" class="text-decoration-none">Accommodations</a></li>
                    <li><a href="{{ route('excursion-listing') }}" class="text-decoration-none">Excursions</a></li>
                    <li><a href="{{ route('wineries-listing') }}" class="text-decoration-none">Wineries</a></li>
                    <li><a href="/licensed" class="text-decoration-none">Licensed</a></li>
                    <li><a href="/non-licensed" class="text-decoration-none">Non-Licensed</a></li>
                    <li><a href="/events" class="text-decoration-none">Events</a></li>
                </ul>
            </div>
        </div>
    </section> -->
    <!-- ========== Tab Sec End ========== -->

    <!-- ========== Banner Sec Start ========== -->
    <section class="banner-sec position-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-7">
                    <div class="sec-content">
                        <h3 class="fw-normal mb-4">THE PERFECT GETAWAY</h3>
                        <p>Your visit to the Niagara Region is the perfect opportunity to indulge a bit. Our team has
                            cultivated an extraordinary collection of vendor partners but the curated experience is where we
                            excel. Use our travel services platform to develop your own travel itinerary or let us help.</p>
                        <p class="fw-bold">Getting help is as easy as…</p>
                        <ul>
                            <li>Decide on your travel dates</li>
                            <li>Submit a booking inquiry</li>
                            <li>Await a response from one of our Experience Curators</li>
                        </ul>
                        <p>Whatever option you choose, join our <a
                                @if (!authCheck()['is_logged_in']) href="{{ route('register') }}" @else href="{{ route('guest-rewards') }}" @endif>Guest
                                Rewards</a> program for the best value and experience.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-5 m-auto text-center">
                    <div class="sec-btn mt-md-0 mt-3">
                        <button type="button">
                            <a
                                @if (!authCheck()['is_logged_in']) href="{{ route('register') }}" @else href="{{ route('guest-rewards') }}" @endif>Guest
                                Rewards <i class="fa-solid fa-angle-right"></i></a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========== Banner Sec End ========== -->

    <!-- ========== Premiere Accommodations Sec Start ========== -->
    <section class="text-with-img-sec position-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="sec-content">
                        <h3 class="fw-normal position-relative mb-4">PREMIERE<br> <i>ACCOMMODATIONS</i></h3>
                        <p>Visit wine country again for the 1st time!</p>
                        <p>Book your stay at our signature <a style="color: #8cbb00;"
                                href="https://winecountryweekends.ca/zjx0gcmx">Prospect House Niagara Falls</a> property
                            or any of our carefully vetted accommodation partners.</p>
                        <p>All of our hosts enjoy providing the highest calibre experience and as a group we pride ourselves
                            on consistently delivering what is expected but our hosts will often go above and beyond to
                            spoil you.</p>
                        <div class="sec-btn">
                            <a href="{{ route('accommodations') }}" class="border-btn">ACCOMMODATION OPTIONS <i
                                    class="fa-solid fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-lg-0 mt-5">
                    <div class="sec-slider">
                        <div class="premiere-accom-slider owl-carousel owl-theme">
                            <div class="item">
                                <img src="{{ asset('images/FrontEnd/img1.jpeg') }}" alt="Wine Country Weekends">
                            </div>
                            <div class="item">
                                <img src="{{ asset('images/FrontEnd/img2.jpeg') }}" alt="Wine Country Weekends">
                            </div>
                            <div class="item">
                                <img src="{{ asset('images/FrontEnd/img3.jpeg') }}" alt="Wine Country Weekends">
                            </div>
                            <div class="item">
                                <img src="{{ asset('images/FrontEnd/img4.jpeg') }}" alt="Wine Country Weekends">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========== Premiere Accommodations Sec End ========== -->

    <!-- ========== Explore Local Wineries Sec Start ========== -->
    <section class="local-wineries-sec position-relative">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="sec-head">
                        <h3 class="fw-normal position-relative mb-4">EXPLORE LOCAL<br> WINERIES</h3>
                        <button type="button">
                            <a href="{{ route('wineries-listing') }}" class="fw-bold">Local Wineries <i
                                    class="fa-solid fa-angle-right"></i></i></a>
                        </button>
                    </div>
                </div>
                <div class="col-lg-6 mt-lg-0 mt-5">
                    <div class="sec-content">
                        <p><span class="cap-letter">N</span>iagara-on-the-Lake & the Niagara Escarpment / Twenty Valley
                            sub-regions combine to offer nearly 100 local wineries to explore. Every winery has its own
                            story from its architecture and history to their current portfolio of wines.</p>
                        <p class="mb-sm-5 mb-2">When booking a tasting, be sure to ask about any premium experiences. The
                            wineries with the best stories often deliver the best experiences.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========== Explore Local Wineries Sec End ========== -->

    <!-- ========== Local Excursions Sec Start ========== -->
    <section class="text-with-img-sec position-relative my-sm-0 my-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="sec-img text-center">
                        <img src="{{ asset('images/FrontEnd/horse.jpg') }}" class="img-fluid" alt="Wine Country Weekends">
                    </div>
                </div>
                <div class="col-lg-6 mt-lg-0 mt-sm-5">
                    <div class="sec-content">
                        <h3 class="fw-normal position-relative mb-4">Local <i>Excursions</i></h3>
                        <p>We call it wine country but that’s not the whole story.</p>
                        <p>Road-trips, travel by boat or even a custom flight solution, we can help curate a unique and
                            memorable experience.<br>
                            After check-in guests may wish to take part in a personalized jeep wine safari, e-bike tour,
                            horseback trail riding, guided off-shore fishing or even a personal chef experience. Almost any
                            experience can be arranged, given enough notice.</p>
                        <div class="sec-btn">
                            <a href="{{ route('excursion-listing') }}" class="border-btn">Local Excursion <i
                                    class="fa-solid fa-angle-right"></i></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sec-btm-btn text-center position-relative">
                <button type="button">
                    <a
                        @if (!authCheck()['is_logged_in']) href="{{ route('register') }}" @else href="{{ route('guest-rewards') }}" @endif>Guest
                        Rewards <i class="fa-solid fa-arrow-right"></i></a>
                </button>
            </div>
        </div>
    </section>
    <!-- ========== Local Excursions Sec End ========== -->

    <!-- ========== Testimonials Sec Start ========== -->
    <section class="testi-sec">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="sec-head text-lg-end text-center">
                        <h4><i>Testimonials & <br><b>Reviews</b></i></h4>
                    </div>
                </div>
                <div class="col-lg-6 mt-lg-0 mt-5">
                    <div class="sec-slider">
                        <div class="testi-slider owl-carousel owl-theme">
                            @if (count($reviews))
                                @foreach ($reviews as $review)
                                    <div class="item">
                                        <p>{{ $review->review_description }}</p>
                                        <div class="testi-head">
                                            <p class="mb-0">{{ $review->vendor->vendor_name }}</p>
                                            <small>{{ $review->vendor->street_address }}</small>
                                            <div
                                                class="d-flex align-items-center justify-content-lg-start justify-content-center mt-3">
                                                <div class="user-img">
                                                    <img src="{{ isset($review->customer->profile_image) && $review->customer->profile_image ? asset('images/UserProfile/' . $review->customer->profile_image) : asset('images/UserProfile/default-profile.png') }}"
                                                        alt="User Pic">
                                                </div>
                                                <div class="user-name">
                                                    <p>{{ $review->customer->firstname ?? '' }}
                                                        {{ $review->customer->lastname ?? '' }}</p>
                                                    <div class="rating-star theme-color d-flex"
                                                        data-rating="{{ $review->avg('rating') ?? 0.0 }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========== Testimonials Sec End ========== -->

@endsection

@section('js')
    @if (config('site.google_search_console_tag'))
        <!-- Google Tag Manager -->
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '{{ config('site.google_search_console_tag') }}');
        </script>
        <!-- End Google Tag Manager -->

        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ config('site.google_search_console_tag') }}"
                height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    @endif
    <script>
        $('.premiere-accom-slider').owlCarousel({
            loop: true,
            items: 1,
            margin: 10,
            nav: false,
            dots: true,
            autoplay: true,
            autoplayTimeout: 4000 // 4 seconds
        });

        $('.testi-slider').owlCarousel({
            loop: true,
            items: 1,
            margin: 10,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 4000 // 4 seconds
        });
        // Get the client's timezone name
        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

        fetch('/set-timezone', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content') // For Laravel
                },
                body: JSON.stringify({
                    timezone: timezone
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log("Timezone saved successfully:", data);
            })
            .catch(error => console.error("Error saving timezone:", error));
    </script>
@endsection
