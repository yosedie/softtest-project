<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstituteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('institute')){
            Schema::create('institute', function (Blueprint $table) {
                $table->id();
                $table->string('title');
    			$table->string('detail');
    			$table->string('user_id');
    			$table->string('image');
    			$table->string('status')->default(1);
    			$table->string('verified')->default(0);
    			$table->string('skill');
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
        Schema::dropIfExists('institutes');
    }
}