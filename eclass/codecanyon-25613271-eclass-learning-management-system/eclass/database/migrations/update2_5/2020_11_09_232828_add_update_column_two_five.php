<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdateColumnTwoFive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('abouts') ) {
            Schema::table('abouts', function (Blueprint $table) {
                if (!Schema::hasColumn('abouts', 'linkedin'))
                {
                    $table->string('linkedin')->nullable();
                }
            });

            Schema::table('abouts', function (Blueprint $table) {
                if (!Schema::hasColumn('abouts', 'twitter'))
                {
                    $table->string('twitter')->nullable();
                }
            });

            Schema::table('abouts', function (Blueprint $table) {
                if (Schema::hasColumn('abouts', 'text_one'))
                {
                    $table->longText('text_one')->change();
                }
                if (Schema::hasColumn('abouts', 'text_two'))
                {
                    $table->longText('text_two')->change();
                }
                if (Schema::hasColumn('abouts', 'text_three'))
                {
                    $table->longText('text_three')->change();
                }
            });
        }

        if(Schema::hasTable('settings')) {
            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'app_download'))
                {
                    $table->boolean('app_download')->default(0);
                }
                if (!Schema::hasColumn('settings', 'app_link'))
                {
                    $table->string('app_link')->nullable();
                }
                if (!Schema::hasColumn('settings', 'play_download'))
                {
                    $table->boolean('play_download')->default(0);
                }
                if (!Schema::hasColumn('settings', 'play_link'))
                {
                    $table->string('play_link')->nullable();
                }
                if (!Schema::hasColumn('settings', 'iyzico_enable'))
                {
                    $table->boolean('iyzico_enable')->default(0);
                }
                if (!Schema::hasColumn('settings', 'course_hover'))
                {
                    $table->boolean('course_hover')->default(1);
                }
            });
        }

        if(Schema::hasTable('orders') ) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'refunded'))
                {
                    $table->boolean('refunded')->default(0);
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
