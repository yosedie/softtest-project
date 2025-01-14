<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDropdownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('dropdowns')){
        Schema::create('dropdowns', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('my_courses')->default(1);
            $table->boolean('my_wishlist')->default(1);
            $table->boolean('purchased_history')->default(1);
            $table->boolean('my_profile')->default(1);
            $table->boolean('flash_deal')->default(1);
            $table->boolean('donation')->default(1);
            $table->boolean('my_wallet')->default(1);
            $table->boolean('affilate')->default(1);
            $table->boolean('compare')->default(1);
            $table->boolean('search_job')->default(1);
            $table->boolean('job_portal')->default(1);
            $table->boolean('form_enable')->default(1);
            $table->boolean('my_leadership')->default(1);
            $table->boolean('affilate_dashboard')->default(1);
            $table->string('role_id', 191)->nullable();

            
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
        Schema::dropIfExists('dropdowns');
    }
}
