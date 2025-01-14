<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class WhatsappButtonController extends Controller
{
    public function show()
    {
    	$setting = Setting::first();
    	return view('admin.setting.whatsapp_setting', compact('setting'));
    }


    public function update(Request $request)
    {
    	$setting = Setting::first();

        

        if(config('app.demolock') == 0){

            $setting->wapp_phone = $request->wapp_phone;
            $setting->wapp_popup_msg = $request->wapp_popup_msg;
            $setting->wapp_title = $request->wapp_title;
            $setting->wapp_color = $request->wapp_color;

            if(isset($request->wapp_enable))
            {
              $setting->wapp_enable = '1';
            }
            else
            {
              $setting->wapp_enable = '0';
            }

            if(isset($request->wapp_position))
            {
              $setting->wapp_position = 'left';
            }
            else
            {
              $setting->wapp_position = 'right';
            }

            $setting->save();

            return back()->with('success', trans('flash.UpdatedSuccessfully'));

            
        }
        else
        {
            return back()->with('delete', trans('flash.DemoCannotupdate'));
        }


        

    	
    }
}
