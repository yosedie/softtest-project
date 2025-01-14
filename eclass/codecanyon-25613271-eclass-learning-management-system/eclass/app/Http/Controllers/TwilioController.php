<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DotenvEditor;
use App\Setting;
use Spatie\Permission\Models\Role;


class TwilioController extends Controller
{

  public function __construct()
  {
  
      $this->middleware('permission:twilio-setting.manage', ['only' => ['index','update']]);
      
     
  }
	public function index()
	{
        $settings = Setting::first();
		return view('admin.twilio.index', compact('settings'));
	}

    public function update(Request $request)
    {
        $setting = Setting::first();

        $addenv_keys = DotenvEditor::setKeys([
            'TWILIO_SID' => $request->TWILIO_SID,
            'TWILIO_AUTH_TOKEN' => $request->TWILIO_AUTH_TOKEN,
            'TWILIO_NUMBER' => $request->TWILIO_NUMBER
        ]);

        if(isset($request->twilio_enable))
        {
          $setting->twilio_enable = '1';
        }
        else
        {
          $setting->twilio_enable = '0';
        }
        $setting->save();
        $addenv_keys->save();
        return back()->with('success', trans('flash.Settingssaved'));

    }
}
