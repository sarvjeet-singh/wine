@extends('admin.layouts.app')
@section('title', (!empty($subscription) ? 'Edit' : 'Create') . ' Subscription')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <h4 class="fw-bold">{{ !empty($subscription) ? 'Edit' : 'Create' }} Subscription</h4>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-between p-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('admin.vendor.subscriptions.index') }}">Subscriptions</a></li>
                                <li class="breadcrumb-item active">{{ !empty($subscription) ? 'Edit' : 'Create' }}</li>
                            </ol>
                        </nav>
                    </div>
                    <div>
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="p-3">
                        <form
                            action="{{ !empty($subscription) ? route('admin.vendor.subscriptions.update', $subscription->id) : route('admin.vendor.subscriptions.store') }}"
                            method="POST">
                            @csrf
                            @if (!empty($subscription))
                                @method('PUT')
                            @endif

                            <div class="information-box mb-3">
                                <div class="info-head p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="text-white">Subscription Details</div>
                                    </div>
                                </div>
                                <div class="m-3 pb-4">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div>
                                                <label class="form-label fw-bold">Vendor</label>
                                                <select name="vendor_id"
                                                    class="form-select select2 @error('vendor_id') is-invalid @enderror">
                                                    <option value="">Select Vendor</option>
                                                    @foreach ($vendors as $vendor)
                                                        <option value="{{ $vendor->id }}"
                                                            {{ old('vendor_id', $subscription->vendor_id ?? '') == $vendor->id ? 'selected' : '' }}>
                                                            {{ $vendor->vendor_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('vendor_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label class="form-label fw-bold">Start Date</label>
                                                <input type="date" name="start_date"
                                                    class="form-control @error('start_date') is-invalid @enderror"
                                                    value="{{ old('start_date', $subscription->start_date ?? '') }}">
                                                @error('start_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label class="form-label fw-bold">End Date</label>
                                                <input type="date" name="end_date"
                                                    class="form-control @error('end_date') is-invalid @enderror"
                                                    value="{{ old('end_date', $subscription->end_date ?? '') }}">
                                                @error('end_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label class="form-label fw-bold">Status</label>
                                                <select name="status"
                                                    class="form-select @error('status') is-invalid @enderror">
                                                    <option value="">Select Status</option>
                                                    <option value="active"
                                                        {{ old('status', $subscription->status ?? '') == 'active' ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="expired"
                                                        {{ old('status', $subscription->status ?? '') == 'expired' ? 'selected' : '' }}>
                                                        Expired</option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label class="form-label fw-bold">Price Type</label>
                                                <select name="price_type" id="priceType"
                                                    class="form-select @error('price_type') is-invalid @enderror"
                                                    onchange="togglePriceField()">
                                                    <option value="">Select Price Type</option>
                                                    <option value="free"
                                                        {{ old('price_type', $subscription->price_type ?? '') == 'free' ? 'selected' : '' }}>
                                                        Free</option>
                                                    <option value="paid"
                                                        {{ old('price_type', $subscription->price_type ?? '') == 'paid' ? 'selected' : '' }}>
                                                        Paid</option>
                                                </select>
                                                @error('price_type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6" id="priceField">
                                            <div>
                                                <label for="charge_amount" class="form-label fw-bold">Price</label>
                                                <input type="text"
                                                    class="form-control @error('charge_amount') is-invalid @enderror"
                                                    name="charge_amount" placeholder="Price"
                                                    value="{{ old('charge_amount', $subscription->charge_amount ?? '') }}"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '')">
                                                @error('charge_amount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div>
                                                <label for="subscription_notes" class="form-label fw-bold">Subscription
                                                    Notes</label>
                                                <textarea class="form-control @error('subscription_notes') is-invalid @enderror" name="subscription_notes"
                                                    rows="3" placeholder="Subscription Notes">{{ old('description', $subscription->subscription_notes ?? '') }}</textarea>
                                                @error('subscription_notes')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="submit"
                                    class="btn btn-primary">{{ !empty($subscription) ? 'Update' : 'Create' }}
                                    Subscription</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    function togglePriceField() {
        let priceType = document.getElementById('priceType').value;
        let priceField = document.getElementById('priceField');

        if (priceType === 'free') {
            priceField.style.display = 'none';
        } else {
            priceField.style.display = 'block';
        }
    }

    // Call function on page load to handle preselected value
    document.addEventListener("DOMContentLoaded", function () {
        togglePriceField();
    });
</script>
@endpush
