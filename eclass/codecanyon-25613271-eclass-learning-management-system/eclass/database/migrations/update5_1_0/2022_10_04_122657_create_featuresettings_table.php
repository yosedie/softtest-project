<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturesettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('featuresettings')){
        Schema::create('featuresettings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 191)->nullable();
            $table->string('detail', 191)->nullable();
            $table->string('image', 191)->nullable();
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
        Schema::dropIfExists('featuresettings');
    }
}
