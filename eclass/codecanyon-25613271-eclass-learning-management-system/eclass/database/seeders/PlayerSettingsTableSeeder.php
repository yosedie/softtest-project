<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PlayerSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('player_settings')->delete();
        
        \DB::table('player_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'logo' => 'logo.png',
                'logo_enable' => 1,
                'cpy_text' => __('All rights reserved'),
                'share_enable' => 1,
                'autoplay' => 1,
                'download' => 1,
                'subtitle_font_size' => 12,
                'subtitle_color' => '#48a3c6',
                'embedded_enable' => 1,
                'created_at' => now(),
                'updated_at' => '2020-11-02 15:01:23',
            ),
        ));
        
        
    }
}