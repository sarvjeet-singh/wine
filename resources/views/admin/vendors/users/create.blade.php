@extends('admin.layouts.app')
@section('css')
    <style>
        .error {
            color: red;
            font-size: 14px;
        }

        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
            border: 1px solid #ddd;
            background: #fff;
            padding: 5px;
            list-style: none;
            position: absolute;
            z-index: 1000;
        }

        .ui-menu-item {
            padding: 5px;
            cursor: pointer;
        }

        .ui-menu-item:hover {
            background-color: #f0f0f0;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <h2 class="mb-0">{{ isset($user) ? 'Edit' : 'Add' }} Contact</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-between p-3">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.vendors.users.index') }}"
                                            class="text-decoration-none text-black">Vendor Contact Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ isset($user) ? 'Edit' : 'Add' }} Contact</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="p-3">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form
                            action="{{ isset($user) ? route('admin.vendors.users.update', $user->id) : route('admin.vendors.users.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($user))
                                @method('PUT') {{-- Use PUT method for updates --}}
                            @endif

                            <div class="information-box mb-3">
                                <div class="info-head p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="text-white">Contact Information</div>
                                    </div>
                                </div>
                                <div class="m-3 pb-4">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div>
                                                <label for="firstname" class="form-label fw-bold">First Name</label>
                                                <input type="text" id="firstname" name="firstname" class="form-control"
                                                    placeholder="Enter first name" autocomplete="off"
                                                    value="{{ old('firstname', $user->firstname ?? '') }}">
                                                @error('firstname')
                                                    <div class="error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="lastname" class="form-label fw-bold">Last Name</label>
                                                <input type="text" id="lastname" name="lastname" class="form-control"
                                                    placeholder="Enter last name" autocomplete="off"
                                                    value="{{ old('lastname', $user->lastname ?? '') }}">
                                                @error('lastname')
                                                    <div class="error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="email" class="form-label fw-bold">Email</label>
                                                <input type="email" id="email" name="email" class="form-control"
                                                    placeholder="Enter email" autocomplete="off"
                                                    value="{{ old('email', $user->email ?? '') }}">
                                                @error('email')
                                                    <div class="error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="contact_number" class="form-label fw-bold">Contact
                                                    Number</label>
                                                <input type="text" id="contact_number" name="contact_number"
                                                    class="form-control phone-number" placeholder="Enter contact number"
                                                    autocomplete="off"
                                                    value="{{ old('contact_number', $user->contact_number ?? '') }}">
                                                @error('contact_number')
                                                    <div class="error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="vendors" class="form-label fw-bold">Select Vendors</label>
                                                <select id="vendors" name="vendor_id[]" class="form-control select2"
                                                    multiple>
                                                    @foreach ($vendors as $vendor)
                                                        <option value="{{ $vendor->id }}"
                                                            {{ isset($user) && $user->vendors->contains($vendor->id) ? 'selected' : '' }}>
                                                            {{ $vendor->vendor_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('vendors')
                                                    <div class="error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="password" class="form-label fw-bold">Password</label>
                                                <input type="password" id="password" name="password"
                                                    class="form-control" placeholder="Enter password" autocomplete="off">
                                                @if (isset($user))
                                                    <small class="text-muted">Leave blank to keep the existing
                                                        password.</small>
                                                @endif
                                                @error('password')
                                                    <div class="error">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mb-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($user) ? 'Update' : 'Save' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#vendors').select2({
                placeholder: "Select Vendors",
                allowClear: true,
                tags: false, // Prevent adding new options
                minimumInputLength: 0, // Start search after 1 character
                width: '100%' // Ensures full-width dropdown
            });
        });
        document.querySelectorAll('.phone-number').forEach(function(input) {
            input.addEventListener('input', function(e) {
                const value = e.target.value.replace(/\D/g, ''); // Remove all non-digit characters
                let formattedValue = '';

                if (value.length > 3 && value.length <= 6) {
                    formattedValue = value.slice(0, 3) + '-' + value.slice(3);
                } else if (value.length > 6) {
                    formattedValue = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
                } else {
                    formattedValue = value;
                }

                e.target.value = formattedValue;
            });
        });
    </script>
@endpush
