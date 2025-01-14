<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\CourseClass;
use App\CourseChapter;
use App\Course;
use Auth;
use Crypt;
use Redirect;
use App\BundleCourse;
use App\WatchCourse;
Use Alert;
use App\Setting;
use App\Attandance;
use Carbon\Carbon;

class WatchController extends Controller
{
    public function watch($id)
    {
       if(Auth::check())
        {
        	$order = Order::where('status', '1')->where('user_id', Auth::User()->id)->where('course_id', $id)->first();

            $courses = Course::where('id', $id)->first();

            $bundle = Order::where('user_id', Auth::User()->id)->where('bundle_id', '!=', NULL)->get();

            $gsetting = Setting::first();

            //attandance start
            if(!empty($order))
            {
                if($gsetting->attandance_enable == 1)
                {

                  $date = Carbon::now();
                  //Get date
                  $date->toDateString();

                  $courseAttandance = Attandance::where('course_id','=',$id)->where('user_id', Auth::User()->id)->where('date','=', $date->toDateString())->first();

                    if(!$courseAttandance)
                    {
                        $attanded = Attandance::create([
                            'user_id'    => Auth::user()->id,
                            'course_id'  => $id,
                            'instructor_id' => $courses->user_id,
                            'date'     => $date->toDateString(),
                            'order_id' => $id,
                            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                            ]
                        );
                    }
                }
            } //attandance end


            $course = Course::findOrFail($id);


            $course_id = array();

            // foreach($bundle as $b)
            // {
            //    $bundle = BundleCourse::where('id', $b->bundle_id)->first();
            //     array_push($course_id, $bundle->course_id);
            // }

            $course_id = array_values(array_filter($course_id));

            $course_id = array_flatten($course_id);


        

            if(Auth::User()->role == "admin")
            {
            	return view('watch',compact('courses'));
            }
            elseif(Auth::User()->id == $course->user_id)
            {
                return view('watch',compact('courses'));
            }
            else
            {
                if(!empty($order))
                {

                     $coursewatch = WatchCourse::where('course_id','=',$id)->where('user_id', Auth::User()->id)->first();


                    if($gsetting->device_control == 1)
                    {

                        if(!$coursewatch)
                        {

                            $watching = WatchCourse::create([
                                'user_id'    => Auth::user()->id,
                                'course_id'  => $id,
                                'start_time' => \Carbon\Carbon::now()->toDateTimeString(),
                                'active'     => '1',
                                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                                ]
                            );

                            return view('watch',compact('courses'));

                        }
                        else{
                          
                            if($coursewatch->active == 0){

                               
                                $coursewatch->active = 1;
                                $coursewatch->save();
                                return view('watch',compact('courses'));
                            }
                            else{

                                // Alert::error('Active', 'User Already Watching Course !!');
                                return back()->with('delete', 'User Already Watching Course !!');

                                return back(); 

                            }

                        }
                    }
                    else{
                        
                        if($gsetting->watch_enable == 1 && $gsetting->watch_time != NUll){
                            if(!$coursewatch){
                                
                                $watching = WatchCourse::create([
                                    'user_id'    => Auth::user()->id,
                                    'course_id'  => $id,
                                    'start_time' => \Carbon\Carbon::now()->toDateTimeString(),
                                    'active'     => '1',
                                    'count' => '1',
                                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                                    ]
                                );
                            }else{
                                if(isset($coursewatch) && $coursewatch->count <= $gsetting->watch_time){
                                    $coursewatch->count = $coursewatch->count + 1;
                                    $coursewatch->save();
                                }else{
                                    return back()->with('delete', 'Course watch limit reached!');
                                }
    
                            }
                           
                        }
                        else{
                            if(!$coursewatch){
                                
                                $watching = WatchCourse::create([
                                    'user_id'    => Auth::user()->id,
                                    'course_id'  => $id,
                                    'start_time' => \Carbon\Carbon::now()->toDateTimeString(),
                                    'active'     => '1',
                                    'count' => '0',
                                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                                    ]
                                );
                            }
                        
                        }

                        return view('watch',compact('courses'));
                    }

                    
                }
                elseif(isset($course_id) && in_array($id, $course_id))
                {
                    return view('watch',compact('courses'));
                }
                else
                {
                    return back()->with('delete', trans('flash.UnauthorizedAction'));
                }
                
            }
        }
        return Redirect::route('login')->withInput()->with('delete', trans('flash.PleaseLogin'));

    }


    public function watchclass($id)
    {
        $class = CourseClass::where('id',$id)->first();

        $courses = Course::where('id', $class->course_id)->first();

        if(Auth::check())
        { 

            $order = Order::where('status', '1')->where('user_id', Auth::User()->id)->where('course_id', $courses->id)->first();

            $gsetting = Setting::first();

            //attandance start
            if(!empty($order))
            {
                if($gsetting->attandance_enable == 1)
                {

                  $date = Carbon::now();
                  //Get date
                  $date->toDateString();

                  $courseAttandance = Attandance::where('course_id','=',$id)->where('user_id', Auth::User()->id)->where('date','=', $date->toDateString())->first();

                    if(!$courseAttandance)
                    {
                        $attanded = Attandance::create([
                            'user_id'    => Auth::user()->id,
                            'course_id'  => $id,
                            'instructor_id' => $courses->user_id,
                            'date'     => $date->toDateString(),
                            'order_id' => $id,
                            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                            ]
                        );
                    }
                }
            } //attandance end

            $bundle = Order::where('user_id', Auth::User()->id)->where('bundle_id', '!=', NULL)->get();

            $course_id = array();

            // foreach($bundle as $b)
            // {
            //    $bundle = BundleCourse::where('id', $b->bundle_id)->first();
            //     array_push($course_id, $bundle->course_id);
            // }

            $course_id = array_values(array_filter($course_id));

            $course_id = array_flatten($course_id);


            if(Auth::User()->role == "admin")
            {
                return view('classwatch',compact('class'));
            }
            elseif(Auth::User()->id == $courses->user_id)
            {
                return view('classwatch',compact('class'));
            }
            else
            {
                if(!empty($order))
                {
                    $coursewatch = WatchCourse::where('course_id','=',$courses->id)->where('user_id', Auth::User()->id)->first();


                    if($gsetting->device_control == 1)
                    {

                        if(!$coursewatch)
                        {

                            $watching = WatchCourse::create([
                                'user_id'    => Auth::user()->id,
                                'course_id'  => $courses->id,
                                'start_time' => \Carbon\Carbon::now()->toDateTimeString(),
                                'active'     => '1',
                                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                                ]
                            );

                            return view('classwatch',compact('class'));

                        }
                        else{
                          
                            if($coursewatch->active == 0){

                               
                                $coursewatch->active = 1;
                                $coursewatch->save();
                                return view('classwatch',compact('class'));
                            }
                            else{

                                Alert::error('Active', 'User Already Watching Course !!');
                                return back(); 
                            }

                        }
                    }
                    else{
                        return view('classwatch',compact('class'));
                    }
                   
                }
                elseif(isset($course_id) && in_array($courses->id, $course_id))
                {
                    return view('classwatch',compact('class'));
                }
                else
                {
                    return back()->with('delete', trans('flash.UnauthorizedAction'));
                }
            }

        }
        return Redirect::route('login')->withInput()->with('delete', trans('flash.PleaseLogin'));
    }

    public function view($url, $course_id)
    {
        $course = $course_id;

        $courses = Course::where('id', $course)->first();

        $url = Crypt::decrypt($url);

        if(Auth::check())
        { 

            $order = Order::where('status', '1')->where('user_id', Auth::User()->id)->where('course_id', $course)->first();

            $gsetting = Setting::first();

            //attandance start
            if(!empty($order))
            {
                if($gsetting->attandance_enable == 1)
                {

                  $date = Carbon::now();
                  //Get date
                  $date->toDateString();

                  $courseAttandance = Attandance::where('course_id','=',$courses->id)->where('user_id', Auth::User()->id)->where('date','=', $date->toDateString())->first();

                    if(!$courseAttandance)
                    {
                        $attanded = Attandance::create([
                            'user_id'    => Auth::user()->id,
                            'course_id'  => $courses->id,
                            'instructor_id' => $courses->user_id,
                            'date'     => $date->toDateString(),
                            'order_id' => $order->id,
                            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                            ]
                        );
                    }
                }
            } //attandance end

            $bundle = Order::where('user_id', Auth::User()->id)->where('bundle_id', '!=', NULL)->get();

            $course_id = array();

            // foreach($bundle as $b)
            // {
            //    $bundle = BundleCourse::where('id', $b->bundle_id)->first();
            //     array_push($course_id, $bundle->course_id);
            // }

            $course_id = array_values(array_filter($course_id));

            $course_id = array_flatten($course_id);


            if(Auth::User()->role == "admin")
            {
                return view('iframe',compact('url', 'course'));
            }
            elseif(Auth::User()->id == $courses->user_id)
            {
                return view('iframe',compact('url', 'course'));
            }
            elseif(isset($course_id) && in_array($course, $course_id))
            {
                return view('iframe',compact('url', 'course'));
            }
            else
            {
                if(!empty($order))
                { 
                    return view('iframe',compact('url', 'course'));
                }
                else
                {
                    return back()->with('delete', trans('flash.UnauthorizedAction'));
                }
            }

        }
        return Redirect::route('login')->withInput()->with('delete', trans('flash.PleaseLogin'));
        
    }

    public function lightbox($id)
    {
        $class = CourseClass::where('id',$id)->first();
        
        return view('lightbox',compact('class'));
    }


    public function audioclass($id)
    {
        $class = CourseClass::where('id',$id)->first();

        $courses = Course::where('id', $class->course_id)->first();


        if(Auth::check())
        { 

            $order = Order::where('status', '1')->where('user_id', Auth::User()->id)->where('course_id', $courses->id)->first();

            $gsetting = Setting::first();

            //attandance start
            if(!empty($order))
            {
                if($gsetting->attandance_enable == 1)
                {

                  $date = Carbon::now();
                  //Get date
                  $date->toDateString();

                  $courseAttandance = Attandance::where('course_id','=',$courses->id)->where('user_id', Auth::User()->id)->where('date','=', $date->toDateString())->first();

                    if(!$courseAttandance)
                    {
                        $attanded = Attandance::create([
                            'user_id'    => Auth::user()->id,
                            'course_id'  => $courses->id,
                            'instructor_id' => $courses->user_id,
                            'date'     => $date->toDateString(),
                            'order_id' => $order->id,
                            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                            ]
                        );
                    }
                }
            } //attandance end

            $bundle = Order::where('user_id', Auth::User()->id)->where('bundle_id', '!=', NULL)->get();

            $course_id = array();

            // foreach($bundle as $b)
            // {
            //    $bundle = BundleCourse::where('id', $b->bundle_id)->first();
            //     array_push($course_id, $bundle->course_id);
            // }

            $course_id = array_values(array_filter($course_id));

            $course_id = array_flatten($course_id);


            if(Auth::User()->role == "admin")
            {
                return view('audioclass',compact('class'));
            }
            else
            {
                if(!empty($order))
                {

                    $coursewatch = WatchCourse::where('course_id','=',$courses->id)->where('user_id', Auth::User()->id)->first();


                    if($gsetting->device_control == 1)
                    {

                        if(!$coursewatch)
                        {

                            $watching = WatchCourse::create([
                                'user_id'    => Auth::user()->id,
                                'course_id'  => $courses->id,
                                'start_time' => \Carbon\Carbon::now()->toDateTimeString(),
                                'active'     => '1',
                                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                                ]
                            );

                            return view('audioclass',compact('class'));

                        }
                        else{
                          
                            if($coursewatch->active == 0){

                               
                                $coursewatch->active = 1;
                                $coursewatch->save();
                                return view('audioclass',compact('class'));
                            }
                            else{

                                Alert::error('Active', 'User Already Watching Course !!');
                                return back(); 
                            }

                        }
                    }
                    else{
                        return view('audioclass',compact('class'));
                    }
                    
                }
                elseif(isset($course_id) && in_array($courses->id, $course_id))
                {
                    return view('audioclass',compact('class'));
                }
                else
                {
                    return back()->with('delete', trans('flash.UnauthorizedAction'));
                }
            }

        }
        return Redirect::route('login')->withInput()->with('delete', trans('flash.PleaseLogin'));
    }

   
}
