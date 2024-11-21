<div class="modal-header px-4">
    <h2 class="modal-title fw-bold fs-5" id="createSectionLabel">Add Questions</h2>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body p-4">
    <form id="FaqFormAdd" action="">
        <div id="message"></div>
        <div id="faqFieldsContainer">
            @if (count($questions) > 0)
                @foreach ($questions as $question)
                    <div class="faq-field mb-3">
                        <div class="mb-1">
                            <label for="question" class="form-label fw-bold">Question</label> <button type="button" class="btn btn-danger btn-sm delete-question" data-id="{{ $question->id }}" data-section-id="{{ $section_id }}"><i class="fa-solid fa-trash-can"></i></button>
                            <input type="hidden" name="question_id[]" value="{{ $question['id'] }}">
                            <input type="text" class="form-control" name="question[]" value="{{ $question['question'] }}">
                        </div>
                        <div>
                            <label for="answer" class="form-label fw-bold">Answer</label>
                            <textarea class="form-control" name="answer[]">{{ $question['answer'] }}</textarea>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="faq-field mb-3">
                    <div class="mb-1">
                        <label for="question" class="form-label fw-bold">Question</label>
                        <input type="text" class="form-control" name="question[]">
                    </div>
                    <div>
                        <label for="answer" class="form-label fw-bold">Answer</label>
                        <textarea class="form-control" name="answer[]"></textarea>
                    </div>
                </div>
            @endif
        </div>
        <div class="text-end my-3">
            <button type="button" class="btn btn-secondary" id="addMoreBtn">Add More</button>
        </div>
        <div class="text-center my-3">
            <button type="submit" class="btn theme-btn px-4">Save</button>
        </div>
    </form>
</div>
<script>
    document.getElementById('addMoreBtn').addEventListener('click', function() {
        const faqFieldsContainer = document.getElementById('faqFieldsContainer');

        const newFaqField = document.createElement('div');
        newFaqField.className = 'faq-field mb-3';
        newFaqField.innerHTML = `
            <div class="mb-1">
                <label for="question" class="form-label fw-bold">Question</label>
                <input type="text" class="form-control" name="question[]">
            </div>
            <div>
                <label for="answer" class="form-label fw-bold">Answer</label>
                <textarea class="form-control" name="answer[]"></textarea>
            </div>
        `;

        faqFieldsContainer.appendChild(newFaqField);
    });
    $(document).ready(function() {
        $('#FaqFormAdd').validate({
            rules: {
                section_name: {
                    required: true,
                    minlength: 3,
                    // Use the remote method to check for duplicate section_name and vendor_type
                    remote: {
                        url: '{{ route('admin.faqs.check-duplicate') }}', // Route for checking duplicates
                        type: 'POST',
                        data: {
                            // Send section_name and vendor_type for duplicate check
                            section_name: function() {
                                return $('#questions[]').val();
                            },
                            account_type: function() {
                                return $('#answers[]').val();
                            },
                            _token: '{{ csrf_token() }}' // Include CSRF token
                        },
                        dataFilter: function(response) {
                            var json = JSON.parse(response);
                            if (json.is_unique) {
                                return true; // No duplicate found
                            } else {
                                return false; // Duplicate exists
                            }
                        }
                    }
                },
            },
            messages: {
                section_name: {
                    remote: "Question name already exists for this section."
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
                $('#message').html();
                let formData = new FormData(form);
                console.log(formData);
                $.ajax({
                    url: '{{ route('admin.faqs.store-question', $section_id) }}',
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
                        // Handle validation errors
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = '<div class="alert alert-danger"><ul>';
                            $.each(errors, function(key, messages) {
                                $.each(messages, function(index, message) {
                                    errorMessage += '<li>' + message +
                                        '</li>';
                                });
                            });
                            errorMessage += '</ul></div>';
                            $('#message').html(
                                errorMessage); // Display errors in the #message div
                        }
                    }
                });
            }
        });
    });
</script>
