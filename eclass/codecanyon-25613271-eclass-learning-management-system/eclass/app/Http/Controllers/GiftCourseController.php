<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\User;
use App\setting;
use Hash;
use Session;

class GiftCourseController extends Controller
{
    public function giftview($id, $slug)
    {
    	$course = Course::where('id', $id)->first();
        $setting = Setting::first();
        if($setting->theme == '1'){
    	return view('front.gift.gift', compact('course'));
        }
    	return view('theme_2.front.gift.gift', compact('course'));

    }

    public function giftcheckout(Request $request)
    {
        $user_check = User::where('email', $request->email)->first();

        if($user_check == NULL)
        {
            $password = '123456';

            $user = new User;
            $user->fname = $request->fname;
            $user->lname = $request->lname;
            $user->email = $request->email;
            $user->password = Hash::make($password);
            $user->email_verified_at = \Carbon\Carbon::now()->toDateTimeString();
            $user->save();
        }

        $user_check = User::where('email', $request->email)->first();


    	$course = Course::where('id', $request->course_id)->first();

    	// $course = Course::all();
        $cart = Course::where('id', $request->course_id)->first();

        $price_total = 0;
        $offer_total = 0;
        $cpn_discount = 0;


        if ($course->discount_price != 0)
        {
            $offer_total = $offer_total + $course->discount_price;
        }
        else
        {
            $offer_total = $offer_total + $course->price;
        }



        $price_total = $price_total + $course->price;


        

        //for offer percent
        $offer_amount  = $price_total - ($offer_total);
        $value         =  $offer_amount / $price_total;
        $offer_percent = $value * 100;

        $offer_percent = $request->offer_percent;


        $cart_total = $offer_total;

        $one_course = 1;

        Session::put('one_order_course', $course->id);

        Session::put('one_order_user', $user_check->id);

        $setting = Setting::first();
        if($setting->theme == '1'){
        return view('front.checkout',compact('course', 'cart','price_total','offer_total', 'offer_percent', 'cart_total', 'one_course'));
        }
        return view('theme_2.front.checkout',compact('course', 'cart','price_total','offer_total', 'offer_percent', 'cart_total', 'one_course'));

    }
}
 