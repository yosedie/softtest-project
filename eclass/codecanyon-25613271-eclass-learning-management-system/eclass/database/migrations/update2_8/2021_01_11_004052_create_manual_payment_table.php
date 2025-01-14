<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManualPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('manual_payment')){
            Schema::create('manual_payment', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->string('detail')->nullable();
                $table->string('image')->nullable();
                $table->integer('status')->unsigned()->default(0);
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
        Schema::dropIfExists('manual_payment');
    }
}
