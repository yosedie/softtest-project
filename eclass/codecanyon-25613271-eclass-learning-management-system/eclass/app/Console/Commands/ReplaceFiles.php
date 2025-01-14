<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;
use ZipArchive;
use Session;

class ReplaceFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'replace:files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will replace bug fixed files';

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
        ini_set('max_execution_time', '-1');

        ini_set('memory_limit', '-1');

        $file = base_path().'/replace'.config('app.version').'.zip'; 
        
        $this->info('Extracting files !');

        try{
                //create an instance of ZipArchive Class
            $zip = new ZipArchive;
             
            //open the file that you want to unzip. 
            //NOTE: give the correct path. In this example zip file is in the same folder
            $zipped = $zip->open($file);
             
            // get the absolute path to $file, where the files has to be unzipped
            $path = base_path();
             
            //check if it is actually a Zip file
            if ($zipped) {
                //if yes then extract it to the said folder
              $extract = $zip->extractTo($path);

              //close the zip
              $zip->close();  
             
              //if unzipped succesfully then show the success message
              if($extract){

                unlink(base_path().'/replace'.config('app.version').'.zip');

                $this->info('Files replaced successfully !');
                 
              }
            }
        }catch(\Exception $e){
            // die($e->getMessage());
            \Session::flash('delete', $e->getMessage());
        }
    }
}
