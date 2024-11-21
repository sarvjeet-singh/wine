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
            $table->string('medical_physical_concerns')->nullable();
            $table->string('alternate_contact_full_name')->nullable();
            $table->string('alternate_contact_relation')->nullable();
            $table->string('date_of_birth')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('medical_physical_concerns');
            $table->dropColumn('alternate_contact_full_name');
            $table->dropColumn('alternate_contact_relation');
            $table->dropColumn('date_of_birth');
        });
    }
};
