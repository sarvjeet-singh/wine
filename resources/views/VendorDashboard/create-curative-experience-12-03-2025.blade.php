@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Vendor Dashboard')

@section('content')

<style>
label{
    font-weight: 400;
}
.form-control:focus {
    box-shadow: unset;
    border-color: #408a95;
}
</style>

    <div class="col right-side">
        <div class="row">
            <div class="col-sm-12">
                <div class="information-box">
                    <div class="information-box-head">
                        <div class="box-head-heading d-flex align-items-center justify-content-between gap-2">
                            <span class="box-head-label theme-color">Curated Experience</span>
                            <a href="#" class="btn wine-btn px-4">Create</a>
                        </div>
                    </div>
                    <div class="information-box-body py-4">
                        <div class="row g-3">
                            <div class="col-sm-4 col-12">
                                <div class="form-floating">
                                    <select class="form-control form-select season-clender" id="seasonSelect">
                                        <option value="">Concert</option>
                                        <option value="">Show/Live Performance</option>
                                        <option value="">Private Function</option>
                                        <option value="">Special Event</option>
                                        <option value="">Market</option>
                                        <option value="">Festival/Celebration</option>
                                    </select>
                                    <label class="form-label">Experience Type</label>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="floatingInput" placeholder="Experience Name">
                                  <label for="floatingInput">Experience Name</label>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12">
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <div class="form-floating">
                                        <input type="text" class="form-control currency-field " value="" name="experience[0][upgradefee]" placeholder="Enter Upgrade fee">
                                        <label for="floatingInputGroup1">Upgrade Fee</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12">
                                <div class="form-floating">
                                <select name="experience[0][currenttype]" class="form-control " placeholder="Select an option">
                                    <option value="+">+</option>
                                    <option value="/Hr">/Hr</option>
                                    <option value="/Person" selected="">/Person</option>
                                    <option value="/Night">/Night</option>
                                    <option value="/Session">/Session</option>
                                </select>
                                <label for="floatingSelectGrid">Extension</label>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="floatingInput" placeholder="URL (Booking Platform)">
                                  <label for="floatingInput">URL (Booking Platform)</label>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="floatingInput" placeholder="Quantity">
                                  <label for="floatingInput">Quantity</label>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12">
                                <div class="form-floating">
                                  <input type="date" class="form-control" id="floatingInput" placeholder="Date">
                                  <label for="floatingInput">Date</label>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12">
                                <div class="form-floating">
                                  <input type="time" class="form-control" id="floatingInput" placeholder="Start Time">
                                  <label for="floatingInput">Start Time</label>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12">
                                <div class="form-floating">
                                  <input type="time" class="form-control" id="floatingInput" placeholder="End Time">
                                  <label for="floatingInput">End Time</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                  <textarea class="form-control" placeholder="Desription" id="floatingTextarea2" style="height: 100px"></textarea>
                                    <label for="floatingTextarea2">Desription</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="profile-img-sec">
                                    <label for="profileImage" class="position-relative">
                                        <img id="profilePreview" src="/images/VendorImages/Cameo Cottage/vu8d6HrhLW.png" class="profile-img rounded-3" alt="Profile Image" style="width: 200px; height: 130px; object-fit: cover; border: 1px solid #408a95;">
                                        <p style="font-size: 14px;margin-top: 10px;color: #408a95;cursor: pointer;text-align: center;"><i class="fa-solid fa-arrow-up-from-bracket"></i> Upload Media</p>
                                    </label>
                                    <input type="file" id="profileImage" class="file-input" accept="image/*" style="display: none;">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn wine-btn">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection