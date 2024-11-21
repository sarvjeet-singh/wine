@extends('admin.layouts.app')
@section('css')
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <h2 class="mb-0">Frequently Asked Questions</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-end p-3">
                        <a href="javascript:void(0)" class="btn theme-btn text-center py-2 px-3 open-modal-btn"
                            data-url="{{ route('admin.faqs.create-section') }}">
                            Add Section
                        </a>
                    </div>
                    <!-- Table Start -->
                    <div class="table-users">
                        @if (session('success'))
                            <div class="alert alert-success text-white">{{ session('success') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="faqsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Section Name</th>
                                        <th>Account Type</th>
                                        <th>Status</th>
                                        <th>Date Created</th>
                                        <th>Date Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Section Name</th>
                                        <th>Account Type</th>
                                        <th>Status</th>
                                        <th>Date Created</th>
                                        <th>Date Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- Table End -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="faqModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal">

            <div class="modal-content">



            </div>

        </div>

    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable with options
            var table = $('#faqsTable').DataTable({
                processing: true,
                serverSide: true,
                order: [
                    [0, "desc"]
                ],
                ajax: {
                    url: '{{ route('admin.faqs.data') }}',
                    dataType: 'json',
                    error: function(xhr, status, error) {
                        $("#faqsTable_processing").remove();
                        $('#faqsTable').text(xhr.responseJSON.error); // Display error message
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'section_name',
                        name: 'section_name'
                    },
                    {
                        data: 'account_type',
                        name: 'account_type'
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            var btnClass = data === 1 ? 'btn-success' : 'btn-danger';
                            var btnText = data === 1 ? 'Active' : 'Inactive';
                            return `<button class="btn btn-sm ${btnClass} btn-toggle" data-id="${row.id}" data-status="${data}">${btnText}</button>`;
                        }
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Handle click event for toggle buttons
            $('#faqsTable').on('click', '.btn-toggle', function() {
                var id = $(this).data('id');
                var status = $(this).data('status');
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to ${status === 1 ? 'deactivate' : 'activate'} this record?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Ajax request to update status
                        $.ajax({
                            url: `/admin/faqs/${id}/toggle-status`,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                status: status
                            },
                            success: function(response) {
                                // Update DataTables row and redraw
                                $('#faqsTable').DataTable().ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    xhr.responseJSON.error,
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
            // Handle click event for delete button
            $('#faqsTable').on('click', '.btn-delete', function() {
                var id = $(this).data('id');

                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this record!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Ajax request to delete record
                        $.ajax({
                            url: '/admin/faqs/' + id,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                // Reload DataTables data after successful delete
                                $('#faqsTable').DataTable().ajax
                                    .reload(); // Use false for server-side processing
                                Swal.fire(
                                    'Deleted!',
                                    'Your record has been deleted.',
                                    'success'
                                );
                            },
                            error: function(xhr) {
                                // console.error(xhr.responseText);
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete record.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.delete-question', function() {
                var id = $(this).data('id');
                var section_id = $(this).data('section-id');

                // Show SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this record!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Ajax request to delete record
                        $.ajax({
                            url: '/admin/faqs/questions/' + id,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                // Reload DataTables data after successful delete
                                // $('#faqsTable').DataTable().ajax
                                //     .reload(); // Use false for server-side processing
                                $.ajax({

                                    url: '/admin/faqs/create-question/' + section_id, // URL to fetch the data from

                                    type: 'GET',

                                    dataType: 'html', // Expect HTML response

                                    beforeSend: function() {

                                        // Optionally show a loader before sending the request

                                        $('#faqModal .modal-content').html(

                                            '<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>'

                                        );

                                    },

                                    success: function(response) {

                                        // Insert the fetched HTML into the modal's body

                                        $('#faqModal .modal-content').html(
                                            response);



                                        // Show the modal after data is fully loaded

                                        $('#faqModal').modal('show');

                                    },

                                    error: function(xhr) {

                                        // Handle error

                                        $('#faqModal .modal-content').html(

                                            '<p>Error loading data. Please try again later.</p>'
                                            );

                                    }

                                });
                                Swal.fire(
                                    'Deleted!',
                                    'Your record has been deleted.',
                                    'success'
                                );
                            },
                            error: function(xhr) {
                                // console.error(xhr.responseText);
                                Swal.fire(
                                    'Error!',
                                    'Failed to delete record.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on("click", ".btn-close", function() {
                $("#faqModal").modal("hide");
            });

            $(document).on('click', '.open-modal-btn', function() {

                // Get the URL or data-id to load content (if needed)

                var url = $(this).data('url') + '/';

                var modalSize = $(this).data('modal-size') ? $(this).data('modal-size') : '';
                if (modalSize == 'modal-lg') {
                    $(".modal-dialog").addClass(modalSize);
                } else {
                    $(".modal-dialog").removeClass('modal-lg');
                }

                // Clear previous modal content

                $('#faqModal .modal-content').html('');



                // Make the AJAX request

                $.ajax({

                    url: url, // URL to fetch the data from

                    type: 'GET',

                    dataType: 'html', // Expect HTML response

                    beforeSend: function() {

                        // Optionally show a loader before sending the request

                        $('#faqModal .modal-content').html(

                            '<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>'

                        );

                    },

                    success: function(response) {

                        // Insert the fetched HTML into the modal's body

                        $('#faqModal .modal-content').html(response);



                        // Show the modal after data is fully loaded

                        $('#faqModal').modal('show');

                    },

                    error: function(xhr) {

                        // Handle error

                        $('#faqModal .modal-content').html(

                            '<p>Error loading data. Please try again later.</p>');

                    }

                });

            });

        });
    </script>
@endpush
