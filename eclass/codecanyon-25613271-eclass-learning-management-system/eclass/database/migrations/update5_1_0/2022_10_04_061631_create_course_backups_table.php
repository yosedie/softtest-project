<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseBackupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_backups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('course_id', 191);
            $table->string('user_id', 191);
            $table->string('category_id', 191);
            $table->string('subcategory_id', 191);
            $table->string('childcategory_id', 191);
            $table->string('language_id', 191);
            $table->string('title', 191)->nullable();
            $table->text('short_detail', 65535)->nullable();
            $table->text('detail', 65535)->nullable();
            $table->text('requirement', 65535)->nullable();
            $table->string('price', 191)->nullable();
            $table->string('discount_price', 191)->nullable();
            $table->string('day', 191)->nullable();
            $table->string('video', 191)->nullable();
            $table->string('url', 191)->nullable();
            $table->enum('featured', array('1','0'))->nullable();
            $table->string('slug', 191)->nullable();
            $table->enum('status', array('1','0'))->nullable();
            $table->string('preview_image', 191)->nullable();
            $table->string('video_url', 191)->nullable();
            $table->string('preview_type', 191)->nullable();
            $table->enum('type', array('1','0'))->nullable();
            $table->integer('duration')->nullable();
            $table->string('duration_type', 191)->nullable();
            $table->integer('assignment_enable')->default(1);
            $table->integer('appointment_enable')->default(1);
            $table->integer('certificate_enable')->default(1);
            $table->text('course_tags')->nullable();
            $table->text('reject_txt')->nullable();
            $table->integer('drip_enable')->default(1);
            $table->integer('institude_id')->default(1);
            $table->integer('involvement_request')->default(1);
            $table->string('country', 191)->nullable();
            $table->string('other_cats', 191)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_backups');
    }
}