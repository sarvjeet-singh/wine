<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('display_name')->nullable()->after('password');
            $table->string('gender')->nullable()->after('display_name');
            $table->string('age_range')->nullable()->after('gender');
            $table->string('role')->nullable()->after('age_range');
            $table->string('emergency_contact_name')->nullable()->after('role');
            $table->string('emergency_contact_relation')->nullable()->after('emergency_contact_name');
            $table->string('emergency_contact_phone_number')->nullable()->after('emergency_contact_relation');
            $table->string('emergency_contact_number')->nullable()->after('emergency_contact_phone_number');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'display_name',
                'gender',
                'age_range',
                'role',
                'emergency_contact_name',
                'emergency_contact_relation',
                'emergency_contact_phone_number',
                'emergency_contact_number',
                
            ]);
        });
    }
}
