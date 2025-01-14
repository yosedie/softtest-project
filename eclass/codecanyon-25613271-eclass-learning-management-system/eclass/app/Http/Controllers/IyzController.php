<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
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
use Crypt;
use Cookie;
use App;
use App\Mail\AdminMailOnOrder;
use TwilioMsg;
use App\Setting;

class IyzController extends Controller
{
    public function pay(Request $request)
    {
    	// return $request;
    	$amount = $request->amount;
    	$conversation_id = $request->conversation_id;
    	$basket_id = 'B'.substr(str_shuffle("0123456789"), 0, 5);
    	$user_id = 'BY'.Auth::user()->id;
    	$fname = Auth::user()->fname;
    	$lname = Auth::user()->lname;
    	$address = Auth::user()->address;
    	$city = $request->city;
    	$state = $request->state;
    	$country = $request->country;
    	$item_id = 'BI'.substr(str_shuffle("0123456789"), 0, 3);
    	$pincode = $request->pincode;
    	$now = \Carbon\Carbon::now()->toDateTimeString();
    	$ip = $request->ip();
    	$currency = $request->currency;
		$language = strtoupper(App::getLocale());
		$identity = $request->identity_number;
    	$email = $request->email;
    	$mobile = $request->mobile;
		Cookie::queue('user_selection', Auth::user()->id, 100);
		$options = new \Iyzipay\Options();
		$options->setApiKey(env('IYZIPAY_API_KEY'));
		$options->setSecretKey(env('IYZIPAY_SECRET_KEY'));
		$options->setBaseUrl(env('IYZIPAY_BASE_URL'));
		$request = new \Iyzipay\Request\CreatePayWithIyzicoInitializeRequest();
		$request->setLocale($language);
		$request->setConversationId($conversation_id);
		$request->setPrice($amount);
		$request->setPaidPrice($amount);
		$request->setCurrency(\Iyzipay\Model\Currency::TL);
		$request->setBasketId($basket_id);
		$request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
		$request->setCallbackUrl(url('return/izy/success'));
		$request->setEnabledInstallments(array(1));
		$buyer = new \Iyzipay\Model\Buyer();
		$buyer->setId($user_id);
		$buyer->setName($fname);
		$buyer->setSurname($lname);
		$buyer->setGsmNumber($mobile);
		$buyer->setEmail($email);
		$buyer->setIdentityNumber($identity);
		$buyer->setLastLoginDate($now);
		$buyer->setRegistrationDate($now);
		$buyer->setRegistrationAddress($address);
		$buyer->setIp($ip);
		$buyer->setCity($city);
		$buyer->setCountry($country);
		$buyer->setZipCode($pincode);
		$request->setBuyer($buyer);
		$shippingAddress = new \Iyzipay\Model\Address();
		$shippingAddress->setContactName($fname);
		$shippingAddress->setCity($city);
		$shippingAddress->setCountry($country);
		$shippingAddress->setAddress($address);
		$shippingAddress->setZipCode($pincode);
		$request->setShippingAddress($shippingAddress);
		$billingAddress = new \Iyzipay\Model\Address();
		$billingAddress->setContactName($fname);
		$billingAddress->setCity($city);
		$billingAddress->setCountry($country);
		$billingAddress->setAddress($address);
		$billingAddress->setZipCode($pincode);
		$request->setBillingAddress($billingAddress);
		$basketItems = array();
		$firstBasketItem = new \Iyzipay\Model\BasketItem();
		$firstBasketItem->setId($item_id);
		$firstBasketItem->setName(config('app.name'));
		$firstBasketItem->setCategory1(config('app.name'));
		$firstBasketItem->setCategory2(config('app.name'));
		$firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
		$firstBasketItem->setPrice($amount);
		$basketItems[0] = $firstBasketItem;
		
		$request->setBasketItems($basketItems);
		# make request
		$payWithIyzicoInitialize = \Iyzipay\Model\PayWithIyzicoInitialize::create($request, $options);


		// dd($payWithIyzicoInitialize);


		if($payWithIyzicoInitialize->getstatus() == 'success')
		{
			$url = $payWithIyzicoInitialize->getpayWithIyzicoPageUrl();


			return redirect($url); 
		}

		$error_msg = $payWithIyzicoInitialize->getErrorMessage();


		\Session::flash('delete', $error_msg);
		return redirect('all/cart');




    }
	public function callback(Request $request)
    {

    	$token = $request->token;

    	$options = new \Iyzipay\Options();
		$options->setApiKey(env('IYZIPAY_API_KEY'));
		$options->setSecretKey(env('IYZIPAY_SECRET_KEY'));
		$options->setBaseUrl(env('IYZIPAY_BASE_URL'));
    	

    	$request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();

    	// dd($request);

		$request->setLocale(\Iyzipay\Model\Locale::EN);
		$request->setConversationId("123456789");
		$request->setToken($token);

		$checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, $options);

		// dd($checkoutForm);

		$status = $checkoutForm->getstatus();

		$payment_id = $checkoutForm->getpaymentId();

		$iyz_currency = $checkoutForm->getcurrency();


		if($status == 'success') {


            $txn_id = $payment_id;

            $payment_method = 'Iyzipay';
            $meeting_id = session()->get('meeting_id', null);
            $checkout = new OrderStoreController;

            $userid = Cookie::get('user_selection');
            $user = User::find($userid);

            if(isset($user))
            {
               $auth_user_id = $user->id;
            }
            else{
                $auth_user_id = Auth::user()->id;
            }
            return $checkout->orderstore($txn_id, $payment_method ,$sale_id = NULL,$file = NULL,$payment_status = NULL, $auth_user_id = NULL, $meeting_id );


		}


		\Session::flash('delete', trans('flash.PaymentFailed'));
		    return redirect('/');

    }
}
