@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Vendor Dashboard')

@section('content')
    <div class="col right-side">
        <div class="table-responsive">
            <table class="table table-custom amenties-table text-center">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Name of Amenities</th>
                        <th scope="col">Type</th>
                        <th scope="col">Activate</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($amenities))
                        @foreach ($amenities as $key => $amenity)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <div class="amenties-name d-flex align-items-center text-start">
                                        <i class="{{ $amenity->amenity_icons }}"></i>
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
                                            type="checkbox" role="switch" @if ($amenity->vendors->first() && $amenity->vendors->first()->pivot->status == 'active') checked @endif>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $(document).delegate(".amenities-save", "change", function() {
                let amenityId = $(this).data('id');
                let status = $(this).is(':checked') ? 1 : 0;

                $.ajax({
                    url: '{{ route('vendor.amenities.save', ['vendorid' => $vendor->id]) }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        amenity_id: amenityId,
                        status: status
                    },
                    success: function(response) {
                        if (response.success) {
                            // alert(response.message);
                        } else {
                            // alert('Something went wrong. Please try again.');
                        }
                    },
                    error: function(xhr) {
                        // alert('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>

@endsection
