<?php

namespace App\Http\Controllers;

use App\Upi;
use Illuminate\Http\Request;

class UpiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $upi = Upi::first();
        return view('admin.upi.setting',compact('upi'));
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

            $upi = Upi::first();
            if ($upi) {
                $upi->status = isset($request->status) ? 1 : 0;
                $upi['name'] = strip_tags($request->name);
                $upi['upiid'] = strip_tags($request->upiid);
                $upi->save();

            } else {

                $upi = new Upi;
                $upi->status = isset($request->status) ? 1 : 0;
                $upi['name'] = strip_tags($request->name);
                $upi['upiid'] = strip_tags($request->upiid);
                $upi->save();
            }
            return redirect()->route('upi')->with('success', trans('flash.UpdatedSuccessfully'));

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
