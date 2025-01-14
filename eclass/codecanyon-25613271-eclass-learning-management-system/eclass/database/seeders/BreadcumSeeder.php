<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BreadcumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('breadcums')->delete();
        
        \DB::table('breadcums')->insert(array (
            0 => 
            array (
                'id' => '1',
                'img' => '1643952051bredcrumbs.jpg',
                'text' => 'Eclass-Learning Management',


                
            ),
        ));
        
        
    
    }
}
