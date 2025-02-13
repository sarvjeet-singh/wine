{{-- resources/views/admin/taxes/create.blade.php --}}
@extends('admin.layouts.app')

@section('title', isset($tax) ? 'Edit Tax' : 'Create Tax')

@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <h4 class="fw-bold">{{ isset($tax) ? 'Edit Tax' : 'Create Tax' }}</h4>
        </div>
        <div>
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="p-3">
                        <form action="{{ isset($tax) ? route('admin.taxes.update', $tax->id) : route('admin.taxes.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($tax))
                                @method('PUT')
                            @endif

                            <div class="mb-3">
                                <label for="name" class="form-label">Tax Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" placeholder="Tax Name" value="{{ old('name', $tax->name ?? '') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3"
                                    placeholder="Description">{{ old('description', $tax->description ?? '') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @if (!isset($tax))
                                <div class="mb-3">
                                    <label for="percentage" class="form-label">Tax Percentage</label>
                                    <input type="number" class="form-control @error('percentage') is-invalid @enderror"
                                        name="percentage" placeholder="Tax Percentage"
                                        value="{{ old('percentage', $tax->percentage ?? '') }}" step="0.01">
                                    @error('percentage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input @error('inclusive') is-invalid @enderror"
                                        name="inclusive" id="inclusive" value="1"
                                        {{ old('inclusive', $tax->inclusive ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inclusive">Inclusive</label>
                                    @error('inclusive')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            <div class="text-end">
                                <button type="submit"
                                    class="btn btn-primary">{{ isset($tax) ? 'Update Tax' : 'Create Tax' }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
