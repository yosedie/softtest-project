<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CourseChaptersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('course_chapters')->delete();
        
        \DB::table('course_chapters')->insert(array (
            0 => 
            array (
                'id' => 15,
                'course_id' => '5',
                'chapter_name' => '{"en":"Introduction"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-22 16:41:18',
                'updated_at' => '2020-01-22 16:41:18',
                'user_id' => NULL,
            ),
            1 => 
            array (
                'id' => 16,
                'course_id' => '5',
                'chapter_name' => '{"en":"Lecture 2"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-22 16:41:34',
                'updated_at' => '2020-01-22 16:41:34',
                'user_id' => NULL,
            ),
            2 => 
            array (
                'id' => 17,
                'course_id' => '5',
                'chapter_name' => '{"en":"Lecture 3"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-22 16:42:07',
                'updated_at' => '2020-01-22 16:42:07',
                'user_id' => NULL,
            ),
            3 => 
            array (
                'id' => 18,
                'course_id' => '5',
                'chapter_name' => '{"en":"Lecture 4"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-22 16:42:17',
                'updated_at' => '2020-01-22 16:42:17',
                'user_id' => NULL,
            ),
            4 => 
            array (
                'id' => 19,
                'course_id' => '6',
                'chapter_name' => '{"en":"Camera Equipment"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-22 16:50:21',
                'updated_at' => '2020-01-22 16:50:21',
                'user_id' => NULL,
            ),
            5 => 
            array (
                'id' => 20,
                'course_id' => '6',
                'chapter_name' => '{"en":"Mastering Camera Settings"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-22 16:55:09',
                'updated_at' => '2020-01-22 16:55:09',
                'user_id' => NULL,
            ),
            6 => 
            array (
                'id' => 21,
                'course_id' => '6',
                'chapter_name' => '{"en":"Light"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-22 16:55:22',
                'updated_at' => '2020-01-22 16:55:22',
                'user_id' => NULL,
            ),
            7 => 
            array (
                'id' => 22,
                'course_id' => '6',
                'chapter_name' => '{"en":"Composition"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-22 16:55:38',
                'updated_at' => '2020-01-22 16:55:38',
                'user_id' => NULL,
            ),
            8 => 
            array (
                'id' => 23,
                'course_id' => '6',
                'chapter_name' => '{"en":"Creativity"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-22 16:55:50',
                'updated_at' => '2020-01-22 16:55:50',
                'user_id' => NULL,
            ),
            9 => 
            array (
                'id' => 33,
                'course_id' => '1',
                'chapter_name' => '{"en":"Introduction"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 21:09:34',
                'updated_at' => '2020-01-23 21:09:34',
                'user_id' => NULL,
            ),
            10 => 
            array (
                'id' => 34,
                'course_id' => '1',
                'chapter_name' => '{"en":"Tools"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 21:09:47',
                'updated_at' => '2020-01-23 21:09:47',
                'user_id' => NULL,
            ),
            11 => 
            array (
                'id' => 35,
                'course_id' => '1',
                'chapter_name' => '{"en":"WordPress Theme: Set Up"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 21:11:13',
                'updated_at' => '2020-01-23 21:11:13',
                'user_id' => NULL,
            ),
            12 => 
            array (
                'id' => 36,
                'course_id' => '1',
                'chapter_name' => '{"en":"Bootstrap Themplate"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 21:11:27',
                'updated_at' => '2020-01-23 21:11:27',
                'user_id' => NULL,
            ),
            13 => 
            array (
                'id' => 37,
                'course_id' => '10',
                'chapter_name' => '{"en":"Introduction"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 21:22:32',
                'updated_at' => '2020-01-23 21:22:32',
                'user_id' => NULL,
            ),
            14 => 
            array (
                'id' => 38,
                'course_id' => '10',
                'chapter_name' => '{"en":"Setting up Our Tools"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 21:23:10',
                'updated_at' => '2020-01-23 21:23:10',
                'user_id' => NULL,
            ),
            15 => 
            array (
                'id' => 39,
                'course_id' => '10',
                'chapter_name' => '{"en":"Javascript Language Basics"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 21:24:11',
                'updated_at' => '2020-01-23 21:24:11',
                'user_id' => NULL,
            ),
            16 => 
            array (
                'id' => 48,
                'course_id' => '10',
                'chapter_name' => '{"en":"Course Introduction"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 21:42:17',
                'updated_at' => '2020-01-23 21:42:17',
                'user_id' => NULL,
            ),
            17 => 
            array (
                'id' => 49,
                'course_id' => '12',
                'chapter_name' => '{"en":"Introduction"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 21:58:17',
                'updated_at' => '2020-01-23 21:58:17',
                'user_id' => NULL,
            ),
            18 => 
            array (
                'id' => 50,
                'course_id' => '12',
                'chapter_name' => '{"en":"Sql Theory"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 22:12:36',
                'updated_at' => '2020-01-23 22:12:36',
                'user_id' => NULL,
            ),
            19 => 
            array (
                'id' => 51,
                'course_id' => '12',
                'chapter_name' => '{"en":"Basic Terminology"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 22:13:12',
                'updated_at' => '2020-01-23 22:13:12',
                'user_id' => NULL,
            ),
            20 => 
            array (
                'id' => 56,
                'course_id' => '14',
                'chapter_name' => '{"en":"Introduction"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 22:19:13',
                'updated_at' => '2020-01-23 22:19:13',
                'user_id' => NULL,
            ),
            21 => 
            array (
                'id' => 57,
                'course_id' => '14',
                'chapter_name' => '{"en":"Introduction to \'Interface and Basics\'"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 22:19:28',
                'updated_at' => '2020-01-23 22:19:28',
                'user_id' => NULL,
            ),
            22 => 
            array (
                'id' => 58,
                'course_id' => '14',
                'chapter_name' => '{"en":"Editing Basics"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 22:20:06',
                'updated_at' => '2020-01-23 22:20:06',
                'user_id' => NULL,
            ),
            23 => 
            array (
                'id' => 65,
                'course_id' => '17',
                'chapter_name' => '{"en":"Introduction"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 22:42:57',
                'updated_at' => '2020-01-23 22:42:57',
                'user_id' => NULL,
            ),
            24 => 
            array (
                'id' => 66,
                'course_id' => '17',
                'chapter_name' => '{"en":"Understanding Colors"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 22:43:27',
                'updated_at' => '2020-01-23 22:43:27',
                'user_id' => NULL,
            ),
            25 => 
            array (
                'id' => 67,
                'course_id' => '17',
                'chapter_name' => '{"en":"Completing Painting"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 22:43:47',
                'updated_at' => '2020-01-23 22:43:47',
                'user_id' => NULL,
            ),
            26 => 
            array (
                'id' => 68,
                'course_id' => '18',
                'chapter_name' => '{"en":"Introduction"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 22:50:09',
                'updated_at' => '2020-01-23 22:50:09',
                'user_id' => NULL,
            ),
            27 => 
            array (
                'id' => 69,
                'course_id' => '18',
                'chapter_name' => '{"en":"How to cut your own hair"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 22:50:43',
                'updated_at' => '2020-01-23 22:50:43',
                'user_id' => NULL,
            ),
            28 => 
            array (
                'id' => 70,
                'course_id' => '18',
                'chapter_name' => '{"en":"How to curl hair"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 22:51:03',
                'updated_at' => '2020-01-23 22:51:03',
                'user_id' => NULL,
            ),
            29 => 
            array (
                'id' => 71,
                'course_id' => '18',
                'chapter_name' => '{"en":"How to dye Hair"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 22:51:19',
                'updated_at' => '2020-01-23 22:51:19',
                'user_id' => NULL,
            ),
            30 => 
            array (
                'id' => 74,
                'course_id' => '20',
                'chapter_name' => '{"en":"Introduction"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 23:05:39',
                'updated_at' => '2020-01-23 23:05:39',
                'user_id' => NULL,
            ),
            31 => 
            array (
                'id' => 75,
                'course_id' => '20',
                'chapter_name' => '{"en":"Travel Programs"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 23:05:55',
                'updated_at' => '2020-01-23 23:05:55',
                'user_id' => NULL,
            ),
            32 => 
            array (
                'id' => 76,
                'course_id' => '20',
                'chapter_name' => '{"en":"Travel Tips"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-01-23 23:06:08',
                'updated_at' => '2020-01-23 23:06:29',
                'user_id' => NULL,
            ),
            33 => 
            array (
                'id' => 77,
                'course_id' => '1',
                'chapter_name' => '{"en":"sdfgvb"}',
                'short_number' => NULL,
                'status' => '1',
                'file' => NULL,
                'created_at' => '2020-04-15 16:34:16',
                'updated_at' => '2020-04-15 16:34:16',
                'user_id' => NULL,
            ),
        ));
        
        
    }
}