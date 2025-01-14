<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstructorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('instructors')){
            Schema::create('instructors', function (Blueprint $table) {
                $table->increments('id');
                $table->string('user_id');
                $table->string('fname');
                $table->string('lname');
                $table->string('email')->unique();
                $table->string('mobile');
                $table->string('gender');
                $table->text('detail');
                $table->string('file');
                $table->string('image');
                $table->string('role')->default('instructor');
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
        Schema::dropIfExists('instructors');
    }
}
