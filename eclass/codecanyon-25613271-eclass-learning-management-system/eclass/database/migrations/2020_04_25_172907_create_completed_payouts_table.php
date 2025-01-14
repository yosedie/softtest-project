<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompletedPayoutsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('completed_payouts')){
			Schema::create('completed_payouts', function(Blueprint $table){
				$table->bigInteger('id', true)->unsigned();
				$table->integer('user_id');
				$table->integer('payer_id');
				$table->integer('pay_total');
				$table->string('order_id', 191);
				$table->string('payment_method')->nullable();
				$table->string('currency', 191);
				$table->string('currency_icon', 191);
				$table->boolean('pay_status')->default(0);
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
		Schema::drop('completed_payouts');
	}

}
