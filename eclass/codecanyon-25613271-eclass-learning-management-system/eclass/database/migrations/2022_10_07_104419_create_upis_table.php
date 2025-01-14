<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('upis')){
        Schema::create('upis', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name', 191)->nullable();
            $table->string('upiid', 191)->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('upis');
    }
}
