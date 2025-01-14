<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CourseReport;
use DB;
use Auth;
use Session;
use Spatie\Permission\Models\Role;

class CourseReportController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:reported-course.view', ['only' => ['index','show']]);
        $this->middleware('permission:reported-course.create', ['only' => [ 'store']]);
        $this->middleware('permission:reported-course.edit', ['only' => ['update']]);
        $this->middleware('permission:reported-course.delete', ['only' => ['destroy']]);
    
    }

	public function index()
    {
    	$items = CourseReport::orderBy('id','desc')->get();
    	return view('admin.report_course.index',compact('items'));
    }

    public function create()
    {

    }

    public function store(Request $request, $id)
    {
       
    	DB::table('course_reports')->insert(
            array(
                'course_id'=>$id,
                'user_id'=>Auth::User()->id,
                'title'=>$request->title,
                'email'=>$request->email,
                'detail'=>$request->detail,
                'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            )
        );

        Session::flash('success',trans('flash.ReportSuccessfully'));
        return back();
    }

    public function show($id)
    {
        $show = CourseReport::where('id', $id)->first();
        return view('admin.report_course.edit',compact('show'));
    }

    public function edit($id)
    {
    	
    }

    public function update(Request $request, $id)
    {
    	$data = CourseReport::findorfail($id);
    	$input = $request->all();
    	$data ->update($input);

        Session::flash('success',trans('flash.UpdatedSuccessfully'));
    	return redirect("admin/report/view");
    }

    public function destroy($id)
    {
        DB::table('course_reports')->where('id',$id)->delete();
        Session::flash('delete',trans('flash.DeletedSuccessfully'));
        return redirect("admin/report/view");
    }
}
