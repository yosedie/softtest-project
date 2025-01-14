<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('advertisements')){
            Schema::create('advertisements', function (Blueprint $table) {
                $table->id();
                $table->string('image1')->nullable();
                $table->string('image2')->nullable();
                $table->string('link_by1')->nullable();
                $table->string('link_by2')->nullable();
                $table->integer('course_id1')->nullable();
                $table->integer('course_id2')->nullable();
                $table->text('url1')->nullable();
                $table->text('url2')->nullable();
                $table->string('type')->nullable();
                $table->boolean('status')->default(0);
                $table->string('position')->nullable();
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
        Schema::dropIfExists('advertisements');
    }
}
