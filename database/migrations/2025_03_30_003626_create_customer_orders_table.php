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
        Schema::create('customer_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('vendor_id');
            $table->enum('order_type', ['event', 'accommodation', 'winery', 'excursion', 'licensed', 'non-licensed'])->nullable()->default('event');
            $table->decimal('sub_total', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('wallet_amount', 10, 2);
            $table->decimal('total', 16, 2);
            $table->string('payment_method');
            $table->string('payment_status');
            $table->string('order_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_orders');
    }
};
