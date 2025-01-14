<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('wallet')){
            Schema::create('wallet', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id')->unsigned();
                $table->float('balance', 10, 0)->nullable()->default(0.00);
                $table->integer('status')->unsigned()->default(1);
                $table->index('user_id');
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
        Schema::dropIfExists('wallet');
    }
}
