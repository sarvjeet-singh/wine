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
        Schema::create('customer_system_activity_logs', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('customer_id');
            $table->string('event_type'); // Example: 'vendor_created', 'order_placed'
            $table->string('message');
            $table->json('data')->nullable(); // Store extra details (order_id, vendor_id)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_system_activity_logs');
    }
};
