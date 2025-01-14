<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TrustedsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trusteds')->delete();
        
        \DB::table('trusteds')->insert(array (
            0 => 
            array (
                'id' => 1,
                'url' => 'https://mediacity.co.in/',
                'image' => 'trust_158114996587.jpg',
                'status' => '1',
                'created_at' => '2020-01-23 16:35:24',
                'updated_at' => '2020-02-08 13:49:25',
            ),
            1 => 
            array (
                'id' => 2,
                'url' => 'https://mediacity.co.in/',
                'image' => '157977781488.jpg',
                'status' => '1',
                'created_at' => '2020-01-23 16:40:14',
                'updated_at' => '2020-02-08 13:30:34',
            ),
            2 => 
            array (
                'id' => 3,
                'url' => 'https://mediacity.co.in/',
                'image' => '157977812389.jpg',
                'status' => '1',
                'created_at' => '2020-01-23 16:45:23',
                'updated_at' => '2020-02-08 13:30:40',
            ),
        ));
        
        
    }
}