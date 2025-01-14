<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdateColumnThreeZero extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('settings') ) {
            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'aamarpay_enable'))
                {
                    $table->boolean('aamarpay_enable')->default(0);
                }
            });

            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'activity_enable'))
                {
                    $table->boolean('activity_enable')->default(0);
                }
            });

            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'twilio_enable'))
                {
                    $table->boolean('twilio_enable')->default(0);
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
