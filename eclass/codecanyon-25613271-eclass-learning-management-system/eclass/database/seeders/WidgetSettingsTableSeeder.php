<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WidgetSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('widget_settings')->delete();
        
        \DB::table('widget_settings')->insert(array (
            0 => 
            array (
                'id' => '1',
                'widget_one' => 'Widget One',
                'widget_two' => 'Widget Two',
                'widget_three' => 'Widget Three',
                'created_at' => now(),
                'updated_at' => now(),
                'widget_enable' => '1',
                'about_enable' => '1',
                'contact_enable' => '1',
                'career_enable' => '1',
                'blog_enable' => '1',
                'help_enable' => '1',
            ),
        ));
        
        
    }
}