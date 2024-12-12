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
        Schema::create('accommodation_inquiries', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('vendor_id');
            $table->date('check_in_date'); // Tentative check-in date
            $table->date('check_out_date'); // Tentative check-out date
            $table->json('visit_nature'); // Nature of the visit (multiple values)
            $table->json('accommodation_type'); // Preferred accommodation types (multiple values)
            $table->integer('number_of_guests'); // Number of guests in the travel party
            $table->string('city'); // City/Town preference
            $table->string('rooms_or_beds'); // Number of rooms or beds required
            $table->text('additional_comments')->nullable(); // Additional comments
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodation_inquiries');
    }
};
