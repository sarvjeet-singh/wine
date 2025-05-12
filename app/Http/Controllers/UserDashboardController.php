<?php

namespace App\Http\Controllers;

use App\Helpers\CustomerHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\PublishSeason;
use App\Models\BookingDate;
use App\Models\Experience;
use App\Models\FaqSection;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Review;
use App\Models\VendorSuggest;
use App\Models\Order;
use App\Models\Inquiry;
use App\Models\Wallet;
use Mews\Captcha\Captcha;

use \illuminate\Support\Facades\DB;
use \illuminate\Support\Facades\Auth;
use App\Mail\AdminReviewNotificationMail;
use Illuminate\Support\Facades\Mail;


class UserDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:customer', 'check.terms']);
    }

    public function userDashboard()
    {
        $first_login = false;
        if (Auth::user()->first_login == 1) {
            // exit;
            $first_login = true;
            Auth::user()->update(['first_login' => false]);
        }
        $wallet = Wallet::where('customer_id', Auth::user()->id)->first();
        $balance = $wallet ? $wallet->balance : 0;
        return view('UserDashboard.index', compact('first_login', 'balance'));
    }

    public function refreshCaptcha(Request $request, Captcha $captcha)
    {
        // Generate a new CAPTCHA image
        $captchaData = $captcha->create('default', true);
        // Return the new CAPTCHA image and its key (if needed)
        return response()->json([
            'captcha' => $captchaData['img'],
            // 'captchaKey' => $captchaData['key'],
        ]);
    }

    public function userSettingsSocialUpdate(Request $request)
    {

        // Retrieve the authenticated user
        $user = Auth::user();

        // Update the social media fields based on the checkboxes and inputs
        $user->facebook =  $request->facebook;
        $user->instagram = $request->instagram;
        $user->youtube = $request->youtube;
        $user->tiktok =  $request->tiktok;
        $user->twitter = $request->twitter;
        $user->linkedin = $request->linkedin;

        // Save the updated user information
        $user->save();

        // Redirect back with a success message
        return back()->with('social-success', 'Social media links updated successfully.');
    }

    public function userSettings()
    {
        return view('UserDashboard.user-settings');
    }
    public function vendorsuggest()
    {
        return view('UserDashboard.vendor-suggest');
    }
    public function becomevendor()
    {
        $user = Auth::user();
        return view('FrontEnd.become-vendor', compact('user'));
    }

    public function userSettingsAccountUpdate(Request $request)
    {
        $userId = Auth::id();
        // Validation rules
        $rules = [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            // 'email' => 'required|email|unique:customers,email,' . $userId,
            'gender' => 'required|in:Male,Female,Other', // example validation for gender
            'age_range' => 'required', // example validation for age range
            'date_of_birth' => [
                'nullable',
                'date',
                'before:' . now()->subYears(5)->format('Y-m-d'),
            ],
        ];

        // Custom validation messages (optional)
        $messages = [
            'firstname.required' => 'First name is required.',
            'lastname.required' => 'Last name is required.',
            'display_name.required' => 'Display name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'Email has already been taken.',
            'gender.required' => 'Gender is required.',
            'gender.in' => 'Gender must be either Male, Female, or other.',
            'age_range.required' => 'Age range is required.',
            'age_range.in' => 'Age range must be one of the specified values.'

        ];

        // Validate the request
        $validatedData = $request->validate($rules, $messages);
        $user = Auth::user();
        if ($request->profile_image) {
            list($type, $data) = explode(';', $request->profile_image);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);

            // Generate a random filename
            $filename = Str::random(10) . '.png';
            $path = public_path('images/UserProfile/' . $filename);

            // Save the decoded image data to a file
            File::put($path, $data);
            $user->profile_image = $filename;
            $user->profile_image_verified = 'verified';
            $user->save();
        }

        $user = Customer::find($userId);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->display_name = $request->display_name;
        // if ($user->email != $request->email) {
        //     $user->email_verified_at = null;
        // }
        // $user->email = $request->email;
        $user->gender = $request->gender;
        $user->age_range = $request->age_range;
        $user->date_of_birth = $request->date_of_birth;
        $user->save();
        return back()->with('profile-success', 'Profile updated successfully.');
    }

    public function userSettingsEmergencyUpdate(Request $request)
    {
        $rules = [
            'medical_physical_concerns' => 'required|string',
            'emergency_contact_name' => 'required|string|regex:/^[a-zA-Z\s]*$/|max:255',
            'emergency_contact_relation' => 'required|string|regex:/^[a-zA-Z\s]*$/|max:255',
            'emergency_contact_phone_number' => 'required|string|max:20',
            'alternate_contact_full_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]*$/|max:255',
            'alternate_contact_relation' => 'required|string|max:255|regex:/^[a-zA-Z\s]*$/|max:255',
            'emergency_contact_number' => 'required|string|max:20',
            // 'alternate_contact_relation' => 'required|string|max:255'

        ];

        // Custom validation messages (optional)
        $messages = [
            'emergency_contact_name.required' => 'Emergency contact name is required.',
            'emergency_contact_relation.required' => 'Emergency contact relation is required.',
            'emergency_contact_phone_number.required' => 'Emergency contact phone number is required.',
            'emergency_contact_number.required' => 'Emergency contact number is required.',
            'medical_physical_concerns' => 'Medical/Physical Concern is required.',
            'alternate_contact_full_name' => 'Alternate Contact’s Full Name is required.',
            'alternate_contact_relation' => 'Alternate Contact’s Relation is required.'

        ];

        // Validate the request
        $validatedData = $request->validate($rules, $messages);

        $userId = Auth::id();
        $user = Customer::find($userId);
        $user->emergency_contact_name = $request->emergency_contact_name;
        $user->emergency_contact_relation = $request->emergency_contact_relation;
        $user->emergency_contact_phone_number = $request->emergency_contact_phone_number;
        $user->emergency_contact_number = $request->emergency_contact_number;
        $user->medical_physical_concerns = $request->medical_physical_concerns;
        $user->alternate_contact_full_name = $request->alternate_contact_full_name;
        $user->alternate_contact_relation = $request->alternate_contact_relation;
        $user->save();

        return back()->with('emergency-success', 'Emergency contact updated successfully.');
    }

    public function userSettingsUpdatePassword(Request $request)
    {
        // Validation rules
        $rules = [
            'current_password' => [
                'required_if:password_present,true',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    // Skip if the user doesn't have a current password
                    if ($request->password_present && !Hash::check($value, Auth::user()->password)) {
                        $fail('Current password is incorrect.');
                    }
                }
            ],
            'new_password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[@$!%*#?&])[A-Za-z0-9@$!%*#?&]{8,}$/',
                'confirmed',
                // Custom rule to ensure new password isn't the same as the current password
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->password_present && Hash::check($value, Auth::user()->password)) {
                        $fail('New password cannot be the same as the current password.');
                    }
                }
            ],
            'new_password_confirmation' => 'required|same:new_password',
        ];

        // Custom validation messages
        $messages = [
            'current_password.required_if' => 'Current password is required.',
            'new_password.required' => 'New password is required.',
            'new_password.min' => 'New password must be at least 8 characters.',
            'new_password.regex' => 'New password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'new_password.confirmed' => 'New password confirmation does not match.',
            'new_password_confirmation.same' => 'New password confirmation does not match the new password.',
        ];

        // Check if the user has a password in the database
        $user = Auth::user();
        $request->merge(['password_present' => !is_null($user->password)]);

        // Validate the request
        $request->validate($rules, $messages);

        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Check if the user wants to log out after updating the password
        if ($request->has('logout_after_change')) {
            Auth::logout();
            return redirect('/login')->with('success', 'Password updated successfully. Please log in with your new password.');
        }

        // If no logout option was selected, redirect back with a success message
        return redirect()->back()->with('password-success', 'Password updated successfully.');
    }


    public function userReviews()
    {
        $vendors = Vendor::get();
        return view('UserDashboard.submit-reviews', compact('vendors'));
    }
    public function userReviewsSubmit(Request $request)
    {
        // Custom validation messages
        $messages = [
            'image.image' => 'Please upload a valid image file.',
            'image.max' => 'Image size should not exceed 8MB.',
            'vendor_id.required' => 'Please select any vendor.',
            'rating.not_in' => 'Please select at least one star.',
            'date_of_visit.required' => 'The date of visit is required.',
            'date_of_visit.date' => 'The date of visit must be a valid date.',
            'review_description.required' => 'Review description is required.',
        ];

        // Validation rules
        $rules = [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',
            'vendor_id' => 'required',
            'date_of_visit' => 'required|date',
            'rating' => 'not_in:0',
            'review_description' => 'required|string|max:1000',
        ];

        // Validate the request
        $request->validate($rules, $messages);

        // Check if the validation fails

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/reviews', 'public');
        } else {
            $imagePath = null;
        }



        // Proceed with storing the review
        // Assuming you have a Review model
        $review = new Review();
        $review->customer_id = Auth::id();
        $review->vendor_id = $request->vendor_id;
        $review->rating = $request->rating;
        $review->date_of_visit = $request->date_of_visit;
        $review->receipt = $request->receipt;
        $review->review_description = $request->review_description;
        $review->image = $imagePath;
        $review->save();

        // Send email to admin
        Mail::to(env('ADMIN_EMAIL'))->send(new AdminReviewNotificationMail($review));

        // Redirect back with a success message
        return back()->with('success', 'Review submitted successfully.');
        // echo "<pre>";print_r($request->all());

    }

    public function userReviewsManage()
    {
        $reviews = Review::with('vendor')->where('customer_id', Auth::id())->get();
        return view('UserDashboard.manage-review', compact('reviews'));
    }

    public function userGuestRegistry()
    {
        return view('UserDashboard.guest-registry-edit');
    }

    public function userAddressUpdate(Request $request)
    {
        $messages = [
            'contact_number.required' => 'The contact number field is required.',
            'country.required' => 'The country field is required.',
            'state.required' => 'The state field is required.',
            'other_country.required' => 'The other country field is required.',
            'other_state.required' => 'The other state field is required.',
            'city.required' => 'The city field is required.',
            'postal_code.required' => 'The postal code field is required.',
            'street_address.required' => 'The street address field is required.',
        ];

        $request->validate([
            'street_address' => 'required',
            'contact_number' => 'required',
            'country' => 'required',
            'state' => 'required_unless:country,Other',
            'other_country' => 'nullable|string|max:255|required_if:country,Other',
            'other_state' => 'nullable|string|max:255|required_if:country,Other',
            'city' => 'required',
            'postal_code' => 'required',
        ], $messages);

        $user = Auth::guard('customer')->user();
        $isOtherCountry = $request->input('country') === 'Other';

        // Update user details
        $user->contact_number = $request->contact_number;
        $user->street_address = $request->street_address;
        $user->suite          = $request->suite;
        $user->city           = $request->city;
        $user->state          = $request->state ?? null;
        $user->postal_code    = $request->postal_code;
        $user->country        = $request->country;
        $user->is_other_country = $isOtherCountry;
        $user->other_country = $request->other_country;
        $user->other_state = $request->other_state;
        $user->form_guest_registry_filled = 1;
        $user->save();
        return redirect()->back()->with('success', 'Guest Registry updated successfully.');
    }

    public function userGovermentUpdate(Request $request)
    {
        $user = Auth::user();
        if ($request->government_proof_front) {
            list($type, $data) = explode(';', $request->government_proof_front);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);

            // Generate a random filename
            $filename = Str::random(10) . '.png';
            $path = public_path('images/GovermentProof/' . $filename);

            // Save the decoded image data to a file
            File::put($path, $data);
            $user->government_proof_front = $filename;
            $user->save();
        }
        if ($request->government_proof_back) {
            list($type, $data) = explode(';', $request->government_proof_back);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);

            // Generate a random filename
            $filename = Str::random(10) . '.png';
            $path = public_path('images/GovermentProof/' . $filename);

            // Save the decoded image data to a file
            File::put($path, $data);
            $user->government_proof_back = $filename;
            $user->save();
        }
        return redirect()->back()->with('Goverment-success', 'Your government proof updated successfully.');
    }

    public function userSettingsRefferralUpdate(Request $request)
    {
        $request->validate([
            'guestrewards' => 'required',
            'guestrewards_social_media' => 'required_if:guestrewards,Social Media Content',
            'guestrewards_vendor_id' => 'required_if:guestrewards,Niagara Region Vendor',
            'guest_referral_other' => 'required_if:guestrewards,Other',
        ], [
            'guestrewards.required' => 'Please select a referral option.',
            'guestrewards_social_media.required_if' => 'Please select a social media platform.',
            'guestrewards_vendor_id.required_if' => 'Please select a vendor.',
            'guest_referral_other.required_if' => 'Please enter a referral name.',
        ]);

        // Update the user's settings
        $user = Auth::user();
        $user->guestrewards = $request->guestrewards;
        $user->guestreward_user = $request->guestreward_user;
        $user->guest_referral_other = $request->guestrewards == 'Other' ? $request->guest_referral_other : null;
        $user->guestrewards_social_media = $request->guestrewards == 'Social Media Content' ? $request->guestrewards_social_media : null;
        $user->guestrewards_vendor_id = $request->guestrewards == 'Niagara Region Vendor' ? $request->guestrewards_vendor_id : null;
        $user->save();

        if($user->first_login == 1){
            return redirect()->route('user-dashboard')->with('success', 'Referral settings updated successfully.');
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Referral settings updated successfully.');
    }
    public function vendor_list(Request $request)
    {
        $query = $request->input('q');
        $options = Vendor::where('vendor_name', 'LIKE', '%' . $query . '%')
            ->whereNotIn('vendor_type', ['licensed', 'non-licensed'])
            ->where('account_status', 1)
            ->get() // Get both columns
            ->map(function ($vendor) {
                return [
                    "id" => $vendor->id,
                    "text" => $vendor->vendor_name
                ]; // remove for now. ' - '.$vendor->buisnessstreet_address . ", " . $vendor->buisness_vendor_city
            });
        return response()->json($options);
    }
    public function support_vendor_list(Request $request)
    {
        $query = $request->input('q');

        $options = Vendor::where('vendor_name', 'LIKE', '%' . $query . '%')
            ->whereNotIn('vendor_type', ['winery', 'accommodation', 'excursion']) // Exclude specific vendor types
            ->where('account_status', 1)
            ->get()
            ->map(function ($vendor) {
                return [
                    "id" => $vendor->id,
                    "text" => $vendor->vendor_name
                ];
            });

        return response()->json($options);
    }
    public function StoreVendorSuggest(Request $request)
    {
        // print_r($request->all()); die;
        // Validate the request
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'user_city' => 'nullable|string|max:255',
            'user_state' => 'nullable|string|max:255',
            'user_email' => 'required|email|max:255',
            'user_phone' => 'nullable|string|max:255',
            'relationship' => 'nullable|string|max:255',
            'vendor_name' => 'required|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'unit_suite' => 'nullable|string|max:255',
            'city_town' => 'nullable|string|max:255',
            'province_state' => 'nullable|string|max:255',
            'postal_zip' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'vendor_phone' => 'required|string|max:255',
            'vendor_category' => 'nullable|string|max:255',
            'vendor_sub_category' => 'nullable|string|max:255',
            'establishment_facility' => 'nullable|string|max:255',
        ]);
        // Add user ID to the validated data
        $validated['user_id'] = Auth::id();
        if (isset($validated['vendor_category']) && $validated['vendor_category'] != null) {
            $validated['vendor_category'] = getCategoryById($validated['vendor_category']);
        }
        if (isset($validated['vendor_sub_category']) && $validated['vendor_sub_category'] != null) {
            $validated['vendor_sub_category'] = getSubCategoryById($validated['vendor_sub_category']);
        }
        if (isset($validated['establishment_facility']) && $validated['establishment_facility'] != null) {
            $validated['establishment_facility'] = getEstablishmentById($validated['establishment_facility']);
        }

        // Fetch user details
        $user = Auth::user();

        // Create a new record in the database
        VendorSuggest::create($validated);

        // Define email parameters
        $to = env('ADMIN_EMAIL');
        $subject = 'New Vendor Suggestion';
        $emailContent = view('emails.vendor_suggestion', [
            'validated' => $validated,
            'user' => $user,
        ])->render();

        // Send email using Laravel's Mail facade
        sendEmail($to, $subject, $emailContent);

        // Redirect or return a response
        return redirect()->back()->with('success', 'Form submitted successfully!');
    }

    public function orders()
    {
        $orders = Order::with('vendor')->where('customer_id', Auth::user()->id)->get();
        return view('UserDashboard.my-transactions', compact('orders'));
    }

    public function orderDetail($id)
    {
        $order = Order::where('id', $id)->first();
        $vendor = Vendor::find($order->vendor_id);
        return view('UserDashboard.order-detail', compact('order', 'vendor'));
    }

    public function inquiries()
    {
        $inquiries = Inquiry::with('vendor')
            ->where('customer_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('UserDashboard.my-inquiries', compact('inquiries'));
    }

    public function inquiryDetail($id)
    {
        $inquiry = Inquiry::where('id', $id)->first();
        $vendor = Vendor::find($inquiry->vendor_id);
        return view('UserDashboard.inquiry-detail', compact('inquiry', 'vendor'));
    }

    public function userFaqs()
    {
        $user_faqs = FaqSection::with('questions')->where('account_type', 'user')->get();
        // print_r($user_faqs); die;
        return view('UserDashboard.user-faq', compact('user_faqs'));
    }

    public function emailTemplateCheck()
    {
        return view('emails.accommodation_inquiry');
    }

    public function changePassword()
    {
        return view('UserDashboard.change-password');
    }

    public function referrals()
    {
        return view('UserDashboard.referral');
    }

    public function emergencyContact()
    {
        return view('UserDashboard.emergency-contact-details');
    }

    public function socialMedia()
    {
        return view('UserDashboard.social-media');
    }

    public function checkActivation(Request $request)
	{
		$customerid = $request->customerid; // ✅ Get vendor ID from request

		if (!$customerid) {
			return response()->json([
				'success' => false,
				'message' => ['Customer ID is required.'], // Return as an array
			], 400);
		}

		$response = CustomerHelper::getCustomerProfileCompletionStatus($customerid);

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
