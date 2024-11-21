<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Rename the 'name' column to 'firstname'
            $table->renameColumn('name', 'firstname');
            
            // Add a new 'lastname' column that allows null values
            $table->string('lastname')->nullable();
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
            // Rename the 'firstname' column back to 'name'
            $table->renameColumn('firstname', 'name');
            
            // Drop the 'lastname' column
            $table->dropColumn('lastname');
        });
    }
}
