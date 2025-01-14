<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('adsenses')){
            Schema::create('adsenses', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->longtext('code');
                $table->boolean('status')->default(0);
                $table->boolean('ishome')->default(0);
                $table->boolean('iscart')->default(0);
                $table->boolean('isdetail')->default(0);
                $table->boolean('iswishlist')->default(0);
                $table->boolean('isviewall')->default(0);
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
        Schema::dropIfExists('adsenses');
    }
}
