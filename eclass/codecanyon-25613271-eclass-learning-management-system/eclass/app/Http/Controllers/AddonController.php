<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Module;
use ZipArchive;
use Artisan;
use Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AddonController extends Controller
{
    public function __construct()
    {
       
        $this->middleware('permission:addon.view', ['only' => ['addon']]);
        $this->middleware('permission:addon.create', ['only' => ['addaddon', 'installaddon']]);
        $this->middleware('permission:addon.edit', ['only' => ['process', 'status_process','status']]);
        $this->middleware('permission:addon.delete', ['only' => ['destroy']]);
    
    }
    public function addon()
    {
        $modules = Module::all();

        return view('admin.addon.index', compact('modules'));
    }

    public function addaddon()
    {
        
        return view('admin.addon.add');
    }
    public function installaddon(Request $request)
    {

        if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }
        $d = \Request::getHost();
        $domain = str_replace("www.", "", $d); 

        if(strstr($domain,'localhost') || strstr( $domain, '192.168.' ) || strstr($domain,'.test') || strstr($domain,'mediacity.co.in') || strstr($domain,'castleindia.in')){
             $put = 1;
            file_put_contents(public_path().'/config.txt', $put);
            return $this->process($request);
        }
        else{
            $responseCode = purchase_code($request->code);
            if($responseCode !== 200){
                return back()->with('delete','Invalid Purchase Code');
            }
            return $this->process($request);

        }


    }

    // public function process($request){

    //     ini_set('max_execution_time', 300);

    //     $filename = $request->addon_file;

    //     $modulename = str_replace('.'.$filename->getClientOriginalExtension(),'',$filename->getClientOriginalName());
    //     $zip = new ZipArchive;
    //     $zipped = $zip->open($filename,ZipArchive::CREATE);

    //     if($zipped){
    //         // $zip->getFromName($modulename.'/module.json');
    //         $extract = $zip->extractTo(base_path().'/Modules/');
    //         if($extract){
    //             $module = Module::find($modulename);
    //             $module->enable();
    //             Artisan::call('module:publish');

    //             Artisan::call('module:migrate', ['module' => $modulename]);
               
    //             Session::flash('success', $modulename.' Installed Successfully');
    //             return back(
    //             );
    //         }
    //     }
        
    //     $zip->close();

    // }
    public function process($request){
        
        ini_set('max_execution_time', 300);
        $filename = $request->addon_file;
        $modulename = str_replace('.'.$filename->getClientOriginalExtension(),'',$filename->getClientOriginalName());
        $zip = new ZipArchive;
        $zipped = $zip->open($filename,ZipArchive::CREATE);
        
        for ($i = 0; $i < $zip->count(); $i++) 
        {
            if($zip->getNameIndex($i) == $modulename."/module.json")
            {
                $fileData = $zip->getFromIndex($i);
                $json_array = json_decode($fileData);
                if(isset($json_array->type) && $json_array->type=='theme')
                {
                    $zip->close();
                    return back()->with('delete','Can not add theme from addon manager');
                }
            }
            
        }
        if($zipped){
         $zip->getFromName($modulename.'/module.json');
            $extract = $zip->extractTo(base_path().'/Modules/');
            if($extract){
                $module = Module::find($modulename);
                $module->enable();
                Artisan::call('module:publish');
                Artisan::call('module:migrate', ['module' => $modulename]);
               
                Session::flash('success', $modulename.' Installed Successfully');
                return back(
                );
            }
        }
        
        $zip->close();
    }
    public function status(Request $request, $addon)
    {
         if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }


        $d = \Request::getHost();
        $domain = str_replace("www.", "", $d); 

        if(strstr($domain,'localhost') || strstr( $domain, '192.168.' ) || strstr($domain,'.test') || strstr($domain,'mediacity.co.in') || strstr($domain,'castleindia.in')){
             $put = 1;
            file_put_contents(public_path().'/config.txt', $put);

            

            return $this->status_process($request, $addon);
        }
        else{


            $responseCode = purchase_code($request->code);

            if($responseCode !== 200){
                return back()->with('delete','Invalid Purchase Code');
            }

            return $this->status_process($request, $addon);

        }
        

    }

    public function status_process($request, $addon){

        $module = Module::find($addon);

        if( $module->isStatus(1))
        {
          $module->disable();  
        }
        else{

            $module->enable();

        }

        return back();

    }


    public function delete(Request $request, $addon)
    {

        if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }

         $module = Module::find($addon);

         $module->delete();
         return back();
    }

   
}
