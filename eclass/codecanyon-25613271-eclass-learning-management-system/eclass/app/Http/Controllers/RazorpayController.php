<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Order;
use Redirect,Response;
use App\Cart;
use Auth;
use DB;
use App\Currency;
use Session;
use App\Wishlist;
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

class RazorpayController extends Controller
{

	public function pay() {
        return view('razorpay');
    }

    public function dopayment(Request $request) 
    {
        $user_email = Auth::User()->email;
        $com_email = env('MAIL_FROM_ADDRESS');
        $txn_id = $request->razorpay_payment_id;
        $payment_method = 'RazorPay';
        $checkout = new OrderStoreController;
        // Get the meeting ID from the session
        $meeting_id = session()->get('meeting_id', null);
        return $checkout->orderstore($txn_id, $payment_method ,$sale_id = NULL,$file = NULL,$payment_status = NULL, $auth_user_id = NULL, $meeting_id );
    }


}
