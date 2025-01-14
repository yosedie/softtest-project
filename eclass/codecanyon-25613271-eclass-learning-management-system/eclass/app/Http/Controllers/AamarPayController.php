<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Shipu\Aamarpay\Facades\Aamarpay;
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

class AamarPayController extends Controller
{
    public function paymentSuccess(Request $request)
    {
     
        if($request->get('pay_status') == 'Failed') {

            \Session::flash('delete', trans('flash.PaymentFailed'));
            return redirect('/');
        }
         if($request->get('pay_status') == 'Successful') {
            $txn_id = $request->pg_txnid;
            $payment_method = 'AamarPay';
            $meeting_id = session()->get('meeting_id', null);
            $checkout = new OrderStoreController;
            return $checkout->orderstore($txn_id, $payment_method ,$sale_id = NULL,$file = NULL,$payment_status = NULL, $auth_user_id = NULL, $meeting_id );
           
        } else {

           \Session::flash('delete', trans('flash.PaymentFailed'));
            return redirect('/'); 
        }
        
        return redirect('/'); 

    }

    public function paymentFailed()
    {
    	\Session::flash('delete', trans('flash.PaymentFailed'));
            return redirect('/');
    }

    public function paymentCancel()
    {

    	\Session::flash('delete', 'Payment Canceled');
        return redirect('all/cart');
    	
    }
}
