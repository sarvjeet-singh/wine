<div class="modal-header px-4">

    <h1 class="modal-title fw-bold fs-5" id="exampleModalLabel">Add Wine - {{ $vendor->vendor_name }}</h1>

    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

</div>

<div class="modal-body p-4">

    <!-- Form Start  -->

    <form class="row g-3" id="vendorWineFormAdd" enctype="multipart/form-data" method="POST">

        @csrf

        @method('POST')

        <div class="col-12">
            <div class="row">
                <div class="col-md-6">
                    <label for="image" class="form-label">Image</label>
                    <input class="form-control" type="file" name="image" id="image" accept="image/*">
                </div>
                <div class="col-md-6 img-box d-flex flex-column align-items-center">
                    <img id="imagePreview" src="" alt="Image Preview"
                        style="display:none; max-width:100%;height:auto;max-height:200px;" />
                    <button type="button" id="removeImage" style="display:none;" class="btn btn-danger mt-2"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <label for="region" class="form-label d-flex align-items-center">
                Region
            </label>
            <select class="form-select" id="region" name="region" required>
                <option value="">Select Region</option>
                @if (count(getRegions()) > 0)
                    @foreach (getRegions() as $region)
                        <option {{ $region->id == $vendor->region ? 'selected' : '' }} value="{{ $region->id }}">
                            {{ $region->name }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="col-md-4">
            <label for="sub_region" class="form-label d-flex align-items-center">
                Sub-Region
            </label>
            <select class="form-select" id="sub_region" name="sub_region">
                <option value="">Select Sub-Region</option>
                @if (count(getSubRegions($vendor->region)) > 0)
                    @foreach (getSubRegions($vendor->region) as $subRegion)
                        <option {{ $vendor->sub_region == $subRegion->id ? 'selected' : '' }}
                            value="{{ $subRegion->id }}">{{ $subRegion->name }}</option>
                    @endforeach
                @endif
            </select>

        </div>

        <div class="col-12">

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="" class="form-label">Label Name</label>

                    <input type="text" name="winery_name" class="form-control" id="Label">
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label">Series Name</label>

                    <input type="text" name="series" class="form-control" id="Series">
                </div>

            </div>

        </div>

        <div class="col-12">

            <div class="row g-3">
                <div class="col-md-4">
                    <label for="" class="form-label">Vintage Date</label>

                    <select class="form-select" id="vintage_date" name="vintage_date">
                        @foreach (range(date('Y'), 1900) as $year)
                            <option value="{{ $year }}">{{ $year }}</option>';
                        @endforeach
                    </select>
                </div>
                <div class="col-md-8">

                    <div id="dynamic-fields-container">
                        <div class="d-flex align-items-between gap-2">
                            <div class="w-75">
                                <label for="varietal_type" class="form-label">Grape Varietals</label>
                            </div>
                            <div class="w-75" style="width: 61.5% !important">
                                <label for="varietal_blend" class="form-label">Blend Percentage</label>
                            </div>
                        </div>
                        <div class="dynamic-field">
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-outline-success add-field"><i
                                        class="fa-solid fa-circle-plus"></i></button>
                                <div class="w-75">
                                    <select class="form-select" name="varietal_type[]">
                                        <option value="">Select</option>.
                                        @if (count(getGrapeVarietals()) > 0)
                                            @foreach (getGrapeVarietals() as $grapeVarietal)
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

            <!-- <input type="number" class="form-control" step="0.01" min="0" max="100" name="abv_rs"

                id="abv_rs"> -->

            <div class="input-group">
                <input type="number" class="form-control" name="abv" id="abv">
                <span class="input-group-text">%</span>
            </div>

        </div>

        <div class="col-md-6">

            <label for="" class="form-label">Bottle Size</label>

            <select class="form-select" id="bottle_size" name="bottle_size">

                <option value="">Select Bottle Size</option>

                <option value="375 ml">375 ml (Demie)</option>

                <option value="750 ml">750 ml (Standard)</option>

                <option value="1.5 L">1.5 L (Magnum)</option>

                <option value="3 L">3 L (Dbl Magnum)</option>

            </select>

        </div>

        <div class="col-12">

            <label for="" class="form-label">Residual Sugars</label>

            <div class="row g-2">
                @foreach (getResidualSugars() as $value => $label)
                    <div class="col-lg-4 col-sm-6">
                        <div class="form-check">
                            @php
                                if ($value == '120+') {
                                    $value__ = '120-150';
                                } else {
                                    $value__ = $value;
                                }
                                $rs_value_mix_max = explode('-', $value__);
                            @endphp
                            <input class="form-check-input" type="radio" name="rs"
                                id="rs-{{ $value }}" value="{{ $value }}"
                                {{ old('rs') == $value ? 'checked' : '' }}
                                onchange="clearOtherFields('{{ $value }}')">
                            <label class="form-check-label" for="rs-{{ $value }}">
                                {{ $label }}
                            </label>
                        </div>
                        <!-- Text input for the value associated with the radio button -->
                        <input type="number" step="0.01" min="{{ $rs_value_mix_max[0] }}"
                            max="{{ $rs_value_mix_max[1] }}" class="form-control rs-values mt-1"
                            id="rs-value-{{ $value }}" name="rs_values[{{ $value }}]"
                            value="{{ old('rs_values.' . $value) }}" placeholder="g/l">
                    </div>
                @endforeach
            </div>

        </div>

        <div class="col-md-6">
            <!-- <label for="" class="form-label">Inventory</label> -->
            <div class="d-flex align-items-center gap-2">
                <div>
                    <label for="casesInput" class="form-label">Cases</label>
                    <input type="number" class="form-control w-100" id="casesInput" min="0"
                        placeholder="Enter cases" style="width: 50%;">
                </div>
                <div>
                    <label for="bottlesInput" class="form-label">Bottles</label>
                    <input type="number" class="form-control w-100" id="bottlesInput" min="0"
                        placeholder="Enter bottles" style="width: 50%;">
                </div>
            </div>
            <input type="hidden" name="inventory" value="" id="inventory" class="form-control">
        </div>

        <div class="col-md-6">
            <div class="d-flex align-items-center gap-2">
                <div>
                    <label for="" class="form-label">Inventory</label>
                    <input type="number" class="form-control w-100 readonly" id="totalInventory" readonly
                        style="width: 50%;">
                </div>
                <div>
                    <label for="" class="form-label">SKU</label>
                    <input type="text" class="form-control w-100" style="width: 50%;" name="sku"
                        id="sku">

                </div>
            </div>
        </div>



        <div class="col-md-4">

            <label for="" class="form-label">Listed Price</label>

            <div class="input-group mb-3">

                <span class="input-group-text">$</span>

                <input type="text" name="cost" placeholder="0.00" onkeypress="return handleInput(event, this)"
                    id="cost" class="form-control" aria-label="Amount (to the nearest dollar)">

            </div>

        </div>

        <div class="col-md-4">

            <label for="" class="form-label">Stocking Fee</label>

            <input type="text" name="commission" placeholder="0.00" readonly
                onkeypress="return handleInput(event, this)" id="commission" class="form-control" id="">

        </div>

        <div class="col-md-4">

            <label for="" class="form-label">Reseller Price</label>

            <div class="input-group mb-3">

                <span class="input-group-text">$</span>

                <input type="text" name="price" placeholder="0.00" onkeypress="return handleInput(event, this)"
                    id="price" class="form-control" aria-label="Amount (to the nearest dollar)">

            </div>

        </div>
        <div class="col-12 cellaring-value-sec">

            <label for="" class="form-label">Cellaring Value</label>

            <div class="row g-2">
                <div class="col-lg-4 col-sm-6">
                    <div class="form-check cellaring-value-1 d-flex align-items-center gap-2 position-relative">
                        <input class="form-check-input" type="radio" name="cellar" id="cellar1"
                            value="Drink Now" {{ old('cellar') == 'Drink Now' ? 'checked' : '' }}>
                        <label class="form-check-label" for="cellar1">
                            <img src="{{ asset('images/wine-drink.png') }}" class="img-fluid" alt="Wine Image">
                            <p>Drink Now</p>
                        </label>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="form-check cellaring-value-2 d-flex align-items-center gap-2 position-relative">
                        <input class="form-check-input" type="radio" name="cellar" id="cellar2"
                            value="Drink or Cellar" {{ old('cellar') == 'Drink or Cellar' ? 'checked' : '' }}>
                        <label class="form-check-label" for="cellar2">
                            <img src="{{ asset('images/wine-drink.png') }}" class="img-fluid" alt="Wine Image">
                            <p>Drink or Hold</p>
                        </label>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="form-check cellaring-value-3 d-flex align-items-center gap-2 position-relative">
                        <input class="form-check-input" type="radio" name="cellar" id="cellar3" value="Cellar"
                            {{ old('cellar') == 'Cellar' ? 'checked' : '' }}>
                        <label class="form-check-label" for="cellar3">
                            <img src="{{ asset('images/wine-drink.png') }}" class="img-fluid" alt="Wine Image">
                            <p>Cellar</p>
                        </label>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-12">

            <label for="" class="form-label">Bottle Notes</label>

            <textarea class="form-control" name="description" id="description" rows="3"></textarea>

        </div>

        <div class="col-12 text-center">

            <button type="submit" id="submit-button" class="btn wine-btn w-25 px-3">Save</button>

        </div>

    </form>

    <!-- Form End  -->

</div>
<script>
    // document.getElementById('cost').addEventListener('input', calculatePrice);
    // document.getElementById('commission').addEventListener('input', calculatePrice);

    // function calculatePrice() {
    //     const cost = parseFloat(document.getElementById('cost').value) || 0;
    //     const commission = parseFloat(document.getElementById('commission').value) || 0;
    //     const totalPrice = cost + commission;

    //     document.getElementById('price').value = totalPrice.toFixed(2); // Formats to 2 decimal places
    // }
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
</script>
<script>
    $(document).ready(function() {

        $('#vendorWineFormAdd').validate({

            rules: {

                winery_name: {
                    required: true
                },

                series: {

                    required: true
                },

                abv: {

                    number: true

                },

                cost: {

                    number: true

                },

                commission: {

                    number: true

                },

                price: {
                    number: true
                },

                inventory: {
                    digits: true
                }

            },


            errorElement: "div", // error element as span

            errorPlacement: function(error, element) {

                error.insertAfter(element); // Insert error after the element

            },

            submitHandler: function(form, event) {

                // Handle AJAX submission here

                event.preventDefault();

                let formData = new FormData(form);

                $.ajax({

                    url: '{{ route('vendor-wines.store', $vendor_id) }}',

                    type: 'POST',

                    data: formData,

                    contentType: false, // Important: Prevent jQuery from processing the data

                    processData: false, // Important: Prevent jQuery from automatically converting the data to string

                    headers: {

                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token if required

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

                            // Optionally, close modal or reset form

                            $('#vendorWineFormAdd')[0].reset();

                            // $('#exampleModal').modal('hide');

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
    $(document).ready(function() {
        const defaultRegionId = 1; // Default region ID
        const subRegionDropdown = $('#sub_region');

        // Preselect the default region
        $('#region').val(defaultRegionId).trigger('change');

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

        // Load sub-regions for default region on page load
        @if ($vendor->sub_region == null)
            loadSubRegions(defaultRegionId);
        @endif
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
</script>
