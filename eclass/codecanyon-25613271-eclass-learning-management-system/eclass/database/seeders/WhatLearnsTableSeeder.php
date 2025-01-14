<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WhatLearnsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('what_learns')->delete();
        
        \DB::table('what_learns')->insert(array (
            0 => 
            array (
                'id' => 1,
                'course_id' => '1',
                'detail' => '{"en":"Have the skills to start making money on the side, as a casual freelancer, or full time as a work-from-home freelancer"}',
                'status' => '1',
                'created_at' => '2020-01-22 15:05:40',
                'updated_at' => '2020-01-22 15:05:40',
            ),
            1 => 
            array (
                'id' => 2,
                'course_id' => '1',
            'detail' => '{"en":"Easily create a beautiful HTML & CSS website with Bootstrap (that doesn\'t look like generic Bootstrap websites!)"}',
                'status' => '1',
                'created_at' => '2020-01-22 15:05:51',
                'updated_at' => '2020-01-22 15:05:51',
            ),
            2 => 
            array (
                'id' => 3,
                'course_id' => '1',
                'detail' => '{"en":"Fully understand how to use Custom Post Types and Advanced Custom Fields in WordPress"}',
                'status' => '1',
                'created_at' => '2020-01-22 15:06:07',
                'updated_at' => '2020-01-22 15:06:07',
            ),
            3 => 
            array (
                'id' => 4,
                'course_id' => '1',
                'detail' => '{"en":"Allow your clients to update their websites by themselves by creating user accounts"}',
                'status' => '1',
                'created_at' => '2020-01-22 15:06:47',
                'updated_at' => '2020-01-23 00:50:11',
            ),
            4 => 
            array (
                'id' => 15,
                'course_id' => '5',
                'detail' => '{"en":"They will learn pencil techniques in order to create shirring\\/gathers, and shading, and the use of color pencils."}',
                'status' => '1',
                'created_at' => '2020-01-22 16:31:22',
                'updated_at' => '2020-01-22 16:31:22',
            ),
            5 => 
            array (
                'id' => 16,
                'course_id' => '5',
                'detail' => '{"en":"They will learn movement of the body, balance, plumb line."}',
                'status' => '1',
                'created_at' => '2020-01-22 16:31:38',
                'updated_at' => '2020-01-22 16:31:38',
            ),
            6 => 
            array (
                'id' => 17,
                'course_id' => '5',
                'detail' => '{"en":"They will learn about a fashion diary\\/journal, as a source of inspiration in order to be a great designer."}',
                'status' => '1',
                'created_at' => '2020-01-22 16:31:51',
                'updated_at' => '2020-01-22 16:31:51',
            ),
            7 => 
            array (
                'id' => 18,
                'course_id' => '6',
                'detail' => '{"en":"Instructions on how to hold your camera correctly, which will help you to get sharp photographs."}',
                'status' => '1',
                'created_at' => '2020-01-22 16:49:12',
                'updated_at' => '2020-01-22 16:49:12',
            ),
            8 => 
            array (
                'id' => 19,
                'course_id' => '6',
                'detail' => '{"en":"Sound advice on how to choose the right camera lens for each situation."}',
                'status' => '1',
                'created_at' => '2020-01-22 16:49:24',
                'updated_at' => '2020-01-22 16:49:24',
            ),
            9 => 
            array (
                'id' => 20,
                'course_id' => '6',
                'detail' => '{"en":"The necessary confidence to change the most important camera settings correctly at the right time, which in turn will allow you to get perfect photos every time"}',
                'status' => '1',
                'created_at' => '2020-01-22 16:49:31',
                'updated_at' => '2020-01-22 16:49:31',
            ),
            10 => 
            array (
                'id' => 21,
                'course_id' => '6',
                'detail' => '{"en":"The ability to compose photos that are well balanced and very pleasing to the eye."}',
                'status' => '1',
                'created_at' => '2020-01-22 16:49:38',
                'updated_at' => '2020-01-22 16:49:38',
            ),
            11 => 
            array (
                'id' => 31,
                'course_id' => '1',
                'detail' => '{"en":"Cut away a person from their background"}',
                'status' => '1',
                'created_at' => '2020-01-23 00:47:39',
                'updated_at' => '2020-01-23 00:47:39',
            ),
            12 => 
            array (
                'id' => 36,
                'course_id' => '10',
                'detail' => '{"en":"Get friendly and fast support in the course Q&A"}',
                'status' => '1',
                'created_at' => '2020-01-23 21:41:32',
                'updated_at' => '2020-01-23 21:41:32',
            ),
            13 => 
            array (
                'id' => 37,
                'course_id' => '10',
                'detail' => '{"en":"What\'s new in ES6: arrow functions, classes, default and rest parameters, etc."}',
                'status' => '1',
                'created_at' => '2020-01-23 21:41:42',
                'updated_at' => '2020-01-23 21:41:43',
            ),
            14 => 
            array (
                'id' => 38,
                'course_id' => '10',
                'detail' => '{"en":"Organize and structure your code using JavaScript patterns like modules"}',
                'status' => '1',
                'created_at' => '2020-01-23 21:41:51',
                'updated_at' => '2020-01-23 21:41:51',
            ),
            15 => 
            array (
                'id' => 39,
                'course_id' => '10',
                'detail' => '{"en":"Get friendly and fast support in the course Q&A"}',
                'status' => '1',
                'created_at' => '2020-01-23 21:41:59',
                'updated_at' => '2020-01-23 21:41:59',
            ),
            16 => 
            array (
                'id' => 40,
                'course_id' => '12',
                'detail' => '{"en":"Be comfortable putting SQL and PostgreSQL on their resume"}',
                'status' => '1',
                'created_at' => '2020-01-23 21:44:49',
                'updated_at' => '2020-01-23 21:44:49',
            ),
            17 => 
            array (
                'id' => 41,
                'course_id' => '12',
                'detail' => '{"en":"Use SQL to perform data analysis"}',
                'status' => '1',
                'created_at' => '2020-01-23 21:45:00',
                'updated_at' => '2020-01-23 21:45:00',
            ),
            18 => 
            array (
                'id' => 42,
                'course_id' => '12',
                'detail' => '{"en":"Be confident while working with constraints and relating data tables"}',
                'status' => '1',
                'created_at' => '2020-01-23 21:45:30',
                'updated_at' => '2020-01-23 21:45:30',
            ),
            19 => 
            array (
                'id' => 43,
                'course_id' => '12',
                'detail' => '{"en":"Tons of exercises that will solidify your knowledge"}',
                'status' => '1',
                'created_at' => '2020-01-23 21:45:42',
                'updated_at' => '2020-01-23 21:45:42',
            ),
            20 => 
            array (
                'id' => 55,
                'course_id' => '17',
                'detail' => '{"en":"By the end of the class you\\u2019ll paint a portrait in full color."}',
                'status' => '1',
                'created_at' => '2020-01-23 22:45:25',
                'updated_at' => '2020-01-23 22:45:25',
            ),
            21 => 
            array (
                'id' => 56,
                'course_id' => '17',
            'detail' => '{"en":"The best way to light and photograph, portrait (or any other subject) for a painting."}',
                'status' => '1',
                'created_at' => '2020-01-23 22:45:33',
                'updated_at' => '2020-01-23 22:45:33',
            ),
            22 => 
            array (
                'id' => 57,
                'course_id' => '17',
                'detail' => '{"en":"You\\u2019ll Learn the difference between chroma, color and values and how to control them."}',
                'status' => '1',
                'created_at' => '2020-01-23 22:45:43',
                'updated_at' => '2020-01-23 22:45:43',
            ),
            23 => 
            array (
                'id' => 58,
                'course_id' => '17',
                'detail' => '{"en":"An easy system to drawing anything you want!"}',
                'status' => '1',
                'created_at' => '2020-01-23 22:45:51',
                'updated_at' => '2020-01-23 22:45:51',
            ),
            24 => 
            array (
                'id' => 59,
                'course_id' => '18',
                'detail' => '{"en":"Curl your hair"}',
                'status' => '1',
                'created_at' => '2020-01-23 22:47:21',
                'updated_at' => '2020-01-23 22:47:21',
            ),
            25 => 
            array (
                'id' => 60,
                'course_id' => '18',
                'detail' => '{"en":"Straighten your hai"}',
                'status' => '1',
                'created_at' => '2020-01-23 22:47:36',
                'updated_at' => '2020-01-23 22:47:36',
            ),
            26 => 
            array (
                'id' => 61,
                'course_id' => '18',
                'detail' => '{"en":"Cut your own hair"}',
                'status' => '1',
                'created_at' => '2020-01-23 22:47:56',
                'updated_at' => '2020-01-23 22:47:56',
            ),
            27 => 
            array (
                'id' => 62,
                'course_id' => '18',
                'detail' => '{"en":"Dye your own hair naturally at hom"}',
                'status' => '1',
                'created_at' => '2020-01-23 22:48:14',
                'updated_at' => '2020-01-23 22:48:14',
            ),
            28 => 
            array (
                'id' => 66,
                'course_id' => '20',
                'detail' => '{"en":"Locating the perfect dates to travel for the cheapest price."}',
                'status' => '1',
                'created_at' => '2020-01-23 23:04:28',
                'updated_at' => '2020-01-23 23:04:29',
            ),
            29 => 
            array (
                'id' => 67,
                'course_id' => '20',
                'detail' => '{"en":"Learn the tricks of travel and finding discount places to stay."}',
                'status' => '1',
                'created_at' => '2020-01-23 23:04:37',
                'updated_at' => '2020-01-23 23:04:37',
            ),
            30 => 
            array (
                'id' => 68,
                'course_id' => '20',
                'detail' => '{"en":"How to travel light"}',
                'status' => '1',
                'created_at' => '2020-01-23 23:04:53',
                'updated_at' => '2020-01-23 23:04:53',
            ),
            31 => 
            array (
                'id' => 69,
                'course_id' => '20',
                'detail' => '{"en":"How to finance your trips"}',
                'status' => '1',
                'created_at' => '2020-01-23 23:05:07',
                'updated_at' => '2020-01-23 23:05:08',
            ),
            32 => 
            array (
                'id' => 70,
                'course_id' => '20',
                'detail' => '{"en":"How to locate & book cheap flights"}',
                'status' => '1',
                'created_at' => '2020-01-23 23:05:16',
                'updated_at' => '2020-01-23 23:05:16',
            ),
            33 => 
            array (
                'id' => 71,
                'course_id' => '20',
                'detail' => '{"en":"How to communicate if you don\'t speak the native language in a country."}',
                'status' => '1',
                'created_at' => '2020-01-23 23:05:27',
                'updated_at' => '2020-01-23 23:05:27',
            ),
        ));
        
        
    }
}