<?php

namespace App\Services;

use Twilio\Rest\Client;

class OTPService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));
    }

    public function sendOTP($phone, $otp)
    {
        $message = "Your OTP code is $otp";

        $this->twilio->messages->create($phone, [
            'from' => config('services.twilio.from'),
            'body' => $message
        ]);
    }
}
