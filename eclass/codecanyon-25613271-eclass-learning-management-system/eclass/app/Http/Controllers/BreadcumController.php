<?php

namespace App\Http\Controllers;

use App\Breadcum;
use Illuminate\Http\Request;
use Image;
use Spatie\Permission\Models\Role;

class BreadcumController extends Controller
{
  public function __construct()
  {
     $this->middleware('permission:breadcum-setting.manage', ['only' => ['index','update']]);
      
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Breadcum::first();
        return view('admin.breadcum.setting',compact('setting'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBreadcumRequest  $request
     * @param  \App\Breadcum  $breadcum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
          $setting = $this->validate($request,[
            'img' => 'image',
            'img' => 'mimes:jpg,jpeg,png,webp',
        ]);
        $setting = Breadcum::all();
        try {

            $setting = Breadcum::first();
            $input = array_filter($request->all());
            if ($setting) {
                $input['text'] = strip_tags($request->text);
               

                if ($file = $request->file('img')) {
            
                  if($setting->img != null) {
                    $content = @file_get_contents(public_path().'/images/breadcum/'.$setting->img);
                    if ($content) {
                      unlink(public_path().'/images/breadcum/'.$setting->img);
                    }
                  }
      
                  $optimizeImage = Image::make($file);
                  $optimizePath = public_path().'/images/breadcum/';
                  $image = time().$file->getClientOriginalName();
                  $optimizeImage->save($optimizePath.$image, 72);
              

                  $input['img'] = $image;
                  
                }
                $setting->update($input);

            } else {

                $setting = new Breadcum;

                $setting['text'] = strip_tags($request->text);

                if($file = $request->file('img')) 
          {        
            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/images/breadcum/';
            $image = time().$file->getClientOriginalName();
            $optimizeImage->save($optimizePath.$image, 72);

            $input['img'] = $image;
            
          }
                $setting->create($input);
            }
            return redirect()->route('breadcum.setting')->with('success', trans('flash.UpdatedSuccessfully'));

        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }
    }

