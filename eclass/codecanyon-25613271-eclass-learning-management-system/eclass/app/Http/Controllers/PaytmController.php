<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PaytmWallet;
use Session;
use Redirect;
use DB;
use Auth;
use App\Cart;
use App\Wishlist;
use App\Order;
use App\Currency;
use Mail;
use App\Mail\SendOrderMail;
use App\Notifications\UserEnroll;
use App\Course;
use App\User;
use Notification;
use Carbon\Carbon;
use App\InstructorSetting;
use App\PendingPayout;
use App\Mail\AdminMailOnOrder;
use TwilioMsg;
use App\Setting;

class PaytmController extends Controller
{
    /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */

    public function order(Request $request)
    {
        $appurl = env('APP_URL');
        $payment = PaytmWallet::with('receive');
        $payment->prepare([
          'order' => str_random(32),
          'user' => Auth::User()->id,
          'mobile_number' => $request->mobile,
          'email' => $request->email,
          'amount' => $request->amount,
          'callback_url' => url('payment/status')
        ]);
        return $payment->receive();
    }

    /**
     * Obtain the payment information.
     *
     * @return Object
     */
    public function paymentCallback()
    {
        $transaction = PaytmWallet::with('receive');
        $response = $transaction->response();
        $order_id = $transaction->getOrderId();
        if($transaction->isSuccessful()){
            $txn_id = $transaction->getTransactionId();
            $payment_method = 'PayTM';
            $meeting_id = session()->get('meeting_id', null);
            $checkout = new OrderStoreController;
            return $checkout->orderstore($txn_id, $payment_method ,$sale_id = NULL,$file = NULL,$payment_status = NULL, $auth_user_id = NULL, $meeting_id );
        }else if($transaction->isFailed()){
            $res = $transaction->getResponseMessage();
          \Session::flash('delete',  $res);
            return redirect('/');
        }

    }
}
