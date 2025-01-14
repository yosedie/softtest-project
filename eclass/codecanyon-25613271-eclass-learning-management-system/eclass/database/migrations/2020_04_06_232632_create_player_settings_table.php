<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayerSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('player_settings')){
			Schema::create('player_settings', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('logo', 191);
				$table->boolean('logo_enable')->default(1);
				$table->string('cpy_text', 191);
				$table->boolean('share_enable')->default(1);
				$table->boolean('autoplay')->default(1);
				$table->integer('download')->default(0);
				$table->string('skin')->nullable();
				$table->boolean('loop_video')->default(0);
				$table->boolean('chrome_cast')->default(0);
				$table->string('player_google_analytics_id')->nullable();
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
		Schema::drop('player_settings');
	}

}
