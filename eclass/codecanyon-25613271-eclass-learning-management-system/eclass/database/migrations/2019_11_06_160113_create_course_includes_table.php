<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseIncludesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('course_includes')){
            Schema::create('course_includes', function (Blueprint $table) {
                $table->increments('id');
                $table->string('course_id');
                $table->string('item')->nullable();
                $table->string('icon')->nullable();
                $table->text('detail')->nullable();
                $table->enum('status',['1','0']);
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
        Schema::dropIfExists('course_includes');
    }
}
