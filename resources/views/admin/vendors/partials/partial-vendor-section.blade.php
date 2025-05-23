@csrf
{{ !empty($vendor) ? method_field('PUT') : method_field('POST') }}
<div class="information-box mb-3">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="info-head p-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="text-white">Business/Vendor Information</div>
        </div>
    </div>
    <div class="m-3 pb-4">
        <div class="row g-4">
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">Business/Vendor Name*</label>
                    <input type="text" class="form-control @error('vendor_name') is-invalid @enderror"
                        name="vendor_name" placeholder="Business/Vendor Name"
                        value="{{ !empty($vendor) ? $vendor->vendor_name : old('vendor_name') }}">
                    @error('vendor_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <!-- Another input can go here if needed -->
            </div>
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">Street Address*</label>
                    <input type="text" class="form-control @error('street_address') is-invalid @enderror"
                        name="street_address" placeholder="Street Address"
                        value="{{ !empty($vendor) ? $vendor->street_address : old('street_address') }}">
                    @error('street_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-check mt-2">
                        <input class="form-check-input @error('hide_street_address') is-invalid @enderror"
                            type="checkbox" id="hideStreetAddress" name="hide_street_address"
                            {{ !empty($vendor) && $vendor->hide_street_address ? 'checked' : (old('hide_street_address') ? 'checked' : '') }}>
                        <label class="check-label" for="form-check-label">Check this box to hide street address</label>
                        @error('hide_street_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">Unit/Suite#</label>
                    <input type="text" class="form-control @error('unitsuite') is-invalid @enderror" name="unitsuite"
                        placeholder="Unit/Suite#" value="{{ !empty($vendor) ? $vendor->unitsuite : old('unitsuite') }}">
                    @error('unitsuite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="country" class="form-label fw-bold">Country*</label>
                    <select name="country" id="country" class="form-select" aria-label="Select a country">
                        <option value="">Select a country</option>
                        @foreach (getCountries() as $country)
                            <option value="{{ $country->id }}"
                                {{ (!empty($vendor) && $vendor->country == $country->id) || old('country') == $country->id || (empty($vendor) && old('country') === null && $country->id == 2) ? 'selected' : '' }}>
                                {{ $country->name }}
                        @endforeach
                    </select>
                    @error('country')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="province" class="form-label fw-bold">Province/State*</label>
                    <select class="form-control select2 @error('province') is-invalid @enderror" name="province"
                        id="province">
                        @foreach (getStates(2) as $type => $items)
                            <optgroup label="{{ ucfirst($type) }}">
                                @foreach ($items as $state)
                                    <option value="{{ $state->name }}"
                                        {{ collect(old('province', $vendor->province ?? 'Ontario'))->contains($state->name) ? 'selected' : '' }}>
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('province')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">City/Town*</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city"
                        placeholder="City/Town" value="{{ !empty($vendor) ? $vendor->city : old('city') }}">
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">Postal/Zip*</label>
                    <input type="text" class="form-control @error('postalCode') is-invalid @enderror"
                        name="postalCode" placeholder="Postal/Zip"
                        value="{{ !empty($vendor) ? $vendor->postalCode : old('postalCode') }}" maxlength="7"
                        oninput="formatPostalCode(this)">
                    @error('postalCode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="region" class="form-label fw-bold">Region</label>
                    <select name="region" id="region" class="form-select" aria-label="Select a region">
                        <option value="">Select a region</option>
                        @foreach (getRegions() as $region)
                            <option value="{{ $region->id }}"
                                {{ (!empty($vendor) && $vendor->region == $region->id) || old('region') == $region->id ? 'selected' : '' }}>
                                {{ $region->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('region')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="sub_region" class="form-label fw-bold">Sub-Region</label>
                    <select name="sub_region" id="sub_region" class="form-select" aria-label="Select a sub-region">
                        <option value="">Select a sub-region</option>
                        @if (!empty($vendor->region))
                            @foreach (getSubRegions($vendor->region) as $subRegion)
                                <option value="{{ $subRegion->id }}"
                                    {{ (!empty($vendor) && $vendor->sub_region == $subRegion->id) || old('sub_region') == $subRegion->id ? 'selected' : '' }}>
                                    {{ $subRegion->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('sub_region')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">Website</label>
                    <input type="text" class="form-control @error('website') is-invalid @enderror" name="website"
                        placeholder="Website url" value="{{ !empty($vendor) ? $vendor->website : old('website') }}">
                    @error('website')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">Business/Vendor Phone</label>
                    <input type="text" class="form-control @error('vendor_phone') is-invalid @enderror"
                        name="vendor_phone" id="vendor_phone" placeholder="Phone number"
                        value="{{ !empty($vendor) ? $vendor->vendor_phone : old('vendor_phone') }}">
                    @error('vendor_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">eMail</label>
                    <input type="text" class="form-control @error('vendor_email') is-invalid @enderror"
                        name="vendor_email" placeholder="Email address"
                        value="{{ !empty($vendor) ? $vendor->vendor_email : old('vendor_email') }}">
                    @error('vendor_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <div>
                    <label for="" class="form-label fw-bold">Description</label>
                    <div class="form-floating">
                        <textarea maxlength="1000" rows="5" class="form-control @error('description') is-invalid @enderror"
                            name="description" id="description" placeholder="Description" style="height: 100px" placeholder="Please enter description">{{ old('description', $vendor->description) }}</textarea>
                        <div class="form-text text-end">
                            <span id="description-count">0</span>/1000
                        </div>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#vendor_phone').mask('000-000-0000');
        });
        //Function for Postal code
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
            const defaultRegionId = $('#region').val();
            const selectedSubRegionId =
                "{{ $vendor->sub_region ?? (old('sub_region') ?? '') }}"; // Use sub-region from DB or old value
            const subRegionDropdown = $('#sub_region');

            function loadSubRegions(regionId, selectedSubRegionId = null) {
                subRegionDropdown.html('<option value="">Loading...</option>'); // Show loading indicator

                if (regionId) {
                    $.ajax({
                        url: '/get-subregions/' + regionId, // Adjust this route as needed
                        type: 'GET',
                        success: function(response) {
                            let options = '<option value="">Select Sub-Region</option>';
                            response.forEach(subRegion => {
                                options += `<option value="${subRegion.id}" ${
                            subRegion.id == selectedSubRegionId ? 'selected' : ''
                        }>${subRegion.name}</option>`;
                            });
                            subRegionDropdown.html(options);
                        },
                        error: function() {
                            subRegionDropdown.html(
                                '<option value="">Error loading sub-regions</option>');
                        }
                    });
                } else {
                    subRegionDropdown.html('<option value="">Select Sub-Region</option>'); // Reset dropdown
                }
            }

            // Load sub-regions for default region on page load
            if (defaultRegionId) {
                loadSubRegions(defaultRegionId, selectedSubRegionId);
            }

            // Trigger on region change
            $('#region').on('change', function() {
                const regionId = $(this).val();
                loadSubRegions(regionId);
            });
        });
        $(document).ready(function() {
            let typingTimer; // Timer for debounce
            const debounceDelay = 500; // Delay in milliseconds

            $("input[name='vendor_name'], input[name='street_address']").on("keyup", function() {
                clearTimeout(typingTimer);

                typingTimer = setTimeout(() => {
                    validateCombination();
                }, debounceDelay);
            });

            function validateCombination() {
                const vendorName = $("input[name='vendor_name']").val().trim();
                const streetAddress = $("input[name='street_address']").val().trim();

                if (vendorName === "" || streetAddress === "") {
                    // Reset the error message if fields are empty
                    // removeError("vendor_name");
                    removeError("street_address");
                    return;
                }

                // AJAX request to validate the combination
                $.ajax({
                    url: "{{ route('check.vendor.combination') }}",
                    type: "POST",
                    data: {
                        vendor_name: vendorName,
                        street_address: streetAddress,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.exists) {
                            // Add error to both fields
                            // addError("vendor_name", response.message);
                            addError("street_address", response.message);
                        } else {
                            // Remove error if combination does not exist
                            // removeError("vendor_name");
                            removeError("street_address");
                        }
                    },
                    error: function() {
                        alert("An error occurred. Please try again.");
                    }
                });
            }

            function addError(fieldName, message) {
                const inputField = $(`input[name='${fieldName}']`);
                inputField.addClass("is-invalid");

                // Remove existing error feedback, if any
                inputField.next(".invalid-feedback").remove();

                // Add new feedback message
                inputField.after(`<div class="invalid-feedback">${message}</div>`);
            }

            function removeError(fieldName) {
                const inputField = $(`input[name='${fieldName}']`);
                inputField.removeClass("is-invalid");
                inputField.next(".invalid-feedback").remove();
            }
        });
        $(document).ready(function() {
            $('#province').select2({
                placeholder: "Select Province/State",
                allowClear: true,
                width: '100%',
                dropdownCssClass: 'select2-dropdown-searchable'
            });
        });
        $(document).ready(function() {
            // Listen for country dropdown change
            $('#country').change(function() {
                let countryId = $(this).val();

                if (countryId) {
                    $.ajax({
                        url: '{{ route('get.states') }}', // Endpoint for fetching states
                        type: 'GET',
                        data: {
                            country_id: countryId
                        },
                        success: function(response) {
                            let stateDropdown = $('#province');
                            stateDropdown.empty(); // Clear existing options

                            if (response.success) {
                                // Populate states
                                $.each(response.states, function(type, states) {
                                    // Add optgroup for each type (province, state)
                                    let group = $('<optgroup>', {
                                        label: capitalizeFirstLetter(type)
                                    });
                                    $.each(states, function(index, state) {
                                        group.append($('<option>', {
                                            value: state.id,
                                            text: state.name
                                        }));
                                    });
                                    stateDropdown.append(group);
                                });
                            } else {
                                stateDropdown.append('<option>No states available</option>');
                            }
                        },
                        error: function() {
                            alert('Failed to load states. Please try again.');
                        }
                    });
                }
            });
        });

        function capitalizeFirstLetter(string) {
            if (!string) return ''; // Handle empty or null strings
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
        $(document).ready(function() {
            $("#vendorName").text("{{ !empty($vendor) ? $vendor->vendor_name : '' }}");
        });
        $(document).on('input', '.percent', function() {
            var $this = $(this);
            var value = $(this).val();
            // Remove all non-numeric characters except the decimal point
            value = value.replace(/[^0-9.]/g, '');

            // Ensure the value does not start with a decimal point
            if (value.startsWith('.')) {
                value = '0' + value;
            }

            // Split the value into whole and decimal parts
            var parts = value.split('.');

            // Limit decimal places to two
            if (parts.length > 2) {
                value = parts[0] + '.' + parts.slice(1).join('');
            }

            // If there is a decimal point, limit the number of decimal places to two
            if (parts.length === 2) {
                parts[1] = parts[1].slice(0, 2);
                value = parts.join('.');
            }

            // Convert value to number and ensure it's within the range 0 to 100
            var numericValue = parseFloat(value);
            // if (isNaN(numericValue)) {
            //     value = '';
            // } else 

            if (numericValue > 100) {
                value = '100';
            } else if (numericValue < 0) {
                value = '0';
            }

            // Set the formatted value back to the input
            $this.val(value);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('description');
            const counter = document.getElementById('description-count');
            const max = parseInt(textarea.getAttribute('maxlength'), 10);

            // initialize
            counter.textContent = textarea.value.length;

            textarea.addEventListener('input', () => {
                counter.textContent = textarea.value.length;
            });
        });
    </script>
@endpush
