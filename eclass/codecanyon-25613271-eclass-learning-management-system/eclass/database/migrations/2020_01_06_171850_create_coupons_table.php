<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCouponsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('coupons')){
			Schema::create('coupons', function(Blueprint $table){
				$table->increments('id');
				$table->string('code', 191);
				$table->string('distype', 100);
				$table->string('amount', 191);
				$table->string('link_by', 100);
				$table->integer('course_id')->unsigned()->nullable();
				$table->integer('category_id')->nullable();
				$table->integer('maxusage')->unsigned()->nullable();
				$table->float('minamount', 10, 0)->nullable();
				$table->dateTime('expirydate');
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
		Schema::drop('coupons');
	}

}
