<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExcursionInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('excursion_inquiries', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('vendor_id');
            $table->date('check_in_date'); // Tentative check-in date
            $table->date('check_out_date'); // Tentative check-out date
            $table->json('visit_nature'); // Nature of the visit (multiple values)
            $table->integer('number_of_guests'); // Number of guests in the travel party
            $table->string('city'); // City/Town preference
            $table->json('preferred_excursions'); // Preferred excursion types (multiple values)
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
        Schema::dropIfExists('excursion_inquiries');
    }
}

