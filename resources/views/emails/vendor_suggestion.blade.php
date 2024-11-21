<h1>New Vendor Suggestion</h1>
<p><strong>Vendor Name:</strong> {{ $validated['vendor_name'] }}</p>
<p><strong>Street Address:</strong> {{ $validated['street_address'] }}</p>
<p><strong>Unit/Suite:</strong> {{ $validated['unit_suite'] }}</p>
<p><strong>City/Town:</strong> {{ $validated['city_town'] }}</p>
<p><strong>Province/State:</strong> {{ $validated['province_state'] }}</p>
<p><strong>Postal/Zip:</strong> {{ $validated['postal_zip'] }}</p>
<p><strong>Vendor Phone:</strong> {{ $validated['vendor_phone'] }}</p>
<p><strong>Vendor Category:</strong> {{ $validated['vendor_category'] }}</p>
<p><strong>Vendor Sub-Category:</strong> {{ $validated['vendor_sub_category'] }}</p>
<p><strong>Establishment/Facility:</strong> {{ $validated['establishment_facility'] }}</p>
<p><strong>Submitted by:</strong> {{ $user->name }} ({{ $user->email }})</p>
<div class="email-footer" style="text-align: center;">
<img src="https://winecountryweekends.ca/images/logo.png" style="width:150px;" alt="Logo">
<p>&copy; 2024 Wine Country Weekends. All rights reserved.</p>
</div>