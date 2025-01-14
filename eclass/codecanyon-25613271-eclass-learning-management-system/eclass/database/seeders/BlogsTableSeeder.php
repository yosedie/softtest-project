<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('blogs')->delete();
        
        \DB::table('blogs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'date' => '0000-00-00',
                'image' => '157977947577.jpg',
                'heading' => '{"en":"Blogging Courses, Training, Classes & Tutorials Online"}',
            'detail' => '{"en":"<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<\\/p>"}',
                'text' => '{"en":"#blog"}',
                'approved' => 1,
                'status' => 1,
                'slug' =>'blogging-courses-training-classes-tutorials-online',
                'created_at' => '2020-01-23 17:07:55',
                'updated_at' => '2020-04-03 17:57:13',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 1,
                'date' => '0000-00-00',
                'image' => '157978018683.jpg',
                'heading' => '{"en":"Blogging & Content Writing Masterclass"}',
                'detail' => '{"en":"<p>Lorem Ipsumis simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum<\\/p>"}',
                'text' => '{"en":"#ffgph"}',
                'approved' => 1,
                'status' => 1,
                'slug' =>'blogging-content-writing-masterclass',
                'created_at' => '2020-01-23 17:11:34',
                'updated_at' => '2020-04-03 17:58:01',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 1,
                'date' => '0000-00-00',
                'image' => '157978055225.jpg',
                'heading' => '{"en":"Blogging Masterclass"}',
                'detail' => '{"en":"<p>Lorem Ipsum&amp;nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum<\\/p>"}',
                'text' => '{"en":"Blogging Masterclass: Full lifetime access"}',
                'approved' => 1,
                'status' => 1,
                'slug' =>'blogging-masterclass',
                'created_at' => '2020-01-23 17:25:27',
                'updated_at' => '2020-04-03 17:58:58',
            ),
            3 => 
            array (
                'id' => 4,
                'user_id' => 1,
                'date' => '0000-00-00',
                'image' => '157978163994.jpg',
                'heading' => '{"en":"Blogging for Your Business"}',
                'detail' => '{"en":"<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.<\\/p>"}',
                'text' => '{"en":"#vblog"}',
                'approved' => 1,
                'status' => 1,
                'slug' =>'blogging-for-your-business',
                'created_at' => '2020-01-23 17:42:09',
                'updated_at' => '2020-04-03 17:59:43',
            ),
            4 => 
            array (
                'id' => 5,
                'user_id' => 1,
                'date' => '0000-00-00',
                'image' => '157978167090.jpg',
                'heading' => '{"en":"Build a Successful Creative Blog"}',
                'detail' => '{"en":"<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.<\\/p>"}',
                'text' => '{"en":"#Creative Live"}',
                'approved' => 1,
                'status' => 1,
                'slug' =>'build-a-successful-creative-blog',
                'created_at' => '2020-01-23 17:43:30',
                'updated_at' => '2020-04-03 18:00:10',
            ),
            5 => 
            array (
                'id' => 6,
                'user_id' => 1,
                'date' => '0000-00-00',
                'image' => '157978219697.jpg',
                'heading' => '{"en":"Built to Blog"}',
                'detail' => '{"en":"<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.<\\/p>"}',
                'text' => '{"en":"#blog"}',
                'approved' => 1,
                'status' => 1,
                'slug' =>'built-to-blog',
                'created_at' => '2020-01-23 17:53:16',
                'updated_at' => '2020-04-03 18:00:33',
            ),
        ));
        
        
    }
}