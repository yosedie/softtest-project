<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CourseIncludesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('course_includes')->delete();
        
        \DB::table('course_includes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'course_id' => '1',
                'item' => NULL,
                'icon' => 'fa-american-sign-language-interpreting',
                'detail' => '{"en":"Anytime, Anywhere"}',
                'status' => '1',
                'created_at' => '2020-01-22 14:50:50',
                'updated_at' => '2020-01-23 00:26:25',
            ),
            1 => 
            array (
                'id' => 2,
                'course_id' => '1',
                'item' => NULL,
                'icon' => 'fa-adjust',
                'detail' => '{"en":"Downloadable resources"}',
                'status' => '1',
                'created_at' => '2020-01-22 15:01:30',
                'updated_at' => '2020-01-22 15:03:55',
            ),
            2 => 
            array (
                'id' => 3,
                'course_id' => '1',
                'item' => NULL,
                'icon' => 'fa-bandcamp',
                'detail' => '{"en":"Full lifetime access"}',
                'status' => '1',
                'created_at' => '2020-01-22 15:04:08',
                'updated_at' => '2020-01-22 15:04:08',
            ),
            3 => 
            array (
                'id' => 4,
                'course_id' => '1',
                'item' => NULL,
                'icon' => 'fa-check-square',
                'detail' => '{"en":"Access on mobile and TV"}',
                'status' => '1',
                'created_at' => '2020-01-22 15:04:34',
                'updated_at' => '2020-01-22 15:04:34',
            ),
            4 => 
            array (
                'id' => 19,
                'course_id' => '5',
                'item' => NULL,
                'icon' => 'fa-bullseye',
                'detail' => '{"en":"Full lifetime access"}',
                'status' => '1',
                'created_at' => '2020-01-22 16:30:16',
                'updated_at' => '2020-01-22 16:30:16',
            ),
            5 => 
            array (
                'id' => 20,
                'course_id' => '5',
                'item' => NULL,
                'icon' => 'fa-bandcamp',
                'detail' => '{"en":"Access on mobile and TV"}',
                'status' => '1',
                'created_at' => '2020-01-22 16:30:35',
                'updated_at' => '2020-01-22 16:30:35',
            ),
            6 => 
            array (
                'id' => 21,
                'course_id' => '5',
                'item' => NULL,
                'icon' => 'fa-clipboard',
                'detail' => '{"en":"On-demand video"}',
                'status' => '1',
                'created_at' => '2020-01-22 16:30:48',
                'updated_at' => '2020-01-22 16:31:05',
            ),
            7 => 
            array (
                'id' => 22,
                'course_id' => '6',
                'item' => NULL,
                'icon' => 'fa-video-camera',
                'detail' => '{"en":"2 hours on-demand video"}',
                'status' => '1',
                'created_at' => '2020-01-22 16:47:42',
                'updated_at' => '2020-01-22 16:47:42',
            ),
            8 => 
            array (
                'id' => 23,
                'course_id' => '6',
                'item' => NULL,
                'icon' => 'fa-paper-plane-o',
                'detail' => '{"en":"6 articles"}',
                'status' => '1',
                'created_at' => '2020-01-22 16:48:01',
                'updated_at' => '2020-01-22 16:48:01',
            ),
            9 => 
            array (
                'id' => 24,
                'course_id' => '6',
                'item' => NULL,
                'icon' => 'fa-download',
                'detail' => '{"en":"1 downloadable resource"}',
                'status' => '1',
                'created_at' => '2020-01-22 16:48:14',
                'updated_at' => '2020-01-22 16:48:14',
            ),
            10 => 
            array (
                'id' => 25,
                'course_id' => '6',
                'item' => NULL,
                'icon' => 'fa-mobile-phone',
                'detail' => '{"en":"Access on mobile and TV"}',
                'status' => '1',
                'created_at' => '2020-01-22 16:48:31',
                'updated_at' => '2020-01-22 16:48:31',
            ),
            11 => 
            array (
                'id' => 26,
                'course_id' => '6',
                'item' => NULL,
                'icon' => 'fa-certificate',
                'detail' => '{"en":"Certificate of Completion"}',
                'status' => '1',
                'created_at' => '2020-01-22 16:48:51',
                'updated_at' => '2020-01-22 16:48:51',
            ),
            12 => 
            array (
                'id' => 34,
                'course_id' => '5',
                'item' => NULL,
                'icon' => 'fa-bell-o',
                'detail' => '{"en":"downloadable resource"}',
                'status' => '1',
                'created_at' => '2020-01-23 00:31:45',
                'updated_at' => '2020-01-23 00:32:20',
            ),
            13 => 
            array (
                'id' => 39,
                'course_id' => '10',
                'item' => NULL,
                'icon' => 'fa-book',
                'detail' => '{"en":"Anytime, Anywhere"}',
                'status' => '1',
                'created_at' => '2020-01-23 21:39:43',
                'updated_at' => '2020-01-23 21:39:43',
            ),
            14 => 
            array (
                'id' => 40,
                'course_id' => '10',
                'item' => NULL,
                'icon' => 'fa-cubes',
                'detail' => '{"en":"Downloadable resources"}',
                'status' => '1',
                'created_at' => '2020-01-23 21:40:08',
                'updated_at' => '2020-01-23 21:40:08',
            ),
            15 => 
            array (
                'id' => 41,
                'course_id' => '10',
                'item' => NULL,
                'icon' => 'fa-check-circle-o',
                'detail' => '{"en":"Full lifetime access"}',
                'status' => '1',
                'created_at' => '2020-01-23 21:40:20',
                'updated_at' => '2020-01-23 21:40:20',
            ),
            16 => 
            array (
                'id' => 42,
                'course_id' => '10',
                'item' => NULL,
                'icon' => 'fa-dribbble',
                'detail' => '{"en":"Access on mobile and TV"}',
                'status' => '1',
                'created_at' => '2020-01-23 21:40:40',
                'updated_at' => '2020-01-23 21:40:40',
            ),
            17 => 
            array (
                'id' => 43,
                'course_id' => '12',
                'item' => NULL,
                'icon' => 'fa-bookmark',
                'detail' => '{"en":"Anytime, Anywhere"}',
                'status' => '1',
                'created_at' => '2020-01-23 21:48:15',
                'updated_at' => '2020-01-23 21:48:15',
            ),
            18 => 
            array (
                'id' => 44,
                'course_id' => '12',
                'item' => NULL,
                'icon' => 'fa-clipboard',
                'detail' => '{"en":"Full lifetime access"}',
                'status' => '1',
                'created_at' => '2020-01-23 21:48:29',
                'updated_at' => '2020-01-23 21:48:29',
            ),
            19 => 
            array (
                'id' => 45,
                'course_id' => '12',
                'item' => NULL,
                'icon' => 'fa-commenting-o',
                'detail' => '{"en":"Access on mobile and TV"}',
                'status' => '1',
                'created_at' => '2020-01-23 21:48:43',
                'updated_at' => '2020-01-23 21:48:43',
            ),
            20 => 
            array (
                'id' => 56,
                'course_id' => '17',
                'item' => NULL,
                'icon' => 'fa-chevron-left',
                'detail' => '{"en":"Anytime, Anywhere"}',
                'status' => '1',
                'created_at' => '2020-01-23 22:41:50',
                'updated_at' => '2020-01-23 22:41:50',
            ),
            21 => 
            array (
                'id' => 57,
                'course_id' => '17',
                'item' => NULL,
                'icon' => 'fa-check-square',
                'detail' => '{"en":"Downloadable resources"}',
                'status' => '1',
                'created_at' => '2020-01-23 22:42:08',
                'updated_at' => '2020-01-23 22:42:08',
            ),
            22 => 
            array (
                'id' => 58,
                'course_id' => '17',
                'item' => NULL,
                'icon' => 'fa-bullhorn',
                'detail' => '{"en":"Full lifetime access"}',
                'status' => '1',
                'created_at' => '2020-01-23 22:42:23',
                'updated_at' => '2020-01-23 22:42:23',
            ),
            23 => 
            array (
                'id' => 59,
                'course_id' => '18',
                'item' => NULL,
                'icon' => 'fa-braille',
                'detail' => '{"en":"On-demand video"}',
                'status' => '1',
                'created_at' => '2020-01-23 22:48:49',
                'updated_at' => '2020-01-23 22:48:49',
            ),
            24 => 
            array (
                'id' => 60,
                'course_id' => '18',
                'item' => NULL,
                'icon' => 'fa-buysellads',
                'detail' => '{"en":"Full lifetime access"}',
                'status' => '1',
                'created_at' => '2020-01-23 22:49:04',
                'updated_at' => '2020-01-23 22:49:04',
            ),
            25 => 
            array (
                'id' => 61,
                'course_id' => '18',
                'item' => NULL,
                'icon' => 'fa-crosshairs',
                'detail' => '{"en":"Access on mobile and TV"}',
                'status' => '1',
                'created_at' => '2020-01-23 22:49:19',
                'updated_at' => '2020-01-23 22:49:19',
            ),
            26 => 
            array (
                'id' => 62,
                'course_id' => '18',
                'item' => NULL,
                'icon' => 'fa-genderless',
                'detail' => '{"en":"Full lifetime access"}',
                'status' => '1',
                'created_at' => '2020-01-23 22:49:35',
                'updated_at' => '2020-01-23 22:49:35',
            ),
            27 => 
            array (
                'id' => 67,
                'course_id' => '20',
                'item' => NULL,
                'icon' => 'fa-bandcamp',
                'detail' => '{"en":"on-demand video"}',
                'status' => '1',
                'created_at' => '2020-01-23 23:03:28',
                'updated_at' => '2020-01-23 23:03:28',
            ),
            28 => 
            array (
                'id' => 68,
                'course_id' => '20',
                'item' => NULL,
                'icon' => 'fa-bullseye',
                'detail' => '{"en":"Full lifetime access"}',
                'status' => '1',
                'created_at' => '2020-01-23 23:03:40',
                'updated_at' => '2020-01-23 23:03:40',
            ),
            29 => 
            array (
                'id' => 69,
                'course_id' => '20',
                'item' => NULL,
                'icon' => 'fa-align-left',
                'detail' => '{"en":"Anytime, Anywhere"}',
                'status' => '1',
                'created_at' => '2020-01-23 23:04:04',
                'updated_at' => '2020-01-23 23:04:13',
            ),
        ));
        
        
    }
}