<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFiveZero extends Migration
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
                if (!Schema::hasColumn('homesettings', 'discount_badget_enable'))
                {
                    $table->boolean('discount_badget_enable')->default(1);
                }
            });
        }
        if(Schema::hasTable('homesettings') ) {
            Schema::table('homesettings', function (Blueprint $table) {
                if (!Schema::hasColumn('homesettings', 'institute_enable'))
                {
                    $table->boolean('institute_enable')->default(1);
                }
            });
        }
        if(Schema::hasTable('homesettings') ) {
            Schema::table('homesettings', function (Blueprint $table) {
                if (!Schema::hasColumn('homesettings', 'get_enable'))
                {
                    $table->boolean('get_enable')->default(1);
                }
            });
        }
        if(Schema::hasTable('courses') ) {
            Schema::table('courses', function (Blueprint $table) {
                if (!Schema::hasColumn('courses', 'other_cats'))
                {
                    $table->string('other_cats', 191)->nullable();
                }
            });
        }
        if(Schema::hasTable('users') ) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'is_verify'))
                {
                    $table->boolean('is_verify')->default(1);
                }
            });
        }
        if(Schema::hasTable('users') ) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'is_blocked'))
                {
                    $table->boolean('is_blocked')->default(1);
                }
            });
        }
        if(Schema::hasTable('users') ) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'block_note'))
                {
                    $table->string('block_note', 191)->nullable();
                }
            });
        }
        if(Schema::hasTable('users') ) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'document_detail'))
                {
                    $table->string('document_detail', 191)->nullable();
                }
            });
        }
        if(Schema::hasTable('users') ) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'document_file'))
                {
                    $table->string('document_file', 191)->nullable();
                }
            });
        }
        if(Schema::hasTable('institute') ) {
            Schema::table('institute', function (Blueprint $table) {
                if (!Schema::hasColumn('institute', 'slug'))
                {
                    $table->string('slug', 191)->nullable();
                }
            });
        }
        if(Schema::hasTable('menus') ) {
            Schema::table('menus', function (Blueprint $table) {
                if (!Schema::hasColumn('menus', 'position_menu'))
                {
                    $table->string('position_menu', 191)->nullable();
                }
            });
        }
        if(Schema::hasTable('menus') ) {
            Schema::table('menus', function (Blueprint $table) {
                if (!Schema::hasColumn('menus', 'top'))
                {
                    $table->string('top', 191)->nullable();
                }
            });
        }
        if(Schema::hasTable('menus') ) {
            Schema::table('menus', function (Blueprint $table) {
                if (!Schema::hasColumn('menus', 'footer'))
                {
                    $table->string('footer', 191)->nullable();
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
