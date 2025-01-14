<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdateColumnTwoSix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('bundle_courses') ) {
            Schema::table('bundle_courses', function (Blueprint $table) {
                if (!Schema::hasColumn('bundle_courses', 'duration'))
                {
                    $table->integer('duration')->nullable();
                }
            });

            Schema::table('bundle_courses', function (Blueprint $table) {
                if (!Schema::hasColumn('bundle_courses', 'duration_type'))
                {
                    $table->string('duration_type')->default('m');
                }
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
        //
    }
}
