<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreviousPaperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('previous_paper')){
            Schema::create('previous_paper', function (Blueprint $table) {
                $table->id();
                $table->integer('course_id');
                $table->string('title')->nullable();
                $table->string('file')->nullable();
                $table->longtext('detail')->nullable();
                $table->boolean('status')->default(0);
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
        Schema::dropIfExists('previous_paper');
    }
}
