@extends('admin.layouts.app')
@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <h2 class="mb-0">Vendor Details</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-between p-3">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="#"
                                            class="text-decoration-none text-black">User Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Listing</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <div class="vendor-detail-tab-sec p-3">
                        <!-- Tab Section Start -->
                        <ul class="nav nav-tabs border-0 light-bg" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="tab-1" data-bs-toggle="tab"
                                    data-bs-target="#tab-pane-1" type="button" role="tab" aria-controls="tab-pane-1"
                                    aria-selected="true">View</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-2" data-bs-toggle="tab" data-bs-target="#tab-pane-2"
                                    type="button" role="tab" aria-controls="tab-pane-2" aria-selected="false">Wine
                                    Listing</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-3" data-bs-toggle="tab" data-bs-target="#tab-pane-3"
                                    type="button" role="tab" aria-controls="tab-pane-3" aria-selected="false">Vendor
                                    Detail</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-4" data-bs-toggle="tab" data-bs-target="#tab-pane-4"
                                    type="button" role="tab" aria-controls="tab-pane-4" aria-selected="false">Media
                                    Gallery</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-5" data-bs-toggle="tab" data-bs-target="#tab-pane-5"
                                    type="button" role="tab" aria-controls="tab-pane-5"
                                    aria-selected="false">Transactions</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-6" data-bs-toggle="tab" data-bs-target="#tab-pane-6"
                                    type="button" role="tab" aria-controls="tab-pane-6" aria-selected="false">System
                                    Admin</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-7" data-bs-toggle="tab" data-bs-target="#tab-pane-7"
                                    type="button" role="tab" aria-controls="tab-pane-7" aria-selected="false">Inventory
                                    Management</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-8" data-bs-toggle="tab" data-bs-target="#tab-pane-8"
                                    type="button" role="tab" aria-controls="tab-pane-8"
                                    aria-selected="false">Amenties</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-9" data-bs-toggle="tab"
                                    data-bs-target="#tab-pane-9" type="button" role="tab"
                                    aria-controls="tab-pane-9" aria-selected="false">Curated Experience</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-10" data-bs-toggle="tab"
                                    data-bs-target="#tab-pane-10" type="button" role="tab"
                                    aria-controls="tab-pane-10" aria-selected="false">Booking Utility</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-11" data-bs-toggle="tab"
                                    data-bs-target="#tab-pane-11" type="button" role="tab"
                                    aria-controls="tab-pane-11" aria-selected="false">Pricing</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-12" data-bs-toggle="tab"
                                    data-bs-target="#tab-pane-12" type="button" role="tab"
                                    aria-controls="tab-pane-12" aria-selected="false">Setting</button>
                            </li>
                        </ul>

                        <!-- Tabs Content -->
                        <div class="tab-content my-4" id="myTabContent">
                            <!-- View Tab -->
                            <div class="tab-pane fade show active" id="tab-pane-1" role="tabpanel"
                                aria-labelledby="tab-1" tabindex="0">
                                <div class="information-box mb-3">
                                    <div class="info-head p-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="text-white">Accommodation</div>
                                        </div>
                                    </div>
                                    <div class="m-3 pt-3">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-md-6">
                                                <div class="mb-4">
                                                    <h4 class="fw-bold">Business Information</h4>
                                                    <p class="mb-1"><span class="fw-bold">Business/Vendor
                                                            Name:</span> A Movement In Time Bed & Breakfast</p>
                                                    <p class="mb-1"><span class="fw-bold">Street Address:</span>
                                                        5903 Prospect St</p>
                                                    <p class="mb-1"><span class="fw-bold">Sub -Region:</span>
                                                        NIAGARA FALLS</p>
                                                    <p class="mb-1"><span class="fw-bold">City Town</span> </p>
                                                </div>
                                                <div>
                                                    <h4 class="fw-bold">Vendor Contact</h4>
                                                    <p class="mb-1"><span class="fw-bold">First Name:</span> David
                                                        Andreson</p>
                                                    <p class="mb-1"><span class="fw-bold">Email Address:</span>
                                                        Gagandeep@yopmail.com</p>
                                                    <p class="mb-1"><span class="fw-bold">Title:</span> Manager</p>
                                                    <p class="mb-1"><span class="fw-bold">Phone Number:</span>
                                                        987-5896-987</p>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div>
                                                    <p class="mb-1"><span class="fw-bold">Account Status:
                                                        </span>Full Profle</p>
                                                    <p class="mb-1"><span class="fw-bold">Sub Category:
                                                        </span>Entire home</p>
                                                    <p class="mb-1"><span class="fw-bold">Provision/State: </span>OP
                                                    </p>
                                                </div>
                                                <div class="my-4">
                                                    <h4><span class="fw-bold">Price Rating:</span> $999</h4>
                                                </div>
                                                <div class="social-links">
                                                    <h6 class="mb-3">Social media </h6>
                                                    <ul class="list-unstyled d-flex align-items-center gap-3">
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa-brands fa-facebook-f"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa-brands fa-instagram"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa-brands fa-x-twitter"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <i class="fa-brands fa-youtube"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="view-tab-images d-flex align-items-center gap-3">
                                                    <img src="images/qr-code.png" class="img-fluid" />
                                                    <i class="fa-solid fa-cloud-arrow-down"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Listing of Wines Tab -->
                            <div class="tab-pane fade" id="tab-pane-2" role="tabpanel" aria-labelledby="tab-2"
                                tabindex="0">
                                <div class="information-box mb-3">
                                    <div class="info-head p-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="text-white">Listing of Wines</div>
                                        </div>
                                    </div>
                                    <div class="m-3 pb-4">
                                        <div class="row g-4">
                                            <div class="col-12">
                                                <div class="dashboard-card">
                                                    <form>
                                                        <!-- Table Start -->
                                                        <div class="table-users text-center">
                                                            <div class="table-responsive w-100">
                                                                <table class="table w-100">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="20%">S.No.</th>
                                                                            <th width="20%">Series</th>
                                                                            <th width="20%">Stocking Fee</th>
                                                                            <th width="20%">Price</th>
                                                                            <th width="20%">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>Lorem</td>
                                                                            <td>
                                                                                <div>
                                                                                    <input type="text"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </td>
                                                                            <td>$99</td>
                                                                            <td>
                                                                                <a href="#"
                                                                                    class="btn theme-btn">Update</a>
                                                                                <a href="#" class="btn theme-btn"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#exampleModal">View</a>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td>Lorem</td>
                                                                            <td>
                                                                                <div>
                                                                                    <input type="text"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </td>
                                                                            <td>$99</td>
                                                                            <td>
                                                                                <a href="#"
                                                                                    class="btn theme-btn">Update</a>
                                                                                <a href="#" class="btn theme-btn"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#exampleModal">View</a>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>3</td>
                                                                            <td>Lorem</td>
                                                                            <td>
                                                                                <div>
                                                                                    <input type="text"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </td>
                                                                            <td>$99</td>
                                                                            <td>
                                                                                <a href="#"
                                                                                    class="btn theme-btn">Update</a>
                                                                                <a href="#" class="btn theme-btn"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#exampleModal">View</a>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <!-- Table End -->
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Media Gallery -->
                            <div class="tab-pane fade" id="tab-pane-4" role="tabpanel" aria-labelledby="tab-4"
                                tabindex="0">
                                <div class="information-box mb-3">
                                    <div class="info-head p-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="text-white">Media Gallery</div>
                                        </div>
                                    </div>
                                    <div class="m-3 py-3">
                                        <div class="row g-4">
                                            <p class="m-0 pt-2 fs-7">Please upload JPG and PNG images formats</p>
                                            <div class="box-gallary-row">
                                                <div class="box-gallary-images-column select-box-gallary-images-column">
                                                    <label for="" class="custom-file-label upload-button"
                                                        data-bs-toggle="modal" data-bs-target="#editMediaModal">
                                                        <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                                    </label>
                                                </div>
                                                <div class="box-gallary-images-column position-relative">
                                                    <a href="#" class="dlt-icon vendor-media-delete">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                    <img src="images/wine-img.jpg" class="box-gallary-7-images rounded-4">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Amenties Tab -->
                            <div class="tab-pane fade" id="tab-pane-8" role="tabpanel" aria-labelledby="tab-8"
                                tabindex="0">
                                <!-- Table Start -->
                                <div class="table-users amenties-table text-center">
                                    <div class="table-responsive w-100">
                                        <table class="table w-100">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Name of Amenities</th>
                                                    <th>Type</th>
                                                    <th>Activate</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <div
                                                            class="amenties-name d-flex align-items-center gap-1 text-start">
                                                            <i class="fa-solid fa-kitchen-set"></i>
                                                            Cookware
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- <button type="button" class="btn status-btn active-btn">Premium</button> -->
                                                        <button type="button"
                                                            class="btn status-btn inactive-btn">Basic</button>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-switch d-flex justify-content-center">
                                                            <input class="form-check-input amenities-save" data-id=""
                                                                type="checkbox" role="switch">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>
                                                        <div
                                                            class="amenties-name d-flex align-items-center gap-1 text-start">
                                                            <i class="fa-solid fa-kitchen-set"></i>
                                                            Cookware
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- <button type="button" class="btn status-btn active-btn">Premium</button> -->
                                                        <button type="button"
                                                            class="btn status-btn inactive-btn">Basic</button>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-switch d-flex justify-content-center">
                                                            <input class="form-check-input amenities-save" data-id=""
                                                                type="checkbox" role="switch">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>
                                                        <div
                                                            class="amenties-name d-flex align-items-center gap-1 text-start">
                                                            <i class="fa-solid fa-kitchen-set"></i>
                                                            Cookware
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- <button type="button" class="btn status-btn active-btn">Premium</button> -->
                                                        <button type="button"
                                                            class="btn status-btn inactive-btn">Basic</button>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-switch d-flex justify-content-center">
                                                            <input class="form-check-input amenities-save" data-id=""
                                                                type="checkbox" role="switch">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Table End -->
                            </div>

                            <!-- Curated Experience Tab -->
                            <div class="tab-pane fade" id="tab-pane-9" role="tabpanel" aria-labelledby="tab-9"
                                tabindex="0">
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
                                                        <label class="form-label">Experience 1</label>
                                                        <input type="text" class="form-control" value=""
                                                            name="" placeholder="Enter Experience name">

                                                    </div>
                                                    <div class="col-sm-4 col-12">
                                                        <label class="form-label">Upgrade Fee</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input type="text" class="form-control currency-field"
                                                                value="" name=""
                                                                placeholder="Enter Upgrade fee">
                                                        </div>

                                                    </div>
                                                    <div class="col-sm-4 col-12">
                                                        <label class="form-label">Extension</label>
                                                        <select name="experience[0][currenttype]" class="form-control"
                                                            placeholder="Select an option">
                                                            <option value="+">+</option>
                                                            <option value="">/Hr</option>
                                                            <option value="">/Person</option>
                                                            <option value="">/Night</option>
                                                            <option value="">/Session</option>
                                                        </select>


                                                    </div>
                                                    <div class="col-12 mt-3">
                                                        <label class="form-label">Description <span class="theme-color">(
                                                                Maximum character allowed 250
                                                                )</span></label>
                                                        <textarea class="form-control" name="" rows="3" id="description"
                                                            placeholder="Please enter Description"></textarea>

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
                        </div>
                        <!-- /Tabs Content -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header px-4">
                    <h1 class="modal-title fw-bold fs-5" id="exampleModalLabel">Add Wine</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form class="row g-3" id="vendorWineFormAdd" enctype="multipart/form-data" method="POST">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="image" class="form-label">Image</label>
                                    <input class="form-control" type="file" name="image" id="image"
                                        accept="image/*">
                                </div>
                                <div class="col-md-6 img-box d-flex flex-column align-items-center">
                                    <img id="imagePreview" src="" alt="Image Preview"
                                        style="display:none; max-width:100%;height:auto;max-height:200px;" />
                                    <button type="button" id="removeImage" style="display:none;"
                                        class="btn btn-danger mt-2"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="form-label">Business / Vendor Name</label>
                            <input type="text" name="" id="" value="Between the Lines Winery"
                                readonly class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="" class="form-label">Region</label>
                            <select class="form-select" id="region" name="region" required>
                                <option value="">Select Region</option>
                                <option value="niagara" selected>Niagara</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="" class="form-label">Sub-Region</label>
                            <select class="form-select" id="sub_region" name="sub_region">
                                <option value="">Select Region</option>
                                <option value="Niagara Falls">Niagara Falls</option>
                                <option value="Niagara-on-the-Lake">Niagara-on-the-Lake</option>
                                <option value="Niagara Escarpment">Niagara Escarpment</option>
                                <option value="South Escarpment">South Escarpment</option>
                                <option value="Fort Erie">Fort Erie</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="" class="form-label">Series</label>
                                    <input type="text" name="series" class="form-control" id="Series">
                                </div>
                                <div class="col-md-8">
                                    <div id="dynamic-fields-container">
                                        <div class="dynamic-field">
                                            <div class="d-flex align-items-between gap-2">
                                                <div class="w-75" style="width: 61.5% !important">
                                                    <label for="varietal_blend" class="form-label">Varietal/Blend</label>
                                                </div>
                                                <div class="w-75">
                                                    <label for="varietal_type" class="form-label">Grape Varietals</label>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">

                                                <div class="w-75">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control percent"
                                                            name="varietal_blend[]" placeholder="Varietal/Blend">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>
                                                <div class="w-75">
                                                    <select class="form-select" name="varietal_type[]">
                                                        <option value="">Select</option>
                                                        <option value="1">Cabernet Franc</option>
                                                        <option value="2">Cabernet Sauvignon</option>
                                                        <option value="3">Chardonnay</option>
                                                        <option value="4">Gamay Noir</option>
                                                        <option value="5">Gewürztraminer</option>
                                                        <option value="6">Merlot</option>
                                                        <option value="7">Pinot Noir</option>
                                                        <option value="8">Riesling</option>
                                                    </select>
                                                </div>
                                                <button type="button" class="btn btn-outline-success add-field"><i
                                                        class="fa-solid fa-circle-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 cellaring-value-sec">

                            <label for="" class="form-label">Cellaring Value</label>

                            <div class="row g-2">
                                <div class="col-lg-4 col-sm-6">
                                    <div
                                        class="form-check cellaring-value-1 d-flex align-items-center gap-2 position-relative">
                                        <input class="form-check-input" type="radio" name="cellar" id="cellar1"
                                            value="Drink Now" {{ old('cellar') == 'Drink Now' ? 'checked' : '' }}>
                                        <label class="form-check-label d-flex align-items-center gap-2" for="cellar1">
                                            <img src="images/wine-drink.png" class="img-fluid" alt="Wine Image">
                                            <p class="mb-0">Drink Now</p>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div
                                        class="form-check cellaring-value-2 d-flex align-items-center gap-2 position-relative">
                                        <input class="form-check-input" type="radio" name="cellar" id="cellar2"
                                            value="Drink or Cellar"
                                            {{ old('cellar') == 'Drink or Cellar' ? 'checked' : '' }}>
                                        <label class="form-check-label d-flex align-items-center gap-2" for="cellar2">
                                            <img src="images/wine-drink.png" class="img-fluid" alt="Wine Image">
                                            <p class="mb-0">Drink or Hold</p>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div
                                        class="form-check cellaring-value-3 d-flex align-items-center gap-2 position-relative">
                                        <input class="form-check-input" type="radio" name="cellar" id="cellar3"
                                            value="Cellar" {{ old('cellar') == 'Cellar' ? 'checked' : '' }}>
                                        <label class="form-check-label d-flex align-items-center gap-2" for="cellar3">
                                            <img src="images/wine-drink.png" class="img-fluid" alt="Wine Image">
                                            <p class="mb-0">Cellar</p>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <label for="" class="form-label">Vintage Date</label>
                            <select class="form-select" id="vintage_date" name="vintage_date">
                                <option value="2000">2000</option>
                                <option value="2001">2001</option>
                                <option value="2002">2002</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="" class="form-label">Bottle Size</label>
                            <select class="form-select" id="bottle_size" name="bottle_size">
                                <option value="">Select Bottle Size</option>
                                <option value="375 ml">375 ml (Demie)</option>
                                <option value="750 ml">750 ml (Standard)</option>
                                <option value="1.5 L">1.5 L (Magnum)</option>
                                <option value="3 L">3 L (Dbl Magnum)</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="" class="form-label">Alcohol By Volume</label>
                            <div class="input-group">
                                <input type="text" class="form-control percent" name="abv" id="abv">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="" class="form-label">Residual Sugars</label>
                            <div class="row g-2">
                                <div class="col-lg-4 col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rs" id="rs1"
                                            value="0-1" {{ old('rs') == '0-1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rs1">
                                            0 - 1 g/l (Bone Dry)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rs" id="rs2"
                                            value="1-9" {{ old('rs') == '1-9' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rs2">
                                            1 - 9 g/l (Dry)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rs" id="rs3"
                                            value="10-49" {{ old('rs') == '10-49' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rs3">
                                            10 - 49 g/l (Off Dry)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rs" id="rs4"
                                            value="50-120" {{ old('rs') == '50-120' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rs4">
                                            50 - 120 g/l (Semi-Sweet)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rs" id="rs5"
                                            value="120+" {{ old('rs') == '120+' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rs5">
                                            120+ g/l (Sweet)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- <label for="" class="form-label">Inventory</label> -->
                            <div class="d-flex align-items-center gap-2">
                                <div>
                                    <label for="" class="form-label">Case</label>
                                    <input type="number" class="form-control w-100" id="casesInput" min="0"
                                        placeholder="Enter cases" style="width: 50%;">
                                </div>
                                <div>
                                    <label for="" class="form-label">Bottle</label>
                                    <input type="number" class="form-control w-100" id="bottlesInput" min="0"
                                        placeholder="Enter bottles" style="width: 50%;">
                                </div>
                            </div>
                            <input type="hidden" name="inventory" value="" id="inventory" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label for="" class="form-label">SKU</label>
                            <input type="text" class="form-control" name="sku" id="sku">
                        </div>

                        <div class="col-md-4">
                            <label for="" class="form-label">Cost</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">$</span>
                                <input type="text" name="cost" placeholder="0.00"
                                    onkeypress="return handleInput(event, this)" id="cost" class="form-control"
                                    aria-label="Amount (to the nearest dollar)">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="form-label">Stocking Fee</label>
                            <input type="text" name="commission" placeholder="0.00"
                                onkeypress="return handleInput(event, this)" id="commission" class="form-control"
                                id="">
                        </div>

                        <div class="col-md-4">
                            <label for="" class="form-label">Price</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">$</span>
                                <input type="text" name="price" placeholder="0.00"
                                    onkeypress="return handleInput(event, this)" id="price" class="form-control"
                                    aria-label="Amount (to the nearest dollar)">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="" class="form-label">Bottle Notes</label>
                            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" id="submit-button" class="btn theme-btn w-25 px-3">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Image Modal (Media Gallery) -->
    <div class="modal fade mediaGalleryModal" id="editMediaModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-5 p-sm-4 p-2">
                <div class="modal-header border-0">
                    <h3 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Edit Media Gallery</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="upload_media">
                        <input type="hidden" value="" name="vendorImage" class="base64imageupload">
                        <div class="mb-3 image_section">
                            <label class="form-label">Add photo</label>
                            <div class="position-relative select_image_section">
                                <label class="custom-file-label" for="upload_photo_video">
                                    <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                </label>
                                <input type="file" accept="image/*" class="custom-file-input"
                                    id="upload_photo_video">
                            </div>
                            <div class="profile-image-upload-section"></div>
                        </div>

                        <div class="mb-3 text-center or_section">
                            <b>OR</b>
                        </div>
                        <div class="mb-3 youtube_section">
                            <label class="form-label">Add Youtube Link</label>
                            <input type="text" class="form-control add_youtube_link" placeholder="Add Link"
                                name="youtube_link">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn save-btn upload-image-youtube-button">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        // Show Sub Menu on Sidebar JS
        const parentMenus = document.querySelectorAll('.parent-menu');

        parentMenus.forEach(menu => {
            menu.addEventListener('click', function() {
                // Toggle the class "show-menu" on click
                menu.classList.toggle('show-menu');
            });
        });
    </script>
@endpush
