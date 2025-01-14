<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SliderFactsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('slider_facts')->delete();
        
        \DB::table('slider_facts')->insert(array (
            0 => 
            array (
                'id' => 1,
                'icon' => 'fa-anchor',
                'heading' => '{"en":"Learn Anytime, Anywhere"}',
                'sub_heading' => '{"en":"Online Courses for Creative"}',
                'created_at' => '2020-01-23 16:13:39',
                'updated_at' => '2020-01-23 16:13:39',
            ),
            1 => 
            array (
                'id' => 2,
                'icon' => 'fa-magic',
                'heading' => '{"en":"Beacome a researcher"}',
                'sub_heading' => '{"en":"Improve Your Skills Online"}',
                'created_at' => '2020-01-23 16:15:14',
                'updated_at' => '2020-01-23 16:17:41',
            ),
            2 => 
            array (
                'id' => 3,
                'icon' => 'fa-graduation-cap',
                'heading' => '{"en":"Most Popular Courses"}',
                'sub_heading' => '{"en":"Learn on your schedule"}',
                'created_at' => '2020-01-23 16:16:59',
                'updated_at' => '2020-01-23 16:16:59',
            ),
        ));
        
        
    }
}