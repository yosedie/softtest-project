<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Redirect;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use Crypt;
use Illuminate\Support\Facades\Input;
use DB;
use Auth;
use App\Setting;
use App\User;
use Carbon\Carbon;
use App\PlanSubscribe;
use App\InstructorPlan;
use App\Currency;
use PaytmWallet;

class PlanSubscribeController extends Controller
{

	public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function paypal(Request $request)
    {
    	$plans = InstructorPlan::where('id', $request->plan_id)->first();

    	$currency = Currency::where('default', '=', '1')->first();
    	$gsettings = Setting::first();
    	$currency_code = strtoupper($currency->code);

    	$pay = Crypt::decrypt($request->amount);
    	Session::put('payment',$pay);
		$payer = new Payer();
		        $payer->setPaymentMethod('paypal');
		$item_1 = new Item();
		$item_1->setName('Item 1') /** item name **/
		            ->setCurrency($currency_code)
		            ->setQuantity(1)
		            ->setPrice($pay); /** unit price **/
		$item_list = new ItemList();
		        $item_list->setItems(array($item_1));
		$amount = new Amount();
		        $amount->setCurrency($currency_code)
		            ->setTotal($pay);
		$transaction = new Transaction();
		        $transaction->setAmount($amount)
		            ->setItemList($item_list)
		            ->setDescription('Your transaction description');
		$redirect_urls = new RedirectUrls();
		        $redirect_urls->setReturnUrl(URL::route('callbackpaypal')) /** Specify return URL **/
		            ->setCancelUrl(URL::route('status'));
		$payment = new Payment();
		        $payment->setIntent('Sale')
		            ->setPayer($payer)
		            ->setRedirectUrls($redirect_urls)
		            ->setTransactions(array($transaction));
		        
		try {
			$payment->create($this->_api_context);
		} 
		catch (\PayPal\Exception\PayPalConnectionException $ex) {
			if (\Config::get('app.debug')) {
				\Session::flash('delete', $ex->getMessage());
				return redirect('/');
			} else {
				\Session::flash('delete', $ex->getMessage());
				return redirect('/');
			}
		}

		foreach ($payment->getLinks() as $link) {
			if ($link->getRel() == 'approval_url') {
				$redirect_url = $link->getHref();
			    break;
			}
		}


		/** add payment ID to session **/
		Session::put('paypal_payment_id', $payment->getId());

		Session::put('instructor_plan', $plans->id);

		if (isset($redirect_url)) {
		/** redirect to paypal **/
		    return Redirect::away($redirect_url);
		}

		\Session::put('error', 'Unknown error occurred');
		        return redirect('/');

    }


    public function paypalcallback(Request $request)
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        $amount = Session::get('payment');
		/** clear the session payment ID **/
		        Session::forget('paypal_payment_id');
		        if (empty($request->get('PayerID')) || empty($request->get('token')))

		         {
		\Session::flash('delete', trans('flash.PaymentFailed'));
		            return Redirect('/');
		}
		 $payment = Payment::get($payment_id, $this->_api_context);
		    	$execution = new PaymentExecution();
		        $execution->setPayerId($request->get('PayerID'));
		/**Execute the payment **/
		    $result = $payment->execute($execution, $this->_api_context);



		if ($result->getState() == 'approved') {

			$transactions = $payment->getTransactions();
		    $relatedResources = $transactions[0]->getRelatedResources();
		    $sale = $relatedResources[0]->getSale();
		    $saleId = $sale->getId();

			$currency = Currency::where('default', '=', '1')->first();

			$instructor_plan_id = Session::get('instructor_plan');
			
			$plans = InstructorPlan::where('id',$instructor_plan_id)->first();
		   
		   	 
	   		if ($plans->discount_price != 0)
            {
                $pay_amount =  $plans->discount_price;
            }
            else
            {
                $pay_amount =  $plans->price;
            } 


            $lastOrder = PlanSubscribe::orderBy('created_at', 'desc')->first();

            if ( ! $lastOrder )
            {
                // We get here if there is no order at all
                // If there is no number set it to 0, which will be 1 at the end.
                $number = 0;
            }
            else
            { 
                $number = substr($lastOrder->order_id, 3);
            }

            
            if($plans->duration_type == "m")
            {
                
                if($plans->duration != NULL && $plans->duration !='')
                {
                    $days = $plans->duration * 30;
                    $todayDate = date('Y-m-d');
                    $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                }
                else{
                    $todayDate = NULL;
                    $expireDate = NULL;
                }
            }
            else
            {

                if($plans->duration != NULL && $plans->duration !='')
                {
                    $days = $plans->duration;
                    $todayDate = date('Y-m-d');
                    $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                }
                else{
                    $todayDate = NULL;
                    $expireDate = NULL;
                }

            }

               
	                   
	        $created_order = PlanSubscribe::create([
	        	'plan_id' => $plans->id,
	        	'user_id' => Auth::User()->id,
	        	'order_id' => '#' . sprintf("%08d", intval($number) + 1),
	            'transaction_id' => $payment_id,
	            'payment_method' => 'PayPal',
	            'total_amount' => $pay_amount,
	            'currency' => $currency->code,
	            'currency_icon' => $currency->symbol,
	            'duration' => $plans->duration,
	            'duration_type' => $plans->duration_type,
	            'enroll_start' => $todayDate,
                'enroll_expire' => $expireDate,
	            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
	            ]
	        );


	        Session::forget('instructor_plan');
        	

        	\Session::flash('success', trans('flash.PaymentSuccess'));
		    return redirect('/');

	    }

	    
		

		 Session::forget('instructor_plan');

		\Session::flash('delete', trans('flash.PaymentFailed'));
		    return redirect('/');
	}

    public function paytm(Request $request)
    {

    	$plans = InstructorPlan::where('id', $request->plan_id)->first();

    	Session::put('instructor_plan', $plans->id);


    	$appurl = env('APP_URL');

        $payment = PaytmWallet::with('receive');
        $payment->prepare([
          'order' => str_random(32),
          'user' => Auth::User()->id,
          'mobile_number' => $request->mobile,
          'email' => $request->email,
          'amount' => $request->amount,
          'callback_url' => url('subscribeinstructor/status')
        ]);
        return $payment->receive();

    }

    public function paymentsubscribe(Request $request)
    {

    	$transaction = PaytmWallet::with('receive');

        $response = $transaction->response();
        $order_id = $transaction->getOrderId();

        $gsettings = Setting::first();

        if($transaction->isSuccessful()){

        	$currency = Currency::where('default', '=', '1')->first();

			$instructor_plan_id = Session::get('instructor_plan');
			
			$plans = InstructorPlan::where('id',$instructor_plan_id)->first();
		   
		   	 
	   		if ($plans->discount_price != 0)
            {
                $pay_amount =  $plans->discount_price;
            }
            else
            {
                $pay_amount =  $plans->price;
            } 


            $lastOrder = PlanSubscribe::orderBy('created_at', 'desc')->first();

            if ( ! $lastOrder )
            {
                // We get here if there is no order at all
                // If there is no number set it to 0, which will be 1 at the end.
                $number = 0;
            }
            else
            { 
                $number = substr($lastOrder->order_id, 3);
            }

            
            if($plans->duration_type == "m")
            {
                
                if($plans->duration != NULL && $plans->duration !='')
                {
                    $days = $plans->duration * 30;
                    $todayDate = date('Y-m-d');
                    $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                }
                else{
                    $todayDate = NULL;
                    $expireDate = NULL;
                }
            }
            else
            {

                if($plans->duration != NULL && $plans->duration !='')
                {
                    $days = $plans->duration;
                    $todayDate = date('Y-m-d');
                    $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                }
                else{
                    $todayDate = NULL;
                    $expireDate = NULL;
                }

            }

               
	                   
	        $created_order = PlanSubscribe::create([
	        	'plan_id' => $plans->id,
	        	'user_id' => Auth::User()->id,
	        	'order_id' => '#' . sprintf("%08d", intval($number) + 1),
	            'transaction_id' => $response['TXNID'],
	            'payment_method' => 'PayTM',
	            'total_amount' => $pay_amount,
	            'currency' => $currency->code,
	            'currency_icon' => $currency->symbol,
	            'duration' => $plans->duration,
	            'duration_type' => $plans->duration_type,
	            'enroll_start' => $todayDate,
                'enroll_expire' => $expireDate,
	            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
	            ]
	        );


	        Session::forget('instructor_plan');
        	

        	\Session::flash('success', trans('flash.PaymentSuccess'));
		    return redirect('/');



        }else if($transaction->isFailed()){

        	Session::forget('instructor_plan');
        
          \Session::flash('delete', trans('flash.PaymentFailed'));
            return redirect('/');
        }

    }


    public function freecheckout(Request $request)
    {

        $gsettings = Setting::first();
        $currency = Currency::where('default', '=', '1')->first();

        $plans = InstructorPlan::where('id',$request->plan_id)->first();
           
             
            if ($plans->discount_price != 0)
            {
                $pay_amount =  $plans->discount_price;
            }
            else
            {
                $pay_amount =  $plans->price;
            } 


            $lastOrder = PlanSubscribe::orderBy('created_at', 'desc')->first();

            if ( ! $lastOrder )
            {
                // We get here if there is no order at all
                // If there is no number set it to 0, which will be 1 at the end.
                $number = 0;
            }
            else
            { 
                $number = substr($lastOrder->order_id, 3);
            }

            
            if($plans->duration_type == "m")
            {
                
                if($plans->duration != NULL && $plans->duration !='')
                {
                    $days = $plans->duration * 30;
                    $todayDate = date('Y-m-d');
                    $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                }
                else{
                    $todayDate = NULL;
                    $expireDate = NULL;
                }
            }
            else
            {

                if($plans->duration != NULL && $plans->duration !='')
                {
                    $days = $plans->duration;
                    $todayDate = date('Y-m-d');
                    $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                }
                else{
                    $todayDate = NULL;
                    $expireDate = NULL;
                }

            }

               
                       
            $created_order = PlanSubscribe::create([
                'plan_id' => $plans->id,
                'user_id' => Auth::User()->id,
                'order_id' => '#' . sprintf("%08d", intval($number) + 1),
                'total_amount' => 'Free',
                'currency' => $currency->code,
                'currency_icon' => $currency->symbol,
                'duration' => $plans->duration,
                'duration_type' => $plans->duration_type,
                'enroll_start' => $todayDate,
                'enroll_expire' => $expireDate,
                'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                ]
            );


            Session::forget('instructor_plan');
            

            \Session::flash('success', trans('flash.PaymentSuccess'));
            return redirect('/plan/instructor/subscription');

    }

   
}
