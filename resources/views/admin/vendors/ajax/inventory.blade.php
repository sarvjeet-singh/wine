<div class="tab-pane fade show active" id="tab-pane-inventory-management" role="tabpanel" aria-labelledby="tab-inventory-management"
    tabindex="0">
    <div class="information-box mb-5">
        <div class="info-head p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text-white">Inventory Manage</div>
            </div>
        </div>
        <div class="m-3">
            <form name="frmain" id="dateform" action="" method="POST">
                <input type="hidden" name="vendor_id" value="1">
                <input type="hidden" name="start_date" value="" id="firstdate">
                <input type="hidden" name="end_date" value="" id="seconddate">
                <input type="hidden" name="type" value="vendor">
                <div class="row mt-3">
                    <div class="col-sm-4 col-12">
                        <div class="form-floating">
                            <select class="form-control" name="booking_date_option" id="floatingSelect">
                                <option value="booked">Booked Dates</option>
                                <option value="packaged">Package Dates</option>
                                <option value="blocked">Blocked Dates</option>
                            </select>
                            <label for="floatingSelect">Apply Value</label>
                        </div>
                    </div>
                    <div class="col-sm-4 col-12">
                        <div class="form-floating">
                            <select class="form-control season-clender" id="seasonSelect">
                                <option value="">Option 1</option>
                                <option value="">Option 2</option>
                            </select>
                            <label for="floatingSelect">Select Season</label>
                        </div>
                    </div>
                    <div class="col-sm-4 col-12 text-end">
                        <br>
                        <button type="button" class="btn theme-btn manage_dates px-5 rounded-5" data-bs-toggle="modal"
                            data-bs-target="#MangeDatesPopUp">Manage
                            Dates</button>
                    </div>
                </div>

                <!-- <div class="row datefilter_input position-relative mt-3">
                                            <div class="col-xl-12 col-lg-12 col-sm-12 col-md-12" id="datepicker-container">
                                            <input type="text" name="datefilter" value="" placeholder="Select the Dates"
                                            id="datefilter_input" readonly />
                                            </div>
                                            <div class="batch-sec">
                                            <img class="publish-season summer" src="{{ asset('images/summer-published-batch.png') }}"alt="Summer Published">
                                            </div>
                                            </div> -->

                <div class="row mt-5">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn theme-btn px-5 mx-1" id="dateform_submit"
                            disabled>Update</button>
                        <button type="button" id="publish_dates" class="btn theme-btn px-5 mx-1">Publish
                            Sesson</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
