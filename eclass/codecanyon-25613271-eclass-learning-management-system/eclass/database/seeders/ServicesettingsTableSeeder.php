<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ServicesettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('servicesettings')->delete();
        
        \DB::table('servicesettings')->insert(array (
            0 => 
            array (
                'id' => '1',
                'created_at' => '2022-10-05 11:21:14',
                'updated_at' => '2022-10-07 07:02:24',
                'title' => 'Our Services',
                'detail' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut in purus ornare, cursus justo a, aliquam dolor. Quisque ullamcorper purus turpis, ac consequat enim rhoncus at. Aliquam pharetra ve',
                'image' => '1665126144bg1.jpg',
            ),
        ));
        
        
    }
}