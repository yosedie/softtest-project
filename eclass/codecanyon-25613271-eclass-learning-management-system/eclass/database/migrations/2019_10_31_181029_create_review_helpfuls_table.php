<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewHelpfulsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('review_helpfuls')){
            Schema::create('review_helpfuls', function (Blueprint $table) {
                $table->increments('id');
                $table->string('course_id');
                $table->string('user_id');
                $table->string('review_id');
                $table->string('helpful');
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
        Schema::dropIfExists('review_helpfuls');
    }
}
