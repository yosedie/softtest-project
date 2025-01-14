<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFourEight extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('faq_students') ) {
            Schema::table('faq_students', function (Blueprint $table) {
                if (!Schema::hasColumn('faq_students', 'position'))
                {
                    $table->string('position')->nullable();
             
                }
            });
        }
        if(Schema::hasTable('faq_instructors') ) {
            Schema::table('faq_instructors', function (Blueprint $table) {
                if (!Schema::hasColumn('faq_instructors', 'position'))
                {
                    $table->string('position')->nullable();
             
                }
            });
        }
        if(Schema::hasTable('flashsales') ) {
            Schema::table('flashsales', function (Blueprint $table) {
                if (!Schema::hasColumn('flashsales', 'position'))
                {
                    $table->string('position')->nullable();
             
                }
            });
        }
        if(Schema::hasTable('categories') ) {
            Schema::table('categories', function (Blueprint $table) {
                if (!Schema::hasColumn('categories', 'position'))
                {
                    $table->string('position')->nullable();
             
                }
            });
        }
        if(Schema::hasTable('quiz_questions') ) {
            Schema::table('quiz_questions', function (Blueprint $table) {
                if (!Schema::hasColumn('quiz_questions', 'position'))
                {
                    $table->string('position')->nullable();
             
                }
            });
        }
        if(Schema::hasTable('quiz_topics') ) {
            Schema::table('quiz_topics', function (Blueprint $table) {
                if (!Schema::hasColumn('quiz_topics', 'position'))
                {
                    $table->string('position')->nullable();
             
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
       
    }
}
