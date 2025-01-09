<div class="tab-pane fade show active" id="tab-pane-amenties" role="tabpanel" aria-labelledby="tab-amenties" tabindex="0">
    <!-- Table Start -->
    <div class="table-users amenties-table text-center">
        <div class="table-responsive w-100">
            <table class="table w-100">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name of Amenities</th>
                        <th>Type</th>
                        <th>Activate</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($amenities))
                        @foreach ($amenities as $key => $amenity)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <div class="amenties-name d-flex align-items-center text-start gap-2">
                                        <i class="fw-bold {{ $amenity->amenity_icons }}"></i>
                                        {{ $amenity->amenity_name }}
                                    </div>
                                </td>
                                <td>
                                    @if ($amenity->amenity_type == 'Premium')
                                        <button type="button" class="btn status-btn active-btn">Premium</button>
                                    @else
                                        <button type="button" class="btn status-btn inactive-btn">Basic</button>
                                    @endif
                                </td>
                                <td>
                                    <div class="form-check form-switch d-flex justify-content-center">
                                        <input class="form-check-input amenities-save" data-id="{{ $amenity->id }}"
                                            type="checkbox" role="switch"
                                            @if ($amenity->vendors->first() && $amenity->vendors->first()->pivot->status == 'active') checked @endif>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <!-- Table End -->
</div>
<script>
    $(document).ready(function() {
        $(document).delegate(".amenities-save", "change", function() {
            let amenityId = $(this).data("id");
            let status = $(this).is(":checked") ? 1 : 0;

            $.ajax({
                url: '{{ route('admin.vendor.details.ajax-amenities-update', $vendor->id) }}',
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    amenity_id: amenityId,
                    status: status,
                },
                success: function(response) {
                    if (response.success) {
                        showToast("Success", response.message, "success");
                    } else {
                        showToast("Error", response.message, "error");
                    }
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON && xhr.responseJSON.message ?
                        xhr.responseJSON.message :
                        "An error occurred. Please try again.";
                    showToast("Error", errorMessage, "error");
                },
            });
        });
    });
</script>
