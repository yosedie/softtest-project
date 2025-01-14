<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('orders')){
			Schema::create('orders', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('course_id')->nullable();
				$table->integer('user_id');
				$table->integer('instructor_id')->nullable();
				$table->string('order_id')->nullable();
				$table->text('transaction_id', 65535);
				$table->string('payment_method', 191);
				$table->string('total_amount', 191);
				$table->integer('coupon_discount')->nullable();
				$table->string('currency', 191);
				$table->string('currency_icon', 191);
				$table->boolean('status')->default(1);
				$table->integer('duration')->nullable();
				$table->date('enroll_start')->nullable();
				$table->date('enroll_expire')->nullable();
				$table->integer('instructor_revenue')->nullable();
				$table->integer('bundle_id')->nullable();
				$table->string('bundle_course_id', 191)->nullable();
				$table->string('proof')->nullable();
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
		Schema::drop('orders');
	}

}
