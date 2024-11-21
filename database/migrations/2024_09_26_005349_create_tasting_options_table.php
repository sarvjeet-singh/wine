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
        Schema::create('tasting_options', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name'); // Tasting option name
            $table->boolean('status')->default(1); // Active or inactive status
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasting_options');
    }
};
