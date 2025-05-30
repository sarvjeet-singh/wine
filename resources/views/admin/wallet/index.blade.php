@extends('admin.layouts.app')
@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <h2 class="mb-0">Manage Bottle Bucks</h2>
                <a href="{{ route('admin.wallet.create') }}" class="btn btn-primary">Create Bottle Bucks</a>
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
                                            class="text-decoration-none text-black">Bottle Bucks Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Manage Bottle Bucks</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- Table Start -->
                    <div class="table-users">
                        <div class="table-responsive w-100">
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th>ID #</th>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $key => $transaction)
                                        <tr>
                                            <td>#{{ $transactions->firstItem() + $key }}</td>
                                            <td>{{ $transaction->wallet->customer->firstname . ' ' . $transaction->wallet->customer->lastname }} (ID: {{ $transaction->wallet->customer_id }})</td>
                                            <td>${{ $transaction->amount }}</td>
                                            <td>{{ $transaction->status }}</td>
                                            <td>{{ $transaction->description }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                {{ $transactions->links() }}
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
