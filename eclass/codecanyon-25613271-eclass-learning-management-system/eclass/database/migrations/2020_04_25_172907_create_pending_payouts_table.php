<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePendingPayoutsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('pending_payouts')){
			Schema::create('pending_payouts', function(Blueprint $table)
			{
				$table->bigInteger('id', true)->unsigned();
				$table->integer('user_id');
				$table->integer('course_id');
				$table->string('order_id', 191)->nullable();
				$table->string('transaction_id', 191);
				$table->integer('total_amount');
				$table->integer('instructor_revenue');
				$table->string('currency', 191);
				$table->string('currency_icon', 191);
				$table->boolean('status')->default(0);
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
		Schema::drop('pending_payouts');
	}

}
