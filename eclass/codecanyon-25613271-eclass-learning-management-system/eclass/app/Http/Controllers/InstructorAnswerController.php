<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;
use Auth;
use App\Course;
use App\Question;
use Session;
use App\User;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;


class InstructorAnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:answer.view', ['only' => ['index','show']]);
        $this->middleware('permission:answer.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:answer.edit', ['only' => ['edit', 'update','status']]);
        $this->middleware('permission:answer.delete', ['only' => ['destroy', 'bulk_delete']]);
    
    }
    public function index()
    {
    	$answers = Answer::where('instructor_id', Auth::User()->id)->get();
    	return view('instructor.answer.index',compact('answers'));
    }

    public function create()
    {
    	$course = Course::where('user_id', Auth::User()->id)->get();
        $questions = Question::where('user_id', Auth::User()->id)->get();
        return view('instructor.answer.add',compact('course', 'questions'));
    }

    public function store(Request $request)
    {
    	$data = $this->validate($request,[
            'course_id' => 'required',
            'answer' => 'required',
        ]);

        $input = $request->all();
        $data = Answer::create($input);
        $data->save(); 

        Session::flash('success',trans('flash.AddedSuccessfully'));
        return redirect('instructoranswer');

    }

    public function show($id)
    {
        $answer = Answer::find($id);
        $user =  User::all();
        $courses = Course::all();
        return view('instructor.answer.edit',compact('answer','courses','user'));
    }

    public function update(Request $request, $id)
    {
        $data = $this->validate($request,[
            'answer' => 'required',
        ]);
        
        $data = Answer::findorfail($id);
        $input = $request->all();
        $data->update($input);

        Session::flash('success',trans('flash.UpdatedSuccessfully'));
        return redirect('instructoranswer');

    }

    public function destroy($id)
    {
        Answer::where('id',$id)->delete();
        return back();
    }
    public function bulk_delete(Request $request)
    {
     
           $validator = Validator::make($request->all(), ['checked' => 'required']);
           if ($validator->fails()) {
            return back()->with('error',trans('Please select field to be deleted.'));
           }
           Answer::whereIn('id',$request->checked)->delete();

          return back()->with('error',trans('Selected Answer has been deleted.'));

          
   }

    public function status(Request $request)
    {

        $user = Answer::find($request->id);
        $user->status = $request->status;
        $user->save();
        return back()->with('success',trans('flash.UpdatedSuccessfully'));
        
        
    }

}
