<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleAndPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        // Check user type and vendor-specific role
        if (!$user->roles->contains(fn($role) => $role->type === 'vendor' && $role->vendor_id === $request->vendor_id)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
