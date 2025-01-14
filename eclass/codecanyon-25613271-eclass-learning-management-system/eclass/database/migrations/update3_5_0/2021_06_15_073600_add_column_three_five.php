<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnThreeFive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if(Schema::hasTable('settings') ) {
            Schema::table('settings', function (Blueprint $table) {
                if (!Schema::hasColumn('settings', 'donation_enable'))
                {
                    $table->boolean('donation_enable')->default(0);
                }

                if (!Schema::hasColumn('settings', 'donation_link'))
                {
                    $table->string('donation_link')->nullable();
                }

            });
        }

        if(Schema::hasTable('instructor_plan') ) {
            Schema::table('instructor_plan', function (Blueprint $table) {
                if (!Schema::hasColumn('instructor_plan', 'preview_image'))
                {
                    $table->string('preview_image')->nullable();
                }
            });
        }

        if(Schema::hasTable('blogs') ) {
            Schema::table('blogs', function (Blueprint $table) {
                if (!Schema::hasColumn('blogs', 'slug'))
                {
                    $table->string('slug')->nullable();
                }
            });
        }

        if(Schema::hasTable('courses') ) {
            Schema::table('courses', function (Blueprint $table) {
                if (!Schema::hasColumn('courses', 'drip_enable'))
                {
                    $table->boolean('drip_enable')->default(0);
                }
            });
        }

        if(Schema::hasTable('course_chapters') ) {
            Schema::table('course_chapters', function (Blueprint $table) {
                if (!Schema::hasColumn('course_chapters', 'drip_type'))
                {
                    $table->string('drip_type')->nullable();
                }

                if (!Schema::hasColumn('course_chapters', 'drip_date'))
                {
                    $table->date('drip_date')->nullable();
                }

                if (!Schema::hasColumn('course_chapters', 'drip_days'))
                {
                    $table->string('drip_days')->nullable();
                }
            });
        }


        if(Schema::hasTable('course_classes') ) {
            Schema::table('course_classes', function (Blueprint $table) {
                if (!Schema::hasColumn('course_classes', 'drip_type'))
                {
                    $table->string('drip_type')->nullable();
                }

                if (!Schema::hasColumn('course_classes', 'drip_date'))
                {
                    $table->date('drip_date')->nullable();
                }

                if (!Schema::hasColumn('course_classes', 'drip_days'))
                {
                    $table->integer('drip_days')->nullable();
                }
            });
        }



        if(Schema::hasTable('widget_settings') ) {
            Schema::table('widget_settings', function (Blueprint $table) {
                if (!Schema::hasColumn('widget_settings', 'widget_enable'))
                {
                    $table->boolean('widget_enable')->default(1);
                }

                if (!Schema::hasColumn('widget_settings', 'about_enable'))
                {
                    $table->boolean('about_enable')->default(1);
                }

                if (!Schema::hasColumn('widget_settings', 'contact_enable'))
                {
                    $table->boolean('contact_enable')->default(1);
                }

                if (!Schema::hasColumn('widget_settings', 'career_enable'))
                {
                    $table->boolean('career_enable')->default(1);
                }

                if (!Schema::hasColumn('widget_settings', 'blog_enable'))
                {
                    $table->boolean('blog_enable')->default(1);
                }

                if (!Schema::hasColumn('widget_settings', 'help_enable'))
                {
                    $table->boolean('help_enable')->default(1);
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
