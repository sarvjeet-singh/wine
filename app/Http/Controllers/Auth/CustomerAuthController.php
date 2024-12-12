<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Password;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.customer-login');
    }

    public function login(Request $request)
    {
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
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function resend(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:customers,email',
        ]);

        $user = Customer::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('customer.login')->with('error', 'Your email is already verified.');
        }

        // Send the verification email
        $user->sendEmailVerificationNotification();

        return redirect()->route('customer.login')->with('success', 'Verification link has been resent to your email address.');
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

        // Check if the hash matches the user's email verification hash
        if (hash_equals($hash, sha1($user->getEmailForVerification()))) {
            // Fulfill the email verification (mark the email as verified)
            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
            }

            // Log the user in
            Auth::guard('customer')->login($user);

            // Redirect to the dashboard with success message
            return redirect()->route('user-dashboard')->with('success', 'Email verified successfully. Welcome to your dashboard!');



            // Redirect with success message
            // return redirect()->route('customer.login')->with('success', 'Email verified successfully.');
        }

        // If verification fails, return an error
        return redirect()->route('customer.login')->withErrors(['error' => 'Invalid verification link.']);
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
}
