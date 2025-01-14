<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('categories')){
			Schema::create('categories', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('title', 191)->nullable();
				$table->string('icon', 191)->nullable();
				$table->string('slug', 191)->nullable();
				$table->enum('featured', array('1','0'));
				$table->enum('status', array('1','0'));
				$table->integer('position')->nullable();
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
		Schema::drop('categories');
	}

}
