<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('countries')){
			Schema::create('countries', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('country_id')->nullable();
				$table->char('iso', 2);
				$table->string('name', 80);
				$table->string('nicename', 80);
				$table->char('iso3', 3)->nullable();
				$table->smallInteger('numcode')->nullable();
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
		Schema::drop('countries');
	}

}
