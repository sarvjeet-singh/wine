<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WalletTransaction;
use App\Models\Order;

class ApproveCashbackCron extends Command
{
    protected $signature = 'cashback:approve'; // The command to be run
    protected $description = 'Approve cashback for pending transactions';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Fetch transactions that are eligible for cashback approval
        $transactions = WalletTransaction::where('status', 'qualified')
            ->where('created_at', '>=', now()->subDays(7))
            ->get();

        foreach ($transactions as $transaction) {
            // Call the approveCashback function for each transaction
            try {
                $this->approveCashback($transaction);
                $this->info("Cashback approved for transaction ID: {$transaction->id}");
            } catch (\Exception $e) {
                $this->error("Error approving cashback for transaction ID: {$transaction->id}. Error: {$e->getMessage()}");
            }
        }
    }

    public function approveCashback($transaction)
    {
        $order_id = $transaction->order_id;
        $order = Order::find($order_id);

        // Check if the order is older than 10 days
        if ($order && $order->created_at->diffInDays(now()) >= 7) {
            // Approve the transaction
            $transaction->update(['status' => 'approved']);

            // Add cashback to wallet balance
            $wallet = $transaction->wallet;
            $wallet->update(['balance' => $wallet->balance + $transaction->amount]);
            $this->info("Cashback successfully approved for transaction ID: {$transaction->id}");
        } else {
            // Log if the order is too new
            $this->info("Order for transaction ID {$transaction->id} is less than 7 days old. Cashback not approved.");
        }
    }
}
