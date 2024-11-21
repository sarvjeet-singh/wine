<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\VendorHour;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\PublishSeason;
use App\Models\BookingDate;
use App\Models\Experience;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Review;
use App\Models\SubRegion;
use App\Models\InventoryType;
use App\Models\SubCategory;
use App\Models\VendorAmenity;


use DB;
use Auth;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function createAccommodation()
    {
        $subRegions = SubRegion::where(
            [
                'region_id' => 1,
                'status' => 1
            ]
        )->get();
        $inventoryTypes = InventoryType::with('subCategories')->where(['category_id' => 1])->get();
        return view('AdminDashboard.create-accommodations', compact('subRegions', 'inventoryTypes'));
    }
    public function creatExcursion()
    {
        return view('AdminDashboard.create-excursion');
    }
    public function creatWinery()
    {
        return view('AdminDashboard.create-winery');
    }
    public function createLicensedVendor()
    {
        return view('AdminDashboard.create-licensed-vendor');
    }
    public function createNonLicensedVendor()
    {
        return view('AdminDashboard.create-non-licensed-vendor');
    }

    public function vendorEntity()
    {
        return view('AdminDashboard.vendor-entity');
    }




    public function saveAccommodation(Request $request)
    {
        $rules = [
            'vendor_name' => 'required|string|max:255',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postalCode' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'vendor_phone' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:1000',
            'bedrooms' => 'required|integer|min:1',
            'vendor_email' => 'nullable|email|max:255',
            'unitsuite' => 'nullable|string|max:255',
            'square_footage' => 'required|integer|min:1',
            'washrooms' => 'required|integer|min:1',
            'sleeps' => 'nullable|integer|min:0',
            'beds' => 'nullable|integer|min:0',
            'inventory_type' => 'required|string|max:255',
            'vendor_sub_category' => 'required|string|in:Hotel,Inn,Vacation Property (Entire Home),Service Apartment,Motel,B&B,Vacation Property (Guest House),Furnished Room',
            'sub_region' => 'required|string|in:Niagara Falls,Niagara-on-the-Lake,Niagara Escarpment/ Twenty Valley,Fort Erie/ Niagara South Coast,South Escarpment',
        ];

        $messages = [
            'vendor_name.required' => 'The business/vendor name is required.',
            'street_address.required' => 'The street address is required.',
            'city.required' => 'The city/town is required.',
            'province.required' => 'The province/state is required.',
            'postalCode.required' => 'The postal/zip is required.',
            'country.required' => 'The country is required.',
            'vendor_phone.required' => 'The business/vendor phone is required.',
            'description.required' => 'The description is required.',
            'bedrooms.required' => 'The bedrooms field is required.',
            'vendor_sub_category.required' => 'The accommodation type is required.',
            'sub_region.required' => 'The Sub Region is required.',
            'inventory_type' => 'The Inventory Type is required.',
            // other custom messages
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $vendor = Vendor::create([
            'vendor_name' => $request->vendor_name,
            'vendor_email' => $request->vendor_email,
            'street_address' => $request->street_address,
            'unitsuite' => $request->unitsuite,
            'hide_street_address' => $request->hide_street_address ? true : false,
            'city' => $request->city,
            'province' => $request->province,
            'postalCode' => $request->postalCode,
            'country' => $request->country,
            'vendor_phone' => $request->vendor_phone,
            'description' => $request->description,
            'vendor_sub_category' => $request->vendor_sub_category,
            'square_footage' => $request->square_footage,
            'bedrooms' => $request->bedrooms,
            'washrooms' => $request->washrooms,
            'sleeps' => $request->sleeps,
            'beds' => $request->beds,
            'sub_region' => $request->sub_region,
            'inventory_type' => $request->inventory_type,
            'vendor_type' => 'Accommodation',
        ]);

        // Generate QR Code
        $qrCodeData = route('vendorQCode.show', [
            'slug' => $vendor->vendor_slug,
            'redirect' => "/register" // Replace 'register' with your desired redirect route
        ]);

        $qrCodePath = 'images/VendorQRCodes/' . $vendor->vendor_name . '-' . $vendor->id . '.png';

        QrCode::format('png')->size(200)->generate($qrCodeData, public_path($qrCodePath));

        // Save the QR code path to the vendor
        $vendor->qr_code = $qrCodePath;
        $vendor->save();

        if ($request->filled('vendor_email')) {
            $password = Str::random(8);

            $user = User::create([
                'name' => $request->vendor_name,
                'email' => $request->vendor_email,
                'lastname' => $request->vendor_last_name,
                'firstname' => $request->vendor_first_name,
                'password' => Hash::make($password),
                'role' => 'Vendor'
            ]);

            $vendor = Vendor::find($vendor->id);
            $vendor->user_id = $user->id;
            $vendor->save();

            $to = $user->email;
            $subject = "Your new account credentials";
            $emailContent = View::make('AdminDashboard.emails.vendorlogin', ['user' => $user, 'password' => $password])->render();
            sendEmail($to, $subject, $emailContent);
        }
        return redirect()->back()->with('success', 'Accommodation details saved successfully!');
    }


    public function saveExcursion(Request $request)
    {
        $rules = [
            'vendor_name' => 'required|string|max:255',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postalCode' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'vendor_phone' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:1000',
            'vendor_email' => 'nullable|email|max:255',
            'unitsuite' => 'nullable|string|max:255',
            'washrooms' => 'nullable|integer|min:1',
            'sleeps' => 'nullable|integer|min:1',
            'sub_region' => 'required|string|in:Niagara Falls,Niagara-on-the-Lake,Niagara Escarpment/ Twenty Valley,Fort Erie/ Niagara South Coast,South Escarpment',
            'vendor_sub_category' => 'required|string|in:Arts/Culture,Adult Entertainment,Culinary,Sports & Adventuring,Family Entertainment,Thrill Seeking&B',
            'establishment_facility' => 'nullable|string|in:Restaurant,Bar / Pub,Brew Pub,Café / Diner,Food Truck,Farm / Market,Lounge / Night Club,Theatre / Venue,Public Park,Golf & Country Club',
        ];

        $messages = [
            'vendor_name.required' => 'The business/vendor name is required.',
            'street_address.required' => 'The street address is required.',
            'city.required' => 'The city/town is required.',
            'province.required' => 'The province/state is required.',
            'postalCode.required' => 'The postal/zip is required.',
            'country.required' => 'The country is required.',
            'vendor_phone.required' => 'The business/vendor phone is required.',
            'description.required' => 'The description is required.',
            'bedrooms.required' => 'The bedrooms field is required.',
            'sub_region.required' => 'The Sub Region is required.',
            'vendor_sub_category.required' => 'The Excursion Type is required.',
            'establishment_facility.required' => 'The Establishment/Facility Type is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $vendor = Vendor::create([
            'vendor_name' => $request->vendor_name,
            'vendor_email' => $request->vendor_email,
            'street_address' => $request->street_address,
            'unitsuite' => $request->unitsuite,
            'hide_street_address' => $request->hide_street_address ? true : false,
            'city' => $request->city,
            'province' => $request->province,
            'postalCode' => $request->postalCode,
            'country' => $request->country,
            'vendor_phone' => $request->vendor_phone,
            'description' => $request->description,
            'sub_region' => $request->sub_region,
            'vendor_sub_category' => $request->vendor_sub_category,
            'establishment_facility' => $request->establishment_facility, // Saving establishment_facility
            'square_footage' => $request->square_footage,
            'bedrooms' => $request->bedrooms,
            'washrooms' => $request->washrooms,
            'sleeps' => $request->sleeps,
            'vendor_type' => 'Excursion',
        ]);

        // Generate QR Code
        $qrCodeData = route('vendorQCode.show', [
            'slug' => $vendor->vendor_slug,
            'redirect' => "/register" // Replace 'register' with your desired redirect route
        ]);

        $qrCodePath = 'images/VendorQRCodes/' . $vendor->vendor_name . '-' . $vendor->id . '.png';

        QrCode::format('png')->size(200)->generate($qrCodeData, public_path($qrCodePath));

        // Save the QR code path to the vendor
        $vendor->qr_code = $qrCodePath;
        $vendor->save();

        if ($request->filled('vendor_email')) {
            $password = Str::random(8);

            $user = User::create([
                'name' => $request->vendor_name,
                'email' => $request->vendor_email,
                'lastname' => $request->vendor_last_name,
                'firstname' => $request->vendor_first_name,
                'password' => Hash::make($password),
                'role' => 'Vendor'
            ]);

            $vendor->user_id = $user->id;
            $vendor->save();

            Mail::send('AdminDashboard.emails.vendorlogin', ['user' => $user, 'password' => $password], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Your new account credentials');
            });
        }

        return redirect()->back()->with('success', 'Excursion details saved successfully!');
    }

    public function saveWinery(Request $request)
    {
        $rules = [
            'vendor_name' => 'required|string|max:255',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postalCode' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'vendor_phone' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:1000',
            // 'bedrooms' => 'required|integer|min:1',
            'vendor_email' => 'nullable|email|max:255',
            'unitsuite' => 'nullable|string|max:255',
            'washrooms' => 'nullable|integer|min:1',
            'sleeps' => 'nullable|integer|min:1',
            'sub_region' => 'required|string|in:Niagara Falls,Niagara-on-the-Lake,Niagara Escarpment/ Twenty Valley,Fort Erie/ Niagara South Coast,South Escarpment',
            'vendor_sub_category' => 'required|string|in:Destination,Vineyard,Cellar,Farm,Micro / Urban',
            'tasting_options' => 'required|string|in:Appointment Only,Drop-Ins Welcome,Reservations Recommended,Not Offered',
        ];

        $messages = [
            'vendor_name.required' => 'The business/vendor name is required.',
            'street_address.required' => 'The street address is required.',
            'city.required' => 'The city/town is required.',
            'province.required' => 'The province/state is required.',
            'postalCode.required' => 'The postal/zip is required.',
            'country.required' => 'The country is required.',
            'vendor_phone.required' => 'The business/vendor phone is required.',
            'description.required' => 'The description is required.',
            'bedrooms.required' => 'The bedrooms field is required.',
            'vendor_sub_category.required' => 'The accommodation type is required.',
            'sub_region.required' => 'The Sub Region is required.',
            // other custom messages
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $vendor = Vendor::create([
            'vendor_name' => $request->vendor_name,
            'vendor_email' => $request->vendor_email,
            'street_address' => $request->street_address,
            'unitsuite' => $request->unitsuite,
            'hide_street_address' => $request->hide_street_address ? true : false,
            'city' => $request->city,
            'province' => $request->province,
            'postalCode' => $request->postalCode,
            'country' => $request->country,
            'vendor_phone' => $request->vendor_phone,
            'description' => $request->description,
            'sub_region' => $request->sub_region,
            'vendor_sub_category' => $request->vendor_sub_category,
            'tasting_options' => $request->tasting_options,
            'bedrooms' => $request->bedrooms,
            'washrooms' => $request->washrooms,
            'sleeps' => $request->sleeps,
            'vendor_type' => 'Winery',
        ]);

        // Generate QR Code
        $qrCodeData = route('vendorQCode.show', [
            'slug' => $vendor->vendor_slug,
            'redirect' => "/register" // Replace 'register' with your desired redirect route
        ]);

        $qrCodePath = 'images/VendorQRCodes/' . $vendor->vendor_name . '-' . $vendor->id . '.png';

        QrCode::format('png')->size(200)->generate($qrCodeData, public_path($qrCodePath));

        // Save the QR code path to the vendor
        $vendor->qr_code = $qrCodePath;
        $vendor->save();

        if ($request->filled('vendor_email')) {
            $password = Str::random(8);

            $user = User::create([
                'name' => $request->vendor_name,
                'email' => $request->vendor_email,
                'lastname' => $request->vendor_last_name,
                'firstname' => $request->vendor_first_name,
                'password' => Hash::make($password),
                'role' => 'Vendor'
            ]);

            $vendor->user_id = $user->id;
            $vendor->save();

            Mail::send('AdminDashboard.emails.vendorlogin', ['user' => $user, 'password' => $password], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Your new account credentials');
            });
        }

        return redirect()->back()->with('success', 'Winery details saved successfully!');
    }
    public function LicensedVendor(Request $request)
    {
        $rules = [
            'vendor_name' => 'required|string|max:255',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postalCode' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'vendor_phone' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:1000',
            'vendor_email' => 'nullable|email|max:255',
            'unitsuite' => 'nullable|string|max:255',
            'washrooms' => 'nullable|integer|min:1',
            'sleeps' => 'nullable|integer|min:1',
            'sub_region' => 'nullable|string|in:Niagara Falls,Niagara-on-the-Lake,Niagara Escarpment/ Twenty Valley,Fort Erie/ Niagara South Coast,South Escarpment',
            'vendor_sub_category' => 'required|string|in:Restaurant [Culinary],Bar / Pub [Culinary],Brew Pub [Culinary],Lounge / Night Club [Adult Entertainment],Theatre / Venue,Golf & Country Club [Sport & Adventure]',
            'excursion_sub_category' => 'nullable|string|in:Arts/Culture,Culinary,Family Fun (Entertainment),Adult Entertainment,Sport & Adventure,Thrill Seeking',
            'cuisines' => 'nullable|array',
            'cuisines.*' => 'string|distinct',
            'monday_open' => 'nullable|string|max:10',
            'monday_close' => 'nullable|string|max:10',
            'tuesday_open' => 'nullable|string|max:10',
            'tuesday_close' => 'nullable|string|max:10',
            'wednesday_open' => 'nullable|string|max:10',
            'wednesday_close' => 'nullable|string|max:10',
            'thursday_open' => 'nullable|string|max:10',
            'thursday_close' => 'nullable|string|max:10',
            'friday_open' => 'nullable|string|max:10',
            'friday_close' => 'nullable|string|max:10',
            'saturday_open' => 'nullable|string|max:10',
            'saturday_close' => 'nullable|string|max:10',
            'sunday_open' => 'nullable|string|max:10',
            'sunday_close' => 'nullable|string|max:10',
        ];

        $messages = [
            'vendor_name.required' => 'The business/vendor name is required.',
            'street_address.required' => 'The street address is required.',
            'city.required' => 'The city/town is required.',
            'province.required' => 'The province/state is required.',
            'postalCode.required' => 'The postal/zip is required.',
            'country.required' => 'The country is required.',
            'vendor_phone.required' => 'The business/vendor phone is required.',
            'description.required' => 'The description is required.',
            'vendor_sub_category.required' => 'The Licensed Vendor type is required.',
            'sub_region.required' => 'The Sub Region is required.',
            // other custom messages
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Concatenate `excursion_sub_category` and `vendor_sub_category`
        $subCategory = trim(implode(', ', array_filter([
            $request->vendor_sub_category,
            $request->excursion_sub_category
        ])));

        $vendor = Vendor::create([
            'vendor_name' => $request->vendor_name,
            'vendor_email' => $request->vendor_email,
            'street_address' => $request->street_address,
            'unitsuite' => $request->unitsuite,
            'hide_street_address' => $request->hide_street_address ? true : false,
            'city' => $request->city,
            'province' => $request->province,
            'postalCode' => $request->postalCode,
            'country' => $request->country,
            'vendor_phone' => $request->vendor_phone,
            'description' => $request->description,
            'sub_region' => $request->sub_region,
            'vendor_sub_category' => $subCategory, // Save the concatenated sub-categories
            'bedrooms' => $request->bedrooms,
            'washrooms' => $request->washrooms,
            'sleeps' => $request->sleeps,
            'cuisines' => $request->cuisines ? json_encode($request->cuisines) : null,
            'vendor_type' => 'Licensed',
        ]);

        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        foreach ($days as $day) {
            VendorHour::create([
                'vendor_id' => $vendor->id,
                'day' => $day,
                'open_time' => $request->input("{$day}_open"),
                'close_time' => $request->input("{$day}_close"),
            ]);
        }

        // Generate QR Code
        $qrCodeData = route('vendorQCode.show', [
            'slug' => $vendor->vendor_slug,
            'redirect' => "/register" // Replace 'register' with your desired redirect route
        ]);

        $qrCodePath = 'images/VendorQRCodes/' . $vendor->vendor_name . '-' . $vendor->id . '.png';

        QrCode::format('png')->size(200)->generate($qrCodeData, public_path($qrCodePath));

        // Save the QR code path to the vendor
        $vendor->qr_code = $qrCodePath;
        $vendor->save();

        if ($request->filled('vendor_email')) {
            $password = Str::random(8);

            $user = User::create([
                'name' => $request->vendor_name,
                'email' => $request->vendor_email,
                'lastname' => $request->vendor_last_name,
                'firstname' => $request->vendor_first_name,
                'password' => Hash::make($password),
                'role' => 'Vendor'
            ]);

            $vendor->user_id = $user->id;
            $vendor->save();

            Mail::send('AdminDashboard.emails.vendorlogin', ['user' => $user, 'password' => $password], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Your new account credentials');
            });
        }

        return redirect()->back()->with('success', 'Licensed Vendor details saved successfully!');
    }

    public function nonLicensedVendor(Request $request)
    {
        $rules = [
            'vendor_name' => 'required|string|max:255',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postalCode' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'vendor_phone' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:1000',
            // 'bedrooms' => 'required|integer|min:1',
            'vendor_email' => 'nullable|email|max:255',
            'unitsuite' => 'nullable|string|max:255',
            'washrooms' => 'nullable|integer|min:1',
            'sleeps' => 'nullable|integer|min:1',
            'sub_region' => 'nullable|string|in:Niagara Falls,Niagara-on-the-Lake,Niagara Escarpment/ Twenty Valley,Fort Erie/ Niagara South Coast,South Escarpment',
            'vendor_sub_category' => 'required|string|in:Food Truck [Culinary],Café / Diner [Culinary],Farm / Market [Culinary],Public Health,Personal Care & Fitness,Public Parks [Family],Miscellaneous',
            'excursion_sub_category' => 'nullable|string|in:Arts/Culture,Culinary,Family Fun (Entertainment),Adult Entertainment,Sport & Adventure,Thrill Seeking',
            'cuisines' => 'nullable|array',
            'cuisines.*' => 'string|distinct',
            'monday_open' => 'nullable|string|max:10',
            'monday_close' => 'nullable|string|max:10',
            'tuesday_open' => 'nullable|string|max:10',
            'tuesday_close' => 'nullable|string|max:10',
            'wednesday_open' => 'nullable|string|max:10',
            'wednesday_close' => 'nullable|string|max:10',
            'thursday_open' => 'nullable|string|max:10',
            'thursday_close' => 'nullable|string|max:10',
            'friday_open' => 'nullable|string|max:10',
            'friday_close' => 'nullable|string|max:10',
            'saturday_open' => 'nullable|string|max:10',
            'saturday_close' => 'nullable|string|max:10',
            'sunday_open' => 'nullable|string|max:10',
            'sunday_close' => 'nullable|string|max:10',
            'public_amenities' => 'nullable|array',
            'public_amenities.*' => 'string|distinct',
        ];

        $messages = [
            'vendor_name.required' => 'The business/vendor name is required.',
            'street_address.required' => 'The street address is required.',
            'city.required' => 'The city/town is required.',
            'province.required' => 'The province/state is required.',
            'postalCode.required' => 'The postal/zip is required.',
            'country.required' => 'The country is required.',
            'vendor_phone.required' => 'The business/vendor phone is required.',
            'description.required' => 'The description is required.',
            'vendor_sub_category.required' => 'The Non-Licensed Vendor type is required.',
            'sub_region.required' => 'The Sub Region is required.',
            // other custom messages
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Concatenate `excursion_sub_category` and `vendor_sub_category`
        $subCategory = trim(implode(', ', array_filter([
            $request->vendor_sub_category,
            $request->excursion_sub_category
        ])));

        $vendor = Vendor::create([
            // Other attributes
            'vendor_name' => $request->vendor_name,
            'vendor_email' => $request->vendor_email,
            'street_address' => $request->street_address,
            'unitsuite' => $request->unitsuite,
            'hide_street_address' => $request->hide_street_address ? true : false,
            'city' => $request->city,
            'province' => $request->province,
            'postalCode' => $request->postalCode,
            'country' => $request->country,
            'vendor_phone' => $request->vendor_phone,
            'description' => $request->description,
            'sub_region' => $request->sub_region,
            'vendor_sub_category' => $subCategory,
            'bedrooms' => $request->bedrooms,
            'washrooms' => $request->washrooms,
            'sleeps' => $request->sleeps,
            'cuisines' => $request->cuisines ? json_encode($request->cuisines) : null,
            'vendor_type' => 'Non-Licensed',
        ]);

        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        foreach ($days as $day) {
            VendorHour::create([
                'vendor_id' => $vendor->id,
                'day' => $day,
                'open_time' => $request->input("{$day}_open"),
                'close_time' => $request->input("{$day}_close"),
            ]);
        }

        // Handle public_amenities
        $publicAmenities = $request->input('public_amenities', []);
        if (!empty($publicAmenities)) {
            VendorAmenity::create([
                'vendor_id' => $vendor->id,
                'public_amenities' => $publicAmenities, // Store as JSON
            ]);
        }

        // Generate QR Code
        $qrCodeData = route('vendorQCode.show', [
            'slug' => $vendor->vendor_slug,
            'redirect' => "/register" // Replace 'register' with your desired redirect route
        ]);

        $qrCodePath = 'images/VendorQRCodes/' . $vendor->vendor_name . '-' . $vendor->id . '.png';

        QrCode::format('png')->size(200)->generate($qrCodeData, public_path($qrCodePath));

        // Save the QR code path to the vendor
        $vendor->qr_code = $qrCodePath;
        $vendor->save();

        if ($request->filled('vendor_email')) {
            $password = Str::random(8);

            $user = User::create([
                'name' => $request->vendor_name,
                'email' => $request->vendor_email,
                'lastname' => $request->vendor_last_name,
                'firstname' => $request->vendor_first_name,
                'password' => Hash::make($password),
                'role' => 'Vendor'
            ]);

            $vendor->user_id = $user->id;
            $vendor->save();

            Mail::send('AdminDashboard.emails.vendorlogin', ['user' => $user, 'password' => $password], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Your new account credentials');
            });
        }

        return redirect()->back()->with('success', 'Non-Licensed Vendor details saved successfully!');
    }
}
