<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBundleIdColumnsToCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            if (!Schema::hasColumn('coupons', 'bundle_id'))
            {
                $table->string('bundle_id', 50)->nullable();
            }
            if (!Schema::hasColumn('coupons', 'stripe_coupon_id'))
            {
                $table->string('stripe_coupon_id', 50)->nullable();
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
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('bundle_id');
            $table->dropColumn('stripe_coupon_id');
        });
    }
}
