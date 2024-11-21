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
            $table->string('winery_type')->nullable();
            $table->string('excursion_type')->nullable();
            $table->string('sub_region')->nullable();
            $table->string('tasting_options')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('winery_type');
            $table->dropColumn('excursion_type');
            $table->dropColumn('sub_region');
            $table->dropColumn('tasting_options');
        });
    }
};

