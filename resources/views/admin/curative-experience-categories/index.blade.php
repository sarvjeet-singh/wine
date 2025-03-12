@extends('admin.layouts.app')
@section('content')
    <div class="main-content-inner">
        <div class="main-head d-flex align-items-center justify-content-between mb-4">
            <h2 class="mb-0">Curative Experience Categories</h2>
            <a href="{{ route('admin.curative-experience-categories.create') }}"
                class="btn theme-btn text-center py-2 px-4">Add</a>
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
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th>Sort</th>
                                        <th>S. No.</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Status</th>
                                        <th>Image</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable">
                                    @if (count($categories) > 0)
                                        @foreach ($categories as $category)
                                            <tr data-id="{{ $category->id }}">
                                                <td><i class="fa fa-bars handle" style="cursor: grab;"></i></td>
                                                <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}
                                                </td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->slug }}</td>
                                                <td>
                                                    @php
                                                        $statusClass =
                                                            $category->status === 'active' ? 'bg-success' : 'bg-danger';
                                                    @endphp
                                                    <span class="badge {{ $statusClass }} text-white">
                                                        {{ ucfirst($category->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($category->image)
                                                        <img src="{{ asset('storage/' . $category->image) }}"
                                                            width="50">
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.curative-experience-categories.edit', $category->id) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>

                                                    <button class="btn btn-danger btn-sm delete-category"
                                                        data-id="{{ $category->id }}">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>

                                                    <form id="delete-form-{{ $category->id }}"
                                                        action="{{ route('admin.curative-experience-categories.destroy', $category->id) }}"
                                                        method="POST" style="display:none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-end">
                                {{ $categories->links() }}
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
        $(function() {
            $("#sortable").sortable({
                handle: ".handle",
                update: function(event, ui) {
                    let positions = [];
                    $("#sortable tr").each(function(index) {
                        let id = $(this).data("id");
                        positions.push(id);

                        // Update S. No. dynamically
                        $(this).find("td:nth-child(2)").text(index + 1);
                    });

                    // Send updated order to Laravel
                    $.post("{{ route('admin.curative-experience-categories.updateOrder') }}", {
                        positions: positions,
                        _token: "{{ csrf_token() }}"
                    }, function(response) {
                        console.log("Order Updated:", response);
                    }).fail(function(xhr) {
                        console.log("Error:", xhr.responseText);
                    });
                }
            }).disableSelection();
            $(".delete-category").on("click", function() {
                var categoryId = $(this).data("id");

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#delete-form-" + categoryId).submit();
                    }
                });
            });
        });
    </script>
@endpush
