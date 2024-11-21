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
        Schema::create('sub_regions', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('region_id'); // Foreign key to the regions table
            $table->string('name'); // Name of the sub-region
            $table->string('slug')->unique(); // URL-friendly version of the sub-region name
            $table->boolean('status')->default(true); // Active or inactive status
            $table->text('description')->nullable(); // Description of the sub-region
            $table->timestamps(); // Created and updated timestamps

            // Foreign key constraint
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_regions');
    }
};
