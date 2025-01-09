@extends('admin.layouts.app')
@section('content')
    <div class="main-content-inner">
        <div class="main-head d-flex align-items-center justify-content-between mb-4">
            <h2 class="mb-0">Configuration Settings</h2>
            <a href="#" class="btn theme-btn text-center py-2 px-4" data-bs-toggle="modal"
                data-bs-target="#addInfo">Add</a>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card p-4">
                    <!-- Table Start -->
                    <div class="table-users text-center">
                        <div class="table-responsive w-100">
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th width="20%">S.No.</th>
                                        <th width="20%">Title</th>
                                        <th width="20%">Meta Key</th>
                                        <th width="20%">Meta Value</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($settings) > 0)
                                        @foreach ($settings as $setting)
                                            <tr>
                                                <td>{{ $setting->id }}</td>
                                                <td>{{ $setting->title }}</td>
                                                <td>{{ $setting->key }}</td>
                                                <td>{{ $setting->value }}</td>
                                                <td>
                                                    <a href="javascript:void(0);" data-bs-target="#addInfo"
                                                        class="text-white edit-btn"
                                                        data-id="{{ $setting->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Table End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Add Modal Start -->
    <div class="modal fade" id="addInfo" tabindex="-1" aria-labelledby="addInfoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addInfoForm">
                    @csrf
                    @method('POST')
                    <!-- Hidden input for the record ID -->
                    <input type="hidden" name="id" id="id">

                    <div class="modal-header">
                        <h5 class="modal-title" id="addInfoLabel">Add/Edit Configuration Setting</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Title Field -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="Enter Title" required>
                            <label for="title">Title</label>
                        </div>

                        <!-- Key Field -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="key" name="key" placeholder="Enter Key"
                                required>
                            <label for="key">Key</label>
                        </div>

                        <!-- Value Field -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="value" name="value"
                                placeholder="Enter Value" required>
                            <label for="value">Value</label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Modal End -->
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <script>
        $(document).ready(function() {
            $("#addInfoForm").validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 3
                    },
                    key: {
                        required: true,
                        minlength: 2
                    },
                    value: {
                        required: true,
                        minlength: 3
                    }
                },
                messages: {
                    title: {
                        required: "Please enter a title",
                        minlength: "Title must be at least 3 characters long"
                    },
                    key: {
                        required: "Please enter a meta tag",
                        minlength: "Meta tag must be at least 2 characters long"
                    },
                    value: {
                        required: "Please enter a meta value",
                        minlength: "Meta value must be at least 3 characters long"
                    }
                },
                errorElement: "span",
                errorPlacement: function(error, element) {
                    error.addClass("text-danger");
                    element.closest(".form-floating").append(error);
                },
                highlight: function(element) {
                    $(element).addClass("is-invalid");
                },
                unhighlight: function(element) {
                    $(element).removeClass("is-invalid");
                },
                submitHandler: function(form) {
                    // Prevent the default form submission behavior
                    event.preventDefault();

                    // AJAX submission code
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.configuration-settings.store') }}",
                        data: $(form).serialize(),
                        success: function(response) {
                            // Handle success response
                            if (response.status === 'success') {
                                showToast("Success", response.message, "success");
                                // Close the modal
                                $('#addInfo').modal('hide');
                                location.reload();
                            }
                        },
                        error: function(xhr) {
                            // Handle error response
                            console.log(xhr);
                            // Show error message
                            showToast("Error", xhr.responseJSON.message, "error");
                        }
                    });
                }
            });
            $(document).on("click", ".edit-btn", function() {
                const id = $(this).data("id");

                // Fetch data for the selected record
                $.ajax({
                    type: "GET",
                    url: `/admin/configuration-settings/${id}`, // Adjust the URL as needed
                    success: function(response) {
                        if (response.status) {
                            const data = response.data;

                            // Populate the form fields
                            $("#addInfoForm input[name='id']").val(data.id).prop("readonly", true);
                            $("#addInfoForm input[name='title']").val(data.title).prop("readonly", true);
                            $("#addInfoForm input[name='key']").val(data.key).prop("readonly",
                                true); // Disable key editing
                            $("#addInfoForm input[name='value']").val(data.value);

                            // Set modal title
                            // $("#addInfoLabel").text("Edit Configuration Setting");

                            // Show the modal
                            $('#addInfo').modal('show');
                        } else {
                            showToast("Error", response.message, "error");
                        }
                    },
                    error: function() {
                        showToast("Error", "Unable to fetch data for editing.", "error");
                    }
                });
            });
        });
    </script>
@endpush
