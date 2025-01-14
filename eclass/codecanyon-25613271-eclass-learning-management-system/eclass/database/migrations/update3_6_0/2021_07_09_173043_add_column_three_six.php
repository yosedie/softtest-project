<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnThreeSix extends Migration
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
                if (!Schema::hasColumn('users', 'vacation_start'))
                {
                    $table->date('vacation_start')->nullable();
                }

                if (!Schema::hasColumn('users', 'vacation_end'))
                {
                    $table->date('vacation_end')->nullable();
                }

            });
        }

        if(Schema::hasTable('attandance') ) {
            Schema::table('attandance', function (Blueprint $table) {

                if (!Schema::hasColumn('attandance', 'zoom_id'))
                {
                    $table->integer('zoom_id')->nullable();
                }

                if (!Schema::hasColumn('attandance', 'bbl_id'))
                {
                    $table->integer('bbl_id')->nullable();
                }

                if (!Schema::hasColumn('attandance', 'googlemeet_id'))
                {
                    $table->integer('googlemeet_id')->nullable();
                }

                if (!Schema::hasColumn('attandance', 'jitsi_id'))
                {
                    $table->integer('jitsi_id')->nullable();
                }

                if (Schema::hasColumn('attandance', 'course_id'))
                {
                    $table->string('course_id')->nullable()->change();
                }

                if (Schema::hasColumn('attandance', 'order_id'))
                {
                    $table->string('order_id')->nullable()->change();
                }

            });
        }

        if(Schema::hasTable('carts') ) {
            Schema::table('carts', function (Blueprint $table) {
                if (Schema::hasColumn('carts', 'price'))
                {
                    $table->string('price')->change();
                }

                if (Schema::hasColumn('carts', 'offer_price'))
                {
                    $table->string('offer_price')->change();
                }

                if (Schema::hasColumn('carts', 'disamount'))
                {
                    $table->string('disamount')->change();
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
