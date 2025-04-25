@extends('admin.layouts.app')
@section('content')
    <div class="main-content-inner">
        <div class="main-head d-flex align-items-center justify-content-between mb-4">
            <h2 class="mb-0"> View Event</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card p-4 shadow-lg rounded bg-white mx-auto">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
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
                    <form action="" method="POST" id="experienceForm" enctype="multipart/form-data">
                        @csrf
                        @if (isset($experience))
                            @method('PUT')
                        @endif

                        <div class="information-box-body py-4">
                            <div class="row g-3">
                                <!-- Experience Type -->
                                <div class="col-lg-4 col-12">
                                    <div class="form-floating">
                                        <select name="category_id" class="form-control form-select" id="experienceType"
                                            disabled>
                                            <option value="">Select type</option>
                                            @if ($categories->isEmpty())
                                                <option value="">No Category Found</option>
                                            @else
                                                @foreach ($categories as $key => $category)
                                                    <option value="{{ $key }}"
                                                        {{ old('category_id', isset($experience) ? $experience->category_id : '') == $key ? 'selected' : '' }}>
                                                        {{ $category }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <label class="form-label">Experience Type</label>
                                    </div>
                                </div>

                                <!-- Experience Name -->
                                <div class="col-lg-4 col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name', isset($experience) ? $experience->name : '') }}"
                                            placeholder="Experience Name" readonly>
                                        <label>Experience Name</label>
                                    </div>
                                </div>

                                <!-- Admittance + Free -->
                                <div class="col-lg-4 col-12">
                                    <div class="row">
                                        <div class="col-9">
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" name="admittance"
                                                        value="{{ old('admittance', isset($experience) ? $experience->admittance : '') }}"
                                                        placeholder="Enter Admittance Fee" readonly>
                                                    <label>Admittance</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3 d-flex align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="is_free"
                                                    value="1" id="flexCheckDefault"
                                                    {{ old('is_free', isset($experience) ? $experience->is_free : 0) ? 'checked' : '' }}
                                                    disabled>
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Free
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Extension -->
                                <div class="col-lg-4 col-12">
                                    <div class="form-floating">
                                        <select name="extension" class="form-control" disabled>
                                            @php
                                                $selectedExtension = old(
                                                    'extension',
                                                    isset($experience) ? $experience->extension : '',
                                                );
                                            @endphp
                                            <option value="">+</option>
                                            <option value="/Hr" {{ $selectedExtension == '/Hr' ? 'selected' : '' }}>/Hr
                                            </option>
                                            <option value="/Person"
                                                {{ $selectedExtension == '/Person' ? 'selected' : '' }}>/Person</option>
                                            <option value="/Night" {{ $selectedExtension == '/Night' ? 'selected' : '' }}>
                                                /Night</option>
                                            <option value="/Session"
                                                {{ $selectedExtension == '/Session' ? 'selected' : '' }}>/Session</option>
                                        </select>
                                        <label>Extension</label>
                                    </div>
                                </div>

                                <!-- URL (Booking Platform) -->
                                <div class="col-lg-4 col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="booking_url"
                                            value="{{ old('booking_url', isset($experience) ? $experience->booking_url : '') }}"
                                            placeholder="URL (Booking Platform)" readonly>
                                        <label>URL (Booking Platform)</label>
                                    </div>
                                </div>

                                <!-- Inventory -->
                                <div class="col-lg-4 col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="inventory"
                                            value="{{ old('inventory', isset($experience) ? $experience->inventory : '') }}"
                                            placeholder="Quantity" readonly>
                                        <label>Inventory</label>
                                    </div>
                                </div>

                                <!-- Start Date -->
                                <div class="col-lg-3 col-12">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" name="start_date"
                                            value="{{ old('start_date', isset($experience) ? $experience->start_date : '') }}"
                                            readonly>
                                        <label>Start Date</label>
                                    </div>
                                </div>

                                <!-- End Date -->
                                <div class="col-lg-3 col-12">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" name="end_date"
                                            value="{{ old('end_date', isset($experience) ? $experience->end_date : '') }}"
                                            readonly>
                                        <label>End Date</label>
                                    </div>
                                </div>

                                <!-- Start Time -->
                                <div class="col-lg-3 col-12">
                                    <div class="form-floating">
                                        <input type="time" id="start_time" name="start_time" class="form-control"
                                            value="{{ old('start_time', !empty($experience) && !empty($experience->start_time) ? \Carbon\Carbon::parse($experience->start_time)->format('H:i') : '') }}"
                                            readonly>
                                        <label>Start Time</label>
                                    </div>
                                </div>

                                <!-- End Time -->
                                <div class="col-lg-3 col-12">
                                    <div class="form-floating">
                                        <input type="time" id="end_time" name="end_time" class="form-control"
                                            value="{{ old('end_time', !empty($experience) && !empty($experience->end_time) ? \Carbon\Carbon::parse($experience->end_time)->format('H:i') : '') }}"
                                            readonly>
                                        <label>End Time</label>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" name="description" style="height: 100px" readonly>{{ old('description', isset($experience) ? $experience->description : '') }}</textarea>
                                        <label>Description</label>
                                    </div>
                                </div>

                                <!-- Media Upload -->
                                <div class="col-12">
                                    <div id="profilePreviewWrapper" class="d-flex flex-wrap gap-2">
                                        @if (!empty($experience) && !empty($experience->image))
                                            <img src="{{ Storage::url($experience->image) }}"
                                                class="profile-img rounded-3"
                                                style="width: 200px; height: 130px; object-fit: cover; border: 1px solid #408a95;">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Active/Inactive Toggle -->
                        @php
                            $isActive = isset($experience) && $experience->status === 'active'; // Ensure status is 'active'
                            $buttonClass = $isActive ? 'btn-success' : 'btn-danger';
                            $buttonText = $isActive ? 'Active' : 'Inactive';
                        @endphp

                        <button type="button" class="btn toggle-status w-100 px-4 py-2 {{ $buttonClass }}"
                            data-id="{{ $experience->id ?? '' }}" data-status="{{ $isActive ? 'active' : 'inactive' }}"
                            style="font-size: 1rem; font-weight: 500; border-radius: 8px;">
                            {{ $buttonText }}
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $(".toggle-status").click(function() {
                let button = $(this);
                let experienceId = button.data("id");
                let currentStatus = button.data("status");
                let newStatus = currentStatus === "active" ? "inactive" : "active";

                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to change the status to " + newStatus + "?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, change it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.curative-experiences.toggleStatus') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: experienceId,
                                status: currentStatus
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Toggle status & update button styling
                                    let newStatus = response.status;
                                    button.text(newStatus.charAt(0).toUpperCase() +
                                        newStatus.slice(1));
                                    button.data("status", newStatus);

                                    if (newStatus === "active") {
                                        button.css({
                                            "background-color": "#28a745",
                                            "color": "white"
                                        });
                                    } else {
                                        button.css({
                                            "background-color": "#dc3545",
                                            "color": "white"
                                        });
                                    }

                                    // Show success message
                                    Swal.fire({
                                        title: "Done!",
                                        text: "Status has been updated successfully.",
                                        icon: "success",
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                } else {
                                    Swal.fire("Error!",
                                        "Failed to update status. Please try again.",
                                        "error");
                                }
                            },
                            error: function() {
                                Swal.fire("Error!",
                                    "An error occurred. Please try again.", "error");
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
