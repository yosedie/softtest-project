<?php

namespace App\Http\Controllers;

use App\Downloadqr;
use Illuminate\Http\Request;
use Image;
use Spatie\Permission\Models\Role;

class DownloadqrController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:downloadqr.manage', ['only' => ['index','update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $qrsetting = Downloadqr::first();
        return view('admin.qr.setting',compact('qrsetting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVideosettingRequest  $request
     * @param  \App\Videosetting  $videosetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $qrsetting = Downloadqr::all();
        try {

            $qrsetting = Downloadqr::first();
            $input = array_filter($request->all());
            if ($qrsetting) {

                if ($file = $request->file('image')) {
            
                    if($qrsetting->image != null) {
                      $content = @file_get_contents(public_path().'/images/qr/'.$qrsetting->image);
                      if ($content) {
                        unlink(public_path().'/images/qr/'.$qrsetting->image);
                      }
                    }
        
                    $optimizeImage = Image::make($file);
                    $optimizePath = public_path().'/images/qr/';
                    $image = time().$file->getClientOriginalName();
                    $optimizeImage->save($optimizePath.$image, 72);
                
  
                    $input['image'] = $image;
                    
                  }
                  if ($file = $request->file('image2')) {
            
                    if($qrsetting->image2 != null) {
                      $content = @file_get_contents(public_path().'/images/qr/'.$qrsetting->image2);
                      if ($content) {
                        unlink(public_path().'/images/qr/'.$qrsetting->image2);
                      }
                    }
        
                    $optimizeImage = Image::make($file);
                    $optimizePath = public_path().'/images/qr/';
                    $image = time().$file->getClientOriginalName();
                    $optimizeImage->save($optimizePath.$image, 72);
                    $input['image2'] = $image;
                    
                  }
                  if ($file = $request->file('demo_image')) {
            
                    if($qrsetting->demo_image != null) {
                      $content = @file_get_contents(public_path().'/images/qr/'.$qrsetting->demo_image);
                      if ($content) {
                        unlink(public_path().'/images/qr/'.$qrsetting->demo_image);
                      }
                    }
        
                    $optimizeImage = Image::make($file);
                    $optimizePath = public_path().'/images/qr/';
                    $image = time().$file->getClientOriginalName();
                    $optimizeImage->save($optimizePath.$image, 72);
                    $input['demo_image'] = $image;
                    
                  }
                $qrsetting->update($input);

            } else {

                $qrsetting = new Downloadqr;
                if($file = $request->file('image')) 
                {        
                  $optimizeImage = Image::make($file);
                  $optimizePath = public_path().'/images/qr/';
                  $image = time().$file->getClientOriginalName();
                  $optimizeImage->save($optimizePath.$image, 72);
      
                  $input['image'] = $image;
                  
                }
                if($file = $request->file('image2')) 
                {        
                  $optimizeImage = Image::make($file);
                  $optimizePath = public_path().'/images/qr/';
                  $image = time().$file->getClientOriginalName();
                  $optimizeImage->save($optimizePath.$image, 72);
      
                  $input['image2'] = $image;
                  
                }
                if ($file = $request->file('demo_image')) {
            
                  if($qrsetting->demo_image != null) {
                    $content = @file_get_contents(public_path().'/images/qr/'.$qrsetting->demo_image);
                    if ($content) {
                      unlink(public_path().'/images/qr/'.$qrsetting->demo_image);
                    }
                  }
      
                  $optimizeImage = Image::make($file);
                  $optimizePath = public_path().'/images/qr/';
                  $image = time().$file->getClientOriginalName();
                  $optimizeImage->save($optimizePath.$image, 72);
                  $input['demo_image'] = $image;
                  
                }
                $qrsetting->create($input);
            }
            return redirect()->route('mobileqr')->with('success', trans('flash.UpdatedSuccessfully'));

        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }
}
