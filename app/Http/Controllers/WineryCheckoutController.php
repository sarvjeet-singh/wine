<?php

namespace App\Http\Controllers;

use App\Models\AdminSetting;
use Illuminate\Http\Request;

use App\Models\WineryCart;
use App\Models\WineryOrder;
use App\Models\WineryOrderWine;
use App\Models\WineryOrderTransaction;
use App\Models\Vendor;
use App\Models\VendorWine;
use App\Models\VendorStripeDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use DB;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class WineryCheckoutController extends Controller
{
    public function index($shopid, $vendorid)
    {
        $cart = WineryCart::with('items.product')
            ->where('user_id', Auth::id())
            ->where('shop_id', $shopid)
            ->where('vendor_id', $vendorid)
            ->first();

        $cartTotal = 0.00;
        $totalQuantity = 0;

        if ($cart) {
            foreach ($cart->items as $item) {
                $cartTotal += $item->product->price * $item->quantity;
                $totalQuantity += $item->quantity; // Calculate the total quantity
            }
        }

        if (isset($cartTotal) && $cartTotal == 0.00) {
            return redirect()->route('cart.index', ['shopid' => $shopid, 'vendorid' => $vendorid]);
        }

        $cartTotal = number_format($cartTotal, 2, '.', '');

        $deliveryData = AdminSetting::where('option_name', 'delivery_fee')->first();
        $deliveryFee = $deliveryData ? $deliveryData->option_value : 0.00;

        // Set delivery fee to zero if total quantity is 12 or more
        if ($totalQuantity >= 12) {
            $deliveryFee = 0.00;
        }

        $vendor = Vendor::with('stripeDetails')->find($shopid);
        return view('VendorDashboard.winery.checkout', compact('shopid', 'vendorid', 'vendor', 'cartTotal', 'deliveryFee'));
    }

    public function checkout(Request $request, $shopid, $vendorid)
    {
        $request->validate([
            // Billing Address
            'billing_first_name' => 'required|string',
            'billing_last_name' => 'required|string',
            'billing_phone' => 'required|string',
            'billing_email' => 'required|string',
            'billing_street' => 'required|string',
            'billing_street2' => 'nullable|string',
            'billing_city' => 'required|string',
            'billing_unit' => 'nullable|string',
            'billing_state' => 'required|string',
            'billing_postal_code' => 'required|string',
            'billing_country' => 'required|string',

            // Shipping Address
            // Shipping fields
            'shipping_first_name' => 'nullable|string',
            'shipping_last_name' => 'nullable|string',
            'shipping_phone' => 'nullable|string',
            'shipping_email' => 'nullable|email',
            'shipping_street' => 'nullable|string',
            'shipping_street2' => 'nullable|string',
            'shipping_city' => 'nullable|string',
            'shipping_unit' => 'nullable|string',
            'shipping_state' => 'nullable|string',
            'shipping_postal_code' => 'nullable|string',
            'shipping_country' => 'nullable|string',
            'delivery_type' => 'required|string|in:delivery,pickup',
        ]);

        $cart = WineryCart::with('items.product')
            ->where('user_id', Auth::id())
            ->where('shop_id', $shopid)
            ->where('vendor_id', $vendorid)
            ->first();

        $cartTotal = 0.00;
        $totalQuantity = 0;

        if ($cart) {
            foreach ($cart->items as $item) {
                $cartTotal += $item->product->price * $item->quantity;
                $totalQuantity += $item->quantity; // Calculate the total quantity
            }
        }

        if (isset($cartTotal) && $cartTotal == 0.00) {
            return redirect()->route('cart.index', ['shopid' => $shopid, 'vendorid' => $vendorid]);
        }

        $cartTotal = number_format($cartTotal, 2, '.', '');

        $deliveryData = AdminSetting::where('option_name', 'delivery_fee')->first();
        $deliveryFee = $deliveryData ? $deliveryData->option_value : 0.00;

        // Set delivery fee to zero if total quantity is 12 or more
        if ($totalQuantity >= 12) {
            $deliveryFee = 0.00;
        }
        
        DB::beginTransaction();
        $data = [
            'user_id' => Auth::id(),
            'vendor_buyer_id' => $vendorid,
            'vendor_seller_id' => $shopid,
            'subtotal_price' => $cartTotal, // Total cart amount
            'delivery_charges' => (!empty($request->input('delivery_type')) && $request->input('delivery_type') == 'delivery') ? $deliveryFee : 0.00, // Total cart amount
            'total_price' => $cartTotal + $deliveryFee, // Total cart amount
            'status' => 'pending',
            // Billing Details
            'billing_first_name' => $request->input('billing_first_name'),
            'billing_last_name' => $request->input('billing_last_name'),
            'billing_phone' => $request->input('billing_phone'),
            'billing_email' => $request->input('billing_email'),
            'billing_street' => $request->input('billing_street') . ' ' . $request->input('billing_street2'),
            'billing_unit' => $request->input('billing_unit'),
            'billing_city' => $request->input('billing_city'),
            'billing_state' => $request->input('billing_state'),
            'billing_postal_code' => $request->input('billing_postal_code'),
            'billing_country' => $request->input('billing_country'),
            'delivery' => (!empty($request->input('delivery_type')) && $request->input('delivery_type') == 'delivery') ? 1 : 0,

            // Shipping Details
            'shipping_first_name' => $request->input('shipping_first_name'),
            'shipping_last_name' => $request->input('shipping_last_name'),
            'shipping_phone' => $request->input('shipping_phone'),
            'shipping_email' => $request->input('shipping_email'),
            'shipping_street' => $request->input('shipping_street') . ' ' . $request->input('shipping_street2'),
            'shipping_unit' => $request->input('shipping_unit'),
            'shipping_city' => $request->input('shipping_city'),
            'shipping_state' => $request->input('shipping_state'),
            'shipping_postal_code' => $request->input('shipping_postal_code'),
            'shipping_country' => $request->input('shipping_country'),
        ];

        try {
            // Step 1: Create the Order
            $order = WineryOrder::create($data);

            // Step 2: Create OrderWines for each item in the cart
            foreach ($cart['items'] as $key => $item) {
                WineryOrderWine::create([
                    'winery_order_id' => $order->id,
                    'vendor_wine_id' => $item['product']['id'],
                    'wine_name' => $item['product']['series'],
                    'quantity' => $item['quantity'],
                    'price' => $item['product']['price'] ?? 0.00,
                ]);
            }

            // delete cart
            $cart->items()->delete();
            $cart->delete();
            // also clear items

            DB::commit();

            // Set up customer information
            $customerName = $request->input('billing_first_name') . ' ' . $request->input('billing_last_name');

            // Step 3: Create Payment Intent
            $description = "Order Payment for Customer Name $customerName and Order ID: " . $order->id;


            $customerAddress = [
                'line1' => $request->input('billing_street'),
                'line2' => $request->input('billing_street2'),
                'city' => $request->input('billing_city'),
                'state' => $request->input('billing_state'),
                'postal_code' => $request->input('billing_postal_code'),
                'country' => 'CA',
            ];

            $stripeDetail = VendorStripeDetail::where('vendor_id', $shopid)->first();
            Stripe::setApiKey(Crypt::decryptString($stripeDetail->stripe_secret_key));

            $intent = PaymentIntent::create([
                'amount' => $cartTotal * 100,
                'currency' => 'usd',
                'description' => $description,
                'payment_method_types' => ['card'],
                'shipping' => [
                    'name' => $customerName,
                    'address' => $customerAddress,
                ],
                'metadata' => [
                    'customer_email' => $request->input('shipping_email'),
                    'customer_name' => $customerName,
                ],
            ]);
            //return response()->json(['client_secret' => $intent->client_secret]);



            return response()->json([
                'message' => 'Order placed successfully!',
                'client_secret' => $intent->client_secret,
                'order_id' => $order->id
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Failed to place the order. Please try again.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function storeTransactionDetails(Request $request)
    {
        $order_id = $request->input('order_id');
        $payment_intent_id = $request->input('payment_intent_id');
        $transaction = WineryOrderTransaction::where('winery_order_id', $order_id)->first();
        if ($transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction already exists for this order.',
                // 'transaction' => $transaction
            ], 200);
        }
        $order = WineryOrder::find($order_id);
        $stripeDetail = VendorStripeDetail::where('vendor_id', $order->vendor_seller_id)->first();
        Stripe::setApiKey(Crypt::decryptString($stripeDetail->stripe_secret_key));
        $paymentIntent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
        $transactionData = [
            'winery_order_id' => $order_id,
            'transaction_id' => $paymentIntent->id,
            'amount' => $paymentIntent->amount / 100, // Stripe amount is in cents
            'currency' => $paymentIntent->currency,
            'status' => $paymentIntent->status,
            'payment_method' => $paymentIntent->payment_method,
            'card_brand' => $paymentIntent->charges->data[0]->payment_method_details->card->brand ?? null,
            'card_last4' => $paymentIntent->charges->data[0]->payment_method_details->card->last4 ?? null,
            'receipt_url' => $paymentIntent->charges->data[0]->receipt_url ?? null,
            'billing_details' => $paymentIntent->charges->data[0]->billing_details ?? null,
            'transaction_created_at' => \Carbon\Carbon::createFromTimestamp($paymentIntent->created),
        ];
        VendorWine::updateWineStock($transactionData['winery_order_id']);
        WineryOrderTransaction::create($transactionData);
        return response()->json([
            'success' => true,
            'message' => 'Transaction details stored successfully.',
            'transaction' => $transaction
        ], 201);
    }
}
