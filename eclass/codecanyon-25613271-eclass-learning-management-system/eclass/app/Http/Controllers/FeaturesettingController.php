<?php

namespace App\Http\Controllers;

use App\Featuresetting;
use Illuminate\Http\Request;
use Image;

class FeaturesettingController extends Controller
{
  public function __construct()
    {
        $this->middleware('permission:admin.featuresetting.manage', ['only' => ['index','update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $feasetting = Featuresetting::first();
        return view('admin.feature.setting',compact('feasetting'));
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
          $this->validate($request,[
            'image' => 'image|mimes:jpg,jpeg,png,webp',
        ]);
        $feasetting = Featuresetting::all();
        try {

            $feasetting = Featuresetting::first();
            $input = array_filter($request->all());
            if ($feasetting) {
                $input['title'] = strip_tags($request->title);
                $feasetting['detail'] = strip_tags($request->detail);

                if ($file = $request->file('image')) {
            
                    if($feasetting->image != null) {
                      $content = @file_get_contents(public_path().'/images/feature/'.$feasetting->image);
                      if ($content) {
                        unlink(public_path().'/images/feature/'.$feasetting->image);
                      }
                    }
        
                    $optimizeImage = Image::make($file);
                    $optimizePath = public_path().'/images/feature/';
                    $image = time().$file->getClientOriginalName();
                    $optimizeImage->save($optimizePath.$image, 72);
                
  
                    $input['image'] = $image;
                    
                  }
                $feasetting->update($input);

            } else {

                $feasetting = new Featuresetting();

                $feasetting['title'] = strip_tags($request->title);
                $feasetting['detail'] = strip_tags($request->detail);
                if($file = $request->file('image')) 
                {        
                  $optimizeImage = Image::make($file);
                  $optimizePath = public_path().'/images/feature/';
                  $image = time().$file->getClientOriginalName();
                  $optimizeImage->save($optimizePath.$image, 72);
      
                  $input['image'] = $image;
                  
                }
                $feasetting->create($input);
            }
            return redirect()->route('feature.settings')->with('success', trans('flash.UpdatedSuccessfully'));

        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }
}
