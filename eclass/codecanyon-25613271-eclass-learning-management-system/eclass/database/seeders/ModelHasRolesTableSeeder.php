<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModelHasRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('model_has_roles')->delete();
        
        \DB::table('model_has_roles')->insert(array (
            0 => 
            array (
                'role_id' => '3',
                'model_type' => 'App\\User',
                'model_id' => '0',
            ),
            1 => 
            array (
                'role_id' => '4',
                'model_type' => 'App\\User',
                'model_id' => '0',
            ),
            2 => 
            array (
                'role_id' => '1',
                'model_type' => 'App\\User',
                'model_id' => '1',
            ),
            3 => 
            array (
                'role_id' => '3',
                'model_type' => 'App\\User',
                'model_id' => '2',
            ),
            4 => 
            array (
                'role_id' => '2',
                'model_type' => 'App\\User',
                'model_id' => '3',
            ),
            5 => 
            array (
                'role_id' => '2',
                'model_type' => 'App\\User',
                'model_id' => '4',
            ),
            6 => 
            array (
                'role_id' => '3',
                'model_type' => 'App\\User',
                'model_id' => '5',
            ),
            7 => 
            array (
                'role_id' => '2',
                'model_type' => 'App\\User',
                'model_id' => '6',
            ),
            8 => 
            array (
                'role_id' => '2',
                'model_type' => 'App\\User',
                'model_id' => '7',
            ),
            9 => 
            array (
                'role_id' => '4',
                'model_type' => 'App\\User',
                'model_id' => '8',
            ),
            10 => 
            array (
                'role_id' => '3',
                'model_type' => 'App\\User',
                'model_id' => '10',
            ),
            11 => 
            array (
                'role_id' => '5',
                'model_type' => 'App\\User',
                'model_id' => '10',
            ),
        ));
        
        
    }
}