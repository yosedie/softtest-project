<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelatedCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('related_courses')){
            Schema::create('related_courses', function (Blueprint $table) {
                $table->increments('id');
                $table->string('course_id', 191)->nullable();
                $table->string('main_course_id', 191)->nullable();
                $table->string('user_id', 191)->nullable();
                $table->enum('status', array('1','0'))->nullable();
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
        Schema::dropIfExists('related_courses');
    }
}
