<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReportReview;
use DB;
use Auth;
use Session;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class ReportReviewController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:review-reports.manage', ['only' => ['store','show','update','destroy','bulk_delete']]);
    
    }
    public function index()
    {
        //
    }

    public function store(Request $request, $id)
    {
       
        DB::table('report_reviews')->insert(
            array(
                'course_id'  => $id,
                'user_id'    => Auth::User()->id,
                'review_id'  => $request->review_id,
                'title'      => $request->title,
                'email'      => $request->email,
                'detail'     => $request->detail,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            )
        );
        Session::flash('success', trans('flash.ReportSuccessfully'));
        return back();
    }
    public function show($id)
    {
        $show = ReportReview::where('id', $id)->first();
        return view('admin.course.reviewreport.edit',compact('show'));
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $data = ReportReview::findorfail($id);
        $input = $request->all();
        $data ->update($input);
        return redirect()->route('course.show',$request->course);
    }

    public function destroy($id)
    {
        DB::table('report_reviews')->where('id',$id)->delete();
        return redirect()->route('reports.index');
    }

    public function bulk_delete(Request $request)
    {
    
        $validator = Validator::make($request->all(), ['checked' => 'required']);

        if ($validator->fails()) {
            return back()->with('error',trans('Please select field to be deleted.'));
        }

        ReportReview::whereIn('id',$request->checked)->delete();

        return back()->with('error',trans('Selected Report Review has been deleted.'));      
    }
}
