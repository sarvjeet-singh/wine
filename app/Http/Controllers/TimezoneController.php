<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimezoneController extends Controller
{
    public function setTimezone(Request $request)
    {
        $timezone = $request->input('timezone');

        // Store in session or database
        session(['timezone' => $timezone]);

        return response()->json(['message' => 'Timezone saved successfully!']);
    }
}
