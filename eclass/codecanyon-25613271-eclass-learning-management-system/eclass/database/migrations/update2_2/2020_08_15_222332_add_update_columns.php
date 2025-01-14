<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdateColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('settings') ) {
            Schema::table('settings', function(Blueprint $table){
                if (!Schema::hasColumn('settings', 'hide_identity'))
                {
                    $table->boolean('hide_identity')->default(0);
                }

                if (!Schema::hasColumn('settings', 'footer_logo'))
                {
                    $table->string('footer_logo', 191)->nullable();
                }
            });
        }

        if(Schema::hasTable('courses') ) {
            Schema::table('courses', function(Blueprint $table){
                if (!Schema::hasColumn('courses', 'duration_type'))
                {
                    $table->string('duration_type')->default('m');
                }
                if (!Schema::hasColumn('courses', 'instructor_revenue'))
                {
                    $table->integer('instructor_revenue')->nullable();
                }
                if (!Schema::hasColumn('courses', 'involvement_request'))
                {
                    $table->boolean('involvement_request')->default(0);
                }
            });
        }

        if(Schema::hasTable('course_chapters') ) {
            Schema::table('course_chapters', function (Blueprint $table) {
                if (!Schema::hasColumn('course_chapters', 'user_id'))
                {
                    $table->integer('user_id')->nullable();
                }
            });
        }

        if(Schema::hasTable('course_classes') ) {
            Schema::table('course_classes', function (Blueprint $table) {
                if (!Schema::hasColumn('course_classes', 'user_id'))
                {
                    $table->integer('user_id')->nullable();
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
