<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\QuizAnswer;
use App\QuizTopic;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class QuizTopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:quiz-topic.view', ['only' => ['index','show','view']]);
        $this->middleware('permission:quiz-topic.create', ['only' => [ 'store']]);
        $this->middleware('permission:quiz-topic.edit', ['only' => ['update','quiztopicstatus','quiztopicagainstatus']]);
        $this->middleware('permission:quiz-topic.delete', ['only' => ['destroy','delete', 'bulk_delete']]);
        $this->middleware('permission:report.quiz-report.manage', ['only' => ['quizreport']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = QuizTopic::orderBy('position')->get();
        return view('admin.course.quiztopic.index', compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input = $request->all();

        $request->validate([
            'title' => 'required|string',
            'per_q_mark' => 'required',

        ]);

        if (isset($request->quiz_price)) {
            $request->validate([
                'amount' => 'required',
            ]);
        }

        if (isset($request->type)) {
            $input['type'] = '1';
        } else {
            $input['type'] = null;
        }

        if (isset($request->quiz_price)) {
            $input['amount'] = $request->amount;
        } else {
            $input['amount'] = null;
        }

        if (isset($request->show_ans)) {
            $input['show_ans'] = "1";
        } else {
            $input['show_ans'] = "0";
        }

        if (isset($request->status)) {
            $input['status'] = "1";
        } else {
            $input['status'] = "0";
        }

        if (isset($request->quiz_again)) {
            $input['quiz_again'] = "1";
        } else {
            $input['quiz_again'] = "0";
        }

        $quiz = QuizTopic::create($input);

        return back()->with('success', 'Topic has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\QuizTopic  $quizTopic
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topic = QuizTopic::where('id', $id)->first();
        return view('admin.course.quiztopic.edit', compact('topic'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QuizTopic  $quizTopic
     * @return \Illuminate\Http\Response
     */
    public function edit(QuizTopic $quizTopic)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QuizTopic  $quizTopic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([

            'title' => 'required|string',
            'per_q_mark' => 'required',

        ]);

        if (isset($request->pricechk)) {
            $request->validate([
                'amount' => 'required',
            ]);
        }

        $topic = QuizTopic::findOrFail($id);

        $topic->title = $request->title;
        $topic->description = $request->description;
        $topic->per_q_mark = $request->per_q_mark;
        $topic->timer = isset($request->timer) ? $request->timer : null;
        $topic->due_days = $request->due_days;

        if (isset($request->type)) {
            $topic['type'] = '1';
        } else {
            $topic['type'] = null;
        }

        if (isset($request->status)) {
            $topic['status'] = "1";
        } else {
            $topic['status'] = "0";
        }

        if (isset($request->quiz_again)) {
            $topic['quiz_again'] = "1";
        } else {
            $topic['quiz_again'] = "0";
        }

        $topic->save();

        return redirect()->route('course.show', $topic->course_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QuizTopic  $quizTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $topic = QuizTopic::findOrFail($id);

        $topic->delete();

        Quiz::where('topic_id', $id)->delete();
        QuizAnswer::where('topic_id', $id)->delete();

        return back()->with('delete', trans('flash.DeletedSuccessfully'));
    }

    public function delete($id)
    {
        $topic = QuizTopic::where('id', $id)->first();
        $answer = QuizAnswer::where('topic_id', $id)->get();

        if ($answer != null) {
            QuizAnswer::where('topic_id', $id)->delete();
        }
        return redirect()->route('course.show', $topic->course_id);
    }

    public function showreport($id)
    {
        $topics = QuizTopic::findOrFail($id);
        $ans = QuizAnswer::where('topic_id', $topics->id)->get();
        $c_que = Quiz::where('topic_id', $id)->count();

        $students = User::get();

        $filtStudents = collect();
        foreach ($students as $student) {
            foreach ($ans as $answer) {
                if ($answer->user_id == $student->id) {
                    $filtStudents->push($student);
                }
            }
        }

        $filtStudents = $filtStudents->unique();
        $filtStudents = $filtStudents->flatten();



        return view('admin.course.quiztopic.report', compact('filtStudents', 'ans', 'c_que', 'topics'));

    }
    public function bulk_delete(Request $request)
    {

        $validator = Validator::make($request->all(), ['checked' => 'required']);
        if ($validator->fails()) {
            return back()->with('error', trans('Please select field to be deleted.'));
        }
        QuizTopic::whereIn('id', $request->checked)->delete();

        return back()->with('error', trans('Selected QuizTopic has been deleted.'));

    }

    public function quiztopicstatus($id)
    {
        $quiztopic = QuizTopic::findorfail($id);

        if ($quiztopic->status == 0) {
            DB::table('quiz_topics')->where('id', '=', $id)->update(['status' => "1"]);
            return back()->with('success', 'Status changed to active !');
        } else {
            DB::table('quiz_topics')->where('id', '=', $id)->update(['status' => "0"]);
            return back()->with('delete', 'Status changed to deactive !');
        }
    }

    public function quiztopicagainstatus($id)
    {
        $quiztopic = QuizTopic::findorfail($id);

        if ($quiztopic->quiz_again == 0) {
            DB::table('quiz_topics')->where('id', '=', $id)->update(['quiz_again' => "1"]);
            return back()->with('success', 'Status changed to active !');
        } else {
            DB::table('quiz_topics')->where('id', '=', $id)->update(['quiz_again' => "0"]);
            return back()->with('delete', 'Status changed to deactive !');
        }
    }

    public function quizreport()
    {
        $user = User::where('role', '=', 'user')->with('courses')->get();
        return view('admin.report.quiz', compact('user'));
    }
    public function view($id)
    {
        $quiz = QuizTopic::join('quiz_questions','quiz_questions.topic_id','=','quiz_topics.id')

            ->join('quiz_answers','quiz_answers.question_id','=','quiz_questions.id')
            ->join('users','quiz_answers.user_id','=','users.id')
            ->select(
                'users.fname as fname','users.lname as lname','users.email as useremail',
                'quiz_topics.title->'.session()->get('changed_language').' as topictitle','quiz_topics.per_q_mark','quiz_topics.id as topicid',
                'quiz_answers.type as answer_type','quiz_answers.user_answer','quiz_answers.answer','quiz_answers.txt_approved','quiz_answers.course_id','quiz_questions.id'
              )
            ->withCount('quizquestion')
            ->groupBy('quiz_topics.id')
            ->where('quiz_answers.user_id','=',$id)
            ->get();


        return view('admin.report.quizview', compact('quiz'));
    }
    public function sort(Request $request){
        $posts = QuizTopic::all();
        foreach ($posts as $post) {
            foreach ($request->order as $order) {

                if($order['id'] == $post->id) {
                    \DB::table('quiz_topics')->where('id',$post->id)->update(['position' => $order['position']]);
                    
                }
            }
        }
        return response()->json('Update Successfully.', 200);

       
    }
}
