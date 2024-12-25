<div class="tab-pane fade show active" id="tab-pane-curated-exp" role="tabpanel" aria-labelledby="tab-curated-exp" tabindex="0">
    <div class="information-box mb-3">
        <div class="info-head p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="text-white">Curated Experience</div>
            </div>
        </div>
        <div class="m-3 pb-3">
            <div class="row g-4">
                <form action="" method="post">
                    <input type="hidden" name="vendor_id" value="">
                    <input type="hidden" name="" value="">
                    <div class="row mt-3">
                        <div class="col-sm-4 col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" value="" name="exp_name"
                                    placeholder="Enter Experience name">
                                <label for="exp_name">Enter Experience name</label>
                            </div>
                            <!-- <span class="invalid-feedback" role="alert">
                                        {{-- <strong>{{ $message }}</strong> --}}
                                        </span> -->
                        </div>
                        <div class="col-sm-4 col-12">
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <div class="form-floating">
                                    <input type="text" class="form-control currency-field" value=""
                                        name="u-fee" placeholder="Enter Upgrade fee">
                                    <label for="u-fee">Enter Upgrade fee</label>
                                </div>
                            </div>
                            <!-- <span class="invalid-feedback" role="alert">
                                                                    {{-- <strong>{{ $message }}</strong> --}}
                                                                    </span> -->
                        </div>
                        <div class="col-sm-4 col-12">
                            <div class="form-floating">
                                <select name="experience" class="form-control" placeholder="Select an option">
                                    <option value="+">+</option>
                                    <option value="">/Hr</option>
                                    <option value="">/Person</option>
                                    <option value="">/Night</option>
                                    <option value="">/Session</option>
                                </select>
                                <label for="experience">Extension</label>
                            </div>
                            
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-floating">
                                <textarea class="form-control" name="floatingTextarea" rows="3" id="description"
                                    placeholder="Please enter Description"></textarea>
                                <label for="floatingTextarea">Comments</label>
                            </div>
                            <!-- <span class="invalid-feedback" role="alert">
                                                    {{-- <strong>{{ $message }}</strong> --}}
                                                    </span> -->
                        </div>
                    </div>
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
