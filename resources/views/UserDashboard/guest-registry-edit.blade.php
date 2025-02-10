@extends('FrontEnd.layouts.mainapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')
    <div class="container main-container">
        <div class="row flex-lg-nowrap flex-wrap g-4">
            @include('UserDashboard.includes.leftNav')
            <div class="col right-side">

                <!-- User Guest Registry Start -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="information-box">
                            <div class="information-box-head">
                                <div class="box-head-heading d-flex">
                                    <span class="box-head-label theme-color">Guest Registry:</span>
                                </div>
                            </div>
                            <div class="information-box-body">
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <form method="post" action="{{ route('user.update.address') }}">
                                    @csrf
                                    <div class="row mt-3">
                                        <div class="col-sm-6 col-12 mb-sm-0 mb-3">
                                            <label class="form-label">Contact Ph#</label>
                                            <input type="text" class="form-control  phone-number" name="contact_number"
                                                value="{{ old('contact_number', Auth::user()->contact_number) }}"
                                                placeholder="Enter Contact Phone">
                                            @error('contact_number')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label class="form-label">Street Address:</label>
                                            <input type="text" class="form-control" name="street_address"
                                                value="{{ old('street_address', Auth::user()->street_address) }}"
                                                placeholder="Enter Street Address:">
                                            @error('street_address')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-sm-6 col-12 mb-sm-0 mb-3">
                                            <label class="form-label">Unit/Suite#</label>
                                            <input type="text" class="form-control" name="suite"
                                                value="{{ old('suite', Auth::user()->suite) }}"
                                                placeholder="Enter Unit/Suite#">
                                            @error('suite')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label class="form-label">City/Town<span class="required-filed">*</span></label>
                                            <input type="text" class="form-control" name="city"
                                                value="{{ old('city', Auth::user()->city) }}" placeholder="Enter City/Town">
                                            @error('city')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-6 col-12">
                                            <label class="form-label">Country</label>
                                            <select name="country" id="country" class="form-select">
                                                <option value="">Select Country</option>
                                                @foreach (getCountries() as $country)
                                                    <option data-id="{{ $country->id }}" value="{{ $country->name }}"
                                                        {{ old('country', Auth::user()->country ?? '') == $country->name ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                                <option value="Other"
                                                    {{ old('country', Auth::user()->is_other_country ? 'Other' : '') == 'Other' ? 'selected' : '' }}>
                                                    Other
                                                </option>
                                            </select>
                                            @error('country')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-sm-6 col-12 mb-sm-0 mb-3" id="state-wrapper" style="display: none;">
                                            <label class="form-label">State</label>
                                            <select name="state" id="state" class="form-select">
                                                <option value="">Select State</option>
                                                {{-- States will be dynamically loaded via JS --}}
                                            </select>
                                            @error('state')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-sm-6 col-12 mb-sm-0 mb-3" id="other-country-wrapper"
                                            style="display: none;">
                                            <label class="form-label">Other Country</label>
                                            <input type="text" name="other_country" id="other-country"
                                                class="form-control"
                                                value="{{ old('other_country', Auth::user()->other_country ?? '') }}">
                                            @error('other_country')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-sm-6 col-12 mb-sm-0 mb-3" id="other-state-wrapper"
                                            style="display: none;">
                                            <label class="form-label">Other State</label>
                                            <input type="text" name="other_state" id="other-state" class="form-control"
                                                value="{{ old('other_state', Auth::user()->other_state ?? '') }}">
                                            @error('other_state')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-6 col-12">
                                            <label for="email" class="form-label">Postal Code/Zip<span
                                                    class="required-filed">*</span></label>
                                            <input type="text" class="form-control" name="postal_code" maxlength="7"
                                                oninput="formatPostalCode(this)"
                                                value="{{ old('postal_code', Auth::user()->postal_code) }}"
                                                placeholder="Enter Postal Code/Zip">
                                            @error('postal_code')
                                                <div class="text-danger">{{ $message }}</div>
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
                <!-- User Guest Registry End -->

                <!-- User Driving License Information Start -->
                <div class="row mt-5">
                    <div class="col-sm-12">
                        <div class="information-box">
                            <div class="information-box-head">
                                <div class="box-head-heading d-flex">
                                    <span class="box-head-label theme-color">Government Issue Photo ID</span>
                                </div>
                            </div>
                            <div class="information-box-body">
                                @if (session('Goverment-success'))
                                    <div class="alert alert-success">
                                        {{ session('Goverment-success') }}
                                    </div>
                                @endif
                                <form action="{{ route('user.goverment.update') }}" method="post">
                                    @csrf
                                    <input type="hidden" id="front-goverment-image" name="government_proof_front">
                                    <input type="hidden" id="back-goverment-image" name="government_proof_back">
                                    <div class="row mt-3 mb-3">
                                        <div class="col-12 col-sm-4">
                                            <label for="front_License_image" class="custom-file-label">
                                                <img src="{{ asset('images/icons/upload_image_icon.png') }}"
                                                    width="20"><br>Upload Driver License<br>( Front )
                                            </label>
                                            <input type="file" id="front_License_image"
                                                class="custom-file-input image_uplod" data-id="front-goverment-image"
                                                accept="image/*">
                                            <div class="mt-3 front-goverment-image"
                                                @if (Auth::user()->government_proof_front == '') style="display:none" @endif>
                                                <img src="{{ asset('images/GovermentProof') }}/{{ Auth::user()->government_proof_front }}"
                                                    style="width:100%">
                                            </div>
                                        </div>
                                        {{-- <div class="col-12 col-sm-4">
                                            <label for="back_License_image" class="custom-file-label"><img width="20" src="{{asset('images/icons/upload_image_icon.png')}}"><br>Upload Driver License<br>( Back )</label>
                                            <input type="file" id="back_License_image" class="custom-file-input image_uplod" data-id="back-goverment-image" accept="image/*">
                                            <div class="mt-3 back-goverment-image" @if (Auth::user()->government_proof_back == '') style="display:none" @endif>
                                                <img src="{{asset('images/GovermentProof')}}/{{Auth::user()->government_proof_back}}" style="width:100%">
                                            </div>
                                        </div> --}}
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


                <!-- User Driving License Information End -->



            </div>
        </div>
    </div>
    @include('UserDashboard.includes.logout_modal')
    <div class="modal fade" id="cropImage" tabindex="-1" role="dialog" aria-labelledby="cropImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Photo ID</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 profile-image-upload-section">
                        <img id="image" style="Width:100%">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button type="button" class="btn btn-primary image-crop">Crop & Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.image_uplod').on('change', function(event) {
            var file = event.target.files[0];
            var uploadid = $(this).attr('data-id');
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
                    $image.attr('data-id', uploadid);
                    // Initialize rcrop after the image is loaded
                    $image.on('load', function() {
                        setTimeout(() => {
                            $(this).rcrop({
                                minSize: [200, 200],
                                preserveAspectRatio: false,
                                preview: {
                                    display: true,
                                    size: [100, 100],
                                    wrapper: '#custom-preview-wrapper',
                                    useImageSize: true
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
            $('#image').attr('src', '');
            var imageid = $('#image').attr('data-id');
            $("#" + imageid).val(imagerurl)
            $("#cropImage").modal('hide');
            $('.' + imageid).show();
            $('.' + imageid + ' img').attr('src', imagerurl);
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

        function formatPostalCode(input) {
            // Remove all non-alphanumeric characters and convert to uppercase
            let value = input.value.replace(/\W/g, '').toUpperCase();

            // Add a space after every 3 characters
            if (value.length > 3) {
                value = value.slice(0, 3) + ' ' + value.slice(3);
            }

            // Update the input value
            input.value = value;
        }
        $(document).ready(function() {
            $('#state').select2({
                placeholder: "Select Province/State",
                allowClear: true,
                width: '100%',
                dropdownCssClass: 'select2-dropdown-searchable'
            });
        });
        $(document).ready(function() {
            const countryDropdown = $('#country');
            const stateDropdown = $('#state');
            const stateWrapper = $('#state-wrapper');
            const otherCountryWrapper = $('#other-country-wrapper');
            const otherStateWrapper = $('#other-state-wrapper');

            // Function to toggle visibility of fields based on country selection
            function toggleFields(country) {
                if (country === 'Other') {
                    stateWrapper.hide();
                    stateDropdown.val('');
                    otherCountryWrapper.show();
                    otherStateWrapper.show();
                } else {
                    stateWrapper.show();
                    otherCountryWrapper.hide();
                    otherStateWrapper.hide();
                }
            }

            // Function to load states dynamically and preselect a state if provided
            function loadStates(countryId, selectedState = null) {
                if (countryId) {
                    $.ajax({
                        url: '{{ route('get.states') }}',
                        type: 'GET',
                        data: {
                            country_id: countryId
                        },
                        success: function(response) {
                            stateDropdown.empty().append('<option value="">Select State</option>');
                            if (response.success) {
                                $.each(response.states, function(type, states) {
                                    const optgroup = $('<optgroup>').attr('label',
                                        capitalizeFirstLetter(type));
                                    $.each(states, function(index, state) {
                                        const option = $('<option>')
                                            .val(state.name)
                                            .text(state.name)
                                            .prop('selected', state.name ==
                                                selectedState);
                                        optgroup.append(option);
                                    });
                                    stateDropdown.append(optgroup);
                                });
                            }
                        },
                        error: function() {
                            alert('Failed to load states.');
                        }
                    });
                }
            }

            // Handle initial page load
            const savedCountry = '{{ old('country', Auth::user()->country ?? '') }}';
            const savedState = '{{ old('state', Auth::user()->state ?? '') }}';
            const isOtherCountry = savedCountry === 'Other';
            toggleFields(savedCountry);

            if (!isOtherCountry && savedCountry) {
                const selectedCountryId = countryDropdown.find(`option[value="${savedCountry}"]`).data('id');
                loadStates(selectedCountryId, savedState);
            }

            // Handle country dropdown change
            countryDropdown.change(function() {
                const selectedOption = $(this).find(':selected');
                const country = $(this).val();
                const countryId = selectedOption.data('id');

                toggleFields(country);

                //if (country !== 'Other') {
                    loadStates(countryId);
                //}
                if(country !== 'Other'){
                    $("#other-country").val('');
                    $("#other-state").val('');
                }
            });
        });



        function capitalizeFirstLetter(string) {
            if (!string) return ''; // Handle empty or null strings
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    </script>
@endsection
