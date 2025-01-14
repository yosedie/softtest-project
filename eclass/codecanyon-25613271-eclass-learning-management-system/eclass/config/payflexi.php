<?php

return [

    /**
     * Public Key: Your PayFlexi publicKey. Sign up on https://merchant.payflexi.co to get one from your settings page
     *
     */
    'publicKey' => env('PAYFLEXI_PUBLIC_KEY'),

    /**
     * Secret Key: Your PayFlexi secretKey. Sign up on https://merchant.payflexi.co to get one from your settings page
     *
     */
    'secretKey' => env('PAYFLEXI_SECRET_KEY'),
    /**
     * Environment: This can either be 'text' or 'live'
     *
     */
    'gateway' => env('PAYFLEXI_PAYMENT_GATEWAY', 'stripe'),
    /**
     * Environment: This can either be 'text' or 'live'
     *
     */
    'env' => env('PAYFLEXI_ENVIRONMENT', 'test'),
    
    /**
     * PayFlexi Webhook URL
     *
     */
    'webhookUrl' => getenv('PAYFLXI_WEBHOOK_URL'),

];
