<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWineryInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('winery_inquiries', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('vendor_id');
            $table->date('check_in_date'); // Tentative arrival/check-in date
            $table->date('check_out_date'); // Tentative departure/check-out date
            $table->json('visit_nature'); // Nature of the visit (multiple values like Business or Pleasure)
            $table->integer('number_of_guests'); // Number of guests in the travel party
            $table->string('experience_preference'); // Tastings or immersive experience
            $table->string('sub_region'); // Preferred sub-region
            $table->json('winery_types'); // Preferred winery types (multiple values like Destination, Vineyard, etc.)
            $table->text('additional_comments')->nullable(); // Additional comments
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('winery_inquiries');
    }
}
