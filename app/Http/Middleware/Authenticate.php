<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        // Check if the request is for admin routes and redirect to admin login
        if ($request->routeIs('admin.*')) {
            return route('admin.login'); // Ensure this route exists in your routes
        }
        // Check if the request is for vendor routes and redirect to vendor login
        if ($request->routeIs('vendor*')) {
            return route('vendor.login'); // Ensure this route exists in your routes
        }
        // Default redirection for other guards or routes
        return route('customer.login');
    }
}
