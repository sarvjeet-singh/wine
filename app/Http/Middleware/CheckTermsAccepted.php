<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckTermsAccepted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('customer')->user();

        // Check if the user is logged in and hasn't accepted terms
        if ($user && is_null($user->terms_accepted_at)) {
            // Redirect to the terms popup route
            return redirect()->route('customer.terms.popup');
        }

        return $next($request);
    }
}
