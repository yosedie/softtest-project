<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use DB;
use Validator;

class IPBlockController extends Controller
{
    public function view()
    {
    	$settings = Setting::first();
    	return view('admin.ipblock.edit', compact('settings'));
    }

    public function update(Request $request)
    {


        $setting = Setting::first();

	    $setting->ipblock = $request->ipblock;

	    $setting->save();

    	return back();
    }
}
