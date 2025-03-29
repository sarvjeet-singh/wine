@extends('FrontEnd.layouts.mainapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')

    <style>
        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #dee2e6;
        }

        .select2-container .select2-selection--single {
            height: 37.6px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-block: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 6px;
        }

        .profile-img-sec svg {
            width: 34px;
            height: 34px;
            padding: 6px;
            border-radius: 50%;
            color: #343434;
            position: absolute;
            top: 33%;
            right: 30%;
            cursor: pointer;
        }

        .upload-box {
            width: 100%;
            border: 2px dashed #bba253;
            border-radius: 6px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
        }

        .upload-box:hover {
            background-color: #f8f9fa;
        }

        .upload-box h5 svg {
            width: 22px;
            height: 22px;
        }

        .preview-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-start;
            align-items: center;
        }

        .preview-box,
        .add-more-box {
            width: 80px;
            height: 80px;
            border: 1px solid #0000001f;
            border-radius: 8px;
            text-align: center;
            position: relative;
        }

        .preview-img,
        .preview-video {
            width: 100%;
            height: 80px;
            border-radius: 6px;
            object-fit: cover;
        }

        .close-btn {
            position: absolute;
            top: 3px;
            right: 3px;
            background-color: rgba(255, 255, 255, 0.7);
            border: none;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .close-btn span {
            color: #dc3545;
            font-weight: bold;
            font-size: 14px;
        }

        .add-more {
            display: none;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .add-more .btn {
            font-size: 30px;
            width: 80px;
            height: 80px;
            background-color: #b7a35f;
            color: white;
            border: none;
        }
    </style>

    <div class="container main-container">
        <div class="row flex-lg-nowrap flex-wrap g-4">
            @include('UserDashboard.includes.leftNav')
            <div class="col right-side">

                <!-- User Guest Registry Start -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="information-box">
                            <div class="information-box-head">
                                <div class="box-head-heading d-flex flex-wrap">
                                    <span class="box-head-label theme-color">Submit Reviews</span>
                                    <p class="f-15">Earn an additional $25 in Bottle Bucks after submitting ten (10)
                                        verifiable reviews (i.e. reviews include receipt#).</p>
                                </div>
                            </div>
                            <div class="information-box-body">
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                <form method="post" action="{{ route('user-reviews-submit') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="rating" value="0" id="rating">
                                    <div class="row mt-3">
                                        <!-- <div class="col-12">
                                                        <div class="profile-img-sec text-center">
                                                            <label for="profileImage" class="position-relative">
                                                                <img id="profilePreview" src="" class="profile-img rounded-circle" style="width: 120px; height: 120px; min-height: 120px; object-fit: cover; border: 2px solid #b7a35f;cursor: pointer;">
                                                                <i class="fa-solid fa-camera"></i>
                                                            </label>
                                                            <input type="file" id="profileImage" class="file-input" accept="image/*" style="display: none;">
                                                        </div>
                                                    </div> -->
                                        <div class="col-12 mb-3">
                                            <!-- Upload Box -->
                                            <div class="upload-box mb-1" id="uploadBox" style="display: block;">
                                                <input type="file" name="image" id="uploadInput" style="display: none;"
                                                    accept="image/*, video/*" onchange="previewFile()" />
                                                <h5
                                                    class="d-flex align-items-center justify-content-center gap-2 mb-0 fs-6 fw-bold">
                                                    <svg fill="#343434" height="200px" width="200px" version="1.1"
                                                        id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 487 487"
                                                        xml:space="preserve">
                                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                            stroke-linejoin="round"></g>
                                                        <g id="SVGRepo_iconCarrier">
                                                            <g>
                                                                <g>
                                                                    <path
                                                                        d="M308.1,277.95c0,35.7-28.9,64.6-64.6,64.6s-64.6-28.9-64.6-64.6s28.9-64.6,64.6-64.6S308.1,242.25,308.1,277.95z M440.3,116.05c25.8,0,46.7,20.9,46.7,46.7v122.4v103.8c0,27.5-22.3,49.8-49.8,49.8H49.8c-27.5,0-49.8-22.3-49.8-49.8v-103.9 v-122.3l0,0c0-25.8,20.9-46.7,46.7-46.7h93.4l4.4-18.6c6.7-28.8,32.4-49.2,62-49.2h74.1c29.6,0,55.3,20.4,62,49.2l4.3,18.6H440.3z M97.4,183.45c0-12.9-10.5-23.4-23.4-23.4c-13,0-23.5,10.5-23.5,23.4s10.5,23.4,23.4,23.4C86.9,206.95,97.4,196.45,97.4,183.45z M358.7,277.95c0-63.6-51.6-115.2-115.2-115.2s-115.2,51.6-115.2,115.2s51.6,115.2,115.2,115.2S358.7,341.55,358.7,277.95z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </svg> Share a Photo
                                                </h5>
                                            </div>

                                            <!-- Preview Container -->
                                            <div class="preview-container mt-2" id="previewContainer"
                                                style="display: none;">
                                                <!-- Preview Box (Uploaded Media) -->
                                                <div class="preview-box" id="previewBox" style="display: none;">
                                                    <div id="mediaPreview"></div>
                                                </div>

                                                <!-- More Boxes -->
                                                {{-- <div class="add-more" id="addMoreBtnContainer">
                                                    <button class="btn" id="addMoreBtn" onclick="showUploadBox(event)">
                                                        <span><i class="fa-solid fa-plus"></i></span>
                                                    </button>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Business/Vendor Name<span
                                                    class="required-filed">*</span></label>
                                            <select id="buisness_vendor_name"
                                                class="form-control @error('vendor_id') is-invalid @enderror"
                                                name="vendor_id">
                                                <option value="" disabled selected>Select a vendor</option>
                                                @if ($vendors)
                                                    @foreach ($vendors as $vendor)
                                                        <option value="{{ $vendor->id }}">{{ $vendor->vendor_name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('vendor_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-sm-6 col-12 mb-sm-0 mb-2">
                                            <label class="form-label">Date of Visit<span
                                                    class="required-filed">*</span></label>
                                            <input type="date"
                                                class="form-control @error('date_of_visit') is-invalid @enderror"
                                                name="date_of_visit" max="{{ date('Y-m-d') }}">
                                            @error('date_of_visit')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <label for="email" class="form-label">Receipt#</label>
                                            <input type="text" placeholder="Receipt" class="form-control" name="receipt">
                                        </div>
                                    </div>

                                    <div class="row mt-3 mb-3">
                                        <div class="col-12">
                                            <div>
                                                <label class="form-label">Rate your experience from 1 - 5 stars<span
                                                        class="required-filed">*</span></label>
                                            </div>
                                            <div class="my-rating-5"></div>
                                            @if ($errors->any())
                                                @foreach ($errors->get('rating') as $error)
                                                    <span class="is-invalid"></span>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $error }}</strong>
                                                    </span>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mt-3 mb-3">
                                        <div class="col-12">
                                            <label class="form-label">Describe your experience<span
                                                    class="required-filed">*</span></label>
                                            <textarea class="form-control @error('review_description') is-invalid @enderror" placeholder="Description"
                                                id="exampleFormControlTextarea1" name="review_description" rows="3"></textarea>
                                            @error('review_description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-5">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" class="btn wine-btn">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Guest Registry End -->
            </div>
        </div>
    </div>
    @include('UserDashboard.includes.logout_modal')
@endsection

@section('js')
    <script>
        $("#buisness_vendor_name").select2();
        $(document).ready(function() {
            $(".my-rating-5").starRating({
                starSize: 20,
                hoverColor: '#c0a144',
                emptyColor: '#8b8b8b',
                callback: function(currentRating) {
                    // alert(currentRating);
                    $("#rating").val(currentRating);
                }
            });
            const dateInput = $('input[name="date_of_visit"]');
            dateInput.on('click', function() {
                this.showPicker();
            });
        });


        // Upload Profile Image
        // $('#profileImage').on('change', function(event) {
        //         const file = event.target.files[0];
        //         if (file) {
        //             const reader = new FileReader();
        //             reader.onload = function(e) {
        //                 $('#profilePreview').attr('src', e.target.result);
        //             };
        //             reader.readAsDataURL(file);
        //         }
        //     });
    </script>

    <!-- Upload Profile Image -->
    <script>
        // Trigger file input when upload box is clicked
        document.getElementById('uploadBox').addEventListener('click', function() {
            document.getElementById('uploadInput').click();
        });

        // Preview uploaded file (image or video)
        function previewFile() {
            const fileInput = document.getElementById('uploadInput');
            const mediaPreview = document.getElementById('mediaPreview');
            const previewBox = document.getElementById('previewBox');
            const uploadBox = document.getElementById('uploadBox');
            const addMoreBtnContainer = document.getElementById('addMoreBtnContainer');
            const previewContainer = document.getElementById('previewContainer');

            const file = fileInput.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let mediaElement;
                    if (file.type.startsWith('image/')) {
                        mediaElement = `<img src="${e.target.result}" class="preview-img" alt="Uploaded image" />`;
                    } else if (file.type.startsWith('video/')) {
                        mediaElement =
                            `<video controls class="preview-video"><source src="${e.target.result}" type="${file.type}"></video>`;
                    }

                    // Create a new preview box for the uploaded file
                    const newPreviewBox = document.createElement('div');
                    newPreviewBox.classList.add('preview-box');
                    newPreviewBox.innerHTML = `
            <div>${mediaElement}</div>
            <button class="close-btn" onclick="removePreview(this)"><span>&times;</span></button>
        `;

                    // Append the new preview box to the container
                    previewContainer.appendChild(newPreviewBox);
                    previewContainer.style.display = 'flex'; // Show preview container
                    uploadBox.style.display = 'none'; // Hide the upload box after upload
                };
                reader.readAsDataURL(file);
            }
        }

        // Function to show the upload box when "+" is clicked
        function showUploadBox(event) {
            event.preventDefault(); // Prevent the page from refreshing

            // Hide the "+" button again
            document.getElementById('addMoreBtnContainer').style.display = 'none';

            // Show the upload box
            document.getElementById('uploadBox').style.display = 'block';

            // Reset the file input so that it can be reused
            document.getElementById('uploadInput').value = '';
        }

        // Function to remove the preview box
        function removePreview(button) {
            const previewBox = button.parentElement;
            previewBox.remove();

            // Reset the file input to allow re-selection of the same file
            const uploadInput = document.getElementById('uploadInput');
            uploadInput.value = '';

            // Show the upload box again
            document.getElementById('uploadBox').style.display = 'block';
        }
    </script>


@endsection
