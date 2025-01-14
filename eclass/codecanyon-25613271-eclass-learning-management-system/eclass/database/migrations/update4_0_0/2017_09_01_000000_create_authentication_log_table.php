<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthenticationLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('authentication_log')){
            Schema::create('authentication_log', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->morphs('authenticatable');
                $table->string('ip_address', 45)->nullable();
                $table->text('platform')->nullable();
                $table->text('browser')->nullable();
                $table->string('user_agent', 255)->nullable();
                $table->timestamp('login_at')->nullable();
                $table->timestamp('logout_at')->nullable();
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
        Schema::dropIfExists('auth_log');
    }
}
