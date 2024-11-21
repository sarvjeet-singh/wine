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
        Schema::create('vendor_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('check_in')->nullable();
            $table->date('check_out')->nullable();
            $table->string('visit_nature')->nullable();
            $table->integer('guest_no')->nullable();
            $table->string('vendor_sub_category')->nullable();
            $table->string('sub_region')->nullable();
            $table->integer('rooms_required')->nullable();
            $table->text('excursion_activities')->nullable();
            $table->string('preferred_accommodation')->nullable();
            $table->string('group_type')->nullable();
            $table->longText('additional_comments_inquiry')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_inquiries');
    }
};
