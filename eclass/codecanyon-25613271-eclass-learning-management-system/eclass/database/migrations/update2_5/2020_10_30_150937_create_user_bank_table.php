<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('user_bank')){
            Schema::create('user_bank', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id');
                $table->string('bank_name', 191);
                $table->string('ifcs_code', 191)->nullable();
                $table->string('account_number', 191);
                $table->string('account_holder_name', 191);
                $table->string('swift_code', 191)->nullable();
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
        Schema::dropIfExists('user_bank');
    }
}
