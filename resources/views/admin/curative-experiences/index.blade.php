@extends('admin.layouts.app')
@section('content')
    <div class="main-content-inner">
        <div class="main-head d-flex align-items-center justify-content-between mb-4">
            <h2 class="mb-0">Manage Events</h2>
            <form id="searchForm" method="GET" action="{{ route('admin.curative-experiences.index') }}">
                <div class="input-group">
                    <!-- Vendor Search -->
                    <input type="text" id="vendorSearch" name="vendor" value="{{ request('vendor') }}" class="form-control"
                        placeholder="Search Vendor" autocomplete="off">

                    <!-- Experience Search -->
                    <input type="text" id="experienceSearch" name="experience" value="{{ request('experience') }}"
                        class="form-control" placeholder="Search Experience" autocomplete="off">

                    <!-- Combined Search Button -->
                    <button type="submit" class="btn btn-primary" id="filter-btn">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card p-4">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <!-- Table Start -->
                    <div class="table-users text-center">
                        <div class="table-responsive w-100">
                            <form id="bulkStatusForm">
                                @csrf
                                <div id="bulkStatusContainer" class="d-flex justify-content-between mb-3 d-none">
                                    <div>
                                        <select id="bulkStatusSelect" class="form-control d-inline-block w-auto">
                                            <option value="">Select</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                        <button type="button" id="bulkStatusUpdate" class="btn btn-primary">
                                            </i> Update
                                        </button>
                                    </div>
                                </div>
                                <table class="table w-100">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" class="form-check-input" id="selectAll"></th>
                                            <th>S. No.</th>
                                            <th>Vendor Name</th>
                                            <th>Account Status</th>
                                            <th>Experience Type</th>
                                            <th>Experience Name</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sortable">
                                        @if (count($experiences) > 0)
                                            @foreach ($experiences as $experience)
                                                <tr data-id="{{ $experience->id }}">
                                                    <td><input type="checkbox" class="select-experience form-check-input"
                                                            value="{{ $experience->id }}"></td>
                                                    <td>{{ ($experiences->currentPage() - 1) * $experiences->perPage() + $loop->iteration }}
                                                    </td>
                                                    <td>{{ $experience->vendor->vendor_name }}</td>
                                                    <td>{{ $experience->vendor->accountStatus->name }}</td>
                                                    <td>{{ $experience->category->name }}</td>
                                                    <td>{{ $experience->name }}</td>
                                                    <td>
                                                        <span
                                                            class="badge toggle-status {{ $experience->status === 'active' ? 'bg-success' : 'bg-danger' }} text-white"
                                                            data-id="{{ $experience->id }}"
                                                            data-status="{{ $experience->status }}"
                                                            style="cursor: pointer;">
                                                            {{ ucfirst($experience->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.curative-experiences.show', $experience->id) }}"
                                                            class="btn btn-warning btn-sm">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </form>
                            <div class="d-flex justify-content-end">
                                {{ $experiences->links() }}
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
    <!-- Include jQuery UI -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            function setupAutocomplete(inputId, param) {
                $("#" + inputId).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('admin.curative-experiences.search') }}",
                            type: "GET",
                            data: {
                                [param]: request.term
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 2,
                    select: function(event, ui) {
                        $("#" + inputId).val(ui.item.value);
                        $("#searchForm").submit(); // Auto-submit search
                    }
                });
            }

            setupAutocomplete("vendorSearch", "vendor");
            setupAutocomplete("experienceSearch", "experience");
        });
        $("#filter-btn").click(function(e) {
            e.preventDefault();
            $("#searchForm").submit();
        });
        $(document).ready(function() {
            $(".toggle-status").click(function() {
                let statusBadge = $(this);
                let experienceId = statusBadge.data("id");
                let currentStatus = statusBadge.data("status");
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
                                    // Toggle status & class
                                    statusBadge.text(response.status.charAt(0)
                                        .toUpperCase() + response.status.slice(1));
                                    statusBadge.data("status", response.status);

                                    if (response.status === "active") {
                                        statusBadge.removeClass("bg-danger").addClass(
                                            "bg-success");
                                    } else {
                                        statusBadge.removeClass("bg-success").addClass(
                                            "bg-danger");
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
        $(document).ready(function() {
            // Prevent form submission on button click
            $('#bulkStatusUpdate').click(function(e) {
                e.preventDefault(); // Prevent page refresh

                let selectedStatus = $('#bulkStatusSelect').val();
                let selectedExperiences = [];

                $('.select-experience:checked').each(function() {
                    selectedExperiences.push($(this).val());
                });

                if (selectedExperiences.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No experiences selected',
                        text: 'Please select at least one experience to update the status.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    return;
                }

                if (!selectedStatus) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No status selected',
                        text: 'Please select a status before updating.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to update the status of selected experiences.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.curative-experiences.bulkStatusUpdate') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                status: selectedStatus,
                                experiences: selectedExperiences
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Status Updated',
                                    text: 'The status of selected experiences has been updated.',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    location
                                        .reload(); // Refresh the page to reflect changes
                                });
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Something went wrong. Please try again.',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                        });
                    }
                });
            });

            // Select All Checkbox
            $('#selectAll').change(function() {
                $('.select-experience').prop('checked', $(this).prop('checked'));
            });

            $('.select-experience').change(function() {
                if ($('.select-experience:checked').length > 0) {
                    $('#bulkStatusContainer').removeClass('d-none'); // Show bulk status div
                } else {
                    $('#bulkStatusContainer').addClass('d-none'); // Hide bulk status div
                }
            });
        });
        $(document).ready(function() {
            function toggleBulkStatusContainer() {
                if ($('.select-experience:checked').length > 0) {
                    $('#bulkStatusContainer').removeClass('d-none'); // Show div
                } else {
                    $('#bulkStatusContainer').addClass('d-none'); // Hide div
                }
            }

            // Handle individual checkboxes
            $('.select-experience').on('change', function() {
                toggleBulkStatusContainer();
            });

            // Handle "Select All" checkbox
            $('#selectAll').on('change', function() {
                $('.select-experience').prop('checked', $(this).prop('checked')).trigger('change');
            });
        });
    </script>
@endpush
