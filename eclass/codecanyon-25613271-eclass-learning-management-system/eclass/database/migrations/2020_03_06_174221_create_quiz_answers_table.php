<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('quiz_answers')){
            Schema::create('quiz_answers', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('course_id')->unsigned();
                $table->integer('topic_id')->unsigned();
                $table->integer('user_id');
                $table->integer('question_id');
                $table->char('user_answer');
                $table->char('answer');
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
        Schema::dropIfExists('quiz_answers');
    }
}
