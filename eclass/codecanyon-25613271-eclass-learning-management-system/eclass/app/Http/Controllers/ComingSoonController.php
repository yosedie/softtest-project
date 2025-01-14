<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ComingSoon;
use Session;
use Spatie\Permission\Models\Role;

class ComingSoonController extends Controller
{
   
    public function show()
    {
    	$comingsoon = ComingSoon::first();
		return view('admin.coming_soon.edit',compact('comingsoon'));
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'bg_image' => 'mimes:jpg,jpeg,png,bmp,tiff,webp'
        ]);

    	$items = ComingSoon::first();

        $input = $request->all();

        if(isset($items))
        {
            if ($file = $request->file('bg_image'))
            {
                $image_file = @file_get_contents(public_path().'/images/comingsoon/'.$items->bg_image);

                if($image_file)
                {
                    unlink('images/comingsoon/'.$items->bg_image);
                }
                $name = time().$file->getClientOriginalName();
                $file->move('images/comingsoon', $name);
                $input['bg_image'] = $name;
            }

            if(config('app.demolock') == 0){

                if(isset($request->enable)){
                    $input['enable'] = '1';
                }else{
                    $input['enable'] = '0';
                }
            }
           

            $items->update($input);
        }
        else
        {
            if ($file = $request->file('bg_image'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('images/comingsoon', $name);
                $input['bg_image'] = $name;
            }

            if(config('app.demolock') == 0){

                if($request->enable == 'on')
                {
                    $input['enable'] = '1';
                }
                else
                {
                    $input['enable'] = '0';
                }
            }
            
            $data = ComingSoon::create($input);
          
            $data->save();
            
        }
        Session::flash('success', trans('flash.UpdatedSuccessfully'));
        return redirect('comingsoon');
        // return back()->with('message',trans('flash.UpdatedSuccessfully'));
    }

    public function comingsoonpage()
    {
        $data = ComingSoon::first();
        return view('front.coming_soon.show',compact('data'));
    }
}
