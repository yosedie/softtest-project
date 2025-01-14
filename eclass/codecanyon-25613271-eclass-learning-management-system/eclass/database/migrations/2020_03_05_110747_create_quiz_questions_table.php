<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('quiz_questions')){
            Schema::create('quiz_questions', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('course_id');
                $table->integer('topic_id');
                $table->longtext('question');
                $table->string('a');
                $table->string('b');
                $table->string('c');
                $table->string('d');
                $table->string('answer');
                $table->timestamps();
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
        Schema::dropIfExists('quiz_questions');
    }
}
