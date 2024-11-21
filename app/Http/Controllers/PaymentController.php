<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // public function createPaymentIntent(Request $request, $vendorid)
    // {
    //     print_r($request->all()); die;
    //     \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    //     $description = "Order for Vendor ID: $vendorid ";

    //     // Set up customer information
    //     $customerName = "Customer Full Name";  // Replace with the actual customer name
    //     $customerAddress = [
    //         'line1' => '123 Main St',   // Replace with the actual address
    //         'line2' => '',              // Optional
    //         'city' => 'Mumbai',         // Replace with the actual city
    //         'state' => 'MH',            // Replace with the actual state
    //         'postal_code' => '400001',  // Replace with the actual postal code
    //         'country' => 'IN'
    //     ];

    //     $intent = \Stripe\PaymentIntent::create([
    //         'amount' => 1000, // example amount in cents
    //         'currency' => 'usd',
    //         'description' => $description,
    //         'payment_method_types' => ['card'],
    //         'shipping' => [
    //             'name' => $customerName,
    //             'address' => $customerAddress,
    //         ],
    //     ]);

    //     return response()->json(['client_secret' => $intent->client_secret]);
    // }

    public function confirmPayment(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $paymentIntentId = $request->input('payment_intent_id');
        $intent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

        // Check if the PaymentIntent requires additional action
        if ($intent->status === 'requires_action') {
            return response()->json([
                'requires_action' => true,
                'client_secret' => $intent->client_secret,
            ]);
        }

        if ($intent->status === 'succeeded') {
            // Payment was successful
            return response()->json(['success' => true]);
        }

        // If payment confirmation fails
        return response()->json(['success' => false]);
    }
}
