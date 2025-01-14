<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if(Schema::hasTable('currencies') ) {
            Schema::table('currencies', function (Blueprint $table) {
                if (!Schema::hasColumn('currencies', 'name'))
                {
                    $table->string('name')->nullable();
                }

                if (!Schema::hasColumn('currencies', 'code'))
                {
                    $table->string('code', 10)->index();
                }

                if (!Schema::hasColumn('currencies', 'symbol'))
                {
                    $table->string('symbol', 25)->nullable();
                }

                if (!Schema::hasColumn('currencies', 'format'))
                {
                    $table->string('format', 10)->nullable();
                }

                if (!Schema::hasColumn('currencies', 'exchange_rate'))
                {
                    $table->string('exchange_rate')->nullable();
                }

                if (!Schema::hasColumn('currencies', 'active'))
                {
                    $table->boolean('active')->default(false);
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
        Schema::table('currencies', function (Blueprint $table) {
            //
        });
    }
}
