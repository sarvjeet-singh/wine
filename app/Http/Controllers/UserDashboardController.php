<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\PublishSeason;
use App\Models\BookingDate;
use App\Models\Experience;
use App\Models\FaqSection;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Review;
use App\Models\VendorSuggest;
use App\Models\Order;
use App\Models\Inquiry;

use \illuminate\Support\Facades\DB;
use \illuminate\Support\Facades\Auth;


class UserDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userDashboard(){
        $first_login = false;
        if(Auth::user()->first_login == 1){
            // exit;
            $first_login = true;
            Auth::user()->update(['first_login' => false]);
        }
        return view('UserDashboard.index',compact('first_login'));
    }

    public function userSettings(){
        return view('UserDashboard.user-settings');
    }
    public function vendorsuggest(){
        return view('UserDashboard.vendor-suggest');
    }
    public function becomevendor(){
        return view('FrontEnd.become-vendor');
    }

    public function userSettingsAccountUpdate(Request $request){
        
        $userId = Auth::id();
        // Validation rules
        $rules = [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
            'gender' => 'required|in:Male,Female,Other', // example validation for gender
            'age_range' => 'required', // example validation for age range
            // 'date_of_birth' => 'string|max:255'
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
        if($request->profile_image){
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

        $user = User::find($userId);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->display_name = $request->display_name;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->age_range = $request->age_range;
        $user->date_of_birth = $request->date_of_birth;
        $user->save();
        return back()->with('profile-success', 'Profile updated successfully.');
    }

    public function userSettingsEmergencyUpdate(Request $request){
        $rules = [
            'emergency_contact_name' => 'required|string|regex:/^[a-zA-Z\s]*$/|max:255',
            'emergency_contact_relation' => 'required|string|regex:/^[a-zA-Z\s]*$/|max:255',
            'emergency_contact_phone_number' => 'required|string|max:20',
            'emergency_contact_number' => 'required|string|max:20',
            'medical_physical_concerns' => 'required|string|max:255',
            'alternate_contact_full_name' => 'required|string|max:255|regex:/^[a-zA-Z\s]*$/|max:255',
            'alternate_contact_relation' => 'required|string|max:255|regex:/^[a-zA-Z\s]*$/|max:255',
            'alternate_contact_relation' => 'required|string|max:255'
            
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
        $user = User::find($userId);
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
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ];

        // Custom validation messages (optional)
        $messages = [
            'current_password.required' => 'Current password is required.',
            'new_password.required' => 'New password is required.',
            'new_password.min' => 'New password must be at least 8 characters.',
            'new_password.confirmed' => 'New password confirmation does not match.',
        ];

        // Validate the request
        $request->validate($rules, $messages);

        // Get the currently authenticated user
        $user = Auth::user();

        // Check if the current password matches the user's password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Log the user out
        Auth::logout();

        // Redirect to the login page with a success message
        return redirect('/login')->with('password-success', 'Password updated successfully. Please log in with your new password.');
    }

    public function userSettingsSocialUpdate(Request $request){

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

    public function userReviews() {
        $vendors = Vendor::get();
        return view('UserDashboard.submit-reviews', compact('vendors'));
    }
    public function userReviewsSubmit(Request $request){
        // Custom validation messages
        $messages = [
            'vendor_id.required' => 'Please select any vendor.',
            'rating.not_in' => 'Please select at least one star.',
            'date_of_visit.required' => 'The date of visit is required.',
            'date_of_visit.date' => 'The date of visit must be a valid date.',
            'review_description.required' => 'Review description is required.',
        ];

        // Validation rules
        $rules = [
            'vendor_id' => 'required',
            'date_of_visit' => 'required|date',
            'rating' => 'not_in:0',
            'review_description' => 'required|string|max:1000',
        ];

        // Validate the request
        $request->validate($rules, $messages);

        // Check if the validation fails
        

        // Proceed with storing the review
        // Assuming you have a Review model
        $review = new Review();
        $review->user_id = Auth::id();
        $review->vendor_id = $request->vendor_id;
        $review->rating = $request->rating;
        $review->date_of_visit = $request->date_of_visit;
        $review->receipt = $request->receipt;
        $review->review_description = $request->review_description;
        $review->save();

        // Redirect back with a success message
        return back()->with('success', 'Review submitted successfully.');
        // echo "<pre>";print_r($request->all());

    }

    public function userReviewsManage(){
        $reviews = Review::with('vendor')->where('user_id', Auth::id())->get();
        return view('UserDashboard.manage-review', compact('reviews'));
    }

    public function userGuestRegistry(){
        return view('UserDashboard.guest-registry-edit');
    }
    
    public function userAddressUpdate(Request $request){
        $messages = [
            'city.required' => 'The city field is required.',
            'state.required' => 'The state field is required.',
            'postal_code.required' => 'The postal code field is required.'
        ];
    
        $request->validate([
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
        ], $messages);
    
        $user = auth()->user();
    
        // Update user details
        $user->contact_number = $request->contact_number;
        $user->street_address = $request->street_address;
        $user->suite          = $request->suite;
        $user->city           = $request->city;
        $user->state          = $request->state;
        $user->postal_code    = $request->postal_code;
        $user->country        = $request->country;
        $user->save();
        return redirect()->back()->with('success', 'Guest Registry updated successfully.');
    }

    public function userGovermentUpdate(Request $request){
        $user = Auth::user();
        if($request->government_proof_front){
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
        if($request->government_proof_back){
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
        ], [
            'guestrewards.required' => 'Please select a referral option.',
            'guestrewards_social_media.required_if' => 'Please select a social media platform.',
            'guestrewards_vendor_id.required_if' => 'Please select a vendor.',
        ]);

        // Update the user's settings
        $user = Auth::user();
        $user->guestrewards = $request->guestrewards;
        $user->guestreward_user = $request->guestreward_user;
        $user->guestrewards_social_media = $request->guestrewards == 'Social Media Content' ? $request->guestrewards_social_media : null;
        $user->guestrewards_vendor_id = $request->guestrewards == 'Niagara Region Vendor' ? $request->guestrewards_vendor_id : null;
        $user->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Referral settings updated successfully.');
    }
    public function vendor_list(Request $request){
        $query = $request->input('q');
        $options = Vendor::where('vendor_name', 'LIKE', '%' . $query . '%')
        ->get() // Get both columns
        ->map(function ($vendor) {
            return [
              "id" => $vendor->id,
              "text" => $vendor->vendor_name ]; // remove for now. ' - '.$vendor->buisnessstreet_address . ", " . $vendor->buisness_vendor_city
        });
        return response()->json($options);
    }
    public function StoreVendorSuggest(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'vendor_name' => 'required|string|max:255',
            'street_address' => 'nullable|string|max:255',
            'unit_suite' => 'nullable|string|max:255',
            'city_town' => 'nullable|string|max:255',
            'province_state' => 'nullable|string|max:255',
            'postal_zip' => 'nullable|string|max:255',
            'vendor_phone' => 'required|string|max:255',
            'vendor_category' => 'nullable|string|max:255',
            'vendor_sub_type' => 'nullable|string|max:255',
            'establishment_facility' => 'nullable|string|max:255',
        ]);

        // Add user ID to the validated data
        $validated['user_id'] = Auth::id();

        // Fetch user details
        $user = Auth::user();

        // Create a new record in the database
        VendorSuggest::create($validated);

        // Define email parameters
        $to = "hkamboj116@gmail.com";
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

    public function orders() {
        $orders = Order::with('vendor')->where('user_id', Auth::user()->id)->get();
        return view('UserDashboard.my-transactions', compact('orders'));
    }

    public function orderDetail($id) {
        $order = Order::where('id', $id)->first();
        $vendor = Vendor::find($order->vendor_id);
        return view('UserDashboard.order-detail', compact('order', 'vendor'));
    }

    public function inquiries() {
        $inquiries = Inquiry::with('vendor')->where('user_id', Auth::user()->id)->get();
        return view('UserDashboard.my-inquiries', compact('inquiries'));
    }

    public function inquiryDetail($id) {
        $inquiry = Inquiry::where('id', $id)->first();
        $vendor = Vendor::find($inquiry->vendor_id);
        return view('UserDashboard.inquiry-detail', compact('inquiry', 'vendor'));
    }

    public function userFaqs() {
        $user_faqs = FaqSection::with('questions')->where('account_type', 'user')->get();
        // print_r($user_faqs); die;
        return view('UserDashboard.user-faq', compact('user_faqs'));
    }

}