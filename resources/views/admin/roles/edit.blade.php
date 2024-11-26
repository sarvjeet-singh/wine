@extends('admin.layouts.app')
@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <h2 class="mb-0">Edit Role</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-between p-3">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="#"
                                            class="text-decoration-none text-black">Role Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Role</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.roles.update', $role->id ?? '') }}">
                        @csrf
                        @method('PUT')
                        <div class="information-box mb-3">
                            <div class="m-3 pb-4">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div>
                                            <label for="" class="form-label fw-bold">Role Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                name="name" id="name" placeholder="Enter Role Name"
                                                value="{{ old('name', $role->name) }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="text-center mb-3">
                                        <button type="submit" class="btn theme-btn px-5">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
