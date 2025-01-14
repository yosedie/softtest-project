<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestimonialsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('testimonials')->delete();
        
        \DB::table('testimonials')->insert(array (
            0 => 
            array (
                'id' => 1,
                'client_name' => 'Admin',
                'details' => '{"en":"<p><span style=\\"font-family: \'Open Sans\', Arial, sans-serif; text-align: justify;\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.&nbsp;<\\/span><\\/p>"}',
                'status' => 1,
                'image' => '157968868531.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'client_name' => 'John Doe',
                'details' => '{"en":"<p><span style=\\"font-family: \'Open Sans\', Arial, sans-serif; text-align: justify;\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.&nbsp;<\\/span><\\/p>"}',
                'status' => 1,
                'image' => '158133327542.jpg',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'client_name' => 'Mary Carr',
                'details' => '{"en":"<p><span style=\\"font-family: \'Open Sans\', Arial, sans-serif; text-align: justify;\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.&nbsp;<\\/span><\\/p>"}',
                'status' => 1,
                'image' => '157968912636.png',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}