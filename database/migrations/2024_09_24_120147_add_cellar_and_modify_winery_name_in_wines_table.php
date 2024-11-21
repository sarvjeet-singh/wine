<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCellarAndModifyWineryNameInWinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_wines', function (Blueprint $table) {
            // Add the new 'cellar' field
            $table->string('cellar')->nullable();

            // Modify the existing 'winery_name' field to be nullable
            $table->string('winery_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_wines', function (Blueprint $table) {
            // Drop the 'cellar' field if we roll back
            $table->dropColumn('cellar');

            // Revert 'winery_name' to be non-nullable if we roll back
            $table->string('winery_name')->nullable(false)->change();
        });
    }
}