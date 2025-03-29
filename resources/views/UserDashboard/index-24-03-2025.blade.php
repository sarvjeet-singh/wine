@extends('FrontEnd.layouts.mainapp')

@section('title', 'Wine Country Weekends - User Dashboard')

@section('content')
    <style>
        .image-container {
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .zoomable-image {
            display: block;
            width: 100%;
            height: auto;
            transition: transform 0.2s ease-in-out;
        }

        .zoomable-image:hover {
            transform: scale(1.1);
            /* Slightly increase scale on hover */
        }

        /* Lightbox overlay */
        .lightbox-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            z-index: 999;
            justify-content: center;
            align-items: center;
        }

        .lightbox-content {
            position: relative;
        }

        .lightbox-image {
            height: 500px;
            width: 500px;
            display: block;
            margin: 0 auto;
            min-height: 100px;
            min-width: 100px;
        }

        .close-button {
            position: absolute;
            top: -39px;
            right: -43px;
            color: #fff;
            font-size: 35px;
            cursor: pointer;
        }

        #proof-images {
            display: none;
        }
    </style>
    <div class="container main-container">
        <div class="row flex-lg-nowrap flex-wrap g-4">
            @include('UserDashboard.includes.leftNav')
            <div class="col right-side">
                <div class="row g-3">
                    <!-- <div class="col-xl-3 col-6">
                                <div class="top-boxes">
                                    <div class="box-image">
                                        <img src="{{ asset('images/icons/bottle-bucks-box-icon.png') }}">
                                    </div>
                                    <div class="box-points">0 Events</div>
                                    <div class="box-text mt-1">Today</div>
                                </div>
                            </div> -->
                    <div class="col-xl-3 col-6">
                        <a href="{{ route('wallet-history') }}">
                            <div class="top-boxes">
                                <div class="box-image">
                                    <img src="{{ asset('images/icons/amount-box-icon.png') }}">
                                </div>
                                <div class="box-points">${{ $balance }}</div>
                                <div class="box-text">Bottle Bucks</div>
                            </div>
                        </a>
                    </div>
                    <!-- <div class="col-xl-3 col-6">
                                <div class="top-boxes">
                                    <div class="box-image">
                                        <img src="{{ asset('images/icons/messages-box-icon.png') }}">
                                    </div>
                                    <div class="box-points">1 + 0</div>
                                    <div class="box-text">Prize Pools</div>
                                </div>
                            </div> -->
                    <div class="col-xl-3 col-6">
                        <div class="top-boxes">
                            <div class="box-image">
                                <img src="{{ asset('images/icons/reviews-box-icon.png') }}">
                            </div>
                            <div class="box-points">{{ reviewsCount() }}</div>
                            <div class="box-text">Reviews Submitted</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-6">
                        <div class="top-boxes">
                            <div class="box-image">
                                <img src="{{ asset('images/icons/reviews-box-icon.png') }}">
                            </div>
                            <div class="box-points">{{ approvedReviewsCount() }}</div>
                            <div class="box-text">Approved Reviews</div>
                        </div>
                    </div>
                </div>
                <!-- User Profile Box Start -->
                <div class="row mt-5">
                    @if (empty(Auth::user()->profile_image))
                        <div class="col-12">
                            <h5 class="fw-bold mb-3 theme-color">Please upload a profile headshot so your testimonials &
                                reviews can be publicly posted.</h5>
                        </div>
                    @endif
                    <div class="col-sm-12">
                        <div class="information-box">
                            <div class="information-box-head grey-head">
                                <div class="box-head-heading d-flex">
                                    <span class="box-head-label theme-color">User Profile</span>
                                    <a href="{{ route('user-settings') }}" class="information-box-edit">
                                        <i class="fa-solid fa-pencil box-edit-icon"></i> Edit
                                    </a>
                                </div>
                                <div class="box-head-description mt-3">
                                    Upload a headshot to qualify for your Testimonials & Reviews to be publicly viewed.
                                </div>
                            </div>
                            <div class="information-box-body">
                                <div class="box-body-label">
                                    {{ Auth::user()->profile_image ? 'Profile Image' : 'Upload Profile Image' }}</div>
                                <div class="row g-3 mt-sm-3 mt-2">
                                    <div class="col-md-4 profile-parent">
                                        <img src="{{ Auth::user()->profile_image ? asset('images/UserProfile/' . Auth::user()->profile_image) : asset('images/UserProfile/default-profile.png') }}"
                                            class="box-userprofile-image">
                                        @if (Auth::user()->profile_image_verified == 'verified')
                                            <div class="verify-icon">
                                                <img src="{{ asset('images/icons/profile-verify-icon.png') }}"
                                                    class="verify-image">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-sm-4 mb-sm-0 mb-2">
                                                <div class="box-body-label">Given Name(s):</div>
                                                <div class="box-body-information">{{ Auth::user()->firstname }}</div>
                                            </div>
                                            <div class="col-sm-3 mb-sm-0 mb-2">
                                                <div class="box-body-label">Last/Surname:</div>
                                                <div class="box-body-information">{{ Auth::user()->lastname }}</div>
                                            </div>
                                            <div class="col-sm-5 mb-sm-0 mb-2">
                                                <div class="box-body-label">Email: @if (!empty(Auth::user()->email_verified_at))
                                                        <i class="fas fa-check-circle text-success"
                                                            title="Email Verified"></i>
                                                    @endif
                                                </div>
                                                <div class="box-body-information">{{ Auth::user()->email }}</div>
                                            </div>


                                        </div>
                                        <div class="row mt-sm-5">
                                            <div class="col-sm-4 mb-sm-0 mb-2">
                                                <div class="box-body-label">Age Range:</div>
                                                <div class="box-body-information">{{ Auth::user()->age_range }}</div>
                                            </div>
                                            <div class="col-sm-3 mb-sm-0 mb-2">
                                                <div class="box-body-label">Date of Birth</div>
                                                <div class="box-body-information">{{ Auth::user()->date_of_birth }}</div>
                                            </div>
                                            <div class="col-sm-5 mb-sm-0 mb-2">
                                                <div class="box-body-label">Gender:</div>
                                                <div class="box-body-information">{{ Auth::user()->gender }}</div>
                                            </div>

                                        </div>
                                        <div class="row mt-sm-5">
                                            <div class="col-sm-4 mb-sm-0 mb-2">
                                                <div class="box-body-label">Member Since</div>
                                                <div class="box-body-information">
                                                    {{ toLocalTimezone(Auth::user()->created_at, getUserTimezone()) }}
                                                </div>
                                            </div>
                                            <div class="col-sm-3 mb-sm-0 mb-2">
                                                <div class="box-body-label">User Role:</div>
                                                <div class="box-body-information">Member</div>
                                            </div>
                                            <div class="col-sm-5 mb-sm-0 mb-2">
                                                <div class="box-body-label">My Socials:</div>
                                                @if (Auth::user()->facebook != '')
                                                    <img src="{{ asset('images/FrontEnd/facebook.png') }}"
                                                        class="box-social-icon">
                                                @endif
                                                @if (Auth::user()->instagram != '')
                                                    <img src="{{ asset('images/FrontEnd/instagram.png') }}"
                                                        class="box-social-icon">
                                                @endif
                                                @if (Auth::user()->youtube != '')
                                                    <img src="{{ asset('images/FrontEnd/youtube.png') }}"
                                                        class="box-social-icon">
                                                @endif
                                                @if (Auth::user()->tiktok != '')
                                                    <img src="{{ asset('images/FrontEnd/tiktok.png') }}"
                                                        class="box-social-icon">
                                                @endif
                                                @if (Auth::user()->twitter != '')
                                                    <img src="{{ asset('images/FrontEnd/twitter-x.png') }}"
                                                        class="box-social-icon">
                                                @endif
                                                @if (Auth::user()->linkedin != '')
                                                    <img src="{{ asset('images/FrontEnd/linkedin.png') }}"
                                                        class="box-social-icon">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>



                        <!-- test<i class="fa-solid fa-pencil"></i> -->
                    </div>
                </div>
                <!-- User Profile Box End -->

                <!-- User Guest Registry Start -->
                <div class="row mt-5">
                    @if (Auth::user()->form_guest_registry_filled == 0)
                        <div class="col-12">
                            <h5 class="fw-bold mb-3 theme-color">Please complete the Guest Registry to process transactions and access your Bottle Bucks credits.</h5>
                        </div>
                    @endif
                    <div class="col-sm-12">
                        <div class="information-box guest-reg-sec">
                            <div class="information-box-head grey-head">
                                <div class="box-head-heading d-flex justify-content-between">
                                    <div class="d-flex align-items-center flex-md-nowrap flex-wrap gap-3">
                                        <span class="box-head-label theme-color">Guest Registry</span>
                                        @if (Auth::user()->government_proof_front != '' && Auth::user()->government_proof_back != '')
                                            <div
                                                class="self-check-verify d-flex align-items-center flex-md-nowrap flex-wrap gap-2">
                                                <img src="{{ asset('images/icons/verify-green-icon.png') }}"
                                                    class="verify-image">
                                                <p class="mb-0 fs-6 fw-bold">Self check-in verify</p>
                                            </div>
                                        @endif
                                    </div>
                                    <a href="{{ route('user-guest-registry') }}" class="information-box-edit">
                                        <i class="fa-solid fa-pencil box-edit-icon"></i> Edit
                                    </a>
                                </div>
                                <div class="box-head-description mt-3">
                                    Completing the Guest Registry section of your profile will provide details to satisfy
                                    our security protocols and allow you to book accommodations directly with our vendor
                                    partners saving on third-party fees.
                                </div>
                            </div>
                            <div class="information-box-body">
                                <div class="box-body-label mt-3 theme-color">Home / Default Delivery</div>
                                <div class="row mt-3">
                                    <div class="col-md-4 mb-sm-0 mb-2">
                                        <div class="box-body-label">Street Address:</div>
                                        <div class="box-body-information">{{ Auth::user()->street_address }}</div>
                                    </div>
                                    <div class="col-md-2 mb-sm-0 mb-2">
                                        <div class="box-body-label">Unit/Suite#:</div>
                                        <div class="box-body-information">{{ Auth::user()->suite }}</div>
                                    </div>
                                    <div class="col-md-3 mb-sm-0 mb-2">
                                        <div class="box-body-label">City/Town:</div>
                                        <div class="box-body-information">{{ Auth::user()->city }}</div>
                                    </div>
                                    <div class="col-md-3 mb-sm-0 mb-2">
                                        <div class="box-body-label">Province/State:</div>
                                        <div class="box-body-information">
                                            {{ Auth::user()->country == 'Other' ? Auth::user()->other_state : Auth::user()->state }}
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-sm-2">
                                        <div class="box-body-label">Postal Code/Zip:</div>
                                        <div class="box-body-information">{{ Auth::user()->postal_code }}</div>
                                    </div>
                                    <div class="col-md-4 mt-sm-2">
                                        <div class="box-body-label">Country:</div>
                                        <div class="box-body-information">
                                            {{ Auth::user()->country == 'Other' ? Auth::user()->other_country : Auth::user()->country }}
                                        </div>
                                    </div>
                                    <div class="col-md-4 mt-sm-2">
                                        <div class="box-body-label">Contact Ph#:</div>
                                        <div class="box-body-information">{{ Auth::user()->contact_number }}</div>
                                    </div>
                                </div>
                                @if (!empty(Auth::user()->government_proof_front))
                                    <div class="row mt-5">
                                        <div class="col-sm-12 text-sm-start text-center">
                                            <button id="show_id" class="btn wine-btn">View ID</button>
                                        </div>
                                    </div>
                                    <div class="row mt-3" id="proof-images">
                                        <div class="d-flex">
                                            <div class="col-sm-4">
                                                <div class="image-container">
                                                    <img src="images/GovermentProof/{{ Auth::user()->government_proof_front }}"
                                                        height="200px" width="200px" class="zoomable-image">
                                                </div>
                                            </div>
                                            {{-- <div class="col-sm-4">
                                            <div class="image-container">
                                                <img src="images/GovermentProof/{{ Auth::user()->government_proof_back }}"
                                                    height="200px" width="200px" class="zoomable-image">
                                            </div>
                                        </div> --}}
                                        </div>
                                    </div>
                                @else
                                    <div class="row mt-5">
                                        <div class="col-sm-12 text-sm-start text-center">
                                            <a href="{{ route('user-guest-registry') }}" class="btn wine-btn">Add
                                                Government ID Proof</a>
                                        </div>
                                    </div>
                                @endif
                                {{-- <div class="box-body-label mt-5">See Emergency Contact</div>
                                <div class="row mt-3">
                                    <div class="col-sm-4">
                                        <div class="box-body-label">Contact Name:</div>
                                        <div class="box-body-information">{{ Auth::user()->emergency_contact_name }}</div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="box-body-label">Contact Relation:</div>
                                        <div class="box-body-information">{{ Auth::user()->emergency_contact_relation }}</div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="box-body-label">Contact Phone:</div>
                                        <div class="box-body-information">{{ Auth::user()->emergency_contact_phone_number }}</div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- User Profile Box End -->
            </div>
        </div>
    </div>

    @if ($first_login)
        <!-- Modal -->
        <div class="modal fade" id="bottleBucks" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center pb-4">
                        <img src="{{ asset('images/icons/clapping.png') }}">
                        <h3 class="fw-bold mt-4">Congrats</h3>
                        <p class="fs-5">You have earned <span class="theme-color fw-bold">${{ $balance }}</span>
                            Bottle Bucks just
                            for registering</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @include('UserDashboard.includes.logout_modal')
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const zoomableImages = document.querySelectorAll('.zoomable-image');
            const overlay = document.createElement('div');
            overlay.className = 'lightbox-overlay';
            document.body.appendChild(overlay);

            zoomableImages.forEach(image => {
                image.addEventListener('click', function() {
                    const imageSrc = this.getAttribute('src');
                    const lightboxImage = document.createElement('img');
                    lightboxImage.src = imageSrc;
                    lightboxImage.className = 'lightbox-image';

                    const closeButton = document.createElement('span');
                    closeButton.innerHTML = '&times;';
                    closeButton.className = 'close-button';
                    closeButton.addEventListener('click', function() {
                        overlay.style.display = 'none';
                    });

                    const lightboxContent = document.createElement('div');
                    lightboxContent.className = 'lightbox-content';
                    lightboxContent.appendChild(closeButton);
                    lightboxContent.appendChild(lightboxImage);

                    overlay.innerHTML = ''; // Clear previous content
                    overlay.appendChild(lightboxContent);
                    overlay.style.display = 'flex';
                });
            });

            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.style.display = 'none';
                }
            });
            var toggleButton = document.getElementById('show_id');
            var proofImagesDiv = document.getElementById('proof-images');

            // Add click event listener to the button
            toggleButton.addEventListener('click', function() {
                // Check the current display state and toggle it
                if (proofImagesDiv.style.display === 'none' || proofImagesDiv.style.display === '') {
                    proofImagesDiv.style.display = 'block';
                } else {
                    proofImagesDiv.style.display = 'none';
                }
            });
        });
        setTimeout(() => {


            if ($("#bottleBucks").length > 0) {
                $("#bottleBucks").modal('show');
            }
        }, 1000);
    </script>
@endsection
