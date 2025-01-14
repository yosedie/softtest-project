<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGetStartedsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('get_starteds')){
			Schema::create('get_starteds', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('heading', 191)->nullable();
				$table->string('sub_heading', 191)->nullable();
				$table->string('button_txt', 191)->nullable();
				$table->string('image', 191)->nullable();
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
		Schema::drop('get_starteds');
	}

}
