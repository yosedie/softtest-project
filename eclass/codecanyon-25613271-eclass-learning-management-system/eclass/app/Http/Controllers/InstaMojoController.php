<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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

class InstaMojoController extends Controller
{
    public function index()
   	{
        return view('pages.checkout.show');
   	}

	// public function pay(Request $request){
	 
	//      $api = new \Instamojo\Instamojo(
	//             config('services.instamojo.api_key'),
	//             config('services.instamojo.auth_token'),
	//             config('services.instamojo.url')
	//         );

	//     $appurl = env('APP_URL');
	//     $appname = env('APP_NAME');	 
	//     try {
	//          $response = $api->paymentRequestCreate(array(
	//             "purpose" => $appname,
	//             "amount" => $request->amount,
	//             "buyer_name" => $request->name,
	//             "send_email" => true,
	//             "send_sms" => true,
	//             "email" => $request->email,
	//             "phone" => $request->mobile_number,
	//             "redirect_url" => url('pay-success')
	//             ));
	             
	//             header('Location: ' . $response['longurl']);
	//             exit();
	            
	//     } catch (\Exception $e) {
	      
	//         \Session::flash('delete', $e->getMessage());
    //         return redirect('all/cart');
	//     }
	// }
	 

	public function pay(Request $request)
{
    $appurl = env('APP_URL');
    $appname = env('APP_NAME');
    
     $payload = [
        'purpose' => $appname,
        'amount' => $request->amount,
        'buyer_name' => $request->buyer_name,
        'send_email' => true,
        'send_sms' => true,
        'email' => $request->email,
        'phone' => $request->mobile_number,
        'redirect_url' => url('/payment/pay-success')
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, config('services.instamojo.url') . '/v2/payment_requests/');
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . config('services.instamojo.auth_token'),
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

	 $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response, true);

    if (isset($response['longurl'])) {
        return redirect($response['longurl']);
    } else {
        $error_message = $response['message'] ?? 'Unknown error occurred';
        return redirect('all/cart')->with('error', $error_message);
    }
}


	// public function success(Request $request){
		
	//     try {
	 
	//         $api = new \Instamojo\Instamojo(
	//             config('services.instamojo.api_key'),
	//             config('services.instamojo.auth_token'),
	//             config('services.instamojo.url')
	//         );
	//          $response = $api->paymentRequestStatus(request('payment_request_id'));
	//         if( !isset($response['payments'][0]['status']) ) {
	           	
	//            	\Session::flash('delete', trans('flash.PaymentFailed'));
	// 	    	return redirect('/');

	//         } else if($response['payments'][0]['status'] != 'Credit') {
	            
	//             \Session::flash('delete', trans('flash.PaymentFailed'));
	// 	    	return redirect('/');
	//         } 
	        
	//       	}catch (\Exception $e) {
	//         	\Session::flash('delete', trans('flash.Payment Failed'));
	// 	    	return redirect('/');

	//     }

	//     $txn_id = $request->payment_id;
    //     $payment_method = 'Instamojo';
	// 	$meeting_id = session()->get('meeting_id', null);
    //     $checkout = new OrderStoreController;
	// 	return $checkout->orderstore($txn_id, $payment_method ,$sale_id = NULL,$file = NULL,$payment_status = NULL, $auth_user_id = NULL, $meeting_id );


	// }

	public function success(Request $request)
{
    $paymentRequestId = $request->input('payment_request_id');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, config('services.instamojo.url') . '/v2/payment_requests/' . $paymentRequestId);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . config('services.instamojo.auth_token')
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response, true);

    if (isset($response['payments']) && isset($response['payments'][0]) && $response['payments'][0]['status'] === 'Credit') {
        $txn_id = $response['payments'][0]['payment_id'];
        $payment_method = 'Instamojo';
        $meeting_id = session()->get('meeting_id', null);
        $checkout = new OrderStoreController;
        return $checkout->orderstore($txn_id, $payment_method, null, null, null, null, $meeting_id);
    } else {
        \Session::flash('delete', trans('flash.PaymentFailed'));
        return redirect('/');
    }
}


}
