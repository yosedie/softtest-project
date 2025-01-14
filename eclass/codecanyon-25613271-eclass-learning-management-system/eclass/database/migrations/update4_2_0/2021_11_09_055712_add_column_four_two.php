<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFourTwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('player_settings') ) {
            Schema::table('player_settings', function (Blueprint $table) {
                if (!Schema::hasColumn('player_settings', 'subtitle_font_size'))
                {
                    $table->integer('subtitle_font_size')->nullable();
                }
            });
        }

        if(Schema::hasTable('player_settings') ) {
            Schema::table('player_settings', function (Blueprint $table) {
                if (!Schema::hasColumn('player_settings', 'subtitle_color'))
                {
                    $table->string('subtitle_color')->nullable();
                }
            });
        }

        if(Schema::hasTable('courses') ) {
            Schema::table('courses', function (Blueprint $table) {
                if (!Schema::hasColumn('courses', 'country'))
                {
                    $table->longText('country')->nullable();
                }
            });
        }

         if(Schema::hasTable('testimonials') ) {
            Schema::table('testimonials', function (Blueprint $table) {
                if (!Schema::hasColumn('testimonials', 'rating'))
                {
                    $table->string('rating')->nullable();
                }
            });
        }
        if(Schema::hasTable('testimonials') ) {
            Schema::table('testimonials', function (Blueprint $table) {
                if (!Schema::hasColumn('testimonials', 'designation'))
                {
                    $table->longText('designation')->nullable();
                }
            });
        }

        if(Schema::hasTable('invoice_design') ) {
            Schema::table('invoice_design', function (Blueprint $table) {
                if (!Schema::hasColumn('invoice_design', 'signature'))
                {
                    $table->longText('signature')->nullable();
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
