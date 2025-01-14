<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CourseLanguagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('course_languages')->delete();
        
        \DB::table('course_languages')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '{"en":"English"}',
                'status' => '1',
                'created_at' => '2020-01-22 14:41:54',
                'updated_at' => '2020-01-22 14:41:54',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '{"en":"Hindi"}',
                'status' => '1',
                'created_at' => '2020-01-22 15:43:52',
                'updated_at' => '2020-01-22 15:43:52',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '{"en":"French"}',
                'status' => '1',
                'created_at' => '2020-01-22 15:44:02',
                'updated_at' => '2020-01-22 15:44:02',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => '{"en":"Spanish"}',
                'status' => '1',
                'created_at' => '2020-01-22 15:44:15',
                'updated_at' => '2020-01-22 15:44:15',
            ),
        ));
        
        
    }
}