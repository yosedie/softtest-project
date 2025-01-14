<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('questions')){
			Schema::create('questions', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('user_id', 191);
				$table->integer('instructor_id')->nullable();
				$table->string('course_id', 191);
				$table->string('question', 191);
				$table->string('answer', 191);
				$table->enum('status', array('1','0'))->nullable();
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
		Schema::drop('questions');
	}

}
