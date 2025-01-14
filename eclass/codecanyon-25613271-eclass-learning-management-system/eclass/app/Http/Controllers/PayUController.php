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
use Tzsk\Payu\Concerns\Attributes;
use Tzsk\Payu\Concerns\Customer;
use Tzsk\Payu\Concerns\Transaction;
use Tzsk\Payu\Facades\Payu;
use TwilioMsg;
use App\Setting;

class PayUController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Payu Add on For eclass v2.2 and above
    |--------------------------------------------------------------------------
    |
    | © 2020 - AddOn Developer @nkit
    | PayU Package By : Kazi Mainuddin Ahmed
    | - Mediacity
     */

    public function pay(Request $request)
    {

        $pay = Crypt::decrypt($request->amount);
        Session::put('payment', $pay);

        $currency = Currency::where('default', '=', '1')->first();

        

         $customer = Customer::make()
            ->firstName(Auth::user()->fname)
            ->email(Auth::user()->email);

         $attributes = Attributes::make()
            ->udf1('Payment for Online Courses');

         $transaction = Transaction::make()
            ->charge($pay)
            ->for('Online Courses')
            ->with($attributes)
            ->to($customer);

        return Payu::initiate($transaction)->redirect(route('payu.success'));


    }

    public function success(Request $request)
    {

         $payment = Payu::capture();

         $gsettings = Setting::first();

        if ($payment->successful()) {
            $txn_id = $payment->transaction_id;
            $payment_method =  strtoupper(env('PAYU_DEFAULT'));
            $meeting_id = session()->get('meeting_id', null);
            $checkout = new OrderStoreController;
            return $checkout->orderstore($txn_id, $payment_method ,$sale_id = NULL,$file = NULL,$payment_status = NULL, $auth_user_id = NULL, $meeting_id );

        }
        else{

            \Session::flash('delete', trans('flash.PaymentFailed'));
            return redirect('/');

        }

        

    }
}
