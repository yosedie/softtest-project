<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InvoiceDesignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('invoice_design')->delete();
        
        \DB::table('invoice_design')->insert(array (
            0 => 
            array (
                'id' => 1,
                'logo_enable' => 1,
                'print_type' => NULL,
                'border_enable' => 1,
                'border_radius' => '50',
                'border_color' => '#0284A2',
                'border_style' => 'groove',
                'date_format' => 'jS F Y',
                'created_at' => '2019-12-11 11:24:24',
                'updated_at' => '2020-02-08 17:45:15',
                
            ),
        ));
    }
}
