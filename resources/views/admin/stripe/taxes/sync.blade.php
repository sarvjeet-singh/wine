{{-- resources/views/admin/plans/sync.blade.php --}}
@extends('admin.layouts.app')
@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <h2 class="mb-0">Sync Stripe Taxes</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-between p-3">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-black">Tax Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Sync Stripe Tax</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <div class="p-3">
                        <div class="alert alert-info">
                            <h5 class="alert-heading">Sync Information</h5>
                            <p>This will sync all taxes from your Stripe account to your local database. The process will:</p>
                            <ul>
                                <li>Import new taxes from Stripe</li>
                                <li>Update existing taxes with latest Stripe data</li>
                                <li>Mark local taxes as inactive if they no longer exist in Stripe</li>
                            </ul>
                        </div>

                        <form action="{{ route('admin.taxes.sync') }}" method="POST" class="text-center">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sync-alt me-2"></i> Sync Taxes from Stripe
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