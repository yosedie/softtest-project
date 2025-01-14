<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSlidersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('sliders')){
			Schema::create('sliders', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('heading', 191);
				$table->string('sub_heading', 191);
				$table->string('search_text', 191);
				$table->text('detail', 65535);
				$table->enum('status', array('1','0'));
				$table->string('image', 191);
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
		Schema::drop('sliders');
	}

}
