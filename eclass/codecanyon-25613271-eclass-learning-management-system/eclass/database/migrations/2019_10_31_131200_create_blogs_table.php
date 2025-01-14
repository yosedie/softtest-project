<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('blogs')){
            Schema::create('blogs', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->date('date');
                $table->string('image');
                $table->string('heading');
                $table->text('detail');
                $table->string('text');
                $table->boolean('approved');
                $table->boolean('status');
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
        Schema::dropIfExists('blogs');
    }
}
