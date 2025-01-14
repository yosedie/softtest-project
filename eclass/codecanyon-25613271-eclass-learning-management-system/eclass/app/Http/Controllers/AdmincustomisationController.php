<?php

namespace App\Http\Controllers;

use App\Admincustomisation;
use Illuminate\Http\Request;

class AdmincustomisationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin.costomisation.manage', ['only' => ['index','update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $color = Admincustomisation::first();
        return view('admin.admincustomisation.view', compact('color'));
    }
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admincustomisation  $colorOption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = Admincustomisation::first();

        if(config('app.demolock') == 0){

            $input = $request->all();

            if(isset($data))
            {
                $data->update($input);
            }
            else
            {
                $data = Admincustomisation::create($input);
                $data->save();
            }

            return back()->with('success',trans('flash.UpdatedSuccessfully'));

        }
        else
        {
            return back()->with('delete', trans('flash.DemoCannotupdate'));
        }

    }
    public function reset()
    {

        \Artisan::call('db:seed --class=AdmincustomisationsTableSeeder');

        return back()->with('success',trans('flash.UpdatedSuccessfully'));
        
    }
}
