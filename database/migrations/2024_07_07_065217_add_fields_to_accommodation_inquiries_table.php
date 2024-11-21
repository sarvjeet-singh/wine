<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToAccommodationInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accommodation_inquiries', function (Blueprint $table) {
            $table->text('excursion_activities')->nullable();
            $table->string('preferred_accommodation');
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
            $table->dropColumn('excursion_activities');
            $table->dropColumn('preferred_accommodation');
        });
    }
}
