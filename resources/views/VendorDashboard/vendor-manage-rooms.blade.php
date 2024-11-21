@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content') 
<div class="col right-side">   
    <!-- <div class="container my-5"> -->
        <div class="manage-room-table">
            <div class="text-end mb-4">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoom-modal">
                Add Room
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-custom text-center" id="roomslist">
                    <thead>
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">Room Style</th>
                            <th scope="col">Room Price</th>
                            <th scope="col">Inventory</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rooms as $key => $room)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $room->room_style }}</td>
                                <td>${{ $room->room_price }}</td>
                                <td>{{ $room->inventory }}</td>
                                <td>
                                    <a href="#" class="delete-room" data-id="{{ $room->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No rooms available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    <!-- </div> -->
</div>
<div class="modal fade" id="addRoom-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Room</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addRoomForm">
                    @csrf
                    <div>
                        <label class="form-label" for="room_style">Room Style</label>
                        <div class="input-group mb-3">
                            <select class="form-select" name="room_style" id="room_style">
                                <option selected value="">Open this select menu</option>
                                <option value="Presidential Suite">Presidential Suite</option>
                                <option value="Suite">Suite</option>
                                <option value="Connecting">Connecting</option>
                                <option value="Double">Double</option>
                                <option value="Standard">Standard</option>
                            </select>
                            <div class="invalid-feedback" id="error-room_style"></div>
                        </div>
                        
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">$</span>
                        <input type="text" class="form-control" name="room_price" id="room_price" placeholder="Room Price">
                        <div class="invalid-feedback" id="error-room_price"></div>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inventory">Inventory</span>
                        <input type="text" class="form-control" name="inventory" id="inventory" aria-describedby="inventory">
                        <div class="invalid-feedback" id="error-inventory"></div>
                    </div>
                    <div class="mb-3 w-50">
                        <label for="formFileSm" class="form-label">Upload Media</label>
                        <input class="form-control" id="room_image" name="room_image" type="file">
                        <div class="invalid-feedback" id="error-room_image"></div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn submit-btn btn-secondary">Create Room</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal -->
@endsection
@section('js')
<script>
    $(document).ready(function(e){
        let table = new DataTable('#roomslist');
    });
    $('#addRoomForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        // Clear previous errors
        $('.invalid-feedback').text('');

        $.ajax({
            url: "{{ route('manage.rooms.save', ['vendorid' => $vendor->id]) }}", // Replace with your route
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Handle success
                alert(response.success);
                window.location.reload();
                // $('#addRoom-modal').modal('hide');
            },
            error: function(response) {
                // Handle validation errors
                $("#room_style, #room_price, #inventory, #room_image").removeClass('is-invalid');
                var errors = response.responseJSON.errors;
                $.each(errors, function(key, value) {
                    // console.log(key,value[0])
                    $("#"+key).addClass('is-invalid')
                    $('#error-' + key).text(value[0]);
                });
            }
        });
    });
    $(document).on('click', '.delete-room', function(e) {
        e.preventDefault();
        var roomId = $(this).data('id');

        if(confirm('Are you sure you want to delete this room?')) {
            $.ajax({
                type: 'DELETE',
                url: "{{ route('vendor.rooms.delete', ['vendorid' => $vendor->id]) }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "roomId" : roomId
                },
                success: function(response) {
                    if(response.success) {
                        alert('Room deleted successfully');
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert('Failed to delete room');
                    }
                },
                error: function(response) {
                    alert('Error occurred while deleting room');
                }
            });
        }
    });

</script>
@endsection