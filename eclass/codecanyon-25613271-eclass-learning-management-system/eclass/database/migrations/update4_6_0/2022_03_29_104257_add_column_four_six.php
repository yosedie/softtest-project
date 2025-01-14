<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFourSix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('currencies') ) {
            Schema::table('currencies', function (Blueprint $table) {
                if (!Schema::hasColumn('currencies', 'position'))
                {
                    $table->string('position')->default('r');
             
                }
            });
        }
        if(Schema::hasTable('watch_courses') ) {
            Schema::table('watch_courses', function (Blueprint $table) {
                if (!Schema::hasColumn('watch_courses', 'count'))
                {
                    $table->string('count')->nullable();

                }
            });
        }
        if(Schema::hasTable('settings') ) {
            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'watch_enable'))
                {
                    $table->boolean('watch_enable')->default(0);
                }
                if (!Schema::hasColumn('settings', 'watch_time'))
                {
                    $table->string('watch_time')->nullable();

                }
                if (!Schema::hasColumn('settings', 'sidebar_enable'))
                {
                    $table->boolean('sidebar_enable')->default(1);

                }
                if (!Schema::hasColumn('settings', 'instructor_sidebar'))
                {
                    $table->boolean('instructor_sidebar')->default(1);

                }
            });
        }
        if(Schema::hasTable('contacts') ) {
            Schema::table('contacts', function (Blueprint $table) {
                if (!Schema::hasColumn('contacts', 'reason'))
                {
                    $table->string('contacts')->nullable();
             
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
