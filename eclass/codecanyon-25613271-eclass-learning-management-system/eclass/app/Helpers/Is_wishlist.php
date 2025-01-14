<?php

namespace App\Helpers;


use Twilio\Rest\Client;
use App\Wishlist;
use Auth;

class Is_wishlist
{ 

    public static function in_wishlist($c)
    {
    	if(Auth::guard('api')->check()){
			
	    	$in_wishlist = Wishlist::where('user_id',Auth::guard('api')->user()->id)
							->where('course_id', $c)
							->first();

	        if(isset($in_wishlist)){
	            return 1;
	        }else{
	           return 0;
	        }
	    }else{

            return 0;

        }
        
    }

}
