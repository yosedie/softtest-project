<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuizTopic;
use App\QuizAnswer;
use Auth;
use App\Quiz;
use App\User;
use App\Setting;

class QuizStartController extends Controller
{
    public function quizstart($id)
    {
        $topic = QuizTopic::findOrFail($id);
        $answers = QuizAnswer::where('topic_id','=',$topic->topic_id)->first();
        $setting = Setting::first();
        if($setting->theme == '1'){
        return view('front.quiz.main_quiz', compact('topic','answers'));
        }
        return view('theme_2.front.quiz.main_quiz', compact('topic','answers'));
        }

    public function store(Request $request, $id)
    {

        $topics=QuizTopic::where('id',$id)->first();

        $unique_question = array_unique($request->question_id);

        $quiz_already = QuizAnswer::where('user_id', Auth::user()->id)->where('topic_id', $id)->first();

        if($quiz_already == NULL)
        {
            for ($i = 1; $i <= count($request->answer); $i++) {

                $already_answer = QuizAnswer::where('question_id', $unique_question[$i])->where('topic_id',$topics->id)->where('user_id', Auth::user()->id)->first();

                if($already_answer == NULL)
                {
        
                    $answers[] = [
                        'user_id' => Auth::user()->id,
                        'user_answer' => $request->answer[$i],
                        'question_id' => $unique_question[$i],
                        'course_id'=>$topics->course_id,
                        'topic_id'=>$topics->id,
                        'answer'=>$request->canswer[$i],
                        'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                    ];
                }

            }

            QuizAnswer::insert($answers);
         
        }
        
        
        return redirect()->route('start.quiz.show', $id);
           
    }

    public function show($id)
    {
        $auth = Auth::user();
        $topic = QuizTopic::where('id',$id)->get();
        $questions = Quiz::where('topic_id', $id)->get();
        $count_questions = $questions->count();
        $topics=QuizTopic::where('id',$id)->first();
        $ans = QuizAnswer::where('user_id',$auth->id)->where('topic_id',$id)->get();
        $mark = 0;
        foreach ($ans as $key => $answer) {
            if ($answer->answer == $answer->user_answer) {
                $mark++;
            }
        }
        $correct = $mark*$topics->per_q_mark;
        $total_mark = $count_questions*$topics->per_q_mark;
        $per['exam_percentage'] = round(($correct*100)/$total_mark, 2);
        if(Auth::check()){
            User::whereId(Auth::user()->id)->update($per);
        }
        $setting = Setting::first();
        if($setting->theme == '1'){
        return view('front.quiz.finish', compact('auth','topic','questions','count_questions','ans','topics'));
        }
        return view('theme_2.front.quiz.finish', compact('auth','topic','questions','count_questions','ans','topics'));
        }

    public function tryagain($id)
    {
        QuizAnswer::where('topic_id',$id)->where('user_id', Auth::User()->id)->delete();

        return redirect()->route('start_quiz', $id);
    }


    public function subquizstart($id)
    {
        $topic = QuizTopic::findOrFail($id);
        $answers = QuizAnswer::where('topic_id','=',$topic->topic_id)->first();
        return view('front.quiz.sub_main_quiz', compact('topic','answers'));
    }

    public function sub_store(Request $request, $id)
    {

        $topics=QuizTopic::where('id',$id)->first();

        $unique_question = array_unique($request->question_id);


        $quiz_already = QuizAnswer::where('user_id', Auth::user()->id)->where('topic_id', $id)->first();


        if($quiz_already == NULL)
        {
      
            for ($i = 1; $i <= count($request->txt_answer); $i++) {
        
                    
                $answers[] = [
                    'user_id' => Auth::user()->id,
                    // 'user_answer' => $request->answer[$i],
                    'question_id' => $unique_question[$i],
                    'course_id'=>$topics->course_id,
                    'topic_id'=>$topics->id,
                    'txt_answer' => $request->txt_answer[$i],
                    'type' => '1',
                    'txt_approved' => '0',
                    'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                ];
             
            }
            
            QuizAnswer::insert($answers);

        }
        
        
        return redirect()->route('sub.start.quiz.show', $id);
           
    }

    public function sub_show($id)
    {
        $auth = Auth::user();
        $topic = QuizTopic::where('id',$id)->get();
        $questions = Quiz::where('topic_id', $id)->get();
        $count_questions = $questions->count();
        $topics=QuizTopic::where('id',$id)->first();
        $ans = QuizAnswer::where('user_id',$auth->id)
              ->where('topic_id',$id)->get(); 

        return view('front.quiz.sub_finish', compact('auth','topic','questions','count_questions','ans','topics'));

    }


    public function subtryagain($id)
    {
        QuizAnswer::where('topic_id',$id)->where('user_id', Auth::User()->id)->delete();

        return redirect()->route('sub_start_quiz', $id);
    }
}
