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
        Schema::create('accommodation_inquiries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vendor_id');
            $table->date('check_in');
            $table->date('check_out');
            $table->string('visit_nature');
            $table->integer('guest_no');
            $table->string('accommodation_type');
            $table->string('sub_region');
            $table->integer('rooms_required');
            $table->text('additional_comments_inquiry')->nullable();
            $table->timestamps();
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
