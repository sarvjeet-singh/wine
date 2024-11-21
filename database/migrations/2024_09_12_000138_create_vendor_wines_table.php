<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('vendor_wines', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_id');
            $table->string('winery_name');
            $table->string('region')->nullable();
            $table->string('sub_region')->nullable();
            $table->string('series')->nullable();
            $table->string('varietal_blend')->nullable();
            $table->year('vintage_date')->nullable()->nullable();
            $table->text('description')->nullable()->nullable();
            $table->decimal('abv', 5, 2)->nullable()->nullable();  // Alcohol By Volume
            $table->string('rs')->nullable();  // Alcohol By Volume
            $table->string('bottle_size')->nullable();
            $table->string('sku')->nullable();
            $table->string('image')->nullable();
            $table->decimal('cost', 8, 2)->default(0.00);
            $table->decimal('commission_delivery_fee', 8, 2)->default(0.00);
            $table->decimal('price', 8, 2)->default(0.00);
            $table->integer('inventory')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_wines');
    }
};
