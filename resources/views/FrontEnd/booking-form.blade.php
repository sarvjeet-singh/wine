@extends('FrontEnd.layouts.mainapp')

@section('content')
    <style>
        body {
            background-color: #fafafa;
        }
        .booking .card {
            border: none;
            border-radius: 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .booking .card-title {
            background-color: #f8f3e9;
            padding: 15px;
            margin: -1.25rem -1.25rem 1rem;
            border-bottom: 1px solid #ddd;
            font-size: 1.25rem;
            color: #333;
        }
        .booking .mb-3,
        .booking .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .booking .row.g-3 > [class*="col-"] {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .booking .card-body {
            padding: 1.25rem;
        }

        .booking {
            max-width: 960px;
        }
    </style>
</head>

<body>
    <div class="container frontend  booking mt-5">
        <form>
            <!-- Business/Vendor Details Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Business/Vendor Details</h5>
                    <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label for="businessName" class="form-label">Business/Vendor Name*</label>
                        <input type="text" class="form-control" id="businessName" placeholder="Business/Vendor Name">
                    </div>
                    </div>
                    <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label for="streetAddress" class="form-label">Street Address*</label>
                        <input type="text" class="form-control" id="streetAddress" placeholder="Street Address">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="unitsuite" class="form-label">Unit/Suite#</label>
                        <input type="text" class="form-control" id="unitsuite" placeholder="Street Address">
                    </div>
                    </div>
                    <div class="form-check mt-3 mb-3">
                        <input class="form-check-input" type="checkbox" id="hideStreetAddress">
                        <label class="form-check-label" for="hideStreetAddress">
                            Check this box to hide street address
                        </label>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">City/Town*</label>
                            <input type="text" class="form-control" id="city" placeholder="City/Town">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="province" class="form-label">Province/State*</label>
                            <input type="text" class="form-control" id="province" placeholder="Province/State">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="postalCode" class="form-label">Postal/Zip*</label>
                            <input type="text" class="form-control" id="postalCode" placeholder="Postal/Zip">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="country" class="form-label">Country*</label>
                            <input type="text" class="form-control" id="country" placeholder="Country">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-Region Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Sub-Region</h5>
                    <div class="mb-3">
                        <label for="vendorPhone" class="form-label">Business/Vendor Phone*</label>
                        <input type="text" class="form-control" id="vendorPhone" placeholder="Business/Vendor Phone">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description*</label>
                        <textarea class="form-control" id="description" rows="3" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>

            <!-- Accommodation Details Section -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Accommodation Details</h5>
                    <div class="mb-3">
                        <label class="form-label">Accommodation Sub Type</label>
                        <div class="row g-3 justify-content-between">
                        <div class="col-md-4 d-flex  justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="accommodationType" id="hotel" value="Hotel">
                            <label class="form-check-label" for="hotel">
                                Hotel
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="accommodationType" id="inn" value="Inn">
                            <label class="form-check-label" for="inn">
                                Inn
                            </label>
                        </div></div>
                        <div class="col-md-6 d-flex  justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="accommodationType" id="vacationEntire" value="Vacation Property (Entire Home)">
                            <label class="form-check-label" for="vacationEntire">
                                Vacation Property (Entire Home)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="accommodationType" id="serviceApartment" value="Service Apartment">
                            <label class="form-check-label" for="serviceApartment">
                                Service Apartment
                            </label>
                        </div></div>
                        <div class="col-md-4 d-flex  justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="accommodationType" id="motel" value="Motel">
                            <label class="form-check-label" for="motel">
                                Motel
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="accommodationType" id="bb" value="B&B">
                            <label class="form-check-label" for="bb">
                                B&B
                            </label>
                        </div></div><div class="col-md-6 d-flex  justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="accommodationType" id="vacationGuest" value="Vacation Property (Guest House)">
                            <label class="form-check-label" for="vacationGuest">
                                Vacation Property (Guest House)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="accommodationType" id="furnishedRoom" value="Furnished Room">
                            <label class="form-check-label" for="furnishedRoom">
                                Furnished Room
                            </label>
                        </div>
                    </div></div></div>
                    <div class="row g-3">
                        <div class="col-md-6 ">
                            <label for="squareFootage" class="form-label">Total Square Footage</label>
                            <input type="text" class="form-control" id="squareFootage" placeholder="Total Square Footage">
                        </div>
                        <div class="col-md-6">
                            <label for="bedrooms" class="form-label">Bedrooms*</label>
                            <input type="text" class="form-control" id="bedrooms" placeholder="Bedrooms">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="washrooms" class="form-label">Washrooms</label>
                            <input type="text" class="form-control" id="washrooms" placeholder="Washrooms">
                        </div>
                        <div class="col-md-6">
                            <label for="sleeps" class="form-label">Sleeps</label>
                            <input type="text" class="form-control" id="sleeps" placeholder="Sleeps">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center" style="display: none;">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    @endsection
    