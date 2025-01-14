<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdateColumnTwoSeven extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('review_helpfuls') ) {
            Schema::table('review_helpfuls', function (Blueprint $table) {
                if (!Schema::hasColumn('review_helpfuls', 'review_like'))
                {
                    $table->boolean('review_like')->default(0);
                }
            });

            Schema::table('review_helpfuls', function (Blueprint $table) {
                if (!Schema::hasColumn('review_helpfuls', 'review_dislike'))
                {
                    $table->boolean('review_dislike')->default(0);
                }
            });
        }

        if(Schema::hasTable('courses') ) {
            Schema::table('courses', function (Blueprint $table) {
                if (!Schema::hasColumn('courses', 'tags'))
                {
                    $table->longtext('tags')->nullable();
                }
            });
        }

        if(Schema::hasTable('course_chapters') ) {
            Schema::table('course_chapters', function (Blueprint $table) {
                if (!Schema::hasColumn('course_chapters', 'position'))
                {
                    $table->integer('position')->nullable();
                }
            });
        }

        if(Schema::hasTable('settings') ) {
            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'ssl_enable'))
                {
                    $table->boolean('ssl_enable')->default(0);
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
