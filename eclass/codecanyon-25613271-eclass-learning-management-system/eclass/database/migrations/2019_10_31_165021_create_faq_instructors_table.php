<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqInstructorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('faq_instructors')){

            Schema::create('faq_instructors', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('category_id');
                $table->string('title');
                $table->text('details');
                $table->boolean('status');
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
        Schema::dropIfExists('faq_instructors');
    }
}
