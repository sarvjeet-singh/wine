<div class="modal-header px-4">

    <h1 class="modal-title fw-bold fs-5" id="exampleModalLabel">Add Wine</h1>

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

            <label for="" class="form-label">Business / Vendor Name</label>

            <input type="text" name="" id="" value="{{ $vendor->vendor_name }}" readonly
                class="form-control">

        </div>
        {{-- <div class="col-md-4">

            <label for="" class="form-label">Winery Name</label>

            <input type="text" name="winery_name" id="winery_name" class="form-control">

        </div> --}}

        <div class="col-md-4">

            <label for="" class="form-label">Region</label>

            <select class="form-select" id="region" name="region" required>
                <option value="">Select Region</option>
                <option value="niagara" selected>Niagara</option>
            </select>

        </div>

        <div class="col-md-4">

            <label for="" class="form-label">Sub-Region</label>

            <select class="form-select" id="sub_region" name="sub_region">

                <option value="">Select Region</option>

                <option value="Niagara Falls">Niagara Falls</option>

                <option value="Niagara-on-the-Lake">Niagara-on-the-Lake</option>

                <option value="Niagara Escarpment">Niagara Escarpment</option>

                <option value="South Escarpment">South Escarpment</option>

                <option value="Fort Erie">Fort Erie</option>

            </select>

        </div>

        <div class="col-12">

            <div class="row g-3">
                <div class="col-md-4">
                    <label for="" class="form-label">Series</label>

                    <input type="text" name="series" class="form-control" id="Series">
                </div>
                <div class="col-md-8">

                    <div id="dynamic-fields-container">

                        <div class="dynamic-field">
                            <div class="d-flex align-items-between gap-2">
                                <div class="w-75" style="width: 61.5% !important">
                                    <label for="varietal_blend" class="form-label">Varietal/Blend</label>
                                </div>
                                <div class="w-75">
                                    <label for="varietal_type" class="form-label">Grape Varietals</label>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">

                                <div class="w-75">
                                    <div class="input-group">
                                        <input type="text" class="form-control percent" name="varietal_blend[]"
                                            placeholder="Varietal/Blend">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>

                                <div class="w-75">
                                    <select class="form-select" name="varietal_type[]">
                                        <option value="">Select</option>
                                        <option value="1">Cabernet Franc</option>
                                        <option value="2">Cabernet Sauvignon</option>
                                        <option value="3">Chardonnay</option>
                                        <option value="4">Gamay Noir</option>
                                        <option value="5">Gewürztraminer</option>
                                        <option value="6">Merlot</option>
                                        <option value="7">Pinot Noir</option>
                                        <option value="8">Riesling</option>
                                    </select>
                                </div>

                                <button type="button" class="btn btn-outline-success add-field"><i
                                        class="fa-solid fa-circle-plus"></i></button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-12">

            <label for="" class="form-label">Cellaring Value</label>

            <div class="row g-2">
                <div class="col-lg-4 col-sm-6">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cellar" id="cellar1"
                            value="Drink Now" {{ old('cellar') == 'Drink Now' ? 'checked' : '' }}>
                        <label class="form-check-label" for="cellar1">
                            Drink Now
                        </label>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cellar" id="cellar2"
                            value="Drink or Cellar" {{ old('cellar') == 'Drink or Cellar' ? 'checked' : '' }}>
                        <label class="form-check-label" for="cellar2">
                            Drink or Cellar
                        </label>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cellar" id="cellar3" value="Cellar"
                            {{ old('cellar') == 'Cellar' ? 'checked' : '' }}>
                        <label class="form-check-label" for="cellar3">
                            Cellar
                        </label>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-6">

            <label for="" class="form-label">Vintage Date</label>

            <select class="form-select" id="vintage_date" name="vintage_date">
                @foreach (range(date('Y'), 1900) as $year)
                    <option value="{{ $year }}">{{ $year }}</option>';
                @endforeach
            </select>

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

        <div class="col-md-6">

            <label for="" class="form-label">Alcohol By Volume</label>

            <!-- <input type="number" class="form-control" step="0.01" min="0" max="100" name="abv_rs"

                id="abv_rs"> -->

            <div class="input-group">
                <input type="text" class="form-control percent" name="abv" id="abv">
                <span class="input-group-text">%</span>
            </div>

        </div>

        <div class="col-12">

            <label for="" class="form-label">Residual Sugars</label>

            <div class="row g-2">
                <div class="col-lg-4 col-sm-6">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="rs" id="rs1" value="0-1"
                            {{ old('rs') == '0-1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="rs1">
                            0 - 1 g/l (Bone Dry)
                        </label>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="rs" id="rs2" value="1-9"
                            {{ old('rs') == '1-9' ? 'checked' : '' }}>
                        <label class="form-check-label" for="rs2">
                            1 - 9 g/l (Dry)
                        </label>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="rs" id="rs3" value="10-49"
                            {{ old('rs') == '10-49' ? 'checked' : '' }}>
                        <label class="form-check-label" for="rs3">
                            10 - 49 g/l (Off Dry)
                        </label>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="rs" id="rs4" value="50-120"
                            {{ old('rs') == '50-120' ? 'checked' : '' }}>
                        <label class="form-check-label" for="rs4">
                            50 - 120 g/l (Semi-Sweet)
                        </label>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="rs" id="rs5" value="120+"
                            {{ old('rs') == '120+' ? 'checked' : '' }}>
                        <label class="form-check-label" for="rs5">
                            120+ g/l (Sweet)
                        </label>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-6">
            <label for="" class="form-label">Inventory</label>
            <div class="d-flex align-items-center gap-2">
                <input type="number" class="form-control" id="casesInput" min="0" placeholder="Enter cases"
                    style="width: 50%;">
                <input type="number" class="form-control" id="bottlesInput" min="0"
                    placeholder="Enter bottles" style="width: 50%;">
            </div>
            <input type="hidden" name="inventory" value="" id="inventory" class="form-control">
        </div>

        <div class="col-md-6">

            <label for="" class="form-label">SKU</label>

            <input type="text" class="form-control" name="sku" id="sku">

        </div>



        <div class="col-md-4">

            <label for="" class="form-label">Cost</label>

            <div class="input-group mb-3">

                <span class="input-group-text">$</span>

                <input type="text" name="cost" placeholder="0.00" onkeypress="return handleInput(event, this)" id="cost" class="form-control"
                    aria-label="Amount (to the nearest dollar)">

            </div>

        </div>

        <div class="col-md-4">

            <label for="" class="form-label">Stocking/Delivery Fee</label>

            <input type="text" name="commission" placeholder="0.00" onkeypress="return handleInput(event, this)" id="commission" class="form-control" id="">

        </div>

        <div class="col-md-4">

            <label for="" class="form-label">Price</label>

            <div class="input-group mb-3">

                <span class="input-group-text">$</span>

                <input type="text" name="price" placeholder="0.00" onkeypress="return handleInput(event, this)" id="price" class="form-control"
                    aria-label="Amount (to the nearest dollar)">

            </div>

        </div>

        <div class="col-md-12">

            <label for="" class="form-label">Bottle Notes</label>

            <textarea class="form-control" name="description" id="description" rows="3"></textarea>

        </div>

        <div class="col-12 text-center">

            <button type="submit" id="submit-button" class="btn btn-primary w-25">Save</button>

        </div>

    </form>

    <!-- Form End  -->

</div>
<script>
    document.getElementById('cost').addEventListener('input', calculatePrice);
    document.getElementById('commission').addEventListener('input', calculatePrice);

    function calculatePrice() {
        const cost = parseFloat(document.getElementById('cost').value) || 0;
        const commission = parseFloat(document.getElementById('commission').value) || 0;
        const totalPrice = cost + commission;

        document.getElementById('price').value = totalPrice.toFixed(2); // Formats to 2 decimal places
    }
</script>
<script>
    $(document).ready(function() {

        $('#vendorWineFormAdd').validate({

            rules: {

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
