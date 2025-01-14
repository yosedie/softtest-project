<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnThreeTwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('users') ) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'google2fa_secret'))
                {
                    $table->text('google2fa_secret')->nullable();
                }
            });
        }

        if(Schema::hasTable('users') ) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'google2fa_enable'))
                {
                    $table->boolean('google2fa_enable')->default(0);
                }
            });
        }

        if(Schema::hasTable('sliders') ) {
            Schema::table('sliders', function (Blueprint $table) {
                if (!Schema::hasColumn('sliders', 'search_enable'))
                {
                    $table->boolean('search_enable')->default(0);
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
