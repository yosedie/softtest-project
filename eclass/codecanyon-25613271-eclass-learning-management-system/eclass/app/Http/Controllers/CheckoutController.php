<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Cart;
use App\Setting;
use App\Meeting;
use App\BBL;
use Auth;
use Braintree;
use Session;
use App\JitsiMeeting;
use App\Googlemeet;


class CheckoutController extends Controller
{
    // public function checkoutpage(Request $request)
    // {
    //     $course = Course::all();
    //     if(auth::check())
    //     {
    //         $carts = Cart::where('user_id',Auth::User()->id)->get();
    //     }
    //     else
    //     {
    //         $carts = session()->get('cart.add_to_cart');
    //         $carts = array_unique($carts);
    //     }
        

    //     $price_total = session()->get('price_total');
    //     $offer_total = session()->get('offer_total');
    //     $offer_percent = session()->get('offer_percent');
    //     $cart_total = session()->get('cart_total');
        


    //     if(Session::get('one_order_course') !== null)
    //     {
    //         session()->forget('one_order_course');
    //     }

    //     if(Session::get('one_order_user') !== null)
    //     {
    //         session()->forget('one_order_user');
    //     }

    //     $setting = Setting::first();
    //     if($setting->theme == '1'){
    //     return view('front.checkout',compact('course', 'carts','price_total','offer_total', 'offer_percent', 'cart_total'));
    //     }
    //     return view('theme_2.front.checkout',compact('course', 'carts','price_total','offer_total', 'offer_percent', 'cart_total'));
    // }  
    
    
    public function checkoutpage(Request $request)
    {
        $course = Course::all();
        
        // Initialize carts based on user authentication status
        if (auth::check()) {
            $carts = Cart::where('user_id', Auth::User()->id)->get();
        } else {
            $carts = session()->get('cart.add_to_cart', []);
            $carts = array_unique($carts);
        }

        // Retrieve session data
        $price_total = session()->get('price_total', 0);
        $offer_total = session()->get('offer_total', 0);
        $offer_percent = session()->get('offer_percent', 0);
        $cart_total = session()->get('cart_total', 0);
        
        // Retrieve meeting price and ID from session
        $meeting_price = session()->get('meeting_price', 0);
        $meetingID = session()->get('meeting_id', null);

        // Clear one order session data if present
        session()->forget('one_order_course');
        session()->forget('one_order_user');
        
        // Retrieve settings
        $setting = Setting::first();
        
        // Return the appropriate view with updated cart total and meeting price
        if ($setting->theme == '1') {
            return view('front.checkout', compact('course', 'carts', 'price_total', 'offer_total', 'offer_percent', 'cart_total', 'meeting_price', 'meetingID'));
        }
        
        return view('theme_2.front.checkout', compact('course', 'carts', 'price_total', 'offer_total', 'offer_percent', 'cart_total', 'meeting_price', 'meetingID'));
    }

    public function checkoutmeeting(Request $request)
    {
        $meeting_id = $request->input('meeting_id');
        $type = $request->input('type');

        switch ($type) {
            case 'zoom':
                $meeting = Meeting::findOrFail($meeting_id);
                break;
            case 'jitsi':
                $meeting = JitsiMeeting::findOrFail($meeting_id);
                break;
            case 'bbl':
                $meeting = BBL::findOrFail($meeting_id);
                break;
            case 'googlemeet':
                $meeting = Googlemeet::findOrFail($meeting_id);
                break;
            default:
                return redirect()->back()->withErrors('Invalid meeting type');
        }

        // Store meeting price and ID in session
        session()->put('meeting_price', $meeting->paid_meeting_price);
        session()->put('meeting_id', $meeting->id);
        session()->put('meeting_type', $type);

        // Redirect to the checkout page
        return redirect()->route('checkoutpage');
    }



}
