@extends('FrontEnd.layouts.mainapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')
    <div class="container main-container">
        <div class="row flex-lg-nowrap flex-wrap g-4">
            @include('UserDashboard.includes.leftNav')
            <div class="col right-side">
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
                                <form method="post" action="{{ route('user-settings-social-update') }}" id="social-form">
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
                                            <input type="text" class="form-control mt-2" id="facebook" name="facebook"
                                                {{ !Auth::user()->facebook ? 'disabled' : '' }}
                                                value="{{ Auth::user()->facebook }}"
                                                placeholder="Enter your Facebook username">
                                            <div class="error" id="facebook-error"></div>

                                        </div>
                                        <div class="col-md-4 col-12">
                                            <input type="checkbox" class="custom-checkbox social-media-checkbox"
                                                id="Instagram" name="instagram_checkbox"
                                                {{ Auth::user()->instagram ? 'checked' : '' }}>
                                            <label for="Instagram">Instagram</label>
                                            <input type="text" class="form-control mt-2" id="instagram" name="instagram"
                                                {{ !Auth::user()->instagram ? 'disabled' : '' }}
                                                value="{{ Auth::user()->instagram }}"
                                                placeholder="Enter your Instagram username">
                                            <div class="error" id="instagram-error"></div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <input type="checkbox" class="custom-checkbox social-media-checkbox"
                                                id="Youtube" name="youtube_checkbox"
                                                {{ Auth::user()->youtube ? 'checked' : '' }}>
                                            <label for="Youtube">Youtube</label>
                                            <input type="text" class="form-control mt-2" id="youtube" name="youtube"
                                                {{ !Auth::user()->youtube ? 'disabled' : '' }}
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
                                            <input type="text" class="form-control mt-2" id="tiktok" name="tiktok"
                                                {{ !Auth::user()->tiktok ? 'disabled' : '' }}
                                                value="{{ Auth::user()->tiktok }}"
                                                placeholder="Enter your Tiktok username">
                                            <div class="error" id="tiktok-error"></div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <input type="checkbox" class="custom-checkbox social-media-checkbox"
                                                id="Twitter" name="twitter_checkbox"
                                                {{ Auth::user()->twitter ? 'checked' : '' }}>
                                            <label for="Twitter">Twitter</label>
                                            <input type="text" class="form-control mt-2" id="twitter" name="twitter"
                                                {{ !Auth::user()->twitter ? 'disabled' : '' }}
                                                value="{{ Auth::user()->twitter }}"
                                                placeholder="Enter your Twitter Username">
                                            <div class="error" id="twitter-error"></div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <input type="checkbox" class="custom-checkbox social-media-checkbox"
                                                id="Linkedin" name="linkedin_checkbox"
                                                {{ Auth::user()->linkedin ? 'checked' : '' }}>
                                            <label for="Linkedin">Linkedin</label>
                                            <input type="text" class="form-control mt-2" id="linkedin" name="linkedin"
                                                {{ !Auth::user()->linkedin ? 'disabled' : '' }}
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
            </div>
        </div>
    </div>
    @include('UserDashboard.includes.logout_modal')
@endsection
@section('js')
    <script>
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
    </script>
@endsection
