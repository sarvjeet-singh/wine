@extends('admin.layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css">

    <div class="main-content-inner">

        <div class="main-head mb-4">

            <h2 class="mb-0">Manage Review & Testimonial</h2>

        </div>

        <div class="row">

            <div class="col-12">

                <div class="dashboard-card">

                    <div class="top-card d-flex align-items-center justify-content-between p-3">

                        <div>

                            <nav aria-label="breadcrumb">

                                <ol class="breadcrumb mb-0">

                                    <li class="breadcrumb-item"><a href="#"
                                            class="text-decoration-none text-black">User Management</a></li>

                                    <li class="breadcrumb-item active" aria-current="page">Manage Review & Testimonial</li>

                                </ol>

                            </nav>

                        </div>

                    </div>

                    <div class="information-box p-3">

                        <div class="info-head p-3">

                            <div class="d-flex align-items-center justify-content-between">

                                <div class="text-white">User Details</div>

                            </div>

                        </div>

                        <div class="m-3 pt-3">

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="text-center">

                                        <img src="{{ asset('images/UserProfile/' . ($review->customer->profile_image ?? 'default-profile.png')) }}"
                                            class="img-fluid border object-fit-cover" width="200px" style="border-radius: 100px; aspect-ratio: 1/1;" alt="Profle Image" />

                                        <p class="fw-bold mt-2 mb-0">{{ $review->customer->firstname ?? '' }}

                                            {{ $review->customer->lastname ?? '' }}</p>

                                        <p class="mb-0">{{ $review->customer->email ?? '' }}</p>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div>

                                        <!-- <p class="mb-1"><span class="fw-bold">User eMail: </span> loremlpsum@gmail.com</p> -->

                                        <p class="mb-2"><span class="fw-bold">Receipt Number: </span>

                                            {{ $review->receipt ?? 'N/A' }}</p>

                                        <p class="mb-2"><span class="fw-bold">Date of Visit: </span>

                                            {{ $review->date_of_visit ?? 'N/A' }}</p>
                                        <p class="mb-2"><span class="fw-bold">City/Town: </span>

                                            {{ $review->customer->city ?? 'N/A' }}</p>
                                        <p class="mb-2"><span class="fw-bold">State/Province: </span>

                                            {{ $review->customer->state ?? 'N/A' }}</p>

                                        <div class="comment-scroll pe-2">
                                            <p class="mb-2"><span class="fw-bold">Comment: </span>

                                                {{ $review->review_description ?? 'N/A' }}</p>
                                        </div>
                                        <div class="rating-star mb-1 d-flex align-items-center gap-1">
                                            <p class="mb-0"><span class="fw-bold">Rating: </span></p>
                                            <ul class="list-unstyled d-flex align-items-center mb-0">
                                                @if (isset($review->rating) && $review->rating > 0)
                                                    @for ($i = 1; $i <= floor($review->rating); $i++)
                                                        <li><i class="fa-solid fa-star"></i></li>
                                                    @endfor
                                                @endif
                                            </ul>
                                        </div>

                                    </div>

                                    <div class="mt-2">

                                        @if (isset($review->review_status) && $review->review_status == 'pending')
                                            <button class="btn btn-success btn-approve"
                                                data-id="{{ $review->id }}">Approve</button>

                                            <button class="btn btn-danger btn-decline"
                                                data-id="{{ $review->id }}">Decline</button>
                                        @elseif (isset($review->review_status) && $review->review_status == 'approved')
                                            <button class="btn btn-success" disabled>Approved</button>
                                        @elseif (isset($review->review_status) && $review->review_status == 'declined')
                                            <button class="btn btn-danger" disabled>Declined</button>
                                        @endif

                                    </div>

                                </div>

                                <div class="col-md-4">
                                    @if ($review->image)
                                        <div class="ps-5 border-start h-100">
                                            <h5 class="mb-3">Reviews images</h5>
                                            <!-- Image Thumbnail -->
                                            <img src="{{ url(Storage::url($review->image)) }}" alt="Thumbnail Image"
                                                class="img-thumbnail" data-bs-toggle="modal" data-bs-target="#imageModal"
                                                style="width: 100px;cursor: pointer;">

                                            <!-- Modal -->
                                            <div class="modal fade" id="imageModal" tabindex="-1"
                                                aria-labelledby="imageModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="imageModalLabel">Image View</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="{{ url(Storage::url($review->image)) }}"
                                                                alt="{{ $review->review_description }}"
                                                                class="img-fluid w-100 object-fit-cover"
                                                                style="height: 450px;">
                                                            <p class="my-2 fst-italic"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="information-box p-3">

                        <div class="info-head p-3">

                            <div class="d-flex align-items-center justify-content-between">

                                <div class="text-white">Vendor Details</div>

                            </div>

                        </div>

                        <div class="m-3">

                            <div class="row">

                                <div class="col-12">

                                    <div>

                                        <p class="mb-2"><span class="fw-bold">Business/Vendor Name: </span>

                                            {{ $review->vendor->vendor_name ?? 'N/A' }}

                                        </p>

                                        <p class="mb-2"><span class="fw-bold">Street Address: </span>

                                            {{ $review->vendor->street_address ?? 'N/A' }}</p>

                                        <p class="mb-2"><span class="fw-bold">Vendor Contact eMail: </span>

                                            {{ $review->vendor->vendor_email ?? 'N/A' }}</p>

                                        <!-- <p class="mb-2"><span class="fw-bold">Date of Visit: </span>

                                                                {{ $review->date_of_visit ?? 'N/A' }}</p> -->

                                        <p class="mb-2"><span class="fw-bold">Vendor Contact Number: </span>

                                            {{ $review->vendor->vendor_phone ?? 'N/A' }}</p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- <div class="information-box p-3">
                        <div class="info-head p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-white">Admin Section</div>
                            </div>
                        </div>
                        <div class="m-3">
                            <div class="row">
                                <div class="col-12">
                                    <form>
                                    <select class="form-select w-25" id="actionDropdown" aria-label="Action Select">
                                      <option value="accept">Approved</option>
                                      <option value="reject">Reject</option>                                      
                                    </select>
                                    <div class="my-2" id="rejectReasonGroup" style="display: none;">
                                        <!-- <label for="rejectReason" class="form-label"></label> -->
                                        <input type="text" class="form-control" id="rejectReason" placeholder="Comments">
                                    </div>
                                    <div class="sec-btn text-center mt-3">
                                        <a href="#" class="btn theme-btn px-5">Save</a>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                </div>

            </div>

        </div>

    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.js"></script>

    <script>
        $(document).ready(function() {

            $('.btn-approve').on('click', function() {

                const reviewId = $(this).data('id');

                Swal.fire({

                    title: 'Are you sure?',

                    text: "You want to approve this review!",

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonColor: '#3085d6',

                    cancelButtonColor: '#d33',

                    confirmButtonText: 'Yes, approve it!'

                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({

                            url: '{{ route('admin.reviews.approve', ['id' => ':id']) }}'
                                .replace(':id', reviewId),

                            type: 'POST',

                            headers: {

                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                            },

                            success: function(data) {

                                if (data.success) {

                                    Swal.fire(

                                        'Approved!',

                                        data.message,

                                        'success'

                                    ).then(() => {

                                        location.reload();

                                    });

                                } else {

                                    Swal.fire(

                                        'Error!',

                                        'Something went wrong.',

                                        'error'

                                    );

                                }

                            },

                            error: function() {

                                Swal.fire(

                                    'Error!',

                                    'Error occurred while processing the request.',

                                    'error'

                                );

                            }

                        });

                    }

                });

            });



            $('.btn-decline').on('click', function() {

                const reviewId = $(this).data('id');

                Swal.fire({

                    title: 'Are you sure?',

                    text: "You want to decline this review!",

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonColor: '#3085d6',

                    cancelButtonColor: '#d33',

                    confirmButtonText: 'Yes, decline it!'

                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({

                            url: '{{ route('admin.reviews.decline', ['id' => ':id']) }}'
                                .replace(':id', reviewId),

                            type: 'POST',

                            headers: {

                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                            },

                            success: function(data) {

                                if (data.success) {

                                    Swal.fire(

                                        'Declined!',

                                        data.message,

                                        'success'

                                    ).then(() => {

                                        location.reload();

                                    });

                                } else {

                                    Swal.fire(

                                        'Error!',

                                        'Something went wrong.',

                                        'error'

                                    );

                                }

                            },

                            error: function() {

                                Swal.fire(

                                    'Error!',

                                    'Error occurred while processing the request.',

                                    'error'

                                );

                            }

                        });

                    }

                });

            });

        });
    </script>

    <!-- Reject Reason Input -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dropdown = document.getElementById("actionDropdown");
            const rejectReasonGroup = document.getElementById("rejectReasonGroup");

            dropdown.addEventListener("change", function() {
                if (this.value === "reject") {
                    rejectReasonGroup.style.display = "block";
                } else {
                    rejectReasonGroup.style.display = "none";
                }
            });
        });
    </script>
@endpush
