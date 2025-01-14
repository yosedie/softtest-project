<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('users')){
			Schema::create('users', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('fname', 191);
				$table->string('lname', 191);
				$table->date('doa')->nullable();
				$table->string('mobile', 191)->unique()->nullable();
				$table->string('email', 191)->unique();
				$table->string('password', 191);
				$table->string('address', 191)->nullable();
				$table->string('married_status', 191)->nullable();
				$table->integer('city_id')->unsigned()->nullable();
				$table->integer('state_id')->unsigned()->nullable();
				$table->integer('country_id')->unsigned()->nullable();
				$table->string('gender', 191)->nullable();
				$table->string('pin_code', 191)->nullable();
				$table->boolean('status')->default(1);
				$table->boolean('verified');
				$table->string('user_img', 191)->nullable();
				$table->string('role', 191)->default('user');
				$table->dateTime('email_verified_at')->nullable();
				$table->text('detail')->nullable();
				$table->integer('braintree_id');
				$table->string('fb_url', 191)->nullable();
				$table->string('twitter_url', 191)->nullable();
				$table->string('youtube_url', 191)->nullable();
				$table->string('linkedin_url', 191)->nullable();
				$table->string('remember_token', 100)->nullable();
				$table->string('prefer_pay_method')->nullable();
				$table->string('paypal_email')->nullable();
				$table->string('paytm_mobile')->nullable();
				$table->string('bank_acc_name')->nullable();
				$table->string('bank_acc_no')->nullable();
				$table->string('ifsc_code')->nullable();
				$table->string('bank_name')->nullable();
				$table->string('facebook_id')->nullable();
				$table->string('google_id')->nullable();
				$table->string('amazon_id')->nullable();
				$table->timestamps();
				$table->string('zoom_email', 200)->nullable();
				$table->text('jwt_token')->nullable();
				$table->string('gitlab_id')->nullable();
				$table->string('linkedin_id')->nullable();
				$table->string('twitter_id')->nullable();
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
		Schema::drop('users');
	}

}
