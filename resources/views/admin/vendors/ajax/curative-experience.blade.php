<div class="tab-pane fade show active" id="tab-pane-curated-exp" role="tabpanel" aria-labelledby="tab-curated-exp"
    tabindex="0">
    <div class="information-box mb-3">
        <div class="info-head p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text-white">Curated Experience</div>
            </div>
        </div>
        <div class="m-3 pb-3">
            <div class="row g-4">
                <form id="experienceForm" action="{{ route('admin.vendor.details.ajax-experience-update', $vendor->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">
                    @for ($i = 0; $i < 3; $i++)
                        @if (isset($experiences[$i]->id))
                            <input type="hidden" name="experience[{{ $i }}][id]"
                                value="{{ $experiences[$i]->id }}">
                        @endif
                        <div class="row mt-3">
                            <div class="col-sm-4 col-12">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control @error('experience.' . $i . '.title') is-invalid @enderror"
                                        value="{{ old('experience.' . $i . '.title', $experiences[$i]->title ?? '') }}"
                                        name="experience[{{ $i }}][title]"
                                        placeholder="Enter Experience name">
                                    <label for="exp_name">Experience {{ $i + 1 }}</label>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12">
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control currency-field @error('experience.' . $i . '.upgradefee') is-invalid @enderror"
                                            value="{{ old('experience.' . $i . '.upgradefee', $experiences[$i]->upgradefee ?? '') }}"
                                            name="experience[{{ $i }}][upgradefee]"
                                            placeholder="Enter Upgrade fee">
                                        <label for="u-fee">Upgrade Fee</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12">
                                <div class="form-floating">
                                    <select name="experience[{{ $i }}][currenttype]"
                                        class="form-control form-select @error('experience.' . $i . '.currenttype') is-invalid @enderror"
                                        placeholder="Select an option">
                                        <option value="+"
                                            {{ old('experience.' . $i . '.currenttype', $experiences[$i]->currenttype ?? '') == '+' ? 'selected' : '' }}>
                                            +</option>
                                        <option value="/Hr"
                                            {{ old('experience.' . $i . '.currenttype', $experiences[$i]->currenttype ?? '') == '/Hr' ? 'selected' : '' }}>
                                            /Hr</option>
                                        <option value="/Person"
                                            {{ old('experience.' . $i . '.currenttype', $experiences[$i]->currenttype ?? '') == '/Person' ? 'selected' : '' }}>
                                            /Person</option>
                                        <option value="/Night"
                                            {{ old('experience.' . $i . '.currenttype', $experiences[$i]->currenttype ?? '') == '/Night' ? 'selected' : '' }}>
                                            /Night</option>
                                        <option value="/Session"
                                            {{ old('experience.' . $i . '.currenttype', $experiences[$i]->currenttype ?? '') == '/Session' ? 'selected' : '' }}>
                                            /Session</option>
                                    </select>
                                    <label for="experience">Extension</label>
                                </div>

                            </div>
                            <div class="col-12 mt-3">
                                <div class="form-floating">
                                    <textarea class="form-control @error('experience.' . $i . '.description') is-invalid @enderror"
                                        name="experience[{{ $i }}][description]" rows="3" id="description"
                                        placeholder="Please enter Description">{{ old('experience.' . $i . '.description', $experiences[$i]->description ?? '') }}</textarea>
                                    <label for="floatingTextarea">Description ( Maximum character allowed 250 )</label>
                                </div>
                            </div>
                        </div>
                    @endfor
                    <div class="row mt-5">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn theme-btn px-5">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var currencyFields = document.querySelectorAll('.currency-field');
        currencyFields.forEach(function(currencyField) {
            currencyField.addEventListener('input', function(e) {
                var value = e.target.value;
                var regex = /^\d+(\.\d{0,2})?$/;
                if (!regex.test(value)) {
                    e.target.value = value.slice(0, -1);
                }
            });
        });
    });
    $(document).ready(function() {
        $('#experienceForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'), // URL from the form action
                method: $(this).attr('method'), // Method from the form method
                data: $(this).serialize(), // Serialize the form data
                success: function(response) {
                    if (response.success) {
                        showToast("Success", response.message, "success");
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Validation errors
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = Object.values(errors).map(errorArray =>
                            errorArray.join(', ')
                        );

                        showToast("Error", errorMessages.join('<br>'), "error");
                    } else {
                        // Other errors
                        showToast("Error", "An error occurred while updating experiences.", "error");
                    }
                },
            });
        });
    });
</script>
