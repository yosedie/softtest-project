<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFourNine extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('homesettings') ) {
            Schema::table('homesettings', function (Blueprint $table) {
                if (!Schema::hasColumn('homesettings', 'trusted_enable'))
                {
                    $table->string('trusted_enable')->nullable();
             
                }
            });
        }
        if(Schema::hasTable('homesettings') ) {
            Schema::table('homesettings', function (Blueprint $table) {
                if (!Schema::hasColumn('homesettings', 'newsletter_enable'))
                {
                    $table->string('newsletter_enable')->nullable();
             
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
