<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CheckPasswordUpdated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Allow vendor to access password change routes without restriction
        if (in_array(Route::currentRouteName(), ['vendor-change-password', 'vendor-password-update','vendor-skip-password'])) {
            return $next($request);
        }

        // Check if vendor is authenticated and password is not updated
        if (Auth::guard('vendor')->check() && Auth::guard('vendor')->user()->password_updated == 0) {
            return redirect()->route('vendor-change-password', Auth::guard('vendor')->user()->id);
        }

        return $next($request);
    }
}
