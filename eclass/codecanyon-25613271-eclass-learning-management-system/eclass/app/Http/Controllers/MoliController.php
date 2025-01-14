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
use Mollie\Laravel\Facades\Mollie;
use Notification;
use Redirect;
use Session;
use App\Mail\AdminMailOnOrder;
use TwilioMsg;
use App\Setting;

class MoliController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MoliPay Add on For eclass v2.2 and above
    |--------------------------------------------------------------------------
    |
    | © 2020 - AddOn Developer @nkit
    | - Mediacity
    |
     */

    public function pay(Request $request)
    {

        $currency = Currency::where('default', '=', '1')->first();

        if ($currency->code == 'INR') {
            return redirect('/')->with('delete', 'Moli Not Support Indian Payment Currency !');
        }

        $pay = Crypt::decrypt($request->amount);
        Session::put('payment', $pay);

        $amount = sprintf("%.2f", $pay);

        $payment = Mollie::api()->payments()->create([
            'amount' => [
                'currency' => $currency->code,
                'value' => $amount, // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            'description' => 'Payment for digital content',
            'redirectUrl' => route('moli.pay.success'),
        ]);

        $payment = Mollie::api()->payments()->get($payment->id);
        Session::put('payid', $payment->id);
        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);

    }

    public function success(Request $request)
    {

        $payment = Mollie::api()->payments()->get(Session::get('payid'));

        if ($payment->isPaid()) {

            $txn_id = $payment->id;

            $payment_method =  'MOLI';
            $meeting_id = session()->get('meeting_id', null);

            $checkout = new OrderStoreController;

            return $checkout->orderstore($txn_id, $payment_method ,$sale_id = NULL,$file = NULL,$payment_status = NULL, $auth_user_id = NULL, $meeting_id );

        }

        \Session::flash('delete', trans('flash.PaymentFailed'));
        return redirect('/');

    }
}
