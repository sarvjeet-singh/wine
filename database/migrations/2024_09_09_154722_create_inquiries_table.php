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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->unsignedBigInteger('user_id');  // User who made the inquiry
            $table->unsignedBigInteger('vendor_id');  // Vendor related to the inquiry
            $table->dateTime('check_in_at');  // DateTime for check-in
            $table->dateTime('check_out_at');  // DateTime for check-out
            $table->integer('nights_count');  // Number of nights
            $table->integer('travel_party_size');  // Size of travel party
            $table->string('visit_purpose');  // Purpose of the visit
            $table->decimal('rate_basic', 10, 2);  // Basic rate for the inquiry
            $table->string('guest_name');  // Name of the guest
            $table->string('guest_email');  // Email of the guest
            $table->json('experiences_selected');  // Selected experiences (in JSON format)
            $table->decimal('experiences_total', 10, 2);  // Total cost of selected experiences
            $table->decimal('cleaning_fee', 10, 2);  // Cleaning fee
            $table->decimal('security_deposit', 10, 2);  // Security deposit
            $table->decimal('pet_fee', 10, 2);  // Pet fee
            $table->decimal('tax_rate', 10, 2);  // Tax rate
            $table->decimal('order_total', 10, 2);  // Total order amount
            $table->unsignedInteger('inquiry_status');  // Status of the inquiry
            $table->timestamps();  // Created at and Updated at timestamps

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inquiries');
    }
};