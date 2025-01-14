<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('wallet_settings')){
            Schema::create('wallet_settings', function (Blueprint $table) {
                $table->id();
                $table->integer('status')->unsigned()->default(0);
                $table->boolean('paytm_enable')->nullable()->default(0);
                $table->boolean('paypal_enable')->nullable()->default(0);
                $table->boolean('razorpay_enable')->nullable()->default(0);
                $table->boolean('stripe_enable')->nullable()->default(0);
                $table->boolean('braintree_enable')->nullable()->default(0);
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
        Schema::dropIfExists('wallet_settings');
    }
}
