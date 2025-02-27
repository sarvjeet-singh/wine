@extends('admin.layouts.app')
@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <h2 class="mb-0">View Contact</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-between p-3">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.vendors.users.index') }}" class="text-decoration-none text-black">Vendor Contact Management</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">View Contact</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="card shadow-lg border-0 rounded-3">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 60px; height: 60px; font-size: 24px;">
                                        {{ strtoupper(substr($user->firstname, 0, 1)) }}{{ strtoupper(substr($user->lastname, 0, 1)) }}
                                    </div>
                                    <div class="ms-3">
                                        <h4 class="mb-0">{{ $user->firstname }} {{ $user->lastname }}</h4>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="info-box p-3 bg-light rounded">
                                            <strong class="d-block text-muted">Email:</strong>
                                            <span>{{ $user->email }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-box p-3 bg-light rounded">
                                            <strong class="d-block text-muted">Contact Number:</strong>
                                            <span>{{ $user->contact_number }}</span>
                                        </div>
                                    </div>
                                    @if ($user->vendors->isNotEmpty())
                                        <div class="col-12">
                                            <div class="info-box p-3 bg-light rounded">
                                                <strong class="d-block text-muted">Vendors:</strong>
                                                {!! $user->vendors->pluck('vendor_name')->map(fn($name) => "<span class='badge bg-primary'>$name</span>")->join(' ') !!}
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('admin.vendors.users.edit', $user->id) }}" class="btn btn-primary">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                    <a href="{{ route('admin.vendors.users.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> Back to List
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
