<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SlidersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sliders')->delete();
        
        \DB::table('sliders')->insert(array (
            0 => 
            array (
                'id' => 1,
                'heading' => '{"en":"Online Courses"}',
                'sub_heading' => '{"en":"Explore a variety of fresh topics"}',
                'search_text' => '{"en":"0"}',
                'detail' => '{"en":"Search Online.. Explore Online"}',
                'status' => '1',
                'image' => '15974361563617493.jpg',
                'position' => 4,
                'created_at' => '2020-01-22 15:54:01',
                'updated_at' => '2020-08-15 01:45:56',
                'left' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'heading' => '{"en":"Learn Smart Online"}',
                'sub_heading' => '{"en":"Become a better researcher"}',
                'search_text' => '{"en":"0"}',
                'detail' => '{"en":"online classes"}',
                'status' => '1',
                'image' => '15974360873025.jpg',
                'position' => 2,
                'created_at' => '2020-02-04 11:32:16',
                'updated_at' => '2020-08-15 01:44:48',
                'left' => NULL,
            ),
            2 => 
            array (
                'id' => 4,
                'heading' => '{"en":"Learn Anytime"}',
                'sub_heading' => '{"en":"Learn Wherever, Whenever, However..."}',
                'search_text' => '{"en":"0"}',
                'detail' => '{"en":"Online classes"}',
                'status' => '1',
                'image' => '15974359982976.jpg',
                'position' => 1,
                'created_at' => '2020-02-10 12:36:14',
                'updated_at' => '2020-08-15 01:43:20',
                'left' => NULL,
            ),
        ));
        
        
    }
}