<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Order;
use Auth;
use App\Course;
use App\setting;

class StudentprofileController extends Controller
{
    public function index(){
        if (Auth::check()) {
        $users = User::select('*')->where('role', 'user')->where('status', '1')->first();
        $enroll = Order::where('refunded', '0')->where('status', '1')->where('user_id', Auth::user()->id)->get();
        $course = Course::all();
        $setting = setting::first();
        if($setting->theme == '1'){
        return view('front.student.profile',compact('users','enroll','course'));
        }
        return view('theme_2.front.student.profile',compact('users','enroll','course'));

    }
    else{
        return redirect('login');
    }
}
}
