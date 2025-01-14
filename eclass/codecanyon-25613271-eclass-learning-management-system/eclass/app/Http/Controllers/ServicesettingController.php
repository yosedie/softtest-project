<?php

namespace App\Http\Controllers;

use App\Servicesetting;
use Illuminate\Http\Request;
use Image;

class ServicesettingController extends Controller
{
  public function __construct()
  {
      $this->middleware('permission:serviceSetting.manage', ['only' => ['index','update']]);
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $sersetting = Servicesetting::first();
        return view('admin.service.setting',compact('sersetting'));
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
      $request->validate([
        "image" => "image|mimes:jpg,jpeg,png,webp",
       ]);
        $sersetting = Servicesetting::all();
        try {

            $sersetting = Servicesetting::first();
            $input = array_filter($request->all());
            if ($sersetting) {
                $input['title'] = strip_tags($request->title);
                $sersetting['detail'] = strip_tags($request->detail);

                if ($file = $request->file('image')) {
            
                    if($sersetting->image != null) {
                      $content = @file_get_contents(public_path().'/images/services/'.$sersetting->image);
                      if ($content) {
                        unlink(public_path().'/images/services/'.$sersetting->image);
                      }
                    }
        
                    $optimizeImage = Image::make($file);
                    $optimizePath = public_path().'/images/services/';
                    $image = time().$file->getClientOriginalName();
                    $optimizeImage->save($optimizePath.$image, 72);
                
  
                    $input['image'] = $image;
                    
                  }
                $sersetting->update($input);

            } else {

                $sersetting = new Servicesetting();

                $sersetting['title'] = strip_tags($request->title);
                $sersetting['detail'] = strip_tags($request->detail);
                if($file = $request->file('image')) 
                {        
                  $optimizeImage = Image::make($file);
                  $optimizePath = public_path().'/images/services/';
                  $image = time().$file->getClientOriginalName();
                  $optimizeImage->save($optimizePath.$image, 72);
      
                  $input['image'] = $image;
                  
                }
                $sersetting->create($input);
            }
            return redirect()->route('service.settings')->with('success', trans('flash.UpdatedSuccessfully'));

        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

}
