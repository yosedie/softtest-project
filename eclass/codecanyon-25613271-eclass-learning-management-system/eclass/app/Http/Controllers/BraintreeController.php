<?php

namespace App\Http\Controllers;

use App\Config;
use App\Menu;
use App\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Session;
use Redirect;
use Validator;
use DB;
use App\Cart;
use App\Wishlist;
use App\Order;
use App\Currency;
use Braintree;
use App\Mail\SendOrderMail;
use App\Notifications\UserEnroll;
use App\Course;
use App\User;
use Notification;
use App\InstructorSetting;
use App\PendingPayout;
use App\Mail\AdminMailOnOrder;
use TwilioMsg;
use App\Setting;

class BraintreeController extends Controller
{
	

	public function payment(Request $request)
	{

		
	    $gateway = new Braintree\Gateway([
	        'environment' => env('BRAINTREE_ENV'),
	            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
	            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
	            'privateKey' => env('BRAINTREE_PRIVATE_KEY'),
	    ]);

	    $amount = $request->amount;
	    $nonce = $request->payment_method_nonce;

	    $result = $gateway->transaction()->sale([
	        'amount' => $amount,
	        'paymentMethodNonce' => $nonce,
	        'customerId' => $this->createCustomer(),
	        'options' => [
	            'submitForSettlement' => true
	        ]
	    ]);

	    // return $result;


	    if ($result->success) {
	        $transaction = $result->transaction;
	        // header("Location: transaction.php?id=" . $transaction->id);

	        $txnx_id = $result->transaction->id;


            $txn_id = $txnx_id;

            $payment_method = 'Braintree';
            $meeting_id = session()->get('meeting_id', null);

            $checkout = new OrderStoreController;

            return $checkout->orderstore($txn_id, $payment_method ,$sale_id = NULL,$file = NULL,$payment_status = NULL, $auth_user_id = NULL, $meeting_id );


	       
	        // return back()->with('success_message', 'Transaction successful. The ID is:'. $transaction->id);
	    } else {
	        $errorString = "";

	        foreach ($result->errors->deepAll() as $error) {
	            $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
	        }

	        // $_SESSION["errors"] = $errorString;
	        // header("Location: index.php");
	        // return back()->withErrors('An error occurred with the message: '.$result->message);

	        \Session::flash('delete', trans('flash.PaymentFailed'));
            return redirect('/');
	    }
	}

	public function createCustomer()
	{
	  	if (!Auth::user()->braintree_id) {

            $gateway = $this->brainConfig();

            $result = $gateway->customer()->create([
                'firstName' => Auth::user()->name,
                'email' => Auth::user()->email,
            ]);

            if ($result->success) {
                User::where('id', Auth::user()->id)->update(['braintree_id' => $result->customer->id]);
                return $result->customer->id;
            }

        } else {
            return Auth::user()->braintree_id;
        }
	}


	public function brainConfig()
    {

        return $gateway = new Braintree\Gateway([
            'environment' => env('BRAINTREE_ENV'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY'),
        ]);

    }



	



}
