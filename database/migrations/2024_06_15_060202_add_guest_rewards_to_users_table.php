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
        Schema::table('users', function (Blueprint $table) {
            $table->string('guestrewards')->nullable()->after('remember_token');
            $table->integer('guestrewards_vendor_id')->nullable()->after('guestrewards');
            $table->string('guestrewards_social_media')->nullable()->after('guestrewards_vendor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('guestrewards');
            $table->dropColumn('guestrewards_vendor_id');
            $table->dropColumn('guestrewards_social_media');
        });
    }
};
