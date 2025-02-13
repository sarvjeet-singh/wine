{{-- resources/views/admin/taxes/index.blade.php --}}
@extends('admin.layouts.app')
@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <h2 class="mb-0">Tax Management</h2>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('admin.taxes.create') }}" class="btn btn-primary">Add Tax Rate</a>
                    <a href="{{ route('admin.taxes.sync.index') }}" class="btn btn-info">
                        <i class="fas fa-sync-alt"></i> Sync Stripe Taxes
                    </a>
                </div>
            </div>
        </div>
        <div>
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-between p-3">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="#"
                                            class="text-decoration-none text-black">Tax Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Tax Rate Listing</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="dropdown">
                                <select class="form-select" name="status" id="statusSelect">
                                    <option value="">Select Status</option>
                                    <option {{ request('status') == 'active' ? 'selected' : '' }} value="active">Active
                                    </option>
                                    <option {{ request('status') == 'inactive' ? 'selected' : '' }} value="inactive">
                                        Inactive</option>
                                </select>
                            </div>
                            <div class="search-bar position-relative">
                                <input autocomplete="off" value="{{ !empty(request('q')) ? request('q') : '' }}"
                                    type="search" name="search" id="search" placeholder="Search tax rates...">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="filterTaxes()">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                            <div class="total-user-value">
                                <p class="mb-0 fw-bold">Total Tax Rates: <span>{{ $total }}</span></p>
                            </div>
                        </div>
                    </div>
                    <!-- Table Start -->
                    <div class="table-users">
                        <div class="table-responsive w-100">
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th>Tax Name</th>
                                        <th>Percentage</th>
                                        <th>Status</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($taxes) > 0)
                                        @foreach ($taxes as $tax)
                                            <tr>
                                                <td>{{ $tax->name }}</td>
                                                <td>{{ $tax->percentage }}%</td>
                                                <td>
                                                    <span class="badge {{ $tax->active ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $tax->active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td><span
                                                        class="badge {{ $tax->type ? 'bg-success' : 'bg-danger' }}">{{ $tax->type ? 'Inclusive' : 'Exclusive' }}</span>
                                                </td>
                                                <td>{{ Str::limit($tax->description, 50) }}</td>
                                                <td>{{ $tax->created_at->format('m/d/Y') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.taxes.edit', $tax->id) }}">
                                                        <img
                                                            src="{{ asset('asset/admin/images/icons/gray-edit-icon.png') }}" />
                                                    </a>
                                                    <form action="{{ route('admin.taxes.destroy', $tax->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this tax rate?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link p-0">
                                                            <i class="fa-solid fa-trash text-danger"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">No Tax Rates Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-end justify-content-end">
                    {{ $taxes->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function filterTaxes() {
            let baseUrl = window.location.origin + window.location.pathname;
            let status = document.getElementById('statusSelect').value;
            let searchTerm = document.getElementById('search').value;

            let params = new URLSearchParams();

            if (status) {
                params.append('status', status);
            }

            if (searchTerm) {
                params.append('q', searchTerm);
            }

            window.location.href = baseUrl + '?' + params.toString();
        }

        $(document).ready(function() {
            // Auto-submit on enter key in search box
            $('#search').keypress(function(e) {
                if (e.which == 13) {
                    if (window.location.pathname.includes('plans')) {
                        filterPlans();
                    } else {
                        filterTaxes();
                    }
                }
            });
        });
    </script>
@endpush
