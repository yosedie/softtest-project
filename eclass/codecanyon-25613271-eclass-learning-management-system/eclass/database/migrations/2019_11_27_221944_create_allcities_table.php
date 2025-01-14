<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAllcitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('allcities')){
			Schema::create('allcities', function(Blueprint $table)
			{
				$table->integer('id', true);
				$table->string('name', 30);
				$table->integer('state_id');
				$table->integer('pincode')->nullable();
				$table->dateTime('updated_at')->nullable();
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
		Schema::drop('allcities');
	}

}
