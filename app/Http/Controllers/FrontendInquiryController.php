<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\InquiryMail;
use App\Models\AccommodationInquiry;
use App\Models\ExcursionInquiry;
use App\Models\WineryInquiry;
use App\Models\Vendor;
use Exception;
use Auth;
use Mail;

class FrontendInquiryController extends Controller
{
    public function storeAccommodation(Request $request)
    {
        try {
            $validated = $request->validate([
                'vendor_id' => 'required|integer',
                'check_in_date' => 'required|date',
                'check_out_date' => 'required|date',
                'visit_nature' => 'required|array',
                'number_of_guests' => 'required|integer',
                'accommodation_type' => 'required|array',
                'city' => 'required|string',
                'rooms_or_beds' => 'required|integer',
                'additional_comments' => 'nullable|string',
            ]);
            $vendor = Vendor::with('sub_category')->findOrFail($validated['vendor_id']);
            $validated['customer_id'] = Auth::guard('customer')->id();

            AccommodationInquiry::create($validated);

            $data = [
                'vendor' => $vendor,
                'inquiry' => $validated,
                'user' => Auth::guard('customer')->user()
            ];

            $data['inquiry']['visit_nature'] = implode(', ',$data['inquiry']['visit_nature']);
            $data['inquiry']['accommodation_type'] = implode(', ',$data['inquiry']['accommodation_type']);
            
            Mail::to(env('ADMIN_EMAIL'))->send(new InquiryMail($data, 'emails.accommodation_inquiry')); 
            die;

            return response()->json(['success' => true, 'message' => 'Accommodation inquiry saved successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred. Please try again.', 'error' => $e->getMessage()], 500);
        }
    }

    public function storeExcursion(Request $request)
    {
        try {
            $validated = $request->validate([
                'vendor_id' => 'required|integer',
                'check_in_date' => 'required|date',
                'check_out_date' => 'required|date',
                'visit_nature' => 'required|array',
                'number_of_guests' => 'required|integer',
                'city' => 'required|string',
                'preferred_excursions' => 'required|array',
                'additional_comments' => 'nullable|string',
            ]);
            $vendor = Vendor::with('sub_category')->findOrFail($validated['vendor_id']);
            $validated['customer_id'] = Auth::guard('customer')->id();

            ExcursionInquiry::create($validated);

            $data = [
                'vendor' => $vendor,
                'inquiry' => $validated,
                'user' => Auth::guard('customer')->user()
            ];

            $data['inquiry']['visit_nature'] = implode(', ',$data['inquiry']['visit_nature']);
            $data['inquiry']['preferred_excursions'] = implode(', ',$data['inquiry']['preferred_excursions']);

            Mail::to(env('ADMIN_EMAIL'))->send(new InquiryMail($data, 'emails.excursion_inquiry'));

            return response()->json(['success' => true, 'message' => 'Excursion inquiry saved successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred. Please try again.', 'error' => $e->getMessage()], 500);
        }
    }

    public function storeWinery(Request $request)
    {
        try {
            $validated = $request->validate([
                'vendor_id' => 'required|integer',
                'check_in_date' => 'required|date',
                'check_out_date' => 'required|date',
                'visit_nature' => 'required|array',
                'number_of_guests' => 'required|integer',
                'experience_preference' => 'required|string',
                'sub_region' => 'required|string',
                'winery_types' => 'required|array',
                'additional_comments' => 'nullable|string',
            ]);
            $vendor = Vendor::with('sub_category')->findOrFail($validated['vendor_id']);
            $validated['customer_id'] = Auth::guard('customer')->id();

            WineryInquiry::create($validated);

            $data = [
                'vendor' => $vendor,
                'inquiry' => $validated,
                'user' => Auth::guard('customer')->user()
            ];

            $data['inquiry']['visit_nature'] = implode(', ',$data['inquiry']['visit_nature']);
            $data['inquiry']['winery_types'] = implode(', ',$data['inquiry']['winery_types']);

            Mail::to(env('ADMIN_EMAIL'))->send(new InquiryMail($data, 'emails.winery_inquiry'));

            return response()->json(['success' => true, 'message' => 'Winery inquiry saved successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred. Please try again.', 'error' => $e->getMessage()], 500);
        }
    }
}
