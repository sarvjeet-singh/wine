
@extends('FrontEnd.layouts.mainapp')



@section('content')
<div class="container my-5">	
    <div>
    <h5 class="text-center mb-4">The Wine Country Weekends marketing team sources and presents all the best experiences Niagara region has to offer.  Our newly updated, single source platform is being positioned as the hub for local travel, enhancing exposure and driving sales for all its registered vendors.</h5>
    </div>
	<div class="information-box">
		<div class="information-box-head">
	        <div class="box-head-heading d-flex flex-wrap flex-column">
	            <span class="box-head-label theme-color">Become a vendor</span>
	            {{--<p class="f-15">Suggest a vendor that does not currently exist in our database and you would like to submit a review for</p>--}}
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
            <input type="text" id="buisness_vendor_name" class="form-control" name="vendor_name" required>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-6 col-12">
            <label class="form-label">Street Address</label>
            <input type="text" class="form-control" name="street_address" >
        </div>
        <div class="col-sm-6 col-12">
            <label class="form-label">Unit/Suite#</label>
            <input type="text" class="form-control" name="unit_suite">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-6 col-12">
            <label class="form-label">City/Town</label>
            <input type="text" class="form-control" name="city_town" >
        </div>
        <div class="col-sm-6 col-12">
            <label class="form-label">Province/State</label>
            <input type="text" class="form-control" name="province_state" >
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-6 col-12">
            <label class="form-label">Postal / Zip</label>
            <input type="text" class="form-control" name="postal_zip" >
        </div>
        <div class="col-sm-6 col-12">
            <label class="form-label">Business/Vendor Phone</label>
            <input type="text" class="form-control" name="vendor_phone" >
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