<?php

namespace App\Services;

use App\Models\Subscription;
use Exception;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Product as StripeProduct;
use Stripe\Customer;
use Stripe\Price;
use Stripe\PaymentMethod;
use App\Models\WinerySubscription;
use Stripe\Subscription as StripeSubscription;
use App\Models\Plan;
use App\Models\Vendor;

class StripeSubscriptionService
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function cancelSubscription($subscriptionId)
    {
        try {
            // Cancel the subscription on Stripe
            $subscription = StripeSubscription::retrieve($subscriptionId);
            $subscription->cancel();

            // Update the subscription status in your database
            WinerySubscription::where('stripe_subscription_id', $subscriptionId)
                ->update(['status' => 'canceled']);

            return ['status' => 'success', 'message' => 'Subscription canceled successfully.'];
        } catch (\Exception $e) {
            // Handle any errors that occur during the cancellation process
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getSubscriptionDetails($subscriptionId)
    {
        try {
            // Fetch the subscription details from Stripe
            $subscription = StripeSubscription::retrieve($subscriptionId);
            // Fetch the payment method associated with the subscription
            $paymentMethodId = $subscription->default_payment_method;
            $paymentMethod = PaymentMethod::retrieve($paymentMethodId);

            // Prepare the data to return, including last four digits
            return [
                'status' => 'success',
                'data' => [
                    'id' => $subscription->id,
                    'status' => $subscription->status,
                    'current_period_start' => \Carbon\Carbon::createFromTimestamp($subscription->current_period_start)->toDateTimeString(),
                    'current_period_end' => \Carbon\Carbon::createFromTimestamp($subscription->current_period_end)->toDateTimeString(),
                    'plan' => [
                        'id' => $subscription->plan->id,
                        'amount' => $subscription->plan->amount,
                        'currency' => $subscription->plan->currency,
                        'interval' => $subscription->plan->interval,
                    ],
                    'card_last4' => $paymentMethod->card->last4, // Get last 4 digits of the card
                    'card_brand' => $paymentMethod->card->brand, // Optionally include card brand
                ],
            ];
        } catch (\Exception $e) {
            // Handle any errors that occur during the fetch process
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    public function changeSubscription($user, $vendorId, $newPlanId, $newPrice)
    {
        try {
            // Find the active subscription for the user and vendor
            $currentSubscription = Subscription::where('user_id', $user->id)
                ->where('vendor_id', $vendorId)
                ->where('status', 'active')
                ->first();

            if (!$currentSubscription) {
                throw new Exception("No active subscription found for this user.");
            }

            // Calculate remaining days in the current subscription
            $now = now();
            $endDate = $currentSubscription->end_date ?: $now->copy()->addMonth(); // Default to 1 month if end_date is null
            $remainingDays = $now->diffInDays($endDate, false); // Negative if expired

            if ($remainingDays <= 0) {
                // Subscription has expired, proceed with a new subscription without proration
                return $this->createSubscription($user, $vendorId, $newPlanId, $newPrice);
            }

            // Calculate the prorated amount or period for the new subscription
            $proratedEndDate = $now->copy()->addDays($remainingDays);

            // Cancel the old subscription in Stripe
            $stripeSubscription = StripeSubscription::retrieve($currentSubscription->stripe_subscription_id);
            $stripeSubscription->cancel();

            // Mark current subscription as canceled in database
            $currentSubscription->update([
                'status' => 'canceled',
                'end_date' => $now,
            ]);

            // Create the new subscription in Stripe
            $newSubscription = StripeSubscription::create([
                'customer' => $user->stripe_customer_id,
                'items' => [['price' => $newPlanId]],
                'trial_end' => $proratedEndDate->timestamp, // Use prorated end date as the trial period
            ]);

            // Save new subscription in the database
            $newSubscriptionRecord = Subscription::create([
                'user_id' => $user->id,
                'vendor_id' => $vendorId,
                'stripe_subscription_id' => $newSubscription->id,
                'stripe_plan_id' => $newPlanId,
                'price' => $newPrice,
                'status' => 'active',
                'start_date' => $now,
                'end_date' => $proratedEndDate,
            ]);

            return $newSubscriptionRecord;
        } catch (Exception $e) {
            Log::error('Subscription change failed: ' . $e->getMessage());
            throw new Exception("Failed to change subscription: " . $e->getMessage());
        }
    }

    public function getProducts()
    {
        try {
            return StripeProduct::all(['expand' => ['data.default_price']]);;
        } catch (Exception $e) {
            Log::error('Failed to get products: ' . $e->getMessage());
            throw new Exception("Failed to get products: " . $e->getMessage());
        }
    }

    public function createPaymentIntent($vendor, $priceId, $plan)
    {
        if ($vendor->vendor_stripe_id == null) {
            $customer = Customer::create([
                'name' => $vendor->vendor_name, // Replace with actual customer name
                'email' => $vendor->vendor_email, // Replace with actual email
                'address' => [
                    'line1' => $vendor->street_address,
                    'city' => $vendor->city,
                    'state' => $vendor->province,
                    'postal_code' => $vendor->postalCode,
                    'country' => 'CA',
                ],
            ]);

            $vendor->update([
                'vendor_stripe_id' => $customer->id,
            ]);
        } else {
            $customer = Customer::retrieve($vendor->vendor_stripe_id);
        }
        $planDetail = Plan::where('stripe_plan_id', $priceId)
            ->with('taxes:id,stripe_tax_id')
            ->first();
        $stripeTaxIds = $planDetail->taxes->pluck('stripe_tax_id')->implode(',');
        // $taxRateId = env('STRIPE_TAX_RATE_ID');
        $subscriptionData = [
            'customer' => $customer->id,
            'items' => [[
                'price' => $priceId
            ]],
            'payment_behavior' => 'default_incomplete', // To collect payment details and confirm subscription
            'expand' => ['latest_invoice.payment_intent'],
            // 'default_tax_rates' => [$stripeTaxIds],
        ];
        if(!empty($stripeTaxIds)){
            $subscriptionData['default_tax_rates'] = [$stripeTaxIds];
        }
        $subscription = StripeSubscription::create($subscriptionData);
        $price = Price::retrieve($priceId);
        $winerySubscription = WinerySubscription::create([
            'vendor_id' => $vendor->id,
            'stripe_subscription_id' => $subscription->id,
            'stripe_price_id' => $priceId,
            'price' => number_format($price->unit_amount / 100, 2, '.', ''),
            'status' => 'incomplete',
            'start_date' => now(),
            'end_date' => null,
        ]);
        return response()->json([
            'clientSecret' => $subscription->latest_invoice->payment_intent->client_secret,
            'plan' => $plan,
            'price' => $price->unit_amount / 100,
            'subscription_id' => $winerySubscription->id,
        ]);

        // $intent['amount'] = $price->unit_amount/100;
        // $paymentIntent = PaymentIntent::create($intent);

        // return response()->json([
        //     'clientSecret' => $paymentIntent->client_secret,
        //     'success' => true,
        //     'price' => '$' . number_format($intent['amount'] / 100, 2),
        //     'plan' => $plan,
        //     'currency' => $price->currency,

        // ]);
    }

    /**
     * Create a new subscription for a vendor in Stripe, and update the user's
     * subscription in your database.
     *
     * @param User $user
     * @param Plan $plan
     * @return \Stripe\Subscription
     * @throws \Exception
     */
    public function createSubscription(Vendor $vendor, Plan $plan)
    {
        // Get tax IDs for the plan
        $taxIds = $plan->taxes()
            ->where('active', true)
            ->pluck('stripe_tax_id')
            ->toArray();

        try {
            // Create subscription with taxes
            $subscription = StripeSubscription::create([
                'customer' => $vendor->stripe_id,
                'items' => [
                    ['price' => $plan->stripe_plan_id],
                ],
                'default_tax_rates' => $taxIds
            ]);

            // Update user's subscription in your database
            $vendor->subscription()->create([
                'stripe_subscription_id' => $subscription->id,
                'plan_id' => $plan->id,
                'status' => $subscription->status,
            ]);

            return $subscription;
        } catch (\Exception $e) {
            throw new \Exception('Failed to create subscription: ' . $e->getMessage());
        }
    }
}
