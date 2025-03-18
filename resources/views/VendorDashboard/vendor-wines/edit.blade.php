<div class="modal-header px-4">

    <h1 class="modal-title fw-bold fs-5" id="exampleModalLabel">Edit Wine - {{ $vendor->vendor_name }}</h1>

    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

</div>

<div class="modal-body p-4">

    <!-- Form Start  -->

    <form class="row g-3" id="vendorWineFormEdit"
        action="{{ route('vendor-wines.update', ['id' => $wine->id, 'vendor_id' => $vendor_id]) }}" method="POST"
        enctype="multipart/form-data">

        @csrf

        @method('PUT') <!-- Use PUT method for updating data -->


        <div class="col-12">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-6">
                        <label for="image" class="form-label">Image</label>
                        <input class="form-control" type="file" name="image" id="image" accept="image/*">
                    </div>
                    <div class="col-md-6 img-box d-flex flex-column align-items-center">
                        @if ($wine->image)
                            <img id="imagePreview" src="{{ asset('storage/' . $wine->image) }}"
                                alt="{{ $wine->winery_name }}" style="max-width:100%; height:auto; max-height:200px;" />
                            <button type="button" id="removeImage" class="btn btn-danger mt-2">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        @else
                            <img id="imagePreview" src="{{ asset('storage/' . $wine->image) }}" alt="Image Preview"
                                style="display:none; max-width:100%; height:auto; max-height:200px;" />
                            <button type="button" id="removeImage" style="display:none;" class="btn btn-danger mt-2">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        @endif
                        <input type="hidden" name="image_removed" id="imageRemoved" value="false">
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-4">

            <label for="" class="form-label">Business / Vendor Name</label>

            <input type="text" name="" id="" value="{{ $vendor->vendor_name }}" readonly
                class="form-control">

        </div> --}}
        {{-- <div class="col-md-4">

            <label for="winery_name" class="form-label">Winery Name</label>

            <input type="text" name="winery_name" id="winery_name" class="form-control"
                value="{{ old('winery_name', $wine->winery_name) }}">

        </div> --}}

        <div class="col-md-4">
            <label for="region" class="form-label d-flex align-items-center">
                Region
            </label>
            <select class="form-select {{ $wine->custom_region ? 'd-none' : '' }}" id="region" name="region"
                {{ $wine->custom_region ? 'disabled' : '' }} required>
                <option value="">Select Region</option>
                @foreach (getRegions() as $region)
                    <option value="{{ $region->id }}" {{ $wine->region == $region->id ? 'selected' : '' }}>
                        {{ $region->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label for="sub_region" class="form-label d-flex align-items-center">
                Sub-Region
            </label>
            <select class="form-select {{ $wine->custom_sub_region ? 'd-none' : '' }}" id="sub_region"
                name="sub_region" {{ $wine->custom_sub_region ? 'disabled' : '' }}>
                <option value="">Select Sub-Region</option>
                @foreach (getSubRegions($wine->region) as $subRegion)
                    <option value="{{ $subRegion->id }}" {{ $wine->sub_region == $subRegion->id ? 'selected' : '' }}>
                        {{ $subRegion->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-12">

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="" class="form-label">Label Name</label>

                    <input type="text" name="winery_name" value="{{ old('winery_name', $wine->winery_name) }}"
                        class="form-control" id="Label">
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label">Series Name</label>

                    <input type="text" name="series" value="{{ old('series', $wine->series) }}"
                        class="form-control" id="Series">
                </div>
            </div>

        </div>

        <div class="col-12">

            <div class="row g-3">
                <div class="col-md-4">
                    <label for="vintage_date" class="form-label">Vintage Date</label>

                    <select class="form-select" id="vintage_date" name="vintage_date">
                        <option value="">Select Year</option>
                        @foreach (range(date('Y'), 1900) as $year)
                            <option value="{{ $year }}"
                                {{ isset($wine->vintage_date) && $wine->vintage_date == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-8">

                    <div id="dynamic-fields-container">

                        @php

                            $varietal_blends = json_decode($wine->varietal_blend, true);
                        @endphp
                        <div class="d-flex align-items-between gap-2">
                            <div class="w-75">
                                <label for="varietal_type" class="form-label">Grape Varietals</label>
                            </div>
                            <div class="w-75" style="width: 61.5% !important">
                                <label for="varietal_blend" class="form-label">Blend Percentage</label>
                            </div>
                        </div>
                        @php $usedVarietal = []; @endphp
                        @if (count($varietal_blends) > 0)
                            @foreach ($varietal_blends as $key => $varietal_blend)
                                <div class="dynamic-field">
                                    <div class="d-flex align-items-center gap-2 {{ $key > 0 ? 'mt-2' : '' }}">
                                        <button type="button" class="btn btn-outline-danger remove-field">
                                            <i class="fa-solid fa-circle-minus"></i>
                                        </button>
                                        <div class="w-75">
                                            <select class="form-select" name="varietal_type[]">
                                                <option value="">Select</option>
                                                @if (count(getGrapeVarietals()) > 0)
                                                    @foreach (getGrapeVarietals() as $grapeVarietal)
                                                        @if (in_array($grapeVarietal->id, $usedVarietal))
                                                            @continue
                                                        @endif
                                                        <option value="{{ $grapeVarietal->id }}"
                                                            @if (isset($varietal_blend['type']) && $varietal_blend['type'] == $grapeVarietal->id) selected
                                                            @php $usedVarietal[] = $grapeVarietal->id; @endphp @endif>
                                                            {{ $grapeVarietal->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="w-75">
                                            <div class="input-group">
                                                <input type="text" class="form-control percent"
                                                    name="varietal_blend[]" placeholder="Varietal/Blend"
                                                    value="{{ $varietal_blend['blend'] ?? '' }}">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <!-- Extra empty select row for adding new varietal -->
                        <div class="dynamic-field">
                            <div class="d-flex align-items-center gap-2 mt-2">
                                <button type="button" class="btn btn-outline-success add-field">
                                    <i class="fa-solid fa-circle-plus"></i>
                                </button>
                                <div class="w-75">
                                    <select class="form-select" name="varietal_type[]">
                                        <option value="">Select</option>
                                        @if (count(getGrapeVarietals()) > 0)
                                            @foreach (getGrapeVarietals() as $grapeVarietal)
                                                @if (in_array($grapeVarietal->id, $usedVarietal))
                                                    @continue
                                                @endif
                                                <option value="{{ $grapeVarietal->id }}">{{ $grapeVarietal->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="w-75">
                                    <div class="input-group">
                                        <input type="text" class="form-control percent" name="varietal_blend[]"
                                            placeholder="Varietal/Blend">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <label for="abv" class="form-label">Alcohol By Volume</label>
            <div class="input-group">
                <input type="text" class="form-control" name="abv" id="abv"
                    value="{{ old('abv', $wine->abv) }}">
                <span class="input-group-text">%</span>
            </div>

        </div>
        <div class="col-md-6">
            <label for="bottle_size" class="form-label">Bottle Size</label>
            <select class="form-select" id="bottle_size" name="bottle_size">
                <option value="">Select Bottle Size</option>
                <option value="375 ml"
                    {{ isset($wine->bottle_size) && $wine->bottle_size == '375 ml' ? 'selected' : '' }}>
                    375 ml (Demie)
                </option>
                <option value="750 ml"
                    {{ isset($wine->bottle_size) && $wine->bottle_size == '750 ml' ? 'selected' : '' }}>
                    750 ml (Standard)
                </option>
                <option value="1.5 L"
                    {{ isset($wine->bottle_size) && $wine->bottle_size == '1.5 L' ? 'selected' : '' }}>
                    1.5 L (Magnum)
                </option>
                <option value="3 L"
                    {{ isset($wine->bottle_size) && $wine->bottle_size == '3 L' ? 'selected' : '' }}>
                    3 L (Dbl Magnum)
                </option>
            </select>
        </div>
        <div class="col-12">

            <label for="" class="form-label">Residual Sugars</label>

            <div class="row g-2">
                @foreach (getResidualSugars() as $value => $label)
                    <div class="col-lg-4 col-sm-6">
                        <div class="form-check">
                            @php
                                // Handle special case for '120+' to set a proper range
                                if ($value == '120+') {
                                    $value__ = '120-150';
                                } else {
                                    $value__ = $value;
                                }
                                // Exploding the range into min and max values
                                $rs_value_mix_max = explode('-', $value__);
                            @endphp
                            <input class="form-check-input" type="radio" name="rs"
                                id="rs-{{ $value }}" value="{{ $value }}"
                                {{ isset($wine->rs) && $wine->rs == $value ? 'checked' : '' }}
                                onchange="clearOtherFields('{{ $value }}')">
                            <label class="form-check-label" for="rs-{{ $value }}">
                                {{ $label }}
                            </label>
                        </div>
                        <!-- Text input for the value associated with the radio button -->
                        <input type="number" step="0.01" min="{{ $rs_value_mix_max[0] }}"
                            max="{{ $rs_value_mix_max[1] }}" class="form-control rs-values mt-1"
                            id="rs-value-{{ $value }}" name="rs_values[{{ $value }}]"
                            value="{{ isset($wine->rs_value) && $wine->rs == $value ? $wine->rs_value : old('rs_value') }}"
                            placeholder="g/l">
                    </div>
                @endforeach
            </div>

        </div>

        <div class="col-md-6">
            <div class="d-flex align-items-center gap-2">
                <div>
                    <label for="casesInput" class="form-label">Casew</label>
                    <input type="number" class="form-control w-100" id="casesInput" min="0"
                        placeholder="Enter cases" style="width: 50%;">
                </div>
                <div>
                    <label for="bottlesInput" class="form-label">Bottles</label>
                    <input type="number" class="form-control w-100" id="bottlesInput" min="0"
                        placeholder="Enter bottles" style="width: 50%;">
                </div>
            </div>
            <input type="hidden" name="inventory" value="{{ old('inventory', $wine->inventory) }}" id="inventory"
                class="form-control">
        </div>

        <div class="col-md-6">
            <div class="d-flex align-items-center gap-2">
                <div>
                    <label for="totalInventory" class="form-label">Inventory</label>
                    <input type="number" class="form-control w-100" id="totalInventory" readonly
                        value="{{ old('inventory', $wine->inventory) }}" style="width: 50%;">
                </div>
                <div>
                    <label for="sku" class="form-label">SKU</label>

                    <input type="text" class="form-control w-100" style="width: 50%;" name="sku"
                        id="sku" value="{{ old('sku', $wine->sku) }}">

                </div>
            </div>
        </div>


        <div class="col-md-4">

            <label for="cost" class="form-label">Listed Price</label>

            <div class="input-group mb-3">

                <span class="input-group-text">$</span>

                <input type="text" name="cost" placeholder="0.00" onkeypress="return handleInput(event, this)"
                    id="cost" class="form-control" value="{{ old('cost', $wine->cost) }}">

            </div>

        </div>

        <div class="col-md-4">

            <label for="commission" class="form-label">Stocking Fee</label>

            <input type="text" name="commission" readonly placeholder="0.00"
                onkeypress="return handleInput(event, this)" id="commission" class="form-control"
                value="{{ old('commission', $wine->commission_delivery_fee) }}">

        </div>

        <div class="col-md-4">

            <label for="price" class="form-label">Reseller Price</label>

            <div class="input-group mb-3">

                <span class="input-group-text">$</span>

                <input type="text" name="price" placeholder="0.00" onkeypress="return handleInput(event, this)"
                    id="price" class="form-control" value="{{ old('price', $wine->price) }}">

            </div>

        </div>

        <div class="col-12 cellaring-value-sec">
            <label for="" class="form-label">Cellaring Value</label>
            <div class="row g-2">
                <div class="col-lg-4 col-sm-6">
                    <div class="form-check cellaring-value-1 d-flex align-items-center gap-2 position-relative">
                        <input class="form-check-input" type="radio" name="cellar" id="cellar1"
                            value="Drink Now" {{ old('cellar', $wine->cellar) == 'Drink Now' ? 'checked' : '' }}>
                        <label class="form-check-label" for="cellar1">
                            <img src="{{ asset('images/wine-drink.png') }}" class="img-fluid" alt="Wine Image">
                            <p>Drink Now</p>
                        </label>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="form-check cellaring-value-2 d-flex align-items-center gap-2 position-relative">
                        <input class="form-check-input" type="radio" name="cellar" id="cellar2"
                            value="Drink or Cellar"
                            {{ old('cellar', $wine->cellar) == 'Drink or Cellar' ? 'checked' : '' }}>
                        <label class="form-check-label" for="cellar2">
                            <img src="{{ asset('images/wine-drink.png') }}" class="img-fluid" alt="Wine Image">
                            <p>Drink or Hold</p>
                        </label>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="form-check cellaring-value-3 d-flex align-items-center gap-2 position-relative">
                        <input class="form-check-input" type="radio" name="cellar" id="cellar3" value="Cellar"
                            {{ old('cellar', $wine->cellar) == 'Cellar' ? 'checked' : '' }}>
                        <label class="form-check-label" for="cellar3">
                            <img src="{{ asset('images/wine-drink.png') }}" class="img-fluid" alt="Wine Image">
                            <p>Cellar</p>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">

            <label for="description" class="form-label">Bottle Notes</label>

            <textarea class="form-control" name="description" id="description" rows="3">{{ old('description', $wine->description) }}</textarea>

        </div>

        <div class="col-12 text-center">

            <button type="submit" class="btn wine-btn w-25 px-3">Update</button>

        </div>

    </form>

    <!-- Form End  -->
    <script>
        $(document).ready(function() {

            $('#vendorWineFormEdit').validate({
                rules: {
                    winery_name: {
                        required: true
                    },
                    series: {
                        required: true
                    },
                },

                errorElement: "div", // error element as span

                errorPlacement: function(error, element) {

                    error.insertAfter(element); // Insert error after the element

                },

                submitHandler: function(form, event) {

                    // Handle AJAX submission here

                    event.preventDefault();

                    let formData = new FormData(form);



                    // Get the wine ID for the update, assuming it's stored in a hidden input or as part of the form

                    var wineId = $('#wine_id').val(); // Replace with the correct ID field



                    $.ajax({

                        url: '{{ route('vendor-wines.update', ['id' => $wine->id, 'vendorid' => $vendor_id]) }}',

                        type: 'POST',

                        data: formData,

                        contentType: false, // Important: Prevent jQuery from processing the data

                        processData: false, // Important: Prevent jQuery from automatically converting the data to string

                        headers: {

                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token

                            'X-HTTP-Method-Override': 'PUT' // Simulate PUT method since HTML forms don't support it natively

                        },

                        success: function(response) {

                            if (response.success) {

                                Swal.fire({
                                    icon: 'success', // Can be 'success', 'error', 'warning', 'info', or 'question'
                                    title: 'Success',
                                    text: response
                                        .message, // The message you want to show
                                    confirmButtonText: 'OK' // Button text
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Reload the page after the user clicks "OK"
                                        location.reload();
                                    }
                                });
                            }

                        },

                        error: function(xhr) {

                            var errors = xhr.responseJSON.errors;

                            $.each(errors, function(key, value) {

                                // Handle error for each field

                                $('#' + key).addClass('error');

                                $('#' + key).after('<span class="error">' + value[

                                    0] + '</span>');

                            });

                        }

                    });

                }

            });

        });
    </script>
    <script>
        document.getElementById('cost').addEventListener('input', calculateFees);

        function calculateFees() {
            // Get the cost input value
            const costInput = document.getElementById('cost').value;
            const cost = parseFloat(costInput);

            // Get the stocking fee and price elements
            const stockingFeeInput = document.getElementById('commission');
            const priceInput = document.getElementById('price');

            // Return if cost is invalid or empty
            if (isNaN(cost) || cost < 0) {
                stockingFeeInput.value = '';
                priceInput.value = '';
                return;
            }

            // Determine the stocking fee based on the cost
            let stockingFee = 0;
            if (cost <= 20) {
                stockingFee = 3;
            } else if (cost <= 40) {
                stockingFee = 4;
            } else if (cost <= 60) {
                stockingFee = 6;
            } else if (cost <= 80) {
                stockingFee = 8;
            } else if (cost > 80) {
                stockingFee = 10;
            }

            // Calculate the total price
            const totalPrice = cost + stockingFee;

            // Update the input fields
            stockingFeeInput.value = stockingFee.toFixed(2);
            priceInput.value = totalPrice.toFixed(2);
        }
        $(document).ready(function() {
            // Function to calculate total bottles from cases and individual bottles
            function calculateTotalBottles() {
                var cases = parseInt($('#casesInput').val(), 10) || 0;
                var bottles = parseInt($('#bottlesInput').val(), 10) || 0;
                var totalBottles = (cases * 12) + bottles;

                $('#inventory').val(totalBottles);
                $('#totalInventory').val(totalBottles);
            }

            // Function to display cases and bottles from a given total number of bottles
            function displayCasesAndBottles(totalBottles) {
                if (isNaN(totalBottles) || totalBottles < 0) {
                    alert("Invalid number of bottles.");
                    return;
                }

                var cases = Math.floor(totalBottles / 12);
                var remainingBottles = totalBottles % 12;

                $('#casesInput').val(cases);
                $('#bottlesInput').val(remainingBottles);
            }

            // Event listeners for input fields
            $('#casesInput, #bottlesInput').on('input', calculateTotalBottles);

            // Example usage: Display cases and bottles when total comes from the database
            var totalBottlesFromDB = $('#inventory').val(); // Replace this with the value from your database
            displayCasesAndBottles(totalBottlesFromDB);
        });
    </script>
    <script>
        function handleInput(evt, input) {
            const charCode = (evt.which) ? evt.which : evt.keyCode;

            // Allow: backspace, delete, tab, escape, enter, Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
            if ([8, 9, 27, 13].indexOf(charCode) !== -1 ||
                (charCode === 65 && evt.ctrlKey === true) ||
                (charCode === 67 && evt.ctrlKey === true) ||
                (charCode === 86 && evt.ctrlKey === true) ||
                (charCode === 88 && evt.ctrlKey === true) ||
                // Allow: decimal point if it doesn't already exist
                (charCode === 46 && input.value.indexOf('.') === -1)) {
                return true;
            }

            // Prevent any other key presses except numbers
            if (charCode < 48 || charCode > 57) {
                return false;
            }

            // Handle formatting after input
            setTimeout(() => {
                let value = input.value;

                // Replace any non-numeric characters (except decimal)
                value = value.replace(/[^0-9.]/g, '');

                // Split into whole and decimal parts
                const parts = value.split('.');
                if (parts.length > 2) {
                    value = parts[0] + '.' + parts.slice(1).join('').substring(0, 2);
                } else if (parts.length === 2) {
                    // Limit decimal part to 2 digits
                    parts[1] = parts[1].substring(0, 2);
                    value = parts.join('.');
                }

                // Update input value
                input.value = value;
            }, 0);

            return true;
        }
        $(document).ready(function() {
            const subRegionDropdown = $('#sub_region');
            // Function to load sub-regions based on region ID
            function loadSubRegions(regionId) {
                subRegionDropdown.html('<option value="">Loading...</option>'); // Show loading indicator

                if (regionId) {
                    $.ajax({
                        url: '/get-subregions/' + regionId, // Adjust this route as needed
                        type: 'GET',
                        success: function(response) {
                            let options = '<option value="">Select Sub-Region</option>';
                            response.forEach(subRegion => {
                                options +=
                                    `<option value="${subRegion.id}">${subRegion.name}</option>`;
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

            // Trigger on region change
            $('#region').on('change', function() {
                const regionId = $(this).val();
                loadSubRegions(regionId);
            });
        });

        function clearOtherFields(selectedValue) {
            // Get all text input fields
            const inputs = document.querySelectorAll('input.form-control.rs-values');

            // Loop through and clear all except the selected one
            inputs.forEach(input => {
                if (input.id !== `rs-value-${selectedValue}`) {
                    input.value = ''; // Clear the value
                }
            });
        }

        // If a radio button is already selected (for editing), run the function to clear non-selected fields
        document.addEventListener("DOMContentLoaded", function() {
            const checkedRadio = document.querySelector('input[name="rs"]:checked');
            if (checkedRadio) {
                const selectedValue = checkedRadio.value;
                clearOtherFields(selectedValue);
            }
        });
    </script>
</div>
