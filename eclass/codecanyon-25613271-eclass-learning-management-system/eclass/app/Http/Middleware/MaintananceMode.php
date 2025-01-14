<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\ComingSoon;

class MaintananceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $ip = $request->ip();

        $comingsoon = ComingSoon::first();


        $ip_address = array();

        
        if(isset($comingsoon)){
            if(is_array($comingsoon->allowed_ip) || is_object($comingsoon->allowed_ip)) 
            {
                foreach($comingsoon->allowed_ip as $b)
                {
                    array_push($ip_address, $b);
                }
            }   
        }
        

        $ip_address = array_values(array_filter($ip_address));

        $ip_address = array_flatten($ip_address);
            




        if(isset($ip_address) && in_array($ip, $ip_address))
        {
            return $next($request);
        }
        else
        {
            if(Auth::check() && Auth::user()->role == 'admin'){

                return $next($request);
                
            }
            else{

                if(isset($comingsoon)){

                    if($comingsoon['enable'] == 1){

                        return redirect()->route('comingsoon.show');
                    }
                    else{

                        return $next($request);

                    }
                }
                else{

                    return $next($request);

                }

            }
        }


        return $next($request);
                
            
        
        
    }
}
