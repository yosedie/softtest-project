<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJitsimeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('jitsimeetings')){
            Schema::create('jitsimeetings', function (Blueprint $table) {
                $table->id();
                $table->string('meeting_id', 191)->nullable();
                $table->string('owner_id', 191)->nullable();
    			$table->integer('user_id')->nullable();
    			$table->string('meeting_title')->nullable();
    			$table->dateTime('start_time')->nullable();
                $table->dateTime('end_time')->nullable();
                $table->string('duration')->nullable();
    			$table->string('jitsi_url')->nullable();
    			$table->string('link_by')->nullable();
    			$table->integer('course_id')->nullable();
                $table->string('time_zone')->nullable();
                $table->integer('type')->nullable();
                $table->longtext('agenda')->nullable();
                $table->string('image')->nullable();
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
        Schema::dropIfExists('jitsimeetings');
    }
}
