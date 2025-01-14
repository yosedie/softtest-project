<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('features')){
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 191)->nullable();
            $table->string('detail', 191)->nullable();
            $table->string('image', 191)->nullable();
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
        Schema::dropIfExists('features');
    }
}
