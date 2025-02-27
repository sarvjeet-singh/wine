<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\OrderTransaction;
use App\Models\Order;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class AccommodationCapturePendingPayments extends Command
{
    protected $signature = 'accommodation-payments:capture';
    protected $description = 'Capture payments for orders that require capture and are within the allowed timeframe.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try {
            // Set Stripe API key
            Stripe::setApiKey(env('STRIPE_SECRET'));

            // Fetch transactions that require capture and are within 6 days
            $transactions = OrderTransaction::where('transaction_status', 'requires_capture')
                ->whereDate('transaction_created_at', '>=', Carbon::now()->subDays(6))
                ->get();

            if ($transactions->isEmpty()) {
                $this->info('No pending transactions require capture.');
                return;
            }

            foreach ($transactions as $transaction) {
                try {
                    // Capture payment on Stripe
                    $paymentIntent = PaymentIntent::retrieve($transaction->transaction_id);
                    $paymentIntent->capture();
                    $order = Order::find($transaction->order_id);
                    $order->payment_status = 'paid';
                    $order->save();
                    // Update transaction status
                    $transaction->update(['transaction_status' => 'captured']);

                    // Update the order status (if needed)
                    // Order::where('id', $transaction->order_id)->update(['status' => 'paid']);

                    $this->info("Payment captured successfully for Order ID: {$transaction->order_id}");
                } catch (\Exception $e) {
                    $this->error("Failed to capture payment for Order ID: {$transaction->order_id}. Error: " . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            $this->error('Error processing payments: ' . $e->getMessage());
        }
    }
}
