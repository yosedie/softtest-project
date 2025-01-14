<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WatchCourse;
use App\Course;
use App\setting;
use Auth;

class WatchCourseController extends Controller
{

	public function active(Request $request)
	{

	   	try{

	   	  	$cid = $request->chapterid;
	   	  	$userid = $request->userid;
	       
	   	  	$w = WatchCourse::where('course_id', $cid)->where('user_id', '=', $userid)->update(['active' => 0]);
	        
	   	  	if($w){
	   	  		return response()->json(['msg' => 'Limit lift', 'code' => 200]);
	   	  	}else{
	   	  		return response()->json(['msg' => 'Please try later !', 'code' => 400]);
	   	  	}
	   	}
	   	catch(\Exception $e)
	   	{
	   	  	return response()->json(['msg' => $e->getMessage(), 'code' => 400]);
	   	}

	}

    public function watchlist() 
    {
    	$coursewatch = WatchCourse::where('user_id', Auth::User()->id)->where('active', 1)->get(); 
		$setting = Setting::first();
		if($setting->theme == '1'){
    	return view('front.watchlist', compact('coursewatch'));
		}
    	return view('theme_2.front.watchlist', compact('coursewatch'));

    }

    public function delete($id)
    {
    	WatchCourse::where('id', $id)->delete();
    	return back();
    }
}
