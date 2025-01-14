<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBundleCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('bundle_courses')){
			Schema::create('bundle_courses', function(Blueprint $table)
			{
				$table->bigInteger('id', true)->unsigned();
				$table->string('user_id', 191);
				$table->string('course_id', 191);
				$table->string('title', 191)->nullable();
				$table->text('detail')->nullable();
				$table->integer('price')->nullable();
				$table->integer('discount_price')->nullable();
				$table->enum('type', array('1','0'))->nullable();
				$table->string('slug', 191)->nullable();
				$table->boolean('status')->nullable();
				$table->boolean('featured')->default(1);
				$table->string('preview_image', 191)->nullable();
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
		Schema::drop('bundle_courses');
	}

}
