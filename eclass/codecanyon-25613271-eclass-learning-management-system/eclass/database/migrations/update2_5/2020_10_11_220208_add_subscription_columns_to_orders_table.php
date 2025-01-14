<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriptionColumnsToOrdersTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'price_id'))
            {
                $table->string('price_id', 50)->nullable();
            }
            if (!Schema::hasColumn('orders', 'subscription_id'))
            {
                $table->string('subscription_id', 50)->nullable();
            }

            if (!Schema::hasColumn('orders', 'customer_id'))
            {
                $table->string('customer_id', 50)->nullable();
            }

            if (!Schema::hasColumn('orders', 'subscription_status'))
            {
                $table->string('subscription_status', 50)->nullable();
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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('price_id');
            $table->dropColumn('subscription_id');
            $table->dropColumn('customer_id');
            $table->dropColumn('subscription_status');
        });
    }
}
