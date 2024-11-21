<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('winery_order_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('winery_order_id')->constrained('winery_orders')->onDelete('cascade'); // Reference to the order
            $table->string('transaction_id')->unique(); // Stripe transaction ID
            $table->decimal('amount', 10, 2); // Transaction amount
            $table->string('currency', 3)->default('USD'); // Currency, default to USD
            $table->enum('status', ['requires_payment_method', 'requires_confirmation', 'requires_action', 'processing', 'succeeded', 'requires_capture', 'canceled']); // Payment status
            $table->string('payment_method')->nullable(); // Payment method used (e.g., card)
            $table->string('card_brand')->nullable(); // Card brand (if card payment)
            $table->string('card_last4', 4)->nullable(); // Last 4 digits of card number
            $table->string('receipt_url')->nullable(); // Link to the Stripe receipt
            $table->json('billing_details')->nullable(); // Billing details as JSON (name, address)
            $table->timestamp('transaction_created_at')->nullable(); // Timestamp of when the transaction was created
            $table->timestamps(); // Laravel timestamps (created_at and updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('winery_order_transactions');
    }
};
