@extends('FrontEnd.layouts.mainapp')

@section('content')
<style>
.detail-form-sec .sub-type-radio {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 10px 10px;
}
</style>
<div class="main-container">
<form class="row g-sm-3 g-2" action="{{ route('save.excursion') }}" method="post" >
 @csrf
<!--========== Business/Vendor Detail Form Start ==========-->
<section class="detail-form-sec mt-5 mb-md-5 mb-4">
	<div class="container">
    	@if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
		<div class="sec-head px-md-5 px-4 py-3">
			<h6 class="theme-color mb-0 fw-bold">Business/Vendor Details</h6>
		</div>	
		<div class="sec-form px-md-5 px-4 py-4">
			<div class="row g-sm-3 g-2 mb-3">
				<div class="col-md-6">
					<label for="businessName" class="form-label">Business/Vendor Name*</label>
					<input type="text" class="form-control @error('vendor_name') is-invalid @enderror" name="vendor_name" placeholder="Business/Vendor Name" value="{{ old('vendor_name') }}">
					@error('vendor_name')
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
				<div class="col-md-6">					
				</div>
				<div class="col-md-6">
					<div class="mb-3">
						<label for="streetAddress" class="form-label">Street Address*</label>
				        <input type="text" class="form-control @error('street_address') is-invalid @enderror" name="street_address" placeholder="Street Address" value="{{ old('street_address') }}">
                            @error('street_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
					</div>
					<div>
						<input class="form-check-input @error('hide_street_address') is-invalid @enderror" type="checkbox" id="hideStreetAddress" name="hide_street_address" {{ old('hide_street_address') ? 'checked' : '' }}>
						<label class="check-label" for="form-check-label">Check this box to hide street address</label>
						 @error('hide_street_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
					</div>
				</div>
				<div class="col-md-6">
					<label for="unitsuite" class="form-label">Unit/Suite#</label>
				    <input type="text" class="form-control @error('unitsuite') is-invalid @enderror" name="unitsuite" placeholder="Unit/Suite#" value="{{ old('unitsuite') }}">
                            @error('unitsuite')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
				</div>
				<div class="col-md-6">
					<label for="city" class="form-label">City/Town*</label>
				    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" placeholder="City/Town" value="{{ old('city') }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
				</div>
				<div class="col-md-6">
					<label for="province" class="form-label">Provience/State*</label>
				     <input type="text" class="form-control @error('province') is-invalid @enderror" name="province" placeholder="Province/State" value="{{ old('province') }}">
                            @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
				</div>
				<div class="col-md-6">
					<label for="postalCode" class="form-label">Postal/Zip*</label>
				    <input type="text" class="form-control @error('postalCode') is-invalid @enderror" name="postalCode" placeholder="Postal/Zip" value="{{ old('postalCode') }}"placeholder="Please enter Postal/Zip" maxlength="7" oninput="formatPostalCode(this)">
                            @error('postalCode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
				</div>
				<div class="col-md-6">
					<label for="country" class="form-label">Country*</label>
					<input type="text" class="form-control" name="country" value="{{ old('country', Auth::user()->country ?? 'CA') }}" placeholder="Enter Country" readonly>
				    @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
				</div>
			</div>
		</div>
	</div>
</section>
<!--========== Business/Vendor Detail Form End ==========-->

<!--========== Sub Region Form Start ==========-->
<section class="detail-form-sec mb-5">
	<div class="container">
		<div class="sec-head px-md-5 px-4 py-3">
			<h6 class="theme-color mb-0 fw-bold">Sub Region*</h6>
		</div>	
		<div class="sec-form px-md-5 px-4 py-4">
			<div class="row g-sm-3 g-2 mb-3">
				<div class="col-md-4">
					<div class="sub-type-radio d-block">
						<div class="d-flex align-items-baseline gap-2 mb-3">
							<input class="form-check-input @error('sub_region') is-invalid @enderror" type="radio" name="sub_region" id="niagara_falls" value="Niagara Falls" {{ old('sub_region') == 'Niagara Falls' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="niagara_falls">Niagara Falls</label>
						</div>
						<div class="d-flex align-items-baseline gap-2 mb-3">
							<input class="form-check-input @error('sub_region') is-invalid @enderror" type="radio" name="sub_region" id="SouthEscarpment" value="South Escarpment" {{ old('sub_region') == 'South Escarpment' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="SouthEscarpment">South Escarpment</label>
						</div>
					</div>			
				</div>
				<div class="col-md-4">
					<div class="sub-type-radio d-block">
						<div class="d-flex align-items-baseline gap-2 mb-3">
							<input class="form-check-input @error('sub_region') is-invalid @enderror" type="radio" name="sub_region" id="niagara_lake" value="Niagara-on-the-Lake" {{ old('sub_region') == 'Niagara-on-the-Lake' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="niagara_lake">Niagara-on-the-Lake</label>
						</div>
						<div class="d-flex align-items-baseline gap-2">
							<input class="form-check-input @error('sub_region') is-invalid @enderror" type="radio" name="sub_region" id="Fort_niagara_south_coast" value="Fort Erie/ Niagara South Coast" {{ old('sub_region') == 'Fort Erie/ Niagara South Coast' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Fort_niagara_south_coast">Fort Erie/ Niagara South Coast</label>
						</div>
					</div>				
				</div>	
				<div class="col-md-4">
					<div class="sub-type-radio d-block">
					<div class="d-flex align-items-baseline gap-2">
							<input class="form-check-input @error('sub_region') is-invalid @enderror" type="radio" name="sub_region" id="niagara_escarpment_twenty" value="Niagara Escarpment/ Twenty Valley" {{ old('sub_region') == 'Niagara Escarpment/ Twenty Valley' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="niagara_escarpment_twenty">Niagara Escarpment/ Twenty Valley</label>
						</div>
					</div>				
				</div>	
				@error('sub_region')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror		
			</div>
		</div>

	</div>
</section>
<!--========== Sub Region Details Form End ==========-->

<!--========== Excursion Detail Form Start ==========-->
<section class="detail-form-sec mb-5">
	<div class="container">
		<div class="sec-head px-md-5 px-4 py-3">
			<h6 class="theme-color mb-0 fw-bold">Excursion Details*</h6>
		</div>	
		<div class="sec-form px-md-5 px-4 py-4">
			<div class="row g-sm-3 g-2 mb-3">
				<div class="col-md-12">
					<div class="sub-type-radio">
						<div class="d-flex align-items-baseline gap-2">
							<input class="form-check-input @error('vendor_sub_category') is-invalid @enderror" type="radio" name="vendor_sub_category" id="arts_culture" value="Arts/Culture" {{ old('vendor_sub_category') == 'Arts/Culture' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="arts_culture">Arts/Culture</label>
						</div>
						<div class="d-flex align-items-baseline gap-2">
							<input class="form-check-input @error('vendor_sub_category') is-invalid @enderror" type="radio" name="vendor_sub_category" id="adult_entertainment" value="Adult Entertainment" {{ old('vendor_sub_category') == 'Adult Entertainment' ? 'checked' : '' }}>
                                <label class="form-check-label" for="adult_entertainment">Adult Entertainment</label>
						</div>
						<div class="d-flex align-items-baseline gap-2">
							<input class="form-check-input @error('vendor_sub_category') is-invalid @enderror" type="radio" name="vendor_sub_category" id="culinary" value="Culinary" {{ old('vendor_sub_category') == 'Culinary' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="culinary">Culinary</label>
						</div>
						
					</div>	
								
				</div>
				<div class="col-md-12">
					<div class="sub-type-radio">
						<div class="d-flex align-items-baseline gap-2">
							 <input class="form-check-input @error('vendor_sub_category') is-invalid @enderror" type="radio" name="vendor_sub_category" id="sports_adventuring" value="Sports & Adventuring" {{ old('vendor_sub_category') == 'Sports & Adventuring' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sports_adventuring">Sports & Adventuring</label>
						</div>
						<div class="d-flex align-items-baseline gap-2">
							<input class="form-check-input @error('vendor_sub_category') is-invalid @enderror" type="radio" name="vendor_sub_category" id="motel" value="family_entertainment" {{ old('vendor_sub_category') == 'Family Entertainment' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="family_entertainment">Family Entertainment</label>
						</div>
						<div class="d-flex align-items-baseline gap-2">
							<input class="form-check-input @error('vendor_sub_category') is-invalid @enderror" type="radio" name="vendor_sub_category" id="thrill_seeking" value="Thrill Seeking&B" {{ old('vendor_sub_category') == 'Thrill Seeking&B' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="thrill_seeking">Thrill Seeking&B</label>
						</div>
					</div>	
						@error('vendor_sub_category')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror	
				</div>
				
				<div class="col-12">
					<label for="description" class="form-label">Description</label>
					<textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3" placeholder="Description" style="height: 100px">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
				</div>			
			</div>
		</div>

	</div>
</section>
<!--========== Excursion Details Form End ==========-->

<!--========== Establishment/Facility Detail Form Start ==========-->
<section class="detail-form-sec mb-5">
	<div class="container">
		<div class="sec-head px-md-5 px-4 py-3">
			<h6 class="theme-color mb-0 fw-bold">Establishment/Facility*</h6>
		</div>	
		<div class="sec-form px-md-5 px-4 py-4">
			<div class="row g-sm-3 g-2 mb-3">
				<div class="col-md-12">
					<div class="sub-type-radio">
						<div class="d-flex align-items-baseline gap-2">
							<input class="form-check-input @error('establishment_facility') is-invalid @enderror" type="radio" name="establishment_facility" id="restaurant" value="Restaurant" {{ old('establishment_facility') == 'Restaurant' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="restaurant">Restaurant</label>
						</div>
						<div class="d-flex align-items-baseline gap-2">
							<input class="form-check-input @error('establishment_facility') is-invalid @enderror" type="radio" name="establishment_facility" id="bar_pub" value="Bar / Pub" {{ old('establishment_facility') == 'Bar / Pub' ? 'checked' : '' }}>
                                <label class="form-check-label" for="bar_pub">Bar / Pub</label>
						</div>
						<div class="d-flex align-items-baseline gap-2">
							<input class="form-check-input @error('establishment_facility') is-invalid @enderror" type="radio" name="establishment_facility" id="brew_pub" value="Brew Pub" {{ old('establishment_facility') == 'Brew Pub' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="brew_pub">Brew Pub</label>
						</div>
						<div class="d-flex align-items-baseline gap-2">
							<input class="form-check-input @error('establishment_facility') is-invalid @enderror" type="radio" name="establishment_facility" id="cafe_diner" value="Café / Diner" {{ old('establishment_facility') == 'Café / Diner' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cafe_diner">Café / Diner</label>
						</div>
						<div class="d-flex align-items-baseline gap-2">
							<input class="form-check-input @error('establishment_facility') is-invalid @enderror" type="radio" name="establishment_facility" id="food_truck" value="Food Truck" {{ old('establishment_facility') == 'Food Truck' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="food_truck">Food Truck</label>
						</div>
						<div class="d-flex align-items-baseline gap-2">
							 <input class="form-check-input @error('establishment_facility') is-invalid @enderror" type="radio" name="establishment_facility" id="farm_market" value="Farm / Market" {{ old('establishment_facility') == 'Farm / Market' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="farm_market">Farm / Market</label>
						</div>
					</div>	
				</div>
				<div class="col-md-12">
					<div class="sub-type-radio">
						
						<div class="d-flex align-items-baseline gap-2">
							<input class="form-check-input @error('establishment_facility') is-invalid @enderror" type="radio" name="establishment_facility" id="lounge_night_club" value="Lounge / Night Club" {{ old('establishment_facility') == 'Lounge / Night Club' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="lounge_night_club">Lounge / Night Club</label>
						</div>
						<div class="d-flex align-items-baseline gap-2">
							<input class="form-check-input @error('establishment_facility') is-invalid @enderror" type="radio" name="establishment_facility" id="theatre_venue" value="Theatre / Venue" {{ old('establishment_facility') == 'Theatre / Venue' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="theatre_venue">Theatre / Venue</label>
						</div>
						<div class="d-flex align-items-baseline gap-2">
							<input class="form-check-input @error('establishment_facility') is-invalid @enderror" type="radio" name="establishment_facility" id="public_park" value="Public Park" {{ old('establishment_facility') == 'Public Park' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="public_park">Public Park</label>
						</div>
						<div class="d-flex align-items-baseline gap-2">
							<input class="form-check-input @error('establishment_facility') is-invalid @enderror" type="radio" name="establishment_facility" id="golf_country_club" value="Golf & Country Club" {{ old('establishment_facility') == 'Golf & Country Club' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="golf_country_club">Golf & Country Club</label>
						</div>
					</div>	
						@error('establishment_facility')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror	
				</div>		
			</div>
		</div>
	</div>
</section>

<!--========== Establishment/Facility Details Form End ==========-->
<!--========== Vendor detail Form Start ==========-->
<section class="detail-form-sec mb-md-5 mb-4">
	<div class="container">
		<div class="sec-head px-md-5 px-4 py-3">
			<h6 class="theme-color mb-0 fw-bold">Vendor Detail</h6>
		</div>	
		<div class="sec-form px-md-5 px-4 py-4">
			<div class="row g-sm-3 g-2 mb-3">
				<div class="col-md-6">
					<label for="vendor_first_name" class="form-label">Given Name(s)</label>
				       <input type="text" class="form-control @error('vendor_first_name') is-invalid @enderror" name="vendor_first_name" placeholder="Given Name(s)" value="{{ old('first_name') }}">
                            @error('vendor_first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
				</div>
				<div class="col-md-6">
					<label for="vendorlastname" class="form-label">Last/Surname</label>
                    <input type="text" class="form-control @error('vendor_last_name') is-invalid @enderror" name="vendor_last_name" placeholder="Last/Surname" value="{{ old('vendor_last_name') }}">
                            @error('vendor_last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
				</div>
				<div class="col-md-6">
					<label for="businessEmail" class="form-label">eMail Address</label>
				    <input type="email" class="form-control @error('vendor_email') is-invalid @enderror" name="vendor_email" placeholder="eMail Address" value="{{ old('vendor_email') }}">
                            @error('vendor_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
				</div>
				<div class="col-md-6">
					<label for="vendorPhone" class="form-label">Vendor Phone number</label>
					<input type="text" class="form-control phone-number @error('vendor_phone') is-invalid @enderror" name="vendor_phone" placeholder="Business/Vendor Phone" value="{{ old('vendor_phone') }}">
					@error('vendor_phone')
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
			</div>
		</div>
		<div class="row mt-4">
			<div class="col-12 text-center">
		    	<button type="submit" class="btn book-btn">Submit</button>
		  	</div>
		</div>
	</div>
	
</section>
<!--========== Vendor Detail Form End ==========-->

</form>
</div>
@endsection

@section('js')
<script>
//Function for Postal code
    function formatPostalCode(input) {
    // Remove all non-alphanumeric characters and convert to uppercase
    let value = input.value.replace(/\W/g, '').toUpperCase();

    // Add a space after every 3 characters
    if (value.length > 3) {
        value = value.slice(0, 3) + ' ' + value.slice(3);
    }

    // Update the input value
    input.value = value;
}
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.phone-number').forEach(function(input) {
        input.addEventListener('input', function(e) {
            const value = e.target.value.replace(/\D/g, ''); // Remove all non-digit characters
            let formattedValue = '';
            if (value.length > 3 && value.length <= 6) {
                formattedValue = value.slice(0, 3) + '-' + value.slice(3);
            } else if (value.length > 6) {
                formattedValue = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
            } else {
                formattedValue = value;
            }
            e.target.value = formattedValue;
        });
    });
});

</script>
@endsection



