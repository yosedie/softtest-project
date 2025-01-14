<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CheckReferral
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

        if( $request->hasCookie('referral')) {
            return $next($request);
        }
        else {
            if( $request->query('ref') ) {
                Cookie::queue('referral',$request->query('ref'));
            }
        }

        return $next($request);
        
    }
}
