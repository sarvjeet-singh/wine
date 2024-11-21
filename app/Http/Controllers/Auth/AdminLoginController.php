<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    protected $redirectTo = '/admin/dashboard';
    // Show the admin login form
    public function showLoginForm()
    {
        return view('auth.admin-login'); // Create a custom admin login view
    }

    // Handle admin login
    public function login(Request $request)
    {
        // Validate the form data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt to log the user in with 'admin' role
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'admin'])) {
            // Redirect to admin dashboard if successful
            return redirect()->intended('/admin/dashboard');
        }

        // If the login attempt failed, redirect back with error
        return redirect()->back()->withErrors(['email' => 'These credentials do not match our records or you are not an admin.']);
    }

    // Logout admin
    public function logout()
    {
        Auth::logout();
        return redirect('/admin/login');
    }
}