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
        Schema::create('vendor_inqueries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->date('check_in')->nullable();
            $table->date('check_out')->nullable();
            $table->string('visit_nature')->nullable();
            $table->integer('guest_no')->nullable();
            $table->integer('number_of_rooms')->nullable();
            $table->string('accommodation_type')->nullable();
            $table->string('sub_region')->nullable();
            $table->text('additional_comments_inquiry')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_inqueries');
    }
};
