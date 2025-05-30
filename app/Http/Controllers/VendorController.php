<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

use App\Models\PublishSeason;
use App\Helpers\SeasonHelper;
use App\Models\BookingDate;
use App\Models\Experience;
use App\Models\Vendor;
use App\Models\VendorSocialMedia;
use App\Models\VendorPricing;
use App\Models\VendorMediaGallery;
use App\Models\Review;
use App\Models\Questionnaire;
use App\Models\VendorQuestionnaire;
use App\Models\Amenity;
use App\Models\VendorAmenity;
use App\Models\VendorRoom;
use App\Models\Order;
use App\Models\Inquiry;
use App\Models\CmsPage;
use App\Models\InventoryType;
use App\Models\SubCategory;
use App\Models\FarmingPractice;
use App\Models\MaxGroup;
use App\Models\TastingOption;
use App\Models\Establishment;
use App\Models\Cuisine;
use App\Models\Country;
use App\Models\FaqSection;
use App\Models\User;
use App\Models\Customer;
use App\Models\SubRegion;
use App\Models\VendorStripeDetail;
use App\Models\VendorAccommodationMetadata;
use App\Models\VendorWineryMetadata;
use App\Models\VendorExcursionMetadata;
use App\Models\VendorLicenseMetadata;
use App\Models\VendorNonLicenseMetadata;
use App\Models\WinerySubscription;
use \illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryApprovedMail;
use App\Mail\InquiryRejectedMail;
use DB;
use Hash;
use App\Services\DateCheckerService;
use App\Helpers\VendorHelper;


class VendorController extends Controller
{
	private $dateCheckerService;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(DateCheckerService $dateCheckerService)
	{
		// $this->middleware('auth');
		$this->dateCheckerService = $dateCheckerService;
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function manageBookingUtilityAjax(Request $request)
	{
		// if(Auth::id()){
		// $user_id = Auth::id();
		$today = Carbon::today();
		$vendor_id = $request->vendorid;
		$cojoin = DB::table('booking_dates')->where('vendor_id',  $vendor_id)->where('booking_type', 'packaged')->select('start_date', 'end_date')->get();
		$booked = DB::table('booking_dates')->where('vendor_id',  $vendor_id)->where('booking_type', '!=', 'packaged')->select('start_date', 'end_date')->get();

		// $booked_dates = DB::table('member_payment')->where('vendor_id',  $vendor_id)->select('check_in','check_out')->get();
		$checkOutOnly = [];
		$checkInOnly = [];
		$cojoinDates = array();
		$dates = array();

		foreach ($cojoin as $value) {
			// Convert start_date and end_date to Carbon instances
			$startDate = Carbon::parse($value->start_date);
			$endDate = Carbon::parse($value->end_date);

			// Initialize an array to hold dates for the current range
			$rangeDates = [];

			// Generate all dates between start_date and end_date, including both
			for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
				// Add each date to the rangeDates array in 'Y-m-d' format
				$rangeDates[] = $date->format('Y-m-d');
			}

			// Add this array of dates to the main allDates array
			$cojoinDates[] = $rangeDates;
		}

		// if (count($cojoin)) {
		// 	foreach ($cojoin as $value) {
		// 		$diff = date_diff(date_create($value->start_date), date_create($value->end_date));
		// 		$days = $diff->format("%a") . ",";
		// 		$start_date = $value->start_date;
		// 		array_push($cojoinDates, $value->start_date);
		// 		for ($day = 1; $day <= $days; $day++) {
		// 			$start_date = date('Y-m-d', strtotime(($start_date . '1 day')));
		// 			array_push($cojoinDates, $start_date);
		// 		}
		// 	}
		// }

		// if(count($booked_dates)){
		// 	foreach ($booked_dates as $value){
		// 		$diff=date_diff(date_create($value->check_in),date_create($value->check_out));
		// 		$days = $diff->format("%a").",";
		// 		$check_in = $value->check_in;
		// 		array_push($dates,$value->check_in);
		// 		for ($day = 1; $day <= $days; $day++){
		// 			$check_in = date('Y-m-d', strtotime(($check_in . ' 1 day')));
		// 			array_push($dates,$check_in);
		// 		}
		// 	}
		// }
		$bookedAndBlockedDates = [];
		if (count($booked)) {
			foreach ($booked as $value) {
				$diff = date_diff(date_create($value->start_date), date_create($value->end_date));
				$days = $diff->format("%a") . ",";
				$start_date = $value->start_date;
				array_push($bookedAndBlockedDates, $value->start_date);
				for ($day = 1; $day <= $days; $day++) {
					$start_date = date('Y-m-d', strtotime(($start_date . '1 day')));
					array_push($bookedAndBlockedDates, $start_date);
				}
			}
		}
		// $bookedAndBlockedDates = [];
		$orders = Order::where('vendor_id', $vendor_id)
			->where(function ($query) use ($today) {
				$query->where('check_in_at', '>=', $today)
					->orWhere('check_out_at', '>=', $today);
			})
			->get();
		foreach ($orders as $order) {
			$checkin = Carbon::parse($order->check_in_at);
			$checkout = Carbon::parse($order->check_out_at)->subDay();

			// Ensure we start from today if checkin is before today
			if ($checkin->lt($today)) {
				$checkin = $today;
			}

			// Generate dates between checkin and checkout
			while ($checkin->lte($checkout)) {
				$bookedAndBlockedDates[] = $checkin->toDateString(); // Add the date to the array
				$checkin->addDay(); // Move to the next day
			}
		}
		// Remove duplicates just in case
		$bookedAndBlockedDates = array_unique($bookedAndBlockedDates);

		// Sort dates (optional)
		sort($bookedAndBlockedDates);

		// Convert to JSON format if needed
		// $bookedAndBlockedDatesJson = json_encode($bookedAndBlockedDates);
		$dates_all = $this->dateCheckerService->processVendorDates($vendor_id);
		$checkInOnly = $this->dateCheckerService->getCheckInOnlyDates();
		$checkOutOnly = $this->dateCheckerService->getCheckOutOnlyDates();
		$bookedAndBlockeddates = $this->dateCheckerService->getBlockedDates();
		$data['bookedAndBlockeddates']  = $bookedAndBlockeddates;
		$data['checkOutOnly']           = $checkOutOnly;
		$data['checkInOnly']           = $checkInOnly;
		$data['cojoinDates'] = $cojoinDates;
		$data['dates'] = $dates;
		// $data['bookedAndBlockeddates'] = $bookedAndBlockedDates;
		return response()->json(array('success' => true, 'data' => $data), 200);

		// }
	}

	public function addbookingdate(Request $request)
	{

		$user = Auth::user();
		$booking_dates = new BookingDate;
		$booking_dates->user_id = $user->id;
		$booking_dates->vendor_id = $request->vendorid;
		$booking_dates->booking_type = $request->booking_type;
		$booking_dates->reason = $request->type_reason ? $request->type_reason : '';
		$booking_dates->start_date = $request->start_date;
		$booking_dates->end_date = $request->end_date;
		$booking_dates->save();
		// return back();
	}

	public function publishDatesUpdate(Request $request)
	{
		$vendorID = $request->vendorid; // Ensure it matches AJAX param

		if (!$vendorID) {
			return response()->json([
				'success' => false,
				'message' => ['Vendor ID is required.'], // Return as an array
			], 400);
		}

		$response = VendorHelper::canActivateBooking($vendorID);
		if (!$response['status']) {
			return response()->json([
				'success' => false,
				'message' => is_array($response['messages']) ? $response['messages'] : [$response['messages']],
			], 400);
		}

		$seasonType = $request->season_type;

		// Check if pricing exists
		$seasonPricingExists = VendorPricing::where('vendor_id', $vendorID)
			->whereNotNull($seasonType)
			->exists();

		if (!$seasonPricingExists) {
			return response()->json([
				'success' => false,
				'message' => ['Pricing does not exist for the selected season.'], // Return as an array
			], 400);
		}

		// Find or create PublishSeason record
		$PublishSeason = PublishSeason::firstOrNew([
			'vendor_id' => $vendorID,
			'season_type' => $seasonType
		]);

		$PublishSeason->publish = 1;
		$PublishSeason->save();

		return response()->json([
			'success' => true,
			'message' => 'Season published successfully.',
		]);
	}

	public function getCuratedExperience($vendorid)
	{
		$experiences = Experience::where('vendor_id', $vendorid)->get();
		return view('VendorDashboard.vendor-curated-experience', compact('experiences', 'vendorid'));
	}

	public function updateCuratedExperience(Request $request)
	{
		$vendor_id = $request->input('vendor_id');

		// Initialize rules and messages
		$rules = [];
		$messages = [];

		// Get existing experiences
		$existingExperiences = Experience::where('vendor_id', $vendor_id)->get();

		// Iterate through up to three experiences
		for ($i = 0; $i < 3; $i++) {
			$experienceData = $request->input("experience.$i");
			// print_r($experienceData); die;
			if ($experienceData['title'] == null) {
				continue;
			}
			// Check if any field is filled
			if ($experienceData['title'] || $experienceData['upgradefee'] || $experienceData['currenttype'] || $experienceData['description']) {
				// If this experience already exists, update it
				if (isset($existingExperiences[$i])) {
					$rules["experience.$i.title"] = 'required';
					$rules["experience.$i.upgradefee"] = 'required';
					$rules["experience.$i.currenttype"] = 'required';
					$rules["experience.$i.description"] = 'required|max:250';

					// Custom messages...
					$messages["experience.$i.title.required"] = 'The experience ' . ($i + 1) . ' title is required.';
					$messages["experience.$i.upgradefee.required"] = 'The experience ' . ($i + 1) . ' upgrade fee is required.';
					$messages["experience.$i.currenttype.required"] = 'The experience ' . ($i + 1) . ' extension type is required.';
					$messages["experience.$i.description.required"] = 'The experience ' . ($i + 1) . ' description is required.';
					$messages["experience.$i.description.max"] = 'The experience ' . ($i + 1) . ' description may not be greater than 250 characters.';

					// Validate the existing experience data
					$request->validate($rules, $messages);
					// Update the existing experience
					$existingExperiences[$i]->update($experienceData);
				} else {
					// If the experience does not exist, add validation rules
					$rules["experience.$i.title"] = 'required';
					$rules["experience.$i.upgradefee"] = 'required';
					$rules["experience.$i.currenttype"] = 'required';
					$rules["experience.$i.description"] = 'required|max:250';

					// Validate the new experience data
					$request->validate($rules, $messages);

					// Create a new experience
					Experience::create(array_merge($experienceData, ['vendor_id' => $vendor_id, 'user_id' => 1]));
				}
			}
		}

		return redirect()->back()->with('success', 'Curated experiences updated successfully.');
	}

	// public function updateCuratedExperience(Request $request){
	//     $vendor_id = $request->vendor_id;
	//     if($request->experience && count($request->experience) > 0 ){
	//         foreach($request->experience as $experiences){
	//             if(isset($experiences['id'])){
	//                 $experience = Experience::find($experiences['id']);
	//             }else{
	//                 $experience = new Experience;
	//                 $experience->vendor_id = $vendor_id;
	//             }

	//             $experience->user_id = 1; //Auth::id();
	//             $experience->title = isset($experiences['title']) ? $experiences['title']: '';
	//             $experience->upgradefee = isset($experiences['upgradefee']) ? $experiences['upgradefee']: '';
	//             $experience->currenttype = isset($experiences['currenttype']) ? $experiences['currenttype']: '';
	//             $experience->description = isset($experiences['description']) ? $experiences['description']: '';
	//             $experience->save();
	//         }
	//     }
	//     return redirect()->back()->with('success', 'Curated Experience updated successfully!');
	// }

	public function getVendorSettings($vendorid)
	{
		$vendor = Vendor::find($vendorid);
		$vendor_type = strtolower($vendor->vendor_type);
		$countries = Country::get();
		$subRegions = SubRegion::where('region_id', 1)->get();
		$inventoryTypes = InventoryType::with('subCategories')->get();
		$subCategories = SubCategory::whereHas('category', function ($query) use ($vendor_type) {
			$query->where('slug', $vendor_type);
		})->get();
		$farmingPractices = FarmingPractice::get();
		$maxGroups = MaxGroup::get();
		$tastingOptions = TastingOption::get();
		$establishments = Establishment::get();
		$cuisines = Cuisine::get();
		switch (strtolower($vendor_type)) {
			case 'excursion':
				$vendor->load('excursionMetadata');
				$metadata = $vendor->excursionMetadata;
				break;
			case 'winery':
				$vendor->load('wineryMetadata');
				$metadata = $vendor->wineryMetadata;
				break;
			case 'accommodation':
				$vendor->load('accommodationMetadata');
				$metadata = $vendor->accommodationMetadata;
				break;
			case 'licensed':
				$vendor->load('licenseMetadata');
				$metadata = $vendor->licenseMetadata;
				break;
			case 'non-licensed':
				$vendor->load('nonLicenseMetadata');
				$metadata = $vendor->nonLicenseMetadata;
				break;
				// Add other cases as necessary
		}
		$VendorMediaGallery = VendorMediaGallery::where('vendor_id', $vendorid)->get();
		return view('VendorDashboard.vendor-settings', compact('vendor', 'subCategories', 'inventoryTypes', 'farmingPractices', 'maxGroups', 'tastingOptions', 'cuisines', 'establishments', 'countries', 'metadata', 'subRegions', 'VendorMediaGallery'));
	}
	public function getVendorAmenities($vendorId)
	{
		$vendor = Vendor::findOrFail($vendorId);
		$amenities = Amenity::where('amenity_status', 'active')
			->with(['vendors' => function ($query) use ($vendorId) {
				$query->where('vendor_id', $vendorId);
			}]);
		if (strtolower($vendor->vendor_type) == 'accommodation') {
			$amenities = $amenities->where('vendor_type', 'accommodation');
		} else if (strtolower($vendor->vendor_type) == 'excursion' || strtolower($vendor->vendor_type) == 'winery') {
			$amenities = $amenities->where('vendor_type', NULL);
		}
		$amenities = $amenities->get();

		return view('VendorDashboard.vendor-amenities', compact('vendor', 'amenities'));
	}
	public function VendorSettingsPropertyDetails(Request $request)
	{
		$request->validate([
			'vendor_name' => 'required|string|max:255',
			'street_address' => [
				'required',
				'string',
				'max:255',
				function ($attribute, $value, $fail) use ($request) {
					// Vendor ID if this is an edit operation
					$vendorId = $request->vendorid;

					// Normalize the input address by cleaning and splitting it into words
					$normalizedInputAddress = $this->normalizeAddress($value);

					// Check if a vendor with the same name and similar address exists, excluding the current vendor
					$vendorsExists = DB::table('vendors')
						->where('vendor_name', $request->input('vendor_name'))
						->when($vendorId, function ($query, $vendorId) {
							// Exclude the vendor being edited
							return $query->where('id', '!=', $vendorId);
						})
						->get()
						->filter(function ($vendor) use ($normalizedInputAddress) {
							// Normalize the address from the database
							$normalizedDbAddress = $this->normalizeAddress($vendor->street_address);

							// Compare normalized addresses as sets of words
							return $this->compareAddresses($normalizedInputAddress, $normalizedDbAddress);
						})
						->isNotEmpty();

					if ($vendorsExists) {
						$fail('The vendor with this name and a similar address already exists.');
					}
				},
			],
			'vendor_email' => 'nullable|email|max:255',
			'country' => 'required|string|max:255',
			'province' => 'required|string|max:255',
			'city' => 'required|string|max:255',
			'unitsuite' => 'nullable|string|max:255',
			'postalCode' => 'required|string|max:10',
			'vendor_phone' => 'nullable|string|max:20',
			'sub_region' => 'nullable|string|max:255',
			'description' => 'nullable|string|max:1000',
			'hide_street_address' => 'integer|max:1',
			'website' => 'nullable|string|max:255',
			'license_number' => 'nullable|string|max:255',
			'license_expiry_date' => 'nullable|date',
			'description' => 'required|string|max:1000',
		]);
		$vendor = Vendor::find($request->vendorid);
		$data = $request->all();

		// Set hide_street_address to 1 if checked, otherwise 0
		$data['hide_street_address'] = $request->has('hide_street_address') ? 1 : 0;

		// Update the vendor with the processed data
		$vendor->update($data);
		if(strtolower($vendor->vendor_type) == 'licensed'){
			$metadata = VendorLicenseMetadata::where('vendor_id', $vendor->id)->first();
			if (!$metadata) {
				$metadata = new VendorLicenseMetadata();
				$metadata->vendor_id = $vendor->id;
			}
			$metadata->license_number = $request->license_number ?? NULL;
			$metadata->license_expiry_date = $request->license_expiry_date ?? NULL;
			$metadata->save();
		}
		return redirect()->route('vendor-settings', ['vendorid' => $vendor->id])
			->with('property-success', 'Vendor details updated successfully.');
	}
	public function VendorSettingsBooking(Request $request)
	{
		$request->validate([
			'vendor_sub_category' => 'required|integer',
			'square_footage' => 'nullable|integer',
			'bedrooms' => 'nullable|integer',
			'sleeps' => 'nullable|integer|min:0',
			'beds' => 'nullable|integer|min:0',
			'washrooms' => 'nullable|integer'
		]);
		// Update the vendor record in the database
		$vendor = Vendor::find($request->vendorid);
		$vendor->update($request->only('vendor_sub_category'));
		$metdata = VendorAccommodationMetadata::where('vendor_id', $request->vendorid)->first();
		if (!$metdata) {
			$metdata = new VendorAccommodationMetadata();
			$metdata->vendor_id = $request->vendorid;
		}
		$metdata->square_footage = $request->square_footage;
		$metdata->bedrooms = $request->bedrooms;
		$metdata->sleeps = $request->sleeps;
		$metdata->beds = $request->beds;
		$metdata->washrooms = $request->washrooms;
		$metdata->save();
		// Redirect back with success message
		return redirect()->back()->with('booking-success', 'Vendor details updated successfully.');
	}
	public function updateVendorSocialMedia(Request $request)
	{
		$request->validate([
			'facebook' => 'nullable|string|max:255',
			'instagram' => 'nullable|string|max:255',
			'twitter' => 'nullable|string|max:255',
			'youtube' => 'nullable|string|max:255',
			'pinterest' => 'nullable|string|max:255',
			'tiktok' => 'nullable|string|max:255',
		]);

		$vendor = Vendor::find($request->vendorid);
		if ($vendor) {
			$vendor->socialMedia()->updateOrCreate(
				['vendor_id' => $request->vendorid],
				$request->only(['facebook', 'instagram', 'twitter', 'youtube', 'pinterest', 'tiktok'])
			);
			return redirect()->back()->with('social-media-success', 'Social media links updated successfully.');
		}
		return redirect()->back()->with('error', 'Vendor not found.');
	}

	public function getVendorPricing($vendorid)
	{
		$vendor = Vendor::find($vendorid);
		$currentDate = now();
		$season = SeasonHelper::getSeasonAndPrice($currentDate, $vendorid);
		return view('VendorDashboard.vendor-pricing', compact('vendor', 'season'));
	}

	public function updateVendorPricing(Request $request)
	{
		$request->validate([
			'spring' => 'nullable|string|max:255',
			'summer' => 'nullable|string|max:255',
			'fall' => 'nullable|string|max:255',
			'winter' => 'nullable|string|max:255',
			'special_price' => 'nullable|boolean',
			'special_price_value' => 'nullable|string|max:255',
			'current_rate' => 'nullable|numeric',
			'extension' => 'nullable|string',
		]);

		$vendor = Vendor::find($request->vendorid);
		if ($vendor) {
			$data = $request->only(['spring', 'summer', 'fall', 'winter', 'special_price', 'special_price_value', 'current_rate', 'extension']);

			// Set special_price to 0 if the checkbox is not present in the request
			$data['special_price'] = $request->has('special_price') ? 1 : 0;

			$vendor->pricing()->updateOrCreate(
				['vendor_id' => $request->vendorid],
				$data
			);

			return redirect()->back()->with('success', 'Pricing updated successfully.');
		}

		return redirect()->back()->with('error', 'Vendor not found.');
	}
	public function getBookingUtility($vendorid)
	{
		$vendor = Vendor::find($vendorid);
		if (!$vendor) {
			return redirect()->back()->with('error', 'Vendor not found.');
		}
		if (strtolower($vendor->vendor_type) === 'winery') {
			$vendor->load('wineryMetadata');
			$vendor->metadata = $vendor->wineryMetadata;
			unset($vendor->excursionMetadata);
		} elseif (strtolower($vendor->vendor_type) === 'excursion') {
			$vendor->load('excursionMetadata');
			$vendor->metadata = $vendor->excursionMetadata;
			unset($vendor->excursionMetadata);
		} elseif (strtolower($vendor->vendor_type) === 'accommodation') {
			$vendor->load('accommodationMetadata');
			$vendor->metadata = $vendor->accommodationMetadata;
			unset($vendor->accommodationMetadata);
		}
		$getRefundData = CmsPage::where('slug', 'refund-policy')->first();
		$getRefundContent = '';
		if ($getRefundData) {
			$getRefundContent = $getRefundData->description;
		}
		$stripeDetail = VendorStripeDetail::where('vendor_id', $vendorid)->count();
		return view('VendorDashboard.vendor-booking-utility', compact('vendor', 'stripeDetail', 'getRefundContent'));
	}

	public function updateVendorPolicy(Request $request)
	{
		$request->validate([
			// other validation rules
			'policy' => 'required|string|in:no-cancel,one-day,seven-day',
		]);

		$vendor = Vendor::find($request->vendorid);
		if ($vendor) {
			$vendor->policy = $request->policy;
			$vendor->save();
			return redirect()->back()->with('success', 'Vendor settings updated successfully.');
		} else {
			return redirect()->back()->with('error', 'Vendor not found.');
		}
	}
	public function updateVendorBookingUtility(Request $request)
	{
		$vendor = Vendor::find($request->vendorid);
		if (!$vendor) {
			return redirect()->back()->with('error', 'Vendor not found.');
		}
		$required_fields = [
			'process_type' => 'required|string|in:one-step,two-step,redirect-url',
			'redirect_url_type' => 'nullable|required_if:process_type,redirect-url|string|in:http://,https://',
			'redirect_url' => 'nullable|required_if:process_type,redirect-url',
			'applicable_taxes_amount' => 'nullable|required_if:apply_applicable_taxes,1|string|max:255',
			// 'checkin_end_time' => 'required|before:checkin_start_time',
		];
		if (strtolower($vendor->vendor_type) == 'accommodation') {
			$required_fields = array_merge($required_fields, [
				'checkin_start_time' => 'required',
				'checkout_time' => 'required',
				'security_deposit_amount' => 'nullable|required_if:apply_security_deposit,1|string|max:255',
				'cleaning_fee_amount' => 'nullable|required_if:apply_cleaning_fee,1|string|max:255',
				'pet_boarding' => 'nullable|required_if:apply_pet_boarding,1|string|max:255',
				'host' => 'nullable|string|max:255',
			]);
		}
		$request->validate($required_fields);

		$vendor->host = $request->host ?? null;
		$vendor->save();

		if (strtolower($vendor->vendor_type) == 'accommodation') {
			$metdata = VendorAccommodationMetadata::where('vendor_id', $request->vendorid)->first();
			if (!$metdata) {
				$metdata = new VendorAccommodationMetadata();
				$metdata->vendor_id = $request->vendorid;
			}
			$metdata->cleaning_fee_amount  =  $request->cleaning_fee_amount;
			$metdata->checkout_time = $request->checkout_time ?
				Carbon::createFromFormat('h:i A', $request->checkout_time)->format('H:i:s') : null;

			$metdata->checkin_start_time = $request->checkin_start_time ?
				Carbon::createFromFormat('h:i A', $request->checkin_start_time)->format('H:i:s') : null;

			$metdata->checkin_end_time = $request->checkin_end_time ?
				Carbon::createFromFormat('h:i A', $request->checkin_end_time)->format('H:i:s') : null;
			$metdata->pet_boarding = $request->pet_boarding;
			$metdata->booking_minimum  =  $request->booking_minimum;
			$metdata->booking_maximum  =  $request->booking_maximum;
			$metdata->security_deposit_amount  =  $request->security_deposit_amount;
		}

		if (strtolower($vendor->vendor_type) == 'excursion') {
			$metdata = VendorExcursionMetadata::where('vendor_id', $request->vendorid)->first();
			if (!$metdata) {
				$metdata = new VendorExcursionMetadata();
				$metdata->vendor_id = $request->vendorid;
			}
		}
		if (strtolower($vendor->vendor_type) == 'winery') {
			$metdata = VendorWineryMetadata::where('vendor_id', $request->vendorid)->first();
			
			$metdata->applicable_vendor_taxes_amount  =  $request->applicable_vendor_taxes_amount ?? null;
			if (!$metdata) {
				$metdata = new VendorWineryMetadata();
				$metdata->vendor_id = $request->vendorid;
			}
		}

		$metdata->process_type  =  $request->process_type;
		$metdata->redirect_url  =  $request->redirect_url_type . $request->redirect_url;
		$metdata->applicable_taxes_amount  =  $request->applicable_taxes_amount;

		// print_r($metdata); die;
		$metdata->save();

		return redirect()->back()->with('success-booking-utility', 'Vendor settings updated successfully.');
	}
	public function getReviewsTestimonial($vendorid)
	{
		$reviews = Review::with('customer')->where('vendor_id', $vendorid)->get();
		return view('VendorDashboard.reviews-testimonial', compact('reviews'));
	}

	public function getVendorMediaGallery($vendorid)
	{
		$vendor = Vendor::find($vendorid);
		$VendorMediaGallery = VendorMediaGallery::where('vendor_id', $vendorid)->get();
		return view('VendorDashboard.vendor-media-gallary', compact('vendor', 'VendorMediaGallery'));
	}
	public function uploadMedia(Request $request)
	{
		$vendor = Vendor::find($request->vendorid);
		$vendor_media_type = '';
		if ($request->vendorImage) {
			$vendor_media_type = 'image';
			list($type, $data) = explode(';', $request->vendorImage);
			list(, $data) = explode(',', $data);
			$data = base64_decode($data);

			// Generate a random filename
			$filename = Str::random(10) . '.png';

			// Create the vendor-specific directory if it doesn't exist
			$vendorDir = public_path('images/VendorImages/' . $vendor->short_code);
			if (!File::exists($vendorDir)) {
				File::makeDirectory($vendorDir, 0777, true, true);
			}

			// Save the image to the directory
			$filePath = $vendorDir . '/' . $filename;
			file_put_contents($filePath, $data);

			// Save the media information to the database
			$VendorMediaGallery = new VendorMediaGallery;
			$VendorMediaGallery->vendor_media = 'images/VendorImages/' . $vendor->short_code . '/' . $filename;
			$VendorMediaGallery->vendor_media_type = 'image';
			$VendorMediaGallery->vendor_id = $vendor->id;

			// Check if there are no existing media for this vendor
			$existingMediaCount = VendorMediaGallery::where('vendor_id', $vendor->id)->where('is_default', 1)->count();
			if ($existingMediaCount === 0) {
				$VendorMediaGallery->is_default = 1; // Make this the default image
			}

			$VendorMediaGallery->save();
		}
		if ($request->youtube_link) {
			$urlParts = parse_url($request->youtube_link);
			if (isset($urlParts['query'])) {
				parse_str($urlParts['query'], $query);
				$videolink = isset($query['v']) ? "https://www.youtube.com/embed/" . $query['v'] : $request->youtube_link;
			} else {
				$videolink = $request->youtube_link;
			}

			$vendor_media_type = 'youtube';
			$VendorMediaGallery = new VendorMediaGallery;
			$VendorMediaGallery->vendor_media = $videolink;
			$VendorMediaGallery->vendor_media_type = 'youtube';
			$VendorMediaGallery->vendor_id = $vendor->id;
			$VendorMediaGallery->save();
			$filePath = $videolink;
		}
		return response()->json(['status' => 'success', 'path' => $filePath, 'type' => $vendor_media_type, 'mediaid' => $VendorMediaGallery->id]);
	}
	public function uploadVendorLogo(Request $request)
	{
		$vendor = Vendor::find($request->vendorid);
		if ($request->vendorImage) {
			list($type, $data) = explode(';', $request->vendorImage);
			list(, $data) = explode(',', $data);
			$data = base64_decode($data);

			// Generate a random filename
			$filename = Str::random(10) . '.png';

			// Create the vendor-specific directory if it doesn't exist
			$vendorDir = public_path('images/VendorImages/' . $vendor->vendor_name);
			if (!File::exists($vendorDir)) {
				File::makeDirectory($vendorDir, 0777, true, true);
			}

			// Save the image to the directory
			$filePath = $vendorDir . '/' . $filename;
			file_put_contents($filePath, $data);

			// Save the media information to the database (optional)
			$vendor->vendor_media_logo = 'images/VendorImages/' . $vendor->vendor_name . '/' . $filename;
			$vendor->save();
		}
		return response()->json(['status' => 'success']);
	}
	public function deleteVendorLogo(Request $request)
	{
		$vendor = Vendor::find($request->vendorid);
		$filePath = public_path($vendor->vendor_media_logo);
		if (File::exists($filePath)) {
			File::delete($filePath);
		}
		$vendor->vendor_media_logo = '';
		$vendor->save();
		return response()->json(['status' => 'success']);
	}
	public function deleteVendorMedia(Request $request)
	{
		$media = VendorMediaGallery::findOrFail($request->mediaId);

		// Check if the image is the default
		if ($media->is_default) {
			return response()->json([
				'status' => 'error',
				'message' => 'Default media cannot be deleted. Please set another media as default before deleting this one.'
			], 400);
		}

		// Delete the file from the filesystem if it's an image
		if ($media->vendor_media_type == "image") {
			$filePath = public_path($media->vendor_media);
			if (File::exists($filePath)) {
				File::delete($filePath);
			}
		}

		// Delete the record from the database
		$media->delete();

		return response()->json(['status' => 'success']);
	}

	public function setDefaultMedia(Request $request, $vendorId)
	{
		// Validate the media ID
		$request->validate([
			'mediaId' => 'required|exists:vendor_media_galleries,id',
		]);

		// Find the media by ID
		$media = VendorMediaGallery::findOrFail($request->mediaId);

		// Ensure the media belongs to the vendor
		if ($media->vendor_id != $vendorId) {
			return response()->json(['status' => 'error', 'message' => 'Unauthorized action.'], 403);
		}

		if ($media->vendor_media_type == 'youtube') {
			return response()->json(['status' => 'error', 'message' => 'Video cannot be set as logo.'], 422);
		}

		// Reset all media is_default to 0 for this vendor
		VendorMediaGallery::where('vendor_id', $vendorId)->update(['is_default' => 0]);

		// Set the current media as default
		$media->is_default = 1;
		$media->save();

		return response()->json(['status' => 'success', 'message' => 'Media set as logo successfully.']);
	}

	public function getVendorDetails($vendorid)
	{
		// Find the vendor using the vendor ID
		$vendor = Vendor::find($vendorid);
		$usersCount = Customer::count();
		$mostCommonLocation = Customer::select('country', 'city', \DB::raw('COUNT(*) as user_count'))
			->whereNotNull('country') // Exclude NULL countries
			->where('country', '!=', '') // Exclude empty strings
			->whereNotNull('city') // Exclude NULL cities
			->where('city', '!=', '') // Exclude empty strings
			->groupBy('country', 'city')
			->orderByDesc('user_count')
			->first();
		$reviewData = Review::where('vendor_id', $vendorid)
			->where('review_status', 'approved')
			->selectRaw('COUNT(*) as review_count, AVG(rating) as average_rating')
			->first();
		// $hasActiveSubscription = WinerySubscription::where('vendor_id', $vendorid)
		// 	->where('status', 'active')
		// 	->where('end_date', '>', Carbon::now())
		// 	->exists();
		$VendorMediaGallery = VendorMediaGallery::where('vendor_id', $vendorid)->get();
		// return view('VendorDashboard.vendor-dashboard', compact('vendor', 'VendorMediaGallery', 'usersCount', 'mostCommonLocation', 'reviewData','hasActiveSubscription'));
		return view('VendorDashboard.vendor-dashboard', compact('vendor', 'VendorMediaGallery', 'usersCount', 'mostCommonLocation', 'reviewData'));

		// Check if vendor is not found
		if (!$vendor) {
			return redirect()->back()->with('error', 'Vendor not found.');
		}

		// Pass the vendor variable to the view
		return view('VendorDashboard.vendor-dashboard', compact('vendor'));
	}
	public function getManageDates(Request $request)
	{
		if ($request->ajax()) {
			$BookingDate = BookingDate::select(DB::raw('id, CONCAT(start_date, " - ", end_date) as date,booking_type,id, reason'))
				->where('vendor_id', $request->vendorid);
			if ($request->filterDateTypes != "All") {
				$BookingDate = $BookingDate->where('booking_type', $request->filterDateTypes);
			}
			return Datatables::of($BookingDate)
				->addColumn('action', function ($row) {
					$btn = '<a href="javascript:void(0)" class="delete-dates" data-id="' . $row->id . '"><i class="fa fa-trash" aria-hidden="true"></i</a>';
					return $btn;
				})
				->rawColumns(['action'])
				->make(true);
		}
	}
	public function ManageDatesDelete(Request $request)
	{
		if ($request->ajax()) {
			BookingDate::where('id', $request->bookingDateID)->delete();
			return response()->json(["status" => true]);
		}
	}
	public function vendorSocialMedia($vendorid)
	{
		$vendor = Vendor::find($vendorid);
		$Vendorsocial = VendorSocialMedia::where('vendor_id', $vendorid)->get();
		return view('VendorDashboard.vendor-social-media', compact('vendor', 'Vendorsocial'));
	}
	public function updateQuestionnaireMedia(Request $request)
	{
		// Custom validation logic
		$validator = Validator::make($request->all(), [
			'answer' => ['nullable', 'array', function ($attribute, $value, $fail) {
				foreach ($value as $questionId => $answer) {
					$questionnaire = Questionnaire::find($questionId);

					if (!$questionnaire) {
						continue; // Skip if the questionnaire is not found
					}

					// Handle validation based on question type
					if ($questionnaire->question_type === 'checkbox') {
						// Ensure checkbox answers are an array and at least one checkbox is selected
						// if (!is_array($answer) || count(array_filter($answer, 'strlen')) === 0) {
						// 	$fail('At least one answer must be provided for question ' . $questionId . '.');
						// }
					} elseif ($questionnaire->question_type === 'radio') {
						// Ensure radio answers are a non-empty string
						// if (strlen(trim($answer)) === 0) {
						// 	$fail('An answer must be provided for question ' . $questionId . '.');
						// }
					} else {
						// For text input or other types
						// if (strlen(trim($answer)) === 0) {
						// 	$fail('An answer must be provided for question ' . $questionId . '.');
						// }
					}
				}
			}],
			'answer.*' => ['nullable'],
			'answer.*.*' => ['string', 'nullable'],
		], [
			'answer.required' => 'At least one answer must be provided.',
			'answer.array' => 'Answers must be an array.',
			'answer.*.*' => 'Invalid answer format.',
		]);

		// Check if validation fails
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}

		// Retrieve validated data
		$validated = $validator->validated();

		foreach ($validated['answer'] as $questionnaireId => $answer) {
			// Retrieve the questionnaire to determine its type
			$questionnaire = Questionnaire::find($questionnaireId);

			if ($questionnaire) {
				if ($questionnaire->question_type === 'checkbox') {
					// For checkboxes, ensure that $answer is an array
					$value = is_array($answer) ? $answer : [];
					$jsonValue = json_encode($value);
					$value = $jsonValue;
				} else {
					// For other question types (e.g., radio buttons), handle accordingly
					$value = $answer;
				}

				// Convert the value to JSON format


				// Update or create the vendor questionnaire record
				VendorQuestionnaire::updateOrCreate(
					['vendor_id' => $request->vendorid, 'questionnaire_id' => $questionnaireId],
					['answer' => $value]
				);
			}
		}

		return redirect()->back()->with('questionnaire-success', 'Questionnaire updated successfully.');
	}
	public function VendorAmenitiesSave(Request $request)
	{
		$vendorId = $request->vendorid;
		$amenityId = $request->amenity_id;
		$status = $request->status ? 'active' : 'inactive';

		$vendorAmenity = VendorAmenity::updateOrCreate(
			['vendor_id' => $vendorId, 'amenity_id' => $amenityId],
			['status' => $status]
		);

		return response()->json(['success' => true, 'message' => 'Amenity status updated successfully.']);
	}
	public function manageVendorRooms(Request $request)
	{
		$vendor = Vendor::find($request->vendorid);
		$rooms = VendorRoom::where('vendor_id', $request->vendorid)->get();
		return view('VendorDashboard.vendor-manage-rooms', compact('vendor', 'rooms'));
	}
	public function manageVendorRoomsSave(Request $request)
	{
		// Validate the incoming request
		$validatedData = $request->validate([
			'room_style' => 'required|string',
			'room_price' => 'required|numeric',
			'inventory' => 'required|integer',
			'room_image' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048', // validate file type and size
		]);

		$vendor = Vendor::find($request->vendorid);

		// Handle the file upload
		if ($request->hasFile('room_image')) {
			// Get the file from the request
			$file = $request->file('room_image');

			// Define the file path
			// Create the vendor-specific directory if it doesn't exist
			$vendorDir = public_path('images/VendorImages/' . $vendor->vendor_name);
			if (!File::exists($vendorDir)) {
				File::makeDirectory($vendorDir, 0777, true, true);
			}

			// Generate a unique file name
			$fileName = time() . '_' . $file->getClientOriginalName();

			// Move the file to the specified path
			$file->move(public_path($vendorDir), $fileName);

			// Prepare the full path to store in the database
			$fileFullPath = 'images/VendorImages/' . $vendor->vendor_name . "/" . $fileName;
		} else {
			$fileFullPath = null; // Handle cases where file might not be uploaded (even if required)
		}

		// Save the data in the database
		$room = new VendorRoom(); // Assuming VendorRoom is your model for the vendor_rooms table
		$room->vendor_id = $request->vendorid; // Assuming vendor is the logged-in user
		$room->room_style = $request->room_style;
		$room->room_price = $request->room_price;
		$room->inventory = $request->inventory;
		$room->room_image = $fileFullPath; // Store the image path in the database
		$room->save();

		// Return a success response
		return response()->json(['success' => 'Room created successfully']);
	}
	public function deleteRoom(Request $request)
	{
		$room = VendorRoom::find($request->roomId);

		if ($room) {
			$room->delete();
			return response()->json(['success' => true]);
		}

		return response()->json(['success' => false]);
	}

	public function orders(Request $request)
	{
		$orders = Order::with('vendor')->where('vendor_id', $request->vendorid)->get();
		return view('VendorDashboard.my-transactions', compact('orders'));
	}

	public function orderDetail($id, $vendor_id)
	{
		$order = Order::with('orderTransactions')
			->where('id', $id)
			->first();
		$vendor = Vendor::find($vendor_id);
		return view('VendorDashboard.order-detail', compact('order', 'vendor'));
	}

	public function inquiries(Request $request)
	{
		$inquiries = Inquiry::with('vendor')
			->where('vendor_id', $request->vendorid)
			->orderBy('created_at', 'desc')
			->get();
		return view('VendorDashboard.my-inquiries', compact('inquiries'));
	}

	public function inquiryDetail($id, $vendor_id)
	{
		$inquiry = Inquiry::where('id', $id)
			->first();
		$vendor = Vendor::find($vendor_id);
		return view('VendorDashboard.inquiry-detail', compact('inquiry', 'vendor'));
	}

	// Approve the inquiry
	public function inquiryApprove($id)
	{
		$inquiry = Inquiry::find($id);

		if (!$inquiry) {
			return response()->json(['error' => 'Inquiry not found.'], 404);
		}

		// Fetch customer details
		$customer = Customer::find($inquiry->customer_id);
		$vendor = Vendor::find($inquiry->vendor_id);

		if (!$customer || empty($customer->email)) {
			return response()->json(['error' => 'Customer email not found.'], 404);
		}

		// Update the inquiry status to 'approved' (define status code accordingly, e.g., 1 for approved)
		$inquiry->inquiry_status = 1; // Assuming 1 is for "approved"
		$inquiry->apk = Str::uuid();
		$inquiry->save();
		// Send email to the customer
		Mail::to($customer->email)->send(new InquiryApprovedMail($inquiry, $vendor));

		return response()->json(['success' => true, 'message' => 'Inquiry approved successfully.']);
	}

	// Reject the inquiry
	public function inquiryReject($id)
	{
		$inquiry = Inquiry::find($id);

		if (!$inquiry) {
			return response()->json(['error' => 'Inquiry not found.'], 404);
		}

		$customer = Customer::find($inquiry->customer_id);
		$vendor = Vendor::find($inquiry->vendor_id);

		if (!$customer || empty($customer->email)) {
			return response()->json(['error' => 'Customer email not found.'], 404);
		}

		// Update the inquiry status to 'rejected' (define status code accordingly, e.g., 2 for rejected)
		$inquiry->inquiry_status = 2; // Assuming 2 is for "rejected"
		$inquiry->save();

		Mail::to($customer->email)->send(new InquiryRejectedMail($inquiry, $vendor));

		return response()->json(['success' => true, 'message' => 'Inquiry rejected successfully.']);
	}

	public function updateMetadata(Request $request, $vendorid)
	{
		// Find the vendor by ID
		$vendor = Vendor::findOrFail($vendorid);

		// Validate the request
		$request->validate([
			'vendor_sub_category' => 'required',
			'establishment' => 'sometimes|nullable',
			'tasting_options' => 'sometimes|nullable',
			'farming_practices' => 'sometimes|nullable',
			'max_group' => 'sometimes|nullable',
			'cuisines' => 'sometimes|array',
		]);

		// Update vendor general data
		$vendor->vendor_sub_category = $request->input('vendor_sub_category');
		$vendor->save();
		// Update metadata dynamically based on vendor type

		if (strtolower($vendor->vendor_type) == 'excursion') {
			$metadata = VendorExcursionMetadata::where('vendor_id', $vendorid)->first();
			if (!$metadata) {
				// Create new metadata if not found
				$metadata = new VendorExcursionMetadata();
				$metadata->vendor_id = $vendorid;
			}
			// Update metadata fields
			$metadata->establishment = $request->establishment;
			$metadata->farming_practices = $request->farming_practices;
			$metadata->max_group = $request->max_group;
			$metadata->cuisines = $request->cuisines ? json_encode($request->cuisines) : null; // Assuming cuisines is an array
			// Save the updated or new metadata
			$metadata->save();
		}

		if (strtolower($vendor->vendor_type) == 'winery') {
			$wineryMetadata = VendorWineryMetadata::where('vendor_id', $vendorid)->first();

			if (!$wineryMetadata) {
				// Create new winery metadata if not found
				$wineryMetadata = new VendorWineryMetadata();
				$wineryMetadata->vendor_id = $vendorid;
			}

			// Update winery metadata fields
			$wineryMetadata->tasting_options = $request->tasting_options;
			$wineryMetadata->farming_practices = $request->farming_practices;
			$wineryMetadata->max_group = $request->max_group;
			$wineryMetadata->cuisines = $request->cuisines ? json_encode($request->cuisines) : null; // Assuming cuisines is an array

			// Save the updated or new winery metadata
			$wineryMetadata->save();
		}

		if (strtolower($vendor->vendor_type) == 'licensed') {

			// Check if license metadata already exists
			$licenseMetadata = VendorLicenseMetadata::where('vendor_id', $vendorid)->first();

			if (!$licenseMetadata) {
				// Create new license metadata if not found
				$licenseMetadata = new VendorLicenseMetadata();
				$licenseMetadata->vendor_id = $vendorid;
			}

			// Update license metadata fields
			$licenseMetadata->farming_practices = $request->farming_practices;
			$licenseMetadata->max_group = $request->max_group;
			$licenseMetadata->cuisines = $request->cuisines ? json_encode($request->cuisines) : null; // Assuming cuisines is an array

			// Save the updated or new license metadata
			$licenseMetadata->save();
		}

		if (strtolower($vendor->vendor_type) == 'non-licensed') {
			// Check if non-license metadata already exists
			$nonLicenseMetadata = VendorNonLicenseMetadata::where('vendor_id', $vendorid)->first();

			if (!$nonLicenseMetadata) {
				// Create new non-license metadata if not found
				$nonLicenseMetadata = new VendorNonLicenseMetadata();
				$nonLicenseMetadata->vendor_id = $vendorid;
			}

			// Update non-license metadata fields
			$nonLicenseMetadata->farming_practices = $request->farming_practices;
			$nonLicenseMetadata->max_group = $request->max_group;
			$nonLicenseMetadata->cuisines = $request->cuisines ? json_encode($request->cuisines) : null; // Assuming cuisines is an array

			// Save the updated or new non-license metadata
			$nonLicenseMetadata->save();
		}

		// Save vendor


		return redirect()->route('vendor-settings', $vendorid)->with('success', 'Vendor updated successfully.');
	}

	public function userDetailsUpdate(Request $request, $vendorid)
	{
		// Validate the input data
		$request->validate([
			'firstname' => 'required|string|max:255',
			'lastname' => 'required|string|max:255',
			'contact_number' => 'required|string|max:15', // You can adjust max length as needed
		]);


		// Get the authenticated user's ID
		$user_id = Auth::user()->id;
		// echo $user_id; die;
		// Perform the update
		$updated = User::where('id', $user_id)->update([
			'firstname' => $request->firstname,
			'lastname' => $request->lastname,
			'contact_number' => $request->contact_number,
		]);


		// Check if the update was successful
		if ($updated) {
			// Optionally refresh the authenticated user instance
			$user = User::find($user_id);

			// Update the authenticated user instance in the session
			Auth::setUser($user);

			return redirect()->route('vendor-access-credentials', $vendorid)
				->with('success', 'User updated successfully.');
		}

		return redirect()->route('vendor-access-credentials', $vendorid)
			->with('error', 'User update failed.');
	}

	public function inventoryManagement(Request $request, $vendorid)
	{
		$publishedSeasons = PublishSeason::where('vendor_id', $vendorid)->get();
		return view('VendorDashboard.inventory-management', compact('publishedSeasons', 'vendorid'));
	}

	/**
	 * Normalize the address by:
	 * - Converting to lowercase
	 * - Removing special characters (commas, periods, etc.)
	 * - Splitting it into an array of words
	 */
	protected function normalizeAddress($address)
	{
		// Convert to lowercase, remove commas and periods, and split into words
		return array_filter(
			preg_split('/\s+/', strtolower(preg_replace('/[^a-zA-Z0-9\s]/', '', $address)))
		);
	}


	/**
	 * Compare two addresses by checking if they contain the same words,
	 * regardless of their order.
	 */
	protected function compareAddresses($address1, $address2)
	{
		// Compare both arrays of words, sorting them to avoid order issues
		sort($address1);
		sort($address2);

		return $address1 == $address2;
	}

	public function vendorFaqs($vendorid)
	{
		$vendor = Vendor::find($vendorid);
		$faqs = FaqSection::where('account_type', $vendor->vendor_type)->get();
		return view('VendorDashboard.vendor-faqs', compact('faqs', 'vendorid'));
	}

	public function changePassword(Request $request, $vendorid)
	{
		$user_id = Auth::guard('vendor')->user()->id;
		$user = User::find($user_id);
		$vendor = Vendor::find($vendorid);
		$hideSidebar = false;
		if ($user->password_updated == 0) {
			$hideSidebar = true;
		}
		return view('VendorDashboard.change-password', compact('vendor', 'user', 'hideSidebar'));
	}

	public function passwordUpdate(Request $request, $vendorid)
	{
		$user = User::find(Auth::user()->id);
		$req = [
			'new_password' => 'required|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[@$!%*#?&])[A-Za-z0-9@$!%*#?&]{8,}$/',
			'confirm_password' => 'required|min:8|same:new_password',
		];
		if ($request->has('old_password') || $user->password_updated > 0) {
			$req['old_password'] = 'required';
			$req['new_password'] = [
				'required',
				'min:8',
				'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[@$!%*#?&])[A-Za-z0-9@$!%*#?&]{8,}$/',
				function ($attribute, $value, $fail) use ($request) {
					if ($value === $request->old_password) {
						$fail('The new password must not match the old password.');
					}
				},
			];
		}
		$validator = Validator::make($request->all(), $req);

		// Check validation
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}

		// check old password
		if ($request->has('old_password')) {
			if (!Hash::check($request->old_password, $user->password)) {
				return response()->json(
					[
						'errors' => 'Old password is incorrect.'
					],
					500
				);
			}
		}
		try {
			// Find the vendor by ID
			$user = User::find(Auth::user()->id);

			// Hash the new password
			$user->password = Hash::make($request->new_password);

			// Mark the password as updated
			$user->password_updated = 1;

			// Save the updated vendor
			$user->save();

			return response()->json(
				[
					'message' => 'Password updated successfully.'
				],
				200
			);
		} catch (\Exception $e) {
			return response()->json(
				[
					'errors' => 'An error occurred while updating the password update.'
				],
				500
			);
		}
	}

	public function skipPassword($vendorid)
	{
		try {

			$user_id = Auth::user()->id;
			$user = User::find($user_id);
			if (!$user) {
				return response()->json(['message' => 'User not found.'], 404);
			}

			$user->password_updated = 2; // Set to 2 for skipping the process
			$user->save();

			return response()->json(
				[
					'message' => 'Password update skipped successfully.'
				],
				200
			);
		} catch (\Exception $e) {
			return response()->json(
				[
					'message' => 'An error occurred while skipping the password update.'
				],
				500
			);
		}
	}

	public function vendorReferrals($vendorid)
	{
		$referrals = Customer::where('guestrewards_vendor_id', $vendorid)->get();
		return view('VendorDashboard.vendor-referrals', compact('referrals'));
	}

	public function questionnaire($vendorid)
	{
		$vendor = Vendor::find($vendorid);
		$questionnaires = Questionnaire::with(['vendorQuestionnaires' => function ($query) use ($vendorid) {
			$query->where('vendor_id', $vendorid);
		}])
			->where(
				'vendor_type',
				'=',
				trim(strtolower($vendor->vendor_type))
			)
			->get();
		return view('VendorDashboard.questionnaire', compact('questionnaires', 'vendor'));
	}

	public function accessCredentials($vendorid)
	{
		$vendor = Vendor::find($vendorid);
		return view('VendorDashboard.access-credentials', compact('vendor'));
	}

	public function checkActivation(Request $request)
	{
		$vendorid = $request->vendorid; // ✅ Get vendor ID from request

		if (!$vendorid) {
			return response()->json([
				'success' => false,
				'message' => ['Vendor ID is required.'], // Return as an array
			], 400);
		}

		$vendor = Vendor::find($vendorid);
		if (strtolower($vendor->vendor_type) == 'accommodation') {
			$response = VendorHelper::canActivateSubscription($vendorid);
		} else if (strtolower($vendor->vendor_type) == 'winery') {
			$response = VendorHelper::canActivateWinerySubscription($vendorid);
		} else if (strtolower($vendor->vendor_type) == 'excursion') {
			$response = VendorHelper::canActivateExcursionSubscription($vendorid);
		} else {
			$response = ['status' => true];
			$vendor->account_status = 1;
			$vendor->save();
		}

		if (is_array($response['messages'])) {
			return response()->json([
				'success' => $response['status'],
				'message' => is_array($response['messages']) ? $response['messages'] : [$response['messages']],
			]);
		}

		// return response()->json([
		// 	'success' => false,
		// 	'message' => is_array($response['messages']) ? $response['messages'] : [$response['messages']],
		// ], 400);
	}
}
