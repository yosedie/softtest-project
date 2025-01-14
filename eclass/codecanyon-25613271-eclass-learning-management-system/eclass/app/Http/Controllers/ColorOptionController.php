<?php

namespace App\Http\Controllers;

use App\ColorOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ColorOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ini_set("zlib.output_compression", "Off");
        
        $color = ColorOption::first();
        return view('admin.coloroption.view', compact('color'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ColorOption  $colorOption
     * @return \Illuminate\Http\Response
     */
    public function show(ColorOption $colorOption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ColorOption  $colorOption
     * @return \Illuminate\Http\Response
     */
    public function edit(ColorOption $colorOption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ColorOption  $colorOption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        ini_set("zlib.output_compression", "Off");
        
        $data = ColorOption::first();

        if(config('app.demolock') == 0){

            $input = $request->all();

            if(isset($data))
            {
                $data->update($input);
            }
            else
            {
                $data = ColorOption::create($input);
                $data->save();
            }

            return back()->with('success',trans('flash.UpdatedSuccessfully'));

        }
        else
        {
            return back()->with('delete', trans('flash.DemoCannotupdate'));
        }

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ColorOption  $colorOption
     * @return \Illuminate\Http\Response
     */
    public function destroy(ColorOption $colorOption)
    {
        //
    }


    public function reset()
    {

        \Artisan::call('db:seed --class=ColorOptionsTableSeeder');

        return back()->with('success',trans('flash.UpdatedSuccessfully'));
        
    }
}
