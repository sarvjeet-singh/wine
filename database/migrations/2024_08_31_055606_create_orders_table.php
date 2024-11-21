<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vendor_id');
            $table->dateTime('check_in_at');  // DateTime when the check-in occurs
            $table->dateTime('check_out_at');  // DateTime when the check-out occurs
            $table->integer('nights_count');  // Number of nights
            $table->integer('travel_party_size');  // Number of people in the travel party
            $table->string('visit_purpose');  // Nature of visit (renamed for clarity)
            $table->decimal('rate_basic', 10, 2);  // Basic rate
            $table->string('guest_name');  // Name of the guest
            $table->string('guest_email');  // Email of the guest
            $table->json('experiences_selected');  // Selected experiences (in JSON format)
            $table->decimal('experiences_total', 10, 2);  // Total cost of selected experiences
            $table->decimal('cleaning_fee', 10, 2);  // Cleaning fee
            $table->decimal('security_deposit', 10, 2);  // Security deposit
            $table->decimal('pet_fee', 10, 2);  // Pet fee
            $table->decimal('tax_rate', 10, 2);  // Tax rate
            $table->decimal('order_total', 10, 2);  // Total order amount
            $table->timestamps();  // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
