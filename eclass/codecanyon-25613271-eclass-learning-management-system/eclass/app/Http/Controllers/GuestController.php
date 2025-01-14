<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Cart;
use App\User;
use App\Course;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Coupon;

class GuestController extends Controller
{
    public function offlineview() {
    	return view('offline');
    }

    public function addtocart(Request $request, $id)
    {
    	session()->push('cart.add_to_cart', $id);

    	$viewed = session()->get('cart.add_to_cart');

    	return back()->with('success',trans('flash.CartAdded'));
    }

    public function userregister(Request $request)
    {
    	return view('front.guest.guest_register');
    }

    public function usercheckout(Request $request)
    {

        $request->validate([
            'fname' => 'required|min:1', 
            'lname' => 'required|min:1', 
            'email' => 'required|unique:users,email']);

      

        $user = new User;

        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->email = $request->email;
        $user->password = Hash::make(str_random(8));
        $user->status = 1;
        $user->assignRole('user');

        $user->save();

        Auth::login($user);

        if (session()->has('cart.add_to_cart'))
        {

            foreach (session()->get('cart.add_to_cart') as $key => $c)
            {

                $course = Course::findorFail($c);

                $cart = new Cart;
                $cart->user_id = Auth::user()->id;
                $cart->course_id = $course->id;
                $cart->category_id = $course->category_id;
                $cart->price = $course['price'];
                $cart->offer_price = $course['discount_price'];
                $cart->created_at = \Carbon\Carbon::now()->toDateTimeString();
                $cart->save();

            
            }

        }

        

        Session::forget('cart.add_to_cart');

        return redirect('all/cart');
    }

    public function removefromcart(Request $request, $id)
    {
    	$viewed = session()->get('cart.add_to_cart');

        $viewed = array_filter($viewed, function($v) use ($id) {
            return $v != $id;
        });

        session()->put('cart.add_to_cart', $viewed);

        $viewed = session()->get('cart.add_to_cart');

        return back()->with('delete',trans('flash.CartRemoved'));
    }
    public function guestlogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {

            if (session()->has('cart.add_to_cart'))
            {

                foreach (session()->get('cart.add_to_cart') as $key => $c)
                {

                    $course = Course::findorFail($c);

                    $cart = new Cart;
                    $cart->user_id = Auth::user()->id;
                    $cart->course_id = $course->id;
                    $cart->category_id = $course->category_id;
                    $cart->price = $course['price'];
                    $cart->offer_price = $course['discount_price'];
                    $cart->created_at = \Carbon\Carbon::now()->toDateTimeString();
                    $cart->save();

                
                }

            }
            
            return redirect()->action('CartController@cartpage')
                        ->withSuccess('You have Successfully logged in');
        }
    }
}
