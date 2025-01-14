<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBigbluemeetingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('bigbluemeetings')){
			Schema::create('bigbluemeetings', function(Blueprint $table)
			{
				$table->bigInteger('id', true)->unsigned();
				$table->string('presen_name');
				$table->integer('instructor_id')->unsigned();
				$table->string('meetingid', 191);
				$table->text('detail')->nullable();
				$table->string('start_time', 200);
				$table->string('meetingname', 191);
				$table->string('modpw', 191);
				$table->string('attendeepw', 191);
				$table->string('welcomemsg', 191)->nullable();
				$table->string('duration', 191);
				$table->string('setMaxParticipants', 191)->default('-1');
				$table->string('setMuteOnStart', 191)->default('false');
				$table->boolean('allow_record');
				$table->integer('is_ended')->default(0);
				$table->integer('course_id')->nullable();
				$table->string('link_by')->nullable();
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
		Schema::drop('bigbluemeetings');
	}

}
