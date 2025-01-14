<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourseText;
use DB;
use Spatie\Permission\Models\Role;

class CoursetextController extends Controller
{
   
    public function show()
    {
        $show = CourseText::first();
        return view('admin.course_text.edit',compact('show'));
    }

    public function update(Request $request)
    {

        $data = $this->validate($request,[
            'heading' => 'required|max:50',
            'sub_heading'=>'required|max:100',
        ]);

    	$data = CourseText::first();

        $input = $request->all();

        if(isset($data))
        {
            $data->update($input);
        }
        else
        {
            $data = CourseText::create($input);
          
            $data->save();
        }

		return back()->with('message',trans('flash.UpdatedSuccessfully'));
    }

}
