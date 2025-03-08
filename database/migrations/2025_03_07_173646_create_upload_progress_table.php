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
        Schema::create('upload_progress', function (Blueprint $table) {
            $table->id();
            $table->string('file_name')->unique();
            $table->bigInteger('uploaded_size')->default(0);
            $table->bigInteger('total_size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upload_progress');
    }
};
