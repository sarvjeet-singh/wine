@extends('admin.layouts.app')
@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <h2 class="mb-0">Manage Admins</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-between p-3">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="#" class="text-decoration-none text-black">Admin Management</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Manage Admins</li>
                                </ol>
                            </nav>
                        </div>
                        <div>
                            <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
                                <i class="fa-solid fa-plus me-1"></i> Add Admin
                            </a>
                        </div>
                    </div>
                    <!-- Table Start -->
                    <div class="table-users">
                        <div class="table-responsive w-100">
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Profile</th>
                                        <th>Admin Name</th>
                                        <th>Email</th>
                                        <th>Created Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admins as $key => $admin)
                                        <tr>
                                            <td>{{ ($admins->currentPage() - 1) * $admins->perPage() + $loop->iteration }}
                                            </td>
                                            <td>
                                                <img width="50px" class="userprofile-image-icon"
                                                    src="{{ Storage::url($admin->profile_image ?? 'user-main.png') }}">
                                            </td>
                                            <td>{{ $admin->firstname }} {{ $admin->lastname }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td>{{ $admin->created_at->format('m/d/Y') }}</td>
                                            <td>{{ ucfirst($admin->status) }}</td>
                                            <td>
                                                <a href="{{ route('admin.admins.edit', $admin->id) }}"
                                                    class="btn btn-primary">Edit</a>
                                                <form action="{{ route('admin.admins.destroy', $admin->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this admin?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-end">
                                {{ $admins->links() }}
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
