@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Vendor Dashboard')

@section('content')
    <div class="col right-side">
        <div class="row">
            <div class="col-sm-3">
                <div class="top-boxes">
                    <div class="box-image">
                        <img src="{{ asset('images/icons/total_booking_icon.png') }}">
                    </div>
                    <div class="box-points">{{ $usersCount }}</div>
                    <div class="box-text mt-1">Total Users/QR code users</div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="top-boxes">
                    <div class="box-image">
                        <img src="{{ asset('images/icons/Inquiries-box-icon.png') }}">
                    </div>
                    <div class="box-points">{{ $mostCommonLocation->city ?? '' }},
                        {{ ucwords($mostCommonLocation->country ?? '') }}</div>
                    <div class="box-text">Guest Origins</div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="top-boxes">
                    <div class="box-image">
                        <img src="{{ asset('images/icons/vendor-reviews-box-icon.png') }}">
                    </div>
                    <div class="box-points">{{ $reviewData->review_count }}/{{ round($reviewData->average_rating, 1) }}
                    </div>
                    <div class="box-text">What People Think</div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="top-boxes">
                    <div class="box-image">
                        <img src="{{ asset('images/icons/enhance-points-box.png') }}">
                    </div>
                    <div class="box-points">0</div>
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
                                    @if (strtolower($vendor->vendor_type) == 'accommodation')
                                        <div class="col-sm-5">
                                            <label>Current Rate</label>
                                        </div>
                                        <div class="col-sm-7 text-right">
                                            <span
                                                id="current-rate">${{ number_format($vendor->pricing->current_rate ?? 0, 2) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        {{-- @if ($vendor->account_status != 1) --}}
                                            <button id="checkActivationBtn" class="btn btn-primary wine-btn rounded-2 px-3">
                                                Complete Your Profile
                                            </button>
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4 col-9 text-right">
                                <img src="{{ asset($vendor->qr_code) }}" id="qr-code-img" style="width:120px">
                            </div>
                            <div class="col-sm-2 col-3">
                                <img id="download-qr" src="{{ asset('images/icons/download.png') }}" width="80">
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
                                @if ($VendorMediaGallery)
                                    @foreach ($VendorMediaGallery as $media)
                                        <div class="box-gallary-images-column ">
                                            @if ($media->vendor_media_type == 'image')
                                                <img src="{{ asset($media->vendor_media) }}"
                                                    class="box-gallary-images rounded-4">
                                            @elseif($media->vendor_media_type == 'youtube')
                                                <iframe width="135px" src="{{ $media->vendor_media }}" frameborder="0"
                                                    allowfullscreen></iframe>
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
    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalLabel">Your profile is incomplete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="errorIntro">
                        Your profile is incomplete. Please complete the following required sections to get Vendor Partner
                        status:
                    </p>
                    <ul id="errorMessage" class="mb-0 list-unstyled"></ul>
                </div>
                <div class="modal-footer">
                    <p id="completionNote">
                        Once all sections are complete, your account can be upgraded to “Vendor Partner”, with full access to all utilities and a “Dedicated Vendor Page”.
                    </p>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
        // $(document).ready(function() {
        //     $('#checkActivationBtn').click(function() {
        //         let vendorid = "{{ $vendor->id }}"; // Get vendor ID

        //         // Show confirmation alert
        //         Swal.fire({
        //             title: "Are you sure?",
        //             text: "Do you want to check if the subscription can be activated?",
        //             icon: "warning",
        //             showCancelButton: true,
        //             confirmButtonColor: "#3085d6",
        //             cancelButtonColor: "#d33",
        //             confirmButtonText: "Yes, check now!",
        //             cancelButtonText: "Cancel"
        //         }).then((result) => {
        //             if (result.isConfirmed) {
        //                 // Proceed with AJAX request if confirmed
        //                 $.ajax({
        //                     type: 'POST',
        //                     url: "{{ route('vendor.activation.check') }}" + '/' + vendorid,
        //                     data: {
        //                         vendorid: vendorid, // Sending vendor ID in the body
        //                     },
        //                     dataType: 'json',
        //                     headers: {
        //                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                     },
        //                     success: function(response) {
        //                         Swal.fire("Success!", response.message, "success");
        //                     },
        //                     error: function(xhr) {
        //                         let errorMessage = 'Cannot activate subscription.';

        //                         if (xhr.responseJSON && xhr.responseJSON.message) {
        //                             if (Array.isArray(xhr.responseJSON.message)) {
        //                                 // Convert array messages to a bulleted list with <br>
        //                                 errorMessage = xhr.responseJSON.message.map(
        //                                     msg => `• ${msg}`).join('<br>');
        //                             } else {
        //                                 errorMessage = `• ${xhr.responseJSON.message}`;
        //                             }
        //                         }

        //                         Swal.fire({
        //                             title: "Error!",
        //                             html: errorMessage, // Use 'html' to render new lines with <br>
        //                             icon: "error",
        //                             showConfirmButton: true
        //                         });
        //                     }
        //                 });
        //             }
        //         });
        //     });
        // });
        $(document).ready(function() {
            $('#checkActivationBtn').click(function() {
                let vendorid = "{{ $vendor->id }}"; // Get vendor ID

                $.ajax({
                    type: 'POST',
                    url: "{{ route('vendor.activation.check') }}" + '/' + vendorid,
                    data: {
                        vendorid: vendorid
                    },
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        let messages = '';

                        if (response.message && Array.isArray(response.message)) {
                            messages = response.message.map(item => {
                                let color = item.completed ? 'green' : item
                                    .is_optional ? 'orange' : 'red';
                                let icon = item.completed ? '✅' : item.is_optional ?
                                    '⚠️' : '❌';

                                return `<li style="color: ${color};">
            ${icon} ${item.message}
        </li>`;
                            }).join('');
                        } else {
                            messages =
                                `<li style="color: green;">✅ Vendor is eligible for activation</li>`;
                        }

                        $('#errorMessage').html(messages);

                        if (response.success) {
                            $('#errorModalLabel').text('Your profile is complete ✅');
                            $("#errorIntro").text('Your profile is complete now!');
                            $("#completionNote").text(
                                'All sections are completed, your profile will be upgraded to Vendor Partner status.'
                            );
                            $('#checkActivationBtn').remove();
                            $(".modal-header").removeClass("bg-danger").addClass("bg-success");
                        } else {
                            $('#errorModalLabel').text('Your profile is incomplete ❌');
                        }

                        $('#errorModal').modal('show');
                    },
                    error: function() {
                        $('#errorMessage').html(
                            "<li style='color: red;'>❌ Something went wrong. Please try again.</li>"
                        );
                        $('#errorModalLabel').text('Error ❌');
                        $('#errorModal').modal('show');
                    }
                });
            });
        });
        $(document).ready(function() {
            $('#errorModal').on('hidden.bs.modal', function() {
                location.reload();
            });
        });
    </script>
@endsection
