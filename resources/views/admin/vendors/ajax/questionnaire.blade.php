<div class="tab-pane fade show active" id="tab-pane-setting" role="tabpanel" aria-labelledby="tab-pane-setting"
    tabindex="0">
    <!-- Questionnaire -->
    <div class="information-box mb-3">
        <div class="info-head p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text-white">Questionnaire</div>
            </div>
        </div>
        <div class="m-3 pb-3">
            <div class="row g-4">
                <form id="questionnaireForm"
                    action="{{ route('admin.vendor.details.ajax-questionnaire-update', $vendor->id) }}" method="POST">
                    <div class="row g-4">
                        @if (session('questionnaire-success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('questionnaire-success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @csrf
                        @foreach ($questionnaires as $key => $questionnaire)
                            <div class="row mt-5">
                                <div class="col-12">

                                    <label class="form-label">{{ $key + 1 }}.
                                        {{ $questionnaire->question }}</label>

                                    @php
                                        $vendorQuestionnaire = $questionnaire->vendorQuestionnaires->firstWhere(
                                            'vendor_id',
                                            $vendor->id,
                                        );
                                        $answers = $vendorQuestionnaire
                                            ? json_decode($vendorQuestionnaire->answer, true)
                                            : [];
                                        $options = json_decode($questionnaire->options, true);
                                    @endphp

                                    @if ($questionnaire->question_type === 'radio')
                                        <!-- Single choice (Radio buttons) -->
                                        <div class="row g-3 mt-3">
                                            @foreach ($options as $key => $option)
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="answer[{{ $questionnaire->id }}]"
                                                            id="question_{{ $questionnaire->id }}_{{ $key }}"
                                                            value="{{ $key }}"
                                                            {{ old('answer.' . $questionnaire->id, $vendorQuestionnaire->answer ?? '') == $key ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="question_{{ $questionnaire->id }}_{{ $key }}">
                                                            {!! $option !!}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif($questionnaire->question_type === 'checkbox')
                                        <!-- Multiple choice (Checkboxes) -->
                                        @foreach ($options as $key => $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="answer[{{ $questionnaire->id }}][]"
                                                    id="question_{{ $questionnaire->id }}_{{ $key }}"
                                                    value="{{ $option }}"
                                                    {{ in_array($option, $answers) ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="question_{{ $questionnaire->id }}_{{ $key }}">
                                                    {!! $option !!}
                                                </label>
                                            </div>
                                        @endforeach
                                    @else
                                        <!-- Default: Text input -->
                                        <div class="form-floating">
                                            <textarea class="form-control @error('answer.' . $questionnaire->id) is-invalid @enderror"
                                                name="answer[{{ $questionnaire->id }}]" placeholder="Answer">{{ old('answer.' . $questionnaire->id, $vendorQuestionnaire->answer ?? '') }}</textarea>
                                            <label for="question_{{ $questionnaire->id }}">Answer</label>
                                        </div>
                                    @endif

                                    @error('answer.' . $questionnaire->id)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        @error('answer')
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="alert alert-danger">{{ $message }}</div>
                                </div>
                            </div>
                        @enderror

                        <div class="row mt-5">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn theme-btn px-5">Save</button>
                            </div>
                        </div>
                        {{-- </form> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#questionnaireForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'), // Form action URL
                method: $(this).attr('method'), // Form method (POST)
                data: $(this).serialize(), // Form data
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK',
                        }).then(() => {
                            // Optional: Redirect or perform other actions after success
                            // window.location.reload(); // Reload the page
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = Object.values(errors)
                            .map((errorArray) => errorArray.join(', '))
                            .join('<br>');

                        Swal.fire({
                            title: 'Validation Errors',
                            html: errorMessages, // Use HTML to allow line breaks
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'An error occurred. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                        });
                    }
                },
            });
        });
    });
</script>
