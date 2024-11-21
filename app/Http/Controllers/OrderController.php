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

class OrderController extends Controller
{
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
        $paymentMethodId = $request->paymentMethodId;
        $user = $user = Auth::user();
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $paymentMethod = PaymentMethod::retrieve($paymentMethodId);
            $paymentMethod->attach(['customer' => $user->stripe_id]);

            //     // Update the customer's default payment method
            Customer::update($user->stripe_id, [
                'invoice_settings' => [
                    'default_payment_method' => $paymentMethodId,
                ],
            ]);

            $booking = Session::get('booking');
            $user = Auth::user();
            $booking_data = $request->all();
            $total_experiences = number_format(array_sum(array_column($booking_data['selectedExperiences'], 'value')), 2, '.', '');
            $vendor = Vendor::with('pricing')->where('id', $booking['vendor_id'])->first();
            $cleaning_fee = number_format(!empty($vendor->accommodationMetadata->cleaning_fee_amount) ? $vendor->accommodationMetadata->cleaning_fee_amount : 0, 2, '.', '');
            $security_deposit = number_format(!empty($vendor->accommodationMetadata->security_deposit_amount) ? $vendor->accommodationMetadata->security_deposit_amount : 0, 2, '.', '');
            $pet_fee = number_format(!empty($vendor->accommodationMetadata->pet_boarding) ? $vendor->accommodationMetadata->pet_boarding : 0, 2, '.', '');
            $tax_rate = !empty($vendor->accommodationMetadata->applicable_taxes_amount) ? $vendor->accommodationMetadata->applicable_taxes_amount : '';
            $sub_total = ($vendor->pricing->current_rate * $booking['days']) + $total_experiences + $cleaning_fee + $security_deposit + $pet_fee;
            $tax = ($sub_total * $tax_rate) / 100;
            $grand_total = $sub_total + $tax;

            $inquiry = null;
            $rate_basic = $vendor->pricing->current_rate;
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

            $order = [
                'user_id' => Auth::user()->id,
                'vendor_id' => $booking['vendor_id'],
                'check_in_at' => $booking['start_date'],
                'check_out_at' => $booking['end_date'],
                'nights_count' => $booking['days'],
                'travel_party_size' => $booking['number_travel_party'],
                'visit_purpose' => $booking['nature_of_visit'],
                'rate_basic' => $rate_basic,
                'guest_name' => $user->firstname . ' ' . $user->lastname,
                'guest_email' => $user->email,
                'experiences_selected' => json_encode($booking_data['selectedExperiences'], JSON_UNESCAPED_UNICODE),
                'experiences_total' => $experiences_total,
                'cleaning_fee' => $cleaning_fee,
                'security_deposit' => $security_deposit,
                'pet_fee' => $pet_fee,
                'tax_rate' => $tax_rate,
                'order_total' => $order_total,
                'inquiry_id' => $inquiry_id,
            ];

            // Create order
            $order = Order::create($order);

            // Stripe payment
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $stripe_detail = $stripe->customers->retrieve($user->stripe_id, []);

            $payment_intent = $stripe->paymentIntents->create([
                'amount' => (float) ($order->order_total * 100),
                'currency' => 'usd',
                'customer' => $user->stripe_id,
                // 'application_fee_amount' => $company_total,
                // 'error_on_requires_action' => true,
                'confirm' => true,
                'capture_method' => 'manual',
                'payment_method' => $stripe_detail->invoice_settings->default_payment_method,
                // 'transfer_data' => ['destination' => $agent->connect_id],
                'automatic_payment_methods' => ['enabled' => true, 'allow_redirects' => 'never'],
                'metadata' => [
                    'order_id' => $order->id,
                    'customer_id' => $user->id,
                    'vendor_id' => $booking['vendor_id'],
                ]
            ]);
            if ($payment_intent) {
                $orderTransaction = OrderTransaction::create([
                    'order_id' => $order->id,
                    'payment_type' => $payment_intent->payment_method_types[0],
                    'transaction_id' => $payment_intent->id,
                    'transaction_status' => $payment_intent->status,
                    'transaction_amount' => number_format($payment_intent->amount / 100, 2, '.', ''),
                    'transaction_currency' => $payment_intent->currency,
                    // 'transaction_created_at' => \Carbon\Carbon::createFromTimestamp($payment_intent->created)->format('Y-m-d H:i:s'),
                ]);
                if (!empty($order) && !empty($orderTransaction)) {
                    Session::forget('booking');
                    if(!empty($inquiry)){
                        $inquiry->update(['inquiry_status' => 3]);
                    }
                    return response()->json(['success' => true, "redirect_url" => route('user.orderDetail', $order->id), "message" => 'Order created successfully', 'order_id' => $order->id]);
                } else {
                    return response()->json(['success' => false, "data" => [], "message" => 'Something went wrong try again']);
                }
            }
            //     return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function sendInquiry(Request $request)
    {
        $booking = Session::get('booking');
        $user = Auth::user();
        $booking_data = $request->all();
        $total_experiences = number_format(array_sum(array_column($booking_data['selectedExperiences'], 'value')), 2, '.', '');
        $vendor = Vendor::with('pricing')->where('id', $booking['vendor_id'])->first();
        $cleaning_fee = number_format(!empty($vendor->accommodationMetadata->cleaning_fee_amount) ? $vendor->accommodationMetadata->cleaning_fee_amount : 0, 2, '.', '');
        $security_deposit = number_format(!empty($vendor->accommodationMetadata->security_deposit_amount) ? $vendor->accommodationMetadata->security_deposit_amount : 0, 2, '.', '');
        $pet_fee = number_format(!empty($vendor->accommodationMetadata->pet_boarding) ? $vendor->accommodationMetadata->pet_boarding : 0, 2, '.', '');
        $tax_rate = !empty($vendor->accommodationMetadata->applicable_taxes_amount) ? $vendor->accommodationMetadata->applicable_taxes_amount : '';
        $sub_total = ($vendor->pricing->current_rate * $booking['days']) + $total_experiences + $cleaning_fee + $security_deposit + $pet_fee;
        $tax = ($sub_total * $tax_rate) / 100;
        $grand_total = $sub_total + $tax;

        $inquiryData = [
            'user_id' => Auth::user()->id,
            'vendor_id' => $booking['vendor_id'],
            'check_in_at' => $booking['start_date'],
            'check_out_at' => $booking['end_date'],
            'nights_count' => $booking['days'],
            'travel_party_size' => $booking['number_travel_party'],
            'visit_purpose' => $booking['nature_of_visit'],
            'rate_basic' => $vendor->pricing->current_rate,
            'guest_name' => $user->firstname . ' ' . $user->lastname,
            'guest_email' => $user->email,
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
            return response()->json(['success' => true, "redirect_url" => route('user-inquiries', $vendor->id), "message" => 'Inquiry sent successfully', 'inquiry_id' => $inquiry->id]);
        } else {
            return response()->json(['success' => false, "data" => [], "message" => 'Something went wrong try again']);
        }
    }
}
