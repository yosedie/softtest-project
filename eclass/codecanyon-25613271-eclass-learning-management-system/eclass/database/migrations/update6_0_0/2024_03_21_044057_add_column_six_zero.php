<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSixZero extends Migration
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
                if (!Schema::hasColumn('settings', 'api_enable')) {
                    // Add the column 'api_enable'
                    $table->string('api_enable')->nullable();
                }
            });
        }
        if(Schema::hasTable('course_backups') ) {
            Schema::table('course_backups', function (Blueprint $table) {
                if (!Schema::hasColumn('course_backups', 'refund_policy_id'))
                {
                    $table->string('refund_policy_id')->nullable();
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
