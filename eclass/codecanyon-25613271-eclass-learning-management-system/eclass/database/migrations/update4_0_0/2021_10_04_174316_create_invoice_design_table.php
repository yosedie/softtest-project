<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDesignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('invoice_design')){
            Schema::create('invoice_design', function (Blueprint $table) {
                $table->id();
                $table->boolean('logo_enable')->default(1);
                $table->string('print_type')->nullable();
                $table->boolean('border_enable')->default(1);
                $table->string('border_radius')->nullable();
                $table->string('border_color')->nullable();
                $table->string('border_style')->nullable();
                $table->string('date_format')->nullable();
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
        Schema::dropIfExists('invoice_design');
    }
}
