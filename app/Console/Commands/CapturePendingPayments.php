<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WineryOrderTransaction;
use App\Models\Vendor;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Log;

class CapturePendingPayments extends Command
{
    protected $signature = 'winery-payments:capture';
    protected $description = 'Capture all payments with requires_capture status after a vendor-specified duration.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Set your Stripe API key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Get transactions that are pending capture
        $transactions = WineryOrderTransaction::where('status', 'requires_capture')->get();

        foreach ($transactions as $transaction) {
            $vendor = Vendor::find($transaction->vendor_id);
            if (!$vendor || !$vendor->settlement_duration) {
                continue;
            }

            // Calculate when the payment should be captured
            $captureDate = Carbon::parse($transaction->created_at)->addDays($vendor->settlement_duration);

            // If it's time to capture the payment
            if (Carbon::now()->greaterThanOrEqualTo($captureDate)) {
                try {
                    // Capture the payment via Stripe
                    $paymentIntent = PaymentIntent::retrieve($transaction->transaction_id);
                    $paymentIntent->capture();

                    // Update the transaction status in the database
                    $transaction->update([
                        'status' => 'captured'
                    ]);

                    Log::info("Payment captured for transaction ID: {$transaction->transaction_id}");
                } catch (\Exception $e) {
                    Log::error("Failed to capture payment for transaction ID: {$transaction->transaction_id}. Error: " . $e->getMessage());
                }
            }
        }

        $this->info('CapturePendingPayments command executed successfully.');
    }
}
