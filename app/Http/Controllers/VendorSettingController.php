<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessHour;
use Illuminate\Support\Facades\DB;

class VendorSettingController extends Controller
{
    public function getBusinessHours(Request $request, $vendor_id)
    {
        $timeOptions = $this->getTimeOptions();
        $businessHours = BusinessHour::where('vendor_id', $vendor_id)->get();
        // show view
        return view('VendorDashboard.business-hours', compact('businessHours', 'timeOptions', 'vendor_id'));
    }
    public function updateBusinessHours(Request $request, $vendor_id)
    {
        // // Wrap the operation in a database transaction
        // DB::beginTransaction();

        // try {
            $validated = $request->validate([ // Validate the vendor ID
                'hours' => 'required|array',
                'hours.*.opening_time' => 'nullable|date_format:H:i',
                'hours.*.closing_time' => 'nullable|date_format:H:i',
                'hours.*.is_open' => 'nullable|boolean',
            ]);
            foreach ($validated['hours'] as $day => $hour) {
                // Check if a record already exists for the vendor and the day
                $businessHour = BusinessHour::where('vendor_id', $vendor_id)
                    ->where('day', ucfirst($day))
                    ->first();

                // If exists, update it; otherwise, create a new one
                if ($businessHour) {
                    $businessHour->update([
                        'opening_time' => $hour['opening_time'] ?? null,
                        'closing_time' => $hour['closing_time'] ?? null,
                        'is_open' => isset($hour['is_open']) ? 1 : 0,
                    ]);
                } else {
                    $data = [
                        'vendor_id' => $vendor_id,
                        'day' => ucfirst($day),
                        'opening_time' => $hour['opening_time'] ?? null,
                        'closing_time' => $hour['closing_time'] ?? null,
                        'is_open' => isset($hour['is_open']) ? 1 : 0,
                    ];
                    BusinessHour::create($data);
                }
            }
            // Commit the transaction
            // DB::commit();

            return redirect()->route('business-hours.index', $vendor_id)->with('success', 'Business hours saved successfully!');
        // } catch (\Exception $e) {
        //     // Rollback the transaction if anything goes wrong
        //     DB::rollBack();

        //     // Optionally, you can log the error for debugging purposes
        //     // Log::error('Business hours update failed: ' . $e->getMessage());

        //     return redirect()->back()->withErrors(['error' => 'Failed to update business hours. Please try again.']);
        // }
    }

    public function getTimeOptions($interval = 20)
    {
        $times = [];

        // Loop from 00:00 to 23:59 with a 20-minute interval
        for ($hour = 0; $hour < 24; $hour++) {
            for ($minute = 0; $minute < 60; $minute += $interval) {
                $time = sprintf('%02d:%02d', $hour, $minute);
                $times[$time] = $time;  // Use the same value for option text and value
            }
        }

        return $times;
    }
}
