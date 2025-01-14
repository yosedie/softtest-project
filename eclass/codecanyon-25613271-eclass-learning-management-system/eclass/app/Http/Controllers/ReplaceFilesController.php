<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Storage;
use Count;
use DotenvEditor;
use ZipArchive;

class ReplaceFilesController extends Controller
{

    public function index()
    {

        $app_version = env('APP_VERSION');
        $app_version = str_replace('.', '', $app_version) + 1;
         $app_version = implode('.', str_split($app_version));

        $contents = @file_get_contents('http://eclass.mediacity.co.in/bugfix/'.$app_version.'.zip');
        return view('admin.replace_files.index', compact('contents', 'app_version'));

    }


    public function replace(Request $request)
    { 

        ini_set('max_execution_time', '-1');

        ini_set('memory_limit', '-1');


        $app_version = env('APP_VERSION');
        $app_version = str_replace('.', '', $app_version) + 1;
        $app_version = implode('.', str_split($app_version));


        $db_version = env('APP_VERSION');
        $db_version = str_replace('.', '_', $db_version);
        $db_version = str_replace('_', '', $db_version) + 1;
        $db_version = implode('_', str_split($db_version));
        
        

        try{


        	$contents = @file_get_contents('http://eclass.mediacity.co.in/bugfix/'.$app_version.'.zip');

    		$bug_fix_files = @file_put_contents(base_path().$app_version.'.zip', $contents);


            // return 'yes';


            if ($bug_fix_files == !NULL)
            {

                // \Artisan::call('replace:files');

                $file = base_path().$app_version.'.zip';

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

                        $replace_file = @file_get_contents(base_path().$app_version.'.zip');

                        if($replace_file)
                        {

                            unlink(base_path().$app_version.'.zip');
                        }


                        $migration_path = 'migrations/update'.$db_version;

                        if(file_exists(database_path().'/'.$migration_path)) {
          
                            \Artisan::call('migrate --path=database/migrations/update'.$db_version);

                        }


                        if(!empty(config('app.version')))
                        {
                            DotenvEditor::setKey('APP_VERSION', $app_version)->save();
                        }
                        

                         
                    }
                }

                
            }

            return back()->with('success','Update Successfully');


        }catch(\Exception $e){
            
            \Session::flash('delete', $e->getMessage());
            return back();
        }

    	
    }


}
