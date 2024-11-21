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
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <img src="{{ asset('images/UserProfile/' . ($review->user->profile_image ?? 'default-profile.png')) }}"
                                            class="img-fluid" alt="Profle Image" />
                                        <p class="fw-bold mt-2 mb-0">{{ $review->user->firstname }}
                                            {{ $review->user->lastname }}</p>
                                        <p class="mb-0">{{ $review->user->email }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <!-- <p class="mb-1"><span class="fw-bold">User eMail: </span> loremlpsum@gmail.com</p> -->
                                        <p class="mb-2"><span class="fw-bold">Receipt Number: </span>
                                            {{ $review->receipt ?? 'N/A' }}</p>
                                        <p class="mb-2"><span class="fw-bold">Date of Visit: </span>
                                            {{ $review->date_of_visit ?? 'N/A' }}</p>
                                        <p class="mb-2"><span class="fw-bold">Comment: </span>
                                            {{ $review->review_description ?? 'N/A' }}</p>
                                        <p class="mb-1"><span class="fw-bold">Rating: </span>
                                            {{ $review->rating ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        @if ($review->review_status == 'pending')
                                            <button class="btn btn-success btn-approve"
                                                data-id="{{ $review->id }}">Approve</button>
                                            <button class="btn btn-danger btn-decline"
                                                data-id="{{ $review->id }}">Decline</button>
                                        @elseif ($review->review_status == 'approved')
                                            <button class="btn btn-success" disabled>Approved</button>
                                        @elseif ($review->review_status == 'declined')
                                            <button class="btn btn-danger" disabled>Declined</button>
                                        @endif
                                    </div>
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
                                        <p class="mb-2"><span class="fw-bold">Date of Visit: </span>
                                            {{ $review->date_of_visit ?? 'N/A' }}</p>
                                        <p class="mb-2"><span class="fw-bold">Vendor Contact Number: </span>
                                            {{ $review->vendor->vendor_phone ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            url: '{{ route('admin.reviews.approve', ['id' => ':id']) }}'.replace(':id', reviewId),
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
                            url: '{{ route('admin.reviews.decline', ['id' => ':id']) }}'.replace(':id', reviewId),
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
@endpush
