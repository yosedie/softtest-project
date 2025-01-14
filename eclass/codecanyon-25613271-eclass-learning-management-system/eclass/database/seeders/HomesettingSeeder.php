<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HomesettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('homesettings')->delete();
        
        \DB::table('homesettings')->insert(array (
            0 => 
            array (
                'id' => '1',
                'fact_enable' => '1',
                'discount_enable' => '1',
                'purchase_enable' => '1',
                'recentcourse_enable' => '1',
                'featured_enable' => '1',
                'bundle_enable' => '1',
                'bestselling_enable' => '1',
                'batch_enable' => '1',
                'livemeetings_enable' => '1',
                'blog_enable' => '1',
                'became_enable' => '1',
                'featuredcategories_enable' => '1',
                'testimonial_enable' => '1',
                'video_enable' => '1',
                'instructor_enable' => '1',

            ),
        ));
        
        
    }
    }
