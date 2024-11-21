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
        Schema::create('admin_settings', function (Blueprint $table) {
            $table->id();
            $table->string('option_name')->unique();  // Equivalent to `option_name` in `wp_options`
            $table->text('option_value')->nullable(); // Equivalent to `option_value`, can store larger values
            $table->string('autoload')->default('yes'); // Similar to `autoload`, specifies if this option loads on every request

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_settings');
    }
};
