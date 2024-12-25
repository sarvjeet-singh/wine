<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery.js@2.7.1/dist/css/lightgallery-bundle.min.css">
<link rel="stylesheet"
    href="https://www.jqueryscript.net/demo/Responsive-Mobile-friendly-Image-Cropper-With-jQuery-rcrop/dist/rcrop.min.css">

<style>
    /* Style for the button loader */
    .loader-btn {
        position: absolute;
        /* Absolute positioning */
        top: 50%;
        /* Vertically center the loader */
        left: 50%;
        /* Horizontally center the loader */
        transform: translate(-50%, -50%);
        /* Fine-tune centering */
        width: 20px;
        height: 20px;
        display: none;
        /* Hidden by default */
    }

    /* Loader spinner style */
    .loader-btn .spinner {
        border: 2px solid #f3f3f3;
        /* Light grey */
        border-top: 2px solid #3498db;
        /* Blue */
        border-radius: 50%;
        width: 100%;
        height: 100%;
        animation: spin 1s linear infinite;
    }

    /* Spinner animation */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    /* Button with relative position to hold the spinner */
    .upload-image-youtube-button {
        position: relative;
        padding-right: 30px;
        /* Make room for the spinner */
        min-width: 100px;
        /* Ensure the button has a minimum width */
        height: 40px;
        /* Set a fixed height for consistency */
    }

    /* Media Gallery */
    .image-grid figure {
        margin-bottom: 0;
        height: 100%;
    }

    .image-grid img {
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #118c9700;
        transition: .3s ease-in-out;
    }

    .image-grid .media-inner:hover img {
        filter: brightness(0.7);
    }

    .lightbox-modal .modal-content {
        background: #24242400;
    }

    .lightbox-modal .btn-close {
        position: absolute;
        top: 20px;
        right: 18px;
        font-size: 18px;
        z-index: 10;
    }

    .lightbox-modal .modal-body {
        display: flex;
        align-items: center;
        padding: 0;
        text-align: center;
    }

    .lightbox-modal img {
        width: auto;
        max-height: 90vh;
        max-width: 100%;
        border-radius: 20px;
    }

    .lightbox-modal .carousel-caption {
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(36, 36, 36, 0.75);
    }

    .lightbox-modal .carousel-control-prev,
    .lightbox-modal .carousel-control-next {
        top: 50%;
        bottom: auto;
        transform: translateY(-50%);
        width: auto;
    }

    .lightbox-modal .carousel-control-prev {
        left: 10px;
    }

    .lightbox-modal .carousel-control-next {
        right: 10px;
    }

    .image-grid a.dlt-icon {
        place-items: center;
        z-index: 98;
    }

    .image-grid .media-inner:hover a.dlt-icon {
        display: grid;
    }

    .image-grid a.default-media-logo {
        text-align: center;
        font-size: 15px;
        position: absolute;
        bottom: -100px;
        left: 0;
        right: 0;
        padding-block: 4px;
        margin: 0 2px 2px;
        background-color: #28405E;
        color: #fff;
        border-radius: 0 0 6px 6px;
        transition: .3s ease-in-out;
    }

    .image-grid a.current-default-media-logo {
        text-align: center;
        font-size: 15px;
        position: absolute;
        top: 2px;
        left: 0;
        padding: 2px 6px;
        margin: 0 2px 2px;
        background-color: #28405E;
        color: #fff;
        border-radius: 6px 0 6px 0;
        transition: .3s ease-in-out;
    }

    .image-grid .media-inner:hover .default-media-logo {
        display: block;
        bottom: 0;
    }
</style>
<div class="col right-side">
    <div class="row">
        <div class="col-sm-12">
            <div class="information-box">
                <div class="information-box-head py-3">
                    <div class="box-head-heading d-flex">
                        <span class="box-head-label theme-color">Media Gallary</span>
                    </div>
                    <div class="box-head-description">
                        Please upload JPG and PNG images formats
                    </div>
                </div>
                <div class="information-box-body pb-4">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="row mt-3">
                        <!-- Old HTML -->
                        <!-- <div class="box-gallary-7-images-row">
                                                        <div class="box-gallary-images-column select-box-gallary-images-column"
                                                            @if ($VendorMediaGallery->count() > 5) style="display:none" @endif>
                                                            <label for="front_License_image" class="custom-file-label upload-button">
                                                                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                                            </label>
                                                        </div>
                                                        @if ($VendorMediaGallery)
@foreach ($VendorMediaGallery as $media)
<div class="box-gallary-images-column position-relative">
                                                                    <a href="javascript:void(0)" class="dlt-icon vendor-media-delete"
                                                                        data-id="{{ $media->id }}" data-type="{{ $media->vendor_media_type }}"><i
                                                                            class="fa-solid fa-trash"></i></a>
                                                                    @if ($media->vendor_media_type == 'image')
<img src="{{ asset($media->vendor_media) }}"
                                                                            class="box-gallary-7-images rounded-4">
@elseif($media->vendor_media_type == 'youtube')
<iframe width="135px" src="{{ $media->vendor_media }}" frameborder="0"
                                                                            allowfullscreen></iframe>
@endif
                                                                </div>
@endforeach
@endif
                                                    </div> -->
                        <!-- /Old HTML -->

                        <div class="image-grid">
                            <div class="row gy-4">
                                <div class="col-6 col-sm-4 col-md-3">
                                    <div class="box-gallary-images-column select-box-gallary-images-column"
                                        @if ($VendorMediaGallery->count() > 6) style="display:none" @endif>
                                        <label for="front_License_image"
                                            class="custom-file-label upload-button mx-auto">
                                            <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                        </label>
                                    </div>
                                </div>
                                @if ($VendorMediaGallery)
                                    @foreach ($VendorMediaGallery as $media)
                                        <div class="col-6 col-sm-4 col-md-3">
                                            <div class="media-inner position-relative overflow-hidden h-100">
                                                <figure>
                                                    @if ($media->vendor_media_type == 'image')
                                                        <a class="d-block h-100" href="javascript:void(0)">
                                                            <img width="1920" height="1280"
                                                                src="{{ asset($media->vendor_media) }}"
                                                                class="img-fluid rounded-4" alt="Media Image"
                                                                data-caption="">
                                                        </a>
                                                    @elseif($media->vendor_media_type == 'youtube')
                                                        <iframe width="100%" height="100%"
                                                            src="{{ $media->vendor_media }}" frameborder="0"
                                                            allowfullscreen></iframe>
                                                    @endif
                                                </figure>
                                                <a href="javascript:void(0)" class="dlt-icon vendor-media-delete"
                                                    data-id="{{ $media->id }}"
                                                    data-type="{{ $media->vendor_media_type }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                                @if ($media->is_default == 1)
                                                    <a href="javascript:void(0)" class="current-default-media-logo">
                                                        Default Logo
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0)" data-id="{{ $media->id }}"
                                                        class="default-media-logo vendor-media-set-default">
                                                        Set as Logo
                                                    </a>
                                                @endif
                                            </div>
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
</div>

<div class="modal mediaGalleryModal fade" id="editMediaModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-sm-4 p-2">
            <div class="modal-header border-0">
                <h3 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Edit Media Gallery</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.vendor.details.ajax.upload_media', ['vendorid' => $vendor->id]) }}"
                    id="upload_media">
                    @csrf
                    <input type="hidden" value="" name="vendorImage" class="base64imageupload">
                    <div class="mb-3 image_section">
                        <label class="form-label">Add photo</label>
                        <div class="position-relative select_image_section">
                            <label class="custom-file-label" for="upload_photo_video">
                                <!-- <img src="{{ asset('images/media-gallary/plus-icon.png') }}" width="20"> -->
                                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                            </label>
                            <input type="file" accept="image/*" class="custom-file-input" id="upload_photo_video">
                        </div>
                        <div class="profile-image-upload-section"></div>
                    </div>

                    <div class="mb-3 text-center or_section">
                        <b>OR</b>
                    </div>
                    <div class="mb-3 youtube_section">
                        <label class="form-label">Add Youtube Link</label>
                        <input type="text" class="form-control add_youtube_link" placeholder="Add Link"
                            name="youtube_link">
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn save-btn upload-image-youtube-button">
                    <span class="btn-text">Save</span>
                    <div class="loader-btn" style="display: none;">
                        <div class="spinner"></div>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cropImage" tabindex="-1" role="dialog" aria-labelledby="cropImageModalLabel"
    aria-hidden="true">
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

<!-- Light Gallery Popup -->
<div class="modal lightbox-modal" id="lightbox-modal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                aria-label="Close"></button>
            <div class="modal-body">
                <div class="container-fluid p-0">
                    <!-- JS content here -->
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/lightgallery.js@2.7.1/dist/lightgallery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery.js@2.7.1/dist/plugins/zoom/lg-zoom.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lightgallery.js@2.7.1/dist/plugins/thumbnail/lg-thumbnail.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script
    src="https://www.jqueryscript.net/demo/Responsive-Mobile-friendly-Image-Cropper-With-jQuery-rcrop/dist/rcrop.min.js">
</script>
<script>
    $('.upload-button').click(function() {
        $('#upload_photo_video, .add_youtube_link, .base64imageupload').val('');
        $('.select_image_section, .or_section, .youtube_section').show();
        $('#editMediaModal .profile-image-upload-section').html('').hide();
        $('.upload-image-youtube-button').prop('disabled', true);
        $(".mediaGalleryModal").modal('show');
    });
    $(document).delegate("#upload_photo_video", "change", function(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {

                $("#cropImage").modal('show');
                $('#cropImage .profile-image-upload-section').html(
                    '<img src="" id="image" class="image" style="Width:100%">');
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
        $('#editMediaModal .profile-image-upload-section').html(
            '<img src="" id="image" class="image" style="Width:100%">');
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






    $(document).delegate('.add_youtube_link', 'blur', function() {
        $('.image_section, .or_section').hide();
        $('.upload-image-youtube-button').prop('disabled', false);
    });

    $(document).delegate('.upload-image-youtube-button', 'click', function() {
        var $button = $(this); // Get the clicked button
        var $loader = $button.find('.loader-btn'); // Find the loader inside the button
        var $btnText = $button.find('.btn-text'); // Find the text inside the button

        // Disable the button and show the loader
        $button.prop('disabled', true);
        $btnText.hide(); // Hide the button text
        $loader.show(); // Show the loader

        var formData = $("#upload_media").serialize();

        $.ajax({
            url: $("#upload_media").attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.status == "success") {
                    window.location.reload();

                    var galleryHtml =
                        `<div class="box-gallary-images-column">
                        <a href="javascript:void(0)" class="dlt-icon vendor-media-delete" data-id="${response.mediaid}" data-type="${response.type}"><i class="fa-solid fa-trash"></i></a>`;

                    if (response.type == "image") {
                        galleryHtml +=
                            `<img src="/${response.path}" class="box-gallary-7-images rounded-4"></div>`;
                    }
                    if (response.type == "youtube") {
                        galleryHtml +=
                            `<iframe width="100%" src="${response.path}" frameborder="0" allowfullscreen></iframe></div>`;
                    }

                    $(".box-gallary-7-images-row").append(galleryHtml);

                    // Hide the loader and enable the button
                    $btnText.show(); // Show the button text
                    $loader.hide(); // Hide the loader
                    $button.prop('disabled', false); // Enable the button again
                    $(".mediaGalleryModal").modal('hide');
                }
            },
            error: function(xhr, status, error) {
                // Handle any errors
                $button.prop('disabled', false);
                $btnText.show(); // Show the button text in case of error
                $loader.hide(); // Hide the loader if error occurs
                console.error(xhr.responseText);
            }
        });
    });

    $(document).delegate('.vendor-media-delete', 'click', function() {
        var mediaId = $(this).attr('data-id');

        // Show SweetAlert2 confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: "This action will delete the media permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Perform AJAX call if confirmed
                $.ajax({
                    url: "{{ route('admin.vendor.details.ajax-media-delete', ['vendorid' => $vendor->id]) }}",
                    type: 'POST',
                    data: {
                        "mediaId": mediaId
                    },
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === "success") {
                            Swal.fire(
                                'Deleted!',
                                'The media has been deleted successfully.',
                                'success'
                            ).then(() => {
                                window.location
                                    .reload(); // Reload after showing success
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message || 'An unexpected error occurred.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors
                        Swal.fire(
                            'Error!',
                            xhr.responseJSON.message ||
                            'An error occurred while deleting the media. Please try again.',
                            'error'
                        );
                        $('.upload-image-youtube-button').prop('disabled', false);
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
    $(document).delegate('.vendor-media-set-default', 'click', function() {
        var mediaId = $(this).attr('data-id');

        // Show SweetAlert2 confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: "This will set this media as the logo image!",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, set it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Perform AJAX call if confirmed
                $.ajax({
                    url: "{{ route('admin.vendor.details.ajax-media-set-default', ['vendorid' => $vendor->id]) }}",
                    type: 'POST',
                    data: {
                        "mediaId": mediaId
                    },
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === "success") {
                            Swal.fire(
                                'Success!',
                                'The media has been set as the default image.',
                                'success'
                            ).then(() => {
                                window.location
                                    .reload(); // Reload after setting default
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message || 'An unexpected error occurred.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle any errors
                        Swal.fire(
                            'Error!',
                            'An error occurred while setting the default media. Please try again.',
                            'error'
                        );
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
</script>

<!-- Light Media Gallery -->
<script>
    const imageGrid = document.querySelector(".image-grid");
    const links = imageGrid.querySelectorAll("a");
    const imgs = imageGrid.querySelectorAll("img");
    const lightboxModal = document.getElementById("lightbox-modal");
    const bsModal = new bootstrap.Modal(lightboxModal);
    const modalBody = document.querySelector(".modal-body .container-fluid");

    for (const link of links) {
        link.addEventListener("click", function(e) {
            e.preventDefault();
            const currentImg = link.querySelector("img");
            const lightboxCarousel = document.getElementById("lightboxCarousel");
            if (lightboxCarousel) {
                const parentCol = link.parentElement.parentElement;
                const index = [...parentCol.parentElement.children].indexOf(parentCol);
                const bsCarousel = new bootstrap.Carousel(lightboxCarousel);
                bsCarousel.to(index);
            } else {
                createCarousel(currentImg);
            }
            bsModal.show();
        });
    }

    function createCarousel(img) {
        const markup = `
        <div id="lightboxCarousel" class="carousel slide carousel-fade" data-bs-interval="false">
          <div class="carousel-inner">
            ${createSlides(img)}
          </div> 
          <button class="carousel-control-prev" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="prev">
           <span class="carousel-control-prev-icon" aria-hidden="true"></span>
           <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#lightboxCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
        `;

        modalBody.innerHTML = markup;

        // Initialize Bootstrap carousel with no auto-cycling
        const bsCarousel = new bootstrap.Carousel(document.getElementById("lightboxCarousel"), {
            interval: false, // Prevent automatic cycling
            wrap: true, // Allow wrapping (infinite scrolling)
            pause: "hover", // Pause on hover (optional)
        });
    }


    function createSlides(img) {
        let markup = "";
        const currentImgSrc = img.getAttribute("src");

        for (const img of imgs) {
            const imgSrc = img.getAttribute("src");
            const imgAlt = img.getAttribute("alt");
            const imgCaption = img.getAttribute("data-caption");

            markup += `
        <div class="carousel-item${currentImgSrc === imgSrc ? " active" : ""}">
          <img src="${imgSrc}" alt="${imgAlt}">
          ${imgCaption ? createCaption(imgCaption) : ""}
        </div>
        `;
        }

        return markup;
    }

    function createCaption(caption) {
        return `<div class="carousel-caption">
         <p class="m-0">${caption}</p>
        </div>`;
    }
</script>
