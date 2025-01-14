<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWhatLearnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('what_learns')){
            Schema::create('what_learns', function (Blueprint $table) {
                $table->increments('id');
                $table->string('course_id')->nullable();
                $table->text('detail')->nullable();
                $table->enum('status',['1','0'])->nullable();
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
        Schema::dropIfExists('what_learns');
    }
}
