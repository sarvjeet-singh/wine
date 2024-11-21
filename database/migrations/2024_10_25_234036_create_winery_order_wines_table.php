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
        Schema::create('winery_order_wines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('winery_order_id')->constrained('winery_orders')->onDelete('cascade');
            $table->foreignId('vendor_wine_id')->constrained('vendor_wines');
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('winery_order_wines');
    }
};
