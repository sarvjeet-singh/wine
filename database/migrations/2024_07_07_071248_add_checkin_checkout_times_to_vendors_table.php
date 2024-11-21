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
            $table->string('checkin_start_time')->nullable()->after('vendor_email');
            $table->string('checkin_end_time')->nullable()->after('checkin_start_time');
            $table->string('checkout_time')->nullable()->after('checkin_end_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('checkin_start_time');
            $table->dropColumn('checkin_end_time');
            $table->dropColumn('checkout_time');
        });
    }
};
