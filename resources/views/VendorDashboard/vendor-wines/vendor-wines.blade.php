@extends('VendorDashboard.layouts.vendorapp')



@section('title', 'Wine Country Weekends - Guest Registry')



@section('content')
    <style type="text/css">
        /******DON'T COPY THIS CSS*****/
        .upload-container {
            text-align: center;
        }

        .dropbox {
            width: 400px;
            height: 100px;
            border: 2px dashed #aaa;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px auto;
            cursor: pointer;
        }

        .dropbox.drag-over {
            border-color: green;
            background: #f0f8ff;
        }

        .progress-container {
            width: 300px;
            height: 20px;
            background: #ddd;
            margin: 10px auto;
            border-radius: 5px;
            overflow: hidden;
            position: relative;
        }

        /*.progress-bar {
                                width: 0%;
                                height: 100%;
                                background: green;
                                text-align: center;
                                line-height: 20px;
                                color: white;
                                font-weight: bold;
                                transition: width 0.3s;
                            }*/
        .progress {
            width: 80%;
            height: 12px;
            font-size: 10px;
        }

        .progress-btns {
            width: 20%;
        }

        .progress-bar {
            background-color: #408a95;
        }

        #fileList {
            margin-top: 20px;
        }

        .table-custom th {

            background-color: #118c9730;

            padding: 20px 30px 20px 10px !important
        }



        .table-custom th:first-child {

            border-top-left-radius: 15px;

        }



        .table-custom th:last-child {

            border-top-right-radius: 15px;

        }



        .btn-primary,

        .btn-primary:hover {

            background-color: #348a96;

            border-color: #348a96;

        }



        .form-control:focus,

        .form-select:focus {

            background-color: #fff;

            border-color: #348a96 !important;

            outline: 0;

            box-shadow: none;

        }





        /*************** COPY THIS CSS ***************/

        .dt-search [type=search] {

            outline: none;

        }



        .dt-length label {

            padding-left: 10px;

            text-transform: capitalize;

        }



        .wine-vintage-table a {

            color: #348a96;

        }



        .wine-vintage-table th {

            white-space: nowrap;

            border-bottom: none !important;

            outline: none !important;

            text-align: left !important;

        }



        #addWine-modal .form-label {

            font-weight: bold;

        }



        #addWine-modal .modal-title {

            color: #348a96;

        }



        #addWine-modal .fa-circle-plus {

            width: 20px;

            height: 20px;

            color: #348a96;

        }



        .error {

            font-size: 12px;

            color: red;

            font-style: italic;

        }



        div.error {

            width: 100%;

        }

        .img-box {
            position: relative;
        }

        #removeImage {
            position: absolute;
            top: -23px;
            right: 0px;
        }
    </style>

    <div class="col right-side">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- <div class="upload-container">
                                <h3>Upload Your Files</h3>
                                <div class="dropbox" id="dropbox">
                                    Drag & Drop files here or click to upload
                                </div>
                                <input type="file" id="fileInput" multiple style="display: none;">

                                <div class="progress-container" style="display: none;">
                                    <div class="progress-bar" id="progressBar">0%</div>
                                </div>

                                <div id="status"></div>
                            </div> -->

        <div class="mb-4">
            <div class="row align-items-start">
                <!-- Progress Bar & Status -->
                <div class="col-md-9 col-12 mb-3 mb-md-0">
                    <div class="progress progress-container w-100 mb-2" style="display: none;" role="progressbar"
                        aria-label="Animated striped example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%"
                            id="progressBar">0%</div>
                    </div>
                    <div id="status" class="text-muted small"></div>
                </div>

                <!-- Buttons -->
                <div class="col-md-3 col-12 text-md-end text-start d-flex justify-content-md-end gap-2">
                    {{-- <button type="button" class="btn wine-btn rounded px-4 open-modal-btn" data-url="add"
                        data-id="{{ $vendor_id }}">Add Wine</button> --}}
                    <a class="btn wine-btn rounded px-4" href="{{ route('vendor-wines.add', $vendor_id) }}">Add Wine</a>
                    <input type="file" id="fileInput" multiple style="display: none;">
                    <button type="button" id="dropbox" class="btn wine-btn rounded px-4">Upload</button>
                </div>
            </div>
        </div>

        <div class="table-responsive">

            <table class="table table-custom wine-vintage-table text-center" id="wine-vintageTable">

                <thead>

                    <tr>

                        <th scope="col">S.No</th>

                        <th scope="col">Label</th>
                        <th scope="col">Image</th>
                        <th scope="col">Inventory</th>

                        <th scope="col">Price</th>
                        <th scope="col">Listed</th>

                        <th scope="col">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($wines as $key => $wine)
                        <tr>

                            <td>{{ $key + 1 }}</td>

                            <td>{{ $wine->winery_name }}</td>

                            <td>
                                @if ($wine->image)
                                    <img src="{{ $wine->image && file_exists(public_path('storage/' . $wine->image)) ? url('storage/' . $wine->image) : url('images/default-wine.jpg') }}"
                                        style="width: 50px; height: 50px;" alt="{{ $wine->winery_name }}">
                                @endif
                            </td>

                            <td>{{ $wine->inventory }}</td>

                            <td>${{ $wine->price }}</td>
                            <td>{{ $wine->delisted == 0 ? 'Yes' : 'No' }}</td>

                            <td>

                                <a href="{{ route('vendor-wines.edit', ['id' => $wine->id, 'vendorid' => $vendor_id]) }}"><i class="fa-regular fa-pen-to-square"></i></a>

                                <a class="btn-delete mx-2" data-id="{{ $wine->id }}"
                                    data-vendor_id="{{ $vendor_id }}"
                                    href="{{ route('vendor-wines.destroy', ['id' => $wine->id, 'vendorid' => $vendor_id]) }}"><i
                                        class="fa-solid fa-trash"></i></a>

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

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

@endsection

@section('js')

    <!-- jQuery Validation Plugin -->

    <script>
        $(document).ready(function(e) {

            let table = new DataTable('#wine-vintageTable', {

                language: {

                    emptyTable: "No inquiries available at the moment"

                }

            });

        });
    </script>

    <script>
        $(document).ready(function() {

            // $(document).on('click', '.open-modal-btn', function() {

            //     // Get the URL or data-id to load content (if needed)

            //     var url = $(this).data('url') + '/' + $(this).data('id');



            //     // Clear previous modal content

            //     $('#addWineModal .modal-content').html('');



            //     // Make the AJAX request

            //     $.ajax({

            //         url: url, // URL to fetch the data from

            //         type: 'GET',

            //         dataType: 'html', // Expect HTML response

            //         beforeSend: function() {

            //             // Optionally show a loader before sending the request

            //             $('#addWineModal .modal-content').html(

            //                 '<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>'

            //             );

            //         },

            //         success: function(response) {

            //             // Insert the fetched HTML into the modal's body

            //             $('#addWineModal .modal-content').html(response);



            //             // Show the modal after data is fully loaded

            //             $('#addWineModal').modal('show');

            //         },

            //         error: function(xhr) {

            //             // Handle error

            //             $('#addWineModal .modal-content').html(

            //                 '<p>Error loading data. Please try again later.</p>');

            //         }

            //     });

            // });

        });
    </script>

    <script>
        $(document).ready(function() {
            // Handle click on delete button
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault(); // Prevent the default form submission
                var url = $(this).attr('href');

                // Use SweetAlert2 for confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You can revert this later!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delist it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, send the AJAX request
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Delisted!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonText: 'OK',
                                    }).then(() => {
                                        location.reload(); // Reload the page
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: response.message,
                                        icon: 'error',
                                        confirmButtonText: 'OK',
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'An error occurred. Please try again.',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                });
                            },
                        });
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let vendorId = "{{ $vendor_id }}"; // Get vendor_id from Blade
            let uploadUrl = `/vendor/upload/store/${vendorId}`;
            let dropbox = document.getElementById("dropbox");
            let fileInput = document.getElementById("fileInput");
            let progressBar = document.getElementById("progressBar");
            let progressContainer = document.querySelector(".progress-container");
            let status = document.getElementById("status");

            let isUploading = false; // Track if an upload is in progress
            // let uploadedFilesList = new Set(JSON.parse(localStorage.getItem("uploadedFiles")) || []);
            let uploadedFilesList = new Set();

            // Prevent closing or refreshing the page during upload
            window.addEventListener("beforeunload", function(event) {
                if (isUploading) {
                    event.preventDefault();
                    return (event.returnValue =
                        "File upload is in progress. Are you sure you want to leave?");
                }
            });

            // Click to open file input
            dropbox.addEventListener("click", function() {
                fileInput.click();
            });

            // Drag & Drop functionality
            dropbox.addEventListener("dragover", function(event) {
                event.preventDefault();
                dropbox.classList.add("drag-over");
            });

            dropbox.addEventListener("dragleave", function() {
                dropbox.classList.remove("drag-over");
            });

            dropbox.addEventListener("drop", function(event) {
                event.preventDefault();
                dropbox.classList.remove("drag-over");
                let files = event.dataTransfer.files;
                handleFileUpload(files);
            });

            // Handle file selection
            fileInput.addEventListener("change", function() {
                let files = fileInput.files;
                handleFileUpload(files);
            });

            async function handleFileUpload(files) {
                if (!files.length) return;

                progressContainer.style.display = "block";
                progressBar.style.width = "0%";
                progressBar.innerText = "0%"; // Show 0% initially
                status.innerHTML = "";
                isUploading = true; // Mark as uploading

                let formData = new FormData();
                let newFiles = [];

                // Filter files that haven't been uploaded yet
                for (let i = 0; i < files.length; i++) {
                    if (!uploadedFilesList.has(files[i].name)) {
                        formData.append("files[]", files[i]);
                        newFiles.push(files[i].name);
                    }
                }

                if (newFiles.length === 0) {
                    status.innerHTML = `<p style="color: orange;">No new files to upload.</p>`;
                    isUploading = false;
                    return;
                }

                try {
                    let response = await fetchWithProgress(uploadUrl, formData, updateProgress);

                    if (!response.ok) {
                        let errorData = await response.json();
                        if (response.status === 422) {
                            let errorMessages = Object.values(errorData.errors).flat().join("<br>");
                            throw new Error(errorMessages);
                        }
                        throw new Error(errorData.message || "File upload failed");
                    }

                    let result = await response.json();
                    progressBar.style.width = "100%";
                    progressBar.innerText = "100%";

                    status.innerHTML = `<p style="color: green;">Files uploaded successfully!</p>`;

                    // Store uploaded file names to resume from where it left off
                    newFiles.forEach((file) => uploadedFilesList.add(file));
                    // localStorage.setItem("uploadedFiles", JSON.stringify(Array.from(uploadedFilesList)));
                } catch (error) {
                    status.innerHTML = `<p style="color: red;">Upload Failed: ${error.message}</p>`;
                } finally {
                    isUploading = false; // Mark upload as finished
                    setTimeout(() => {
                        progressContainer.style.display = "none";
                    }, 2000);
                }
            }

            function updateProgress(percent) {
                progressBar.style.width = percent + "%";
                progressBar.innerText = percent + "%"; // Show percentage number inside bar
            }

            async function fetchWithProgress(url, formData, progressCallback) {
                return new Promise((resolve, reject) => {
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", url, true);
                    xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector(
                        'meta[name="csrf-token"]').getAttribute("content"));

                    xhr.upload.onprogress = function(event) {
                        if (event.lengthComputable) {
                            let percent = Math.round((event.loaded / event.total) * 100);
                            progressCallback(percent);
                        }
                    };

                    xhr.onload = function() {
                        resolve(new Response(xhr.responseText, {
                            status: xhr.status
                        }));
                    };

                    xhr.onerror = function() {
                        reject(new Error("Network error"));
                    };

                    xhr.send(formData);
                });
            }
        });
    </script>
@endsection
