<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdateColumnTwoNine extends Migration
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
                if (!Schema::hasColumn('settings', 'currency_swipe'))
                {
                    $table->boolean('currency_swipe')->default(1);
                }
            });

            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'attandance_enable'))
                {
                    $table->boolean('attandance_enable')->default(0);
                }
            });

            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'youtube_enable'))
                {
                    $table->boolean('youtube_enable')->default(0);
                }
            });

             Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'vimeo_enable'))
                {
                    $table->boolean('vimeo_enable')->default(0);
                }
            });
        }


        if(Schema::hasTable('bundle_courses') ) {
            Schema::table('bundle_courses', function (Blueprint $table) {
                if (!Schema::hasColumn('bundle_courses', 'short_detail'))
                {
                    $table->longtext('short_detail')->nullable();
                }
            });
        }


        if(Schema::hasTable('manual_payment') ) {
            Schema::table('manual_payment', function (Blueprint $table) {
                if (Schema::hasColumn('manual_payment', 'detail'))
                {
                    $table->longtext('detail')->change();
                }
            });
        }


        if(Schema::hasTable('course_classes') ) {
            Schema::table('course_classes', function (Blueprint $table) {
                if (Schema::hasColumn('course_classes', 'file'))
                {
                    $table->string('file')->change();
                }
            });
        }


        if(Schema::hasTable('courses') ) {
            Schema::table('courses', function (Blueprint $table) {
                if (Schema::hasColumn('courses', 'tags'))
                {
                    $table->renameColumn('tags', 'level_tags');
                }
            });
        }

        if(Schema::hasTable('courses') ) {
            Schema::table('courses', function (Blueprint $table) {
                if (!Schema::hasColumn('courses', 'course_tags'))
                {
                    $table->longtext('course_tags')->nullable();
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
