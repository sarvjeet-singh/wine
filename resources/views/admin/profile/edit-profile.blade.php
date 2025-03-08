@extends('admin.layouts.app')
@section('title', (!empty($vendor) ? 'Edit' : 'Create') . ' Profile')
@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <h2 class="mb-0">Profile</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="information-box p-3">
                        <div class="info-head p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="text-white">{{ $admin->id ? 'Edit Admin' : 'Create Admin' }}</div>
                            </div>
                        </div>
                        <div class="m-3 pt-3">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form
                                action="{{ isset($admin->id) ? route('admin.admins.update', $admin->id) : route('admin.admins.store') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @if (isset($admin->id))
                                    @method('PUT')
                                @endif

                                <div class="profile-img-sec text-center">
                                    <label for="profileImage" class="position-relative">
                                        <img id="profilePreview"
                                            src="{{ isset($admin->profile_image) ? Storage::url($admin->profile_image) : asset('asset/admin/images/user-main.png') }}"
                                            class="profile-img rounded-circle" alt="Profile Image"
                                            style="width: 120px; height: 120px; object-fit: cover; border: 2px solid #313744;">
                                        <i class="fa-solid fa-plus"></i>
                                    </label>
                                    <input type="file" id="profileImage" name="profile_image" class="file-input"
                                        accept="image/*" style="display: none;">
                                </div>

                                <div class="mt-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="firstname"
                                                    value="{{ old('firstname', $admin->firstname ?? '') }}" required>
                                                <label>First Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="lastname"
                                                    value="{{ old('lastname', $admin->lastname ?? '') }}" required>
                                                <label>Last Name</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating mb-3">
                                                <input type="email" class="form-control" name="email"
                                                    value="{{ old('email', $admin->email ?? '') }}" required>
                                                <label>Email</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="password" class="form-control" name="password">
                                                <label>Change Password</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3">
                                                <input type="password" class="form-control" name="password_confirmation">
                                                <label>Confirm Password</label>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center mt-3">
                                            <button type="submit" class="btn btn-primary px-5">Save Changes</button>
                                        </div>
                                    </div>
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
    <script>
        document.getElementById('profileImage').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profilePreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
