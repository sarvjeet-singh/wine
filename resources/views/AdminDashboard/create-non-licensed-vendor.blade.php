@extends('FrontEnd.layouts.mainapp')

@section('content')
<style>
	.detail-form-sec .sub-type-radio {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 30px 10px;
}
</style>
<div class="container">
<form class="row g-sm-3 g-2" action="{{ route('save.nonLicensedVendor') }}" method="post" >
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
						<div class="d-flex align-items-baseline gap-2">
							<input class="form-check-input @error('sub_region') is-invalid @enderror" type="radio" name="sub_region" id="niagara_escarpment_twenty" value="Niagara Escarpment/ Twenty Valley" {{ old('sub_region') == 'Niagara Escarpment/ Twenty Valley' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="niagara_escarpment_twenty">Niagara Escarpment/ Twenty Valley</label>
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
						<div class="d-flex align-items-baseline gap-2 mb-3">
							<input class="form-check-input @error('sub_region') is-invalid @enderror" type="radio" name="sub_region" id="SouthEscarpment" value="South Escarpment" {{ old('sub_region') == 'South Escarpment' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="SouthEscarpment">South Escarpment</label>
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

<!--========== Accommodation Detail Form Start ==========-->
<section class="detail-form-sec mb-5">
	<div class="container">
		<div class="sec-head px-md-5 px-4 py-3">
			<h6 class="theme-color mb-0 fw-bold">Non-Licensed Details</h6>
		</div>	
		<div class="sec-form px-md-5 px-4 py-4">
			<div class="row g-sm-3 g-2 mb-3">
				<label class="mb-3">Non-Licensee Sub-Type*</label>
				<div class="col-md-4">
					<div class="sub-type-radio d-block">
						<div class="d-flex align-items-baseline gap-2 mb-3">
							<input class="form-check-input @error('vendor_sub_category') is-invalid @enderror" type="radio" name="vendor_sub_category" id="Food-Truck" value="Food Truck [Culinary]" {{ old('vendor_sub_category') == 'Food Truck [Culinary]' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Food-Truck">Food Truck [Culinary]</label>
						</div>
						<div class="d-flex align-items-baseline gap-2">
							<input class="form-check-input @error('vendor_sub_category') is-invalid @enderror" type="radio" name="vendor_sub_category" id="diner" value="Café / Diner [Culinary]" {{ old('vendor_sub_category') == 'Café / Diner [Culinary]' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Diner">Café / Diner [Culinary]</label>
						</div>
					</div>			
				</div>
				<div class="col-md-4">
					<div class="sub-type-radio d-block">
						<div class="d-flex align-items-baseline gap-2 mb-3">
							<input class="form-check-input @error('vendor_sub_category') is-invalid @enderror" type="radio" name="vendor_sub_category" id="eatery" value="Farm / Market [Culinary]" {{ old('vendor_sub_category') == 'Farm / Market [Culinary]' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Farm-Market">Farm / Market [Culinary]</label>
						</div>
						<div class="d-flex align-items-baseline gap-2">
							<input class="form-check-input @error('vendor_sub_category') is-invalid @enderror" type="radio" name="vendor_sub_category" id="public-health" value="Public Health" {{ old('vendor_sub_category') == 'Public Health' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Public Health">Public Health</label>
						</div>
					</div>				
				</div>	
				<div class="col-md-4">
					<div class="sub-type-radio d-block">
						<div class="d-flex align-items-baseline gap-2 mb-3">
							<input class="form-check-input @error('vendor_sub_category') is-invalid @enderror" type="radio" name="vendor_sub_category" id="personal-care-fitness" value="Personal Care & Fitness" {{ old('vendor_sub_category') == 'Personal Care & Fitness' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Personal Care & Fitness">Personal Care & Fitness</label>
						</div>
						<div class="d-flex align-items-baseline gap-2 mb-3">
							<input class="form-check-input @error('vendor_sub_category') is-invalid @enderror" type="radio" name="vendor_sub_category" id="Public-Parks" value="Public Parks [Family]" {{ old('vendor_sub_category') == 'Public Parks [Family]' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Public-Parks">Public Parks [Family]</label>
						</div>
					</div>				
				</div>	
				<div class="col-md-4 mt-0">
					<div class="sub-type-radio d-block d-flex">
						<div class="align-items-baseline gap-2 mb-3">
							<input class="form-check-input @error('vendor_sub_category') is-invalid @enderror" type="radio" name="vendor_sub_category" id="Miscellaneous" value="Miscellaneous" {{ old('vendor_sub_category') == 'Miscellaneous' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Miscellaneous">Miscellaneous</label>
						</div>
					</div>				
				</div>	
				@error('vendor_sub_category')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
						<div class="col-md-12">
					<label class="mb-3">Excursion Sub-Type*</label>
					<div class="sub-type-radio">
					<div class="d-flex align-items-baseline gap-2">
						<input class="form-check-input @error('excursion_sub_category') is-invalid @enderror" type="radio" name="excursion_sub_category" id="arts-culture" value="Arts/Culture" {{ old('excursion_sub_category') == 'Arts/Culture' ? 'checked' : '' }}>
						<label class="form-check-label" for="arts-culture">Arts/Culture</label>
					</div>
					<div class="d-flex align-items-baseline gap-2">
						<input class="form-check-input @error('excursion_sub_category') is-invalid @enderror" type="radio" name="excursion_sub_category" id="culinary" value="Culinary" {{ old('excursion_sub_category') == 'Culinary' ? 'checked' : '' }}>
						<label class="form-check-label" for="culinary">Culinary</label>
					</div>
					<div class="d-flex align-items-baseline gap-2">
						<input class="form-check-input @error('excursion_sub_category') is-invalid @enderror" type="radio" name="excursion_sub_category" id="family-fun" value="Family Fun (Entertainment)" {{ old('excursion_sub_category') == 'Family Fun (Entertainment)' ? 'checked' : '' }}>
						<label class="form-check-label" for="family-fun">Family Fun (Entertainment)</label>
					</div>
					<div class="d-flex align-items-baseline gap-2">
						<input class="form-check-input @error('excursion_sub_category') is-invalid @enderror" type="radio" name="excursion_sub_category" id="adult-entertainment" value="Adult Entertainment" {{ old('excursion_sub_category') == 'Adult Entertainment' ? 'checked' : '' }}>
						<label class="form-check-label" for="adult-entertainment">Adult Entertainment</label>
					</div>
					<div class="d-flex align-items-baseline gap-2">
						<input class="form-check-input @error('excursion_sub_category') is-invalid @enderror" type="radio" name="excursion_sub_category" id="sport-adventure" value="Sport & Adventure" {{ old('excursion_sub_category') == 'Sport & Adventure' ? 'checked' : '' }}>
						<label class="form-check-label" for="sport-adventure">Sport & Adventure</label>
					</div>
					<div class="d-flex align-items-baseline gap-2">
						<input class="form-check-input @error('excursion_sub_category') is-invalid @enderror" type="radio" name="excursion_sub_category" id="thrill-seeking" value="Thrill Seeking" {{ old('excursion_sub_category') == 'Thrill Seeking' ? 'checked' : '' }}>
						<label class="form-check-label" for="thrill-seeking">Thrill Seeking</label>
					</div>
					</div>	
					
					@error('excursion_sub_category')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror		
				</div>		
					<div class="col-12">
					<label class="mb-3">Cuisine	</label>
					<select id="multiple-select" name="cuisines[]" multiple style="display:none;">
						<option value="African" {{ collect(old('cuisines'))->contains('African') ? 'selected' : '' }}>African</option>
						<option value="American" {{ collect(old('cuisines'))->contains('American') ? 'selected' : '' }}>American</option>
						<option value="American Bistro" {{ collect(old('cuisines'))->contains('American Bistro') ? 'selected' : '' }}>American Bistro</option>
						<option value="BBQ" {{ collect(old('cuisines'))->contains('BBQ') ? 'selected' : '' }}>BBQ</option>
						<option value="Brazilian" {{ collect(old('cuisines'))->contains('Brazilian') ? 'selected' : '' }}>Brazilian</option>
						<option value="Breakfast" {{ collect(old('cuisines'))->contains('Breakfast') ? 'selected' : '' }}>Breakfast</option>
						<option value="Cajun" {{ collect(old('cuisines'))->contains('Cajun') ? 'selected' : '' }}>Cajun</option>
						<option value="Caribbean" {{ collect(old('cuisines'))->contains('Caribbean') ? 'selected' : '' }}>Caribbean</option>
						<option value="Chinese" {{ collect(old('cuisines'))->contains('Chinese') ? 'selected' : '' }}>Chinese</option>
						<option value="Cuban" {{ collect(old('cuisines'))->contains('Cuban') ? 'selected' : '' }}>Cuban</option>
						<option value="Ethiopian" {{ collect(old('cuisines'))->contains('Ethiopian') ? 'selected' : '' }}>Ethiopian</option>
						<option value="Filipino" {{ collect(old('cuisines'))->contains('Filipino') ? 'selected' : '' }}>Filipino</option>
						<option value="French" {{ collect(old('cuisines'))->contains('French') ? 'selected' : '' }}>French</option>
						<option value="German" {{ collect(old('cuisines'))->contains('German') ? 'selected' : '' }}>German</option>
						<option value="Greek" {{ collect(old('cuisines'))->contains('Greek') ? 'selected' : '' }}>Greek</option>
						<option value="Indian" {{ collect(old('cuisines'))->contains('Indian') ? 'selected' : '' }}>Indian</option>
						<option value="Italian" {{ collect(old('cuisines'))->contains('Italian') ? 'selected' : '' }}>Italian</option>
						<option value="Jamaican" {{ collect(old('cuisines'))->contains('Jamaican') ? 'selected' : '' }}>Jamaican</option>
						<option value="Japanese" {{ collect(old('cuisines'))->contains('Japanese') ? 'selected' : '' }}>Japanese</option>
						<option value="Korean" {{ collect(old('cuisines'))->contains('Korean') ? 'selected' : '' }}>Korean</option>
						<option value="Mexican" {{ collect(old('cuisines'))->contains('Mexican') ? 'selected' : '' }}>Mexican</option>
						<option value="Middle Eastern" {{ collect(old('cuisines'))->contains('Middle Eastern') ? 'selected' : '' }}>Middle Eastern</option>
						<option value="Tapas" {{ collect(old('cuisines'))->contains('Tapas') ? 'selected' : '' }}>Tapas</option>
						<option value="Thai" {{ collect(old('cuisines'))->contains('Thai') ? 'selected' : '' }}>Thai</option>
						<option value="Vietnamese" {{ collect(old('cuisines'))->contains('Vietnamese') ? 'selected' : '' }}>Vietnamese</option>
					</select>
					@error('cuisines')
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
				<div class="col-12">
					<label class="mb-3">Public Amenities</label>
					<select id="multiple-select2" name="public_amenities[]" multiple style="display:none;">
						<option value="Ample Space [Sports/Games]" {{ collect(old('public_amenities'))->contains('Ample Space [Sports/Games]') ? 'selected' : '' }}>Ample Space [Sports/Games]</option>
						<option value="Parking [Paid]" {{ collect(old('public_amenities'))->contains('Parking [Paid]') ? 'selected' : '' }}>Parking [Paid]</option>
						<option value="Benches" {{ collect(old('public_amenities'))->contains('Benches') ? 'selected' : '' }}>Benches</option>
						<option value="Hiking Trails" {{ collect(old('public_amenities'))->contains('Hiking Trails') ? 'selected' : '' }}>Hiking Trails</option>
						<option value="Lake/River Access" {{ collect(old('public_amenities'))->contains('Lake/River Access') ? 'selected' : '' }}>Lake/River Access</option>
						<option value="Parking [Free]" {{ collect(old('public_amenities'))->contains('Parking [Free]') ? 'selected' : '' }}>Parking [Free]</option>
						<option value="Picnic Tables" {{ collect(old('public_amenities'))->contains('Picnic Tables') ? 'selected' : '' }}>Picnic Tables</option>
						<option value="Tree Lined [Shaded Areas]" {{ collect(old('public_amenities'))->contains('Tree Lined [Shaded Areas]') ? 'selected' : '' }}>Tree Lined [Shaded Areas]</option>
						<option value="Washrooms" {{ collect(old('public_amenities'))->contains('Washrooms') ? 'selected' : '' }}>Washrooms</option>
						<option value="Wheelchair Access" {{ collect(old('public_amenities'))->contains('Wheelchair Access') ? 'selected' : '' }}>Wheelchair Access</option>
					</select>

					@error('cuisines')
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
			<label >Hours of Operation</label>
					<div class="col-md-6 mb-2">
						<div class="input-group">
							<label for="monday_open" class="input-group-text">Monday</label>
							<input type="time" class="form-control" name="monday_open" id="monday_open" value="{{ old('monday_open') }}">
							<input type="time" class="form-control" name="monday_close" id="monday_close" value="{{ old('monday_close') }}">
						</div>
					</div>
					<div class="col-md-6 mb-2">
						<div class="input-group">
							<label for="tuesday_open" class="input-group-text">Tuesday</label>
							<input type="time" class="form-control" name="tuesday_open" id="tuesday_open" value="{{ old('tuesday_open') }}">
							<input type="time" class="form-control" name="tuesday_close" id="tuesday_close" value="{{ old('tuesday_close') }}">
						</div>
					</div>
					<div class="col-md-6 mb-2">
						<div class="input-group">
							<label for="wednesday_open" class="input-group-text">Wednesday</label>
							<input type="time" class="form-control" name="wednesday_open" id="wednesday_open" value="{{ old('wednesday_open') }}">
							<input type="time" class="form-control" name="wednesday_close" id="wednesday_close" value="{{ old('wednesday_close') }}">
						</div>
					</div>
					<div class="col-md-6 mb-2">
						<div class="input-group">
							<label for="thursday_open" class="input-group-text">Thursday</label>
							<input type="time" class="form-control" name="thursday_open" id="thursday_open" value="{{ old('thursday_open') }}">
							<input type="time" class="form-control" name="thursday_close" id="thursday_close" value="{{ old('thursday_close') }}">
						</div>
					</div>
					<div class="col-md-6 mb-2">
						<div class="input-group">
							<label for="friday_open" class="input-group-text">Friday</label>
							<input type="time" class="form-control" name="friday_open" id="friday_open" value="{{ old('friday_open') }}">
							<input type="time" class="form-control" name="friday_close" id="friday_close" value="{{ old('friday_close') }}">
						</div>
					</div>
					<div class="col-md-6 mb-2">
						<div class="input-group">
							<label for="saturday_open" class="input-group-text">Saturday</label>
							<input type="time" class="form-control" name="saturday_open" id="saturday_open" value="{{ old('saturday_open') }}">
							<input type="time" class="form-control" name="saturday_close" id="saturday_close" value="{{ old('saturday_close') }}">
						</div>
					</div>
					<div class="col-md-6 mb-2">
						<div class="input-group">
							<label for="sunday_open" class="input-group-text">Sunday</label>
							<input type="time" class="form-control" name="sunday_open" id="sunday_open" value="{{ old('sunday_open') }}">
							<input type="time" class="form-control" name="sunday_close" id="sunday_close" value="{{ old('sunday_close') }}">
						</div>
					</div>
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
</section>
<!--========== Accommodation Details Form End ==========-->


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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#multiple-select').select2({
        placeholder: 'Select cuisines...',
        width: '100%'
    });
	$('#multiple-select2').select2({
        placeholder: 'Public Amenities...',
        width: '100%'
    });

});
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