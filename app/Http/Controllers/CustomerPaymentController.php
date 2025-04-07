<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StripeService;
use App\Models\Order;
use App\Models\CustomerOrder;
use App\Models\EventOrderDetail;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomerPaymentController extends Controller
{
    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function createSetupIntent(Request $request, $vendorid)
    {
        $customer = Auth::guard('customer')->user();
        // Create a Stripe Customer if needed
        if (!$customer->stripe_id) {
            $customer_data = [
                'email' => $customer->email,
                'name' => $customer->firstname . ' ' . $customer->lastname,
                'phone' => $customer->contact_number,
            ];
            $customer->stripe_id = $this->stripeService->createCustomer($customer_data);
            $customer->save();
        }
        // Create a Setup Intent for saving the payment method
        $setupIntent = $this->stripeService->setupIntent($customer->stripe_id);
        return response()->json([
            'client_secret' => $setupIntent->client_secret,
        ]);
    }

    /**
     * Save Payment Method and Set as Default
     */
    public function savePaymentMethod(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        $paymentMethodId = $request->payment_method_id;

        $paymentMethodId = $this->stripeService->attachPaymentMethod($customer->stripe_id, $paymentMethodId);
        // $user->update(['default_payment_method' => $paymentMethodId]);

        return response()->json(["success" => true, 'message' => 'Payment method saved successfully!']);
    }

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

    public function createPaymentIntent(Request $request, $vendorid)
    {
        $customer = Auth::guard('customer')->user();
        $payment_method_id = $request->payment_method_id;
        $order_id = $request->order_id;
        $vendor = Vendor::findOrFail($vendorid);
        if(!empty($request->order_type) && $request->order_type == 'event') {
            $order = CustomerOrder::find($order_id);
            $orderDetails = EventOrderDetail::where('customer_order_id', $order->id)->first();
            $order->name = $orderDetails->full_name;
            $order->email = $orderDetails->email;
            $order->street_address = $orderDetails->street_address;
            $order->contact_number = $orderDetails->contact_number;
            $order->suite = $orderDetails->unit_suite;
            $order->city = $orderDetails->city;
            $order->state = $orderDetails->state;
            $order->country = $orderDetails->country;
            $order->postal_code = $orderDetails->postal_code;
            $order->order_total = $order->total;
        } else {            
            $order = Order::find($order_id);
        }
        return $this->stripeService->createCustomerPaymentIntent($order, $vendor, $payment_method_id, $customer->stripe_id);
    }

    public function listPaymentMethods()
    {
        $customer = Auth::guard('customer')->user();
        $paymentMethods = $this->stripeService->listPaymentMethods($customer->stripe_id);
        $defaultPaymentMethod = $this->stripeService->getDefaultPaymentMethod($customer->stripe_id);
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

    public function setDefaultPaymentMethod(Request $request)
    {
        $customer = Auth::guard('customer')->user();
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

        $paymentMethodId = $data['payment_method_id'];

        $setDefault = $this->stripeService->setDefaultPaymentMethod($customer->vendor_stripe_id, $paymentMethodId);

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

    public function getDefaultPaymentMethod(Request $request)
    {
        $customer = Auth::guard('customer')->user();
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
        $paymentMethodId = $data['payment_method_id'];

        $getDefault = $this->stripeService->getDefaultPaymentMethod($customer->stripe_id, $paymentMethodId);

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


    public function removePaymentMethod(Request $request)
    {
        $customer = Auth::guard('customer')->user();
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

        $paymentMethodId = $data['payment_method_id'];

        if ($this->stripeService->isDefaultPaymentMethod($customer->stripe_id, $paymentMethodId)) {
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
        $customer = Auth::guard('customer')->user();
        $paymentMethods = $this->stripeService->listPaymentMethods($customer);
        $defaultPaymentMethod = $this->stripeService->getDefaultPaymentMethod($customer);
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
