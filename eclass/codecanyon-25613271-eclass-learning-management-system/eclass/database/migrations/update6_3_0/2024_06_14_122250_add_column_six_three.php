<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSixThree extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix the table name with trailing space and ensure correct table names
        if (Schema::hasTable('meetings')) {
            Schema::table('meetings', function (Blueprint $table) {
                // Check if the column 'paid_meeting_toggle' does not exist
                if (!Schema::hasColumn('meetings', 'paid_meeting_toggle')) {
                    // Add the column 'paid_meeting_toggle'
                    $table->boolean('paid_meeting_toggle')->default(0);
                }
                // Check if the column 'paid_meeting_price' does not exist
                if (!Schema::hasColumn('meetings', 'paid_meeting_price')) {
                    // Add the column 'paid_meeting_price'
                    $table->string('paid_meeting_price')->nullable();
                }
            });
        }
    
        if (Schema::hasTable('bigbluemeetings')) {
            Schema::table('bigbluemeetings', function (Blueprint $table) {
                // Check if the column 'paid_meeting_toggle' does not exist
                if (!Schema::hasColumn('bigbluemeetings', 'paid_meeting_toggle')) {
                    // Add the column 'paid_meeting_toggle'
                    $table->boolean('paid_meeting_toggle')->default(0);
                }
                // Check if the column 'paid_meeting_price' does not exist
                if (!Schema::hasColumn('bigbluemeetings', 'paid_meeting_price')) {
                    // Add the column 'paid_meeting_price'
                    $table->string('paid_meeting_price')->nullable();
                }
            });
        }
    
        if (Schema::hasTable('jitsimeetings')) {
            Schema::table('jitsimeetings', function (Blueprint $table) {
                // Check if the column 'paid_meeting_toggle' does not exist
                if (!Schema::hasColumn('jitsimeetings', 'paid_meeting_toggle')) {
                    // Add the column 'paid_meeting_toggle'
                    $table->boolean('paid_meeting_toggle')->default(0);
                }
                // Check if the column 'paid_meeting_price' does not exist
                if (!Schema::hasColumn('jitsimeetings', 'paid_meeting_price')) {
                    // Add the column 'paid_meeting_price'
                    $table->string('paid_meeting_price')->nullable();
                }
            });
        }
    
        if (Schema::hasTable('googlemeets')) {
            Schema::table('googlemeets', function (Blueprint $table) {
                // Check if the column 'paid_meeting_toggle' does not exist
                if (!Schema::hasColumn('googlemeets', 'paid_meeting_toggle')) {
                    // Add the column 'paid_meeting_toggle'
                    $table->boolean('paid_meeting_toggle')->default(0);
                }
                // Check if the column 'paid_meeting_price' does not exist
                if (!Schema::hasColumn('googlemeets', 'paid_meeting_price')) {
                    // Add the column 'paid_meeting_price'
                    $table->string('paid_meeting_price')->nullable();
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
