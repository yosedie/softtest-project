<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAffiliateToUsersTable extends Migration
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
                if (!Schema::hasColumn('users', 'affiliate_id'))
                {
                    $table->string('affiliate_id')->nullable();
                }
            });
        }

        if(Schema::hasTable('users') ) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'referred_by'))
                {
                    $table->string('referred_by')->nullable();
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
