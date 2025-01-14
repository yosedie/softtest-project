<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Course;
use App\setting;


class FrontinstructorController extends Controller
{
    public function index()
    {
        $instructors = User::select('*')->where('role', 'instructor')->where('status', '1')->get();
        $setting = Setting::first();
        if($setting->theme == '1'){
        return view('front.instructor.index',compact('instructors'));
        }
        return view('theme_2.front.instructor.index',compact('instructors'));

    }
    public function profile(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        $instructors = User::select('*')->where('role', 'instructor')->where('status', '1')->where('id', $request->id)->first();
        $courses = Course::where('user_id', $instructors?$instructors->id:'')->paginate(5);
        $setting = Setting::first();
        if($setting->theme == '1'){
        return view('front.instructor.profile',compact('instructors','courses','user'));
        }
        return view('theme_2.front.instructor.profile',compact('instructors','courses','user'));

    }
    public function Allprofile(Request $request, $id)
    { 
        $user = User::where('id', $id)->first();

        $instructors = User::where('id', $id)->first();
     
        $courses = Course::where('user_id', $instructors->id)->paginate(5);
        $setting = Setting::first();
        if($setting->theme == '1'){
        return view('front.all.profile',compact('instructors','courses','user'));
        }
        return view('theme_2.front.all.profile',compact('instructors','courses','user'));
    }
}
