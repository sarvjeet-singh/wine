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
            right: 35px !important;
            top: 20px!important;
        }
        .update-pwd-sec form div:has(.invalid-feedback) input {
            padding-right: 60px;
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
                                            <label class="form-label">Given Name(s)<span
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
                                            <label class="form-label">Last/Surname<span class="required-filed">*</span></label>
                                            <input type="text"
                                                class="form-control @error('lastname') is-invalid @enderror" name="lastname"
                                                value="{{ old('lastname', Auth::user()->lastname) }}"
                                                placeholder="Enter your last name">
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
                                                name="display_name"
                                                value="{{ old('display_name', Auth::user()->display_name) }}"
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
        //Function for phone number format
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
