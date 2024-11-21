<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->json('vendor_media')->nullable(); // Store media paths as JSON
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('vendor_media');
        });
    }
};
