<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DotenvEditor;
use Artisan;
use Illuminate\Support\Facades\DB;
use Session;
use Module;
use ZipArchive;
use Spatie\Permission\Models\Role;


class ThemeController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:themes.manage', ['only' => [' index','update','addTheme','installTheme','process','delete']]);
    
    }
    public function index()
    {
    	$env_files = [

            'DEFAULT_THEME' => env('DEFAULT_THEME'),
        ];

    	return view('admin.theme.edit', compact('env_files'));
    }

    public function update(Request $request)
    {
        if($request->default_theme == 'classic'){
            
            if(Module::has('Blizzard'))
            { 
                \Artisan::call('module:disable blizzard'); 
            }

            $env_keys_save = DotenvEditor::setKeys([
                'DEFAULT_THEME' => $request->default_theme
            ]);
    
            $env_keys_save->save();
    
            return back()->with('success', trans('flash.settingssaved'));

        }else{
            \Artisan::call('module:enable '.$request->default_theme);

            if(env('MIX_THEME_FOLDER') == '' || !DB::table('api_keys')->where('id', '2')->first()->secret_key){
                return back()->with('deleted',__('Please configure theme before using it'));
            }

            $env_keys_save = DotenvEditor::setKeys([
                'DEFAULT_THEME' => $request->default_theme
            ]);
    
            $env_keys_save->save();
    
            return back()->with('success', trans('flash.settingssaved'));

        }
       
    }
    public function addTheme()
    {
        return view('admin.theme.add');
    }

    public function installTheme(Request $request)
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

    public function process($request)
    {    
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
                if(!isset($json_array->type) || $json_array->type !='theme')
                {
                    $zip->close();
                    return back()->with('delete','Can not install add-on from theme manager');
                }
            }
        }

        if($zipped)
        {
            $extract = $zip->extractTo(base_path().'/Modules/');
            if($extract){
                $module = Module::find($modulename);
                $module->enable();
                Artisan::call('module:publish');

                Artisan::call('module:migrate', ['module' => $modulename]);
               
                Session::flash('success', $modulename.' Installed Successfully');
                $module->disable();
                return back();
            }
        }
        
        $zip->close();

    }

    public function delete($addon)
    {

        if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }

        $module = Module::find($addon);

        $module->delete();

        $env_keys_save = DotenvEditor::setKeys([
            'DEFAULT_THEME' =>'classic'
        ]);

        $env_keys_save->save();

         return back()->with('delete','Deleted successfully');
    }
}