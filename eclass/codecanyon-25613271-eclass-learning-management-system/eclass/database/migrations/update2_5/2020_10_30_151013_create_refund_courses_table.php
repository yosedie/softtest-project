<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('refund_courses')){
            Schema::create('refund_courses', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id')->unsigned();
                $table->integer('order_id')->unsigned();
                $table->integer('course_id')->unsigned();
                $table->integer('instructor_id')->unsigned();
                $table->string('ref_id')->nullable();
                $table->string('refund_transaction_id', 191)->nullable();
                $table->string('txn_fee')->nullable();
                $table->string('payment_method', 100);
                $table->float('total_amount', 10, 0)->unsigned();
                $table->text('reason')->nullable();
                $table->text('detail')->nullable();
                $table->integer('bank_id')->unsigned()->nullable();
                $table->string('currency', 191)->nullable();
                $table->string('currency_icon', 191)->nullable();
                $table->boolean('status')->default(0);
                $table->boolean('approved')->default(0);
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
        Schema::dropIfExists('refund_courses');
    }
}
