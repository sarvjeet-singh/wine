<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\OrderTransaction;
use App\Models\Vendor;
use App\Models\Inquiry;
use App\Models\Wallet;
use App\Http\Controllers\WalletController;
use App\Services\StripeService;
use App\Helpers\SeasonHelper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendorInquiryMail;

class OrderController extends Controller
{

    private $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        echo 'here';
        die;
        return view('UserDashboard.get-orders');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function authorizePayment(Request $request)
    {
        $request->validate([
            // Billing Address
            'name' => 'required|string',
            'email_address' => 'required|string',
            'contact_number' => 'required|string',
            'street_address' => 'required|string',
            'suite' => 'nullable|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'postal_code' => 'required|string',
            "payment_method_id" => 'nullable|string',
            'wallet_used' => 'required|string',
        ]);

        try {
            $booking = Session::get('booking');
            $booking_data = $request->all();
            $customer = Auth::guard('customer')->user();
            $currentDate = now();
            $season = SeasonHelper::getSeasonAndPrice($currentDate, $booking['vendor_id']);
            $wallet_used = 0.00;
            $wallet = Wallet::where('customer_id', Auth::guard('customer')->user()->id)->first();
            if ($request->wallet_used > 0 && ($wallet->balance >= $request->wallet_used)) {
                $wallet_used = $request->wallet_used;
            }
            if (isset($booking_data['selectedExperiences']) && !empty($booking_data['selectedExperiences'])) {
                $booking_data['selectedExperiences'] = json_decode($booking_data['selectedExperiences'], true);
            }
            $total_experiences = number_format(array_sum(array_column($booking_data['selectedExperiences'], 'value')), 2, '.', '');
            $vendor = Vendor::with('pricing')->where('id', $booking['vendor_id'])->first();
            $cleaning_fee = number_format(!empty($vendor->accommodationMetadata->cleaning_fee_amount) ? $vendor->accommodationMetadata->cleaning_fee_amount : 0, 2, '.', '');
            $security_deposit = number_format(!empty($vendor->accommodationMetadata->security_deposit_amount) ? $vendor->accommodationMetadata->security_deposit_amount : 0, 2, '.', '');
            $pet_fee = number_format(!empty($vendor->accommodationMetadata->pet_boarding) ? $vendor->accommodationMetadata->pet_boarding : 0, 2, '.', '');
            $tax_rate = !empty($vendor->accommodationMetadata->applicable_taxes_amount) ? $vendor->accommodationMetadata->applicable_taxes_amount : '';
            $sub_total = ($season['price'] * $booking['days']) + $total_experiences + $cleaning_fee + $security_deposit + $pet_fee - $wallet_used;
            $tax = ($sub_total * $tax_rate) / 100;
            $grand_total = $sub_total + $tax;

            $inquiry = null;
            $rate_basic = $season['price'];
            $experiences_total = number_format($total_experiences, 2, '.', '');

            $order_total = number_format($grand_total, 2, '.', '');
            $inquiry_id = null;
            if (!empty($booking['apk'])) {
                $inquiry = Inquiry::where('apk', $booking['apk'])->first();
                $rate_basic = $inquiry->rate_basic;
                $experiences_total = number_format($inquiry->experiences_total, 2, '.', '');
                $cleaning_fee = number_format($inquiry->cleaning_fee, 2, '.', '');
                $security_deposit = number_format($inquiry->security_deposit, 2, '.', '');
                $pet_fee = number_format($inquiry->pet_fee, 2, '.', '');
                $tax_rate = $inquiry->tax_rate;
                $order_total = number_format($inquiry->order_total, 2, '.', '');
                $inquiry_id = $inquiry->id;
            }

            if ($customer->form_guest_registry_filled != 1) {
                $customer->contact_number = $request->contact_number;
                $customer->street_address = $request->street_address;
                $customer->suite = $request->suite;
                $customer->city = $request->city;
                $customer->country = $request->country;
                $customer->state = $request->state;
                $customer->postal_code = $request->postal_code;
                $customer->other_country = $request->other_country;
                $customer->other_state = $request->other_state;
                if ($customer->country == 'Other') {
                    $customer->is_other_country = 1;
                }
                $customer->form_guest_registry_filled = 1;
                $customer->save();
            }

            $order = [
                'customer_id' => Auth::guard('customer')->user()->id,
                'vendor_id' => $booking['vendor_id'],
                'name' => $request->name,
                'email' => $request->email_address,
                'phone' => $request->contact_number,
                'street_address' => $request->street_address,
                'suite' => $request->suite,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'postal_code' => $request->postal_code,
                'check_in_at' => $booking['start_date'],
                'check_out_at' => $booking['end_date'],
                'nights_count' => $booking['days'],
                'travel_party_size' => $booking['number_travel_party'],
                'visit_purpose' => $booking['nature_of_visit'],
                'rate_basic' => $rate_basic,
                'guest_name' => $customer->firstname . ' ' . $customer->lastname,
                'guest_email' => $customer->email,
                'experiences_selected' => json_encode($booking_data['selectedExperiences'], JSON_UNESCAPED_UNICODE),
                'experiences_total' => $experiences_total,
                'cleaning_fee' => $cleaning_fee,
                'security_deposit' => $security_deposit,
                'pet_fee' => $pet_fee,
                'tax_rate' => $tax_rate,
                'wallet_used' => $wallet_used,
                'order_total' => $order_total,
                'inquiry_id' => $inquiry_id,
            ];
            // Create order
            $order = Order::create($order);
            if($wallet_used > 0){
                app(WalletController::class)->useWallet($customer, $wallet_used, $order->id);
            }
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
            if (!empty($order)) {
                Session::forget('booking');
                if (!empty($inquiry)) {
                    $inquiry->update(['inquiry_status' => 3]);
                }
                return response()->json(
                    [
                        'success' => true,
                        "client_secret" => $setupIntent->client_secret,
                        "intent_type" => 'setup_intent',
                        "message" => 'Order created successfully',
                        'order_id' => $order->id
                    ]
                );
            } else {
                return response()->json(['success' => false, "data" => [], "message" => 'Something went wrong try again']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function sendInquiry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Billing Address
            'name' => 'required|string',
            'email_address' => 'required|string',
            'contact_number' => 'required|string',
            'street_address' => 'required|string',
            'suite' => 'nullable|string',
            'city' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'postal_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'error' => $validator->errors()
                ]
            );
        }
        $booking = Session::get('booking');
        $customer = Auth::guard('customer')->user();
        $booking_data = $request->all();
        $currentDate = now();
        $season = SeasonHelper::getSeasonAndPrice($currentDate, $booking['vendor_id']);
        if (isset($booking_data['selectedExperiences']) && !empty($booking_data['selectedExperiences'])) {
            $booking_data['selectedExperiences'] = json_decode($booking_data['selectedExperiences'], true);
        }
        $total_experiences = number_format(array_sum(array_column($booking_data['selectedExperiences'], 'value')), 2, '.', '');
        $vendor = Vendor::with('pricing')->where('id', $booking['vendor_id'])->first();
        $cleaning_fee = number_format(!empty($vendor->accommodationMetadata->cleaning_fee_amount) ? $vendor->accommodationMetadata->cleaning_fee_amount : 0, 2, '.', '');
        $security_deposit = number_format(!empty($vendor->accommodationMetadata->security_deposit_amount) ? $vendor->accommodationMetadata->security_deposit_amount : 0, 2, '.', '');
        $pet_fee = number_format(!empty($vendor->accommodationMetadata->pet_boarding) ? $vendor->accommodationMetadata->pet_boarding : 0, 2, '.', '');
        $tax_rate = !empty($vendor->accommodationMetadata->applicable_taxes_amount) ? $vendor->accommodationMetadata->applicable_taxes_amount : '';
        $sub_total = ($season['price'] * $booking['days']) + $total_experiences + $cleaning_fee + $security_deposit + $pet_fee;
        $tax = ($sub_total * $tax_rate) / 100;
        $grand_total = $sub_total + $tax;

        $inquiryData = [
            'customer_id' => Auth::user()->id,
            'vendor_id' => $booking['vendor_id'],
            'name' => $request->name,
            'email' => $request->email_address,
            'phone' => $request->contact_number,
            'street_address' => $request->street_address,
            'suite' => $request->suite,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'check_in_at' => $booking['start_date'],
            'check_out_at' => $booking['end_date'],
            'nights_count' => $booking['days'],
            'travel_party_size' => $booking['number_travel_party'],
            'visit_purpose' => $booking['nature_of_visit'],
            'rate_basic' => $season['price'],
            'guest_name' => $customer->firstname . ' ' . $customer->lastname,
            'guest_email' => $customer->email,
            'experiences_selected' => json_encode($booking_data['selectedExperiences'], JSON_UNESCAPED_UNICODE),
            'experiences_total' => $total_experiences,
            'cleaning_fee' => number_format($cleaning_fee, 2, '.', ''),
            'security_deposit' => number_format($security_deposit, 2, '.', ''),
            'pet_fee' => number_format($pet_fee, 2, '.', ''),
            'tax_rate' => $tax_rate,
            'order_total' => number_format($grand_total, 2, '.', ''),
            'inquiry_status' => 0,
        ];
        $inquiry = Inquiry::create($inquiryData);
        if (!empty($inquiry)) {
            Session::forget('booking');
            Mail::to($vendor->vendor_email)->send(new VendorInquiryMail($inquiryData, $vendor));
            return response()->json(['success' => true, "redirect_url" => route('user-inquiries', $vendor->id), "message" => 'Inquiry sent successfully', 'inquiry_id' => $inquiry->id]);
        } else {
            return response()->json(['success' => false, "data" => [], "message" => 'Something went wrong try again']);
        }
    }

    public function storeTransactionDetails(Request $request)
    {
        $order_id = $request->input('order_id');
        $payment_intent_id = $request->input('payment_intent_id');
        $transaction = OrderTransaction::where('order_id', $order_id)->first();
        if ($transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction already exists for this order.',
                // 'transaction' => $transaction
            ], 200);
        }
        $order = Order::find($order_id);
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $paymentIntent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
        $transactionData = [
            'order_id' => $order_id,
            'payment_type' => 'card',
            'transaction_id' => $paymentIntent->id,
            'transaction_status' => $paymentIntent->status,
            'transaction_amount' => $paymentIntent->amount / 100, // Stripe amount is in cents
            'transaction_currency' => $paymentIntent->currency,
            'transaction_created_at' => \Carbon\Carbon::createFromTimestamp($paymentIntent->created)->toDateTimeString(),
            'card_brand_name' => $paymentIntent->charges->data[0]->payment_method_details->card->brand ?? null,
            'cc_number' => $paymentIntent->charges->data[0]->payment_method_details->card->last4 ?? null,
            'expiry' => ""
        ];
        $transaction = OrderTransaction::create($transactionData);

        if (!empty($transaction)) {
            $customer = Auth::guard('customer')->user();
            app(WalletController::class)->addCashback($customer, $transaction->transaction_amount, $order_id);
            return response()->json([
                'success' => true,
                'message' => 'Transaction details stored successfully.',
                'transaction' => $transaction
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to store transaction details.',
        ], 500);
    }
}
