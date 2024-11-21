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
        Schema::create('winery_carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('shop_id'); // Vendor ID for multi-vendor support
            $table->unsignedBigInteger('vendor_id'); // Vendor ID for multi-vendor support
            $table->enum('status', ['active', 'ordered', 'abandoned'])->default('active');
            $table->timestamps();

            // Foreign keys
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('winery_carts');
    }
};
