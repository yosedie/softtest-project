<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MobileSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mobile_settings')->delete();
        
        \DB::table('mobile_settings')->insert(array (
            0 => 
            array (
                'id' => '1',
                'created_at' => '2022-09-21 15:27:53',
                'updated_at' => '2022-10-07 04:02:32',
                'setting_enable' => '0',
            ),
        ));
        
        
    }
}