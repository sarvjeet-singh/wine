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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->unique();
            $table->string('profile_image')->nullable();
            $table->string('profile_image_verified')->default('pending');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('display_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('age_range')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_relation')->nullable();
            $table->string('emergency_contact_phone_number')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->string('guestrewards')->nullable();
            $table->string('guestreward_user')->nullable();
            $table->unsignedBigInteger('guestrewards_vendor_id')->nullable();
            $table->string('guestrewards_social_media')->nullable();
            $table->string('street_address')->nullable();
            $table->string('suite')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->string('government_proof_front')->nullable();
            $table->string('government_proof_back')->nullable();
            $table->string('medical_physical_concerns')->nullable();
            $table->string('alternate_contact_full_name')->nullable();
            $table->string('alternate_contact_relation')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->boolean('first_login')->default(true);
            $table->boolean('password_updated')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
