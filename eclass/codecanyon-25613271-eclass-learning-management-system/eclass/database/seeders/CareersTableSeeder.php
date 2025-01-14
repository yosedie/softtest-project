<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CareersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('careers')->delete();
        
        \DB::table('careers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'one_enable' => 0,
                'one_heading' => NULL,
                'one_text' => NULL,
                'one_btntxt' => NULL,
                'one_video' => NULL,
                'two_enable' => 0,
                'three_enable' => 0,
                'three_bg_image' => NULL,
                'three_video' => NULL,
                'three_heading' => NULL,
                'three_btntxt' => NULL,
                'four_enable' => 0,
                'four_img_one' => NULL,
                'four_img_two' => NULL,
                'four_img_three' => NULL,
                'four_img_four' => NULL,
                'four_img_five' => NULL,
                'four_img_six' => NULL,
                'four_img_seven' => NULL,
                'four_img_eight' => NULL,
                'four_img_nine' => NULL,
                'five_enable' => 0,
                'five_heading' => NULL,
                'five_text' => NULL,
                'five_icon' => NULL,
                'five_detail' => NULL,
                'five_textone' => NULL,
                'five_texttwo' => NULL,
                'five_textthree' => NULL,
                'five_textfour' => NULL,
                'five_textfive' => NULL,
                'five_textsix' => NULL,
                'five_textseven' => NULL,
                'five_texteight' => NULL,
                'five_textnine' => NULL,
                'five_textten' => NULL,
                'five_dtlone' => NULL,
                'five_dtltwo' => NULL,
                'five_dtlthree' => NULL,
                'five_dtlfour' => NULL,
                'five_dtlfive' => NULL,
                'five_dtlsix' => NULL,
                'five_dtlseven' => NULL,
                'five_dtleight' => NULL,
                'five_dtlnine' => NULL,
                'five_dtlten' => NULL,
                'six_enable' => 0,
                'six_heading' => NULL,
                'six_text' => NULL,
                'six_topic_one' => NULL,
                'six_topic_two' => NULL,
                'six_topic_three' => NULL,
                'six_topic_four' => NULL,
                'six_topic_five' => NULL,
                'six_topic_six' => NULL,
                'created_at' => now(),
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}