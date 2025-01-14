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
        if(Schema::hasTable('languages') ) {
            Schema::table('languages', function (Blueprint $table) {
                if (!Schema::hasColumn('languages', 'language'))
                {
                    $table->string('language')->nullable();
                }
            });
        }

        if(Schema::hasTable('orders') ) {
            Schema::table('orders', function (Blueprint $table) {
                if (Schema::hasColumn('orders', 'bundle_course_id'))
                {
                    $table->dropColumn('bundle_course_id');
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
};
