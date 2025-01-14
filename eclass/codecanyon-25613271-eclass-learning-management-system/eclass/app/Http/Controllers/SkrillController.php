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
use Obydul\LaraSkrill\SkrillClient;
use Obydul\LaraSkrill\SkrillRequest;
use Redirect;
use Session;
use App\Mail\AdminMailOnOrder;
use TwilioMsg;
use App\Setting;

class SkrillController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Skrill Add on For eclass v2.2 and above
    |--------------------------------------------------------------------------
    |
    | © 2020 - AddOn Developer @nkit
    | - Mediacity
    |
     */

    public function pay(Request $request)
    {

        $pay = Crypt::decrypt($request->amount);
        Session::put('payment', $pay);

        $currency = Currency::where('default', '=', '1')->first();

        $request = new SkrillRequest();
        $request->transaction_id = 'SKRILL_' . uniqid(); // generate transaction id
        $request->amount = $pay;
        $request->currency = $currency->code;
        $request->language = Session::get('changed_language');
        $request->prepare_only = '1';
        $request->merchant_fields = 'site_name, customer_email';
        $request->site_name = config('app.url');
        $request->customer_email = Auth::user()->email;
        $request->detail1_description = 'Payment for digital content';
        $request->detail1_text = '';
        $request->pay_to_email = env('SKRILL_MERCHANT_EMAIL');

        // Create object instance of SkrillClient
        $client = new SkrillClient($request);
        $sid = $client->generateSID(); //return SESSION ID

        // handle error
        $jsonSID = json_decode($sid);
        if ($jsonSID != null && $jsonSID->code == "BAD_REQUEST") {
            return $jsonSID->message;
        }

        // do the payment
        $redirectUrl = $client->paymentRedirectUrl($sid); //return redirect url
        return Redirect::to($redirectUrl); // redirect user to Skrill payment page

    }

    public function success(Request $request)
    {

        $txn_id = $request->transaction_id;

        $payment_method = strtoupper('SKRILL');

        $checkout = new OrderStoreController;
        $meeting_id = session()->get('meeting_id', null);

        return $checkout->orderstore($txn_id, $payment_method ,$sale_id = NULL,$file = NULL,$payment_status = NULL, $auth_user_id = NULL, $meeting_id );
       
    }
}
