<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    // Assign initial bonus on registration
    public function assignBonus(Customer $customer)
    {
        $wallet = Wallet::firstOrCreate(['customer_id' => $customer->id], ['balance' => 25.00]);

        WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'amount' => 25.00,
            'type' => 'credit',
            'status' => 'approved',
            'description' => 'Sign-up bonus',
        ]);

        return response()->json(['message' => 'Bonus added successfully']);
    }

    // Add cashback after a booking (7%)
    public function addCashback(Customer $customer, $bookingAmount, $orderId)
    {
        $cashbackAmount = $bookingAmount * 0.07;
        $wallet = Wallet::firstOrCreate(['customer_id' => $customer->id]);

        WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'amount' => $cashbackAmount,
            'type' => 'credit',
            'order_id' => $orderId,
            'status' => 'qualified', // Initially qualified
            'description' => 'Cashback from booking',
        ]);

        return response()->json(['message' => 'Cashback added (waiting approval)']);
    }

    // Approve cashback manually (admin action)
    public function approveCashback($transactionId)
    {
        $transaction = WalletTransaction::findOrFail($transactionId);
        $transaction->update(['status' => 'approved']);

        // Add cashback to wallet balance
        $wallet = $transaction->wallet;
        $wallet->update(['balance' => $wallet->balance + $transaction->amount]);

        return response()->json(['message' => 'Cashback approved']);
    }

    // Deduct wallet balance when making a purchase
    public function useWallet(Customer $customer, $amount, $orderId)
    {
        $wallet = Wallet::where('customer_id', $customer->id)->first();

        if (!$wallet || $wallet->balance < $amount) {
            return response()->json(['message' => 'Insufficient wallet balance'], 400);
        }
        $wallet->update(['balance' => $wallet->balance - $amount]);

        WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'amount' => $amount,
            'type' => 'debit',
            'order_id' => $orderId,
            'status' => 'approved',
            'description' => 'Purchase using wallet balance',
        ]);

        return response()->json(['message' => 'Purchase successful']);
    }

    // Get wallet history (like a bank statement)
    public function walletHistory()
    {
        // Get the wallet for the customer
        $customer = Auth::guard('customer')->user();
        $wallet = Wallet::where('customer_id', $customer->id)->first();
        // If the wallet doesn't exist, return an error
        if (!$wallet) {
            return view('UserDashboard.wallet-history', [
                'wallet' => $wallet,
                'transactions' => [],
                'message' => $wallet ? null : 'Wallet not found for this customer.'
            ]);
        }

        // Fetch the wallet transactions, ordered by the most recent first
        $transactions = $wallet->transactions()->orderByDesc('created_at')->get();

        // Pass the wallet and transactions to the view
        return view('UserDashboard.wallet-history', compact('wallet', 'transactions'));
    }
}
