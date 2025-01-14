<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomesettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('homesettings')){
        Schema::create('homesettings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('fact_enable')->default(1);
            $table->boolean('discount_enable')->default(1);
            $table->boolean('purchase_enable')->default(1);
            $table->boolean('recentcourse_enable')->default(1);
            $table->boolean('featured_enable')->default(1);
            $table->boolean('bundle_enable')->default(1);
            $table->boolean('bestselling_enable')->default(1);
            $table->boolean('batch_enable')->default(1);
            $table->boolean('livemeetings_enable')->default(1);
            $table->boolean('blog_enable')->default(1);
            $table->boolean('became_enable')->default(1);
            $table->boolean('featuredcategories_enable')->default(1);
            $table->boolean('testimonial_enable')->default(1);
            $table->boolean('video_enable')->default(1);
            $table->boolean('instructor_enable')->default(1);
            


            
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
        Schema::dropIfExists('homesettings');
    }
}
