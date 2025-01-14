<?php

namespace App\Console\Commands;

use App\Cart;
use Illuminate\Console\Command;
use Artisan;
use ZipArchive;
use App\Wishlist;
use App\Order;
use Session;

class ImportDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will import demo on your script !';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Importing Demo...');

        Cart::truncate();
        Wishlist::truncate();
        Order::truncate();
        

        Artisan::call('db:seed --class=CategoriesTableSeeder');
        Artisan::call('db:seed --class=SubCategoriesTableSeeder');
        Artisan::call('db:seed --class=ChildCategoriesTableSeeder');
        Artisan::call('db:seed --class=CoursesTableSeeder');
        Artisan::call('db:seed --class=SlidersTableSeeder');
        Artisan::call('db:seed --class=SliderFactsTableSeeder');
        Artisan::call('db:seed --class=BlogsTableSeeder');

        Artisan::call('db:seed --class=GetStartedsTableSeeder');
        Artisan::call('db:seed --class=TestimonialsTableSeeder');
        Artisan::call('db:seed --class=TrustedsTableSeeder');
        Artisan::call('db:seed --class=WhatLearnsTableSeeder');
        Artisan::call('db:seed --class=CourseIncludesTableSeeder');
        Artisan::call('db:seed --class=CourseChaptersTableSeeder');
        Artisan::call('db:seed --class=CourseClassesTableSeeder');
        Artisan::call('db:seed --class=CourseLanguagesTableSeeder');

        $dir = base_path().'/storage/framework/sessions';

        foreach (glob("$dir/*") as $file) {
           
            unlink($file);
            
        }

         

        ini_set('max_execution_time', 200);

        $file = public_path().'/democontent.zip'; 
        
        $this->info('Extracting demo contents !');

        try{
                //create an instance of ZipArchive Class
            $zip = new ZipArchive;
             
            //open the file that you want to unzip. 
            //NOTE: give the correct path. In this example zip file is in the same folder
            $zipped = $zip->open($file);
             
            // get the absolute path to $file, where the files has to be unzipped
            $path = public_path();
             
            //check if it is actually a Zip file
            if ($zipped) {
                //if yes then extract it to the said folder
              $extract = $zip->extractTo($path);

              //close the zip
              $zip->close();  
             
              //if unzipped succesfully then show the success message
              if($extract){
                 $this->info('Demo data imported successfully !');
                 
              }
            }
        }catch(\Exception $e){
            // die($e->getMessage());
            \Session::flash('delete', $e->getMessage());
        }


        
    }
}