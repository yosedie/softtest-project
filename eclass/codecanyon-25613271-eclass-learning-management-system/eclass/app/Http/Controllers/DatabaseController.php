<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Auth;
use File;
use Illuminate\Support\Facades\Storage;
use DirectoryIterator;
use DotenvEditor;
use Spatie\Permission\Models\Role;


class DatabaseController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:help-support-database-backup.manage', ['only' => ['demoimport','importdatabase','resetdatabase','index','genrate','download','update','deletebackup']]);
      
    }
    
    public function demoimport()
    {
        return view('admin.database.demo');
    }

    public function importdatabase()
    {
        if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }

        \Artisan::call('import:demo');
        \Session::flash('delete','Demo Imported successfully !');

        return redirect('/');
    }

    public function resetdatabase()
    {

        if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }

        \Artisan::call('demo:reset');
        
        \Session::flash('delete','Demo reset successfully  !');
        return redirect('/');
    }

    public function index()
    {

        $dump = env('DUMP_BINARY_PATH');
        return view('admin.database.backup', compact('dump'));
    }

    public function genrate(Request $request)
    {
        if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }

        \Artisan::call('backup:run', ['--only-db' => true]);

        return back()->with('success',trans('flash.CreatedSuccessfully'));
    }

    public function download(Request $request, $filename)
    {

        if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }

        if (! $request->hasValidSignature()) {
            return back()->with('delete','Download Link is invalid or expired !');
        }

        $filePath = storage_path().'/app/'.config('app.name').'/'.$filename;

        $fileContent = file_get_contents($filePath);

        $response = response($fileContent, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);

        return $response;
    }

    public function update(Request $request)
    {

        $input = $request->all();

        $env_update = DotenvEditor::setKeys([

            'DUMP_BINARY_PATH' => $request->DUMP_BINARY_PATH,
            'FACEBOOK_CLIENT_SECRET' => $request->FACEBOOK_CLIENT_SECRET,
            'FACEBOOK_CALLBACK_URL' => $request->FACEBOOK_CALLBACK_URL

        ]);

        $env_update->save();

        return back()->with('success',trans('flash.UpdatedSuccessfully'));
        
    }


    public function deletebackup()
    {

        if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }

        $leave_files = array('.gitignore');

         $dir1 = storage_path() . '/app/eClass-LearningManagementSystem';

            foreach (glob("$dir1/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }

            }

        return back()->with('success',trans('flash.DeletedSuccessfully'));
    }




}
