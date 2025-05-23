@extends('VendorDashboard.layouts.vendorapp')

@section('content')

    <div class="col right-side">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="information-box">
            <div class="information-box-head">
                <div class="box-head-heading d-flex align-items-center justify-content-between">
                    <span class="box-head-label theme-color">Edit Wine</span>
                    <div class="d-flex align-items-center gap-3">
                        <div class="form-check form-switch ms-3 d-flex align-items-center">
                            <input class="form-check-input me-2" type="checkbox" id="statusToggle" name="status"
                                value="1" {{ old('status', $wine->delisted == 0) ? 'checked' : '' }}>
                            <label class="form-check-label" for="statusToggle" id="toggleLabel">Publish</label>
                        </div>
                        <a href="#" class="btn wine-btn px-4 py-2">Preview</a>
                    </div>
                </div>
            </div>

            <div class="information-box-body">
                <!-- Form Start  -->
                <form class="row g-3" id="vendorWineFormEdit"
                    action="{{ route('vendor-wines.update', ['id' => $wine->id, 'vendorid' => $vendor_id]) }}"
                    method="POST" enctype="multipart/form-data">

                    @csrf

                    @method('PUT') <!-- Use PUT method for updating data -->

                    <div class="col-md-6">
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

                    <div class="col-md-6">
                        <label for="sub_region" class="form-label d-flex align-items-center">
                            Sub-Region
                        </label>
                        <select class="form-select {{ $wine->custom_sub_region ? 'd-none' : '' }}" id="sub_region"
                            name="sub_region" {{ $wine->custom_sub_region ? 'disabled' : '' }}>
                            <option value="">Select Sub-Region</option>
                            @foreach (getSubRegions($wine->region) as $subRegion)
                                <option value="{{ $subRegion->id }}"
                                    {{ $wine->sub_region == $subRegion->id ? 'selected' : '' }}>
                                    {{ $subRegion->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <h6 class="fw-bold">Varietal/Blend</h6>
                        <div id="dynamic-fields-container">
                            @php

                                $varietal_blends = json_decode($wine->varietal_blend, true);
                            @endphp
                            <div class="d-flex align-items-between gap-2">
                                <div class="w-50">
                                    <label for="varietal_blend" class="form-label">Percentage</label>
                                </div>
                                <div class="w-50">
                                    <label for="varietal_type" class="form-label">Varietal</label>
                                </div>
                            </div>
                            @php $usedVarietal = []; @endphp
                            @if (count($varietal_blends) > 0)
                                @foreach ($varietal_blends as $key => $varietal_blend)
                                    <div class="dynamic-field">
                                        <div class="d-flex align-items-center gap-2 {{ $key > 0 ? 'mt-2' : '' }}">
                                            <div class="w-50 d-flex align-items-center gap-2">
                                                <div class="input-group">
                                                    <input type="text" class="form-control percent"
                                                        name="varietal_blend[]" placeholder="Percentage"
                                                        value="{{ $varietal_blend['blend'] ?? '' }}">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                                <button type="button" class="btn btn-outline-danger remove-field">
                                                    <i class="fa-solid fa-circle-minus"></i>
                                                </button>
                                            </div>
                                            <div class="w-50">
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
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <!-- Extra empty select row for adding new varietal -->
                            <div class="dynamic-field">
                                <div class="d-flex align-items-center gap-2 mt-2">
                                    <div class="w-50 d-flex align-items-center gap-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control percent" name="varietal_blend[]"
                                                placeholder="Percentage">
                                            <span class="input-group-text">%</span>
                                        </div>
                                        <button type="button" class="btn btn-outline-success add-field">
                                            <i class="fa-solid fa-circle-plus"></i>
                                        </button>
                                    </div>
                                    <div class="w-50">
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
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Series/Line</label>

                        <input type="text" name="series" value="{{ old('series', $wine->series) }}"
                            class="form-control" id="Series">
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Label Name</label>

                        <input type="text" name="winery_name" id="winery_name"
                            value="{{ old('winery_name', $wine->winery_name) }}" class="form-control" id="Label">
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label for="vintage_date" class="form-label">Vintage</label>

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

                    <div class="col-lg-3 col-md-6">
                        <label for="" class="form-label">Release</label>

                        <input type="date" name="release" class="form-control">
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label for="sku" class="form-label">SKU</label>
                        <input type="text" class="form-control w-100" name="sku" id="sku"
                            value="{{ old('sku', $wine->sku) }}">
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label for="abv" class="form-label">Alcohol By Volume</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="abv" id="abv"
                                value="{{ old('abv', $wine->abv) }}">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="" class="form-label">Bottle Size</label>
                        <div class="d-flex align-items-center justify-content-between gap-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                    id="inlineRadio1" value="option1">
                                <label class="form-check-label" for="inlineRadio1">375 ml (Demie)</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                    id="inlineRadio2" value="option2">
                                <label class="form-check-label" for="inlineRadio2">750 ml (Standard)</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                    id="inlineRadio3" value="option3">
                                <label class="form-check-label" for="inlineRadio3">1.5 L (Magnum)</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                    id="inlineRadio4" value="option4">
                                <label class="form-check-label" for="inlineRadio4">3 L (Dbl Magnum)</label>
                            </div>
                        </div>
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

                    <div class="col-12 cellaring-value-sec">
                        <label for="" class="form-label">Cellaring Value</label>
                        <div class="row g-2">
                            <div class="col-lg-4 col-sm-6">
                                <div
                                    class="form-check cellaring-value-1 d-flex align-items-center gap-2 position-relative">
                                    <input class="form-check-input" type="radio" name="cellar" id="cellar1"
                                        value="Drink Now"
                                        {{ old('cellar', $wine->cellar) == 'Drink Now' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cellar1">
                                        <img src="{{ asset('images/wine-drink.png') }}" class="img-fluid"
                                            alt="Wine Image">
                                        <p>Drink Now (1-2yrs)</p>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div
                                    class="form-check cellaring-value-2 d-flex align-items-center gap-2 position-relative">
                                    <input class="form-check-input" type="radio" name="cellar" id="cellar2"
                                        value="Drink or Cellar"
                                        {{ old('cellar', $wine->cellar) == 'Drink or Cellar' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cellar2">
                                        <img src="{{ asset('images/wine-drink.png') }}" class="img-fluid"
                                            alt="Wine Image">
                                        <p>Drink or Hold (3-6yrs)</p>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div
                                    class="form-check cellaring-value-3 d-flex align-items-center gap-2 position-relative">
                                    <input class="form-check-input" type="radio" name="cellar" id="cellar3"
                                        value="Cellar" {{ old('cellar', $wine->cellar) == 'Cellar' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cellar3">
                                        <img src="{{ asset('images/wine-drink.png') }}" class="img-fluid"
                                            alt="Wine Image">
                                        <p>Cellar (7+yrs)</p>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="cost" class="form-label">Licensee Price</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">$</span>
                            <input type="text" name="cost" placeholder="0.00"
                                onkeypress="return handleInput(event, this)" id="cost" class="form-control"
                                value="{{ old('cost', $wine->cost) }}">
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
                            <input type="text" name="price" placeholder="0.00"
                                onkeypress="return handleInput(event, this)" id="price" class="form-control"
                                value="{{ old('price', $wine->price) }}">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label for="cost" class="form-label">Retail Price</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">$</span>
                            <input type="text" name="retail_price" placeholder="0.00"
                                onkeypress="return handleInput(event, this)" id="retail_price" class="form-control"
                                value="{{ old('retail_price', $wine->retail_price) }}">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label for="casesInput" class="form-label">Cases</label>
                        <input type="number" class="form-control w-100" id="casesInput" min="0"
                            placeholder="Enter cases">
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label for="bottlesInput" class="form-label">Bottles</label>
                        <input type="number" class="form-control w-100" id="bottlesInput" min="0"
                            placeholder="Enter bottles">
                        <input type="hidden" name="inventory" value="{{ old('inventory', $wine->inventory) }}"
                            id="inventory" class="form-control">
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label for="totalInventory" class="form-label">Inventory</label>
                        <input type="number" class="form-control w-100" id="totalInventory" readonly
                            value="{{ old('inventory', $wine->inventory) }}">
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

                    <div class="col-md-12">
                        <label for="description" class="form-label">Bottle Notes</label>
                        <textarea class="form-control" name="description" id="description" rows="3">{{ old('description', $wine->description) }}</textarea>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="image" class="form-label">Image</label>
                                <input class="form-control" type="file" name="image" id="image"
                                    accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label for="pdf" class="form-label">Upload PDF</label>
                                <input class="form-control" type="file" name="pdf" id="pdf"
                                    accept="application/pdf">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6 img-box d-flex flex-column align-items-center">
                                    @if ($wine->image)
                                        <img id="imagePreview" src="{{ asset('storage/' . $wine->image) }}"
                                            alt="{{ $wine->winery_name }}"
                                            style="max-width:100%; height:auto; max-height:200px;" />
                                        <button type="button" id="removeImage" class="btn btn-danger mt-2">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    @else
                                        <img id="imagePreview"
                                            src="{{ !empty($wine->image) ? asset('storage/' . $wine->image) : '' }}"
                                            alt="Image Preview"
                                            style="display:none; max-width:100%; height:auto; max-height:200px;" />
                                        <button type="button" id="removeImage" style="display:none;"
                                            class="btn btn-danger mt-2">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    @endif
                                    <input type="hidden" name="image_removed" id="imageRemoved" value="false">
                                </div>
                                <div class="col-md-6 d-flex flex-column align-items-center">
                                    @if (isset($wine) && $wine->pdf)
                                        <iframe id="pdfPreview" src="{{ asset('storage/' . $wine->pdf) }}"
                                            style="width:100%; height:200px; border:1px solid #ccc;"></iframe>
                                        <button type="button" id="removePdf"
                                            style="position: absolute; right: 0px; top: 0px; padding: 2px 8px;"
                                            class="btn btn-danger mt-2">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    @else
                                        <iframe id="pdfPreview" src=""
                                            style="display:none; width:100%; height:200px; border:1px solid #ccc;"></iframe>
                                        <button type="button" id="removePdf" style="display:none;"
                                            class="btn btn-danger mt-2">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    @endif
                                    <input type="hidden" name="remove_pdf" id="remove_pdf" value="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-center">
                        <input type="hidden" name="status" id="wineStatus" value="0">
                        <button type="submit" id="submit-button" class="btn wine-btn w-25 px-3">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Form End  -->
    <script>
        $(document).ready(function() {
            $.validator.addMethod('validImage', function(value, element) {
                const wineStatus = $('#wineStatus').val();

                // If not published, skip validation
                if (wineStatus != '1') return true;

                const hasPreviewImage = $('#imagePreview').attr('src')?.trim() !== '';

                // If image already exists, don't require a new upload
                if (hasPreviewImage) return true;

                // If no file selected, validation fails
                if (element.files.length === 0) return false;

                const file = element.files[0];
                const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                const maxSize = 5 * 1024 * 1024; // 5MB

                return validTypes.includes(file.type) && file.size <= maxSize;
            }, 'Please upload a valid image (jpg, png, gif) under 5MB.');
            $('#vendorWineFormEdit').validate({
                rules: {
                    winery_name: {
                        required: true,
                        remote: {
                            url: "{{ route('check-wine-name', $vendor_id) }}",
                            type: "post",
                            data: {
                                winery_name: function() {
                                    return $('#winery_name').val();
                                },
                                wine_id: function() {
                                    return "{{ $wine->id }}";
                                },
                                _token: function() {
                                    return $('meta[name="csrf-token"]').attr('content');
                                }
                            }
                        }
                    },
                    vintage_date: {

                        required: true
                    },

                    bottle_size: {

                        required: true
                    },

                    "varietal_type[]": {

                        required: true
                    },

                    "varietal_blend[]": {

                        required: true
                    },
                    image: {
                        required: {
                            depends: function() {
                                const isWineStatusPublished = $('#wineStatus').val() ===
                                    '1'; // Wine status is Publish
                                const hasPreviewImage = $('#imagePreview').attr('src') && $(
                                    '#imagePreview').attr('src') !== '';
                                return isWineStatusPublished && !hasPreviewImage;
                            }
                        },
                        validImage: true,
                    }
                },
                messages: {
                    winery_name: {
                        required: "Please enter a winery name",
                        remote: "Wine name already exists"
                    },
                    vintage_date: {
                        required: "Please enter a vintage date"
                    },
                    bottle_size: {
                        required: "Please enter a bottle size"
                    },
                    "varietal_type[]": {
                        required: "Please select at least one varietal type"
                    },
                    "varietal_blend[]": {
                        required: "Please enter at least one varietal blend"
                    }
                },
                errorElement: "div", // error element as span
                errorPlacement: function(error, element) {

                    error.insertAfter(element); // Insert error after the element

                },
                submitHandler: function(form, event) {
                    form.submit(); // Submit the form
                    // Handle AJAX submission here
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

                $('#casesInput').val(cases > 0 ? cases : '');
                $('#bottlesInput').val(remainingBottles > 0 ? remainingBottles : '');
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
    <script>
        document.getElementById('pdf').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const pdfPreview = document.getElementById('pdfPreview');
            const removePdf = document.getElementById('removePdf');

            if (file && file.size > 5 * 1024 * 1024) { // 5 MB in bytes
                swal.fire("Error!", "Please select a file less than 5MB.", "error");
                this.value = ''; // Clear the input
                return;
            }

            if (file && file.type === "application/pdf") {
                const objectURL = URL.createObjectURL(file);
                pdfPreview.src = objectURL;
                pdfPreview.style.display = "block";
                removePdf.style.display = "block";
                document.getElementById('remove_pdf').value = "0"; // Reset removal flag
            } else {
                alert("Please upload a valid PDF file.");
                event.target.value = ''; // Reset input
            }
        });

        document.getElementById('removePdf').addEventListener('click', function() {
            document.getElementById('pdf').value = "";
            document.getElementById('pdfPreview').style.display = "none";
            this.style.display = "none";
            document.getElementById('remove_pdf').value = "1"; // Mark for removal
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initial setup: add a remove button to all existing fields except the first one and remove any add button
            $('#dynamic-fields-container .dynamic-field:not(:first)').each(function() {
                $(this).find('.add-field').remove(); // Remove any existing add button
                if (!$(this).find('.remove-field').length) {
                    $(this).find('.d-flex.align-items-center').append(`
                <button type="button" class="btn btn-outline-danger remove-field"><i class="fa-solid fa-circle-minus"></i></button>
            `);
                }
            });

            // Add new field on click
            $(document).on('click', '#dynamic-fields-container .add-field', function() {
                // Get all selected options in existing dropdowns
                let selectedOptions = [];
                $('#dynamic-fields-container .dynamic-field select[name="varietal_type[]"]').each(
                    function() {
                        let value = $(this).val();
                        if (value) {
                            selectedOptions.push(value);
                        }
                    });

                // Remove add buttons from all other fields to ensure only the last one has the add button
                $('#dynamic-fields-container .dynamic-field .add-field').remove();

                let newField = `
                <div class="dynamic-field">
                    <div class="d-flex align-items-center gap-2 mt-2">
                        <button type="button" class="btn btn-outline-success add-field"><i class="fa-solid fa-circle-plus"></i></button>
                        <div class="w-75">
                            <select class="form-select" name="varietal_type[]">
                                <option value="">Select</option>
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
                                <input type="text" class="form-control percent" name="varietal_blend[]" placeholder="Varietal/Blend">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        
                    </div>
                </div>`;

                // Append new field to the container
                let $newField = $(newField);
                $('#dynamic-fields-container').append($newField);

                // Remove options from the new dropdown that are already selected in previous fields
                selectedOptions.forEach(function(value) {
                    $newField.find(`select[name="varietal_type[]"] option[value="${value}"]`)
                        .remove();
                });

                // Add remove buttons to all previous fields and remove any add buttons
                $('#dynamic-fields-container .dynamic-field:not(:last) .d-flex.align-items-center').each(
                    function() {
                        $(this).find('.add-field').remove(); // Remove add buttons
                        if (!$(this).find('.remove-field').length) {
                            $(this).prepend(`
                    <button type="button" class="btn btn-outline-danger remove-field"><i class="fa-solid fa-circle-minus"></i></button>
                `);
                        }
                    });
            });

            // Remove field on click
            $(document).on('click', '#dynamic-fields-container .remove-field', function() {
                $(this).closest('.dynamic-field').remove();
            });
        });
    </script>
    <script>
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
        $(document).on('change', '#image', function(event) {
            $('#imageRemoved').val('false');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result).show();
                    $('#removeImage').show();
                };
                reader.readAsDataURL(file);
            }
        });

        $(document).on('click', '#removeImage', function() {
            $('#image').val(''); // Clear the input value
            $('#imagePreview').attr('src', '').hide(); // Hide the image preview
            $(this).hide(); // Hide the remove button
            $('#imageRemoved').val('true');
        });
    </script>
    <script>
        $(document).on('shown.bs.modal', '#addWineModal', function() {
            const $toggle = $('#statusToggle');
            const $label = $('#toggleLabel');
            const $statusInput = $("#wineStatus");

            function updateLabel() {
                const isChecked = $toggle.is(':checked');
                $label.text(isChecked ? 'Publish' : 'Draft');
                $statusInput.val(isChecked ? 1 : 0);
            }

            // Attach change event (once modal content is visible)
            $toggle.off('change').on('change', updateLabel);

            // Set initial label
            updateLabel();
        });
    </script>
@endsection
