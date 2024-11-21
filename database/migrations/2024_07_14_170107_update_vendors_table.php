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
            // Rename column
            $table->renameColumn('accommodation_type', 'vendor_sub_category');

            // Drop columns
            $table->dropColumn(['winery_type', 'excursion_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            // Rename column back to original
            $table->renameColumn('vendor_sub_category', 'accommodation_type');

            // Add dropped columns back
            $table->string('winery_type')->nullable();
            $table->string('excursion_type')->nullable();
        });
    }
};
