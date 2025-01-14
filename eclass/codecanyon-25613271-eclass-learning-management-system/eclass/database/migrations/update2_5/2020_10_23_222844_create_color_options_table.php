<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('color_options')){
            Schema::create('color_options', function (Blueprint $table) {
                $table->id();
                $table->string('blue_bg')->nullable();
                $table->string('red_bg')->nullable();
                $table->string('grey_bg')->nullable();
                $table->string('light_grey_bg')->nullable();
                $table->string('black_bg')->nullable();
                $table->string('white_bg')->nullable();
                $table->string('dark_red_bg')->nullable();
                $table->string('black_text')->nullable();
                $table->string('light_grey_text')->nullable();
                $table->string('dark_grey_text')->nullable();
                $table->string('red_text')->nullable();
                $table->string('blue_text')->nullable();
                $table->string('dark_blue_text')->nullable();
                $table->string('white_text')->nullable();
                $table->string('linear_bg_one')->nullable();
                $table->string('linear_bg_two')->nullable();
                $table->string('linear_reverse_bg_one')->nullable();
                $table->string('linear_reverse_bg_two')->nullable();
                $table->string('linear_about_bg_one')->nullable();
                $table->string('linear_about_bg_two')->nullable();
                $table->string('linear_about_bluebg_one')->nullable();
                $table->string('linear_about_bluebg_two')->nullable();
                $table->string('linear_career_bg_one')->nullable();
                $table->string('linear_career_bg_two')->nullable();
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
        Schema::dropIfExists('color_options');
    }
}
