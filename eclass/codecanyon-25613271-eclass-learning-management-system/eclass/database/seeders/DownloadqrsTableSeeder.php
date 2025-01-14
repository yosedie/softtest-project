<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DownloadqrsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('downloadqrs')->delete();
        
        \DB::table('downloadqrs')->insert(array (
            0 => 
            array (
                'id' => '1',
                'created_at' => '2022-10-04 14:52:07',
                'updated_at' => '2022-10-07 06:56:40',
                'image' => '16651258001664964395user_app.png',
                'image2' => '16651258001664964395instructor_app.png',
                'demo_image' => '1665125800qr_01.png',
            ),
        ));
        
        
    }
}