<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GetStartedsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('get_starteds')->delete();
        
        \DB::table('get_starteds')->insert(array (
            0 => 
            array (
                'id' => 1,
                'heading' => '{"en":null}',
                'sub_heading' => '{"en":null}',
                'button_txt' => '{"en":null}',
            'image' => '159748969215908739281579934374banner (1).jpg',
                'created_at' => '2020-01-23 16:52:11',
                'updated_at' => '2020-11-13 19:29:33',
                'link' => NULL,
            ),
        ));
        
        
    }
}