<?php

namespace App\Http\Controllers;

use App\QuestionReport;
use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use Spatie\Permission\Models\Role;

class QuestionReportController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:reported-question.view', ['only' => ['index','show']]);
        $this->middleware('permission:reported-question.create', ['only' => [ 'store']]);
        $this->middleware('permission:reported-question.edit', ['only' => ['update','status']]);
        $this->middleware('permission:reported-question.delete', ['only' => ['destroy']]);
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = QuestionReport::orderBy('id','desc')->get();
        return view('admin.question_report.index',compact('items'));
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
    public function store(Request $request, $id)
    {
        DB::table('question_reports')->insert(
            array(
                'course_id'=>$request->course_id,
                'user_id'=>Auth::User()->id,
                'question_id'=>$id,
                'title'=>$request->title,
                'email'=>$request->email,
                'detail'=>$request->detail,
                'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            )
        );

        Session::flash('success', trans('flash.ReportSuccessfully'));
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\QuestionReport  $questionReport
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $show = QuestionReport::where('id', $id)->first();
        return view('admin.question_report.edit',compact('show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\QuestionReport  $questionReport
     * @return \Illuminate\Http\Response
     */
    public function edit(QuestionReport $questionReport)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\QuestionReport  $questionReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = QuestionReport::findorfail($id);
        $input = $request->all();
        $data ->update($input);

        Session::flash('success', trans('flash.UpdatedSuccessfully'));
        return redirect("user/question/report");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\QuestionReport  $questionReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuestionReport $questionReport)
    {
        DB::table('question_reports')->where('id',$id)->delete();
        return redirect("user/question/report");
    }
}
