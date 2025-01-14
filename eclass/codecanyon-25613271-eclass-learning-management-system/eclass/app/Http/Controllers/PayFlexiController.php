<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Auth;
use App\Cart;
use App\Wishlist;
use App\Order;
use App\Currency;
use Mail;
use Session;
use App\User;
use TwilioMsg;
use App\Course;
use App\Setting;
use Notification;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\PendingPayout;
use App\InstructorSetting;
use Illuminate\Support\Str;
use App\Mail\SendOrderMail;
use Illuminate\Http\Request;
use App\Mail\AdminMailOnOrder;
use App\Notifications\UserEnroll;
use App\Http\Controllers\Controller;
use App\PaidMettings;
use App\Meeting;
use App\BBL;
use App\JitsiMeeting;
use App\Googlemeet;


class PayFlexiController extends Controller
{
    /**
     * Issue Secret Key from your Payflexi Dashboard
     * @var string
     */
    protected $secretKey;
    /**
     * Instance of Client
     * @var Client
     */
    protected $client;
    /**
     * Payflexi API base Url
     * @var string
     */
    protected $baseUrl;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->setKey();
        $this->setBaseUrl();
        $this->setRequestOptions();
    }
    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        $reference = Str::random(15);

        $callback_url = route('payflexi.callback');

        $data = [
            'amount' => request()->amount,
            'gateway' => request()->gateway,
            'reference' => $reference,
            'currency' => request()->currency,
            'email' => request()->email,
            'name' => request()->name,
            'meta' => request()->meta,
            'callback_url' => $callback_url,
			'domain'  => 'global',
        ];

        $url = "merchants/transactions";

        try {
            $response = $this->client->request('POST', $this->baseUrl.$url, [
                'json'=> $data
            ]);
            $result = json_decode($response->getBody());
            if ($result->errors == false) {
                return redirect($result->checkout_url);
            }
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            Log::info("Payflexi error: ". json_encode($e->getMessage()));
            $response = json_decode($e->getResponse()->getBody(true));
            $response->gateway_response = $response->message;
            return [
                'status' => 'error', 
                'data'=> $response
            ];
        }
    }
    /**
     * Return from PayFlexi and Confirm the transaction
     *
     */
    public function callback(Request $request)
    {
        if ($request->has('pf_cancelled')) {
            \Session::flash('delete', trans('flash.PaymentFailed'));
            return redirect()->route('cart.show');
        }

        if ($request->has('pf_declined')) {
            \Session::flash('delete', trans('flash.PaymentFailed'));
            return redirect()->route('cart.show');
        }

        if ($request->has('pf_approved')) {
            $transactionRef = $request->input('pf_approved');
        }

        $transaction = $this->verifyTransaction($transactionRef);

        if($transaction['status'] == 'success' && $transaction['data']->status =='approved'){

            $payflexi_transaction_reference = $transaction['data']->reference;
            $payflexi_transaction_order_amount = $transaction['data']->amount;
            $payflexi_transaction_txn_amount = $transaction['data']->txn_amount;

			$currency = Currency::where('default', '=', '1')->first();

            $gsettings = Setting::first();

			$carts = Cart::where('user_id', Auth::User()->id)->get();

            $pay_amount = 0;
		   
		   	foreach($carts as $cart)
		   	{  
		   		if ($cart->offer_price != 0 || $cart->offer_price != NULL)
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

                if ($payflexi_transaction_txn_amount >= $payflexi_transaction_order_amount) {
                
                    $payment = $this->processOnetimePayment($cart, $pay_amount);
                    $order_status = 1;
                    
                }

                if ($payflexi_transaction_txn_amount < $payflexi_transaction_order_amount) {
    
                    $pay_amount = ($pay_amount/$payflexi_transaction_order_amount) * $payflexi_transaction_txn_amount;
                    $payment = $this->processInstalmentPayment($cart, $pay_amount);
                    $order_status = 0;

                }

                $pay_amount = session()->get('meeting_price', 0);
                $meeting_id = session()->get('meeting_id', null);
                $meeting_type = session()->get('meeting_type', null);
            
                if ($meeting_id && $meeting_type) {
                    // Fetch the meeting details from the database based on the meeting type
                    switch ($meeting_type) {
                        case 'zoom':
                            $meeting = Meeting::find($meeting_id);
                            break;
                        case 'jitsi':
                            $meeting = JitsiMeeting::find($meeting_id);
                            break;
                        case 'bbl':
                            $meeting = BBL::find($meeting_id);
                            break;
                        case 'googlemeet':
                            $meeting = Googlemeet::findOrFail($meeting_id);
                            break;
                        default:
                            return redirect()->back()->withErrors('Invalid meeting type');
                    }
            
                    $course_id = null;
            
                    if ($meeting) {
                        $course_id = $meeting->course_id; // Retrieve course_id from meeting
                    } else {
                        return redirect()->back()->withErrors('Meeting not found.');
                    }
            
                    // Create a new PaidMettings record
                    PaidMettings::create([
                        'transaction_id' => $payflexi_transaction_reference, // Ensure $txn_id is defined
                        'meeting_id' => $meeting_id,
                        'course_id' => $payment['course_id'],
                        'type' => $meeting_type,
                        'user_id' => Auth::User()->id, // Use Auth::id() for cleaner code
                        'amount' => $pay_amount,
                        'currency' => $currency->code, // Ensure $currency is defined
                        'currency_symbol' => $currency->symbol,
                        'payment_method' => 'Payflexi', // Ensure $payment_method is defined
                        'status' => $order_status, // Ensure $pay_status is defined
                    ]);
            
                    // Clear the session data after storing
                    session()->forget(['meeting_id', 'meeting_price', 'meeting_type']);
                }

		        $created_order = Order::create([
		        	'course_id' => $payment['course_id'],
		        	'user_id' => Auth::User()->id,
		        	'instructor_id' => $payment['instructor_id'],
		        	'order_id' => '#' . sprintf("%08d", intval($number) + 1),
		            'transaction_id' => $payflexi_transaction_reference,
		            'payment_method' => 'Payflexi',
		            'total_amount' => $pay_amount,
		            'coupon_discount' => $cpn_discount,
		            'currency' => $currency->code,
		            'currency_icon' => $currency->symbol,
		            'duration' => $payment['duration'],
		            'enroll_start' => $payment['todayDate'],
                    'enroll_expire' => $payment['expireDate'],
                    'bundle_id' => $payment['bundle_id'],
                    'bundle_course_id' => $payment['bundle_course_id'],
                    'status' => $order_status,
		            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
		            ]
		        );
		        
		        Wishlist::where('user_id',Auth::User()->id)->where('course_id', $cart->course_id)->delete();

		        Cart::where('user_id',Auth::User()->id)->where('course_id', $cart->course_id)->delete();

                if($payment['instructor_payout'] != 0)
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
    	                            'transaction_id' => $payflexi_transaction_reference,
    	                            'total_amount' => $pay_amount,
    	                            'currency' => $currency->code,
    	                            'currency_icon' => $currency->symbol,
    	                            'instructor_revenue' => $payment['instructor_payout'],
    	                            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
    	                            'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
    	                            ]
    	                        );
    	                    }
    	                }
                    }
                }

                if($created_order && $payflexi_transaction_txn_amount >= $payflexi_transaction_order_amount){
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

		        if($created_order && $payflexi_transaction_txn_amount >= $payflexi_transaction_order_amount){
		        	if (env('MAIL_USERNAME')!=null) {
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
							\Session::flash('deleted',trans('flash.PaymentMailError'));
							return redirect('confirmation');
						}
					}
				}


				if($cart->type == 0)
                {

					if($created_order && $payflexi_transaction_txn_amount >= $payflexi_transaction_order_amount){
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
        	// \Session::flash('success', trans('flash.PaymentSuccess'));
		    return redirect('confirmation');
        }

        \Session::flash('delete', trans('flash.PaymentFailed'));
		    return redirect('/');
    }


    /**
     * Process onetime payment
    */
    public function processOnetimePayment($cart, $pay_amount)
    {
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

            $payment = [
                'bundle_id' => NULL,
                'course_id' => $cart->course_id,
                'bundle_course_id' => NULL,
                'duration' => $cart->courses->duration,
                'instructor_id' => $cart->courses->user_id,
                'todayDate' => $todayDate,
                'expireDate' => $expireDate,
                'instructor_payout' => $instructor_payout
            ];

            return $payment;
        }
    }

    /**
     * Process instalment payment
    */
    public function processInstalmentPayment($cart, $pay_amount)
    {
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

            $payment = [
                'bundle_id' => NULL,
                'course_id' => $cart->course_id,
                'bundle_course_id' => NULL,
                'duration' => $cart->courses->duration,
                'instructor_id' => $cart->courses->user_id,
                'todayDate' => $todayDate,
                'expireDate' => $expireDate,
                'instructor_payout' => $instructor_payout
            ];

            return $payment;
        }
    }

    /**
     * Verify transaction from PayFlexi API
    */
    public function verifyTransaction($reference)
    {
        $url = 'merchants/transactions/'. $reference;

        try {
            $response = $this->client->request('GET', $this->baseUrl.$url);
            $result = json_decode($response->getBody());
            if($result->errors == false) {
                return [
                    'status' => 'success', 
                    'data' => $result->data
                ];
            } else {
                return [
                    'status'=>'fail', 
                    'data'=> $result->data
                ];
            }
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            Log::info('Payflexi verify exception: '. json_encode($e->getMessage()));
            $response = json_decode($e->getResponse()->getBody(true));
            $response->gateway_response = $response->message;
            return [
                'status' => 'fail', 
                'data'=> $response
            ];
        }
    }

    /**
     * Process webhook events
    */
    public function webhook(Request $request)
    {
        if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') || ! array_key_exists('HTTP_X_PAYFLEXI_SIGNATURE', $_SERVER)) {
            exit;
        }

        $json = file_get_contents('php://input');

        // validate event do all at once to avoid timing attack
        if ($_SERVER['HTTP_X_PAYFLEXI_SIGNATURE'] !== hash_hmac('sha512', $json, $this->secretKey)) {
            exit;
        }

        $event = json_decode($json);

        $gsettings = Setting::first();

        if ($event->event == 'transaction.approved' && $event->data->status == 'approved') {

            http_response_code(200);

            $payflexi_transaction_initial_reference = $event->data->initial_reference;
            $payflexi_transaction_reference = $event->data->reference;
            $payflexi_transaction_amount = $event->data->amount;
            $payflexi_transaction_txn_amount = $event->data->txn_amount;
            $payflexi_transaction_total_amount_paid = $event->data->total_amount_paid;

            $orders = Order::where('transaction_id', $payflexi_transaction_initial_reference)->where('payment_method', 'Payflexi')->get();

            if($orders){

                foreach($orders as $order){

                    $pending_payout = PendingPayout::where('order_id', $order->id)->where('transaction_id', $payflexi_transaction_initial_reference)->first();

                    if (!is_null($order->courses->discount_price)){
                        $orderAmount = $order->courses->discount_price;
                    }else{
                        $orderAmount = $order->courses->price;
                    }

                    if($order && $payflexi_transaction_reference !== $payflexi_transaction_initial_reference){
                        
                        $noOfInstalments = $event->data->instalment->instalments;
                        $noOfInstalmentsPaid = $event->data->instalment->instalments_paid;
                        $instalmentsUnPaid =  ($noOfInstalments - $noOfInstalmentsPaid) + 1;
                        $orderBalanceAmount = $orderAmount - $order->total_amount;
                        $instalmentPaid = $orderBalanceAmount/$instalmentsUnPaid;

                        $orderTotalAmountPaid = round($order->total_amount + $instalmentPaid, 2);

                        if($orderTotalAmountPaid <  $orderAmount){
                            //An instalment payment is still ongoing
                            $order->total_amount = $orderTotalAmountPaid;
                            $order->save();

                            if($pending_payout){
                                $pending_payout->total_amount = $orderTotalAmountPaid;
                                $pending_payout->save();
                            }
                         
                        }

                        if($orderTotalAmountPaid >= $orderAmount){
                            //An instalment payment is now completed
                            $diffDays = Carbon::parse($order->enroll_start)->diffInDays( $order->enroll_expire );
                            $todayDate = date('Y-m-d');
                            $expireDate = date("Y-m-d", strtotime("$todayDate +$diffDays days"));
                            $order->enroll_start = $todayDate;
                            $order->enroll_expire = $expireDate;
                            $order->total_amount = $orderTotalAmountPaid;
                            $order->status = 1;
                            $order->save();

                            if($pending_payout){
                                $pending_payout->total_amount = $orderTotalAmountPaid;
                                $pending_payout->save();
                            }

                            //Send SMS Message if enabled
                            if ($gsettings->twilio_enable == '1') {

                                try{
                                    $recipients = $order->user->mobile;
                                    

                                    $msg = 'Hey'. ' ' .$order->user->fname . ' '.
                                            'You\'r successfully enrolled in '. $order->courses->title .
                                            'Thanks'. ' ' . config('app.name');
                                
                                    TwilioMsg::sendMessage($msg, $recipients);

                                }catch(\Exception $e){
                                    
                                }

                            }

                            //Send Email to user and admin
                            try {
                                /*sending email*/
                                $x = 'You are successfully enrolled in a course';
                                Mail::to($order->courses->user->email)->send(new SendOrderMail($x, $order));


                                /*sending admin email*/
                                $x = 'User Enrolled in course '. $order->courses->title;
                                Mail::to($order->courses->user->email)->send(new AdminMailOnOrder($x, $order));

                            } catch (\Swift_TransportException $e) {
                
                            }
                            
                        }

                    }

                }
            }

        }
    }

    /**
     * Get Base Url from Payflexi config file
    */
    public function setBaseUrl()
    {
        $this->baseUrl = 'https://api.payflexi.co/';
    }
    /**
     * Get secret key from Payflexi config file
     */
    public function setKey()
    {
        $this->secretKey = config('payflexi.secretKey');
    }
     /**
     * Set options for making the Client request
     */
    private function setRequestOptions()
    {
        $authBearer = 'Bearer '. $this->secretKey;
        $this->client = new Client(
            [
                'base_uri' => $this->baseUrl,
                'headers' => [
                    'Authorization' => $authBearer,
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json'
                ],
                'verify' => false
            ]
        );
    }
}
