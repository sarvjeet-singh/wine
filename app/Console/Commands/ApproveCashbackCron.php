<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WalletTransaction;

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
        $transactions = WalletTransaction::where('status', 'pending')->get();

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
        // Approve the transaction
        $transaction->update(['status' => 'approved']);

        // Add cashback to wallet balance
        $wallet = $transaction->wallet;
        $wallet->update(['balance' => $wallet->balance + $transaction->amount]);
    }
}
