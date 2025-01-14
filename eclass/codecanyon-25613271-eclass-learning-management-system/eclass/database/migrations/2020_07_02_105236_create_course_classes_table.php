<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourseClassesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('course_classes')){
			Schema::create('course_classes', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('course_id', 191)->nullable();
				$table->string('coursechapter_id', 191)->nullable();
				$table->string('title', 191)->nullable();
				$table->string('image', 191)->nullable();
				$table->string('zip', 191)->nullable();
				$table->string('pdf', 191)->nullable();
				$table->string('audio')->nullable();
				$table->string('size', 191)->nullable();
				$table->string('url', 191)->nullable();
				$table->text('iframe_url')->nullable();
				$table->string('video', 191)->nullable();
				$table->string('duration', 191)->nullable();
				$table->enum('status', array('1','0'))->nullable();
				$table->enum('featured', array('1','0'))->nullable();
				$table->string('type', 191)->nullable();
				$table->string('preview_video')->nullable();
				$table->string('preview_url')->nullable();
				$table->string('preview_type')->nullable();
				$table->dateTime('date_time')->nullable();
				$table->text('detail')->nullable();
				$table->integer('position')->nullable();
				$table->string('aws_upload')->nullable();
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
		Schema::drop('course_classes');
	}

}
