<div class="modal-header px-4">
    <h2 class="modal-title fw-bold fs-5" id="createSectionLabel">{{!empty($section) ? 'Edit' : 'Add'}} Section</h2>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body p-4">
    <form action="" method="POST" id="FaqFormAdd">
        <div id="message"></div>
        <div class="mb-3">
            <label for="account_type" class="form-label fw-bold">Account Type</label>
            <select class="form-select" id="account_type" name="account_type" aria-label="Categories">
                <option value="">Select Account Type</option>
                <option {{(!empty($section->account_type) && $section->account_type == 'user') ? 'selected' : ''}} value="user">User</option>
                @if (count($categories) > 0)
                    @foreach ($categories as $category)
                        <option {{ (!empty($section->account_type)  && $section->account_type == $category['slug']) ? 'selected' : ''}}  value="{{ $category['slug'] }}">{{ $category['name'] }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="mb-3">
            <label for="section_name"  class="form-label fw-bold">Section Title</label>
            <input type="text" id="section_name" value="{{ old('section_name', !empty($section->section_name) ? $section->section_name : '') }}" name="section_name" class="form-control">
        </div>
        <div class="text-center my-3">
            <input type="hidden" name="id" value="{{!empty($section) ? $section->id : ''}}">
            <button type="submit" class="btn theme-btn px-5">Save</button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('#FaqFormAdd').validate({
            rules: {
                section_name: {
                    required: true,
                    minlength: 3,
                    // Use the remote method to check for duplicate section_name and vendor_type
                    remote: {
                        url: '{{ route("admin.faqs.check-duplicate") }}', // Route for checking duplicates
                        type: 'POST',
                        data: {
                            // Send section_name and vendor_type for duplicate check
                            section_name: function() {
                                return $('#section_name').val();
                            },
                            account_type: function() {
                                return $('#account_type').val();
                            },
                            _token: '{{ csrf_token() }}' // Include CSRF token
                        },
                        dataFilter: function(response) {
                            var json = JSON.parse(response);
                            if (json.is_unique) {
                                return true;  // No duplicate found
                            } else {
                                return false; // Duplicate exists
                            }
                        }
                    }
                },
                account_type: {
                    required: true
                },
            },
            messages: {
                section_name: {
                    remote: "Section name already exists for this account type."
                }
            },

            errorElement: "div", // error element as span

            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                error.insertAfter(element);
            },

            submitHandler: function(form, event) {
                event.preventDefault(); // Prevent the default form submission
                // return false;
                let formData = new FormData(form);

                $.ajax({
                    url: '{{ route('admin.faqs.store-section') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false, // Important: Prevent jQuery from processing the data
                    processData: false, // Important: Prevent jQuery from automatically converting the data to string
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token if required
                    },

                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success', // Can be 'success', 'error', 'warning', 'info', or 'question'
                                title: 'Success',
                                text: response
                                    .message, // The message you want to show
                                confirmButtonText: 'OK' // Button text
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Reload the page after the user clicks "OK"
                                    location.reload();
                                }
                            });

                            // Optionally, close modal or reset form
                            $('#FaqFormAdd')[0].reset();
                        }
                    },

                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;

                        // Remove previous error messages
                        $("#message").html(response.message);
                        
                    }
                });
            }
        });
    });
</script>
