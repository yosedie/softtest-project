<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sub_categories')->delete();
        
        \DB::table('sub_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'category_id' => '1',
                'title' => '{"en":"Web Design"}',
                'icon' => 'fa-desktop',
                'slug' => 'web-design',
                'status' => '1',
                'created_at' => '2020-01-22 13:02:16',
                'updated_at' => '2020-01-28 21:29:05',
            ),
            1 => 
            array (
                'id' => 3,
                'category_id' => '1',
                'title' => '{"en":"Fashion"}',
                'icon' => 'fa-snowflake-o',
                'slug' => 'fashion',
                'status' => '1',
                'created_at' => '2020-01-22 13:04:49',
                'updated_at' => '2020-01-22 13:04:49',
            ),
            2 => 
            array (
                'id' => 5,
                'category_id' => '2',
                'title' => '{"en":"Web Devlopment"}',
                'icon' => 'fa-codepen',
                'slug' => 'web-devlopment',
                'status' => '1',
                'created_at' => '2020-01-22 13:08:20',
                'updated_at' => '2020-01-22 13:08:20',
            ),
            3 => 
            array (
                'id' => 6,
                'category_id' => '2',
                'title' => '{"en":"Programming Language"}',
                'icon' => 'fa-language',
                'slug' => 'programming-language',
                'status' => '1',
                'created_at' => '2020-01-22 13:09:05',
                'updated_at' => '2020-01-22 13:09:05',
            ),
            4 => 
            array (
                'id' => 7,
                'category_id' => '2',
                'title' => '{"en":"Databases"}',
                'icon' => 'fa-database',
                'slug' => 'databases',
                'status' => '1',
                'created_at' => '2020-01-22 13:10:03',
                'updated_at' => '2020-01-22 13:10:03',
            ),
            5 => 
            array (
                'id' => 8,
                'category_id' => '3',
                'title' => '{"en":"Music Software"}',
                'icon' => 'fa-deviantart',
                'slug' => 'music-software',
                'status' => '1',
                'created_at' => '2020-01-22 13:11:30',
                'updated_at' => '2020-01-22 13:11:30',
            ),
            6 => 
            array (
                'id' => 10,
                'category_id' => '4',
                'title' => '{"en":"Art & Craft"}',
                'icon' => 'fa-opencart',
                'slug' => 'art-craft',
                'status' => '1',
                'created_at' => '2020-01-22 13:13:49',
                'updated_at' => '2020-01-22 13:13:49',
            ),
            7 => 
            array (
                'id' => 11,
                'category_id' => '4',
                'title' => '{"en":"Beauty & Makeup"}',
                'icon' => 'fa-ravelry',
                'slug' => 'beauty-makeup',
                'status' => '1',
                'created_at' => '2020-01-22 13:15:56',
                'updated_at' => '2020-01-22 13:15:56',
            ),
            8 => 
            array (
                'id' => 12,
                'category_id' => '4',
                'title' => '{"en":"Travel"}',
                'icon' => 'fa-plane',
                'slug' => 'travel',
                'status' => '1',
                'created_at' => '2020-01-22 13:17:46',
                'updated_at' => '2020-01-22 13:17:46',
            ),
            9 => 
            array (
                'id' => 13,
                'category_id' => '5',
                'title' => '{"en":"Digital Phptography"}',
                'icon' => 'fa-address-book-o',
                'slug' => 'digital-phptography',
                'status' => '1',
                'created_at' => '2020-01-22 13:18:18',
                'updated_at' => '2020-01-22 13:18:18',
            ),
            10 => 
            array (
                'id' => 14,
                'category_id' => '5',
                'title' => '{"en":"Photography Tools"}',
                'icon' => 'fa-anchor',
                'slug' => 'photography-tools',
                'status' => '1',
                'created_at' => '2020-01-22 13:19:26',
                'updated_at' => '2020-01-22 13:19:26',
            ),
            11 => 
            array (
                'id' => 15,
                'category_id' => '6',
                'title' => '{"en":"Sports"}',
                'icon' => 'fa-hand-spock-o',
                'slug' => 'sports',
                'status' => '1',
                'created_at' => '2020-01-22 13:23:07',
                'updated_at' => '2020-01-22 13:23:07',
            ),
        ));
        
        
    }
}