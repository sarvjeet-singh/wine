<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\Vendor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class VendorAuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('vendor')->check()) {
            return redirect('/vendor-dashboard/' . Auth::guard('vendor')->user()->id);
        }
        return view('auth.vendor-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('vendor')->attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::guard('vendor')->user();
            $vendor = Vendor::where('user_id', $user->id)->first();
            if ($vendor) {
                if ($user->password_updated == 0) {
                    return redirect()->intended('/vendor-change-password/' . $vendor->id);
                }
                return redirect()->intended('/vendor-dashboard/' . $vendor->id);
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('vendor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('vendor.login');
    }
}
