<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;


class CourseReviewController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:course-reviews.view', ['only' => ['index',' show','rejectedview']]);
        $this->middleware('permission:course-reviews.create', ['only' => ['featured']]);
        $this->middleware('permission:course-reviews.edit', ['only' => [ 'update','status']]);
        $this->middleware('permission:course-reviews.delete', ['only' => [ 'bulk_delete']]);
    
    }
    public function index()
    {
    	$course = Course::where('user_id', '!=' ,Auth::User()->id)->get();
        return view('admin.course_review.index',compact('course'));
    }

    public function show($id)
    {
    	$course = Course::where('id' ,$id)->first();
    	return view('admin.course_review.view', compact('course'));

    }

    public function update(Request $request, $id)
    {
        $course = Course::findorfail($id);
        

        if(isset($request->status))
        {

        	Course::where('id', $id)
                    ->update(['reject_txt' => NULL, 'status' => 1]);
            
        }
        else
        { 
        	Course::where('id', $id)
                    ->update(['reject_txt' => $request->reject_txt, 'status' => 0]);
            
        }

        return redirect('coursereview');
    	
    }

    public function rejected()
    {
        //return 'yes';
         $course = Course::where('user_id', Auth::user()->id)->where('reject_txt', '!=', NULL)->get();
        return view('instructor.rejected.index', compact('course'));

    }

    public function rejectedview($id)
    {
        //return 'yes';
         $course = Course::where('id', $id)->first();
        return view('instructor.rejected.view', compact('course'));

    }
    public function bulk_delete(Request $request)
    {
     
           $validator = Validator::make($request->all(), ['checked' => 'required']);
           if ($validator->fails()) {
            return back()->with('error',trans('Please select field to be deleted.'));
           }
           Course::whereIn('id',$request->checked)->delete();

          return back()->with('error',trans('Selected Course has been deleted.'));

          
   }
    public function status(Request $request)
   {

       $user = Course::find($request->id);
       $user->status = $request->status;
       $user->save();
       return back()->with('success',trans('flash.UpdatedSuccessfully'));
       
       
   }
   public function featured(Request $request)
   {

       $user = Course::find($request->id);
       $user->featured = $request->featured;
       $user->save();
       return back()->with('success',trans('flash.UpdatedSuccessfully'));
       
       
   }


}
