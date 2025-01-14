<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('course_reports')){
            Schema::create('course_reports', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('course_id');
                $table->integer('user_id');
                $table->string('title');
                $table->string('email');
                $table->longtext('detail');
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
        Schema::dropIfExists('course_reports');
    }
}
