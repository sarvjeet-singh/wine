<div class="tab-pane fade show active" id="tab-pane-wine-listing" role="tabpanel" aria-labelledby="tab-wine-listing"
    tabindex="0">
    <div class="information-box mb-3">
        <div class="info-head p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text-white">Listing of Wines</div>
            </div>
        </div>
        <div class="m-3 pb-4">
            <div class="row g-4">
                <div class="col-12">
                    <div class="dashboard-card">
                        <form>
                            <!-- Table Start -->
                            <div class="table-users text-center">
                                <div class="table-responsive w-100">
                                    <table class="table w-100">
                                        <tr>

                                            <th scope="col">S.No</th>

                                            <th scope="col">Series</th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Inventory</th>
                                            <th scope="col">Stocking Fee</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Listed</th>

                                            <th scope="col">Action</th>

                                        </tr>
                                        <tbody>
                                            @foreach ($wines as $key => $wine)
                                                <tr>

                                                    <td>{{ $key + 1 }}</td>

                                                    <td>{{ $wine->series }}</td>

                                                    <td>
                                                        @if ($wine->image)
                                                            <img src="{{ $wine->image && file_exists(public_path('storage/' . $wine->image)) ? url('storage/' . $wine->image) : url('images/default-wine.jpg') }}"
                                                                style="width: 50px; height: 50px;"
                                                                alt="{{ $wine->winery_name }}">
                                                        @endif
                                                    </td>

                                                    <td>{{ $wine->inventory }}</td>

                                                    <td>
                                                        <div class="input-group">

                                                            <span class="input-group-text">$</span>

                                                            <input type="text" data-cost="{{ $wine->cost }}"
                                                                name="commission_delivery_fee" placeholder="0.00"
                                                                onkeypress="return handleInput(event, this)"
                                                                class="form-control cost"
                                                                value="{{ $wine->commission_delivery_fee }}">

                                                        </div>
                                                    </td>
                                                    <td class="price">${{ $wine->price }}</td>
                                                    <td>{{ $wine->delisted == 0 ? 'Yes' : 'No' }}</td>

                                                    <td>

                                                        <a href="javascript:void(0)" class="open-modal-btn"
                                                            data-url=

                                "{{ route('admin.vendor.details.ajax-view-wine', ['id' => $vendor->id, 'wine_id' => $wine->id]) }}"
                                                            data-id="{{ $vendor->id }}"><i
                                                                class="fa-regular fa-eye"></i></a>
                                                        <a href="javascript:void(0)" class="update-wine-btn"
                                                            data-url=

                                "{{ route('admin.vendor.details.ajax-update-wine', ['id' => $vendor->id, 'wine_id' => $wine->id]) }}"
                                                            data-id="{{ $vendor->id }}"><i
                                                                class="fa-solid fa-refresh"></i></a>



                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Table End -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
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

        $(document).on('click', '.open-modal-btn', function() {

            // Get the URL or data-id to load content (if needed)

            var url = $(this).data('url');



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

        $(".update-wine-btn").click(function(e) {
            e.preventDefault();
            var commission_delivery_fee = $(this).closest('tr').find('.cost').val();
            $.ajax({
                url: $(this).data('url'),
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "stocking_fee": commission_delivery_fee
                },
                success: function(response) {
                    if (response.status === 'success') {
                        showToast("Success", response.message, "success");
                    }
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON && xhr.responseJSON.message ?
                        xhr.responseJSON.message :
                        "An error occurred. Please try again.";
                    showToast("Error", errorMessage, "error");
                }

            });
        });
        $(document).on("blur", ".cost", function(e) {
            e.preventDefault();
            var stocking_fee = parseFloat($(this).val()) ||
                0; // Convert to float, default to 0 if invalid
            var cost = parseFloat($(this).attr('data-cost')) ||
                0; // Convert to float, default to 0 if invalid
            var totalPrice = (cost + stocking_fee).toFixed(
                2); // Ensure the result is formatted to 2 decimal places
            $(this).closest('tr').find('td.price').text('$' + totalPrice);
            let $icon = $(this) // Starting point: the input
                .closest('td') // Go to the closest parent td
                .siblings() // Find sibling elements
                .find('a.update-wine-btn').trigger('click');
            
        });
    });
</script>
