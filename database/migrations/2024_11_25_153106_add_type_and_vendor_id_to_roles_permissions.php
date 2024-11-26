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
        Schema::table('roles', function (Blueprint $table) {
            $table->string('type')->nullable(); // 'admin', 'vendor'
            $table->unsignedBigInteger('vendor_id')->nullable(); // For vendor-specific roles
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->string('type')->nullable(); // 'admin', 'vendor'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles_permissions', function (Blueprint $table) {
            //
        });
    }
};
