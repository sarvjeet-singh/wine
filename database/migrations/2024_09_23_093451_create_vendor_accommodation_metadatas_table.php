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
        Schema::create('vendor_accommodation_metadata', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->time('checkin_start_time')->nullable();
            $table->time('checkin_end_time')->nullable();
            $table->time('checkout_time')->nullable();
            $table->unsignedInteger('square_footage')->nullable();
            $table->unsignedInteger('bedrooms')->nullable();
            $table->unsignedInteger('washrooms')->nullable();
            $table->unsignedInteger('sleeps')->nullable();
            $table->unsignedInteger('booking_minimum')->nullable();
            $table->unsignedInteger('booking_maximum')->nullable();
            $table->decimal('security_deposit_amount', 10, 2)->nullable();
            $table->decimal('applicable_taxes_amount', 10, 2)->nullable();
            $table->decimal('cleaning_fee_amount', 10, 2)->nullable();
            $table->unsignedInteger('beds')->nullable();
            $table->boolean('pet_boarding')->default(false);
            $table->decimal('current_rate', 10, 2)->nullable();
            $table->string('extension', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_accommodation_metadatas');
    }
};
