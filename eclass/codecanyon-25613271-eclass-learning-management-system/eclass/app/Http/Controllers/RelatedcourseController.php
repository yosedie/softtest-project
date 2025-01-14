<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\RelatedCourse;
use App\Course;
use Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;


class RelatedcourseController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:related-courses.view', ['only' => ['index','show']]);
        $this->middleware('permission:related-courses.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:related-courses.edit', ['only' => ['update','relatedcoursestatus']]);
        $this->middleware('permission:related-courses.delete', ['only' => ['destroy', 'bulk_delete']]);
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $related = RelatedCourse::all();
        return view('admin.course.relatedcourse.index',compact("related"));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $relatedcourse = Course::all();
        return view('admin.course.relatedcourse.insert',compact('relatedcourse')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $related = RelatedCourse::where('main_course_id', $request->main_course_id )->where('course_id', $request->course_id )->first();

        if(!empty($related)){

            return back()->with('delete',trans('flash.AlreadyExist'));
            
        }
        else{
            DB::table('related_courses')->insert(
            array(

                'course_id' => $request->course_id,
                'main_course_id' => $request->main_course_id,
                'user_id' => $request->user_id,
                'status' => isset($request->status) ? 1 : 0,
                'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                )
            );
            return back()->with('success',trans('flash.AddedSuccessfully'));  
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\relatedcourse  $relatedcourse
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cate = RelatedCourse::find($id);
        
        $courses = Course::all();
        return view('admin.course.relatedcourse.edit',compact('cate','courses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\relatedcourse  $relatedcourse
     * @return \Illuminate\Http\Response
     */
    public function edit(relatedcourse $relatedcourse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\relatedcourse  $relatedcourse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        DB::table('related_courses')->where('id',$id)
            ->update([

            'course_id' => $request->course_id,
            'main_course_id' => $request->main_course_id,
            'user_id' => $request->user_id,
            'status' => isset($request ->status) ? 1 : 0,
            'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),

        ]);

        Session::flash('success', trans('flash.UpdatedSuccessfully'));
        

        return redirect()->route('course.show',$request->main_course_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\relatedcourse  $relatedcourse
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        DB::table('related_courses')->where('id',$id)->delete();
     
        return back();
    }
    public function bulk_delete(Request $request)
    {

        
     
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);

        if ($validator->fails()) {

            return back()->with('delete', 'Pleaseselectdelete');
        }
        else{
            RelatedCourse::whereIn('id',$request->checked)->delete();
            
            Session::flash('success',trans('Deleted Successfully'));
            return redirect()->back();
            
        }
           
          
    }


    public function relatedcoursestatus($id)
    {
        $status = RelatedCourse::findorfail($id);

        if($status->status == 0)
        {
            DB::table('related_courses')->where('id','=',$id)->update(['status' => "1"]); 
            return back()->with('success','Status changed to active !');
        }
        else
        {
            DB::table('related_courses')->where('id','=',$id)->update(['status' => "0"]);
            return back()->with('delete','Status changed to deactive !');
        }
    }
}
