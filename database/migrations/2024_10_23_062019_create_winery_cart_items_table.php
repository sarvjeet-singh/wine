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
        Schema::create('winery_cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('vendor_wine_id');
            $table->integer('quantity');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('cart_id')->references('id')->on('winery_carts')->onDelete('cascade');
            $table->foreign('vendor_wine_id')->references('id')->on('vendor_wines')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('winery_cart_items');
    }
};
