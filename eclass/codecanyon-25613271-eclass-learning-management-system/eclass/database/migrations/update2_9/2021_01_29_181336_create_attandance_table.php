<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttandanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('attandance')){
            Schema::create('attandance', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id');
                $table->integer('course_id');
                $table->integer('instructor_id');
                $table->integer('order_id');
                $table->date('date')->nullable();
                $table->dateTime('end_date')->nullable();
                $table->boolean('status')->default(1);
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
        Schema::dropIfExists('attandance');
    }
}
