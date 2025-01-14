<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSixTwo extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('settings')) {
            Schema::table('settings', function (Blueprint $table) {
                // Check if the column 'api_key' does not exist
                if (!Schema::hasColumn('settings', 'otp_enable')) {
                    // Add the column 'api_key'
                    $table->boolean('otp_enable')->default(0);
                }
                if (!Schema::hasColumn('settings', 'screenshot_enable')) {
                    // Add the column 'api_key'
                    $table->boolean('screenshot_enable')->default(0);
                }
            });
        }
        if (Schema::hasTable('player_settings')) {
            Schema::table('player_settings', function (Blueprint $table) {
                // Check if the column 'api_key' does not exist
                if (!Schema::hasColumn('player_settings', 'embedded_enable')) {
                    // Add the column 'api_key'
                    $table->boolean('embedded_enable')->default(0);
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
