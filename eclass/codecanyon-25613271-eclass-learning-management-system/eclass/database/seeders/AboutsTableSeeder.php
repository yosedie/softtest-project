<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AboutsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('abouts')->delete();
        
        \DB::table('abouts')->insert(array (
            0 => 
            array (
                'id' => 1,
                'one_enable' => 0,
                'one_heading' => '',
                'one_image' => '',
                'one_text' => '',
                'two_enable' => 0,
                'two_heading' => '',
                'two_text' => '',
                'two_imageone' => '',
                'two_imagetwo' => '',
                'two_imagethree' => '',
                'two_imagefour' => '',
                'two_txtone' => '',
                'two_txttwo' => '',
                'two_txtthree' => '',
                'two_txtfour' => '',
                'two_imagetext' => '',
                'three_enable' => 0,
                'three_heading' => '',
                'three_text' => '',
                'three_countone' => '',
                'three_counttwo' => '',
                'three_countthree' => '',
                'three_countfour' => '',
                'three_countfive' => '',
                'three_countsix' => '',
                'three_txtone' => '',
                'three_txttwo' => '',
                'three_txtthree' => '',
                'three_txtfour' => '',
                'three_txtfive' => '',
                'three_txtsix' => '',
                'four_enable' => 0,
                'four_heading' => '',
                'four_text' => '',
                'four_btntext' => '',
                'four_imageone' => '',
                'four_imagetwo' => '',
                'four_txtone' => '',
                'four_txttwo' => '',
                'four_icon' => '',
                'five_enable' => 0,
                'five_heading' => '',
                'five_text' => '',
                'five_btntext' => '',
                'five_imageone' => '',
                'five_imagetwo' => '',
                'five_imagethree' => '',
                'six_enable' => 0,
                'six_heading' => '',
                'six_txtone' => '',
                'six_txttwo' => '',
                'six_txtthree' => '',
                'six_deatilone' => '',
                'six_deatiltwo' => '',
                'six_deatilthree' => '',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}