<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdateColumnThreeOne extends Migration
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
                if (!Schema::hasColumn('settings', 'plan_enable'))
                {
                    $table->boolean('plan_enable')->default(0);
                }
            });

            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'googlemeet_enable'))
                {
                    $table->boolean('googlemeet_enable')->default(0);
                }
            });

            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'cookie_enable'))
                {
                    $table->boolean('cookie_enable')->default(1);
                }
            });

            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'jitsimeet_enable'))
                {
                    $table->boolean('jitsimeet_enable')->default(1);
                }
            });
        }

        if(Schema::hasTable('courses') ) {
            Schema::table('courses', function (Blueprint $table) {
                if (!Schema::hasColumn('courses', 'reject_txt'))
                {
                    $table->longtext('reject_txt')->nullable();
                }
            });
        }

        if(Schema::hasTable('quiz_topics') ) {
            Schema::table('quiz_topics', function (Blueprint $table) {
                if (!Schema::hasColumn('quiz_topics', 'type'))
                {
                    $table->string('type')->nullable();
                }
            });

        }

        if(Schema::hasTable('quiz_questions') ) {
            Schema::table('quiz_questions', function (Blueprint $table) {
                if (!Schema::hasColumn('quiz_questions', 'type'))
                {
                    $table->string('type')->nullable();
                }
            });

            Schema::table('quiz_questions', function (Blueprint $table) {
                if (Schema::hasColumn('quiz_questions', 'a'))
                {
                    $table->string('a')->nullable()->change();
                }
            });

            Schema::table('quiz_questions', function (Blueprint $table) {
                if (Schema::hasColumn('quiz_questions', 'b'))
                {
                    $table->string('b')->nullable()->change();
                }
            });

            Schema::table('quiz_questions', function (Blueprint $table) {
                if (Schema::hasColumn('quiz_questions', 'c'))
                {
                    $table->string('c')->nullable()->change();
                }
            });

            Schema::table('quiz_questions', function (Blueprint $table) {
                if (Schema::hasColumn('quiz_questions', 'd'))
                {
                    $table->string('d')->nullable()->change();
                }
            });

            Schema::table('quiz_questions', function (Blueprint $table) {
                if (Schema::hasColumn('quiz_questions', 'answer'))
                {
                    $table->string('answer')->nullable()->change();
                }
            });
        }

        if(Schema::hasTable('quiz_answers') ) {
            Schema::table('quiz_answers', function (Blueprint $table) {
                if (!Schema::hasColumn('quiz_answers', 'type'))
                {
                    $table->string('type')->nullable();
                }
            });

            Schema::table('quiz_answers', function (Blueprint $table) {
                if (!Schema::hasColumn('quiz_answers', 'txt_answer'))
                {
                    $table->longtext('txt_answer')->nullable();
                }
            });

            Schema::table('quiz_answers', function (Blueprint $table) {
                if (!Schema::hasColumn('quiz_answers', 'txt_approved'))
                {
                    $table->boolean('txt_approved')->default(0);
                }
            });

            Schema::table('quiz_answers', function (Blueprint $table) {
                if (Schema::hasColumn('quiz_answers', 'user_answer'))
                {
                    $table->string('user_answer')->nullable()->change();
                }
            });

            Schema::table('quiz_answers', function (Blueprint $table) {
                if (Schema::hasColumn('quiz_answers', 'answer'))
                {
                    $table->string('answer')->nullable()->change();
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
