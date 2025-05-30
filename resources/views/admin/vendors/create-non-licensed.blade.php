@extends('admin.layouts.app')
@section('title', (!empty($vendor) ? 'Edit' : 'Create') . ' Non Licensed')
@section('css')
    <link rel="stylesheet" href="{{ asset('asset/css/select2.min.css') }}">
@endsection
@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            @include('admin.vendors.partials.partial-title')
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-between p-3">
                        @include('admin.vendors.partials.partial-breadcrumb')
                        @include('admin.vendors.partials.partial-select')
                    </div>

                    <div class="p-3">
                        <form action="{{ $form_route }}" method="POST">
                            <!-- Business/Vendor Details -->
                            @include('admin.vendors.partials.partial-vendor-section')
                            <!-- / Business/Vendor Details -->

                            <!-- Excursion Details -->
                            <div class="information-box mb-3">
                                <div class="info-head p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="text-white">Non-Licensed Details</div>
                                    </div>
                                </div>
                                <div class="m-3 pb-4">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div>
                                                <label for="" class="form-label fw-bold">Non-Licensee
                                                    Sub-Type*</label>
                                                <select class="form-select" name="vendor_sub_category"
                                                    id="vendor_sub_category" aria-label="Default select example">
                                                    <option value="" disabled selected>Please Select</option>
                                                    @foreach (getSubCategories('5') as $subcategory)
                                                        <option value="{{ $subcategory['id'] }}"
                                                            {{ old('vendor_sub_category', $vendor->vendor_sub_category ?? '') == $subcategory['id'] ? 'selected' : '' }}>
                                                            {{ $subcategory['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('vendor_sub_category')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="" class="form-label fw-bold">Farming Practices</label>
                                                <select class="form-select" name="farming_practices"
                                                    aria-label="Default select example">
                                                    <option value="" disabled selected>Select a farming practice
                                                    </option>
                                                    @foreach (getFarmingPractices() as $farming_practice)
                                                        <option value="{{ $farming_practice['id'] }}"
                                                            {{ old('farming_practices', $vendor->metdata->farming_practices ?? '') == $farming_practice['id'] ? 'selected' : '' }}>
                                                            {{ $farming_practice['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <label for="" class="form-label fw-bold">Max Group</label>
                                                <select class="form-select" name="max_group"
                                                    aria-label="Default select example">
                                                    <option value="" disabled selected>Select group
                                                    </option>
                                                    @foreach (getMaxGroups() as $max_group)
                                                        <option value="{{ $max_group['id'] }}"
                                                            {{ old('max_group', $vendor->metdata->max_group ?? '') == $max_group['id'] ? 'selected' : '' }}>
                                                            {{ $max_group['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div>
                                                <label for="" class="form-label fw-bold">Cuisine</label>
                                                <select id="multiple-select" class="form-select"
                                                    aria-label="Default select example" name="cuisines[]" multiple>
                                                    @foreach (getCuisines() as $cuisine)
                                                        <option value="{{ $cuisine['id'] }}"
                                                            {{ collect(old('cuisines', !empty($vendor) && !empty($vendor->metadata->cuisines) ? json_decode($vendor->metadata->cuisines, true) : []))->contains($cuisine['id']) ? 'selected' : '' }}>
                                                            {{ $cuisine['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('cuisines')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / Excursion Details -->

                            <!-- Vendor Contact  -->
                            @include('admin.vendors.partials.partial-user-section')
                            <!-- / Vendor Contact  -->
                            @include('admin.vendors.partials.partial-button')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('asset/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#multiple-select').select2({
                placeholder: 'Select cuisines...',
                width: '100%'
            });
        });
    </script>
@endpush
