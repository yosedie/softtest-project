<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('question_reports')){
            Schema::create('question_reports', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('course_id');
                $table->integer('user_id');
                $table->integer('question_id');
                $table->string('title')->nullable();;
                $table->string('email')->nullable();;
                $table->longtext('detail')->nullable();;
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
        Schema::dropIfExists('question_reports');
    }
}
