<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;

class CheckVendorAuthorization
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
        $user = Auth::user();
        if($user->master_user == 1){
            $vendorid = $request->route('vendorid');
            if (is_null($vendorid) || !Vendor::where('id', $vendorid)->exists()) {
                abort(404, 'No vendor found for the given vendorid in the URL. Please check the URL and try again.');
            }
            return $next($request);
        }

        // Check if vendorid is present in the URL and is valid
        $vendorid = $request->route('vendorid');
        if (is_null($vendorid) || !Vendor::where('id', $vendorid)->where('user_id', $user->id)->exists()) {
            // Get the first vendor ID associated with the authenticated user
            $vendor = Vendor::where('user_id', $user->id)->first();

            if ($vendor) {
                // Redirect to the same route with the vendorid parameter
                return redirect()->route($request->route()->getName(), ['vendorid' => $vendor->id]);
            } else {
                // Handle the case where no vendor is found for the authenticated user
                return redirect()->back()->with('error', 'No vendor found.');
            }
        }

        return $next($request);
    }
}
