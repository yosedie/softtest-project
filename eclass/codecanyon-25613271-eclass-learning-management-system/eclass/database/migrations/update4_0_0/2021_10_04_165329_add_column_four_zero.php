<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFourZero extends Migration
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
                if (!Schema::hasColumn('settings', 'guest_enable'))
                {
                    $table->boolean('guest_enable')->default(0);
                }
            });
        }

        if(Schema::hasTable('settings') ) {
            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'notifiy_enable'))
                {
                    $table->boolean('notifiy_enable')->default(0);
                }
            });
        }

        if(Schema::hasTable('courses') ) {
            Schema::table('courses', function (Blueprint $table) {
                if (!Schema::hasColumn('courses', 'institude_id'))
                {
                    $table->string('institude_id');
                }
            });
        }

        if(Schema::hasTable('users') ) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'age'))
                {
                    $table->string('age');
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
