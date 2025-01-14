<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ChildCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('child_categories')->delete();
        
        \DB::table('child_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'category_id' => 1,
                'subcategory_id' => '1',
                'title' => '{"en":"All Web Design"}',
                'icon' => 'fa-apple',
                'slug' => 'all-web-design',
                'status' => '1',
                'created_at' => '2020-01-22 13:27:19',
                'updated_at' => '2020-01-23 00:16:38',
            ),
            1 => 
            array (
                'id' => 3,
                'category_id' => 1,
                'subcategory_id' => '3',
                'title' => '{"en":"Fashion Design"}',
                'icon' => 'fa-diamond',
                'slug' => 'fashion-design',
                'status' => '1',
                'created_at' => '2020-01-22 13:29:06',
                'updated_at' => '2020-01-22 14:34:33',
            ),
            2 => 
            array (
                'id' => 5,
                'category_id' => 2,
                'subcategory_id' => '5',
                'title' => '{"en":"All Web Devlopment"}',
                'icon' => 'fa-language',
                'slug' => 'all-web-devlopment',
                'status' => '1',
                'created_at' => '2020-01-22 13:32:46',
                'updated_at' => '2020-01-22 14:34:44',
            ),
            3 => 
            array (
                'id' => 6,
                'category_id' => 2,
                'subcategory_id' => '6',
                'title' => '{"en":"JavaScript"}',
                'icon' => 'fa-commenting-o',
                'slug' => 'javascript',
                'status' => '1',
                'created_at' => '2020-01-22 13:35:39',
                'updated_at' => '2020-01-22 14:34:50',
            ),
            4 => 
            array (
                'id' => 7,
                'category_id' => 2,
                'subcategory_id' => '6',
                'title' => '{"en":"C++"}',
                'icon' => 'fa-object-ungroup',
                'slug' => 'c',
                'status' => '1',
                'created_at' => '2020-01-22 13:36:30',
                'updated_at' => '2020-01-22 14:34:56',
            ),
            5 => 
            array (
                'id' => 8,
                'category_id' => 2,
                'subcategory_id' => '7',
                'title' => '{"en":"MySql"}',
                'icon' => 'fa-square-o',
                'slug' => 'mysql',
                'status' => '1',
                'created_at' => '2020-01-22 13:38:23',
                'updated_at' => '2020-01-22 14:35:01',
            ),
            6 => 
            array (
                'id' => 9,
                'category_id' => 2,
                'subcategory_id' => '7',
                'title' => '{"en":"Oracle SQL"}',
                'icon' => 'fa-database',
                'slug' => 'oracle-sql',
                'status' => '1',
                'created_at' => '2020-01-22 13:39:32',
                'updated_at' => '2020-01-22 14:35:06',
            ),
            7 => 
            array (
                'id' => 11,
                'category_id' => 3,
                'subcategory_id' => '8',
                'title' => '{"en":"All Music Software"}',
                'icon' => 'fa-gg',
                'slug' => 'all-music-software',
                'status' => '1',
                'created_at' => '2020-01-22 13:42:32',
                'updated_at' => '2020-01-22 14:35:18',
            ),
            8 => 
            array (
                'id' => 14,
                'category_id' => 4,
                'subcategory_id' => '10',
                'title' => '{"en":"Drawing"}',
                'icon' => 'fa-pencil',
                'slug' => 'drawing',
                'status' => '1',
                'created_at' => '2020-01-22 14:23:47',
                'updated_at' => '2020-01-22 14:35:47',
            ),
            9 => 
            array (
                'id' => 15,
                'category_id' => 4,
                'subcategory_id' => '10',
                'title' => '{"en":"Painting"}',
                'icon' => 'fa-paint-brush',
                'slug' => 'painting',
                'status' => '1',
                'created_at' => '2020-01-22 14:24:39',
                'updated_at' => '2020-01-22 14:36:22',
            ),
            10 => 
            array (
                'id' => 16,
                'category_id' => 4,
                'subcategory_id' => '11',
                'title' => '{"en":"Hair Styling"}',
                'icon' => 'fa-scissors',
                'slug' => 'hair-styling',
                'status' => '1',
                'created_at' => '2020-01-22 14:25:48',
                'updated_at' => '2020-01-22 14:37:29',
            ),
            11 => 
            array (
                'id' => 18,
                'category_id' => 4,
                'subcategory_id' => '11',
                'title' => '{"en":"Nail Art"}',
                'icon' => 'fa-hand-paper-o',
                'slug' => 'nail-art',
                'status' => '1',
                'created_at' => '2020-01-22 14:26:57',
                'updated_at' => '2020-01-22 14:37:52',
            ),
            12 => 
            array (
                'id' => 19,
                'category_id' => 4,
                'subcategory_id' => '12',
                'title' => '{"en":"Travel Tips"}',
                'icon' => 'fa-train',
                'slug' => 'travel-tips',
                'status' => '1',
                'created_at' => '2020-01-22 14:27:45',
                'updated_at' => '2020-01-22 14:37:59',
            ),
            13 => 
            array (
                'id' => 20,
                'category_id' => 5,
                'subcategory_id' => '13',
                'title' => '{"en":"All Digital Photography"}',
                'icon' => 'fa-photo',
                'slug' => 'all-digital-photography',
                'status' => '1',
                'created_at' => '2020-01-22 14:28:40',
                'updated_at' => '2020-01-22 14:38:05',
            ),
            14 => 
            array (
                'id' => 21,
                'category_id' => 5,
                'subcategory_id' => '14',
                'title' => '{"en":"Image Editing"}',
                'icon' => 'fa-file-image-o',
                'slug' => 'image-editing',
                'status' => '1',
                'created_at' => '2020-01-22 14:29:25',
                'updated_at' => '2020-01-22 14:37:03',
            ),
            15 => 
            array (
                'id' => 22,
                'category_id' => 6,
                'subcategory_id' => '15',
                'title' => '{"en":"All Sports"}',
                'icon' => 'fa-spotify',
                'slug' => 'all-sports',
                'status' => '1',
                'created_at' => '2020-01-22 14:31:49',
                'updated_at' => '2020-01-22 14:36:56',
            ),
        ));
        
        
    }
}