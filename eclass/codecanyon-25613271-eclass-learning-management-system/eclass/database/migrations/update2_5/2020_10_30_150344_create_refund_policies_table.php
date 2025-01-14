<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('refund_policies')){
            Schema::create('refund_policies', function (Blueprint $table) {
                $table->id();
                $table->string('name', 191)->nullable();
                $table->string('amount', 191)->nullable();
                $table->string('days', 191)->nullable();
                $table->text('detail', 65535)->nullable();
                $table->boolean('status')->default(1);
                $table->timestamps();
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
        Schema::dropIfExists('refund_policies');
    }
}
