<?php

use App\Currency;
use App\ReviewRating;

if (!function_exists('get_release')) {
    function get_release()
    {
        $version = @file_get_contents(storage_path() . '/app/bugfixer/version.json');
        $version = json_decode($version, true);
        echo $version['subversion'];
    }
}

function purchase_code($code)
{

    $personalToken = "7T9Ichy4xYzXyfDpYjBKwvdYWe48GX5s";

    if (!preg_match("/^(\w{8})-((\w{4})-){3}(\w{12})$/", $code)) {
        //throw new Exception("Invalid code");
        $message = __("Invalid Purchase Code");
        return $message;
    }

    $ch = curl_init($code);

    curl_setopt_array($ch, array(
        CURLOPT_URL => "https://api.envato.com/v3/market/author/sale?code={$code}",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 20,

        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer {$personalToken}",
        ),
    ));

    // Send the request with warnings supressed
    $response = curl_exec($ch);

    // Handle connection errors (such as an API outage)
    if (curl_errno($ch) > 0) {
        //throw new Exception("Error connecting to API: " . curl_error($ch));
        $message = __("Error connecting to API !");
        return $message;
    }
    // If we reach this point in the code, we have a proper response!
    // Let's get the response code to check if the purchase code was found
    $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // HTTP 404 indicates that the purchase code doesn't exist
    if ($responseCode === 403) {
        //throw new Exception("The purchase code was invalid");
        return reverify($code);
    }

    // HTTP 404 indicates that the purchase code doesn't exist
    if ($responseCode === 404) {
        //throw new Exception("The purchase code was invalid");
        return reverify($code);
    }

    // Anything other than HTTP 200 indicates a request or API error
    // In this case, you should again ask the user to try again later
    if ($responseCode !== 200) {
        //throw new Exception("Failed to validate code due to an error: HTTP {$responseCode}");
        $message = __("Failed to validate code.");
        return $message;
    }

    // Parse the response into an object with warnings supressed
    $body = json_decode($response);

    // Check for errors while decoding the response (PHP 5.3+)
    if ($body === false && json_last_error() !== JSON_ERROR_NONE) {
        //new Exception("Error parsing response");
        $message = __("Can't Verify Now.");
        return $message;
    }

    return $responseCode;

}

function reverify($code)
{

    $personalToken = "inNy83FTjV2CTPqvNdPGRr2mAJ0raPC4";

    if (!preg_match("/^(\w{8})-((\w{4})-){3}(\w{12})$/", $code)) {
        //throw new Exception("Invalid code");
        $message = __("Invalid Purchase Code");
        return $message;
    }

    $ch = curl_init($code);

    curl_setopt_array($ch, array(
        CURLOPT_URL => "https://api.envato.com/v3/market/author/sale?code={$code}",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 20,

        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer {$personalToken}",
        ),
    ));

    // Send the request with warnings supressed
    $response = curl_exec($ch);

    // Handle connection errors (such as an API outage)
    if (curl_errno($ch) > 0) {
        //throw new Exception("Error connecting to API: " . curl_error($ch));
        $message = __("Error connecting to API !");
        return $message;
    }
    // If we reach this point in the code, we have a proper response!
    // Let's get the response code to check if the purchase code was found

    $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // HTTP 404 indicates that the purchase code doesn't exist
    if ($responseCode === 404) {
        //throw new Exception("The purchase code was invalid");
        return reverify($code);
    }

    // Anything other than HTTP 200 indicates a request or API error
    // In this case, you should again ask the user to try again later
    if ($responseCode !== 200) {
        //throw new Exception("Failed to validate code due to an error: HTTP {$responseCode}");
        $message = __("Failed to validate code.");
        return $message;
    }

    // Parse the response into an object with warnings supressed
    $body = json_decode($response);

    // Check for errors while decoding the response (PHP 5.3+)
    if ($body === false && json_last_error() !== JSON_ERROR_NONE) {
        //new Exception("Error parsing response");
        $message = __("Can't Verify Now.");
        return $message;
    }

    if ($body->item->id == '34807246') {

        return 200;
    } else {
        return 404;
    }

    return $responseCode;
}

if (!function_exists('course_rating')) {
    function course_rating($id)
    {
        if (isset($id)) {
            $reviews = ReviewRating::where('course_id', $id)->where('status', '1')->get();
            $count = ReviewRating::where('course_id', $id)->count();
            $learn = 0;
            $price = 0;
            $value = 0;
            $sub_total = 0;
            $sub_total = 0;
            $total_rating_percent = 0;
            $course_total_rating = 0;
            $total_rating = 0;

            if ($count > 0) {
                foreach ($reviews as $review) {
                    $learn = $review->learn * 5;
                    $price = $review->price * 5;
                    $value = $review->value * 5;
                    $sub_total = $sub_total + $learn + $price + $value;
                }
                $count = ($count * 3) * 5;
                $rat = $sub_total / $count;
                $ratings_var0 = ($rat * 100) / 5;
                $course_total_rating = $ratings_var0;
            }

            $count = ($count * 3) * 5;

            if ($count != "" && $count != 0) {
                $rat = $sub_total / $count;
                $ratings_var = ($rat * 100) / 5;
                $overallrating = ($ratings_var0 / 2) / 10;
                $total_rating = round($overallrating, 1);
            }
            $total_rating_percent = round($course_total_rating, 2);
            $total_rating = $total_rating;

            return response()->json([
                'total_rating' => $total_rating,
                'total_rating_percent' => $total_rating_percent,
            ]);
        }
    }
}
if (!function_exists('price_format')) {
    function price_format($price)
    {
        if (env('PRICE_DISPLAY_FORMAT') == 'comma') {
            // French notation
            return sprintf('%s', number_format($price, 2, ',', ' '));
        } else {
            // English notation without thousands separator
            return number_format($price, 2, '.', '');
        }
    }
}
if(!function_exists('activeCurrency')){
    function activeCurrency(){
        /** find active currency */
        if(session()->has('changed_currency')){
            $cur = Currency::where('code','=',session()->get('changed_currency'))->first();
            if(isset($cur)){
                return response()->json([
                    'symbol'=> $cur->symbol,
                    'position' => $cur->position
                ]);
            }
        }else{
            $cur = Currency::where('default','=','1')->first();
            if(isset($cur)){
                return response()->json([
                    'symbol'=> $cur->symbol,
                    'position' => $cur->position
                ]);
            }
        }
        /** If no currency found or session has no currency return default currency */
       // return Currency::where('default','=','1')->first();

    }
}

