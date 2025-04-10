@extends('FrontEnd.layouts.mainapp')



@section('content')
    <div class="container my-5">
        <div>
            <h5 class="text-center mb-4">The Wine Country Weekends marketing team sources and presents all the best
                experiences Niagara region has to offer.  Our newly updated, single source platform is being positioned as
                the hub for local travel, enhancing exposure and driving sales for all its registered vendors.</h5>
        </div>
        <div class="information-box">
            <div class="information-box-head">
                <div class="box-head-heading d-flex flex-wrap flex-column">
                    <span class="box-head-label theme-color">Promote a Business</span>
                    {{-- <p class="f-15">Suggest a vendor that does not currently exist in our database and you would like to submit a review for</p> --}}
                </div>
            </div>
            <div class="information-box-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('vendor_suggest') }}" method="POST">
                    @csrf
                    <div class="row mt-3">
                        <div class="col-sm-6 col-12">
                            <label class="form-label">User Full Name</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->firstname ?? '' }} {{ Auth::user()->lastname ?? '' }}" name="full_name" id="full_name" required>
                        </div>
                        <div class="col-sm-6 col-12">
                            <label class="form-label">City/Town</label>
                            <input type="text" id="user_city_town" value="{{ Auth::user()->city ?? '' }}" class="form-control" name="user_city">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-6 col-12">
                            <label class="form-label">Province/State</label>
                            <input type="text" id="user_province_state" value="{{ Auth::user()->state ?? '' }}" class="form-control" name="user_state">
                        </div>
                        <div class="col-sm-6 col-12">
                            <label class="form-label">User eMail</label>
                            <input type="email" value="{{ Auth::user()->email ?? '' }}" class="form-control" name="user_email" id="user_email" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-6 col-12">
                            <label class="form-label">User Phone</label>
                            <input type="text" value="{{ Auth::user()->contact_number ?? '' }}" class="form-control" name="user_phone" id="user_phone">
                        </div>
                        <div class="col-sm-6 col-12">
                            <label class="form-label">Relationship</label>
                            <select name="relationship" class="form-control" id="relationship">
                                <option value="">Select Relationship</option>
                                <option value="Staff">Staff</option>
                                <option value="Management">Management</option>
                                <option value="Patron">Patron</option>
                                <option value="Community Member">Community Member</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="fw-bold theme-color">Business/Vendor Details</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Business/Vendor Name</label>
                            <input type="text" id="vendor_name" class="form-control" name="vendor_name"
                                required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-6 col-12">
                            <label class="form-label">Street Address</label>
                            <input type="text" class="form-control" name="street_address" id="street_address">
                        </div>
                        <div class="col-sm-6 col-12">
                            <label class="form-label">Unit/Suite#</label>
                            <input type="text" class="form-control" name="unit_suite" id="unit_suite">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-6 col-12">
                            <label class="form-label">City/Town</label>
                            <input type="text" class="form-control" name="city_town" id="city_town">
                        </div>
                        <div class="col-sm-6 col-12">
                            <label class="form-label">Province/State</label>
                            <input type="text" class="form-control" name="province_state" id="province_state">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-6 col-12">
                            <label class="form-label">Postal / Zip</label>
                            <input type="text" class="form-control" name="postal_zip" id="postal_zip">
                        </div>
                        <div class="col-sm-6 col-12">
                            <label class="form-label">Country</label>
                            <input type="text" class="form-control" name="country" id="country">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-6 col-12">
                            <label class="form-label">Business/Vendor Phone</label>
                            <input type="text" class="form-control" name="vendor_phone" id="vendor_phone">
                        </div>
                        <div class="col-sm-6 col-12">
                            <label class="form-label">Vendor Category</label>
                            <select name="vendor_category" class="form-control" id="vendor_category">
                                <option value="">Select Category</option>
                                @foreach (getCategories() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-6 col-12">
                            <label class="form-label">Vendor Sub-Type</label>
                            <select name="vendor_sub_category" class="form-control" id="vendor_sub_category">
                                <option value="">Select Sub Category</option>
                            </select>
                        </div>
                        <div class="col-sm-6 col-12" id="establishment_container" style="display: none;">
                            <label class="form-label">Establishment/Facility</label>
                            <select name="establishment_facility" class="form-control" id="establishment_facility">
                                <option value="">Select Establishment/Facility</option>
                                @foreach (getEstablishments() as $establishment)
                                    <option value="{{ $establishment->id }}">{{ $establishment->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn wine-btn">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#vendor_category').on('change', function() {
                let categoryId = $(this).val();
                let subcategoryDropdown = $('#vendor_sub_category');

                if(categoryId == 2) {
                    $("#establishment_container").show();
                } else {
                    $("#establishment_container").hide();
                }

                // Clear existing options
                subcategoryDropdown.empty().append('<option value="">Select Sub Category</option>');

                if (categoryId) {
                    $.ajax({
                        url: "{{ route('getSubcategories', '') }}/" + categoryId,
                        type: "GET",
                        success: function(response) {
                            if (response.length > 0) {
                                response.forEach(function(subcategory) {
                                    subcategoryDropdown.append(
                                        `<option value="${subcategory.id}">${subcategory.name}</option>`
                                    );
                                });
                            }
                        },
                        error: function(xhr) {
                            console.error("Error fetching subcategories:", xhr);
                        }
                    });
                }
            });
        });
    </script>
@endsection
