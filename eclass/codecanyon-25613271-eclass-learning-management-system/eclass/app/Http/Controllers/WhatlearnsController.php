<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\WhatLearn;
use App\Course;
use Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;


class WhatlearnsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:what-learn.view', ['only' => ['show','index']]);
        $this->middleware('permission:what-learn.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:what-learn.edit', ['only' => ['edit', 'update','status']]);
        $this->middleware('permission:what-learn.delete', ['only' => ['destroy', 'bulk_delete']]);
    }
    public function index()
    {
        $whatlearns = WhatLearn::all();
        return view('admin.course.whatlearns.index',compact("whatlearns"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $whatlearns = Course::all();
        return view('admin.course.Whatlearns.insert',compact('whatlearns')); 
   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $data = $this->validate($request,[
            'detail' => 'required|max:300',
        ]);

        $input = $request->all();
        $data = WhatLearn::create($input);

        if(isset($request->status))
        {
            $data->status = '1';
        }
        else
        {
            $data->status = '0';
        }
        
        $data->save();

        Session::flash('success', trans('flash.AddedSuccessfully'));
        return redirect()->route('course.show',$request->course_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Whatlearns  $whatlearns
     * @return \Illuminate\Http\Response
     */

    public function show( $id)
    {
        $cate = WhatLearn::find($id);
        $courses = Course::all();

        return view('admin.course.whatlearns.edit',compact('cate','courses')); 

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Whatlearns  $whatlearns
     * @return \Illuminate\Http\Response
     */

    public function edit(Whatlearns $whatlearns)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Whatlearns  $whatlearns
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request,$id)
    {
        $data = $this->validate($request,[
            'detail' => 'required|max:300',
        ]);

        $data = WhatLearn::findorfail($id);
        $input = $request->all();

        if(isset($request->status))
        {
            $input['status'] = '1';
        }
        else
        {
            $input['status'] = '0';
        }

        $data->update($input);

        return redirect()->route('course.show',$request->course_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Whatlearns  $whatlearns
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        DB::table('what_learns')->where('id',$id)->delete();
        return back();
    }
    public function bulk_delete(Request $request)
    {

     
     
           $validator = Validator::make($request->all(), ['checked' => 'required']);
           if ($validator->fails()) {
            return back()->with('error',trans('Please select field to be deleted.'));
           }
           WhatLearn::whereIn('id',$request->checked)->delete();

          return back()->with('error',trans('Selected WhatLearn has been deleted.'));

          
   }
}
