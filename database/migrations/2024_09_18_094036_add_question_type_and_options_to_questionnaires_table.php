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
        Schema::table('questionnaires', function (Blueprint $table) {
            $table->string('question_type')->nullable()->after('question'); // single_choice, multiple_choice
            $table->json('options')->nullable()->after('question_type'); // JSON for storing options
            $table->string('vendor_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questionnaires', function (Blueprint $table) {
        $table->dropColumn(['question_type', 'options']);
        });
    }
};
