<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdateColumnTwoEight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('quiz_questions') ) {
            Schema::table('quiz_questions', function (Blueprint $table) {
                if (!Schema::hasColumn('quiz_questions', 'question_video_link'))
                {
                    $table->string('question_video_link')->nullable();
                }
            });

            Schema::table('quiz_questions', function (Blueprint $table) {
                if (!Schema::hasColumn('quiz_questions', 'question_img'))
                {
                    $table->string('question_img')->nullable();
                }
            });
        }


        if(Schema::hasTable('coupons') ) {
            Schema::table('coupons', function (Blueprint $table) {
                if (!Schema::hasColumn('coupons', 'show_to_users'))
                {
                    $table->boolean('show_to_users')->default(1);
                }
            });
        }


        if(Schema::hasTable('meetings') ) {
            Schema::table('meetings', function (Blueprint $table) {
                if (!Schema::hasColumn('meetings', 'image'))
                {
                    $table->string('image')->nullable();
                }
            });
        }

        if(Schema::hasTable('courses') ) {
            Schema::table('courses', function (Blueprint $table) {
                if (!Schema::hasColumn('courses', 'assignment_enable'))
                {
                    $table->boolean('assignment_enable')->default(1);
                }
            });

            Schema::table('courses', function (Blueprint $table) {
                if (!Schema::hasColumn('courses', 'appointment_enable'))
                {
                    $table->boolean('appointment_enable')->default(1);
                }
            });

             Schema::table('courses', function (Blueprint $table) {
                if (!Schema::hasColumn('courses', 'certificate_enable'))
                {
                    $table->boolean('certificate_enable')->default(1);
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
