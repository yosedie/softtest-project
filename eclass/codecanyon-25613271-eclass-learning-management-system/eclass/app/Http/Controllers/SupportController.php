<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Spatie\Permission\Models\Role;


class SupportController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:help-support-remove-public.manage', ['only' => ['index','addcontent','createfile']]);
    
    }
    public function index()
    {

        $contents = @file_get_contents(base_path().'/'.'.htaccess');
        $destinationPath=@file_get_contents(resource_path().'/'.'views/admin/support/htaccess.php');
        return view('admin.support.remove_public', compact('contents', 'destinationPath'));
    }

    public function addcontent()
    {

        if(config('app.demolock') == 0){

            if(!file_exists(base_path().'/'.'.htaccess')) {

                $destinationPath=base_path(). '/' .'.htaccess';

                copy(resource_path().'/'.'views/admin/support/htaccess.php', base_path(). '/'.'.htaccess');

            }  

            if(file_exists(base_path().'/'.'.htaccess')) {

                $destinationPath=base_path(). '/' .'.htaccess';

                copy(resource_path().'/'.'views/admin/support/htaccess.php', base_path(). '/'.'.htaccess');

            } 
            return back()->with('success','Update Successfully');

        }

        return back()->with('delete','You can\'t update in Demo');

    }

    public function createfile()
    {

        if(config('app.demolock') == 0){

            if(!file_exists(base_path().'/'.'.htaccess')) {

                $destinationPath=base_path(). '/' .'.htaccess';

                copy(resource_path().'/'.'views/admin/support/htaccess.php', base_path(). '/'.'.htaccess');

            }  

            return back()->with('success','Update Successfully'); 

        }

        return back()->with('delete','You can\'t update in Demo');
    	
    }
}
