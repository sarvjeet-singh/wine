<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WalletController extends Controller
{

    public function index()
    {
        $transactions = WalletTransaction::with(['wallet.customer'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.wallet.index', compact('transactions'));
    }

    public function create()
    {
        return view('admin.wallet.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        // Base validation
        // If the type is refund, we need to validate order_id as well
        if ($request->type == 'refund') {
            $request->validate([
                'type' => 'required|in:receipt_amount,refund',
                'customer_id' => 'required|exists:customers,id',
                'order_id' => 'required|exists:orders,id',
                'amount' => 'required|numeric|min:0.01',
            ]);
        }
        $request->validate([
            'type' => 'required|in:receipt_amount,refund',
            'customer_id' => 'required|exists:customers,id',
        ]);
        try {
            $customer = Customer::find($request->customer_id);

            // Check for transaction type: cashback or refund
            if ($request->type == 'receipt_amount') {
                $responseMessage = $this->addCashbackForReceipts($request, $customer);
            } elseif ($request->type == 'refund') {
                $responseMessage = $this->refundAmount($request, $customer);
            } else {
                return redirect()->back()->with('error', 'Invalid transaction type.');
            }

            // If the transaction was successful, redirect to the wallet transactions page with success message
            if (strpos($responseMessage, 'successfully') !== false) {
                return redirect()->route('admin.wallet.index')->with('success', $responseMessage);
            }

            // If there's an error, redirect back with the error message
            return redirect()->back()->with('error', $responseMessage);
        } catch (\Exception $e) {
            // Log the exception message for debugging purposes
            \Log::error('Error processing transaction: ' . $e->getMessage());

            // Redirect back with a generic error message
            // return redirect()->back()->with('error', 'Something went wrong while processing the transaction. Please try again.');
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    private function addCashbackForReceipts($request)
    {
        $customer = Customer::find($request->customer_id);
        $wallet = Wallet::where('customer_id', $customer->id)->first();

        if (!$wallet) {
            return 'Wallet not found for this customer';
        }
        // Check if cashback has already been given for this set of receipts
        $existingCashback = WalletTransaction::where('wallet_id', $wallet->id)
            ->where('description', 'Cashback for uploading 10 receipts')
            ->where('type', 'credit')
            ->exists();

        if ($existingCashback) {
            return 'Cashback already given for this set of receipts';
        }

        // Add $25 cashback to the customer's wallet
        $wallet->update(['balance' => $wallet->balance + 25]);

        // Create a WalletTransaction for the cashback
        WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'amount' => 25,
            'type' => 'credit',
            'status' => 'approved',
            'description' => 'Cashback for uploading 10 receipts',
        ]);

        return 'Cashback of $25 has been added to the wallet successfully';
    }

    private function refundAmount($request, $customer)
    {
        try {
            // Find the order associated with the refund
            $order = Order::find($request->order_id);

            if (!$order) {
                return 'Order not found';
            }

            // Check if the refund amount is valid (should be less than or equal to the order total)
            if ($request->amount > $order->order_total) {
                return 'Refund amount cannot exceed the order total';
            }

            // Find the wallet for the customer
            $wallet = Wallet::where('customer_id', $customer->id)->first();

            if (!$wallet) {
                return 'Wallet not found for this customer';
            }

            // Ensure that the wallet balance is sufficient for the refund (optional)
            // In most cases, refunds will just be added to wallet, not checking balance here as it's a deposit
            $wallet->update(['balance' => $wallet->balance + $request->amount]);

            // Create a WalletTransaction for the refund
            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'amount' => $request->amount,
                'type' => 'credit',
                'status' => 'approved',
                'order_id' => $request->order_id,
                'description' => 'Refund added to wallet for Order #' . $request->order_id,
            ]);

            return 'Refund of $' . $request->amount . ' successfully added to the wallet';
        } catch (\Exception $e) {
            // Catch any exception and provide a generic error message
            return 'An error occurred while processing the refund: ' . $e->getMessage();
        }
    }
}
