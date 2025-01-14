<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('careers')){
            Schema::create('careers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('one_enable');
            $table->string('one_heading')->nullable();
            $table->text('one_text')->nullable();
            $table->string('one_btntxt')->nullable();
            $table->string('one_video')->nullable();
            $table->integer('two_enable');
            $table->integer('three_enable');
            $table->string('three_bg_image')->nullable();
            $table->string('three_video')->nullable();
            $table->string('three_heading')->nullable();
            $table->string('three_btntxt')->nullable();
            $table->integer('four_enable');
            $table->string('four_img_one')->nullable();
            $table->string('four_img_two')->nullable();
            $table->string('four_img_three')->nullable();
            $table->string('four_img_four')->nullable();
            $table->string('four_img_five')->nullable();
            $table->string('four_img_six')->nullable();
            $table->string('four_img_seven')->nullable();
            $table->string('four_img_eight')->nullable();
            $table->string('four_img_nine')->nullable();
            $table->integer('five_enable');
            $table->string('five_heading')->nullable();
            $table->text('five_text')->nullable();
            $table->string('five_icon')->nullable();
            $table->string('five_detail')->nullable();
            $table->string('five_textone')->nullable();
            $table->string('five_texttwo')->nullable();
            $table->string('five_textthree')->nullable();
            $table->string('five_textfour')->nullable();
            $table->string('five_textfive')->nullable();
            $table->string('five_textsix')->nullable();
            $table->string('five_textseven')->nullable();
            $table->string('five_texteight')->nullable();
            $table->string('five_textnine')->nullable();
            $table->string('five_textten')->nullable();
            $table->text('five_dtlone')->nullable();
            $table->text('five_dtltwo')->nullable();
            $table->text('five_dtlthree')->nullable();
            $table->text('five_dtlfour')->nullable();
            $table->text('five_dtlfive')->nullable();
            $table->text('five_dtlsix')->nullable();
            $table->text('five_dtlseven')->nullable();
            $table->text('five_dtleight')->nullable();
            $table->text('five_dtlnine')->nullable();
            $table->text('five_dtlten')->nullable();
            $table->integer('six_enable');
            $table->string('six_heading')->nullable();
            $table->string('six_text')->nullable();
            $table->string('six_topic_one')->nullable();
            $table->string('six_topic_two')->nullable();
            $table->string('six_topic_three')->nullable();
            $table->string('six_topic_four')->nullable();
            $table->string('six_topic_five')->nullable();
            $table->string('six_topic_six')->nullable();
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
        Schema::dropIfExists('careers');
    }
}
