<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComingSoonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('coming_soons')){
            Schema::create('coming_soons', function (Blueprint $table) {
                $table->increments('id');
                $table->string('bg_image');
                $table->string('heading');
                $table->string('count_one');
                $table->string('count_two');
                $table->string('count_three');
                $table->string('count_four');
                $table->string('text_one');
                $table->string('text_two');
                $table->string('text_three');
                $table->string('text_four');
                $table->string('btn_text');
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
        Schema::dropIfExists('coming_soons');
    }
}
