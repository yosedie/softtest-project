<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('instructor_settings')){
            Schema::create('instructor_settings', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->boolean('instructor_enable')->default(1);
                $table->integer('instructor_revenue')->default(10);
                $table->integer('admin_revenue')->nullable();
                $table->boolean('paypal_enable')->default(1);
                $table->boolean('paytm_enable')->default(1);
                $table->boolean('bank_enable')->default(1);
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
        Schema::dropIfExists('instructor_settings');
    }
}
