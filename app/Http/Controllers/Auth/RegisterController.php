<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Vendor;
// use App\Mail\WelcomeMail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Stripe\Stripe;
use Stripe\Customer as StripeCustomer;
use App\Models\Customer;
use Session;

use Mews\Captcha\Captcha;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // print_r($data);
        // exit;
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z]+$/'],
            'lastname' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',       // must contain at least one uppercase letter
                'regex:/[a-z]/',       // must contain at least one lowercase letter
                'regex:/[0-9]/',       // must contain at least one number
                'regex:/[@$!%*#?&]/',  // must contain a special character
            ],
            // 'captcha' => ['required'],
            // 'g-recaptcha-response' => ['required']
        ]);
    }

    public function showRegistrationForm(Request $request)
    {
        $vendor = null;
        $slug = $request->query('slug');
        if($slug){
            $slug = explode('-', $slug);
            if(is_numeric($slug[0])){
                $vendor = Vendor::where('id', $slug[0])->first();
            }
        }
        return view('auth.register', compact('vendor'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // echo "<pre>";print_r($data);
        // exit;
        $token = Str::random(60);
        $user = Customer::create([
            'firstname' => $data['firstname'],
            'email' => $data['email'],
            'lastname' => $data['lastname'],
            'password' => Hash::make($data['password']),
            'role' => 'Member',
            'login_token' => $token
        ]);

        // Refer by vendor
        if (isset($data['refer_by']) && !empty($data['refer_by'])) {
            $slug = $data['refer_by'];
            if($slug) {
                $slug = explode('-', $slug);
            }
            $vendor = Vendor::where('id', $slug[0])->first();

            if ($vendor->id) {
                $user->guestrewards = "Niagara Region Vendor";
                $user->guestrewards_vendor_id = $vendor->id;
                $user->save();
            }
        }


        // $loginLink = route('login-with-token', ['token' => $token]);

        // $subject = "Welcome to Guest Rewards Program";
        // $emailContent = View::make('emails.welcome', ['username' => $user->name, 'loginLink' => $loginLink])->render();
        // sendEmail($user->email, $subject, $emailContent);
        // Send email verification notification
        $user->sendEmailVerificationNotification();
        return $user;

        // return redirect()->route('verification.notice');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        // exit;
        $user = $this->create($request->all());

        // Instead of logging in, redirect to the login page
        return redirect()->route('login')->with('success', 'Thank you for registering. You can now log in.');
    }

    public function validateCaptcha(Request $request)
    {
        // Get the user input for CAPTCHA from the form
        $userCaptcha = $request->input('captcha');

        // Retrieve the CAPTCHA key from the session
        $sessionCaptchaKey = Session::get('captcha.key');

        // Check if the CAPTCHA is provided and matches the session key
        if (empty($userCaptcha)) {
            return response()->json(['success' => false, 'message' => 'CAPTCHA is required.']);
        }

        // Use bcrypt or hash_check (depending on your encryption method) to compare the CAPTCHA input
        if (password_verify($userCaptcha, $sessionCaptchaKey)) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid CAPTCHA.']);
        }
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
}
