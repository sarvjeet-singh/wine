<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Vendor;
use App\Models\VendorStripeDetail;
use Illuminate\Support\Facades\Crypt;

class VendorStripeDetailController extends Controller
{

    public function show($vendorid)
    {
        $vendor = Vendor::find($vendorid);
        $stripeDetail = VendorStripeDetail::where('vendor_id', $vendorid)->first();

        // Decrypt sensitive fields before passing to the view
        if ($stripeDetail) {
            $stripeDetail->stripe_secret_key = Crypt::decryptString($stripeDetail->stripe_secret_key);
            if (!empty($stripeDetail->webhook_secret_key)) {
                $stripeDetail->webhook_secret_key = Crypt::decryptString($stripeDetail->webhook_secret_key);
            }
        }

        return view('VendorDashboard.stripe-details-form', compact('vendor', 'stripeDetail'));
    }
    public function update(Request $request, $vendorid)
    {
        try {
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'stripe_account_id' => 'nullable|string',
                'webhook_endpoint' => 'nullable|string',
                'stripe_publishable_key' => 'required|string',
                'stripe_secret_key' => 'required|string',
                'webhook_secret_key' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422); // Return validation errors
            }

            $data = $validator->validated();
            $data['vendor_id'] = $vendorid;

            // Encrypt sensitive fields before saving/updating
            $data['stripe_secret_key'] = Crypt::encryptString($data['stripe_secret_key']);
            if (isset($data['webhook_secret_key']) && $data['webhook_secret_key']) {
                $data['webhook_secret_key'] = Crypt::encryptString($data['webhook_secret_key']);
            }

            // Check if credentials already exist for the vendor
            $existingCredential = VendorStripeDetail::where('vendor_id', $vendorid)->first();

            if ($existingCredential) {
                // Update existing record if found
                $existingCredential->update($data);
                return response()->json(['message' => 'Stripe credentials updated successfully!'], 200);
            } else {
                // Create new record if not found
                VendorStripeDetail::create($data);
                return response()->json(['message' => 'Stripe credentials saved successfully!'], 201);
            }
        } catch (\Exception $e) {
            // Handle any unexpected errors
            return response()->json([
                'message' => 'An error occurred while updating the Stripe credentials.',
                'error' => $e->getMessage(),
            ], 500); // Internal server error
        }
    }
}
