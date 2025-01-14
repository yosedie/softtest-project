<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FeaturesettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('featuresettings')->delete();
        
        \DB::table('featuresettings')->insert(array (
            0 => 
            array (
                'id' => '1',
                'created_at' => '2022-10-05 12:02:18',
                'updated_at' => '2022-10-07 07:03:14',
                'title' => 'Our Features',
                'detail' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut in purus ornare, cursus justo a, aliquam dolor. Quisque ullamcorper purus turpis, ac consequat enim rhoncus at. Aliquam pharetra ve',
                'image' => '16651261941664257978flashdeal_61e0fea0514cf.jpg',
            ),
        ));
        
        
    }
}