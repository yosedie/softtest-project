<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffiliateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('affiliate')){
            Schema::create('affiliate', function (Blueprint $table) {
                $table->id();
                $table->string('ref_length')->nullable();
                $table->string('point_per_referral')->nullable();
                $table->string('points_to_reffered')->nullable();
                $table->string('image')->nullable();
                $table->longtext('text')->nullable();
                $table->integer('status')->unsigned()->default(0);
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
        Schema::dropIfExists('affiliate');
    }
}
