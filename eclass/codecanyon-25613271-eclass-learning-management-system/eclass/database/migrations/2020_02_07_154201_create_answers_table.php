<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('answers')){
			Schema::create('answers', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('instructor_id')->nullable();
				$table->integer('ans_user_id');
				$table->integer('ques_user_id');
				$table->integer('course_id');
				$table->integer('question_id');
				$table->string('answer', 191);
				$table->boolean('status');
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
		Schema::drop('answers');
	}

}
