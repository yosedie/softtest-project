<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdateColumnTwoFour extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('settings')) {
            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'wapp_phone'))
                {
                    $table->string('wapp_phone')->nullable();
                }
                if (!Schema::hasColumn('settings', 'wapp_popup_msg'))
                {
                    $table->text('wapp_popup_msg')->nullable();
                }
                if (!Schema::hasColumn('settings', 'wapp_title'))
                {
                    $table->text('wapp_title')->nullable();
                }
                if (!Schema::hasColumn('settings', 'wapp_position'))
                {
                    $table->string('wapp_position')->nullable();
                }
                if (!Schema::hasColumn('settings', 'wapp_color'))
                {
                    $table->string('wapp_color')->nullable();
                }
                if (!Schema::hasColumn('settings', 'wapp_enable'))
                {
                    $table->boolean('wapp_enable')->default(0);
                }

                if (!Schema::hasColumn('settings', 'enable_payhere'))
                {
                    $table->boolean('enable_payhere')->default(0);
                }
            });
        }

        if(Schema::hasTable('course_classes') ) {
            Schema::table('course_classes', function (Blueprint $table) {
                if (!Schema::hasColumn('course_classes', 'file'))
                {
                    $table->integer('file')->nullable();
                }
            });
        }

        if(Schema::hasTable('meetings') ) {
            Schema::table('meetings', function (Blueprint $table) {
                if (!Schema::hasColumn('meetings', 'type'))
                {
                    $table->integer('type')->nullable();
                }

                if (!Schema::hasColumn('meetings', 'agenda'))
                {
                    $table->longtext('agenda')->nullable();
                }
            });
        }

        if(Schema::hasTable('coming_soons') ) {
            Schema::table('coming_soons', function (Blueprint $table) {
                if (!Schema::hasColumn('coming_soons', 'allowed_ip'))
                {
                    $table->longtext('allowed_ip')->nullable();
                }
                if (!Schema::hasColumn('coming_soons', 'enable'))
                {
                    $table->integer('enable')->default(0);
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
