<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => '{"en":"Design","es":"Dise\\u00f1o"}',
                'icon' => 'fa-slideshare',
                'slug' => 'design',
                'featured' => '1',
                'status' => '1',
                'position' => 1,
                'created_at' => '2020-01-22 12:52:40',
                'updated_at' => '2020-09-18 02:04:27',
                'cat_image' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => '{"en":"Devlopment","es":"Desarrollo"}',
                'icon' => 'fa-connectdevelop',
                'slug' => 'devlopment',
                'featured' => '1',
                'status' => '1',
                'position' => 4,
                'created_at' => '2020-01-22 12:53:53',
                'updated_at' => '2020-09-18 02:09:01',
                'cat_image' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'title' => '{"en":"Music","es":"M\\u00fasica"}',
                'icon' => 'fa-music',
                'slug' => 'music',
                'featured' => '0',
                'status' => '0',
                'position' => 6,
                'created_at' => '2020-01-22 12:54:24',
                'updated_at' => '2020-04-23 14:53:18',
                'cat_image' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'title' => '{"en":"Lifestyle","es":"Estilo de vida"}',
                'icon' => 'fa-yelp',
                'slug' => 'lifestyle',
                'featured' => '0',
                'status' => '1',
                'position' => 5,
                'created_at' => '2020-01-22 12:57:01',
                'updated_at' => '2020-04-23 14:53:18',
                'cat_image' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'title' => '{"en":"Photogarphy","es":"Fotograf\\u00eda"}',
                'icon' => 'fa-file-photo-o',
                'slug' => 'photogarphy',
                'featured' => '1',
                'status' => '1',
                'position' => 2,
                'created_at' => '2020-01-22 12:57:32',
                'updated_at' => '2020-09-18 02:05:31',
                'cat_image' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'title' => '{"en":"Health & Fitness","es":"salud y estado fisico"}',
                'icon' => 'fa-heartbeat',
                'slug' => 'health-fitness',
                'featured' => '1',
                'status' => '1',
                'position' => 3,
                'created_at' => '2020-01-22 12:59:41',
                'updated_at' => '2020-09-18 02:08:10',
                'cat_image' => NULL,
            ),
        ));
        
        
    }
}