<?php

namespace App\Http\Controllers;

use App\JoinInstructor;
use Illuminate\Http\Request;
use Image;
use Spatie\Permission\Models\Role;

class JoinInstructorController extends Controller
{
  public function __construct()
  {
  
      $this->middleware('permission:join-an-instructor.manage', ['only' => ['index','update']]);
      
   
  
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = JoinInstructor::first();
        return view('admin.joininstructor.setting',compact('setting'));
    }

   /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJoinInstructorRequest  $request
     * @param  \App\JoinInstructor  $joinInstructor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
            $this->validate($request,[
              'img' => 'image|mimes:jpg,jpeg,png,webp',
          ]);
        $setting = JoinInstructor::all();
        try {

            $setting = JoinInstructor::first();
            $input = array_filter($request->all());
            if ($setting) {
                $input['text'] = strip_tags($request->text);
                $input['detail'] = strip_tags($request->detail);

                if ($file = $request->file('img')) {
            
                  if($setting->img != null) {
                    $content = @file_get_contents(public_path().'/images/joininstructor/'.$setting->img);
                    if ($content) {
                      unlink(public_path().'/images/joininstructor/'.$setting->img);
                    }
                  }
      
                  $optimizeImage = Image::make($file);
                  $optimizePath = public_path().'/images/joininstructor/';
                  $image = time().$file->getClientOriginalName();
                  $optimizeImage->save($optimizePath.$image, 72);
              

                  $input['img'] = $image;
                  
                }
                $setting->update($input);

            } else {

                $setting = new JoinInstructor;

                $setting['text'] = strip_tags($request->text);
                $setting['detail'] = strip_tags($request->detail);

                if($file = $request->file('img')) 
          {        
            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/images/joininstructor/';
            $image = time().$file->getClientOriginalName();
            $optimizeImage->save($optimizePath.$image, 72);

            $input['img'] = $image;
            
          }
                $setting->create($input);
            }
            return redirect()->route('join.instructor')->with('success', trans('flash.UpdatedSuccessfully'));

        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }
    }

