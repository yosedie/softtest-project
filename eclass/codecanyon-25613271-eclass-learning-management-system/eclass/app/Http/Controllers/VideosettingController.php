<?php

namespace App\Http\Controllers;

use App\Videosetting;
use Illuminate\Http\Request;
use Image;
use Spatie\Permission\Models\Role;


class VideosettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
    
        $this->middleware('permission:video-setting.manage', ['only' => ['index','update']]);
       
    
    }
    public function index()
    {
        $videosetting = Videosetting::first();
        return view('admin.videosetting.index',compact('videosetting'));
    }

   
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVideosettingRequest  $request
     * @param  \App\Videosetting  $videosetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Videosetting $videosetting)
    {
        
        $videosetting = Videosetting::all();
        try {

            $videosetting = Videosetting::first();
            $input = array_filter($request->all());
            if ($videosetting) {
                $input['text'] = strip_tags($request->text);
                $videosetting['url'] = strip_tags($request->url);

                if ($file = $request->file('image')) {
            
                    if($videosetting->image != null) {
                      $content = @file_get_contents(public_path().'/images/videosetting/'.$videosetting->image);
                      if ($content) {
                        unlink(public_path().'/images/videosetting/'.$videosetting->image);
                      }
                    }
        
                    $optimizeImage = Image::make($file);
                    $optimizePath = public_path().'/images/videosetting/';
                    $image = time().$file->getClientOriginalName();
                    $optimizeImage->save($optimizePath.$image, 72);
                
  
                    $input['image'] = $image;
                    
                  }
                $videosetting->update($input);

            } else {

                $videosetting = new Videosetting;

                $videosetting['text'] = strip_tags($request->text);
                $videosetting['url'] = strip_tags($request->url);
                if($file = $request->file('image')) 
                {        
                  $optimizeImage = Image::make($file);
                  $optimizePath = public_path().'/images/videosetting/';
                  $image = time().$file->getClientOriginalName();
                  $optimizeImage->save($optimizePath.$image, 72);
      
                  $input['image'] = $image;
                  
                }
                $videosetting->create($input);
            }
            return redirect()->route('videosetting')->with('success', trans('flash.UpdatedSuccessfully'));

        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Videosetting  $videosetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Videosetting $videosetting)
    {
        //
    }
}
