<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ConfigurationSetting;

class ConfigurationSettingController extends Controller
{
    public function index()
    {
        $settings = ConfigurationSetting::all();
        return view('admin.configuration-settings.index', compact('settings'));
    }

    public function edit($id)
    {
        try {
            $setting = ConfigurationSetting::findOrFail($id);
            return response()->json([
                'status' => true,
                'data' => $setting,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to fetch the setting: ' . $e->getMessage(),
            ], 404);
        }
    }

    public function storeUpdate(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'id'    => 'nullable|exists:configuration_settings,id',
                'title' => 'required|string|max:255',
                'key'   => 'required|string|max:255|unique:configuration_settings,key,' . $request->id,
                'value' => 'required|string',
            ]);

            if ($request->id) {
                // Update existing record
                $setting = ConfigurationSetting::findOrFail($request->id);
                $setting->update($validatedData);

                return response()->json([
                    'status'  => "success",
                    'message' => 'Settings updated successfully.',
                ]);
            }

            // Create a new record
            ConfigurationSetting::create($validatedData);

            return response()->json([
                'status'  => "success",
                'message' => 'Settings created successfully.',
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions and return an error response
            return response()->json([
                'status'  => "error",
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}
