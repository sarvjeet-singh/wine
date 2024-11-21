   


    @if($Vendor->vendorRooms)
        @foreach($Vendor->vendorRooms as $vendorRoom)
            <tr>
                <td class="room-img"><img src="{{asset($vendorRoom->room_image)}}"></td>
                <td>{{$vendorRoom->room_style}}</td>
                <td class="room-avail"><div class="quantity-control">
                        <button class="btn btn-decrease" data-room-id="1">-</button>
                        <input type="number" class="form-control room-quantity-input" value="0" min="0" data-max="{{$vendorRoom->inventory}}" data-room-id="1">
                        <button class="btn btn-increase" data-room-id="1">+</button>
                    </div>
                </td>
                <td>
                    <span class="room-price d-block fw-bold mb-2">${{$vendorRoom->room_price}}/per night</span>
                    <button class="btn">Select Room</button>
                </td> 
            </tr>
        @endforeach
    @endif