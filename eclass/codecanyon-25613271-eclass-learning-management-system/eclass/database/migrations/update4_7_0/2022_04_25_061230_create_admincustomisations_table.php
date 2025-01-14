<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmincustomisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('admincustomisations')){
            Schema::create('admincustomisations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('bg_grey_color')->nullable();
            $table->string('bg_white_color')->nullable();
            $table->string('text-grey-color')->nullable();
            $table->string('text_dark_color')->nullable();
            $table->string('text_white_color')->nullable();
            $table->string('text_blue_color')->nullable();
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
        Schema::dropIfExists('admincustomisations');
    }
}
