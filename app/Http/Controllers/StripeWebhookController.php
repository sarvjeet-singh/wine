<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use App\Models\WinerySubscription;
use Log;

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
        } elseif ($event->type === 'customer.subscription.deleted') {
            $subscriptionId = $event->data->object->id;
            $status = 'canceled'; // Set status to canceled
    
            // Update the subscription status in your database
            WinerySubscription::where('stripe_subscription_id', $subscriptionId)
                ->update([
                    'status' => $status,
                    'end_date' => now(), // Optionally set end date to now or keep it as is
                ]);
        }

        return response()->json(['status' => 'success'], 200);
    }
}