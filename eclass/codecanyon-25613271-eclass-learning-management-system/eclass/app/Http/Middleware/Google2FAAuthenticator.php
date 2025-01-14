<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class Google2FAAuthenticator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {  

        if(auth()->check() && auth()->user()->google2fa_enable == '1'){

            if(Cookie::get('two_fa') == 1){

                return $next($request);
                
            }else{
                

                return Response(view('google2fa.verify'));
            }
 
        }else{

            return $next($request);
        }

    }
}
