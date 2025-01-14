<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'payment/status*',
        '/payviacashfree/success',
        'featurepayment/status',
        'payvia/sslcommerze/success',
        'payvias/sslcommerze/cancel',
        'payvia/sslcommerze/fail',
        'payvia/sslcommerze/ipn',
        'return/izy/success',
        'payment/success',
        'payment/cancel',
        'payment/failed',
        'subscribeinstructor/status',
        '/wallet/status/paytm',
        '/paytabs/callback',
        '/payment/pay-success'
    ];
}
