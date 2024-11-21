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
            $table->string('vendor_email')->nullable();
            $table->string('street_address')->nullable();
            $table->string('unitsuite')->nullable();
            $table->boolean('hide_street_address')->default(false);
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postalCode')->nullable();
            $table->string('country')->nullable();
            $table->string('vendor_phone')->nullable();
            $table->text('description')->nullable();
            $table->string('accommodation_type')->nullable();
            $table->integer('square_footage')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('washrooms')->nullable();
            $table->integer('sleeps')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn([
                'vendor_email',
                'street_address',
                'unitsuite',
                'hide_street_address',
                'city',
                'province',
                'postalCode',
                'country',
                'vendor_phone',
                'description',
                'accommodation_type',
                'square_footage',
                'bedrooms',
                'washrooms',
                'sleeps',
            ]);
        });
    }
};
