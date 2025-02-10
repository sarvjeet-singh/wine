<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Password;
use Session;
use Mews\Captcha\Captcha;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendWelcomeCustomerMail;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('customer')->check()) {
            return redirect('/user-dashboard');
        }
        return view('auth.customer-login');
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if (Auth::guard('customer')->attempt($credentials)) {
                $user = Auth::guard('customer')->user();
                // Check if the user's email is verified
                if (!$user || !$user->hasVerifiedEmail()) {
                    // Logout the user to avoid partial session issues
                    Auth::guard('customer')->logout();
                    return redirect()->route('customer.login')
                        ->with('error', 'You need to verify your email address before logging in.')
                        ->with('show_resend_link', true)
                        ->with('unverified_email', $user->email);
                }
                $request->session()->regenerate();
                return redirect()->route('user-dashboard');
            } else {
                return back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
            }
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
    }

    public function showTermsPopup()
    {
        return view('UserDashboard.terms-popup'); // Return a view for the popup
    }

    public function acceptTerms(Request $request)
    {
        $request->validate([
            'terms' => 'required',
            'captcha' => 'required',
        ]);

        // Retrieve the CAPTCHA key from the session
        $sessionCaptchaKey = Session::get('captcha.key');
        if (!$sessionCaptchaKey) {
            return response()->json(['success' => false, 'message' => 'CAPTCHA session key is missing.']);
        }

        // Verify user input against session key
        if (password_verify($request->input('captcha'), $sessionCaptchaKey)) {
            // Assuming you need to store the acceptance in the user's profile
            $user = Auth::guard('customer')->user();
            $user->terms_accepted_at = now(); // Update the terms acceptance
            $user->save();

            return response()->json(['success' => true, 'message' => 'Terms and conditions accepted.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid CAPTCHA. Please try again.']);
        }
    }

    public function resend(Request $request)
    {
        // Validate the request
        if (Auth::guard('customer')->check()) {
            $user = Auth::guard('customer')->user();
        } else {
            $request->validate([
                'email' => 'required|email|exists:customers,email',
            ]);

            // Find the user
            $user = Customer::where('email', $request->email)->first();
        }

        // Check if the email is already verified
        if ($user->hasVerifiedEmail()) {
            $message = 'Your email is already verified.';

            // Check if it's an AJAX request
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 400); // 400 Bad Request
            }

            return redirect()->route('customer.login')->with('error', $message);
        }

        // Send the verification email
        $user->sendEmailVerificationNotification();
        $successMessage = 'Verification link has been resent to your email address.';

        // Check if it's an AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $successMessage,
            ]);
        }

        return redirect()->route('customer.login')->with('success', $successMessage);
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login');
    }

    public function verifyEmail($id, $hash)
    {
        // Retrieve the user by ID
        $user = Customer::findOrFail($id);
        // Check if the email is already verified
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('customer.login')->with(['error' => 'This verification link has expired. Please request a new one.']);
        }
        // Check if the hash matches the user's email verification hash
        if (hash_equals($hash, sha1($user->getEmailForVerification()))) {
            // Fulfill the email verification (mark the email as verified)
            $user->markEmailAsVerified();

            // Log the user in
            Auth::guard('customer')->login($user);
            Mail::to($user->email)->send(new SendWelcomeCustomerMail($user->firstname));
            // Redirect to the dashboard with success message
            return redirect()->route('user-dashboard')->with('success', 'Email verified successfully. Welcome to your dashboard!');
        }

        // If verification fails, return an error
        return redirect()->route('customer.login')->with(['error' => 'Invalid verification link.']);
    }

    public function showForgotPasswordForm()
    {
        return view('auth.passwords.customer-email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Validate the email field
        $request->validate([
            'email' => [
                'required',
                'email',
                'exists:customers,email', // Ensure the email exists in the 'customers' table
            ],
        ]);

        try {
            // Attempt to send the reset link using the 'customers' password broker
            $status = Password::broker('customers')->sendResetLink($request->only('email'));

            // Check the status and provide feedback to the user
            if ($status === Password::RESET_LINK_SENT) {
                return back()->with('status', trans($status));
            }

            // If the link sending failed, return an error response
            return back()->withErrors(['email' => trans($status)]);
        } catch (\Exception $e) {
            // Handle unexpected errors gracefully
            return back()->withErrors(['email' => 'Unable to process your request. Please try again later.']);
        }
    }

    public function showResetPasswordForm($token, Request $request)
    {
        $email = $request->email;
        return view('auth.passwords.customer-reset', ['token' => $token, 'email' => $email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:customers,email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required'
        ]);

        $status = Password::broker('customers')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($customer, $password) {
                $customer->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('customer.login')->with('success', 'Password has been reset. Please login.')
            : back()->withErrors(['email' => 'The provided password reset token is invalid.']);
    }

    public function validateCaptcha(Request $request)
    {
        $request->validate([
            'captcha' => 'required|string',
        ]);

        // Retrieve CAPTCHA key from session
        $sessionCaptchaKey = Session::get('captcha.key');
        if (!$sessionCaptchaKey) {
            return response()->json(false, 200);
        }

        // Verify user input against session key
        if (password_verify($request->input('captcha'), $sessionCaptchaKey)) {
            return response()->json(true, 200);
        }

        return response()->json(false, 200);
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
