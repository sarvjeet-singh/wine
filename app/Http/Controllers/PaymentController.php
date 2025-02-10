<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StripeService;
use App\Models\WineryOrder;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function createSetupIntent(Request $request, $vendorid)
    {
        $vendor = Vendor::findOrFail($vendorid);
        // Create a Stripe Customer if needed
        if (!$vendor->vendor_stripe_id) {
            $vendor_data = [
                'email' => $vendor->vendor_email,
                'name' => $vendor->name,
            ];
            $vendor->vendor_stripe_id = $this->stripeService->createCustomer($vendor_data);
            $vendor->save();
        }
        // Create a Setup Intent for saving the payment method
        $setupIntent = $this->stripeService->setupIntent($vendor->vendor_stripe_id);
        return response()->json([
            'client_secret' => $setupIntent->client_secret,
        ]);
    }

    /**
     * Save Payment Method and Set as Default
     */
    public function savePaymentMethod(Request $request, $vendorid)
    {
        $vendor = Vendor::findOrFail($vendorid);
        $paymentMethodId = $request->payment_method_id;

        $paymentMethodId = $this->stripeService->attachPaymentMethod($vendor->vendor_stripe_id, $paymentMethodId);
        // $user->update(['default_payment_method' => $paymentMethodId]);

        return response()->json(["success" => true, 'message' => 'Payment method saved successfully!']);
    }

    /**
     * Process Payment and Store Transaction
     */
    // public function processPayment(Request $request)
    // {
    //     $user = Auth::user();
    //     $order = Order::findOrFail($request->order_id);
    //     $amount = $order->total_amount;

    //     $paymentIntent = $this->stripeService->createPaymentIntent($user, $amount);
    //     $this->stripeService->saveTransaction($order->id, $paymentIntent);

    //     return response()->json([
    //         'message' => 'Payment successful!',
    //         'paymentIntent' => $paymentIntent
    //     ]);
    // }

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

        if ($intent->status === 'requires_capture') {
            return response()->json(['success' => true]);
        }

        if ($intent->status === 'succeeded') {
            // Payment was successful
            return response()->json(['success' => true]);
        }

        // If payment confirmation fails
        return response()->json(['success' => false]);
    }

    public function createPaymentIntent(Request $request, $shopid, $vendorid)
    {
        $payment_method_id = $request->payment_method_id;
        $order_id = $request->order_id;
        $vendor = Vendor::findOrFail($vendorid);;
        $shop = Vendor::findOrFail($shopid);;
        $order = WineryOrder::find($order_id);
        return $this->stripeService->createPaymentIntent($order, $shop, $vendor, $payment_method_id, $vendor->vendor_stripe_id);
    }

    public function listPaymentMethods($vendorid)
    {
        $vendor = Vendor::findOrFail($vendorid);
        $paymentMethods = $this->stripeService->listPaymentMethods($vendor->vendor_stripe_id);
        $defaultPaymentMethod = $this->stripeService->getDefaultPaymentMethod($vendor->vendor_stripe_id);
        // Format response properly
        $formattedMethods = [];
        foreach ($paymentMethods as $method) {
            $formattedMethods[] = [
                "id" => $method->id,
                "brand" => ucfirst($method->card->brand), // Visa, MasterCard, etc.
                "last4" => $method->card->last4,
                "exp_month" => $method->card->exp_month,
                "exp_year" => $method->card->exp_year,
                "is_default" => ($defaultPaymentMethod && $defaultPaymentMethod == $method->id)
            ];
        }

        return response()->json([
            "success" => true,
            "message" => count($formattedMethods) > 0 ? "Payment methods retrieved successfully!" : "No payment methods found!",
            "data" => $formattedMethods,
        ]);
    }

    public function setDefaultPaymentMethod(Request $request, $vendorid)
    {
        $validator = Validator::make($request->all(), [
            'payment_method_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ]
            );
        }
        $data = $validator->validated();
        $vendor = Vendor::findOrFail($vendorid);

        $paymentMethodId = $data['payment_method_id'];

        $setDefault = $this->stripeService->setDefaultPaymentMethod($vendor->vendor_stripe_id, $paymentMethodId);

        if (!$setDefault) {
            return response()->json(
                [
                    "success" => false,
                    'message' => 'Payment method set as default failed!'
                ],
                401
            );
        }

        return response()->json(
            [
                "success" => true,
                'message' => 'Payment method set as default successfully!',
                "data" => $setDefault
            ]
        );
    }

    public function getDefaultPaymentMethod(Request $request, $vendorid)
    {
        $validator = Validator::make($request->all(), [
            'payment_method_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ]
            );
        }
        $data = $validator->validated();
        $vendor = Vendor::findOrFail($vendorid);
        $paymentMethodId = $data['payment_method_id'];

        $getDefault = $this->stripeService->getDefaultPaymentMethod($vendor->vendor_stripe_id, $paymentMethodId);

        if (!$getDefault) {
            return response()->json(
                [
                    "success" => false,
                    'message' => 'Get default payment method failed!'
                ],
                401
            );
        }

        return response()->json(
            [
                "success" => true,
                'message' => 'Get default payment method successfully!',
                'data' => $getDefault
            ]
        );
    }

    public function removePaymentMethod(Request $request, $vendorid)
    {
        $validator = Validator::make($request->all(), [
            'payment_method_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors(),
                ]
            );
        }
        $data = $validator->validated();
        $vendor = Vendor::findOrFail($vendorid);

        $paymentMethodId = $data['payment_method_id'];

        if ($this->stripeService->isDefaultPaymentMethod($vendor->vendor_stripe_id, $paymentMethodId)) {
            return response()->json(
                [
                    "success" => false,
                    'message' => 'Default payment method can not be removed!'
                ],
                401
            );
        }

        if (!$this->stripeService->getPaymentMethod($paymentMethodId)) {
            return response()->json(
                [
                    "success" => false,
                    'message' => 'Payment method not attached to user!'
                ],
                401
            );
        }

        $removed = $this->stripeService->removePaymentMethod($paymentMethodId);

        if (!$removed) {
            return response()->json(
                [
                    "success" => false,
                    'message' => 'Remove payment method failed!'
                ],
                401
            );
        }

        return response()->json(
            [
                "success" => true,
                'message' => 'Remove payment method successfully!',
                "data" => $removed
            ]
        );
    }

    public function paymentReturn()
    {
        $user = Auth::guard('vendor')->user();
        $paymentMethods = $this->stripeService->listPaymentMethods($user);
        $defaultPaymentMethod = $this->stripeService->getDefaultPaymentMethod($user);
        $paymentMethods['default_payment_method'] = $defaultPaymentMethod;
        if (count($paymentMethods) == 0) {
            return response()->json(
                [
                    "success" => false,
                    'message' => 'No payment methods found!'
                ],
                401
            );
        }
        return response()->json(
            [
                "success" => true,
                'message' => 'Payment methods retrieved successfully!',
                'data' => $paymentMethods,
            ]
        );
    }
}
