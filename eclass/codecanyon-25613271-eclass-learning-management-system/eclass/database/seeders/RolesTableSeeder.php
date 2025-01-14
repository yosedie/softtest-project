<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => '1',
                'name' => 'admin',
                'guard_name' => 'web',
                'created_at' => '2022-03-17 04:47:37',
                'updated_at' => '2022-03-17 04:47:37',
            ),
            1 => 
            array (
                'id' => '2',
                'name' => 'user',
                'guard_name' => 'web',
                'created_at' => '2022-03-17 04:48:16',
                'updated_at' => '2022-03-17 04:48:16',
            ),
            2 => 
            array (
                'id' => '3',
                'name' => 'instructor',
                'guard_name' => 'web',
                'created_at' => '2022-03-17 04:48:39',
                'updated_at' => '2022-03-17 04:48:39',
            ),
        ));
        
        
    }
}