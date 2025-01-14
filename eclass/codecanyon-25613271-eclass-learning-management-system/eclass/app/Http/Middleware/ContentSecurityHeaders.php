<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Set X-Frame-Options header to prevent framing of your site
        $response->headers->set('X-Frame-Options', 'DENY');

        // Set Content-Security-Policy header to define the policy
        $response->headers->set('Content-Security-Policy', "default-src 'self'");

        return $response;
    }
}
