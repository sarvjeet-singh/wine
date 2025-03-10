@extends('admin.layouts.app')
@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <h2 class="mb-0">Vendor Contact Management</h2>
                <a class="btn btn-primary" href="{{ route('admin.vendors.users.create') }}">Add Contact</a>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-between p-3">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.vendors.users.index') }}"
                                            class="text-decoration-none text-black">Vendor Contact Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Contact Listing</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="search-bar position-relative">
                                <input autocomplete="off" value="{{ !empty(request('q')) ? request('q') : '' }}"
                                    type="search" name="search" id="search" placeholder="Type to Search..">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="filterUsers()"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                            <div class="total-user-value">
                                <p class="mb-0 fw-bold">Total Contacts: <span>{{ $total }}</span></p>
                            </div>
                        </div>
                    </div>
                    <!-- Table Start -->
                    <div class="table-users">
                        <div class="table-responsive w-100">
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Connected Vendors</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($users) > 0)
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ ucfirst($user->firstname) ?? '-' }}</td>
                                                <td>{{ ucfirst($user->lastname) ?? '-' }}</td>
                                                <td>{{ $user->email ?? '-' }}</td>
                                                <td>{{ $user->contact_number ?? '-' }}</td>
                                                <td><span
                                                        title="{{ $user->vendors->pluck('vendor_name')->implode(', ') ?? '-' }}">
                                                        {{ Str::limit($user->vendors->pluck('vendor_name')->implode(', ') ?? '-', 50, '...') }}
                                                    </span></td>
                                                <td>{{ $user->created_at->format('m/d/Y') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.vendors.users.edit', $user->id) }}">
                                                        <img
                                                            src="{{ asset('asset/admin/images/icons/gray-edit-icon.png') }}" />
                                                    </a>
                                                    <a href="{{ route('admin.vendors.users.show', $user->id) }}">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    <a class="delete-user" data-id="{{ $user->id }}">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">No Contacts Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Table End -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-end justify-content-end">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('asset/js/jquery-ui.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#search').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: '{{ route('admin.vendors.users.search') }}',
                        data: {
                            query: request.term,
                            type: $("#categorySelect").val()
                        },
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.name,
                                    value: item.name,
                                    id: item.id
                                };
                            }));
                        }
                    });
                },
                minLength: 2, // Trigger after 2 characters
                select: function(event, ui) {
                    // Optional: Do something with the selected vendor (ui.item)
                    // console.log(ui.item.id + ": " + ui.item.value);
                    filterUsers();
                }
            });
        });

        function filterUsers() {
            // Get the current URL without query string
            let baseUrl = window.location.origin + window.location.pathname;

            // Get the selected vendor type and search name
            let searchName = document.getElementById('search').value;

            // Build the query parameters
            let params = new URLSearchParams();

            if (searchName) {
                params.append('q', searchName);
            }

            // Redirect to the new URL with the query parameters
            window.location.href = baseUrl + '?' + params.toString();
        }

        $(document).ready(function() {
            $('.delete-user').on('click', function() {
                let userId = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action will delete the contact permanently!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('admin.vendors.users.destroy', ':id') }}'
                                .replace(':id', userId), // Adjust the route if necessary
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr(
                                    'content') // CSRF token
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: xhr.responseJSON.message ||
                                        'Something went wrong!',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
