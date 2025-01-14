<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFourFour extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('institute') ) {
            Schema::table('institute', function (Blueprint $table) {
                if (!Schema::hasColumn('institute', 'email'))
                {
                    $table->string('email')->nullable();
             
                }
                if (!Schema::hasColumn('institute', 'mobile'))
                {
                    $table->string('mobile')->nullable();

                }
                if (!Schema::hasColumn('institute', 'affilated_by'))
                {
                    
                    $table->string('affilated_by')->nullable();

                }
                if (!Schema::hasColumn('institute', 'address'))
                {
                    $table->string('address')->nullable();

                }
            });
        }
      
    
        if(Schema::hasTable('settings') ) {
            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'text'))
                {
                    $table->string('text')->nullable();
                 

                }
                if (!Schema::hasColumn('settings', 'category_enable'))
                {
                   
				$table->boolean('category_enable')->nullable()->default(0);

                }
                if (!Schema::hasColumn('settings', 'img'))
                {
                    $table->string('img')->nullable();

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
        //
    }
}
