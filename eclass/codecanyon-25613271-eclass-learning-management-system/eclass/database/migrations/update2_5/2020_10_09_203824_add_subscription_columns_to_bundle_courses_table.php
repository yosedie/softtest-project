<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriptionColumnsToBundleCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bundle_courses', function (Blueprint $table) {
            if (!Schema::hasColumn('bundle_courses', 'billing_interval'))
            {
                $table->enum('billing_interval', ['day', 'week', 'month', 'year'])->nullable();
            }

            if (!Schema::hasColumn('bundle_courses', 'price_id'))
            {
                $table->string('price_id', 50)->nullable();
            }

            if (!Schema::hasColumn('bundle_courses', 'product_id'))
            {
                $table->string('product_id', 50)->nullable();
            }

            if (!Schema::hasColumn('bundle_courses', 'subscription_mode'))
            {
                $table->string('subscription_mode', 50)->nullable()->default('stripe');
            }
            
            if (!Schema::hasColumn('bundle_courses', 'is_subscription_enabled'))
            {
                $table->boolean('is_subscription_enabled')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bundle_courses', function (Blueprint $table) {
            $table->dropColumn('billing_interval');
            $table->dropColumn('price_id');
            $table->dropColumn('product_id');
            $table->dropColumn('subscription_mode');
            $table->dropColumn('is_subscription_enabled');
        });
    }
}
