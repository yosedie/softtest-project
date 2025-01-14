<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use Auth;
use App\Course;
use Session;
use App\User;
use App\Answer;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;


class InstructorQuestionController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:question.view', ['only' => ['index','show']]);
        $this->middleware('permission:question.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:question.edit', ['only' => [ 'update','status']]);
        $this->middleware('permission:question.delete', ['only' => ['destroy', 'bulk_delete']]);
    
    }
    public function index()
    {
    	$questions = Question::where('instructor_id', Auth::User()->id)->get();
    	return view('instructor.question.index',compact('questions' ));
    }

    public function create()
    {
    	$course = Course::where('user_id', Auth::User()->id)->get();
        return view('instructor.question.add',compact("course"));
    }

    public function store(Request $request)
    {
        $data = $this->validate($request,[
            'course_id' => 'required',
            'question' => 'required',
        ]);

        $input = $request->all();
        $data = Question::create($input);
        $data->save(); 

        Session::flash('success',trans('flash.AddedSuccessfully'));
        return redirect('instructorquestion');
    }

    public function show($id)
    {
        $que = Question::find($id);
        $user =  User::all();
        $courses = Course::all();
        return view('instructor.question.edit',compact('que','courses','user'));
    }

    public function update(Request $request, $id)
    {
        $data = $this->validate($request,[
            'question' => 'required',
        ]);
        
        $data = Question::findorfail($id);
        $input = $request->all();
        $data->update($input);
        Session::flash('success',trans('flash.UpdatedSuccessfully'));
        return redirect('instructorquestion');

    }

    public function destroy($id)
    {
        Question::where('id',$id)->delete();
        Answer::where('question_id',$id)->delete();
        return back();
    }
    public function bulk_delete(Request $request)
    {
     
           $validator = Validator::make($request->all(), ['checked' => 'required']);
           if ($validator->fails()) {
            return back()->with('error',trans('Please select field to be deleted.'));
           }
           Question::whereIn('id',$request->checked)->delete();

          return back()->with('error',trans('Selected Question has been deleted.'));

          
   }

    public function status(Request $request)
    {

        $user = Question::find($request->id);
        $user->status = $request->status;
        $user->save();
        return back()->with('success',trans('flash.UpdatedSuccessfully'));
        
    }
}
