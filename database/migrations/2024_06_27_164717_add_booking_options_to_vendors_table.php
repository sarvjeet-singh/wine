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
            $table->string('process_type')->nullable();
            $table->string('redirect_url')->nullable();
            $table->string('booking_minimum')->nullable();
            $table->string('booking_maximum')->nullable();
            $table->string('security_deposit_amount')->nullable();
            $table->string('applicable_taxes_amount')->nullable();
            $table->string('cleaning_fee_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn([
                'process_type',
                'redirect_url',
                'booking_minimum',
                'booking_maximum', 
                'security_deposit_amount', 
                'applicable_taxes_amount', 
                'cleaning_fee_amount'
            ]);
        });
    }
};
