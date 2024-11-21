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
        Schema::create('order_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->string('payment_type');
            $table->string('transaction_id');
            $table->string('transaction_status');
            $table->integer('transaction_amount');
            $table->string('transaction_currency');
            $table->timestamp('transaction_created_at')->nullable();
            $table->string('card_brand_name')->nullable();
            $table->string('cc_number')->nullable(); // Consider storing this securely or masking it
            $table->string('expiry')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_transactions');
    }
};
