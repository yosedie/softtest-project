<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Course;
use App\Currency;
use App\InstructorSetting;
use App\Mail\SendOrderMail;
use App\Notifications\UserEnroll;
use App\Order;
use App\PendingPayout;
use App\User;
use App\Wishlist;
use Auth;
use Carbon\Carbon;
use Crypt;
use Illuminate\Http\Request;
use Mail;
use Notification;
use Redirect;
use Session;
use App\Mail\AdminMailOnOrder;
use TwilioMsg;
use App\Setting;

class CashFreeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Cashfree Payment Add on For eclass v2.2 and above
    |--------------------------------------------------------------------------
    |
    | © 2020 - AddOn Developer @nkit
    | - Mediacity
    |
     */

    public function pay(Request $request)
    {

        $pay = $request->amount;
        Session::put('payment', $pay);

        $currency = Currency::where('default', '=', '1')->first();
        if ($currency->code != 'INR') {
            return redirect('/')->with('delete', trans('flash.CashfreeCurrency'));
        }

        $apiEndpoint = env('CASHFREE_END_POINT');

        $opUrl = $apiEndpoint . "/api/v1/order/create";

        $orderid = config('app.name') . '-ORDER-' . uniqid();
        \Session::put('orderid', $orderid);

        $cf_request = array();
        $cf_request["appId"] = env('CASHFREE_APP_ID');
        $cf_request["secretKey"] = env('CASHFREE_SECRET_KEY');
        $cf_request["orderId"] = $orderid;
        $cf_request["orderAmount"] = $pay;
        $cf_request["orderNote"] = "Paying for digital content at " . config('app.name');
        $cf_request["customerPhone"] = $request->phone;
        $cf_request["customerName"] = Auth::user()->name;
        $cf_request["customerEmail"] = $request->email;
        $cf_request["returnUrl"] = url('payviacashfree/success');

        $timeout = 20;

        $request_string = "";
        foreach ($cf_request as $key => $value) {
            $request_string .= $key . '=' . rawurlencode($value) . '&';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$opUrl?");
        curl_setopt($ch, CURLOPT_POST, count($cf_request));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $curl_result = curl_exec($ch);
        curl_close($ch);

        $jsonResponse = json_decode($curl_result);
        if ($jsonResponse->{'status'} == "OK") {
            $paymentLink = $jsonResponse->{"paymentLink"};
            return redirect($paymentLink);
        } else {
            dd($jsonResponse->{'reason'});
        }
    }

    public function success(Request $request)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('CASHFREE_END_POINT') . '/api/v1/order/info/status',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => 'appId=' . env('CASHFREE_APP_ID') . '&secretKey=' . env('CASHFREE_SECRET_KEY') . '&orderId=' . Session::get('orderid'),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {

            $response = json_decode($response, true);

            if ($response['orderStatus'] == 'PAID') {

                $txn_id = $response['referenceId'];

                $payment_method = strtoupper('Cashfree');
                $meeting_id = session()->get('meeting_id', null);

                $checkout = new OrderStoreController;

                return $checkout->orderstore($txn_id, $payment_method ,$sale_id = NULL,$file = NULL,$payment_status = NULL, $auth_user_id = NULL, $meeting_id );


            } else {

                \Session::flash('delete', trans('flash.PaymentFailed'));
                return redirect('/');
            }

        }
    }
}
