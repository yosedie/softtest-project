<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('contacts')){
            Schema::create('contacts', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->string('fname');
                $table->string('lname');
                $table->string('email');
                $table->string('mobile');
                $table->longText('message');
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
        Schema::dropIfExists('contacts');
    }
}
