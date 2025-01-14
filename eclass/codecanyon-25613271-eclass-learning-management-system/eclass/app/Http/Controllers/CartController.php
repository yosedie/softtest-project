<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Cart;
use App\Course;
use App\setting;
use App\Wishlist;
use Session;
use App\Coupon;
use Illuminate\Support\Facades\App;
use App\Adsense;

class CartController extends Controller
{
    public function index()
    {
        //
    }

    public function destroy($id)
    {
        $cart = Cart::findorfail($id);
        $cart->delete();

        return back()->with('delete',trans('flash.CartRemoved'));
    }

    public function addtocart(Request $request)
    {

        $cart = Cart::where('user_id', Auth::User()->id)->where('course_id', $request->course_id)->first();

        if(!empty($cart)){

            return back()->with('delete',trans('flash.CartAlready'));
        }
        else {
            
            DB::table('carts')->insert(
            array(

            'user_id' => Auth::User()->id,
            'course_id' => $request->course_id,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'offer_price' => $request->discount_price,
            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),

            )
        );


        return back()->with('success', trans('flash.CartAddedWithLink', ['cartLink' => route('cart.show')])); // hmd
        }

    	
    }

    public function removefromcart($id)
    {
        $cart = Cart::findorfail($id);
        $cart->delete();

        return back()->with('delete',trans('flash.CartRemoved'));
    }

    public function cartpage(Request $request)
    {

        if(Auth::check())
        {
            $coupanapplieds = Session::get('coupanapplied');
            if(empty($coupanapplieds) == true ){
                     
                Cart::where('user_id', Auth::user()
                            ->id)
                            ->update(['distype' => NULL, 'disamount' => NULL]);

            }

            $wishlist = Wishlist::all();
            $course = Course::all();
            $carts = Cart::where('user_id', Auth::User()->id)->get();

            $ad = Adsense::first();

            $item = Cart::where('user_id', Auth::User()->id)->get();
            
            $cartitems = Cart::where('user_id', Auth::User()->id)->first();


            $price_total = 0;
            $offer_total = 0;
            $cpn_discount = 0;
            $offer_percent = 0;
            $cart_total = 0;

            

            if ($cartitems != NULL){


                //cart price after offer
                foreach ($carts as $key => $c)
                {
                    if ($c->offer_price != 0)
                    {
                        $offer_total = $offer_total + $c->offer_price;
                    }
                    else
                    {
                        $offer_total = $offer_total + $c->price;
                    }
                }

                //for price total
                foreach ($carts as $key => $c)
                {
                    
                    $price_total = $price_total + $c->price;
                    
                }


                //for coupon discount total
                foreach ($carts as $key => $c)
                {
                    
                    $cpn_discount = $cpn_discount + $c->disamount;
                }


                $cart_total = 0;
                
                foreach ($carts as $key => $c)
                {

                    if ($cpn_discount != 0)
                    {
                        $cart_total = $offer_total - $cpn_discount;
                    }
                    else{

                        $cart_total = $offer_total;
                    }
                }


                //for offer percent
                foreach ($carts as $key => $c)
                {
                    if ($cpn_discount != 0)
                    {
                        $offer_amount  = $price_total - ($offer_total - $cpn_discount);
                        $value         =  $offer_amount / $price_total;
                        $offer_percent = $value * 100;
                    }
                    else
                    {
                        $offer_amount  = $price_total - $offer_total;
                        $value         =  $offer_amount / $price_total;
                        $offer_percent = $value * 100; 
                    }
                }
                

            }
            else{

                $item = NULL;
                $carts = NULL;

            }
        }
        else
        {
            $course = Course::all();
            $ad = Adsense::first();

            $item = session()->get('cart.add_to_cart');


            $cart_courses = 0;
            $wishlist = NULL;
            
            $price_total = 0;
            $offer_total = 0;
            $cpn_discount = 0;
            $cart_total = 0;
            $offer_percent = 0;

            if(isset($item))
            {

                
                $recent_course_id = array_values(array_unique($item));
                
                $carts = $recent_course_id;

                if( isset($recent_course_id) )
                {
                    foreach ($recent_course_id as $item1) {

                        $c = Course::where('id', $item1)->where('status', '1')->first();

                        if ($c->discount_price != 0)
                        {
                            $offer_total = $offer_total + $c->discount_price;
                        }
                        else
                        {
                            $offer_total = $offer_total + $c->price;
                        }

                        $price_total = $price_total + $c->price;

                        

                        if ($cpn_discount != 0)
                        {
                            $cart_total = $offer_total - $cpn_discount;
                        }
                        else{

                            $cart_total = $offer_total;
                        }
                    
                        if ($cpn_discount != 0)
                        {
                            $offer_amount  = $price_total - ($offer_total - $cpn_discount);
                            $value         =  $offer_amount / $price_total;
                            $offer_percent = $value * 100;
                        }
                        else
                        {
                            $offer_amount  = $price_total - $offer_total;
                            $value         =  $offer_amount / $price_total;
                            $offer_percent = $value * 100; 
                        }
                    
                        
                    }
                    

                }
            }
            else{

                $item = NULL;
                $carts = NULL;
            }

           
        }


        $setting = Setting::first();
        if($setting->theme == '1'){

        return view('front.cart',compact('course', 'carts', 'wishlist','offer_total','price_total', 'offer_percent', 'cart_total', 'cpn_discount', 'ad', 'item'));
        }
        return view('theme_2.front.cart',compact('course', 'carts', 'wishlist','offer_total','price_total', 'offer_percent', 'cart_total', 'cpn_discount', 'ad', 'item'));
       
    }
   
    
}
