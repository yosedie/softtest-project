<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAluminisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('aluminis')){
        Schema::create('aluminis', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('status')->default(0);
            $table->string('url', 191)->nullable();
            $table->string('user_id', 191)->nullable();
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
        Schema::dropIfExists('aluminis');
    }
}
