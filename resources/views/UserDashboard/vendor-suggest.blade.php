@extends('FrontEnd.layouts.mainapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')
    <div class="container main-container">
        <div class="row flex-lg-nowrap flex-wrap g-4">
            @include('UserDashboard.includes.leftNav')
            <div class="col right-side">
                <div class="container">
                    <div class="information-box">
                        <div class="information-box-head">
                            <div class="box-head-heading d-flex flex-wrap flex-column">
                                <span class="box-head-label theme-color">Suggest Vendor</span>
                                <p class="f-15">Suggest a vendor that does not currently exist in our database and you
                                    would like to added.</p>
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
                                    <div class="col-12">
                                        <label class="form-label">Business/Vendor Name</label>
                                        <input type="text" id="buisness_vendor_name" class="form-control"
                                            name="vendor_name" required>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-6 col-12 mb-sm-0 mb-3">
                                        <label class="form-label">Street Address</label>
                                        <input type="text" class="form-control" name="street_address">
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="form-label">Unit/Suite#</label>
                                        <input type="text" class="form-control" name="unit_suite">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-6 col-12 mb-sm-0 mb-3">
                                        <label class="form-label">City/Town</label>
                                        <input type="text" class="form-control" name="city_town">
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="form-label">Province/State</label>
                                        <input type="text" class="form-control" name="province_state">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-6 col-12 mb-sm-0 mb-3">
                                        <label class="form-label">Postal / Zip</label>
                                        <input type="text" class="form-control" name="postal_zip">
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="form-label">Business/Vendor Phone</label>
                                        <input type="text" class="form-control" name="vendor_phone">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-6 col-12 mb-sm-0 mb-3">
                                        <label class="form-label">Vendor Category</label>
                                        <input type="text" class="form-control" name="vendor_category">
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <label class="form-label">Vendor Sub-Type</label>
                                        <input type="text" class="form-control" name="vendor_sub_type">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-6 col-12 mb-sm-0 mb-3">
                                        <label class="form-label">Establishment/Facility</label>
                                        <input type="text" class="form-control" name="establishment_facility">
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
            </div>
        </div>
    </div>
@endsection
