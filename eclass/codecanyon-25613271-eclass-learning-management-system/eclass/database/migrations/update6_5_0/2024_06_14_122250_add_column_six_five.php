<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSixFive extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix the table name with trailing space and ensure correct table names
        if (Schema::hasTable('player_settings')) {
            Schema::table('player_settings', function (Blueprint $table) {
                // Check if the column 'paid_meeting_toggle' does not exist
                if (!Schema::hasColumn('player_settings', 'skin')) {
                    // Add the column 'paid_meeting_toggle'
                    $table->string('skin')->nullable();
                }
                // Check if the column 'paid_meeting_price' does not exist
                if (!Schema::hasColumn('player_settings', 'loop_video')) {
                    // Add the column 'paid_meeting_price'
                    $table->boolean('loop_video')->default(0);
                }
                if (!Schema::hasColumn('player_settings', 'player_google_analytics_id')) {
                    // Add the column 'paid_meeting_price'
                    $table->boolean('player_google_analytics_id')->default(0);
                }
                if (!Schema::hasColumn('player_settings', 'chrome_cast')) {
                    // Add the column 'paid_meeting_price'
                    $table->boolean('chrome_cast')->default(0);
                }
            });
        }
    

        if (Schema::hasTable('settings')) {
            Schema::table('settings', function (Blueprint $table) {
                // Check if the column 'paid_meeting_toggle' does not exist
                if (!Schema::hasColumn('settings', 'instagram_url')) {
                    // Add the column 'paid_meeting_toggle'
                    $table->string('instagram_url')->nullable();
                }
                // Check if the column 'paid_meeting_price' does not exist
                if (!Schema::hasColumn('settings', 'facebook_url')) {
                    // Add the column 'paid_meeting_price'
                    $table->string('facebook_url')->nullable();
                }
                if (!Schema::hasColumn('settings', 'twitter_url')) {
                    // Add the column 'paid_meeting_price'
                    $table->string('twitter_url')->nullable();
                }
                if (!Schema::hasColumn('settings', 'youtube_url')) {
                    // Add the column 'paid_meeting_price'
                    $table->string('youtube_url')->nullable();
                }
                if (!Schema::hasColumn('settings', 'google_search_console')) {
                    // Add the column 'paid_meeting_price'
                    $table->string('google_search_console')->nullable();
                }
            });
        }
        if (Schema::hasTable('activity_log')) { 
            Schema::table('activity_log', function (Blueprint $table) {
                if (!Schema::hasColumn('activity_log', 'buuid')) {
                    // Add the column 'paid_meeting_toggle'
                    $table->string('batch_uuid')->nullable();
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
