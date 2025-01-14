<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AffiliateTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('affiliate')->delete();
        
        \DB::table('affiliate')->insert(array (
            0 => 
            array (
                'id' => '1',
                'ref_length' => '4',
                'point_per_referral' => '0.01',
                'points_to_reffered' => NULL,
                'image' => NULL,
                'text' => '<p>Testing</p>',
                'status' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ),
        ));
        
        
    }
}