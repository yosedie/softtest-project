<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JoinInstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('join_instructors')->delete();
        
        \DB::table('join_instructors')->insert(array (
            0 => 
            array (
                'id' => '1',
                'img' => '1643950703instructor.jpg',
                'text' => 'Join us an Instructor',
                'detail' => 'Instructor',
                
            ),
        ));
        
        
    }
    
}
