{{-- resources/views/admin/plans/sync.blade.php --}}
@extends('admin.layouts.app')
@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <h2 class="mb-0">Sync Stripe Plans</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-between p-3">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-black">Plan Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Sync Stripe Plans</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <div class="p-3">
                        <div class="alert alert-info">
                            <h5 class="alert-heading">Sync Information</h5>
                            <p>This will sync all active plans from your Stripe account to your local database. The process will:</p>
                            <ul>
                                <li>Import new plans from Stripe</li>
                                <li>Update existing plans with latest Stripe data</li>
                                <li>Mark local plans as inactive if they no longer exist in Stripe</li>
                            </ul>
                        </div>

                        <form action="{{ route('admin.plans.sync') }}" method="POST" class="text-center">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sync-alt me-2"></i> Sync Plans from Stripe
                            </button>
                        </form>

                        @if(session('success'))
                            <div class="alert alert-success mt-3">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger mt-3">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection