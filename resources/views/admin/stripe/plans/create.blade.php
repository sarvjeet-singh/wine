@extends('admin.layouts.app')
@section('title', (!empty($plan) ? 'Edit' : 'Create') . ' Plan')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <h4 class="fw-bold">{{ !empty($plan) ? 'Edit' : 'Create' }} Plan</h4>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-between p-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.plans.index') }}">Plans</a></li>
                                <li class="breadcrumb-item active">{{ !empty($plan) ? 'Edit' : 'Create' }}</li>
                            </ol>
                        </nav>
                    </div>
                    <div>
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
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
                            action="{{ !empty($plan) ? route('admin.plans.update', $plan->id) : route('admin.plans.store') }}"
                            method="POST">
                            @csrf
                            @if (!empty($plan))
                                @method('PUT')
                            @endif

                            <!-- Plan Information -->
                            <div class="information-box mb-3">
                                <div class="info-head p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="text-white">Plan Details</div>
                                    </div>
                                </div>
                                <div class="m-3 pb-4">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div>
                                                <label for="name" class="form-label fw-bold">Plan Name</label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    placeholder="Plan Name" value="{{ old('name', $plan->name ?? '') }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        @if (empty($plan))
                                            <div class="col-md-6">
                                                <div>
                                                    <label for="price" class="form-label fw-bold">Price</label>
                                                    <input type="text"
                                                        class="form-control @error('price') is-invalid @enderror"
                                                        name="price" placeholder="Price"
                                                        value="{{ old('price', $plan->price ?? '') }}"
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '')">
                                                    @error('price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div>
                                                    <label for="interval" class="form-label fw-bold">Billing
                                                        Interval</label>
                                                    <select name="interval"
                                                        class="form-select @error('interval') is-invalid @enderror">
                                                        <option value="">Select Interval</option>
                                                        <option value="day"
                                                            {{ old('interval', $plan->interval ?? '') == 'day' ? 'selected' : '' }}>
                                                            Daily</option>
                                                        <option value="week"
                                                            {{ old('interval', $plan->interval ?? '') == 'week' ? 'selected' : '' }}>
                                                            Weekly</option>
                                                        <option value="month"
                                                            {{ old('interval', $plan->interval ?? '') == 'month' ? 'selected' : '' }}>
                                                            Monthly</option>
                                                        <option value="year"
                                                            {{ old('interval', $plan->interval ?? '') == 'year' ? 'selected' : '' }}>
                                                            Yearly</option>
                                                        <option value="3months"
                                                            {{ old('interval', $plan->interval ?? '') == '3months' ? 'selected' : '' }}>
                                                            Every 3 months</option>
                                                        <option value="6months"
                                                            {{ old('interval', $plan->interval ?? '') == '6months' ? 'selected' : '' }}>
                                                            Every 6 months</option>
                                                    </select>
                                                    @error('interval')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div>
                                                    <label for="currency" class="form-label fw-bold">Currency</label>
                                                    <select name="currency"
                                                        class="form-select @error('currency') is-invalid @enderror">
                                                        <option value="">Select Currency</option>
                                                        @if (count($currencies) > 0)
                                                            @foreach ($currencies as $key => $currency)
                                                                <option value="{{ $key }}"
                                                                    {{ old('currency', $plan->currency ?? '') == $key ? 'selected' : '' }}>
                                                                    {{ $currency }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    @error('currency')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-12">
                                            <div>
                                                <label for="description" class="form-label fw-bold">Description</label>
                                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3"
                                                    placeholder="Plan Description">{{ old('description', $plan->description ?? '') }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div>
                                                <label for="features" class="form-label fw-bold">Features</label>
                                                <textarea class="form-control @error('features') is-invalid @enderror" name="features" rows="3"
                                                    placeholder="Plan Feature">{{ old('features', $plan->features ?? '') }}</textarea>
                                                @error('features')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="features" class="form-label fw-bold">Vendor Type</label>
                                                <select name="type" class="form-select" id="type">
                                                    <option value="">Select Type</option>
                                                    @if (getCategories())
                                                        @foreach (getCategories() as $category)
                                                            <option value="{{ $category['slug'] }}"
                                                                {{ old('type', $plan->type ?? '') == $category['slug'] ? 'selected' : '' }}>
                                                                {{ $category['name'] }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('features')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="sort_order" class="form-label fw-bold">Sort Order</label>
                                                <select name="sort_order" id="sort_order" class="form-select">
                                                    @foreach (range(1, 100) as $i)
                                                        <option
                                                            {{ old('sort_order', $plan->sort_order ?? '') == $i ? 'selected' : '' }}
                                                            value="{{ $i }}">{{ $i }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tax Information -->
                            <div class="information-box mb-3">
                                <div class="info-head p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="text-white">Tax Rates</div>
                                    </div>
                                </div>
                                <div class="m-3 pb-4">
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <label class="form-label fw-bold">Applicable Taxes</label>
                                            @foreach ($taxes as $tax)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="tax_ids[]"
                                                        value="{{ $tax->id }}" id="tax{{ $tax->id }}"
                                                        {{ in_array($tax->id, old('tax_ids', !empty($plan) ? $plan->taxes->pluck('id')->toArray() : [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="tax{{ $tax->id }}">
                                                        {{ $tax->name }} ({{ $tax->percentage }}%)
                                                    </label>
                                                </div>
                                            @endforeach
                                            @error('tax_ids')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    {{ !empty($plan) ? 'Update' : 'Create' }} Plan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.9.2/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            $('select').select2();
            CKEDITOR.replace('features', {
                extraAllowedContent: '*(*);*{*}', // Allows all tags, attributes, and styles
                allowedContent: true, // Fully allows all HTML content
                enterMode: CKEDITOR.ENTER_BR, // Prevents extra paragraphs
            });
        });
    </script>
@endpush
