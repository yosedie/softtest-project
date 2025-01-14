<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RefundCourse;
use App\Currency;
use Auth;
use PayPal\Api\Amount;
use PayPal\Api\Refund;
use PayPal\Api\Sale;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use PaytmWallet;
use Razorpay\Api\Api;
use App\RefundPolicy;
use App\Order;

class RefundController extends Controller
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

    public function index()
    {
        $refunds = RefundCourse::get();
        return view('admin.refund_order.show', compact('refunds'));
    }

    public function edit($id)
    {
    	$refunds = RefundCourse::where('id', $id)->first();
        return view('admin.refund_order.view', compact('refunds'));
    }

    public function update(Request $request, $id)
    {

    	$refnd = RefundCourse::where('id', $id)->first();

    	if(Auth::check())
    	{

    		if(Auth::user()->role == "admin")
	    	{

	    		if($refnd->status == 0)
	    		{

	    			if(isset($refnd))
	    			{

    					if($refnd->payment_method == 'PayPal') 
    					{

                            return $this->refundwithPaypal($request, $refnd);

                        }
                        elseif($refnd->payment_method == 'Stripe')
                        {

                            return $this->refundwithStripe($request, $refnd);

                        }
                        elseif($refnd->payment_method == 'Paystack')
                        {

                            return $this->refundwithPaystack($request, $refnd);

                        }
                        elseif($refnd->payment_method == 'Instamojo')
                        {

                            return $this->refundwithInstamojo($request, $refnd);

                        }
                        elseif($refnd->payment_method == 'PayTM')
                        {

                            return $this->refundwithPaytm($request, $refnd);

                        }elseif($refnd->payment_method == 'RazorPay')
                        {

                            return $this->refundwithRazorPay($request, $refnd);

                        }
                        elseif($refnd->payment_method == 'BankTransfer')
                        {

                            return $this->refundwithBank($request, $refnd);

                        }

	    				
	    			}
	    			else 
		    		{
		                return back()->with('delete', trans('flash.RefundNotFound'));
		            }
	    		}
	    		else 
	    		{
	                return back()->with('delete', trans('flash.RefundAlready'));
	            }
	    	}
	    	else 
	    	{
	            return back()->with('delete', trans('flash.UnauthorizedAction'));
	        }
    	}
    	else 
    	{
            return back()->with('delete', trans('flash.UnauthorizedAction'));
        }

    }


    public function refundwithPaypal($request, $refnd)
    {
    	$refundrequest = RefundCourse::find($refnd->id);
        $currency = Currency::where('default', '=', '1')->first();

        $amt = new Amount();
        $amt->setTotal($refundrequest->total_amount)->setCurrency($currency->code);

        $saleId = $refundrequest->order->sale_id;
        $refund = new Refund();
        $refund->setAmount($amt);
        $sale = new Sale();                         
        $sale->setId($saleId);
        

        try
        {
            $refundedSale = $sale->refund($refund, $this->_api_context);

            RefundCourse::where('id', $refnd->id)
                    ->update([
                'status' => 1,
                'order_refund_id' => $refundrequest->id,
                'refund_transaction_id' => $refundedSale->id,
                'txn_fee' => $refundedSale->refund_from_transaction_fee['value'],
                'refunded_amt' => $refundedSale->total_refunded_amount['value'],
                'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),

            ]);

            Order::where('id', $refundrequest->order_id)
                ->update([
                'refunded' => 1,

            ]);
            

            return redirect('order')->with('success', trans('flash.RefundSuccessful'));

        }
        catch (\Exception $ex) {

            return $ex->getData();

        }

    }

    public function refundwithStripe($request, $refnd)
    {

        $refundrequest = RefundCourse::find($refnd->id);

        $stripe = new Stripe();

        $stripe = Stripe::make(env('STRIPE_SECRET'));

        $charge_id = $refnd->order->transaction_id;
        $amount = $refnd->total_amount;
        

        try
        {
            $striperefund = $stripe->refunds()
                ->create($charge_id, $amount, [
                    'metadata' => [
                        'reason' => $refnd->reason,
                    ],
                ]); 

            RefundCourse::where('id', $refnd->id)
                    ->update([
                'status' => 1,
                'order_refund_id' => $refundrequest->id,
                'refund_transaction_id' => $striperefund['id'],
                'txn_fee' => null,
                'refunded_amt' => $order_refund->amount,
                'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),

            ]);

            Order::where('id', $refundrequest->order_id)
                ->update([
                'refunded' => 1,

            ]);

            return redirect('order')->with('success', trans('flash.RefundSuccessful'));

        }
        catch(\Exception $e)
        {
            $error = $e->getMessage();

            return redirect('order')->with('delete', $error);
        }

        return redirect('order')->with('delete', trans('flash.RefundError'));

    }

    public function refundwithPaystack($request, $refnd)
    {

        $refundrequest = RefundCourse::find($refnd->id);

        $url = "https://api.paystack.co/refund";

        $fields = [
            'amount' => $refundrequest->amount,
            'transaction' => $refundrequest->order->transaction_id,
            'customer_note' => $refundrequest->reason,
        ];

        $fields_string = http_build_query($fields);
        //open connection
        $ch = curl_init();
        $secret_key = env('PAYSTACK_SECRET_KEY');
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $secret_key",
            "Cache-Control: no-cache",
        ));

        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute post
        $result = curl_exec($ch);
        $result = json_decode($result, true);

        if ($result['status'] == false) {

            return redirect('order')->with('delete', $result['message']);

        } else {

            RefundCourse::where('id', $refnd->id)
                    ->update([
                'status' => 1,
                'order_refund_id' => $refundrequest->id,
                'refund_transaction_id' => $result['data']['transaction']['id'],
                'txn_fee' => null,
                'refunded_amt' => $result['data']['transaction']['amount'] / 100,
                'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),

            ]);


            Order::where('id', $refundrequest->order_id)
                ->update([
                'refunded' => 1,

            ]);

            return redirect('order')->with('success', trans('flash.RefundSuccessful'));

        }
        
    }

    public function refundwithInstamojo($request, $refnd)
    {
        $refundrequest = RefundCourse::find($refnd->id);

        $refundrequest->order->transaction_id;

        try {

            $ch = curl_init();
            $api_key = env('IM_API_KEY');
            $auth_token = env('IM_AUTH_TOKEN');
            curl_setopt($ch, CURLOPT_URL, env('IM_REFUND_URL'));
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER,

                array("X-Api-Key:$api_key",
                    "X-Auth-Token:$auth_token"));

            $payload = array(
                'transaction_id' => 'RFD_IM_' . str_random(10),
                'payment_id' => $refundrequest->order->transaction_id,
                'type' => 'QFL',
                'refund_amount' => round($refundrequest->amount, 2),
                'body' => $refundrequest->reason,
            );

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
            $response = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($response, true);

            if (isset($result['refund'])) {


                RefundCourse::where('id', $refnd->id)
                    ->update([
                    'status' => 1,
                    'order_refund_id' => $refundrequest->id,
                    'refund_transaction_id' => $result['refund']['id'],
                    'txn_fee' => null,
                    'refunded_amt' => $result['refund']['refund_amount'],
                    'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),

                ]);

                Order::where('id', $refundrequest->order_id)
                ->update([
                    'refunded' => 1,

                ]);

                return redirect('order')->with('success', trans('flash.RefundSuccessful'));

                

            } else {
                return redirect('order')->with('delete', 'Return already completed');
            }

        } catch (\Exception $e) {
            $error = $e->getMessage();

            return redirect('order')->with('delete', $error);
        }
        
    }

    public function refundwithPaytm($request, $refnd)
    {

        $refundrequest = RefundCourse::find($refnd->id);

        $refund = PaytmWallet::with('refund');

        $refund->prepare([
            'order' => $refundrequest->order->order_id,
            'reference' => 'refund' . $refundrequest->order->order_id,
            'amount' => $refundrequest->total_amount,
            'transaction' => $refundrequest->order->transaction_id,
        ]);

        $refund->initiate();
        $response = $refund->response();

        if($refund->isSuccessful()) {


            RefundCourse::where('id', $refnd->id)
                ->update([
                'status' => 1,
                'order_refund_id' => $refundrequest->id,
                'refund_transaction_id' => $response['REFUNDID'],
                'txn_fee' => null,
                'refunded_amt' => $response['REFUNDAMOUNT'],
                'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),

            ]);

            Order::where('id', $refundrequest->order_id)
                ->update([
                'refunded' => 1,

            ]);

            return redirect('order')->with('success', trans('flash.RefundSuccessful'));
            

        } 
        elseif($refund->isFailed()) {

            if($response['STATUS'] == 'TXN_FAILURE') {

                $status = 0;

                return redirect('order')->with('delete', trans('flash.RefundError'));

            }

            return redirect('order')->with('delete', trans('flash.RefundError'));

        }

        return redirect('order')->with('delete', trans('flash.RefundError'));

        
    }

    public function refundwithRazorPay($request, $refnd)
    {

        $refundrequest = RefundCourse::find($refnd->id);

        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $refund = $api->payment->fetch($refundrequest->order->transaction_id);
            $result = $refund->refund(array('amount' => round($refundrequest->amount * 100, 2)));


            RefundCourse::where('id', $refnd->id)
                ->update([
                'status' => 1,
                'order_refund_id' => $refundrequest->id,
                'refund_transaction_id' => $result->id,
                'txn_fee' => null,
                'refunded_amt' => $result->amount / 100,
                'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),

            ]);

            Order::where('id', $refundrequest->order_id)
                ->update([
                'refunded' => 1,

            ]);

            return redirect('order')->with('success', trans('flash.RefundSuccessful'));

            

        } catch (\Exception $e) {
            $error = $e->getMessage();

            return redirect('order')->with('delete', $error);
        }
        
    }

    public function refundwithBank($request, $refnd)
    {

        $refundrequest = RefundCourse::find($refnd->id);

        RefundCourse::where('id', $refnd->id)
            ->update([
            'status' => 1,
            'order_refund_id' => $refundrequest->id,
            'refund_transaction_id' => str_random(32),
            'txn_fee' => null,
            'refunded_amt' => $refundrequest->total_amount,
            'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),

        ]);

        

        Order::where('id', $refundrequest->order_id)
                ->update([
            'refunded' => 1,

        ]);

        return redirect('order')->with('success', trans('flash.RefundSuccessful'));
        
    }
}
