<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FeaturePayment;
use App\Course;
use App\User;
use Session;
use PaytmWallet;
use Auth;
use App\FeatureCourse;
use App\Currency;
use Redirect;
use Validator;
use URL;

/** All Paypal Details class **/
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
use App\Setting;
use Spatie\Permission\Models\Role;


class FeatureCourseController extends Controller
{
     public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->middleware('permission:featured-courses.view', ['only' => ['index','show']]);
        $this->middleware('permission:featured-courses.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:featured-courses.edit', ['only' => [ 'getPaymentStatus']]);
        $this->middleware('permission:featured-courses.delete', ['only' => ['destroy', 'bulk_delete']]);
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $featured = FeaturePayment::all();
        return view('instructor.featurecourse.index', compact('featured'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::where('user_id', Auth::User()->id)->where('featured', '0')->get();
        return view('instructor.featurecourse.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'course_id' => 'required',
        ]);
        $created_order = FeatureCourse::create([
            'course_id' => $request->course_id,
            'user_id' => Auth::User()->id,
            'total_amount' => $request->total_amount,
            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            ]
        );  

        $payment = $request;
        $course = Course::where('id', $request->course_id)->first();
        return view('instructor.featurecourse.pay', compact('payment', 'course'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $featured = FeaturePayment::where('id', $id)->first();
        return view('instructor.featurecourse.view', compact('featured'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       FeaturePayment::where('id', $id)->delete();
       return Redirect::route('featurecourse.index');
    }

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
          'callback_url' => $appurl."/featurepayment/status" 
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

        //paytm callback
        $transaction = PaytmWallet::with('receive');

        $response = $transaction->response();
        $order_id = $transaction->getOrderId();
        

        if($transaction->isSuccessful()){
            
            $currency = Currency::where('default', '=', '1')->first();

            $feature = FeatureCourse::where('user_id',Auth::User()->id)->first();
           
                       
            $created_order = FeaturePayment::create([
                'course_id' => $feature->course_id,
                'user_id' => Auth::User()->id,
                'transaction_id' => $response['TXNID'],
                'payment_method' => 'PayTM',
                'total_amount' => $response['TXNAMOUNT'],
                'currency' => $response['CURRENCY'],
                'currency_icon' => $currency->symbol,
                'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                ]
            );  
              

            if($created_order){

                Course::where('id', '=', $feature->course_id)->where('user_id', '=', Auth::user()->id)->update(['featured' => '1']);

                $feature = FeatureCourse::where('user_id',Auth::User()->id)->delete();
            } 
         

            \Session::flash('success', trans('flash.PaymentSuccess'));

            return Redirect::route('featurecourse.index');


        }else if($transaction->isFailed()){
        
          \Session::flash('delete', trans('flash.PaymentFailed'));
            return Redirect::route('featurecourse.index');
        }

    }



    public function payWithpaypal(Request $request)
    {   
        // return $request;
        $pay = Crypt::decrypt($request->amount);
        Session::put('payment',$pay);
        $payer = new Payer();
                $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName('Item 1') /** item name **/
                    ->setCurrency('USD')
                    ->setQuantity(1)
                    ->setPrice($pay); /** unit price **/
        $item_list = new ItemList();
                $item_list->setItems(array($item_1));
        $amount = new Amount();
                $amount->setCurrency('USD')
                    ->setTotal($pay);
        $transaction = new Transaction();
                $transaction->setAmount($amount)
                    ->setItemList($item_list)
                    ->setDescription('Your transaction description');
        $redirect_urls = new RedirectUrls();
                $redirect_urls->setReturnUrl(URL::route('featured')) /** Specify return URL **/
                    ->setCancelUrl(URL::route('featured'));
        $payment = new Payment();
                $payment->setIntent('Sale')
                    ->setPayer($payer)
                    ->setRedirectUrls($redirect_urls)
                    ->setTransactions(array($transaction));
                
                try {
        $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
        if (\Config::get('app.debug')) {
        \Session::put('error', 'Connection timeout');
                        return redirect('/');
        } else {
        \Session::put('error', 'Some error occur, sorry for inconvenient');
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
        if (isset($redirect_url)) {
        /** redirect to paypal **/
                    return Redirect::away($redirect_url);
        }
        \Session::put('error', 'Unknown error occurred');
                return redirect('/');
    }

    public function getPaymentStatus(Request $request)
    {

        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        $amount = Session::get('payment');
        /** clear the session payment ID **/
            Session::forget('paypal_payment_id');
            if (empty($request->get('PayerID')) || empty($request->get('token')))

             {
    \Session::put('error', 'Payment failed');
                return redirect('/');
    }
      $payment = Payment::get($payment_id, $this->_api_context);
          $execution = new PaymentExecution();
            $execution->setPayerId($request->get('PayerID'));
    /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

       



        if ($result->getState() == 'approved') {
                    

            $currency = Currency::where('default', '=', '1')->first();

            $feature = FeatureCourse::where('user_id',Auth::User()->id)->first();

            $settings = Setting::first();
           
                       
            $created_order = FeaturePayment::create([
                'course_id' => $feature->course_id,
                'user_id' => Auth::User()->id,
                'transaction_id' => $payment_id,
                'payment_method' => 'Paypal',
                'total_amount' => $settings->feature_amount,
                'currency' => $currency->code,
                'currency_icon' => $currency->symbol,
                'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                ]
            );  
              

            if($created_order){

                Course::where('id', '=', $feature->course_id)->where('user_id', '=', Auth::user()->id)->update(['featured' => '1']);

                $feature = FeatureCourse::where('user_id',Auth::User()->id)->delete();
            } 
            
            

        Session::flash('success', trans('flash.PaymentSuccess'));
            return Redirect::route('featurecourse.index');
        }
        Session::flash('delete', trans('flash.PaymentFailed'));
            return Redirect::route('featurecourse.index');
    }

    
    // This function performs bulk delete action
    public function bulk_delete(Request $request)
    {
    
          $validator = Validator::make($request->all(), ['checked' => 'required']);
          if ($validator->fails()) {
           return back()->with('error',trans('Please select field to be deleted.'));
          }
          FeaturePayment::whereIn('id',$request->checked)->delete();

         return back()->with('error',trans('Selected User has been deleted.'));
         
    }
}
