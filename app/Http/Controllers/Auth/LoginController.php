<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;  // <-- Make sure this is correctly imported
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user-dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // public function login(Request $request)
    // {
    //     echo 'here'; die;
    //     redirect()->route('customer.login');
    // }

    public function login(Request $request)
    {
        return redirect()->route('customer.login');
    }

    protected function authenticated(Request $request, $user)
    {
        if (!$user->hasVerifiedEmail() && strtolower($user->role) === 'member') {
            Auth::logout();
            return redirect('/login')
                ->with('error', 'You need to verify your email address before logging in.')
                ->with('show_resend_link', true)
                ->with('unverified_email', $user->email);
        }
        if (strtolower($user->role) === 'member') {
            return redirect()->intended($this->redirectTo);
        }

        if (strtolower($user->role) === 'vendor') {
            $vendor = Vendor::where('user_id', $user->id)->first();

            if ($vendor) {
                if ($user->password_updated == 0) {
                    return redirect()->intended('/vendor-change-password/' . $vendor->id);
                }
                return redirect()->intended('/vendor-dashboard/' . $vendor->id);
            }

            // Handle case where vendor record is not found
            return redirect()->back()->with('error', 'Vendor not found.');
        }

        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        }

        // Default redirection
        return redirect()->intended('/');
    }
    public function process_login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->except(['_token', 'page', 'remember']);

        $user = User::where('email', $request->email)->first();

        if (auth()->attempt($credentials)) {
            if ($user->role == 1) {
                if ($request->ajax()) {
                    return response()->json(['redirect' => 'vendor']);
                } else {
                    return redirect('vendor');
                }
            } elseif ($user->role == 6) {
                Auth::logout();
                if ($request->ajax()) {
                    return response()->json([
                        'error' => 'Your account has been suspended. Please contact system administrators for next steps.'
                    ]);
                } else {
                    return Redirect::back()->withErrors([
                        'email' => 'Your account has been suspended. Please contact system administrators for next steps.'
                    ]);
                }
            } elseif ($request->page) {
                if ($request->ajax()) {
                    return response()->json(['redirect' => 'accommodation-partners']);
                } else {
                    return redirect('accommodation-partners');
                }
            } else {
                if ($request->ajax()) {
                    return response()->json(['redirect' => '/dashboard?tab=profile']);
                } else {
                    return redirect('/dashboard?tab=profile');
                }
            }
        } else {
            if ($request->ajax()) {
                return response()->json(['error' => 'Invalid User. Please check your details.']);
            } else {
                return Redirect::back()->withErrors(['email' => 'Invalid User. Please check your details.']);
            }
        }
    }
    public function loginWithToken(Request $request, $token)
    {
        $user = User::where('login_token', $token)
            ->where('created_at', '>=', now()->subHour(12))
            ->first();
        // print_r($user);
        // exit;

        if (!$user) {
            return redirect()->route('login')->withErrors(['email' => 'Invalid or expired login link.']);
        } elseif ($user->role == "suspended") {
            return Redirect::back()->withErrors([
                'email' => 'Your account has been suspended. Please contact system administrators for next steps.'
            ]);
        }

        // Log the user in
        auth()->login($user);

        $user->login_token = "";
        $user->save();
        // if ($user->role == 1) {
        //     return redirect('vendor');
        // }

        // Redirect to the desired location
        return redirect()->intended($this->redirectTo);
    }

    public function loginAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed
            return response()->json([
                'status' => 'success',
                'message' => 'Login successful.',
                'redirect_url' => url($this->redirectTo)
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Login failed.',
                'redirect_url' => url($this->redirectTo)
            ], 422);
        }
    }

    public function resend(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('error', 'Your email is already verified.');
        }

        // Send the verification email
        $user->sendEmailVerificationNotification();

        return redirect()->route('login')->with('success', 'Verification link has been resent to your email address.');
    }

    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        $exists = Customer::where('email', $email)->exists();

        return response()->json(!$exists); // Returns true if email is unique, false if it exists
    }
}
