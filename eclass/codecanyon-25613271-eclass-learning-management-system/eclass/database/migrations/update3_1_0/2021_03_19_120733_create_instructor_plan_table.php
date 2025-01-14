<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('instructor_plan')){
            Schema::create('instructor_plan', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->longtext('detail')->nullable();
                $table->string('price')->nullable();
                $table->string('discount_price')->nullable();
                $table->string('type')->nullable();
                $table->string('duration')->nullable();
                $table->string('duration_type')->nullable();
                $table->integer('courses_allowed')->nullable();
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
        Schema::dropIfExists('instructor_plan');
    }
}
