<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessHoursTable extends Migration
{
    public function up()
    {
        Schema::create('business_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id'); // Add vendor ID
            $table->string('day'); // e.g., Monday, Tuesday, etc.
            $table->time('opening_time')->nullable(); // Can be null if closed
            $table->time('closing_time')->nullable(); // Can be null if closed
            $table->boolean('is_open')->default(true); // Switch to indicate open or closed
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('business_hours');
    }
}
