<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWatchCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('watch_courses')){
            Schema::create('watch_courses', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('user_id');
                $table->string('course_id');
                $table->dateTime('start_time')->nullable();
                $table->boolean('active')->default(0);
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
        Schema::dropIfExists('watch_courses');
    }
}
