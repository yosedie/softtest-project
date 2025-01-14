<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('batch')){
            Schema::create('batch', function (Blueprint $table) {
                $table->id();
                $table->string('user_id');
                $table->string('title')->nullable();
                $table->longtext('detail')->nullable();
                $table->double('price')->nullable();
                $table->boolean('type')->default(0);
                $table->string('slug')->nullable();
                $table->boolean('status')->default(0);
                $table->boolean('featured')->default(1);
                $table->string('preview_image')->nullable();
                $table->longtext('allowed_users')->nullable();
                $table->longtext('allowed_courses')->nullable();
                $table->longtext('allowed_bundles')->nullable();
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
        Schema::dropIfExists('batch');
    }
}
