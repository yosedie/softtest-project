<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChildCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('child_categories')){
			
			Schema::create('child_categories', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('category_id')->nullable();
				$table->string('subcategory_id', 191);
				$table->string('title', 191)->nullable();
				$table->string('icon', 191)->nullable();
				$table->string('slug', 191)->nullable();
				$table->enum('status', array('1','0'));
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
		Schema::drop('child_categories');
	}

}
