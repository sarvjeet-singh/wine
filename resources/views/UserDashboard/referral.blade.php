@extends('FrontEnd.layouts.mainapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')
    <div class="container main-container">
        <div class="row flex-lg-nowrap flex-wrap g-4">
            @include('UserDashboard.includes.leftNav')
            <div class="col right-side">
                <!-- User Referral section Start -->
                <div class="row mt-5" id="referral">
                    <div class="col-sm-12">
                        <div class="information-box">
                            <div class="information-box-head">
                                <div class="box-head-heading d-flex">
                                    <span class="box-head-label theme-color">Referral</span>
                                </div>
                                <div class="box-head-description">
                                    What caused you to join our community and Guest Rewards program?
                                </div>
                            </div>
                            <div class="information-box-body">
                                <!-- @if ($errors->any())
                                                                                        <div class="alert alert-danger">
                                                                                            <ul>
                                                                                                @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
                                                                                            </ul>
                                                                                        </div>
                                                                                    @endif -->

                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <form action="{{ route('user.settings.refferral.update') }}" method="post">
                                    @csrf
                                    <div class="row mt-3 g-md-3 g-1">
                                        <div class="col-md-4 col-12">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="guestrewards form-check-input radio-button"
                                                        name="guestrewards" value="Search Engine Results"
                                                        @if (Auth::user()->guestrewards == 'Search Engine Results') checked @endif
                                                        @if (!empty(Auth::user()->guestrewards)) disabled @endif> Search Engine
                                                    Results
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="guestrewards form-check-input radio-button"
                                                        name="guestrewards" value="Word of Mouth"
                                                        @if (Auth::user()->guestrewards == 'Word of Mouth') checked @endif
                                                        @if (!empty(Auth::user()->guestrewards)) disabled @endif> Word of Mouth
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="guestrewards form-check-input radio-button"
                                                        name="guestrewards" value="Other"
                                                        @if (Auth::user()->guestrewards == 'Other') checked @endif
                                                        @if (!empty(Auth::user()->guestrewards)) disabled @endif> Other
                                                </label>
                                                <input type="text"
                                                    @if (!empty(Auth::user()->guest_referral_other)) disabled @else style="display:none" @endif
                                                    class="guest_referral_other"
                                                    value="{{ Auth::user()->guest_referral_other }}"
                                                    name="guest_referral_other">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="guestrewards form-check-input radio-button"
                                                        name="guestrewards" value="Support Local Vendor"
                                                        @if (Auth::user()->guestrewards == 'Support Local Vendor') checked disabled @endif
                                                        @if (!empty(Auth::user()->guestrewards)) disabled @endif> Support Local
                                                    Vendor
                                                </label>
                                            </div>
                                            <div class="gurest_local_vendorlist"
                                                @if (Auth::user()->guestrewards == 'Support Local Vendor') style="display:block" @else style="display:none" @endif>
                                                @if (!empty(Auth::user()->guestrewards_vendor_id))
                                                    @php($vendor = App\Models\Vendor::find(Auth::user()->guestrewards_vendor_id))

                                                    <select class="form-control" name="guestrewards_vendor_id" disabled>
                                                        <option value="{{ $vendor->ID }}">{{ $vendor->vendor_name }}
                                                        <option> {{-- . ' - '.$vendor->buisnessstreet_address . ", " . $vendor->buisness_vendor_city --}}
                                                    </select>
                                                @else
                                                    <select id="business_vendor_name" class="form-control"
                                                        name="guestrewards_local_vendor_id"></select>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="guestrewards form-check-input radio-button"
                                                        name="guestrewards" value="Niagara Region Vendor"
                                                        @if (Auth::user()->guestrewards == 'Niagara Region Vendor') checked @endif
                                                        @if (!empty(Auth::user()->guestrewards)) disabled @endif> Niagara Region
                                                    Vendor
                                                </label>
                                            </div>
                                            <div class="gurest_vendorlist"
                                                @if (Auth::user()->guestrewards == 'Niagara Region Vendor') style="display:block" @endif>
                                                @if (!empty(Auth::user()->guestrewards_vendor_id))
                                                    @php($vendor = App\Models\Vendor::find(Auth::user()->guestrewards_vendor_id))

                                                    <select class="form-control" name="guestrewards_vendor_id" disabled>
                                                        <option value="{{ $vendor->ID }}">{{ $vendor->vendor_name }}
                                                        <option> {{-- . ' - '.$vendor->buisnessstreet_address . ", " . $vendor->buisness_vendor_city --}}
                                                    </select>
                                                @else
                                                    <select id="buisness_vendor_name" class="form-control"
                                                        name="guestrewards_vendor_id"></select>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-md-3 mt-1">
                                        <div class="col-12">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio" class="guestrewards form-check-input radio-button"
                                                        name="guestrewards" value="Social Media Content"
                                                        @if (Auth::user()->guestrewards == 'Social Media Content') checked disabled @endif
                                                        @if (!empty(Auth::user()->guestrewards)) disabled @endif> Social Media
                                                    Content
                                                </label>
                                            </div>
                                            <div class="gurest_social_media mt-2"
                                                @if (Auth::user()->guestrewards == 'Social Media Content') style="display:block" @endif>
                                                <div class="row g-2">
                                                    <div class="col-md-4">
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input radio-button"
                                                                    name="guestrewards_social_media" value="facebook"
                                                                    @if (Auth::user()->guestrewards_social_media == 'facebook') checked disabled @endif
                                                                    @if (!empty(Auth::user()->guestrewards)) disabled @endif>
                                                                Facebook
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-check form-check-inline SocialMediaParent">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input radio-button"
                                                                    name="guestrewards_social_media" value="instagram"
                                                                    @if (Auth::user()->guestrewards_social_media == 'instagram') checked disabled @endif
                                                                    @if (!empty(Auth::user()->guestrewards)) disabled @endif>
                                                                Instagram
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-check form-check-inline SocialMediaParent">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input radio-button"
                                                                    name="guestrewards_social_media" value="youtube"
                                                                    @if (Auth::user()->guestrewards_social_media == 'youtube') checked disabled @endif
                                                                    @if (!empty(Auth::user()->guestrewards)) disabled @endif>
                                                                YouTube
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-check form-check-inline SocialMediaParent">
                                                            <label class="form-check-label">
                                                                <input type="radio"
                                                                    class="form-check-input radio-button"
                                                                    name="guestrewards_social_media" value="tiktok"
                                                                    @if (Auth::user()->guestrewards_social_media == 'tiktok') checked disabled @endif
                                                                    @if (!empty(Auth::user()->guestrewards)) disabled @endif>
                                                                TikTok
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-check form-check-inline SocialMediaParent">
                                                            <label class="form-check-label">
                                                                <input type="radio"
                                                                    class="form-check-input radio-button"
                                                                    name="guestrewards_social_media" value="twitter"
                                                                    @if (Auth::user()->guestrewards_social_media == 'twitter') checked disabled @endif
                                                                    @if (!empty(Auth::user()->guestrewards)) disabled @endif>
                                                                Twitter
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-check form-check-inline SocialMediaParent">
                                                            <label class="form-label">
                                                                <input type="radio"
                                                                    class="form-check-input radio-button"
                                                                    name="guestrewards_social_media" value="linkdin"
                                                                    @if (Auth::user()->guestrewards_social_media == 'linkdin') checked disabled @endif
                                                                    @if (!empty(Auth::user()->guestrewards)) disabled @endif>
                                                                LinkedIn
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="guestreward_user"
                                        @if (Auth::user()->guestreward_user != '') style="display: block !important;" @else style="display: none !important;" @endif>
                                        <div class="row mt-3">
                                            <div class="col-sm-4 col-12">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input radio-button"
                                                            name="guestreward_user" value="David"
                                                            @if (Auth::user()->guestreward_user == 'David') checked @endif
                                                            @if (!empty(Auth::user()->guestrewards)) disabled @endif> David
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input radio-button"
                                                            name="guestreward_user" value="Avien"
                                                            @if (Auth::user()->guestreward_user == 'Avien') checked @endif
                                                            @if (!empty(Auth::user()->guestrewards)) disabled @endif> Avien
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="row mt-5">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" class="btn wine-btn">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- User Referral section End -->
            </div>
        </div>
    </div>
    @include('UserDashboard.includes.logout_modal')
@endsection
@section('js')
    <script>
        $('.guestrewards').change(function() {
            $(".gurest_vendorlist, .gurest_social_media, .guestreward_user, .gurest_local_vendorlist, .guest_referral_other")
                .hide();
            if ($(this).val() == "Niagara Region Vendor") {
                $(".gurest_vendorlist").show();
            } else if ($(this).val() == "Support Local Vendor") {
                $(".gurest_local_vendorlist").show();
            } else if ($(this).val() == "Search Engine Results") {} else if ($(this).val() ==
                "Social Media Content") {
                $(".gurest_social_media").show();
            } else if ($(this).val() == "Other") {
                $(".guest_referral_other").show();
            }
        });
        $('#buisness_vendor_name').select2({
            width: '100%',
            ajax: {
                type: "get",
                url: "{{ route('vendor_list') }}", // Update with your Laravel route URL
                dataType: 'json',
                processResults: function(data) {
                    var options = [];

                    // Format the data for Select2
                    for (var i = 0; i < data.length; i++) {
                        console.log(data);
                        options.push({
                            id: data[i].id,
                            text: data[i].text
                        });
                    }

                    return {
                        results: options
                    };
                },
                cache: true
            },
            minimumInputLength: 1
        });
        $('#business_vendor_name').select2({
            width: '100%',
            ajax: {
                type: "get",
                url: "{{ route('support_vendor_list') }}", // Update with your Laravel route URL
                dataType: 'json',
                processResults: function(data) {
                    var options = [];

                    // Format the data for Select2
                    for (var i = 0; i < data.length; i++) {
                        console.log(data);
                        options.push({
                            id: data[i].id,
                            text: data[i].text
                        });
                    }

                    return {
                        results: options
                    };
                },
                cache: true
            },
            minimumInputLength: 1
        });
        document.addEventListener("DOMContentLoaded", function() {
            // Check if URL contains "#referral"
            if (window.location.hash === "#referral") {
                const referralSection = document.getElementById("referral");
                const fixedMenuHeight = document.querySelector(".navbar")?.offsetHeight ||
                0; // Handle cases where .navbar might not exist

                function smoothScroll(target, duration) {
                    let targetPosition = target.getBoundingClientRect().top + window.scrollY - fixedMenuHeight -
                    40;
                    let startPosition = window.scrollY;
                    let startTime = null;

                    function animation(currentTime) {
                        if (startTime === null) startTime = currentTime;
                        let timeElapsed = currentTime - startTime;
                        let run = ease(timeElapsed, startPosition, targetPosition - startPosition, duration);
                        window.scrollTo(0, run);
                        if (timeElapsed < duration) requestAnimationFrame(animation);
                    }

                    function ease(t, b, c, d) {
                        t /= d / 2;
                        if (t < 1) return (c / 2) * t * t + b;
                        t--;
                        return (-c / 2) * (t * (t - 2) - 1) + b;
                    }

                    requestAnimationFrame(animation);
                }

                if (referralSection) {
                    setTimeout(() => {
                        smoothScroll(referralSection, 1000); // Scroll over 1 second
                    }, 500); // Small delay for better UX
                }
            }
        });
        $(document).ready(function() {
            
            $('input[name="guestrewards"]').change(function() {
                if ($(this).val() == "Social Media Content" && $('input[name="guestrewards_social_media"]')
                    .is(':checked') != false) {
                    $(".guestreward_user").show();
                }
            });
            $('input[name="guestrewards_social_media"]').change(function() {
                if ($(this).val() != "" && $('input[name="guestrewards"]').is(':checked') != false) {
                    $(".guestreward_user").show();
                }
            });
        });
    </script>
@endsection
