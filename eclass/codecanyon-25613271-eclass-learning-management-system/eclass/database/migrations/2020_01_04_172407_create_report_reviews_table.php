<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('report_reviews')){
            Schema::create('report_reviews', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('course_id');
                $table->integer('user_id');
                $table->integer('review_id');
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
        Schema::dropIfExists('report_reviews');
    }
}
