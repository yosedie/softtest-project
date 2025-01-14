<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAboutsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('abouts')){
			Schema::create('abouts', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('one_enable');
				$table->string('one_heading', 191);
				$table->string('one_image', 191);
				$table->text('one_text', 65535);
				$table->integer('two_enable');
				$table->string('two_heading', 191);
				$table->text('two_text', 65535);
				$table->string('two_imageone', 191);
				$table->string('two_imagetwo', 191);
				$table->string('two_imagethree', 191);
				$table->string('two_imagefour', 191);
				$table->string('two_txtone', 191);
				$table->string('two_txttwo', 191);
				$table->string('two_txtthree', 191);
				$table->string('two_txtfour', 191);
				$table->text('two_imagetext', 65535);
				$table->integer('three_enable');
				$table->string('three_heading', 191);
				$table->text('three_text', 65535);
				$table->string('three_countone', 191);
				$table->string('three_counttwo', 191);
				$table->string('three_countthree', 191);
				$table->string('three_countfour', 191);
				$table->string('three_countfive', 191);
				$table->string('three_countsix', 191);
				$table->string('three_txtone', 191);
				$table->string('three_txttwo', 191);
				$table->string('three_txtthree', 191);
				$table->string('three_txtfour', 191);
				$table->string('three_txtfive', 191);
				$table->string('three_txtsix', 191);
				$table->integer('four_enable');
				$table->string('four_heading', 191);
				$table->text('four_text', 65535);
				$table->string('four_btntext', 191);
				$table->string('four_imageone', 191);
				$table->string('four_imagetwo', 191);
				$table->string('four_txtone', 191);
				$table->string('four_txttwo', 191);
				$table->string('four_icon', 191);
				$table->integer('five_enable');
				$table->string('five_heading', 191);
				$table->text('five_text', 65535);
				$table->string('five_btntext', 191);
				$table->string('five_imageone', 191);
				$table->string('five_imagetwo', 191);
				$table->string('five_imagethree', 191);
				$table->integer('six_enable');
				$table->string('six_heading', 191);
				$table->string('six_txtone', 191);
				$table->string('six_txttwo', 191);
				$table->string('six_txtthree', 191);
				$table->text('six_deatilone', 65535);
				$table->text('six_deatiltwo', 65535);
				$table->text('six_deatilthree', 65535);
				$table->string('text_one')->nullable();
				$table->string('text_two')->nullable();
				$table->string('text_three')->nullable();
				$table->string('link_one')->nullable();
				$table->string('link_two')->nullable();
				$table->string('link_three')->nullable();
				$table->string('link_four')->nullable();
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
		Schema::drop('abouts');
	}

}
