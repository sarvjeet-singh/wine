@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Vendor Dashboard')

@section('content')
    <div class="col right-side">
        <div class="row">
            <div class="col-sm-3">
                <div class="top-boxes">
                    <div class="box-image">
                        <img src="{{asset('images/icons/total_booking_icon.png')}}">
                    </div>
                    <div class="box-points">{{ $usersCount }}</div>
                    <div class="box-text mt-1">Guest Rewards</div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="top-boxes">
                    <div class="box-image">
                        <img src="{{asset('images/icons/Inquiries-box-icon.png')}}">
                    </div>
                    <div class="box-points">{{ $mostCommonLocation->city ?? '' }}, {{ucwords($mostCommonLocation->country ?? '')}}</div>
                    <div class="box-text">Guest Origins</div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="top-boxes">
                    <div class="box-image">
                        <img src="{{asset('images/icons/vendor-reviews-box-icon.png')}}">
                    </div>
                    <div class="box-points">{{ $reviewData->review_count }}, {{ round($reviewData->average_rating, 1) }}</div>
                    <div class="box-text">What People Think</div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="top-boxes">
                    <div class="box-image">
                        <img src="{{asset('images/icons/enhance-points-box.png')}}">
                    </div>
                    <div class="box-points">40</div>
                    <div class="box-text">Engagement Points</div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-sm-12">
                <div class="information-box">
                    <div class="information-box-body">
                        <div class="row mt-3">
                            <div class="col-sm-6 col-12">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <label>Vendor</label>
                                    </div>
                                    <div class="col-sm-7 text-right">
                                    <span>{{ ucfirst($vendor->vendor_type ?? '') }}</span>
                                    </div>
                                    <div class="col-sm-5">
                                        <label>Sub Type</label>
                                    </div>
                                    <div class="col-sm-7 text-right">
                                        <span>{{ !empty($vendor->sub_category) ? $vendor->sub_category->name : '' }}</span>
                                    </div>
                                    <div class="col-sm-5">
                                        <label>Account Status</label>
                                    </div>
                                    <div class="col-sm-7 text-right">
                                        
                                        <span>{{ !empty($vendor->account_status) ? $vendor->accountStatus->name : '' }}</span>
                                    </div>
                                    <div class="col-sm-5">
                                        <label>Current Rate</label>
                                    </div>
                                    <div class="col-sm-7 text-right">
                                    <span id="current-rate">${{ number_format($vendor->pricing->current_rate ?? 0, 2) }}</span>
                                    </div>
                                
                                </div>
                            </div>
                        
                            <div class="col-sm-4 col-9 text-right">
                                <img src="{{asset($vendor->qr_code)}}" id="qr-code-img" style="width:120px">
                            </div>
                            <div class="col-sm-2 col-3">
                                <img id="download-qr" src="{{asset('images/icons/download.png')}}" width="80">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-sm-12">
                <div class="information-box">
                    <div class="information-box-body">
                        <div class="box-body-label theme-color">Gallary</div>
                        <div class="row mt-3 d-flex">
                            <div class="box-gallary-images-row">
                                @if($VendorMediaGallery)
                                    @foreach($VendorMediaGallery as $media)
                                        <div class="box-gallary-images-column ">
                                            @if($media->vendor_media_type == 'image')
                                                <img src="{{asset($media->vendor_media)}}" class="box-gallary-images rounded-4">
                                            @elseif($media->vendor_media_type == 'youtube')
                                                <iframe width="135px" src="{{ $media->vendor_media }}" frameborder="0" allowfullscreen></iframe>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')

<script>
    $(document).ready(function() {
        // Get the initial value and format it

        $('#download-qr').on('click', function() {
            // alert();
            const qrImage = $('#qr-code-img');
            const link = $('<a></a>')
                .attr('href', qrImage.attr('src'))
                .attr('download', 'qr_code.png');
            $('body').append(link);
            link[0].click();
            link.remove();
        });
    });
</script>
@endsection