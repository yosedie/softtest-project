<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Order;
use Illuminate\Support\Facades\Schema;
use App\BundleCourse;

class ViewmoreController extends Controller
{
    public function featuredcourse(Request $request){

        $ipaddress = $request->getClientIp();
        
        $geoip = geoip()->getLocation($ipaddress);
        $usercountry = strtoupper($geoip->country);

        $cors = Course::where('status', '1')->where('featured', '1')->with('user')->get()->map(function($c) use($usercountry) {
                    
                    if($c->country != ''){
                        if(!in_array($usercountry,$c->country)){
                            return $c;
                        }
                    }else{
                        return $c;
                    }
                
        })->filter();
        return view('front.viewmore.featured',compact('cors'));
    }
    public function bestselling(){

        $bestselling = Order::whereNotNUll('course_id')->with('courses','courses.user')->get();
        return view('front.viewmore.bestselling',compact('bestselling'));

    }
    public function bundle(){
        
        if (Schema::hasColumn('bundle_courses', 'is_subscription_enabled'))
        {
            $bundles = BundleCourse::where('is_subscription_enabled', 0)->with('user')->get();
            $subscriptionBundles = BundleCourse::where('is_subscription_enabled', 1)->with('user')->get();
        }
        else{

            $bundles = NULL;
            $subscriptionBundles = NULL;

        }
        return view('front.viewmore.bundle',compact('bundles'));
    }
    public function topdiscounted(){

        $discountcourse = Course::where('type','1')->where('status',1)->whereNotNUll('discount_price')->with('user')->get();
        return view('front.viewmore.topdiscounted',compact('discountcourse'));

    }
}
