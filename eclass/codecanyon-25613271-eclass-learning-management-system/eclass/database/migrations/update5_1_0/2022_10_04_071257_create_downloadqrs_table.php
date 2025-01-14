<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadqrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('downloadqrs')){
        Schema::create('downloadqrs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('image', 191)->nullable();
            $table->string('image2', 191)->nullable();
            $table->string('demo_image', 191)->nullable();
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
        Schema::dropIfExists('downloadqrs');
    }
}
