<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class AppSettingsController extends Controller
{
    public function index()
    {
    	$data = Setting::first();
		return view('admin.app_settings.edit',compact('data'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first();

        if(isset($request->googlepay_enable))
        {
            $setting->googlepay_enable = 1;
        }
        else
        {
            $setting->googlepay_enable = 0;
        }
        
        $setting->save();
        
        

        return back()->with('success', trans('flash.settingssaved'));
    }


}
