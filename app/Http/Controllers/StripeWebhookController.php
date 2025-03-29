<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use App\Models\WinerySubscription;
use App\Models\Vendor;
use Log;
use App\Helpers\VendorHelper;
use App\Mail\SubscriptionMail;
use App\Models\Plan;
use Illuminate\Support\Facades\Mail;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Set your Stripe secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Retrieve the webhook secret from your .env file
        $webhookSecret = env('STRIPE_WEBHOOK_SECRET');

        // Retrieve the payload and signature from the headers
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            // Verify the event using the payload and the webhook secret
            $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (SignatureVerificationException $e) {
            $error = $e->getMessage();
            Log::error($error);

            // If verification fails, respond with a 400 error
            return response()->json(['error' =>  $error], 400);
        }

        // Handle the webhook event based on the type
        if ($event->type === 'invoice.payment_succeeded') {
            $subscriptionId = $event->data->object->subscription;
            $status = 'active';

            // Get current timestamps
            $startDate = now(); // Set start date to now
            $endDate = \Carbon\Carbon::createFromTimestamp($event->data->object->lines->data[0]->period->end); // End date from the invoice data

            // Update the status, start date, and end date in your database
            WinerySubscription::where('stripe_subscription_id', $subscriptionId)
                ->update([
                    'status' => $status,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]);
            // Retrieve the vendor_id from the updated WinerySubscription
            $vendorId = WinerySubscription::where('stripe_subscription_id', $subscriptionId)
                ->value('vendor_id');

            // Update the Vendors table with the vendor_id
            if ($vendorId) {
                // Vendor::where('id', $vendorId)->update([
                //     'account_status' => 1, // Replace with your desired status
                // ]);
                VendorHelper::canActivateSubscription($vendorId);
            }
            $vendor = Vendor::where('id', $vendorId)->first();
            $subscription = WinerySubscription::where('stripe_subscription_id', $subscriptionId)->first();
            $plan = Plan::where('stripe_plan_id', $subscription->stripe_plan_id)->first();
            Mail::to($vendor->vendor_email)->send(new SubscriptionMail($vendor, $plan, $subscription));
            Mail::to(env('ADMIN_EMAIL'))->send(new SubscriptionMail($vendor, $plan, $subscription));
        } elseif ($event->type === 'customer.subscription.updated') {
            $subscriptionId = $event->data->object->id;
            $status = $event->data->object->status;

            // Get current period start and end timestamps
            $currentPeriodStart = \Carbon\Carbon::createFromTimestamp($event->data->object->current_period_start);
            $currentPeriodEnd = \Carbon\Carbon::createFromTimestamp($event->data->object->current_period_end);

            // Update the status, start date, and end date based on the updated subscription
            WinerySubscription::where('stripe_subscription_id', $subscriptionId)
                ->update([
                    'status' => $status,
                    'start_date' => $currentPeriodStart,
                    'end_date' => $currentPeriodEnd,
                ]);
            $vendorId = WinerySubscription::where('stripe_subscription_id', $subscriptionId)
                ->value('vendor_id');

            // Update the Vendors table with the vendor_id
            if ($vendorId) {
                // Vendor::where('id', $vendorId)->update([
                //     'account_status' => 1, // Replace with your desired status
                // ]);
                VendorHelper::canActivateSubscription($vendorId);
            }
            $vendor = Vendor::where('id', $vendorId)->first();
            $subscription = WinerySubscription::where('stripe_subscription_id', $subscriptionId)->first();
            // print_r($subscription);
            $plan = Plan::where('stripe_plan_id', $subscription->stripe_plan_id)->first();
            // print_r($plan);
            Mail::to($vendor->vendor_email)->send(new SubscriptionMail($vendor, $plan, $subscription));
            Mail::to(env('ADMIN_EMAIL'))->send(new SubscriptionMail($vendor, $plan, $subscription));
        } elseif ($event->type === 'customer.subscription.deleted') {
            $subscriptionId = $event->data->object->id;
            $status = 'canceled'; // Set status to canceled

            // Update the subscription status in your database
            WinerySubscription::where('stripe_subscription_id', $subscriptionId)
                ->update([
                    'status' => $status,
                    'end_date' => now(), // Optionally set end date to now or keep it as is
                ]);
            $vendorId = WinerySubscription::where('stripe_subscription_id', $subscriptionId)
                ->value('vendor_id');

            // Update the Vendors table with the vendor_id
            if ($vendorId) {
                Vendor::where('id', $vendorId)->update([
                    'account_status' => 3, // Replace with your desired status
                ]);
            }
        }

        return response()->json(['status' => 'success'], 200);
    }
}
