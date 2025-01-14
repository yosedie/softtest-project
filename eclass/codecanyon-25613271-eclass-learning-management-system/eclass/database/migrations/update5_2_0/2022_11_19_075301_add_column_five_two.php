<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFiveTwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('certificate_design') ) {
            Schema::table('certificate_design', function (Blueprint $table) {
                if (!Schema::hasColumn('certificate_design', 'percentage'))
                {
                    $table->string('percentage')->nullable();
                }
            });
        }
        if(Schema::hasTable('certificate_design') ) {
            Schema::table('certificate_design', function (Blueprint $table) {
                if (!Schema::hasColumn('certificate_design', 'widget1_enable'))
                {
                    $table->string('widget1_enable')->nullable();
                }
            });
        }
        if(Schema::hasTable('certificate_design') ) {
            Schema::table('certificate_design', function (Blueprint $table) {
                if (!Schema::hasColumn('certificate_design', 'widget2_enable'))
                {
                    $table->string('widget2_enable')->nullable();
                }
            });
        }
        if(Schema::hasTable('certificate_design') ) {
            Schema::table('certificate_design', function (Blueprint $table) {
                if (!Schema::hasColumn('certificate_design', 'widget3_enable'))
                {
                    $table->string('widget3_enable')->nullable();
                }
            });
        }
        if(Schema::hasTable('course_chapters') ) {
            Schema::table('course_chapters', function (Blueprint $table) {
                if (!Schema::hasColumn('course_chapters', 'goal_date'))
                {
                    $table->string('goal_date')->nullable();
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
