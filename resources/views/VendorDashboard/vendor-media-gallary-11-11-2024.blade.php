@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Vendor Dashboard')

@section('content')
    <div class="col right-side">
        <div class="row">
            <div class="col-sm-12">
                <div class="information-box">
                    <div class="information-box-head">
                        <div class="box-head-heading d-flex">
                            <span class="box-head-label theme-color">Media Gallary</span>
                        </div>
                        <div class="box-head-description mt-3">
                            Please upload JPG and PNG images formats
                        </div>
                    </div>
                    <div class="information-box-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                            
                        <div class="row mt-3">
                            <div class="box-gallary-7-images-row">
                                <div class="box-gallary-images-column select-box-gallary-images-column" @if($VendorMediaGallery->count() > 5 ) style="display:none" @endif>
                                    <label for="front_License_image" class="custom-file-label upload-button">
                                        <img src="{{asset('images/media-gallary/plus-icon.png')}}" width="20">
                                    </label>
                                </div>
                                @if($VendorMediaGallery)
                                    @foreach($VendorMediaGallery as $media)
                                        <div class="box-gallary-images-column position-relative">
                                            <a href="javascript:void(0)" class="dlt-icon vendor-media-delete" data-id="{{$media->id}}" data-type="{{$media->vendor_media_type}}"><i class="fa-solid fa-trash"></i></a>
                                            @if($media->vendor_media_type == 'image')
                                                <img src="{{asset($media->vendor_media)}}" class="box-gallary-7-images rounded-4">
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

    <div class="modal mediaGalleryModal fade" id="editMediaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-sm-4 p-2">
                <div class="modal-header border-0">
                    <h3 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Edit Media Gallery</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('vendor.upload_media', ['vendorid' => $vendor->id]) }}" id="upload_media">
                        @csrf
                        <input type="hidden" value="" name="vendorImage" class="base64imageupload">
                        <div class="mb-5 image_section">
                            <label class="form-label">Add photo</label>
                            <div class="position-relative select_image_section">
                                <label class="custom-file-label" for="upload_photo_video">
                                    <img src="{{asset('images/media-gallary/plus-icon.png')}}" width="20">
                                </label>
                                <input type="file" accept="image/*" class="custom-file-input" id="upload_photo_video">
                            </div>
                            <div class="profile-image-upload-section"></div>
                        </div>

                        <div class="mb-5 text-center or_section">
                            <b>OR</b>
                        </div>
                        <div class="mb-3 youtube_section">
                            <label class="form-label">Add Youtube Link</label>
                            <input type="text" class="form-control add_youtube_link" placeholder="Add Link" name="youtube_link">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn save-btn upload-image-youtube-button">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cropImage" tabindex="-1" role="dialog" aria-labelledby="cropImageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Profie Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 profile-image-upload-section">
                        <img class="image" style="Width:100%">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary image-crop">Crop & Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    $('.upload-button').click(function(){
        $('#upload_photo_video, .add_youtube_link, .base64imageupload').val('');
        $('.select_image_section, .or_section, .youtube_section').show();
        $('#editMediaModal .profile-image-upload-section').html('').hide();
        $('.upload-image-youtube-button').prop('disabled', true);
        $(".mediaGalleryModal").modal('show');
    });
    $(document).delegate("#upload_photo_video","change", function(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {

                $("#cropImage").modal('show');
                $('#cropImage .profile-image-upload-section').html('<img src="" id="image" class="image" style="Width:100%">');
                var $image = $('#cropImage .profile-image-upload-section #image');
                if ($image.data('rcrop')) {
                    $image.rcrop('destroy');
                }
                // var url  = e.target.result;
                $image.attr('src', e.target.result);
                // Initialize rcrop after the image is loaded
                $image.on('load', function() {
                    setTimeout(() => {
                        // $image.rcrop('destroy').off('load');
                        // alert();
                        $(this).rcrop({
                            preserveAspectRatio: true,
                            minSize: [16, 10.2],
                            preserveAspectRatio: true,
                            preview: {
                                display: true,
                                size: [100, 100],
                                wrapper: '#custom-preview-wrapper'
                            },
                        });
                    }, 500);
                });

            };
            reader.readAsDataURL(file);
        }
    });
    $(document).delegate(".image-crop", "click", function() {
        var imagerurl = $('#image').rcrop('getDataURL');

        $('.select_image_section, .or_section, .youtube_section').hide();
        $('#editMediaModal .profile-image-upload-section').show();
        $('#editMediaModal .profile-image-upload-section').html('<img src="" id="image" class="image" style="Width:100%">');
        var $image = $('#editMediaModal .profile-image-upload-section #image');
        $image.attr('src', imagerurl);
        $('.base64imageupload').val(imagerurl);
        $("#cropImage").modal('hide');
        $('.upload-image-youtube-button').prop('disabled', false);



        // $("#profile-image").val(imagerurl)
        // $("#cropImage").modal('hide');
        // // $('.profile-image-section').hide();
        // $('#cropped-original').show();
        // $('#cropped-original img').attr('src', imagerurl);
    });






    $(document).delegate('.add_youtube_link', 'blur',function(){
        $('.image_section, .or_section').hide();
        $('.upload-image-youtube-button').prop('disabled', false);
    });

    $(document).delegate('.upload-image-youtube-button', 'click', function(){
        $('.upload-image-youtube-button').prop('disabled', true);
        var formData = $("#upload_media").serialize();
        $.ajax({
            url: $("#upload_media").attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.status == "success"){
                    window.location.reload();
                    var galleryHtml = `<div class="box-gallary-images-column">
                                            <a href="javascript:void(0)" class="dlt-icon vendor-media-delete" data-id="${response.mediaid}" data-type="${response.type}"><i class="fa-solid fa-trash"></i></a>`;
                    if(response.type == "image"){
                        galleryHtml=`   <img src="/${response.path}" class="box-gallary-7-images rounded-4">
                                        </div>`;
                    }
                    if(response.type == "youtube"){
                        galleryHtml=`   <iframe width="100% src="${response.path}" frameborder="0" allowfullscreen></iframe>
                                        </div>`;
                    }
                    $(".box-gallary-7-images-row").append(galleryHtml);
                    if($('box-gallary-images-column').lenght > 6){
                        $('.select-box-gallary-images-column').hide();
                    }
                    $(".mediaGalleryModal").modal('hide')
                }
            },
            error: function(xhr, status, error) {
                // Handle any errors
                $('.upload-image-youtube-button').prop('disabled', false);
                console.error(xhr.responseText);
            }
        });
    });

    $(document).delegate('.vendor-media-delete','click', function(){
        var mediaId = $(this).attr('data-id');
        $.ajax({
            url: "{{route('vendor-media-delete', ['vendorid' => $vendor->id])}}",
            type: 'POST',
            data: {
                "mediaId" : mediaId
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.status == "success"){
                    window.location.reload();
                }
            },
            error: function(xhr, status, error) {
                // Handle any errors
                $('.upload-image-youtube-button').prop('disabled', false);
                console.error(xhr.responseText);
            }
        });
    });

</script>
@endsection