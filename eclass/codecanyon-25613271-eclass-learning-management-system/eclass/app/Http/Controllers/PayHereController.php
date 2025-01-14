<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
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

class PayHereController extends Controller
{
    public function notifyUrl(Request $request){

    	return 'notify';

	 //As their documentation
	 $merchant_id = $request -> input('merchant_id');
	 $order_id =  $request -> input('order_id');
	 $payhere_amount =  $request -> input('payhere_amount');
	 $payhere_currency =  $request -> input('payhere_currency');
	 $status_code =  $request -> input('status_code');
	 $md5sig =  $request -> input('md5sig');

	 $merchant_secret = 'xxxxxxxxxxxxxxxxxxxx'; // Replace with your Merchant Secret (Can be found on your PayHere account's Settings page)

	 $local_md5sig = strtoupper (md5 ( $merchant_id . $order_id . $payhere_amount . $payhere_currency . $status_code . strtoupper(md5($merchant_secret)) ) );
	// return $status_code;
	if (($local_md5sig === $md5sig) AND ($status_code == 2) ){

	 $newStatus = new Status();
	 $newStatus ->status= 2;
	 $newStatus ->save();

	 }elseif(($local_md5sig === $md5sig) AND ($status_code == 0) ){

	 $newStatus = new Status();
	 $newStatus ->status= 0;
	 $newStatus ->save();

	 }elseif(($local_md5sig === $md5sig) AND ($status_code == -1) ){

	 $newStatus = new Status();
	 $newStatus ->status= -1;
	 $newStatus ->save();

	 }elseif(($local_md5sig === $md5sig) AND ($status_code == -2) ){

	 $newStatus = new Status();
	 $newStatus ->status= -2;
	 $newStatus ->save();

	 }elseif(($local_md5sig === $md5sig) AND ($status_code == -3) ){

	 $newStatus = new Status();
	 $newStatus ->status= -3;
	 $newStatus ->save();

	 }else{

	 $newStatus = new Status();
	 $newStatus ->status= 'Fail';
	 $newStatus ->save();

	 }
	}

	 public function cancelUrl(Request $request){

	 	\Session::flash('delete', trans('flash.PaymentFailed'));
		return redirect('/');

	 }


	 public function returnUrl(Request $request)
	 {

	 	$authcode =  base64_encode(env('PAYHERE_BUISNESS_APP_CODE').':'.env('PAYHERE_APP_SECRET'));
		if(env('PAYHERE_MODE') == 'sandbox'){
            $tokenurl = 'https://sandbox.payhere.lk/merchant/v1/oauth/token';
        }else{
            $tokenurl = 'https://www.payhere.lk/merchant/v1/oauth/token';
        }  


		$response = Http::asForm()->withHeaders([
            'Authorization' => 'Basic '.$authcode
        ])->post($tokenurl,[
            'grant_type' => 'client_credentials'
        ]);


		if($response->successful()){
        $result      =  $response->json();
        $accessToken =  $result['access_token'];

        // return $accessToken;
        if(env('PAYHERE_MODE') == 'sandbox'){
                $orderurl = 'https://sandbox.payhere.lk/merchant/v1/payment/search?order_id=';
            }else{
                $orderurl = 'https://www.payhere.lk/merchant/v1/payment/search?order_id=';
            }

            $paymentStatus = Http::withHeaders([
                'Authorization' => 'Bearer '.$accessToken
            ])->get($orderurl.$request->order_id);

	        $status = $paymentStatus->json();

	        // return $status;

	        if($status['data'] == NULL){
	            $sentfromlastpage = 0;

	            \Session::flash('delete', trans('flash.PaymentFailed'));
		    	return redirect('/');

	        }else{

	           	$txnid = $status['data'][0]['payment_id'];

	           	$currency = Currency::where('default', '=', '1')->first();

	           	$gsettings = Setting::first();
			
				$carts = Cart::where('user_id',Auth::User()->id)->get();
			   
			   	foreach($carts as $cart)
			   	{ 
			   		if ($cart->offer_price != 0)
		            {
		                $pay_amount =  $cart->offer_price;
		            }
		            else
		            {
		                $pay_amount =  $cart->price;
		            }

		            if ($cart->disamount != 0 || $cart->disamount != NULL)
		            {
		                $cpn_discount =  $cart->disamount;
		            }
		            else
		            {
		                $cpn_discount =  '';
		            }


	                $lastOrder = Order::orderBy('created_at', 'desc')->first();

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

	                if($cart->type == 1)
	                {
	                    $bundle_id = $cart->bundle_id;
	                    $bundle_course_id = $cart->bundle->course_id;
	                    $course_id = NULL;
	                    $duration = NULL;
	                    $instructor_payout = 0;
	                    $instructor_id = $cart->bundle->user_id;

	                    if($cart->bundle->duration_type == "m")
	                    {
	                        
	                        if($cart->bundle->duration != NULL && $cart->bundle->duration !='')
	                        {
	                            $days = $cart->bundle->duration * 30;
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

	                        if($cart->bundle->duration != NULL && $cart->bundle->duration !='')
	                        {
	                            $days = $cart->bundle->duration;
	                            $todayDate = date('Y-m-d');
	                            $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
	                        }
	                        else{
	                            $todayDate = NULL;
	                            $expireDate = NULL;
	                        }

	                    }
	                }
	                else{


	                	if($cart->courses->duration_type == "m")
	                    {
	                        
	                        if($cart->courses->duration != NULL && $cart->courses->duration !='')
	                        {
	                            $days = $cart->courses->duration * 30;
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

	                        if($cart->courses->duration != NULL && $cart->courses->duration !='')
	                        {
	                            $days = $cart->courses->duration;
	                            $todayDate = date('Y-m-d');
	                            $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
	                        }
	                        else{
	                            $todayDate = NULL;
	                            $expireDate = NULL;
	                        }

	                    }
	                    

	                    $setting = InstructorSetting::first();

	                    if($cart->courses->instructor_revenue != NULL)
	                    {
	                        $x_amount = $pay_amount * $cart->courses->instructor_revenue;
	                        $instructor_payout = $x_amount / 100;
	                    }
	                    else
	                    {

	                        if(isset($setting))
	                        {
	                            if($cart->courses->user->role == "instructor")
	                            {
	                                $x_amount = $pay_amount * $setting->instructor_revenue;
	                                $instructor_payout = $x_amount / 100;
	                            }
	                            else
	                            {
	                                $instructor_payout = 0;
	                            }
	                            
	                        }
	                        else
	                        {
	                            $instructor_payout = 0;
	                        }  
	                    }

	                    $bundle_id = NULL;
	                    $course_id = $cart->course_id;
	                    $bundle_course_id = NULL;
	                    $duration = $cart->courses->duration;
	                    $instructor_id = $cart->courses->user_id;
	                }
		                   
			        $created_order = Order::create([
			        	'course_id' => $course_id,
			        	'user_id' => Auth::User()->id,
			        	'instructor_id' => $instructor_id,
			        	'order_id' => '#' . sprintf("%08d", intval($number) + 1),
			            'transaction_id' => $txnid,
			            'payment_method' => 'PayHere',
			            'total_amount' => $pay_amount,
			            'coupon_discount' => $cpn_discount,
			            'currency' => $currency->code,
			            'currency_icon' => $currency->symbol,
			            'duration' => $duration,
			            'enroll_start' => $todayDate,
	                    'enroll_expire' => $expireDate,
	                    'bundle_id' => $bundle_id,
	                    'bundle_course_id' => $bundle_course_id,
			            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
			            ]
			        );
			        
			        Wishlist::where('user_id',Auth::User()->id)->where('course_id', $cart->course_id)->delete();

			        Cart::where('user_id',Auth::User()->id)->where('course_id', $cart->course_id)->delete();


			        if($instructor_payout != 0)
	            	{
				        if($created_order)
				        {
				        	if($cart->type == 0)
		                    {
			                    if($cart->courses->user->role == "instructor")
			                    {

			                        $created_payout = PendingPayout::create([
			                            'user_id' => $cart->courses->user_id,
			                            'course_id' => $cart->course_id,
			                            'order_id' => $created_order->id,
			                            'transaction_id' => $txnid,
			                            'total_amount' => $pay_amount,
			                            'currency' => $currency->code,
			                            'currency_icon' => $currency->symbol,
			                            'instructor_revenue' => $instructor_payout,
			                            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
			                            'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
			                            ]
			                        );
			                    }
			                }
		                }
		            }

		            if($created_order){
					    if ($gsettings->twilio_enable == '1') {

					        try{
					            $recipients = Auth::user()->mobile;
					            

					            $msg = 'Hey'. ' ' .Auth::user()->fname . ' '.
					                    'You\'r successfully enrolled in '. $cart->courses->title .
					                    'Thanks'. ' ' . config('app.name');
					        
					            TwilioMsg::sendMessage($msg, $recipients);

					        }catch(\Exception $e){
					            
					        }

					    }
					}
		            

			        if($created_order){
						try{
							
							/*sending email*/
							$x = 'You are successfully enrolled in a course';
							$order = $created_order;
							Mail::to(Auth::User()->email)->send(new SendOrderMail($x, $order));

							/*sending admin email*/
	                        $x = 'User Enrolled in course '. $cart->courses->title;
	                        $order = $created_order;
	                        Mail::to($cart->courses->user->email)->send(new AdminMailOnOrder($x, $order));


						}catch(\Swift_TransportException $e){
							Session::flash('deleted',trans('flash.PaymentMailError'));
							return redirect('confirmation');
						}
					}

					if($cart->type == 0)
	                {

						if($created_order){
							// Notification when user enroll
					        $cor = Course::where('id', $cart->course_id)->first();

					        $course = [
					          'title' => $cor->title,
					          'image' => $cor->preview_image,
					        ];

					        $enroll = Order::where('course_id', $cart->course_id)->get();

					        if(!$enroll->isEmpty())
					        {
					            foreach($enroll as $enrol)
					            {
					                $user = User::where('id', $enrol->user_id)->get();
					                Notification::send($user,new UserEnroll($course));
					            }
					        }
						}
					}
			    }
			}

	  		// \Session::flash('success', trans('flash.PaymentSuccess'));
		    return redirect('confirmation'); 
	 	}
	}
}
