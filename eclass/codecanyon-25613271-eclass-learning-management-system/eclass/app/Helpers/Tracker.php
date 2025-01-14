<?php

namespace App\Helpers;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Tracker
{
    // public static function validSettings($code,$domain,$ip){
    //     try{
                
    //             $code = @file_get_contents(public_path() . '/code.txt');

    //             $traced  = @file_get_contents(public_path().'/info.txt');

    //             $d = \Request::getHost();
                
    //             $domain = str_replace("www.", "", $d);

    //             $rdomain = @file_get_contents(public_path().'/ddtl.txt');

    //             if(!$traced || $domain != $rdomain){

    //                 $response = Http::retry(5,100)->post('https://mediacity.co.in/purchase/public/api/track', [
    //                     'code' => $code == 0 ? 'No Purchase Code' : $code,
    //                     'domain' => \Request::getHost(),
    //                     'ip_address' => $ip,
    //                 ]);

    //                 if($response->serverError()){
    //                     Log::emergency('Could not be tracked ! 500 error API');
    //                 }

    //                 if($response->successful()){
    //                     @file_put_contents(public_path().'/info.txt', \Request::getHost());
    //                 }

    //                 return $response->json();

    //             }
    //              }
    //              catch(\Exception $e){

    //         }
        
        
        
    // }
}