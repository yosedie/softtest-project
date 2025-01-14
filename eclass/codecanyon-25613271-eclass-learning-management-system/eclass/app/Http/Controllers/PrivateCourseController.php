<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PrivateCourse;
use App\Course;
use App\User;
use Session;
use DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;


class PrivateCourseController extends Controller
{
    public function __construct()
    {
        
    
        $this->middleware('permission:private-course.view', ['only' => ['index','show']]);
        $this->middleware('permission:private-course.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:private-course.edit', ['only' => ['update','status']]);
        $this->middleware('permission:private-course.delete', ['only' => ['destroy', 'bulk_delete']]);
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $private_courses = PrivateCourse::get();
        return view('admin.private_course.index', compact('private_courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $courses = Course::get();
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.private_course.create', compact('courses', 'users'));
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
            'course_id' => 'required',
            'user_id' => 'required',
        ]);


        $input = $request->all();

        $input['status'] = isset($request->status)  ? 1 : 0;
        $data = PrivateCourse::create($input);
        
        $data->save();

        Session::flash('success',trans('flash.AddedSuccessfully'));
        return redirect('private-course');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PreviousPaper  $previousPaper
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $courses = Course::get();
        $users = User::where('role', '!=', 'admin')->get();
        $private = PrivateCourse::find($id);
        return view('admin.private_course.edit',compact('private', 'courses', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PreviousPaper  $previousPaper
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PreviousPaper  $previousPaper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validate($request,[
            'course_id' => 'required',
        ]);

        $data = PrivateCourse::findorfail($id);
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

        Session::flash('success',trans('flash.UpdatedSuccessfully')); 
        return redirect('private-course');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PreviousPaper  $previousPaper
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('private_course')->where('id',$id)->delete();
        return back(); 
    }
    public function status(Request $request)
    {

        $data = PrivateCourse::find($request->id);
        $data->status = $request->status;
        $data->save();
        return back()->with('success',trans('flash.UpdatedSuccessfully'));
        
        
    }
    public function bulk_delete(Request $request)
    {
            $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
                return back()->with('warning', 'Atleast one item is required to be checked');
               
            }
            else{
              PrivateCourse::whereIn('id',$request->checked)->delete();
                
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }
    }

}
