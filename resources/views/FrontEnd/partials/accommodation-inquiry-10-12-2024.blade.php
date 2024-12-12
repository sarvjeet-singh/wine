<div class="modal fade enquiry-modal" id="enquiryModal" tabindex="-1" aria-labelledby="enquiryModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header flex-column text-center position-relative border-0">
                <h2 class="modal-title fs-4 text-uppercase theme-color" id="enquiryModal">Accommodation Inquiry</h2>
                <p class="mb-0">To initiate an inquiry please complete and submit this form. An Experience Curator
                    will follow up shortly.</p>
                <button type="button" class="btn-close p-2" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div id="successMessage" style="display:none">
                </div>
                <form class="container" id="accommodationFrom" method="post" enctype="multipart/form-data"
                    action="{{ route('accommodation.inquiry') }}">
                    @csrf
                    <input type="hidden" name="vendor_id" id="inquiryvendorid" value="">
                    <div class="row mb-3">
                        <div class="col-lg-6 mb-lg-0 mb-3">
                            <div class="form-group">
                                <label class="mb-1">What is your tentative arrival/check-in date?</label>
                                <input id="datepicker" class="form-control" name="check_in_date" type="date" required
                                    min="2024-06-25">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="mb-1">What is your tentative departure/check-out date?</label>
                                <input id="datepicker2" class="form-control" name="check_out_date" type="date"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6 mb-lg-0 mb-3">
                            <div class="form-group">
                                <label class="mb-1">What is the nature of your visit?</label>
                                <ul class="list-unstyled mb-0">
                                    @foreach (['Business', 'Pleasure'] as $key => $visit_nature)
                                        <li>
                                            <input type="checkbox" name="visit_nature[]"
                                                id="visit_nature{{ $key }}" value="{{ $visit_nature }}"> <label
                                                for="visit_nature{{ $key }}">
                                                {{ $visit_nature }}</label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="mb-1">How many guests are in your travel party?</label>
                                <input type="number" class="form-control" name="number_of_guests" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="wineries_activity_sec check-list">
                                <label class="mb-1">What is your preferred accommodation type?</label>
                                <ul class="list-unstyled mb-0">
                                    @if (count(getSubCategories(1)) > 0)
                                        @foreach (getSubCategories(1) as $key => $subCategory)
                                            <li>
                                                <input type="checkbox" name="accommodation_type[]"
                                                    id="accommodation_type{{ $key }}"
                                                    value="{{ $subCategory->name }}"><label
                                                    for="accommodation_type{{ $key }}">{{ $subCategory->name }}</label>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="mb-1">In what city/town would you prefer to be accommodated?</label>
                                <select class="form-control" name="city" required>
                                    <option value="">--Select--</option>
                                    @if (count($cities) > 0)
                                        @foreach ($cities as $city)
                                            <option value="{{ $city }}">{{ $city }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="mb-1">Please indicate the number of rooms/beds required.</label>
                                <input type="number" class="form-control" name="rooms_or_beds" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="mb-1">Additional Comments:</label>
                                <textarea name="additional_comments" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="col-md-12 text-center formbtn">
                                <button type="submit" id="accommodationInqBtn">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"
    integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        // Initialize jQuery Validation
        $("#accommodationFrom").validate({
            rules: {
                check_in_date: {
                    required: true,
                    date: true,
                },
                check_out_date: {
                    required: true,
                    date: true,
                },
                "visit_nature[]": {
                    required: true,
                },
                number_of_guests: {
                    required: true,
                    digits: true,
                },
                "accommodation_type[]": {
                    required: true,
                },
                city: {
                    required: true,
                },
                rooms_or_beds: {
                    required: true,
                    digits: true,
                },
                additional_comments: {
                    maxlength: 500,
                },
            },
            messages: {
                check_in_date: "Please select a valid check-in date.",
                check_out_date: "Please select a valid check-out date.",
                "visit_nature[]": "Please select at least one nature of visit.",
                number_of_guests: "Please enter the number of guests.",
                "accommodation_type[]": "Please select at least one accommodation type.",
                city: "Please select a city.",
                rooms_or_beds: "Please enter the number of rooms or beds required.",
                additional_comments: "Comments must not exceed 500 characters.",
            },
            errorClass: "text-danger", // Add error class styling
            errorPlacement: function(error, element) {
                if (element.attr("name") === "visit_nature[]" || element.attr("name") ===
                    "accommodation_type[]") {
                    // Place error below the checkbox group label
                    element.closest(".form-group").append(error);
                } else {
                    // Default error placement
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                // Form is valid, handle AJAX
                let formData = $(form).serialize();

                $("#accommodationInqBtn").prop("disabled", true).text("Submitting...");

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    success: function(response) {
                        // Handle success
                        $("#successMessage").html(
                            '<div class="alert alert-success">Inquiry Submit Successfully. </div>'
                            );
                        $("#successMessage").show();
                        setTimeout(() => {
                            $("#successMessage").hide();
                        }, 5000);
                        $("#accommodationFrom")[0].reset();
                        $("#accommodationInqBtn").prop("disabled",
                            false).text(
                            "Submit");
                    },
                    error: function(xhr) {
                        // Handle error
                        alert("An error occurred. Please try again.");
                        $("#accommodationInqBtn").prop("disabled", false).text(
                            "Submit");
                    },
                });
            },
        });
    });
</script>
