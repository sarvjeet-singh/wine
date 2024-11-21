<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('vendor_suggest', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id')->nullable();
        $table->string('vendor_name')->nullable();
        $table->string('street_address')->nullable();
        $table->string('unit_suite')->nullable();
        $table->string('city_town')->nullable();
        $table->string('province_state')->nullable();
        $table->string('postal_zip')->nullable();
        $table->string('vendor_phone')->nullable();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('vendor_suggest');
}
};
