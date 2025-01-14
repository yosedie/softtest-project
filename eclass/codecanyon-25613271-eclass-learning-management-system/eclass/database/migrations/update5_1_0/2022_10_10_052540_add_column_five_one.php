<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFiveOne extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('homesettings') ) {
            Schema::table('homesettings', function (Blueprint $table) {
                if (!Schema::hasColumn('homesettings', 'service_enable'))
                {
                    $table->boolean('service_enable')->default(1);
                }
            });
        }
        if(Schema::hasTable('homesettings') ) {
            Schema::table('homesettings', function (Blueprint $table) {
                if (!Schema::hasColumn('homesettings', 'feature_enable'))
                {
                    $table->boolean('feature_enable')->default(1);
                }
            });
        }
        if(Schema::hasTable('quiz_questions') ) {
            Schema::table('quiz_questions', function (Blueprint $table) {
                if (!Schema::hasColumn('quiz_questions', 'data_type'))
                {
                    $table->string('data_type', 191)->default('Objective');
                }
            });
        }
        if(Schema::hasTable('quiz_questions') ) {
            Schema::table('quiz_questions', function (Blueprint $table) {
                if (!Schema::hasColumn('quiz_questions', 'first_option_ans'))
                {
                    $table->string('first_option_ans', 191)->nullable();
                }
            });
        }
        if(Schema::hasTable('quiz_questions') ) {
            Schema::table('quiz_questions', function (Blueprint $table) {
                if (!Schema::hasColumn('quiz_questions', 'second_option_ans'))
                {
                    $table->string('second_option_ans', 191)->nullable();
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
