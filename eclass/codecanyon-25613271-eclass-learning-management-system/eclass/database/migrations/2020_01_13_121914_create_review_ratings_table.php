<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('review_ratings')){
            Schema::create('review_ratings', function (Blueprint $table) {
                $table->increments('id');
                $table->string('course_id');
                $table->string('user_id');
                $table->integer('learn');
                $table->integer('price');
                $table->integer('value');
                $table->longtext('review');
                $table->boolean('status')->default(true);
                $table->boolean('approved')->default(true);
                $table->boolean('featured')->nullable();
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
        Schema::dropIfExists('review_ratings');
    }
}
