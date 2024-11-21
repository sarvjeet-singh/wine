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
        Schema::table('accommodation_inquiries', function (Blueprint $table) {
            $table->text('experience_type')->nullable();
            $table->text('winery_type')->nullable();
            $table->text('group_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accommodation_inquiries', function (Blueprint $table) {
            $table->dropColumn('experience_type');
            $table->dropColumn('winery_type');
            $table->dropColumn('group_type');

        });
    }
};
