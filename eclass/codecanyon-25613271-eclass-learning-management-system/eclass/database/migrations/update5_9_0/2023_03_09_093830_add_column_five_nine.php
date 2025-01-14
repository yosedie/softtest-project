<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFiveNine extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('settings')) {
    Schema::table('settings', function (Blueprint $table) {
        // Check if the column 'api_key' does not exist
        if (!Schema::hasColumn('settings', 'api_key')) {
            // Add the column 'api_key'
            $table->string('api_key')->nullable();
        }
    });
}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
