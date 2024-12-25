@extends('admin.layouts.app')
@section('content')
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
                    <!-- Table Start -->
                    <div class="table-users">
                        <div class="table-responsive w-100">
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>User Profile</th>
                                        <th>Username</th>
                                        <th>Vendor Type</th>
                                        <th>Vendor Name</th>
                                        <th width="15%">Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reviews as $key => $review)
                                        <tr>
                                            <td>{{ ($reviews->currentPage() - 1) * $reviews->perPage() + $loop->iteration }}
                                            </td>
                                            <td>
                                                <img width="50px" class="userprofile-image-icon"
                                                    src="{{ asset('images/UserProfile/' . ($review->customer->profile_image ?? 'default-profile.png')) }}">
                                            </td>
                                            <td>{{ $review->customer->firstname ?? '' }} {{ $review->customer->lastname ?? '' }}
                                            </td>
                                            <td>{{ ucfirst($review->vendor->vendor_type) }}</td>
                                            <td>{{ $review->vendor->vendor_name }}</td>
                                            <td>{{ ucfirst($review->review_status) }}</td>
                                            <td>
                                                <a href="{{ route('admin.reviews.show', $review->id) }}"
                                                    class="btn btn-primary">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-end">
                                {{ $reviews->links() }}
                            </div>
                        </div>
                    </div>
                    <!-- Table End -->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
