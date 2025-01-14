<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBankTransfersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('bank_transfers')){
			Schema::create('bank_transfers', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('bank_name', 191);
				$table->string('ifcs_code', 191)->nullable();
				$table->string('account_number', 191);
				$table->string('account_holder_name', 191);
				$table->string('swift_code', 191)->nullable();
				$table->boolean('bank_enable')->default(0);
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
		Schema::drop('bank_transfers');
	}

}
