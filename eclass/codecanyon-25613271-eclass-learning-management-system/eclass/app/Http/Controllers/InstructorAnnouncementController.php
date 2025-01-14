<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Announcement;
use App\Course;
use Auth;
use Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;


class InstructorAnnouncementController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:announcement.view', ['only' => ['index','show']]);
        $this->middleware('permission:announcement.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:announcement.edit', ['only' => ['update']]);
        $this->middleware('permission:announcement.delete', ['only' => ['destroy', 'bulk_delete']]);
    
    }
    public function index()
    {
    	$announs = Announcement::where('user_id', Auth::User()->id)->get();
    	return view('instructor.announcement.index', compact('announs'));
    }

    public function create()
    {
    	$course = Course::where('user_id', Auth::User()->id)->get();
    	return view('instructor.announcement.create', compact('course'));
    }

    public function store(Request $request)
    {
       $data = $this->validate($request,[
            'course_id' => 'required',
            'announsment' => 'required',
        ]);

        $input = $request->all();
        $data = Announcement::create($input);

        if(isset($request->status))
        {
            $data->status = '1';
        }
        else
        {
            $data->status = '0';
        }

        $data->save(); 

        Session::flash('success',trans('flash.AddedSuccessfully'));
        return redirect('instructor/announcement'); 
    }

    public function show($id)
    {
        $course = Course::where('user_id', Auth::User()->id)->get();
        $announs = Announcement::find($id);
        return view('instructor.announcement.edit', compact('course', 'announs'));

    }

    public function edit()
    {
        //
    }

    public function update(Request $request, $id)
    {
        $data = $this->validate($request,[
            'announsment' => 'required',
        ]);
        
        $data = Announcement::findorfail($id);
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
        return redirect('instructor/announcement');

    }

    public function destroy($id)
    {
        Announcement::where('id',$id)->delete();
        return back();
    }

    public function bulk_delete(Request $request)
    {
     
        $validator = Validator::make($request->all(), ['checked' => 'required']);

        if ($validator->fails()) {
            return back()->with('error',trans('Please select field to be deleted.'));
        }

        Announcement::whereIn('id',$request->checked)->delete();

        return back()->with('error',trans('Selected Announcement has been deleted.'));

          
   }
}
