<?php

namespace App\Helpers;


use Twilio\Rest\Client;

class TwilioMsg
{ 

    public static function sendMessage($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        if(empty($recipients)){
            $recipients = 0;
        }
        $client->messages->create($recipients, ['from' => $twilio_number, 'body' => $message]);
    }

}
