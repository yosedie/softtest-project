<?php

namespace App\Http\Controllers;

use App\MobileSetting;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class MobileSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:mobilesetting.manage', ['only' => ['index','update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $msetting = MobileSetting::first();
        return view('admin.mobile.setting',compact('msetting'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHomesettingRequest  $request
     * @param  \App\Homesetting  $homesetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }
        try {

            $msetting = MobileSetting::first();
            if ($msetting) {
                $msetting->setting_enable = isset($request->setting_enable) ? 1 : 0;
                $msetting->save();

            } else {

                $msetting = new MobileSetting;
                $msetting->setting_enable = isset($request->setting_enable) ? 1 : 0;
                $msetting->save();
            }
            return redirect()->route('mobile.setting')->with('success', trans('flash.UpdatedSuccessfully'));

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
