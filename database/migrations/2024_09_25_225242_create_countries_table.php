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
        Schema::create('countries', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Country name
            $table->string('iso_code', 3); // ISO Alpha-3 Code (e.g., 'USA', 'GBR')
            $table->string('iso_code_2', 2); // ISO Alpha-2 Code (e.g., 'US', 'GB')
            $table->string('dial_code', 10)->nullable(); // Country dialing code (e.g., '+1', '+44')
            $table->string('currency')->nullable(); // Currency code (e.g., 'USD', 'GBP')
            $table->boolean('status')->default(1);
            $table->timestamps(); // Created at, Updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
