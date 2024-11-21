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
            $table->string('facebook')->nullable()->after('emergency_contact_number');
            $table->string('instagram')->nullable()->after('facebook');
            $table->string('youtube')->nullable()->after('instagram');
            $table->string('tiktok')->nullable()->after('youtube');
            $table->string('twitter')->nullable()->after('tiktok');
            $table->string('linkedin')->nullable()->after('twitter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'facebook',
                'instagram',
                'youtube',
                'tiktok',
                'twitter',
                'linkedin',
            ]);
        });
    }
};
