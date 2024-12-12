@extends('VendorDashboard.layouts.vendorapp')



@section('title', 'Wine Country Weekends - Guest Registry')



@section('content')

    <style type="text/css">
        /******DON'T COPY THIS CSS*****/

        .table-custom th {

            background-color: #118c9730;

            padding: 20px 30px 20px 10px !important
        }



        .table-custom th:first-child {

            border-top-left-radius: 15px;

        }



        .table-custom th:last-child {

            border-top-right-radius: 15px;

        }



        .btn-primary,

        .btn-primary:hover {

            background-color: #348a96;

            border-color: #348a96;

        }



        .form-control:focus,

        .form-select:focus {

            background-color: #fff;

            border-color: #348a96 !important;

            outline: 0;

            box-shadow: none;

        }





        /*************** COPY THIS CSS ***************/

        .dt-search [type=search] {

            outline: none;

        }



        .dt-length label {

            padding-left: 10px;

            text-transform: capitalize;

        }



        .wine-vintage-table a {

            color: #348a96;

        }



        .wine-vintage-table th {

            white-space: nowrap;

            border-bottom: none !important;

            outline: none !important;

            text-align: left !important;

        }



        .wine-vintage-table tbody td {

            padding: 20px 8px;

            color: #757575;

            text-align: left !important;

        }



        #addWine-modal .form-label {

            font-weight: bold;

        }



        #addWine-modal .modal-title {

            color: #348a96;

        }



        #addWine-modal .fa-circle-plus {

            width: 20px;

            height: 20px;

            color: #348a96;

        }



        .error {

            font-size: 12px;

            color: red;

            font-style: italic;

        }



        div.error {

            width: 100%;

        }

        .img-box {
            position: relative;
        }

        #removeImage {
            position: absolute;
            top: -23px;
            right: 0px;
        }
    </style>

    <div class="col right-side">

        <div class="text-end mb-4">

            <button type="button" class="btn wine-btn rounded px-4 open-modal-btn" data-url=

            "add"
                data-id="{{ $vendor_id }}">

                Add Wine

            </button>

        </div>

        <div class="table-responsive">

            <table class="table table-custom wine-vintage-table text-center" id="wine-vintageTable">

                <thead>

                    <tr>

                        <th scope="col">S.No</th>

                        <th scope="col">Series</th>
                        <th scope="col">Image</th>
                        <th scope="col">Inventory</th>

                        <th scope="col">Price</th>
                        <th scope="col">Listed</th>

                        <th scope="col">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($wines as $key => $wine)
                        <tr>

                            <td>{{ $key + 1 }}</td>

                            <td>{{ $wine->series }}</td>

                            <td>
                                @if ($wine->image)
                                    <img src="{{ $wine->image && file_exists(public_path('storage/' . $wine->image)) ? url('storage/' . $wine->image) : url('images/default-wine.jpg') }}"
                                        style="width: 50px; height: 50px;" alt="{{ $wine->winery_name }}">
                                @endif
                            </td>

                            <td>{{ $wine->inventory }}</td>

                            <td>${{ $wine->price }}</td>
                            <td>{{ $wine->delisted == 0 ? 'Yes' : 'No' }}</td>

                            <td>

                                <a href="javascript:void(0)" class="open-modal-btn"
                                    data-url=

                                "edit/{{ $wine->id }}"
                                    data-id="{{ $vendor_id }}"><i class="fa-regular fa-pen-to-square"></i></a>

                                <a class="btn-delete mx-2" data-id="{{ $wine->id }}"
                                    data-vendor_id="{{ $vendor_id }}"
                                    href="{{ route('vendor-wines.destroy', ['id' => $wine->id, 'vendorid' => $vendor_id]) }}"><i
                                        class="fa-solid fa-trash"></i></a>

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>



    <!-- Add Wine POPUP HTML START -->

    <div class="modal fade" id="addWineModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content">



            </div>

        </div>

    </div>

    <!-- Add Wine POPUP HTML END -->

@endsection

@section('js')

    <!-- jQuery Validation Plugin -->

    <script>
        $(document).ready(function(e) {

            let table = new DataTable('#wine-vintageTable', {

                language: {

                    emptyTable: "No inquiries available at the moment"

                }

            });

        });
    </script>

    <script>
        $(document).ready(function() {

            $(document).on('click', '.open-modal-btn', function() {

                // Get the URL or data-id to load content (if needed)

                var url = $(this).data('url') + '/' + $(this).data('id');



                // Clear previous modal content

                $('#addWineModal .modal-content').html('');



                // Make the AJAX request

                $.ajax({

                    url: url, // URL to fetch the data from

                    type: 'GET',

                    dataType: 'html', // Expect HTML response

                    beforeSend: function() {

                        // Optionally show a loader before sending the request

                        $('#addWineModal .modal-content').html(

                            '<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>'

                        );

                    },

                    success: function(response) {

                        // Insert the fetched HTML into the modal's body

                        $('#addWineModal .modal-content').html(response);



                        // Show the modal after data is fully loaded

                        $('#addWineModal').modal('show');

                    },

                    error: function(xhr) {

                        // Handle error

                        $('#addWineModal .modal-content').html(

                            '<p>Error loading data. Please try again later.</p>');

                    }

                });

            });

        });
    </script>

    <script>
        $(document).ready(function() {
            // Handle click on delete button
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault(); // Prevent the default form submission
                var url = $(this).attr('href');

                // Use SweetAlert2 for confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You can revert this later!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delist it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, send the AJAX request
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Delisted!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                    }).then(() => {
                                        location.reload(); // Reload the page
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: response.message,
                                        icon: 'error',
                                        confirmButtonText: 'OK',
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'An error occurred. Please try again.',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                });
                            },
                        });
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

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

@endsection
