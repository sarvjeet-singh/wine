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
        Schema::create('event_guest_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_order_id');
            $table->unsignedBigInteger('event_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_guest_details');
    }
};
