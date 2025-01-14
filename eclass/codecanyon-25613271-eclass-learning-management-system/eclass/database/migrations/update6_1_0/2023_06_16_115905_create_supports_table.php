<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('admin_supports')){
        Schema::create('admin_supports', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->text('category')->nullable();
            $table->text('priority')->nullable();
            $table->text('subject')->nullable();
            $table->text('message')->nullable();
            $table->text('ticket_id')->nullable();
            $table->boolean('status')->default(0);
            $table->string('image')->nullable();
            $table->string('reply')->nullable();
            $table->string('reply_to')->nullable();
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
        Schema::dropIfExists('admin_supports');
    }
};
