<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSixOne extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('settings')) {
            Schema::table('settings', function (Blueprint $table) {
                // Check if the column 'api_key' does not exist
                if (!Schema::hasColumn('settings', 'wasabi_enable')) {
                    // Add the column 'api_key'
                    $table->boolean('wasabi_enable')->default(1);
                }
                if (!Schema::hasColumn('settings', 'bunny_enable')) {
                    // Add the column 'api_enable'
                    $table->boolean('bunny_enable')->default(1);
                }
            });
        }
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                // Check if the column 'delete_request' does not exist
                if (!Schema::hasColumn('users', 'delete_request')) {
                    // Add the column 'delete_request'
                    $table->string('delete_request')->nullable();
                }
                if (!Schema::hasColumn('users', 'delete_reason')) {
                    // Add the column 'api_enable'
                    $table->string('delete_reason')->nullable();
                }
            });
        }
        if (Schema::hasTable('pages')) {
            Schema::table('pages', function (Blueprint $table) {
                // Check if the column 'delete_request' does not exist
                if (!Schema::hasColumn('pages', 'page_type')) {
                    // Add the column 'delete_request'
                    $table->string('page_type')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
