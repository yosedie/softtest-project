<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wallet;
use App\WalletTransactions;
use App\WalletSettings;
use Auth;
use URL;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use Crypt;
use App\Currency;
use App\Setting;
use PaytmWallet;
use Session;
use Redirect;
use Cartalyst\Stripe\Laravel\Facades\Stripe;

class WalletController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | WalletController
    |--------------------------------------------------------------------------
    |
    | This controller holds the logics and functionality of Wallet Recharge system.
    |
     */

    /**
     * This functions holds the functionality of get paypal api keys
     */

    public function __construct()
    {
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    /**
     * This functions @return the user wallet view
     */

    public function index()
    {

        /* If user wallet is found then create it */

        if(auth()->user()->wallet == NULL)
        {
            auth()->user()->wallet()->create();
        }
        

        $user = auth()->user();
        return view('front.wallet.mywallet', compact('user'));
       
    }

    /**
     * To display wallet add money view to user
     */

    public function checkout(Request $request)
    {
        $wallet_settings = WalletSettings::first();
        $amount = strip_tags($request->amount);
        return view('front.wallet.wallet_checkout', compact('amount', 'wallet_settings'));
    }

    /**
     * Initializing wallet checkout using Paypal payment 
     */

    public function walletPayPal(Request $request)
    {
        $user_wallet = Wallet::where('user_id', Auth::user()->id)->first();

        $currency = Currency::where('default', '=', '1')->first();
        $gsettings = Setting::first();
        $currency_code = strtoupper($currency->code);

        $pay = Crypt::decrypt(strip_tags($request->amount));
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
                $redirect_urls->setReturnUrl(URL::route('wallet.paypal.success')) /** Specify return URL **/
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

        Session::put('user_wallet', $user_wallet->id);

        if (isset($redirect_url)) {
        /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }

        \Session::put('error', __('Unknown error occurred'));
                return redirect('/');
    }


    /**
     * Wallet success function using Paypal payment 
     */

    public function walletpaypalSuccess(Request $request)
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

            $instructor_plan_id = Session::get('user_wallet');
            
            $wallet = Wallet::where('user_id',Auth::user()->id)->first();
           
             
            if (isset($wallet)) {

                /**update money if already wallet exist **/
                if ($wallet->status == 1) {

                    auth()->user()->wallet()->update([
                        'balance' => $wallet->balance + $amount,
                    ]);

                    }
                }


                $wallet_transaction = WalletTransactions::create([
                    'wallet_id' => auth()->user()->wallet->id,
                    'user_id' => Auth::User()->id,
                    'transaction_id' => $payment_id,
                    'payment_method' => 'PayPal',
                    'total_amount' => $amount,
                    'currency' => $currency->code,
                    'currency_icon' => $currency->symbol,
                    'type' => 'Credit',
                    'detail' => 'Added to wallet via PayPal',

                    ]
                );

            Session::forget('user_wallet');
            

            \Session::flash('success', trans('flash.PaymentSuccess'));
            return redirect('/wallet');

        }
        

        Session::forget('instructor_plan');

        \Session::flash('delete', trans('flash.PaymentFailed'));
            return redirect('/wallet');
    }


    /**
     * This function holds the funncality to recharge wallet using paytm.  
     */

    public function paytm(Request $request)
    {

        $user_wallet = Wallet::where('user_id', Auth::user()->id)->first();

        Session::put('user_wallet', $user_wallet->id);


        $appurl = env('APP_URL');

        $payment = PaytmWallet::with('receive');
        $payment->prepare([
          'order' => uniqid(),
          'user' => Auth::User()->id,
          'mobile_number' => strip_tags($request->mobile),
          'email' => strip_tags($request->email),
          'amount' => strip_tags($request->amount),
          'callback_url' => url('/wallet/status/paytm')
        ]);
        return $payment->receive();

    }


    /**
     * This function holds the funncality to capture paytm payment and recharge wallet .  
     */

    public function paymentwallet(Request $request)
    {

        $transaction = PaytmWallet::with('receive');

        $response = $transaction->response();
        $order_id = $transaction->getOrderId();

        $gsettings = Setting::first();

        if($transaction->isSuccessful()){

            /** Get the default currency */

            $currency = Currency::where('default', '=', '1')->first();

             /** Get the logged in user wallet */

            $wallet = Wallet::where('user_id',Auth::user()->id)->first();

            if (isset($wallet)) {

                /** Check if user wallet status is active or not */
                
                if ($wallet->status == 1) {

                    /** Update the wallet balance */

                    auth()->user()->wallet()->update([
                        'balance' => $wallet->balance + $response['TXNAMOUNT'],
                    ]);

                    /** Create wallet transcation history */


                    $wallet_transaction = WalletTransactions::create([
                        'wallet_id' => auth()->user()->wallet->id,
                        'user_id' => Auth::User()->id,
                        'transaction_id' => $response['TXNID'],
                        'payment_method' => 'PayTM',
                        'total_amount' => $response['TXNAMOUNT'],
                        'currency' => $currency->code,
                        'currency_icon' => $currency->symbol,
                        'type' => 'Credit',
                        'detail' => 'Added to wallet via PayTM',

                        ]
                    );
               

                }

            }
            

            \Session::flash('success', __('flash.PaymentSuccess'));
            return redirect('/wallet');



        }else if($transaction->isFailed()){

            /** If payment failed @return back to previous location */

            Session::forget('instructor_plan');
        
          \Session::flash('delete', __('flash.PaymentFailed'));
            return redirect('/wallet');
        }

    }


    /**
     * This function holds the funncality to recharge wallet using stripe.  
     */

    public function payStripe(Request $request)
    {
        
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        
        try {

            // $token = $stripe->tokens()->create([
            //     'card' => [
            //         'number'    => strip_tags($request->get('card_no')),
            //         'exp_month' => $request->get('expiry_month'),
            //         'exp_year'  => $request->get('expiry_year'),
            //         'cvc'       => strip_tags($request->get('cvv')),
            //     ],
            // ]);

            if (!isset($request->stripeToken)) {
                return redirect('/wallet')->with(__('Token is not generate correctly'));
            }

            $charge = $stripe->charges()->create([
                'card' => $request->stripeToken,
                'currency' => __('USD'),
                'amount'   => strip_tags($request->amount),
                'description' => __('Register Event'),
            ]);

            /** Get the default currency */

            $currency = Currency::where('default', '=', '1')->first();

            /** Get logged in user wallet */

            $wallet = Wallet::where('user_id',Auth::user()->id)->first();

            if (isset($wallet)) {

                /** Check if user wallet status is active or not */
                
                if ($wallet->status == 1) {

                    /** Update the wallet balance */
                    

                    auth()->user()->wallet()->update([
                        'balance' => $wallet->balance + $charge['amount']/100,
                    ]);

                    /** Create wallet transcation history */

                    $wallet_transaction = WalletTransactions::create([

                        'wallet_id' => auth()->user()->wallet->id,
                        'user_id' => auth()->id(),
                        'transaction_id' => $charge['id'],
                        'payment_method' => __('Stripe'),
                        'total_amount' => $charge['amount']/100,
                        'currency' => $currency->code,
                        'currency_icon' => $currency->symbol,
                        'type' => 'Credit',
                        'detail' => __('Added to wallet via Stripe'),

                        ]
                    );

                }

            }
            
         
            \Session::flash('success', __('Payment success'));
            return redirect('/wallet');

            } catch (\Exception $e) {

                /** If payment failed return with exception */
               
                \Session::flash('delete', $e->getMessage());

                return redirect('/wallet');
            }
            
    }  
}