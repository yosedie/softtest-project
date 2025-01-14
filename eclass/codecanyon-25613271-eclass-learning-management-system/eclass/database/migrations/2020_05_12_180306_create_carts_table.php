<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCartsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('carts')){
			Schema::create('carts', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('user_id');
				$table->integer('course_id')->nullable();
				$table->integer('category_id')->nullable();
				$table->float('price', 10, 0)->nullable();
				$table->float('offer_price', 10, 0)->nullable();
				$table->float('disamount', 10, 0)->nullable();
				$table->string('distype', 191)->nullable();
				$table->integer('bundle_id')->nullable();
				$table->boolean('type')->default(0);
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
		Schema::drop('carts');
	}

}
