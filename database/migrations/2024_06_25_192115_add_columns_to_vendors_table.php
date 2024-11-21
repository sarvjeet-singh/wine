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
        Schema::table('vendors', function (Blueprint $table) {
            $table->decimal('current_rate', 10, 2)->nullable()->default(null);
            $table->string('extension')->nullable()->default(null);
            $table->decimal('discount', 5, 2)->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('current_rate');
            $table->dropColumn('extension');
            $table->dropColumn('discount');
        });
    }
};
