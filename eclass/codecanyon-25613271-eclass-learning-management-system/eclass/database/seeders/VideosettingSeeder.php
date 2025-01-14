<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VideosettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('videosettings')->delete();
        
        \DB::table('videosettings')->insert(array (
            0 => 
            array (
                'id' => '1',
                'url' => 'https://www.youtube.com/embed/2jhFM6xcw5s',
                'tittle' => 'Start learning anywhere, anytime...',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'image' => '1644474519video.jpg',

                
            ),
        ));
        
        
    }
}
