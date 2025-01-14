<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class TimeHistoryController extends Controller
{
    public function movie_time($endtime,$movie_id,$user_id)
    {
       
        $timeold=$endtime;
        if (strlen($endtime)<=5) {

        	$endtime='00:'. $endtime;

     	}
  
      
       	$times= Session::get('time_'.$movie_id);
       
       	if (isset($times) && !is_null($times)) {

           foreach ($times as $key => $value) {
           $v[]=$value;
           }
          
    	$coll=collect($v)->unique()->flatten();
      

     	if ($coll->contains($movie_id) && strtotime($times['endtime'])<=strtotime($timeold)) {

        session()->put('time_'.$movie_id,[
            'endtime' => $endtime,
            'movie' => $movie_id,
            'user' => $user_id,
        ]);
     
     	}
     	else
     	{
	        if ($times['endtime'] && strtotime($times['endtime'])<=strtotime($timeold)) {
				
	            session()->push('time_'.$movie_id,[
					'endtime' => $endtime,
					'movie' => $movie_id,
					'user' => $user_id,
				]);

        }
        
     
     	}
  
		}
		else{
		     if (isset($times['endtime']) && strtotime($times['endtime'])<=strtotime($timeold)) {
		            session()->put('time_'.$movie_id,[
		        'endtime' => $endtime,
		        'movie' => $movie_id,
		        'user' => $user_id,
		    ]);
        }
        
     	return 'puut';
	}
 
}    


}
