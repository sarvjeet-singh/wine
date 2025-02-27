@extends('admin.layouts.app')
@section('content')
    <div class="main-content-inner">
        <div class="main-head d-flex align-items-center justify-content-between mb-4">
            <h2 class="mb-0">Refund Policy</h2>
            <a href="#" class="btn theme-btn text-center py-2 px-4" data-bs-toggle="modal"
                data-bs-target="#addInfo">Update</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card p-4">
                    <form id="refundPolicyForm" action="{{ route('admin.cms.refund-policy.update') }}" method="POST">
                        @csrf
                        <!-- Title Field -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="Enter Title" value="{{ old('title', $refundPolicy->title ?? '') }}" required>
                            <label for="title">Title</label>
                        </div>

                        <!-- Description Fields -->
                        <div class="mb-3">
                            <label for="description_no_cancel" class="form-label">Description (No Cancel)</label>
                            <textarea class="form-control" id="description_no_cancel" name="description[no_cancel]" rows="4" required>
                                {{ old('description.no_cancel', $refundPolicy->description['no_cancel'] ?? '') }}
                            </textarea>
                        </div>

                        <div class="mb-3">
                            <label for="description_one_day" class="form-label">Description (One Day)</label>
                            <textarea class="form-control" id="description_one_day" name="description[one_day]" rows="4" required>
                                {{ old('description.one_day', $refundPolicy->description['one_day'] ?? '') }}
                            </textarea>
                        </div>

                        <div class="mb-3">
                            <label for="description_seven_day" class="form-label">Description (Seven Day)</label>
                            <textarea class="form-control" id="description_seven_day" name="description[seven_day]" rows="4" required>
                                {{ old('description.seven_day', $refundPolicy->description['seven_day'] ?? '') }}
                            </textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Update Refund Policy</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.9.2/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            CKEDITOR.replace('description_no_cancel');
            CKEDITOR.replace('description_one_day');
            CKEDITOR.replace('description_seven_day');
        });
    </script>
@endpush
