<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdateColumnUpdateColumnTwoThree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('settings')) {
            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'enable_omise'))
                {
                    $table->integer('enable_omise')->default(0);
                }
                if (!Schema::hasColumn('settings', 'enable_payu'))
                {
                    $table->integer('enable_payu')->default(0);
                }
                if (!Schema::hasColumn('settings', 'enable_moli'))
                {
                    $table->integer('enable_moli')->default(0);
                }
                if (!Schema::hasColumn('settings', 'enable_cashfree'))
                {
                    $table->integer('enable_cashfree')->default(0);
                }
                if (!Schema::hasColumn('settings', 'enable_skrill'))
                {
                    $table->integer('enable_skrill')->default(0);
                }
                if (!Schema::hasColumn('settings', 'enable_rave'))
                {
                    $table->integer('enable_rave')->default(0);
                }
                if (!Schema::hasColumn('settings', 'preloader_logo'))
                {
                    $table->string('preloader_logo')->nullable();
                }
                if (!Schema::hasColumn('settings', 'chat_bubble'))
                {
                    $table->text('chat_bubble')->nullable();
                }
            });
        }

        if(Schema::hasTable('sliders')) {
            Schema::table('sliders', function (Blueprint $table) {
                if (!Schema::hasColumn('sliders', 'left'))
                {
                    $table->integer('left')->nullable();
                }
            });
        }

        if(Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                if (!Schema::hasColumn('categories', 'cat_image'))
                {
                    $table->string('cat_image')->nullable();
                }
            });
        }

        if(Schema::hasTable('get_starteds')) {
            Schema::table('get_starteds', function (Blueprint $table) {
                if (!Schema::hasColumn('get_starteds', 'link'))
                {
                    $table->text('link')->nullable();
                }
            });
        }

        if(Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'sale_id'))
                {
                    $table->string('sale_id')->nullable();
                }
            });
        }

        if(Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'code'))
                {
                    $table->string('code')->nullable();
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
