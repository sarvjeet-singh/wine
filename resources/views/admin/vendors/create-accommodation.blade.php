@extends('admin.layouts.app')
@section('title', (!empty($vendor) ? 'Edit' : 'Create') . ' Accommodation')
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
                            <!-- Business/Vendor Information -->
                            @include('admin.vendors.partials.partial-vendor-section')
                            <!-- / Business/Vendor Information -->

                            <!-- Accommodation Details -->
                            <div class="information-box mb-3">
                                <div class="info-head p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="text-white">Accommodation Details</div>
                                    </div>
                                </div>
                                <div class="m-3 pb-4">
                                    <div class="row g-4">
                                        @foreach (getInventoryTypes(1) as $inventoryType)
                                            <div class="mb-3">
                                                <div>
                                                    <label for=""
                                                        class="form-label fw-bold">{{ $inventoryType->name }}</label>
                                                </div>
                                                @foreach ($inventoryType->subCategories as $subCategory)
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="inventory[{{ $inventoryType->id }}]"
                                                            id="inventory{{ $subCategory->id }}"
                                                            value="{{ $subCategory->id }}"
                                                            {{ old('inventory.' . $inventoryType->id, $vendor->vendor_sub_category ?? '') == $subCategory->id ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="inventory{{ $subCategory->id }}">
                                                            {{ $subCategory->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                        @error('inventory')
                                            @php $inventory_error = str_replace('inventory', 'accommodation category', $message) @endphp
                                            <span class="text-danger">{{ $inventory_error }}</span>
                                        @enderror

                                        <div class="col-md-6">
                                            <div>
                                                <label for="" class="form-label fw-bold">Total Square
                                                    Footage</label>
                                                <input type="text"
                                                    class="form-control @error('square_footage') is-invalid @enderror"
                                                    name="square_footage" placeholder="Total Square Footage"
                                                    value="{{ old('square_footage', $vendor->metadata->square_footage ?? '') }}">
                                                @error('square_footage')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div>
                                                <label for="" class="form-label fw-bold">Bedroom</label>
                                                <input type="text"
                                                    class="form-control @error('bedrooms') is-invalid @enderror"
                                                    name="bedrooms" placeholder="Bedrooms"
                                                    value="{{ old('bedrooms', $vendor->metadata->bedrooms ?? '') }}">
                                                @error('bedrooms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div>
                                                <label for="" class="form-label fw-bold">Washroom</label>
                                                <input type="text"
                                                    class="form-control @error('washrooms') is-invalid @enderror"
                                                    name="washrooms" placeholder="Washrooms"
                                                    value="{{ old('washrooms', $vendor->metadata->washrooms ?? '') }}">
                                                @error('washrooms')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="" class="form-label fw-bold">Beds</label>
                                                    <input type="text" name="beds"
                                                        class="form-control @error('beds') is-invalid @enderror"
                                                        value="{{ old('beds', $vendor->metadata->beds ?? '') }}"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                    @error('beds')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="" class="form-label fw-bold">Sleeps</label>
                                                    <input type="text" name="sleeps"
                                                        class="form-control @error('sleeps') is-invalid @enderror"
                                                        value="{{ old('sleeps', $vendor->metadata->sleeps ?? '') }}"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                    @error('sleeps')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / Accommodation Details -->

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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all radio buttons with names that start with 'inventory['
            const inventoryRadios = document.querySelectorAll('input[type="radio"][name^="inventory["]');

            // Add event listener to each radio button
            inventoryRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    // If this radio is checked, uncheck all others
                    if (this.checked) {
                        inventoryRadios.forEach(r => {
                            if (r !== this) {
                                r.checked = false; // Uncheck all others
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
