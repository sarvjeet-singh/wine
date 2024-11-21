<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->string('room_style')->nullable();
            $table->decimal('room_price', 8, 2)->nullable(); // Room price with two decimal places
            $table->integer('inventory')->nullable(); // Number of rooms available
            $table->string('room_image')->nullable(); // Path to the uploaded file
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_rooms');
    }
};
