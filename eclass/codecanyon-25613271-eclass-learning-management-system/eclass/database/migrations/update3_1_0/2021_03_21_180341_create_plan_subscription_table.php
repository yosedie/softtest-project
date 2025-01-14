<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('plan_subscription')){
            Schema::create('plan_subscription', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id')->nullable();
                $table->integer('plan_id')->nullable();
                $table->string('order_id')->nullable();
                $table->string('transaction_id')->nullable();
                $table->string('payment_method')->nullable();
                $table->string('total_amount')->nullable();
                $table->string('currency')->nullable();
                $table->string('currency_icon')->nullable();
                $table->string('duration')->nullable();
                $table->string('duration_type')->nullable();
                $table->date('enroll_start')->nullable();
                $table->date('enroll_expire')->nullable();
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
        Schema::dropIfExists('plan_subscription');
    }
}
