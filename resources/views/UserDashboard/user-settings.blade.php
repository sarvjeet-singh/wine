@extends('FrontEnd.layouts.mainapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')
    <style>
        .rcrop-outer-wrapper {
            opacity: .75;
        }

        .rcrop-outer {
            background: #000
        }

        .rcrop-croparea-inner {
            border: 1px dashed #fff;
        }

        .rcrop-handler-corner {
            width: 12px;
            height: 12px;
            background: none;
            border: 0 solid #51aeff;
        }

        .rcrop-handler-top-left {
            border-top-width: 4px;
            border-left-width: 4px;
            top: -2px;
            left: -2px
        }

        .rcrop-handler-top-right {
            border-top-width: 4px;
            border-right-width: 4px;
            top: -2px;
            right: -2px
        }

        .rcrop-handler-bottom-right {
            border-bottom-width: 4px;
            border-right-width: 4px;
            bottom: -2px;
            right: -2px
        }

        .rcrop-handler-bottom-left {
            border-bottom-width: 4px;
            border-left-width: 4px;
            bottom: -2px;
            left: -2px
        }

        .rcrop-handler-border {
            display: none;
        }

        .error {
            color: #dc3545;
        }

        .update-pwd-sec form div:has(.invalid-feedback) svg {
            display: none;
        }
    </style>
    <div class="container main-container">
        <div class="row flex-lg-nowrap flex-wrap g-4">
            @include('UserDashboard.includes.leftNav')
            <div class="col right-side">

                <!-- User Personal Information Start -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="information-box">
                            <div class="information-box-head">
                                <div class="box-head-heading d-flex">
                                    <span class="box-head-label theme-color">Personal Information</span>
                                </div>
                            </div>
                            <div class="information-box-body">
                                @if (session('profile-success'))
                                    <div class="alert alert-success">
                                        {{ session('profile-success') }}
                                    </div>
                                @endif
                                <form method="post" action="{{ route('user-settings-account-update') }}">
                                    @csrf
                                    <input type="hidden" id="profile-image" name="profile_image">
                                    <div class="box-body-label">Upload Profile Image</div>
                                    <div class="row mt-3 mb-3">
                                        <div class="col-12 col-sm-4 profile-image-section mb-sm-0 mb-3">
                                            <label for="profile_image" class="custom-file-label profile_image"><img
                                                    src="{{ asset('images/icons/upload_image_icon.png') }}"
                                                    width="20"><br>Add Image</label>
                                            <input type="file" id="profile_image" name="image"
                                                class="custom-file-input" accept="image/*">
                                        </div>
                                        <div class="col-12 col-sm-4" id="cropped-original">
                                            <img src="{{ Auth::user()->profile_image ? asset('images/UserProfile/' . Auth::user()->profile_image) : asset('images/UserProfile/default-profile.png') }}"
                                                class="box-userprofile-image">
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-sm-6 col-12 mb-sm-0 mb-3">
                                            <label class="form-label">First Name<span
                                                    class="required-filed">*</span></label>
                                            <input type="text"
                                                class="form-control @error('firstname') is-invalid @enderror"
                                                name="firstname" value="{{ old('firstname', Auth::user()->firstname) }}"
                                                placeholder="Enter your first name">
                                            @error('firstname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-sm-6 col-12">
                                            <label class="form-label">Last Name<span class="required-filed">*</span></label>
                                            <input type="text"
                                                class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                                                value="{{ old('lastname', Auth::user()->lastname) }}" placeholder="Enter your last name">
                                            @error('lastname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-sm-6 col-12 mb-sm-0 mb-3">
                                            <label class="form-label">Display Name<span
                                                    class="required-filed">*</span></label>
                                            <input type="text"
                                                class="form-control @error('display_name') is-invalid @enderror"
                                                name="display_name" value="{{ old('display_name', Auth::user()->display_name) }}"
                                                placeholder="Enter your Display name">
                                            @error('display_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label class="form-label">eMail Address<span
                                                    class="required-filed">*</span></label>
                                            <input type="email" class="form-control  @error('email') is-invalid @enderror"
                                                name="email" disabled value="{{ old('email', Auth::user()->email) }}"
                                                placeholder="Enter your eMail Address">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-sm-6 col-12 mb-sm-0 mb-3">
                                            <label class="form-label">Gender<span class="required-filed">*</span></label>
                                            <select class="form-control  @error('gender') is-invalid @enderror"
                                                name="gender">
                                                <option value="">Select gender</option>
                                                <option value="Male" @if (Auth::user()->gender == 'Male') selected @endif>
                                                    Male</option>
                                                <option value="Female" @if (Auth::user()->gender == 'Female') selected @endif>
                                                    Female</option>
                                                <option value="Other" @if (Auth::user()->gender == 'Other') selected @endif>
                                                    Other</option>
                                            </select>
                                            @error('gender')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label class="form-label">Age Range<span class="required-filed">*</span></label>
                                            <select class="form-control @error('age_range') is-invalid @enderror"
                                                name="age_range">
                                                <option value="">Select age range</option>
                                                <option value="0-18" @if (Auth::user()->age_range == '0-18') selected @endif>
                                                    0-18</option>
                                                <option value="19-29" @if (Auth::user()->age_range == '19-29') selected @endif>
                                                    19-29</option>
                                                <option value="30-39" @if (Auth::user()->age_range == '30-39') selected @endif>
                                                    30-39</option>
                                                <option value="40-49" @if (Auth::user()->age_range == '40-49') selected @endif>
                                                    40-49</option>
                                                <option value="50-59" @if (Auth::user()->age_range == '50-59') selected @endif>
                                                    50-59</option>
                                                <option value="60+" @if (Auth::user()->age_range == '60+') selected @endif>
                                                    60+</option>
                                            </select>
                                            @error('age_range')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-6 col-12">
                                            <label for="DOB" class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control" name="date_of_birth"
                                                value="{{ old('date_of_birth', Auth::user()->date_of_birth) }}"
                                                max="{{ now()->subYears(5)->format('m/d/Y') }}">
                                            @error('date_of_birth')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
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
                <!-- User Personal Information End -->


                <!-- User Social Media Start -->
                <div class="row mt-5">
                    <div class="col-sm-12">
                        <div class="information-box">
                            <div class="information-box-head">
                                <div class="box-head-heading d-flex">
                                    <span class="box-head-label theme-color">Social Media</span>
                                </div>
                                <div class="box-head-description mt-3">
                                    Please indicate your preferred social platform(s) and your handle on each
                                </div>
                            </div>
                            <div class="information-box-body">
                                <form method="post" action="{{ route('user-settings-social-update') }}"
                                    id="social-form">
                                    @csrf
                                    @if (session('social-success'))
                                        <div class="alert alert-success">
                                            {{ session('social-success') }}
                                        </div>
                                    @endif
                                    <div class="row mt-3 g-3">
                                        <div class="col-md-4 col-12">
                                            <input type="checkbox" class="custom-checkbox social-media-checkbox"
                                                id="Facebook" name="facebook_checkbox"
                                                {{ Auth::user()->facebook ? 'checked' : '' }}>
                                            <label for="Facebook">Facebook</label>
                                            <input type="text" class="form-control mt-2" id="facebook"
                                                name="facebook" {{ !Auth::user()->facebook ? 'disabled' : '' }}
                                                value="{{ Auth::user()->facebook }}"
                                                placeholder="Enter your Facebook username">
                                            <div class="error" id="facebook-error"></div>

                                        </div>
                                        <div class="col-md-4 col-12">
                                            <input type="checkbox" class="custom-checkbox social-media-checkbox"
                                                id="Instagram" name="instagram_checkbox"
                                                {{ Auth::user()->instagram ? 'checked' : '' }}>
                                            <label for="Instagram">Instagram</label>
                                            <input type="text" class="form-control mt-2" id="instagram"
                                                name="instagram" {{ !Auth::user()->instagram ? 'disabled' : '' }}
                                                value="{{ Auth::user()->instagram }}"
                                                placeholder="Enter your Instagram username">
                                            <div class="error" id="instagram-error"></div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <input type="checkbox" class="custom-checkbox social-media-checkbox"
                                                id="Youtube" name="youtube_checkbox"
                                                {{ Auth::user()->youtube ? 'checked' : '' }}>
                                            <label for="Youtube">Youtube</label>
                                            <input type="text" class="form-control mt-2" id="youtube"
                                                name="youtube" {{ !Auth::user()->youtube ? 'disabled' : '' }}
                                                value="{{ Auth::user()->youtube }}"
                                                placeholder="Enter your Youtube channel">
                                            <div class="error" id="youtube-error"></div>
                                        </div>
                                    </div>
                                    <div class="row mt-md-3 mt-1 g-3">
                                        <div class="col-md-4 col-12">
                                            <input type="checkbox" class="custom-checkbox social-media-checkbox"
                                                id="Tiktok" name="tiktok_checkbox"
                                                {{ Auth::user()->tiktok ? 'checked' : '' }}>
                                            <label for="Tiktok">Tik Tok</label>
                                            <input type="text" class="form-control mt-2" id="tiktok"
                                                name="tiktok" {{ !Auth::user()->tiktok ? 'disabled' : '' }}
                                                value="{{ Auth::user()->tiktok }}"
                                                placeholder="Enter your Tiktok username">
                                            <div class="error" id="tiktok-error"></div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <input type="checkbox" class="custom-checkbox social-media-checkbox"
                                                id="Twitter" name="twitter_checkbox"
                                                {{ Auth::user()->twitter ? 'checked' : '' }}>
                                            <label for="Twitter">Twitter</label>
                                            <input type="text" class="form-control mt-2" id="twitter"
                                                name="twitter" {{ !Auth::user()->twitter ? 'disabled' : '' }}
                                                value="{{ Auth::user()->twitter }}"
                                                placeholder="Enter your Twitter Username">
                                            <div class="error" id="twitter-error"></div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <input type="checkbox" class="custom-checkbox social-media-checkbox"
                                                id="Linkedin" name="linkedin_checkbox"
                                                {{ Auth::user()->linkedin ? 'checked' : '' }}>
                                            <label for="Linkedin">Linkedin</label>
                                            <input type="text" class="form-control mt-2" id="linkedin"
                                                name="linkedin" {{ !Auth::user()->linkedin ? 'disabled' : '' }}
                                                value="{{ Auth::user()->linkedin }}"
                                                placeholder="Enter your Linkedin username">
                                            <div class="error" id="linkedin-error"></div>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" class="btn wine-btn"
                                                id="update-button">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- User Social Media End -->



                <!-- User Emergency Contact Detail Start -->
                <div class="row mt-5">
                    <div class="col-sm-12">
                        <div class="information-box">
                            <div class="information-box-head">
                                <div class="box-head-heading d-flex">
                                    <span class="box-head-label theme-color">Emergency Contact Details</span>
                                </div>
                            </div>
                            <div class="information-box-body">
                                @if (session('emergency-success'))
                                    <div class="alert alert-success">
                                        {{ session('emergency-success') }}
                                    </div>
                                @endif
                                <form method="post" action="{{ route('user-settings-emergency-update') }}">
                                    @csrf
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <label class="form-label">Medical/Physical Concerns:<span
                                                    class="required-filed">*</span></label>
                                            <textarea class="form-control @error('medical_physical_concerns') is-invalid @enderror"
                                                name="medical_physical_concerns" placeholder="Enter your Medical/Physical Concerns">{{ Auth::user()->medical_physical_concerns }} </textarea>
                                            @error('medical_physical_concerns')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-md-3 mt-1 g-3">
                                        <div class="col-md-6 col-12">
                                            <label class="form-label">Contact Name<span
                                                    class="required-filed">*</span></label>
                                            <input type="text"
                                                class="form-control @error('emergency_contact_name') is-invalid @enderror"
                                                name="emergency_contact_name"
                                                value="{{ Auth::user()->emergency_contact_name }}"
                                                placeholder="Enter your Contact name">
                                            @error('emergency_contact_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <label class="form-label">Contact Relation<span
                                                    class="required-filed">*</span></label>
                                            <input type="text"
                                                class="form-control @error('emergency_contact_relation') is-invalid @enderror"
                                                name="emergency_contact_relation"
                                                value="{{ Auth::user()->emergency_contact_relation }}"
                                                placeholder="Enter your contact person relation">
                                            @error('emergency_contact_relation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-12">
                                            <label class="form-label">Phone Number<span
                                                    class="required-filed">*</span></label>
                                            <input type="text"
                                                class="form-control phone-number @error('emergency_contact_phone_number') is-invalid @enderror"
                                                name="emergency_contact_phone_number"
                                                value="{{ Auth::user()->emergency_contact_phone_number }}"
                                                placeholder="Enter your contact person number" id="phone-number">
                                            @error('emergency_contact_phone_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-md-3 mt-1 g-3">
                                        <div class="col-md-6 col-12">
                                            <label class="form-label">Alternate Contact Name<span
                                                    class="required-filed">*</span></label>
                                            <input type="text"
                                                class="form-control @error('alternate_contact_full_name') is-invalid @enderror"
                                                name="alternate_contact_full_name"
                                                value="{{ Auth::user()->alternate_contact_full_name }}"
                                                placeholder="Enter your alternate contact name">
                                            @error('alternate_contact_full_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <label class="form-label"> Alternate Contact Relation:<span
                                                    class="required-filed">*</span></label>
                                            <input type="text"
                                                class="form-control @error('alternate_contact_relation') is-invalid @enderror"
                                                name="alternate_contact_relation"
                                                value="{{ Auth::user()->alternate_contact_relation }}"
                                                placeholder="Enter your alter contact relation">
                                            @error('alternate_contact_relation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12 col-12">
                                            <label class="form-label">Alernative Contact Phone<span
                                                    class="required-filed">*</span></label>
                                            <input type="text"
                                                class="form-control phone-number @error('emergency_contact_number') is-invalid @enderror"
                                                name="emergency_contact_number"
                                                value="{{ Auth::user()->emergency_contact_number }}"
                                                placeholder="Enter your alternate contact number">
                                            @error('emergency_contact_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
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
                <!-- User Emergency Contact Detail End -->

                <!-- User Referral section Start -->
                <div class="row mt-5">
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
                                                    <input type="radio"
                                                        class="guestrewards form-check-input radio-button"
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
                                                    <input type="radio"
                                                        class="guestrewards form-check-input radio-button"
                                                        name="guestrewards" value="Word of Mouth"
                                                        @if (Auth::user()->guestrewards == 'Word of Mouth') checked @endif
                                                        @if (!empty(Auth::user()->guestrewards)) disabled @endif> Word of Mouth
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="radio"
                                                        class="guestrewards form-check-input radio-button"
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
                                                    <input type="radio"
                                                        class="guestrewards form-check-input radio-button"
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
                                                    <input type="radio"
                                                        class="guestrewards form-check-input radio-button"
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
                                                    <input type="radio"
                                                        class="guestrewards form-check-input radio-button"
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
                                                                <input type="radio"
                                                                    class="form-check-input radio-button"
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
                                                                <input type="radio"
                                                                    class="form-check-input radio-button"
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
                                                                <input type="radio"
                                                                    class="form-check-input radio-button"
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

                <!-- User Update Password Start -->

                <div class="row mt-5">
                    <div class="col-sm-12">
                        <div class="information-box update-pwd-sec">
                            <div class="information-box-head">
                                <div class="box-head-heading d-flex">
                                    <span class="box-head-label theme-color">Password</span>
                                </div>
                            </div>
                            <div class="information-box-body">
                                @if (session('password-success'))
                                    <div class="alert alert-success">
                                        {{ session('password-success') }}
                                    </div>
                                @endif
                                <form method="post" action="{{ route('user-settings-update-password') }}">
                                    @csrf
                                    @if (Auth::user()->password != null)
                                        <div class="row mt-3">
                                            <div class="col-md-6 col-12">
                                                <label class="form-label">Current Password<span
                                                        class="required-filed">*</span></label>
                                                <div style="position:relative;">
                                                    <input type="password"
                                                        class="form-control @error('current_password') is-invalid @enderror"
                                                        name="current_password" placeholder="Enter your current password"
                                                        id="current_password">
                                                    <i class="fa-solid fa-eye toggle-password"
                                                        onclick="togglePasswordVisibility('current_password')"
                                                        style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;"></i>
                                                    @error('current_password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row mt-md-3 mt-0 g-3">
                                        <div class="col-md-6 col-12">
                                            <label class="form-label">New Password<span
                                                    class="required-filed">*</span></label>
                                            <div style="position:relative;">
                                                <input type="password"
                                                    class="form-control @error('new_password') is-invalid @enderror"
                                                    name="new_password" placeholder="Enter your new password"
                                                    id="new_password">
                                                <i class="fa-solid fa-eye toggle-password"
                                                    onclick="togglePasswordVisibility('new_password')"
                                                    style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;"></i>
                                                @error('new_password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <label class="form-label">Confirm New Password<span
                                                    class="required-filed">*</span></label>
                                            <div style="position:relative;">
                                                <input type="password"
                                                    class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                                    name="new_password_confirmation"
                                                    placeholder="Enter your new confirm password"
                                                    id="new_password_confirmation">
                                                <i class="fa-solid fa-eye toggle-password"
                                                    onclick="togglePasswordVisibility('new_password_confirmation')"
                                                    style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;"></i>
                                                @error('new_password_confirmation')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Logout after change password option -->
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <label class="form-check-label" for="logout_checkbox">
                                                <input type="checkbox" class="form-check-input"
                                                    name="logout_after_change" id="logout_checkbox">
                                                Test new password
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row mt-5">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" class="btn wine-btn">Update Password</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Update Password End -->


            </div>
        </div>
    </div>
    @include('UserDashboard.includes.logout_modal')

    <div class="modal fade" id="cropImage" tabindex="-1" role="dialog" aria-labelledby="cropImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Profile Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 profile-image-upload-section">
                        <img class="image" style="Width:100%">
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                    <button type="button" class="btn btn-primary image-crop">Crop & Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#profile_image').on('change', function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#cropImage").modal('show');
                    $('.profile-image-upload-section').html(
                        '<img src="" id="image" class="image" style="Width:100%">');
                    var $image = $('.profile-image-upload-section #image');
                    if ($image.data('rcrop')) {
                        $image.rcrop('destroy');
                    }
                    // var url  = e.target.result;
                    $image.attr('src', e.target.result);
                    // Initialize rcrop after the image is loaded
                    $image.on('load', function() {


                        // alert();
                        setTimeout(() => {
                            // $image.rcrop('destroy').off('load');
                            // alert();
                            $(this).rcrop({
                                // maxSize: [509, 408],
                                preserveAspectRatio: true,
                                preview: {
                                    display: true,
                                    size: [100, 100],
                                    wrapper: '#custom-preview-wrapper'
                                }
                            });
                        }, 500);
                    });
                };
                reader.readAsDataURL(file);
            }
        });

        $(document).delegate(".image-crop", "click", function() {
            var imagerurl = $('#image').rcrop('getDataURL');
            $("#profile-image").val(imagerurl)
            $("#cropImage").modal('hide');
            // $('.profile-image-section').hide();
            $('#cropped-original').show();
            $('#cropped-original img').attr('src', imagerurl);
        });

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

        $(".social-media-checkbox").change(function() {
            var id = $(this).attr("id");
            if ($(this).is(":checked")) {
                console.log(id);
                $("#" + id.toLowerCase()).prop("disabled", false);
            } else {
                console.log(id);
                $("#" + id.toLowerCase()).val('').prop("disabled", true);
            }
        });


        document.querySelectorAll('.phone-number').forEach(function(input) {
            input.addEventListener('input', function(e) {
                const value = e.target.value.replace(/\D/g, ''); // Remove all non-digit characters
                let formattedValue = '';

                if (value.length > 3 && value.length <= 6) {
                    formattedValue = value.slice(0, 3) + '-' + value.slice(3);
                } else if (value.length > 6) {
                    formattedValue = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
                } else {
                    formattedValue = value;
                }

                e.target.value = formattedValue;
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.custom-checkbox');
            const updateButton = document.getElementById('update-button');

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', validateForm);
            });

            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(function(input) {
                input.addEventListener('input', validateForm);
            });

            function validateForm() {
                let isValid = true;

                checkboxes.forEach(function(checkbox) {
                    const inputField = document.getElementById(checkbox.id.toLowerCase());
                    const errorField = document.getElementById(`${checkbox.id.toLowerCase()}-error`);

                    if (checkbox.checked) {
                        if (!inputField.value) {
                            errorField.textContent = `${checkbox.id} link is required.`;
                            inputField.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            errorField.textContent = '';
                            inputField.classList.remove('is-invalid');

                            // Ensure the input starts with '@'
                            if (!inputField.value.startsWith('@')) {
                                inputField.value = '@' + inputField.value;
                            }
                        }
                    } else {
                        errorField.textContent = '';
                        inputField.classList.remove('is-invalid');
                    }
                });

                updateButton.disabled = !isValid;
            }

            // Initial validation on page load
            validateForm();
        });

        function togglePasswordVisibility(id) {
            var passwordField = document.getElementById(id);
            var eyeIcon = passwordField.nextElementSibling;
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }

        //Function for phone number format

        $(document).ready(function() {
            $('#phone-number').on('input', function() {
                // Get the current value of the input
                let input = $(this).val();

                // Remove non-digit characters
                input = input.replace(/\D/g, '');

                // Format the input according to 333-333-3333
                if (input.length > 6) {
                    input = input.replace(/(\d{3})(\d{3})(\d{1,4}).*/, '$1-$2-$3');
                } else if (input.length > 3) {
                    input = input.replace(/(\d{3})(\d{1,3})/, '$1-$2');
                }

                // Update the value of the input with the formatted number
                $(this).val(input);
            });
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
        document.addEventListener("DOMContentLoaded", function() {
            const dateInput = document.querySelector('input[name="date_of_birth"]');
            const today = new Date();
            const maxDate = new Date();

            maxDate.setFullYear(today.getFullYear() - 5); // Minimum age: 5 years

            const formattedMaxDate = `${String(maxDate.getMonth() + 1).padStart(2, '0')}/` +
                `${String(maxDate.getDate()).padStart(2, '0')}/` +
                `${maxDate.getFullYear()}`;

            dateInput.max = maxDate.toISOString().split('T')[0]; // Required for type="date" validation
            dateInput.setAttribute('data-max-display', formattedMaxDate); // Optional, for display

            // Optionally, set a placeholder or tooltip with the formatted date
            dateInput.placeholder = "MM/DD/YYYY";
        });
    </script>
@endsection
