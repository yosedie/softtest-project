<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourseChaptersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('course_chapters')){
			Schema::create('course_chapters', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('course_id', 191);
				$table->string('chapter_name', 191)->nullable();
				$table->string('short_number', 191)->nullable();
				$table->enum('status', array('1','0'));
				$table->string('file')->nullable();
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
		Schema::drop('course_chapters');
	}

}
