<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('sub_categories')){
            Schema::create('sub_categories', function (Blueprint $table) {
                $table->increments('id');
                $table->string('category_id');
                $table->string('title')->nullable();
                $table->string('icon')->nullable();
                $table->string('slug')->nullable();
                $table->enum('status',['1','0']);
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
        Schema::dropIfExists('sub_categories');
    }
}
