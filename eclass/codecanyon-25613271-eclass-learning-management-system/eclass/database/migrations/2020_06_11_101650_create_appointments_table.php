<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('appointments')){
            Schema::create('appointments', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('user_id');
                $table->integer('instructor_id')->nullable();
                $table->integer('course_id');
                $table->string('title')->nullable();
                $table->text('detail')->nullable();
                $table->dateTime('start_time')->nullable();
                $table->string('request')->nullable();
                $table->boolean('accept')->default(0);
                $table->string('files')->nullable();
                $table->text('reply')->nullable();
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
        Schema::dropIfExists('appointments');
    }
}
