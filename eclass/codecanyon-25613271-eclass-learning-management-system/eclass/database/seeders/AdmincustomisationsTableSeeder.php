<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdmincustomisationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('Admincustomisations')->delete();
        
        \DB::table('Admincustomisations')->insert(array (
            0 => 
            array (
                'id' => '1',
                'created_at' => '2022-04-29 06:29:40',
                'updated_at' => '2022-05-05 05:33:21',
                'bg_grey_color' => '#F2F3F7',
                'bg_white_color' => '#FFFFFF',
                'text-grey-color' => '#8A98AC',
                'text_dark_color' => '#141d46',
                'text_white_color' => '#FFFFFF',
                'text_blue_color' => '#506fe4',
            ),
        ));
        
        
    }
}