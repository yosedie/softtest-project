<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UpisTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('upis')->delete();
        
        \DB::table('upis')->insert(array (
            0 => 
            array (
                'id' => '1',
                'created_at' => '2022-10-07 17:16:12',
                'updated_at' => '2022-10-18 05:32:19',
                'name' => 'Mr.doe',
                'upiid' => 'doe@example.com',
                'status' => '1',
            ),
        ));
        
        
    }
}