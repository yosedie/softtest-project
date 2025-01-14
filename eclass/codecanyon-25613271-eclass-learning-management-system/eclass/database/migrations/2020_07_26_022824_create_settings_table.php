<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('settings')){
			Schema::create('settings', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('project_title', 191)->nullable();
				$table->string('logo', 191)->nullable();
				$table->string('favicon', 191)->nullable();
				$table->string('cpy_txt', 191)->nullable();
				$table->string('logo_type', 191)->nullable();
				$table->boolean('rightclick')->default(1);
				$table->boolean('inspect')->default(1);
				$table->string('meta_data_desc', 191)->nullable();
				$table->string('meta_data_keyword', 191)->nullable();
				$table->string('google_ana', 191)->nullable();
				$table->string('fb_pixel', 191)->nullable();
				$table->string('google_search_console',)->nullable();
				$table->boolean('fb_login_enable')->nullable();
				$table->boolean('google_login_enable')->nullable();
				$table->boolean('gitlab_login_enable')->nullable();
				$table->boolean('stripe_enable')->nullable();
				$table->boolean('instamojo_enable')->nullable();
				$table->boolean('paypal_enable')->nullable();
				$table->boolean('paytm_enable')->nullable();
				$table->boolean('braintree_enable')->nullable();
				$table->boolean('razorpay_enable')->nullable();
				$table->boolean('paystack_enable')->nullable();
				$table->boolean('w_email_enable')->nullable();
				$table->boolean('verify_enable')->default(0);
				$table->string('wel_email', 191)->nullable();
				$table->text('default_address')->nullable();
				$table->string('default_phone', 191)->nullable();
				$table->boolean('instructor_enable')->nullable();
				$table->boolean('debug_enable')->default(1);
				$table->integer('cat_enable')->default(0);
				$table->integer('feature_amount')->nullable();
				$table->boolean('preloader_enable')->nullable()->default(1);
				$table->integer('zoom_enable')->nullable()->default(0);
				$table->boolean('amazon_enable')->nullable()->default(0);
				$table->boolean('captcha_enable')->nullable()->default(0);
				$table->boolean('bbl_enable')->default(0);
				$table->string('map_lat')->nullable();
				$table->string('map_long')->nullable();
				$table->string('map_enable', 191)->default('map');
				$table->string('contact_image')->nullable();
				$table->boolean('mobile_enable')->default(0);
				$table->boolean('promo_enable')->default(0);
				$table->text('promo_text')->nullable();
				$table->string('promo_link')->nullable();
				$table->boolean('linkedin_enable')->default(0);
				$table->string('map_api')->nullable();
				$table->boolean('twitter_enable')->default(0);
				$table->boolean('aws_enable')->nullable()->default(0);
				$table->boolean('certificate_enable')->default(1);
				$table->boolean('device_control')->default(0);
				$table->boolean('ipblock_enable')->default(0);
				$table->text('ipblock')->nullable();
				$table->boolean('assignment_enable')->nullable()->default(0);
				$table->boolean('appointment_enable')->nullable()->default(0);
				$table->string('instagram_url')->nullable();
				$table->string('facebook_url')->nullable();
				$table->string('twitter_url')->nullable();
				$table->string('youtube_url')->nullable();
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
		Schema::drop('settings');
	}

}
