@extends('admin.layouts.app')
@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <h2 class="mb-0">Vendor Management</h2>
                <a class="btn btn-primary" href="{{ route('admin.vendors.create') }}">Add Vendor</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-between p-3">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="#"
                                            class="text-decoration-none text-black">Vendor Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Vendor Listing</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="dropdown">
                                <select class="form-select" name="category" id="categorySelect">
                                    <option value="">Select Type</option>
                                    @foreach ($categories as $category)
                                        <option {{ (request('v') == $category['slug']) ? 'selected' : '' }} value="{{ $category['slug'] }}">{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="search-bar position-relative">
                                <input autocomplete="off" value="{{ !empty(request('q')) ? request('q') : '' }}" type="search" name="search" id="search" placeholder="Type to Search..">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="filterVendors()"><i
                                    class="fa-solid fa-magnifying-glass"></i></button>
                            <div class="total-user-value">
                                <p class="mb-0 fw-bold">Total Vendors: <span>{{ $total }}</span></p>
                            </div>
                        </div>
                    </div>
                    <!-- Table Start -->
                    <div class="table-users">
                        <div class="table-responsive w-100">
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th>Vendor Name</th>
                                        <th>Account Type</th>
                                        <th>Business Email</th>
                                        <th>Account Status</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($vendors) > 0)
                                        @foreach ($vendors as $vendor)
                                            <tr>
                                                <td>{{ $vendor->vendor_name ?? '-' }}</td>
                                                <td>{{ ucfirst($vendor->vendor_type) ?? '-' }}</td>
                                                <td>{{ $vendor->vendor_email ?? '-' }}</td>
                                                <td>{{ $vendor->accountStatus->name ?? '-' }}</td>
                                                <td>{{ $vendor->created_at->format('m/d/Y') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.vendors.edit', $vendor->id) }}">
                                                        <img
                                                            src="{{ asset('asset/admin/images/icons/gray-edit-icon.png') }}" />
                                                    </a>
                                                    <a href="{{ route('admin.vendor.details', $vendor->id) }}">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </a>
                                                    {{-- uploded files --}}
                                                    <a href="{{ route('admin.vendors.uploaded-files', $vendor->id) }}">
                                                        <i class="fa-solid fa-upload"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center">No Vendors Found</td>
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
                    {{ $vendors->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('asset/js/jquery-ui.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#search').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: '{{ route('admin.vendors.search') }}',
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
                    filterVendors();
                }
            });
        });

        function filterVendors() {
            // Get the current URL without query string
            let baseUrl = window.location.origin + window.location.pathname;

            // Get the selected vendor type and search name
            let vendorType = document.getElementById('categorySelect').value;
            let searchName = document.getElementById('search').value;

            // Build the query parameters
            let params = new URLSearchParams();

            if (vendorType) {
                params.append('v', vendorType);
            }

            if (searchName) {
                params.append('q', searchName);
            }

            // Redirect to the new URL with the query parameters
            window.location.href = baseUrl + '?' + params.toString();
        }
    </script>
@endpush
