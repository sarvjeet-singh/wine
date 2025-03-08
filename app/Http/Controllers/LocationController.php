<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    /**
     * Store user location.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Log the received location for debugging
        // Check if the location has already been logged today
        if (!$request->cookie('location_logged')) {
            Log::channel('location')->info('Received location:', [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'ip' => $request->ip(),
                'data' => json_encode($request->data),
            ]);

            // Set a cookie that expires in 24 hours
            return response()->json(['message' => 'Location saved'])
                ->cookie('location_logged', true, 1440); // 1440 minutes = 24 hours
        }
        // Optionally, save to database if needed
        // Example: Saving user location to a table
        // \App\Models\UserLocation::create([
        //     'user_id' => auth()->id(),
        //     'latitude' => $request->latitude,
        //     'longitude' => $request->longitude,
        // ]);

        return response()->json([
            'message' => 'Location saved',
            'data' => $request->only(['latitude', 'longitude']),
        ]);
    }
}
