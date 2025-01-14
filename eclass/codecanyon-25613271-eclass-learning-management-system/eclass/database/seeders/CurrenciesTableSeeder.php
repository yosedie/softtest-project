<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('currencies')->delete();
        
        \DB::table('currencies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'icon' => 'fa fa-dollar',
                'currency' => 'USD',
                'default' => 1,
                'created_at' => '2019-12-11 11:24:24',
                'updated_at' => '2020-02-08 17:45:15',
                'name' => 'US Dollar',
                'code' => 'USD',
                'symbol' => '$',
                'format' => '$1,0.00',
                'exchange_rate' => '1',
                'active' => 0,
            ),
        ));
        
        
    }
}