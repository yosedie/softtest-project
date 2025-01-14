<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if(!Schema::hasTable('paid_mettings')){
        Schema::create('paid_mettings', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id'); 
            $table->string('meeting_id'); 
            $table->string('user_id'); 
            $table->string('course_id'); 
            $table->string('amount'); 
            $table->string('currency'); 
            $table->string('currency_symbol'); 
            $table->string('payment_method'); 
            $table->string('type'); 
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paid_mettings');
    }
};
