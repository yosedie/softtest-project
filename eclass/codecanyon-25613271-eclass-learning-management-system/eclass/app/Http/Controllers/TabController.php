<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use phpseclib3\Crypt\DES;
use View;

class TabController extends Controller
{
    public function show(Request $request,$id){
        
        
        $ipaddress = $request->getClientIp();
        
        $geoip = geoip()->getLocation($ipaddress);
        $usercountry = strtoupper($geoip->country);
    	
    	if(request()->ajax()){
    		$cats= Categories::withCount(['courses' => function($query){
	    		return $query->where('status','=','1');
	    	}])->whereHas('courses')->with(['courses' => function($c){
	    	    
	    	    return $c->where('status','=','1')->orderBy('id','DESC')->take(4);
	    	    
	    	}])->find($id);
	    	
	    	$courses = $cats->courses->map(function($c) use ($usercountry){
	    	     if($c->country != ''){
                        if(!in_array($usercountry,$c->country)){
                            return $c;
                        }
                    }else{
                        return $c;
                    }
	    	})->filter();

	    	if(isset($cats)){

	    		return response()->json([
		    		'status'  => 'success',
		    		'btn_view' => View::make('btntab',compact('cats'))->render(),
		    		'tabview' => View::make('tabs',compact('courses'))->render()
		    	]);

	    	}else{

	    		return response()->json([
		    		'status'  => 'fail'
		    	]);

	    	}
    	}

    }
	public function show1(Request $request,$id){
        
        
        $ipaddress = $request->getClientIp();
        
        $geoip = geoip()->getLocation($ipaddress);
        $usercountry = strtoupper($geoip->country);
    	
    	if(request()->ajax()){
    		$cats= Categories::withCount(['courses' => function($query){
	    		return $query->where('status','=','1');
	    	}])->whereHas('courses')->with(['courses' => function($c){
	    	    
	    	    return $c->where('status','=','1')->orderBy('id','DESC')->take(4);
	    	    
	    	}])->find($id);
	    	
	    	$courses = $cats->courses->map(function($c) use ($usercountry){
	    	     if($c->country != ''){
                        if(!in_array($usercountry,$c->country)){
                            return $c;
                        }
                    }else{
                        return $c;
                    }
	    	})->filter();

	    	if(isset($cats)){

	    		return response()->json([
		    		'status'  => 'success',
		    		'btn_view' => View::make('btntab',compact('cats'))->render(),
		    		'tabview2' => View::make('tab2',compact('courses'))->render()
		    	]);

	    	}else{

	    		return response()->json([
		    		'status'  => 'fail'
		    	]);

	    	}
    	}

    }
}
