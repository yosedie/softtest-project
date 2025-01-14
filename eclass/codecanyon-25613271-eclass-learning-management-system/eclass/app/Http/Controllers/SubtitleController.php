<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subtitle;

class SubtitleController extends Controller
{
    public function post(Request $request,$id)
    {
    	if($request->has('sub_t')){
            foreach($request->file('sub_t') as $key=> $image)
            {
              
                $name = $image->getClientOriginalName();
                $image->move(public_path().'/subtitles/', $name);  
               
                $form= new Subtitle();
                $form->sub_lang = $request->sub_lang[$key];
                $form->sub_t=$name;
                $form->c_id = $id;
                $form->save(); 
            }
        }

        return back()->with('success',trans('flash.AddedSuccessfully'));
    }

    public function delete($id)
    {
    	$record = Subtitle::findorfail($id);
    	 if($record->sub_t !="")
         {
            $image_file = @file_get_contents(public_path().'/subtitles/'.$record->sub_t);

            if($image_file)
            {
         	  unlink('subtitles/'.$record->sub_t);
            }
         }
         
    	$record->delete();

    	return back()->with('delete',trans('flash.UpdatedSuccessfully'));
    }
}
