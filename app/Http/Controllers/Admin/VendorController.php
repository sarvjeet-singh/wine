<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use App\Models\Vendor;
use App\Models\Country;
use App\Models\Region;
use App\Models\SubRegion;
use App\Models\InventoryType;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Establishment;
use App\Models\Cuisine;
use App\Models\FarmingPractice;
use App\Models\MaxGroup;
use App\Models\TastingOption;
use App\Models\PricePoint;
use App\Models\AccountStatus;
use App\Models\VendorAccommodationMetadata;
use App\Models\VendorExcursionMetadata;
use App\Models\VendorWineryMetadata;
use App\Models\VendorLicenseMetadata;
use App\Models\VendorNonLicenseMetadata;
use DB;
use Log;

use Validator;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\User;
use Illuminate\Validation\Rule;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        $query = Vendor::query();

        // Filter by vendor type
        if ($request->has('v') && !empty($request->v)) {
            $query->where('vendor_type', $request->v);
        }
    
        // Filter by search name
        if ($request->has('q') && !empty($request->q)) {
            $query->where('vendor_name', 'like', '%' . $request->q . '%');
        }
    
        // Get the filtered vendors
        $vendors = $query->orderBy('id', 'desc')->paginate(10);

        $total = $query->count();
        $categories = Category::where('status', 1)->get();
        return view('admin.vendors.index', compact('vendors', 'total', 'categories'));
    }

    public function create($type = 'accommodation')
    {
        $subregions = SubRegion::where(['status' => 1, 'region_id' => 1])->get();
        $get_catgeory_id = Category::where('slug', $type)->pluck('id')->first();
        $inventory_types = InventoryType::with('subCategories')->where(['category_id' => $get_catgeory_id])->get();
        $sub_categories = SubCategory::where('category_id', $get_catgeory_id)->get();
        $data = [
            'type' => $type,
            'form_route' => route('admin.vendors.store')
        ];
        if ($type == 'accommodation') {
            return view('admin.vendors.create-accommodation', $data);
        } else if ($type == 'winery') {
            return view('admin.vendors.create-winery', $data);
        } else if ($type == 'excursion') {
            return view('admin.vendors.create-excursion', $data);
        } else if ($type == 'licensed') {
            return view('admin.vendors.create-licensed', $data);
        } else if ($type == 'non-licensed') {
            return view('admin.vendors.create-non-licensed', $data);
        }
    }

    protected function validationRules($request, $action, $type, $vendorId = null)
    {
        $rules = [
            'vendor_name' => 'required|string|max:255',
            'street_address' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request, $vendorId) {
                    // Normalize the input address by cleaning and splitting it into words
                    $normalizedInputAddress = $this->normalizeAddress($value);

                    // Check if a property with the same name and similar address exists
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
            'unitsuite' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postalCode' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'region' => 'nullable|integer|min:1',
            'sub_region' => 'nullable|integer|min:1',
            'website' => 'nullable|string|max:255',
            'vendor_phone' => 'nullable|string|max:20',
            'vendor_email' => 'nullable|email|max:255',
            'vendor_first_name' => 'nullable|string|max:255',
            'vendor_last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:1000',
            'vendor_type' => 'required|string|max:255',
        ];

        // if ($action == 'store') {
        //     $rules = array_merge($rules, [
        //         'vendor_name' => 'required|string|max:255|unique:vendors,vendor_name',
        //     ]);
        // }

        // if ($action == 'update') {
        //     $rules = array_merge($rules, [
        //         'vendor_name' => [
        //             'required',
        //             'string',
        //             'max:255',
        //             Rule::unique('vendors', 'vendor_name')->ignore($vendorId),
        //         ],
        //     ]);
        // }

        if ($type == 'accommodation') {
            $rules = array_merge($rules, [
                'square_footage' => 'nullable|integer|min:1',
                'bedrooms' => 'nullable|integer|min:1',
                'washrooms' => 'nullable|integer|min:1',
                'beds' => 'nullable|integer|min:0',
                'sleeps' => 'nullable|integer|min:0',
                'inventory' => 'required|array', // Ensure it's an array
                'inventory.*' => 'required|integer|min:1',
            ]);
        } else if ($type == 'excursion') {
            $rules = array_merge($rules, [
                'vendor_sub_category' => 'required|numeric',
                'establishment' => 'nullable|numeric',
                'farming_practices' => 'nullable|numeric',
                'max_group' => 'nullable|numeric',
                'cuisines' => 'nullable|array',
            ]);
        } else if ($type == 'winery') {
            $rules = array_merge($rules, [
                'vendor_sub_category' => 'required|numeric',
                'tasting_options' => 'nullable|numeric',
                'farming_practices' => 'nullable|numeric',
                'max_group' => 'nullable|numeric',
                'cuisines' => 'nullable|array',
            ]);
        } else if ($type == 'licensed') {
            $rules = array_merge($rules, [
                'vendor_sub_category' => 'required|numeric',
                'farming_practices' => 'nullable|numeric',
                'max_group' => 'nullable|numeric',
                'cuisines' => 'nullable|array',
            ]);
        } else if ($type == 'non-licensed') {
            $rules = array_merge($rules, [
                'vendor_sub_category' => 'required|numeric',
                'farming_practices' => 'nullable|numeric',
                'max_group' => 'nullable|numeric',
                'cuisines' => 'nullable|array',
            ]);
        }
        return $rules;
    }

    protected function validationMessages($type)
    {
        $messages = [
            // General Vendor Information
            'vendor_name.required' => 'The business/vendor name is required.',
            'vendor_name.string' => 'The business/vendor name must be a string.',
            'vendor_name.max' => 'The business/vendor name must not exceed 255 characters.',
            'street_address.required' => 'The street address is required.',
            'street_address.string' => 'The street address must be a string.',
            'street_address.max' => 'The street address must not exceed 255 characters.',
            'unitsuite.max' => 'The unit/suite must not exceed 255 characters.',
            'city.required' => 'The city/town is required.',
            'city.string' => 'The city/town must be a string.',
            'city.max' => 'The city/town must not exceed 255 characters.',
            'province.required' => 'The province/state is required.',
            'province.string' => 'The province/state must be a string.',
            'province.max' => 'The province/state must not exceed 255 characters.',
            'postalCode.required' => 'The postal/zip code is required.',
            'postalCode.max' => 'The postal/zip code must not exceed 10 characters.',
            'country.required' => 'The country is required.',
            'country.string' => 'The country must be a string.',
            'country.max' => 'The country must not exceed 255 characters.',
            'sub_region.required' => 'The sub-region is required.',
            'website.max' => 'The website must not exceed 255 characters.',
            'vendor_phone.max' => 'The business/vendor phone must not exceed 20 characters.',
            'vendor_email.email' => 'The vendor email must be a valid email address.',
            'vendor_email.max' => 'The vendor email must not exceed 255 characters.',

            // Vendor Personal Information
            'vendor_first_name.required' => 'The vendor first name is required.',
            'vendor_first_name.string' => 'The vendor first name must be a string.',
            'vendor_first_name.max' => 'The vendor first name must not exceed 255 characters.',
            'vendor_last_name.required' => 'The vendor last name is required.',
            'vendor_last_name.string' => 'The vendor last name must be a string.',
            'vendor_last_name.max' => 'The vendor last name must not exceed 255 characters.',
            'email.required' => 'The email is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email must not exceed 255 characters.',
            'phone.required' => 'The phone is required.',
            'phone.string' => 'The phone must be a string.',
            'phone.max' => 'The phone must not exceed 20 characters.',
        ];

        // Accommodation-specific messages
        if ($type == 'accommodation') {
            $accommodationMessages = [
                'square_footage.required' => 'The square footage is required.',
                'square_footage.integer' => 'The square footage must be an integer.',
                'square_footage.min' => 'The square footage must be at least 1.',
                'bedrooms.required' => 'The bedrooms field is required.',
                'bedrooms.integer' => 'The bedrooms must be an integer.',
                'bedrooms.min' => 'The bedrooms must be at least 1.',
                'washrooms.required' => 'The washrooms field is required.',
                'washrooms.integer' => 'The washrooms must be an integer.',
                'washrooms.min' => 'The washrooms must be at least 1.',
                'beds.integer' => 'The beds must be an integer.',
                'beds.min' => 'The beds must be at least 0.',
                'sleeps.integer' => 'The sleeps field must be an integer.',
                'sleeps.min' => 'The sleeps must be at least 0.',
                'description.max' => 'The description must not exceed 1000 characters.',
                'inventory.required' => 'The inventory is required.',
                'inventory.array' => 'The inventory must be an array.',
                'inventory.*.required' => 'Each inventory item must be selected.',
                'inventory.*.integer' => 'Each inventory item must be an integer.',
            ];
            $messages = array_merge($messages, $accommodationMessages);
        }

        // Winery-specific messages
        if ($type == 'excursion') {
            $wineryMessages = [
                'vendor_sub_category.required' => 'The vendor sub-category is required.',
                'vendor_sub_category.numeric' => 'The vendor sub-category must be a number.',
                'establishment.required' => 'The year of establishment is required.',
                'establishment.numeric' => 'The year of establishment must be a number.',
                'farming_practices.numeric' => 'The farming practices must be a number.',
                'max_group.numeric' => 'The maximum group size must be a number.',
                'cuisines.array' => 'The cuisines must be an array.',
            ];
            $messages = array_merge($messages, $wineryMessages);
        }

        // Excursion-specific messages
        if ($type == 'winery') {
            $excursionMessages = [
                'vendor_sub_category.required' => 'The vendor sub-category is required.',
                'vendor_sub_category.numeric' => 'The vendor sub-category must be a number.',
                'tasting_options.required' => 'The tasting options are required.',
                'tasting_options.numeric' => 'The tasting options must be a number.',
                'farming_practices.numeric' => 'The farming practices must be a number.',
                'max_group.numeric' => 'The maximum group size must be a number.',
                'cuisines.array' => 'The cuisines must be an array.',
            ];
            $messages = array_merge($messages, $excursionMessages);
        }

        return $messages;
    }

    protected function prepareData($data, $action, $vendorId = null)
    {
        try {
            //$data = $this->validateRequest($request, $action, $request->vendor_type);
            // Ensure 'inventory' exists and is an array
            if (isset($data['inventory']) && is_array($data['inventory'])) {
                $data['inventory_type'] = key($data['inventory']);
                $data['vendor_sub_category'] = current($data['inventory']);
                unset($data['inventory']);
            }
            if (isset($data['cuisines']) && count($data['cuisines']) > 0) {
                $data['cuisines'] = json_encode($data['cuisines']);
            }
            DB::beginTransaction();
            $vendorData = [
                'vendor_name' => $data['vendor_name'],
                'vendor_email' => $data['vendor_email'],
                'street_address' => $data['street_address'],
                'unitsuite' => $data['unitsuite'] ?? null,
                'hide_street_address' => isset($data['hide_street_address']) ? true : false,
                'city' => $data['city'],
                'province' => $data['province'],
                'postalCode' => $data['postalCode'],
                'country' => $data['country'],
                'vendor_phone' => $data['vendor_phone'],
                'description' => $data['description'],
                'vendor_sub_category' => $data['vendor_sub_category'],
                'region' => $data['region'],
                'sub_region' => $data['sub_region'],
                'inventory_type' => $data['inventory_type'] ?? null,
                'vendor_type' => $data['vendor_type'],
                'website' => $data['website'] ?? null,
            ];

            if ($vendorId) {
                $vendor = Vendor::where('id', $vendorId)->first();
                $vendor->update($vendorData);
            } else {
                $vendor = Vendor::create($vendorData);
            }

            if ($vendor) {
                // Handle different vendor types
                if ($vendor->vendor_type == 'accommodation') {
                    $metadata = [
                        'vendor_id' => $vendor->id,
                        'square_footage' => $data['square_footage'] ?? null,
                        'bedrooms' => $data['bedrooms'] ?? null,
                        'washrooms' => $data['washrooms'] ?? null,
                        'sleeps' => $data['sleeps'] ?? null,
                        'beds' => $data['beds'] ?? null,
                    ];
                    if ($vendorId) {
                        unset($metadata['vendor_id']);
                        VendorAccommodationMetadata::where('vendor_id', $vendorId)->update($metadata);
                    } else {
                        VendorAccommodationMetadata::create($metadata);
                    }
                } else if ($vendor->vendor_type == 'winery') {
                    $metadata = [
                        'vendor_id' => $vendor->id,
                        'farming_practices' => $data['farming_practices'] ?? null,
                        'max_group' => $data['max_group'] ?? null,
                        'cuisines' => $data['cuisines'] ?? null,
                        'tasting_options' => $data['tasting_options'] ?? null,
                    ];
                    if ($vendorId) {
                        unset($metadata['vendor_id']);
                        VendorWineryMetadata::where('vendor_id', $vendorId)->update($metadata);
                    } else {
                        VendorWineryMetadata::create($metadata);
                    }
                } else if ($vendor->vendor_type == 'excursion') {
                    $metadata = [
                        'vendor_id' => $vendor->id,
                        'establishment' => $data['establishment'] ?? null,
                        'farming_practices' => $data['farming_practices'] ?? null,
                        'max_group' => $data['max_group'] ?? null,
                        'cuisines' => $data['cuisines'] ?? null,
                    ];
                    if ($vendorId) {
                        unset($metadata['vendor_id']);
                        VendorExcursionMetadata::where('vendor_id', $vendorId)->update($metadata);
                    } else {
                        VendorExcursionMetadata::create($metadata);
                    }
                } else if ($vendor->vendor_type == 'licensed') {
                    $metadata = [
                        'vendor_id' => $vendor->id,
                        'farming_practices' => $data['farming_practices'] ?? null,
                        'max_group' => $data['max_group'] ?? null,
                        'cuisines' => $data['cuisines'] ?? null,
                    ];
                    if ($vendorId) {
                        unset($metadata['vendor_id']);
                        VendorLicenseMetadata::where('vendor_id', $vendorId)->update($metadata);
                    } else {
                        VendorLicenseMetadata::create($metadata);
                    }
                } else if ($vendor->vendor_type == 'non-licensed') {
                    $metadata = [
                        'vendor_id' => $vendor->id,
                        'farming_practices' => $data['farming_practices'] ?? null,
                        'max_group' => $data['max_group'] ?? null,
                        'cuisines' => $data['cuisines'] ?? null,
                    ];
                    if ($vendorId) {
                        unset($metadata['vendor_id']);
                        VendorNonLicenseMetadata::where('vendor_id', $vendorId)->update($metadata);
                    } else {
                        VendorNonLicenseMetadata::create($metadata);
                    }
                }
            }

            // Generate QR Code
            $qrCodeData = route('vendorQCode.show', [
                'slug' => $vendor->id . '-' . $vendor->vendor_slug,
                'redirect' => "/register" // Replace 'register' with your desired redirect route
            ]);

            $qrCodePath = 'images/VendorQRCodes/' . $vendor->vendor_name . '-' . $vendor->id . '.png';

            QrCode::format('png')->size(200)->generate($qrCodeData, public_path($qrCodePath));

            // Save the QR code path to the vendor
            $vendor->qr_code = $qrCodePath;
            $vendor->save();

            // Check if email is provided and handle user creation
            if (!empty($data['email'])) {
                $user = User::where('email', $data['email'])->first();
                $password = null;

                if (empty($user)) {
                    $password = Str::random(8);
                    $user = User::create([
                        'email' => $data['email'],
                        'password' => Hash::make($password),
                        'firstname' => $data['vendor_first_name'],
                        'lastname' => $data['vendor_last_name'],
                        'contact_number' => $data['phone'],
                        'role' => 'vendor',
                    ]);
                } else {
                    $user->firstname = $data['vendor_first_name'];
                    $user->lastname = $data['vendor_last_name'];
                    $user->contact_number = $data['phone'];
                    $user->role = 'vendor';
                    $user->save();
                }

                // Associate vendor with the user
                $vendor->user_id = $user->id;
                $vendor->save();

                // Send email with credentials
                $to = $user->email;
                $subject = "Your new account credentials";
                $emailContent = View::make('AdminDashboard.emails.vendorlogin', ['user' => $user, 'password' => $password])->render();
                sendEmail($to, $subject, $emailContent);
            }

            // Commit the transaction if everything is successful
            DB::commit();
            return [true, 'Vendor details saved successfully!'];
        } catch (\Exception $e) {
            // Rollback the transaction if an error occurs
            DB::rollBack();

            // Log the exception for debugging purposes
            Log::error('Error creating vendor: ' . $e->getMessage());
            return [false, $e->getMessage()];
        }
    }

    public function store(Request $request)
    {
        // Create the validator
        $validator = Validator::make(
            $request->all(),
            $this->validationRules($request, 'store', $request->vendor_type),
            $this->validationMessages($request->vendor_type)
        );

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Return validated data
        $data = $validator->validated();
        list($saved, $message) = $this->prepareData($data, 'store', null);
        if ($saved) {
            // Create the vendor
            return redirect()->back()->with('success', '' . ucfirst($request->vendor_type) . ' details saved successfully!');
        } else {
            // Optionally return an error response or redirect back with an error message
            return redirect()->back()->with('error', 'Failed to save ' . $request->vendor_type . ' details. Please try again.' . $message)->withInput();
        }
    }

    public function show()
    {
        return view('admin.vendors.show');
    }

    public function edit($id)
    {
        $vendor = Vendor::with('user')->find($id);
        $type = strtolower(trim($vendor->vendor_type));
        $subregions = SubRegion::where(['status' => 1, 'region_id' => 1])->get();
        $get_catgeory_id = Category::where('slug', $type)->pluck('id')->first();
        $inventory_types = InventoryType::with('subCategories')->where(['category_id' => $get_catgeory_id])->get();
        $sub_categories = SubCategory::where('category_id', $get_catgeory_id)->get();
        $data = [
            'type' => $type,
            'vendor' => $vendor,
            'form_route' => route('admin.vendors.update', $id)
        ];

        if ($type == 'accommodation') {
            $vendor->metadata = $vendor->accommodationMetadata()->first();
        } else if ($type == 'winery') {
            $vendor->metadata = $vendor->wineryMetadata()->first();
        } else if ($type == 'excursion') {
            $vendor->metadata = $vendor->excursionMetadata()->first();
        } else if ($type == 'licensed') {
            $vendor->metadata = $vendor->licenseMetadata()->first();
        } else if ($type == 'non-licensed') {
            $vendor->metadata = $vendor->nonLicenseMetadata()->first();
        }

        return view("admin.vendors.create-$type", $data);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            $this->validationRules($request, 'update', $request->vendor_type, $id),
            $this->validationMessages($request->vendor_type)
        );

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Return validated data
        $data = $validator->validated();
        list($updated, $message) = $this->prepareData($data, 'update', $id);
        if ($updated) {
            // Create the vendor
            return redirect()->back()->with('success', '' . ucfirst($request->vendor_type) . ' details updated successfully!');
        } else {
            // Optionally return an error response or redirect back with an error message
            return redirect()->back()->with('error', 'Failed to update ' . $request->vendor_type . ' details. Please try again.', $message)->withInput();
        }
    }

    public function destroy()
    {
        return view('admin.vendor.destroy');
    }

    public function getUserByEmail(Request $request)
    {
        $email = $request->email;

        // Check if a vendor with this email exists
        $user = User::where('email', $email)->first();
        if ($user) {
            // Return all relevant fields if vendor exists
            return response()->json([
                'success' => true,
                'user' => [
                    'first_name' => $user->firstname,
                    'last_name' => $user->last_name,
                    'phone' => $user->contact_number,
                    'id' => $user->id
                ]
            ]);
        }

        // If no vendor is found, return an empty response
        return response()->json(['success' => false, 'message' => 'No user found']);
    }

    public function getEmailSuggestions(Request $request)
    {
        $term = $request->term;
        $emails = User::where('email', 'LIKE', '%' . $term . '%')->pluck('email');

        return response()->json($emails);
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

    public function filterSearch(Request $request)
    {
        // Get the search query
        $searchTerm = $request->input('query');
        $type = $request->input('type');

        // Search for vendors whose name matches the query
        $query = Vendor::where('vendor_name', 'LIKE', "%{$searchTerm}%");
        if(!empty($type)) {
            $query = $query->where('vendor_type', $type);
        }
        $vendors = $query->select('id', 'vendor_name as name')->limit(10)->get();

        // Return the results as JSON
        return response()->json($vendors);
    }

    public function accountStatus($id) {
        $vendor = Vendor::find($id);
        $accountStatuses = AccountStatus::where('status', 1)->get();
        $pricePoints = PricePoint::where('status', 1)->get();
        return view('admin.vendors.account-status', compact('vendor', 'accountStatuses', 'pricePoints'));
    }

    public function updateAccountStatus(Request $request, $id) {
        $vendor = Vendor::find($id);
        $vendor->account_status = $request->account_status;
        $vendor->price_point = $request->price_point;
        $vendor->save();
        return redirect()->back()->with('success', 'Account status updated successfully');
    }
}