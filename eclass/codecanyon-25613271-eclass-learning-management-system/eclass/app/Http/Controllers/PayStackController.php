<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Paystack;
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
use Session;
use App\Mail\AdminMailOnOrder;
use TwilioMsg;
use App\Setting;

class PayStackController extends Controller
{
    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway(Request $request)
    {
        try{
            $auth = Auth::user();
            $data = [
                'user' => $auth->id,
                'mobile_number' => $auth->mobile ?? '',
                'email' => $auth->email,
                'amount' => (int) ($request->input('amount') * 100),
                'reference' => uniqid(),
                'currency' => 'NGN',
                'callback_url' => route('paystack.callback')
            ];
            return Paystack::getAuthorizationUrl($data)->redirectNow();
        }
        catch(\Exception $ex){
            \Session::flash('delete', $ex->getMessage());
            return redirect('all/cart');
        }
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();
        $paymentdata = $paymentDetails['data'];
        if($paymentDetails['status'] == 'true') {
            $txn_id = $paymentdata['reference'];
            $payment_method = 'Paystack';
            $meeting_id = session()->get('meeting_id', null);
            $checkout = new OrderStoreController;
            return $checkout->orderstore($txn_id, $payment_method ,$sale_id = NULL,$file = NULL,$payment_status = NULL, $auth_user_id = NULL, $meeting_id );
		}
		\Session::flash('delete', trans('flash.Payment Failed'));
		    return redirect('/');
    }
}
