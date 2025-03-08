<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use App\Mail\VendorMail;
use App\Models\Vendor;
use App\Models\VendorAmenity;
use App\Models\Amenity;
use App\Models\Country;
use App\Models\Region;
use App\Models\SubRegion;
use App\Models\InventoryType;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Establishment;
use App\Models\Cuisine;
use App\Models\Experience;
use App\Models\FarmingPractice;
use App\Models\MaxGroup;
use App\Models\Order;
use App\Models\TastingOption;
use App\Models\PricePoint;
use App\Models\AccountStatus;
use App\Models\VendorAccommodationMetadata;
use App\Models\VendorExcursionMetadata;
use App\Models\VendorWineryMetadata;
use App\Models\VendorLicenseMetadata;
use App\Models\VendorNonLicenseMetadata;
use App\Models\Questionnaire;
use App\Models\VendorQuestionnaire;
use App\Models\VendorMediaGallery;
use App\Models\VendorWine;
use App\Models\Inquiry;
use App\Models\WinerySubscription;
use Intervention\Image\Facades\Image;
use DB;
use Log;
use Mail;
use Validator;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\User;
use App\Models\VendorFileUpload;
use App\Models\VendorSocialMedia;
use App\Models\VendorStripeDetail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

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
            'custom_password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&#]).{8,}$/'
            ],
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
                'short_code' => $vendor->short_code,
                'redirect' => "register" // Replace 'register' with your desired redirect route
            ]);

            $qrCodePath = 'images/VendorQRCodes/' . $vendor->vendor_name . '-' . $vendor->short_code . '.png';

            // QrCode::format('png')->size(200)->generate($qrCodeData, public_path($qrCodePath));
            $qrCode = QrCode::format('png')
                ->size(350) // Set the size of the QR code
                ->margin(1) // Add some margin around the QR code
                ->generate($qrCodeData);

            $qrCodeTempPath = 'images/VendorQRCodes/' . $vendor->vendor_name . '-' . $vendor->short_code . '_temp.png';
            $qrCodeTempPath = public_path($qrCodeTempPath);
            file_put_contents($qrCodeTempPath, $qrCode);

            // Load the QR code image
            $qrCodeImage = Image::make($qrCodeTempPath);

            // Prepare the circular background with the logo
            $logoPath = public_path('images/logo-leaf.png');
            if (file_exists($logoPath)) {
                $logo = Image::make($logoPath)->resize(65, 65); // Resize the logo
                // Add the circular canvas with the logo to the center of the QR code
                $qrCodeImage->insert($logo, 'center');
            }

            // Save the final QR code with the logo
            $qrCodeImage->save(public_path($qrCodePath));

            // Clean up the temporary file
            unlink($qrCodeTempPath);


            // Save the QR code path to the vendor
            $vendor->qr_code = $qrCodePath;
            $vendor->save();

            // Check if email is provided and handle user creation
            if (!empty($data['email'])) {
                $user = User::where('email', $data['email'])->first();
                $password = null;

                if (empty($user)) {
                    $password = $data['custom_password'] ?? Str::random(8);
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
                    // $user->password = $data['custom_password'] ?? Hash::make($password);
                    $user->role = 'vendor';
                    $user->save();
                }

                // Associate vendor with the user
                $vendor->user_id = $user->id;
                $vendor->save();

                // Send email with credentials
                $to = $user->email;
                $subject = "Your new account credentials";

                $vendorData = [
                    'user' => $user,
                    'password' => $password,
                    'vendor' => $vendor
                ];
                $send = Mail::to($to)->send(new VendorMail($vendorData, 'emails.vendor.vendor_login_details_email', $subject));
                $send = Mail::to(env('ADMIN_EMAIL'))->send(new VendorMail($vendorData, 'emails.vendor.vendor_login_details_email', $subject));
                $moderatorEmail = env('MODERATOR_EMAIL');

                if (!empty($moderatorEmail)) {
                    Mail::to($moderatorEmail)->send(new VendorMail($vendorData, 'emails.vendor.vendor_login_details_email', $subject));
                }
                if ($send) {
                    $vendor->email_sent_at = \Carbon\Carbon::now();
                    $vendor->save();
                }
                // if ($vendor->vendor_type == 'winery') {
                //     Mail::to($to)->send(new VendorMail($vendorData, 'emails.vendor.winery_vendor_login_details_email', $subject));
                // } else if ($vendor->vendor_type == 'licensed' || $vendor->vendor_type == 'non-licensed') {
                //     Mail::to($to)->send(new VendorMail($vendorData, 'emails.vendor.support_local_vendor_login_details_email', $subject));
                // } else {
                //     $emailContent = View::make('AdminDashboard.emails.vendorlogin', ['user' => $user, 'password' => $password])->render();
                //     sendEmail($to, $subject, $emailContent);
                // }
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

    public function getUploadedFiles($vendor_id)
    {
        $vendor = Vendor::find($vendor_id);
        $files = VendorFileUpload::where('vendor_id', $vendor_id)
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('admin.vendors.uploaded-files', compact('vendor', 'files'));
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
        if (!empty($type)) {
            $query = $query->where('vendor_type', $type);
        }
        $vendors = $query->select('id', 'vendor_name as name')->limit(10)->get();

        // Return the results as JSON
        return response()->json($vendors);
    }

    // public function accountStatus($id)
    // {
    //     $vendor = Vendor::find($id);
    //     $accountStatuses = AccountStatus::where('status', 1)->get();
    //     $pricePoints = PricePoint::where('status', 1)->get();
    //     return view('admin.vendors.account-status', compact('vendor', 'accountStatuses', 'pricePoints'));
    // }

    public function updateAccountStatus(Request $request, $id)
    {
        try {
            $vendor = Vendor::findOrFail($id); // Use findOrFail to handle invalid IDs

            // Update account status and track the change timestamp
            if ($vendor->account_status != $request->account_status) {
                $vendor->account_status_updated_at = \Carbon\Carbon::now();
            }

            $vendor->account_status = $request->account_status;
            $vendor->price_point = $request->price_point ?? $vendor->price_point ?? null;

            // Save the updates
            $vendor->save();

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Account status updated successfully.'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle case where Vendor is not found
            return response()->json([
                'status' => 'error',
                'message' => 'Vendor not found.'
            ], 404);
        } catch (\Exception $e) {
            // Handle general exceptions
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the account status.',
                'error' => $e->getMessage() // Optional: Include error details for debugging
            ], 500);
        }
    }

    public function checkVendorCombination(Request $request)
    {
        $validated = $request->validate([
            'vendor_name' => 'required|string',
            'street_address' => 'required|string',
        ]);

        $exists = Vendor::where('vendor_name', $request->vendor_name)
            ->where('street_address', $request->street_address)
            ->exists();

        if ($exists) {
            return response()->json(['exists' => true, 'message' => 'The vendor with this name and a similar address already exists.'], 200);
        }

        return response()->json(['exists' => false]);
    }

    public function vendorEmailTest()
    {
        // $vendor = Vendor::with('user')->find(2);
        // $qrCodeData = route('vendorQCode.show', [
        //     'short_code' => $vendor->short_code,
        //     'redirect' => "register" // Replace 'register' with your desired redirect route
        // ]);
        // echo $qrCodeData; die;
        // $subscriptionId = "sub_1QFa1xSC0b81aLgQzARwakB6";
        // $vendorId = WinerySubscription::where('stripe_subscription_id', $subscriptionId)
        //         ->value('vendor_id');
        // echo $vendorId; die;
        $vendor = Vendor::with('user')->find(2);
        $data = [
            "username" => $vendor->user->email,
            "password" => '12345678',
        ];
        $emailContent = View::make('emails.vendor.vendor_login_details_email', compact('vendor', 'data'))->render();
        echo $emailContent;
        die;
    }

    public function vendorDetails($id)
    {
        $vendor = Vendor::with('user')->find($id);
        return view('admin.vendors.vendor-detail', compact('vendor'));
    }

    public function getViewTab($id)
    {
        $vendor = Vendor::with('user')->find($id);
        return view('admin.vendors.ajax.view', compact('vendor'));
    }

    public function getExperienceTab($id)
    {
        $vendor = Vendor::find($id);
        $experiences = Experience::where('vendor_id', $id)->get();
        return view('admin.vendors.ajax.curative-experience', compact('experiences', 'vendor'));
    }

    public function updateExperience(Request $request, $id)
    {
        try {
            // Initialize rules and messages
            $rules = [];
            $messages = [];

            // Get existing experiences
            $existingExperiences = Experience::where('vendor_id', $id)->get();

            // Iterate through up to three experiences
            for ($i = 0; $i < 3; $i++) {
                $experienceData = $request->input("experience.$i");

                if ($experienceData['title'] == null) {
                    continue;
                }

                // Check if any field is filled
                if ($experienceData['title'] || $experienceData['upgradefee'] || $experienceData['currenttype'] || $experienceData['description']) {
                    // Define validation rules and messages
                    $rules["experience.$i.title"] = 'required';
                    $rules["experience.$i.upgradefee"] = 'required';
                    $rules["experience.$i.currenttype"] = 'required';
                    $rules["experience.$i.description"] = 'required|max:250';

                    $messages["experience.$i.title.required"] = 'The experience ' . ($i + 1) . ' title is required.';
                    $messages["experience.$i.upgradefee.required"] = 'The experience ' . ($i + 1) . ' upgrade fee is required.';
                    $messages["experience.$i.currenttype.required"] = 'The experience ' . ($i + 1) . ' extension type is required.';
                    $messages["experience.$i.description.required"] = 'The experience ' . ($i + 1) . ' description is required.';
                    $messages["experience.$i.description.max"] = 'The experience ' . ($i + 1) . ' description may not be greater than 250 characters.';

                    // Validate the request
                    $request->validate($rules, $messages);

                    // Update or create experience
                    if (isset($existingExperiences[$i])) {
                        $existingExperiences[$i]->update($experienceData);
                    } else {
                        Experience::create(array_merge($experienceData, ['vendor_id' => $id, 'user_id' => 1]));
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Curated experiences updated successfully.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating experiences.',
            ], 500);
        }
    }

    public function getStripeDetailsTab($id)
    {
        $vendor = Vendor::find($id);
        $stripeDetail = VendorStripeDetail::where('vendor_id', $id)->first();

        // Decrypt sensitive fields before passing to the view
        if ($stripeDetail) {
            $stripeDetail->stripe_secret_key = Crypt::decryptString($stripeDetail->stripe_secret_key);
            if (!empty($stripeDetail->webhook_secret_key)) {
                $stripeDetail->webhook_secret_key = Crypt::decryptString($stripeDetail->webhook_secret_key);
            }
        }
        return view('admin.vendors.ajax.stripe-details', compact('vendor', 'stripeDetail'));
    }

    public function updateStripeDetails(Request $request, $id)
    {
        $request->validate([
            'stripe_publishable_key' => 'required|string',
            'stripe_secret_key' => 'required|string',
            'webhook_secret_key' => 'nullable|string',
        ]);
        $stripeDetail = VendorStripeDetail::where('vendor_id', $id)->first();

        if (!$stripeDetail) {
            $stripeDetail = new VendorStripeDetail();
            $stripeDetail->vendor_id = $id;
        }
        $stripeDetail->stripe_publishable_key = $request->stripe_publishable_key;
        $stripeDetail->stripe_secret_key = Crypt::encryptString($request->stripe_secret_key);
        $stripeDetail->webhook_secret_key = Crypt::encryptString($request->webhook_secret_key);
        $save = $stripeDetail->save();

        if (!$save) {
            return response()->json(['success' => false]);
        }
        // ajax
        return response()->json(['success' => true]);
    }

    public function getQuestionnaireTab($id)
    {
        $vendor = Vendor::find($id);
        $questionnaires = Questionnaire::with(['vendorQuestionnaires' => function ($query) use ($id) {
            $query->where('vendor_id', $id);
        }])
            ->where(
                'vendor_type',
                '=',
                trim(strtolower($vendor->vendor_type))
            )
            ->get();
        return view('admin.vendors.ajax.questionnaire', compact('questionnaires', 'vendor'));
    }

    public function updateQuestionnaire(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'answer' => ['nullable', 'array', function ($attribute, $value, $fail) {
                foreach ($value as $questionId => $answer) {
                    $questionnaire = Questionnaire::find($questionId);
                    if (!$questionnaire) {
                        continue;
                    }
                    if ($questionnaire->question_type === 'checkbox') {
                        // Validation logic for checkboxes (optional)
                    } elseif ($questionnaire->question_type === 'radio') {
                        // Validation logic for radio (optional)
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

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        foreach ($validated['answer'] as $questionnaireId => $answer) {
            $questionnaire = Questionnaire::find($questionnaireId);
            if ($questionnaire) {
                $value = $questionnaire->question_type === 'checkbox' ? json_encode($answer ?? []) : $answer;
                VendorQuestionnaire::updateOrCreate(
                    ['vendor_id' => $request->id, 'questionnaire_id' => $questionnaireId],
                    ['answer' => $value]
                );
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Questionnaire updated successfully.',
        ]);
    }

    public function getSocialMediaTab($id)
    {
        $vendor = Vendor::find($id);
        return view('admin.vendors.ajax.social-media', compact('vendor'));
    }

    public function updateSocialMedia(Request $request, $id)
    {
        $request->validate([
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'twitter' => 'nullable|string',
            'youtube' => 'nullable|string',
            'pinterest' => 'nullable|string',
            'tiktok' => 'nullable|string',
        ]);
        $socialMedia = VendorSocialMedia::where('vendor_id', $id)->first();
        if (!$socialMedia) {
            $socialMedia = new VendorSocialMedia();
            $socialMedia->vendor_id = $id;
        }
        $socialMedia->facebook = $request->facebook ?? NULL;
        $socialMedia->instagram = $request->instagram ?? NULL;
        $socialMedia->twitter = $request->twitter ?? NULL;
        $socialMedia->youtube = $request->youtube ?? NULL;
        $socialMedia->pinterest = $request->pinterest ?? NULL;
        $socialMedia->tiktok = $request->tiktok ?? NULL;
        $save = $socialMedia->save();
        if (!$save) {
            return response()->json(['success' => false]);
        }
        // ajax
        return response()->json(['success' => true]);
    }

    public function getAccessCredentialsTab($id)
    {
        $vendor = Vendor::find($id);
        return view('admin.vendors.ajax.access-credentials', compact('vendor'));
    }

    public function updateAccessCredentials(Request $request, $vendorid)
    {
        try {
            // Validate the input data
            $request->validate([
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'contact_number' => 'required|string|max:15', // Adjust max length as needed
            ]);
            $vendor = Vendor::find($vendorid);
            // Perform the update
            $updated = User::where('id', $vendor->user_id)->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'contact_number' => $request->contact_number,
            ]);

            // Check if the update was successful
            if ($updated) {
                // Refresh the authenticated user instance

                return response()->json([
                    'success' => true,
                    'message' => 'User updated successfully.',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'User update failed.',
            ], 500);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred.',
            ], 500);
        }
    }

    public function getMediaGalleryTab($id)
    {
        $vendor = Vendor::find($id);
        $VendorMediaGallery = VendorMediaGallery::where('vendor_id', $id)->get();
        return view('admin.vendors.ajax.media-gallery', compact('vendor', 'VendorMediaGallery'));
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
            $vendorDir = public_path('images/VendorImages/' . $vendor->vendor_name);
            if (!File::exists($vendorDir)) {
                File::makeDirectory($vendorDir, 0777, true, true);
            }

            // Save the image to the directory
            $filePath = $vendorDir . '/' . $filename;
            file_put_contents($filePath, $data);

            // Save the media information to the database
            $VendorMediaGallery = new VendorMediaGallery;
            $VendorMediaGallery->vendor_media = 'images/VendorImages/' . $vendor->vendor_name . '/' . $filename;
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

    public function deleteMedia(Request $request)
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

        // Reset all media is_default to 0 for this vendor
        VendorMediaGallery::where('vendor_id', $vendorId)->update(['is_default' => 0]);

        // Set the current media as default
        $media->is_default = 1;
        $media->save();

        return response()->json(['status' => 'success', 'message' => 'Media set as logo successfully.']);
    }

    public function getAmenitiesTab($id)
    {
        $vendor = Vendor::findOrFail($id);
        $amenities = Amenity::where('amenity_status', 'active')
            ->with(['vendors' => function ($query) use ($id) {
                $query->where('vendor_id', $id);
            }]);
        if (strtolower($vendor->vendor_type) == 'accommodation') {
            $amenities = $amenities->where('vendor_type', 'accommodation');
        } else if (strtolower($vendor->vendor_type) == 'excursion' || strtolower($vendor->vendor_type) == 'winery') {
            $amenities = $amenities->where('vendor_type', NULL);
        }
        $amenities = $amenities->get();
        return view('admin.vendors.ajax.amenities', compact('vendor', 'amenities'));
    }

    public function updateAmenities(Request $request, $id)
    {
        try {
            $amenityId = $request->amenity_id;
            $status = $request->status ? 'active' : 'inactive';

            // Update or create vendor amenity
            $vendorAmenity = VendorAmenity::updateOrCreate(
                ['vendor_id' => $id, 'amenity_id' => $amenityId],
                ['status' => $status]
            );

            return response()->json([
                'success' => true,
                'message' => 'Amenity status updated successfully.',
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error updating amenity: ' . $e->getMessage(), [
                'vendor_id' => $id,
                'amenity_id' => $request->amenity_id,
            ]);

            // Return a JSON response with error
            return response()->json([
                'success' => false,
                'message' => 'Failed to update amenity status. Please try again later.',
            ], 500);
        }
    }

    public function getBookingUtilityTab($id)
    {
        $vendor = Vendor::find($id);
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
        return view('admin.vendors.ajax.booking-utility', compact('vendor'));
    }

    public function updateBookingUtility(Request $request, $id)
    {
        $vendor = Vendor::find($id);
        if (!$vendor) {
            return response()->json(['status' => 'error', 'message' => 'Vendor not found.'], 404);
        }

        $required_fields = [
            'process_type' => 'required|string|in:one-step,two-step,redirect-url',
            'redirect_url_type' => 'nullable|required_if:process_type,redirect-url|string|in:http://,https://',
            'redirect_url' => 'nullable|required_if:process_type,redirect-url',
            'applicable_taxes_amount' => 'nullable|required_if:apply_applicable_taxes,1|string|max:255',
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

        $validated = $request->validate($required_fields);

        try {
            $vendor->host = $request->host ?? null;
            $vendor->save();

            if (strtolower($vendor->vendor_type) == 'accommodation') {
                $metdata = VendorAccommodationMetadata::firstOrNew(['vendor_id' => $id]);
                $metdata->cleaning_fee_amount = $request->cleaning_fee_amount;
                $metdata->checkout_time = $request->checkout_time ?
                    Carbon::createFromFormat('h:i A', $request->checkout_time)->format('H:i:s') : null;
                $metdata->checkin_start_time = $request->checkin_start_time ?
                    Carbon::createFromFormat('h:i A', $request->checkin_start_time)->format('H:i:s') : null;
                $metdata->checkin_end_time = $request->checkin_end_time ?
                    Carbon::createFromFormat('h:i A', $request->checkin_end_time)->format('H:i:s') : null;
                $metdata->pet_boarding = $request->pet_boarding;
                $metdata->booking_minimum = $request->booking_minimum;
                $metdata->booking_maximum = $request->booking_maximum;
                $metdata->security_deposit_amount = $request->security_deposit_amount;
            }

            if (strtolower($vendor->vendor_type) == 'excursion') {
                $metdata = VendorExcursionMetadata::firstOrNew(['vendor_id' => $id]);
            }

            if (strtolower($vendor->vendor_type) == 'winery') {
                $metdata = VendorWineryMetadata::firstOrNew(['vendor_id' => $id]);
            }

            $metdata->process_type = $request->process_type;
            $metdata->redirect_url = $request->redirect_url_type . $request->redirect_url;
            $metdata->applicable_taxes_amount = $request->applicable_taxes_amount;
            $metdata->save();

            return response()->json(['status' => 'success', 'message' => 'Booking utility updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred while updating booking utility.'], 500);
        }
    }

    public function updateVendorPolicy(Request $request, $id)
    {
        $validated = $request->validate([
            // Other validation rules
            'policy' => 'required|string|in:open,partial,closed'
        ]);

        try {
            $vendor = Vendor::find($id);
            if ($vendor) {
                $vendor->policy = $request->policy;
                $vendor->save();
                return response()->json(['status' => 'success', 'message' => 'Vendor policy updated successfully.']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Vendor not found.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'An error occurred while updating vendor policy.'], 500);
        }
    }

    public function getSettingsTab($id)
    {
        $vendor = Vendor::find($id);
        $vendor_type = strtolower($vendor->vendor_type);
        $inventoryTypes = InventoryType::with('subCategories')->get();
        $subCategories = SubCategory::whereHas('category', function ($query) use ($vendor_type) {
            $query->where('slug', $vendor_type);
        })->get();
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
        $VendorMediaGallery = VendorMediaGallery::where('vendor_id', $id)->get();
        return view('admin.vendors.ajax.settings', compact('vendor', 'metadata', 'VendorMediaGallery', 'inventoryTypes', 'subCategories'));
    }

    public function getSystemAdminTab($id)
    {
        $vendor = Vendor::find($id);
        return view('admin.vendors.ajax.system-admin', compact('vendor'));
    }

    public function getWineTab($id)
    {
        $vendor = Vendor::find($id);
        $wines = VendorWine::where('vendor_id', $id)->get();
        return view('admin.vendors.ajax.wine-listing', compact('vendor', 'wines'));
    }
    public function viewWineDetails($id, $wine_id)
    {
        $vendor = Vendor::find($id);
        $wine = VendorWine::find($wine_id);
        return view('admin.vendors.ajax.wine-view', compact('wine', 'vendor'));
    }

    public function updateWineFee($id, $wine_id, Request $request)
    {
        $request->validate([
            'stocking_fee' => 'required|numeric',
        ]);
        // update wine commission_delivery_fee
        $wine = VendorWine::find($wine_id);
        // $price = calculateStockingFeeAndPrice($wine->cost);
        $wine->commission_delivery_fee = $request['stocking_fee'];
        $wine->price = $wine->cost + $request['stocking_fee'];
        $updated = $wine->save();
        if ($updated) {
            return response()->json(['status' => 'success', 'message' => 'Wine commission updated successfully.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'An error occurred while updating wine commission.'], 500);
        }
    }



    public function getInquiriesTab(Request $request, $id)
    {
        $inquiries = Inquiry::with('vendor')->where('vendor_id', $id)->get();
        return view('admin.vendors.ajax.booking-inquiries', compact('inquiries'));
    }

    public function getTransactionTab(Request $request, $id)
    {
        $orders = Order::with('vendor')->where('vendor_id', $id)->get();
        return view('admin.vendors.ajax.transaction', compact('orders'));
    }
}
