@extends('admin.layouts.app')
@section('content')
    <div class="main-content-inner">
        <div class="main-head d-flex align-items-center justify-content-between mb-4">
            <h2 class="mb-0"> {{ isset($category) ? 'Edit Category' : 'Add Category' }}</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card p-4 shadow-lg rounded bg-white mx-auto" style="max-width: 600px;">
                    <form method="POST"
                        action="{{ isset($category) ? route('admin.curative-experience-categories.update', $category->id) : route('admin.curative-experience-categories.store') }}"
                        enctype="multipart/form-data" class="needs-validation" novalidate>

                        @csrf
                        @isset($category)
                            @method('PUT')
                        @endisset

                        <div class="mb-3">
                            <label class="fw-bold">Name</label>
                            <input type="text" class="form-control border-primary shadow-sm" name="name"
                                value="{{ old('name', $category->name ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Status</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" id="statusToggle" name="status"
                                    value="active" {{ isset($category) && $category->status == 'active' ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold text-success" for="statusToggle">Active</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Image</label>
                            <input type="file" class="form-control border-primary shadow-sm" name="image"
                                id="imageUpload">
                            @if (isset($category) && $category->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $category->image) }}" id="imagePreview"
                                        class="rounded shadow-sm" width="100">
                                </div>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow">
                            <i class="fas fa-save me-2"></i> Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        document.getElementById('imageUpload').addEventListener('change', function(event) {
            let reader = new FileReader();
            reader.onload = function() {
                let preview = document.getElementById('imagePreview');
                if (!preview) {
                    preview = document.createElement('img');
                    preview.id = 'imagePreview';
                    preview.className = 'rounded shadow-sm mt-2';
                    preview.width = 100;
                    document.querySelector('.mb-3:last-child').appendChild(preview);
                }
                preview.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>
@endpush
