<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GetStarted;
use Image;
use DB;
use Spatie\Permission\Models\Role;


class GetstartedController extends Controller
{
  public function __construct()
  {
  
      $this->middleware('permission:get-started.manage', ['only' => ['show','update']]);
     
  }

    public function show()
    {
      $show = GetStarted::first();
      return view('admin.get_started.edit',compact('show'));
    }

    public function update(Request $request)
    {
      $this->validate($request,[
        'image' => 'image|mimes:jpg,jpeg,png,webp',
    ]);
        $data = GetStarted::first();
         $input = $request->all();
        if($data){

        if ($file = $request->file('image')) {
          if($data->image != null) {
            $content = @file_get_contents(public_path().'/images/getstarted/'.$data->image);
            if ($content) {
              unlink(public_path().'/images/getstarted/'.$data->image);
            }
          }
         

          $optimizeImage = Image::make($file);
          $optimizePath = public_path().'/images/getstarted/';
          $image = time().$file->getClientOriginalName();
          $optimizeImage->save($optimizePath.$image, 72);
      
          $input['image'] = $image;
        }
         
          $data->update($input);
         }
        else
        {
          if($data){

          if ($file = $request->file('image')) {
            if($data->image != null) {
              $content = @file_get_contents(public_path().'/images/getstarted/'.$data->image);
              if ($content) {
                unlink(public_path().'/images/getstarted/'.$data->image);
              }
            }
           
  
            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/images/getstarted/';
            $image = time().$file->getClientOriginalName();
            $optimizeImage->save($optimizePath.$image, 72);
        
            $input['image'] = $image;
          }
        }
          $input = $request->all();

          $data = GetStarted::create($input);
          
          $data->save();

        }

        return back()->with('message',trans('flash.UpdatedSuccessfully'));
    }

}
