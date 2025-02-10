<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Vendor;
use App\Models\VendorStripeDetail;
use Illuminate\Support\Facades\Crypt;
use Stripe\Stripe;
use Stripe\OAuth;

class VendorStripeDetailController extends Controller
{

    public function show($vendorid)
    {
        $vendor = Vendor::find($vendorid);
        $oauthUrl = 'https://connect.stripe.com/oauth/authorize?' . http_build_query([
            'response_type' => 'code',
            'client_id' => env('STRIPE_CLIENT_ID'), // Set this in your .env file
            'scope' => 'read_write',
            'state' => $vendorid, // Pass vendor ID securely
            'redirect_uri' => route('handle-stripe-callback')
        ]);

        return view('VendorDashboard.stripe-details-form', compact('vendor', 'oauthUrl'));
    }

    public function handleStripeCallback(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        if ($request->has('code')) {
            $response = OAuth::token([
                'grant_type' => 'authorization_code',
                'code' => $request->code,
            ]);

            $stripeAccountId = $response->stripe_user_id; // This is the existing Stripe account ID

            // Save this Stripe account ID in your user's record
            $vendor = Vendor::find($request->state);
            $vendor->stripe_account_id = $stripeAccountId;
            $vendor->save();

            return redirect()->route('stripe.details.show', $request->state)->with('success', 'Stripe account connected successfully!');
        }

        return redirect()->route('stripe.details.show', $request->state)->with('error', 'Failed to connect Stripe account.');
    }

    // public function update(Request $request, $vendorid)
    // {
    //     try {
    //         // Validate the incoming request data
    //         $validator = Validator::make($request->all(), [
    //             'stripe_account_id' => 'nullable|string',
    //             'webhook_endpoint' => 'nullable|string',
    //             'stripe_publishable_key' => 'required|string',
    //             'stripe_secret_key' => 'required|string',
    //             'webhook_secret_key' => 'nullable|string',
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json($validator->errors(), 422); // Return validation errors
    //         }

    //         $data = $validator->validated();
    //         $data['vendor_id'] = $vendorid;

    //         // Encrypt sensitive fields before saving/updating
    //         $data['stripe_secret_key'] = Crypt::encryptString($data['stripe_secret_key']);
    //         if (isset($data['webhook_secret_key']) && $data['webhook_secret_key']) {
    //             $data['webhook_secret_key'] = Crypt::encryptString($data['webhook_secret_key']);
    //         }

    //         // Check if credentials already exist for the vendor
    //         $existingCredential = VendorStripeDetail::where('vendor_id', $vendorid)->first();

    //         if ($existingCredential) {
    //             // Update existing record if found
    //             $existingCredential->update($data);
    //             return response()->json(['message' => 'Stripe credentials updated successfully!'], 200);
    //         } else {
    //             // Create new record if not found
    //             VendorStripeDetail::create($data);
    //             return response()->json(['message' => 'Stripe credentials saved successfully!'], 201);
    //         }
    //     } catch (\Exception $e) {
    //         // Handle any unexpected errors
    //         return response()->json([
    //             'message' => 'An error occurred while updating the Stripe credentials.',
    //             'error' => $e->getMessage(),
    //         ], 500); // Internal server error
    //     }
    // }
}
