<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuizTopicsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('quiz_topics')){
			Schema::create('quiz_topics', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('course_id');
				$table->string('title', 191);
				$table->text('description', 65535)->nullable();
				$table->integer('per_q_mark');
				$table->integer('timer')->nullable();
				$table->boolean('status')->default(1);
				$table->integer('show_ans')->default(0);
				$table->boolean('quiz_again')->default(1);
				$table->integer('due_days')->nullable();
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
		Schema::drop('quiz_topics');
	}

}
