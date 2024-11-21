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
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('category_id'); // Foreign key to the categories table
            $table->unsignedBigInteger('inventory_type_id')->nullable(); // Foreign key to the inventory_types table
            $table->string('name'); // Name of the sub-category
            $table->string('slug')->unique(); // URL-friendly version of the name
            $table->boolean('status')->default(true); // Active or inactive status
            $table->text('description')->nullable(); // Description of the sub-category
            $table->timestamps(); // Created and updated timestamps

            // Foreign key constraints
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('inventory_type_id')->references('id')->on('inventory_types')->onDelete('set null'); // Set to null if inventory type is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categories');
    }
};
