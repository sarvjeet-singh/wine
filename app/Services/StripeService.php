<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\PaymentIntent;
use Stripe\SetupIntent;
use Stripe\Account;
use Stripe\AccountLink;
use App\Models\OrderTransaction;
use Illuminate\Support\Facades\Log;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    /**
     * Create a Stripe customer if not exists
     */
    public function createCustomer($vendor_data)
    {
        $customer = Customer::create($vendor_data);
        return $customer->id;
    }

    /**
     * Create a Setup Intent for the authenticated user.
     */
    public function setupIntent($customer_id)
    {
        $setupIntent = SetupIntent::create([
            'customer' => $customer_id,
        ]);
        return $setupIntent;
    }

    /**
     * Attach a payment method to a customer and make it default
     */
    /**
     * Attach a payment method to a customer and make it default
     */
    public function attachPaymentMethod($customer_id, $paymentMethodId)
    {
        try {
            // Retrieve the payment method
            $paymentMethod = PaymentMethod::retrieve($paymentMethodId);

            // Attach payment method to customer
            $paymentMethod->attach(['customer' => $customer_id]);
            // Set as default payment method
            Customer::update($customer_id, [
                'invoice_settings' => ['default_payment_method' => $paymentMethodId],
            ]);

            return true;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            Log::error('Stripe Error: ' . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            Log::error('General Error: ' . $e->getMessage());
            return false;
        }
    }

    public function removePaymentMethod($paymentMethodId)
    {
        try {
            $paymentMethod = PaymentMethod::retrieve($paymentMethodId);
            $detached = $paymentMethod->detach();
            return $detached;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            Log::error('Stripe Error: ' . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            Log::error('General Error: ' . $e->getMessage());
            return false;
        }
    }

    public function isDefaultPaymentMethod($customer_id, $paymentMethodId)
    {
        try {
            $customer = Customer::retrieve($customer_id);
            $defaultPaymentMethod = $customer->invoice_settings->default_payment_method;
            return $defaultPaymentMethod === $paymentMethodId;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            Log::error('Stripe Error: ' . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            Log::error('General Error: ' . $e->getMessage());
            return false;
        }
    }

    public function getPaymentMethod($paymentMethodId)
    {
        try {
            $paymentMethod = PaymentMethod::retrieve($paymentMethodId);
            return $paymentMethod;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            Log::error('Stripe Error: ' . $e->getMessage());
            return null;
        } catch (\Exception $e) {
            Log::error('General Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Retrieve the default payment method for a user.
     *
     * @param \App\Models\User $user
     *
     * @return string|null
     */
    public function getDefaultPaymentMethod($customer_id)
    {
        try {
            $customer = Customer::retrieve($customer_id);
            $defaultPaymentMethod = $customer->invoice_settings->default_payment_method;
            return $defaultPaymentMethod;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            Log::error('Stripe Error: ' . $e->getMessage());
            return null;
        } catch (\Exception $e) {
            Log::error('General Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Set the default payment method for a user
     *
     * @param User $user
     * @param string $paymentMethodId
     * @return string
     */
    public function setDefaultPaymentMethod($customer_id, $paymentMethodId)
    {
        try {
            $customer = Customer::retrieve($customer_id);
            $customer->invoice_settings->default_payment_method = $paymentMethodId;
            $customerData = $customer->save();
            return $customerData;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            Log::error('Stripe Error: ' . $e->getMessage());
            return null;
        } catch (\Exception $e) {
            Log::error('General Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * List all payment methods of a user
     *
     * @param User $user
     * @return array
     */
    public function listPaymentMethods($customer_id)
    {
        try {
            $paymentMethods = PaymentMethod::all(['customer' => $customer_id]);
            return $paymentMethods;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            Log::error('Stripe Error: ' . $e->getMessage());
            return [];
        } catch (\Exception $e) {
            Log::error('General Error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Charge a customer using their default payment method
     */
    public function createPaymentIntent($order, $shop, $vendor, $payment_method_id, $customerId)
    {
        $customerName = $order->billing_first_name . ' ' . $order->billing_last_name;

        // Step 3: Create Payment Intent
        $description = "Order Payment for Customer Name $customerName and Order ID: " . $order->id;


        $customerAddress = [
            'line1' => $order->billing_street,
            'line2' => '',
            'city' => $order->billing_city,
            'state' => $order->billing_state,
            'postal_code' => $order->billing_postal_code,
            'country' => 'CA',
        ];
        $paymentIntent = PaymentIntent::create([
            'amount' => $order->total_price * 100,
            'currency' => 'cad',
            'description' => $description,
            'payment_method' => $payment_method_id,
            'off_session' => false,
            "confirm" => true,
            'setup_future_usage' => 'off_session',
            'customer' => $customerId,
            'capture_method' => 'manual', // Delayed capture
            'return_url' => route('payment.return', $order->vendor_buyer_id),
            'shipping' => [
                'name' => $customerName,
                'address' => $customerAddress,
            ],
            'metadata' => [
                'customer_email' => $order->billing_email,
                'customer_name' => $customerName,
            ],
            'transfer_data' => [
                'destination' => $shop->stripe_account_id, // Connect account ID
            ],
        ]);

        return $paymentIntent;
    }


    public function createCustomerPaymentIntent($order, $vendor, $payment_method_id, $customerId)
    {
        $customerName = $order->name;

        // Step 3: Create Payment Intent
        $description = "Order Payment for Customer Name $customerName and Order ID: " . $order->id;


        $customerAddress = [
            'line1' => $order->street_address,
            'line2' => $order->suite,
            'city' => $order->city,
            'state' => $order->state,
            'postal_code' => $order->postal_code,
            'country' => 'CA',
        ];
        $paymentIntentData = [
            'amount' => $order->order_total * 100,
            'currency' => 'cad',
            'description' => $description,
            'payment_method' => $payment_method_id,
            'off_session' => false,
            "confirm" => true,
            'setup_future_usage' => 'off_session',
            'customer' => $customerId,
            'capture_method' => 'manual', // Delayed capture
            'return_url' => route('payment.return', $order->vendor_buyer_id),
            'shipping' => [
                'name' => $customerName,
                'address' => $customerAddress,
            ],
            'metadata' => [
                'customer_email' => $order->email,
                'customer_name' => $customerName,
            ],
            'transfer_data' => [
                'destination' => $vendor->stripe_account_id, // Connect account ID
            ],
        ];

        $paymentIntent = PaymentIntent::create($paymentIntentData);

        return $paymentIntent;
    }

    /**
     * Store transaction details in database
     */
    public function saveTransaction($orderId, $paymentIntent)
    {
        return OrderTransaction::create([
            'order_id' => $orderId,
            'payment_type' => 'stripe',
            'transaction_id' => $paymentIntent->id,
            'transaction_status' => $paymentIntent->status,
            'transaction_amount' => $paymentIntent->amount / 100, // Convert to dollars
            'transaction_currency' => $paymentIntent->currency,
            'transaction_created_at' => now(),
        ]);
    }
}
