<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstructorskillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('instructorskills')){
        Schema::create('instructorskills', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('instructor_id', 191)->nullable();
            $table->string('skills', 191)->nullable();

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
        Schema::dropIfExists('instructorskills');
    }
}
