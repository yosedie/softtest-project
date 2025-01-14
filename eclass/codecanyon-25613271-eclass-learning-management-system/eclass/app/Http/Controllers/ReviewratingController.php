<?php

namespace App\Http\Controllers;

use App\ReviewRating;
use Illuminate\Http\Request;
use App\User; 
use App\Course;
use DB;
use Auth;
use App\Order;
use App\BundleCourse;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;



class ReviewratingController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:review-rating.manage', ['only' => ['store','show','update','destroy','bulk_delete']]);
     
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //
      
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
        
        DB::table('review_ratings')->insert(
        array(
            'course_id' => $request->course,
            'user_id' => $request->user_id,
            'review' => $request->review,
            'status' => $request->status,
            'approved' => $request->approved,
            'featured' => $request->featured,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            )
        );
        return redirect()->route('course.show',$request->course);
    }   
 

    /**
     * Display the specified resource.
     *
     * @param  \App\reviewrating  $reviewrating
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $jp = ReviewRating::find($id);
        $users = User::all();
        $courses = Course::all();
        return view('admin.course.reviewrating.edit',compact('jp','courses','users'));
   
    }
  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\reviewrating  $reviewrating
     * @return \Illuminate\Http\Response
     */
    public function edit(reviewrating $reviewrating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\reviewrating  $reviewrating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $data = ReviewRating::findorfail($id);
        $input = $request->all();
        $input['status'] = isset($request->status) ? '1' : '0';
        $input['approved'] = isset($request->status) ? '1' : '0';
        $input['featured'] = isset($request->status) ? '1' : '0';
        $data ->update($input);
        return redirect()->route('course.show',$request->course);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\reviewrating  $reviewrating
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('review_ratings')->where('id',$id)->delete();
        return back();
    }


    public function rating(Request $request,$id)
    {
        $orders = Order::where('user_id', Auth::User()->id)->where('course_id', $id)->first();
        $review = ReviewRating::where('user_id', Auth::User()->id)->where('course_id', $id)->first();

        $bundle = Order::where('user_id', Auth::User()->id)->where('bundle_id', '!=', NULL)->get();

        $course_id = array();
  

        foreach ($bundle as $b) {
            $bundleCourse = BundleCourse::where('id', $b->bundle_id)->first();
            if ($bundleCourse !== null) {
                array_push($course_id, $bundleCourse->course_id);
            }
        }

        $course_id = array_values(array_filter($course_id));

        $course_id = array_flatten($course_id);

        if(!empty($orders) || Auth::user()->role == 'admin' || isset($course_id) || in_array($course->id, $course_id) ){
            if(!empty($review))
            {
                return back()->with('delete',trans('flash.AlreadyReviewed'));
            }
            else{

                $input = $request->all();
                $input['course_id'] = $id;
                $input['user_id'] = Auth::User()->id;
                $data = ReviewRating::create($input);
                $data->save();

                return back()->with('success',trans('flash.ReviewSuccessfully'));
            }
            return back()->with('success',trans('flash.ReviewSuccessfully'));
        }
        else{
            return back()->with('delete',trans('flash.PurchasetoReview'));

        }
        
    }

    
    public function bulk_delete(Request $request)
    {
     
           $validator = Validator::make($request->all(), ['checked' => 'required']);
           if ($validator->fails()) {
            return back()->with('error',trans('Please select field to be deleted.'));
           }
           ReviewRating::whereIn('id',$request->checked)->delete();

          return back()->with('error',trans('Selected ReviewRating has been deleted.'));

          
   }


   public function reviewratingstatus($id)
    {
        $reviewrating = ReviewRating::findorfail($id);

        if($reviewrating->status ==0)
        {
            DB::table('review_ratings')->where('id','=',$id)->update(['status' => "1"]); 
            return back()->with('success','Status changed to active !');
        }
        else
        {
            DB::table('review_ratings')->where('id','=',$id)->update(['status' => "0"]);
            return back()->with('delete','Status changed to deactive !');
        }
    }

    public function reviewratingapproved($id)
    {
        $reviewrating = ReviewRating::findorfail($id);

        if($reviewrating->approved ==0)
        {
            DB::table('review_ratings')->where('id','=',$id)->update(['approved' => "1"]); 
            return back()->with('success','Status changed to active !');
        }
        else
        {
            DB::table('review_ratings')->where('id','=',$id)->update(['approved' => "0"]);
            return back()->with('delete','Status changed to deactive !');
        }
    }

    public function reviewratingfeatured($id)
    {
        $reviewrating = ReviewRating::findorfail($id);

        if($reviewrating->featured ==0)
        {
            DB::table('review_ratings')->where('id','=',$id)->update(['featured' => "1"]); 
            return back()->with('success','Status changed to active !');
        }
        else
        {
            DB::table('review_ratings')->where('id','=',$id)->update(['featured' => "0"]);
            return back()->with('delete','Status changed to deactive !');
        }
    }
    
}
