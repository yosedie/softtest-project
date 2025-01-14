<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use KingFlamez\Rave\Facades\Rave as Flutterwave;

class FlutterwaveController extends Controller
{
    public function initialize(Request $request)
    {
    
        //This generates a payment reference
        $reference = Flutterwave::generateReference();

        // Enter the details of the payment
        $data = [
            'payment_options' => 'card,banktransfer',
            'amount' => request()->amount,
            'email' => request()->email,
            'tx_ref' => $reference,
            'currency' => "NGN",
            'redirect_url' => route('flutterrave.callback'),
            'customer' => [
                'email' => request()->email,
                "phone_number" => request()->phone,
                "name" => request()->name
            ],

            "customizations" => [
                "title" => 'One Time Order',
                "description" => "Online Course Purchase"
            ]
        ];

        $payment = Flutterwave::initializePayment($data);


        if ($payment['status'] !== 'success') {
            // notify something went wrong
            return;
        }

        return redirect($payment['data']['link']);
        // Rave::initialize(route('rave.callback'));
    }

    public function callback()
    {
        $status = request()->status;

        //if payment is successful
        if ($status ==  'successful') {
        
            $transactionID = Flutterwave::getTransactionIDFromCallback();
            $data = Flutterwave::verifyTransaction($transactionID);

            $txn_id = $transactionID;

            $payment_method = strtoupper('RAVE');
            $meeting_id = session()->get('meeting_id', null);
            $checkout = new OrderStoreController;

            return $checkout->orderstore($txn_id, $payment_method ,$sale_id = NULL,$file = NULL,$payment_status = NULL, $auth_user_id = NULL, $meeting_id );

        }
        elseif ($status ==  'cancelled'){
            //Put desired action/code after transaction has been cancelled here
            \Session::flash('delete', 'Payment Cancelled');
            return redirect('all/cart');
        }
        else{
            //Put desired action/code after transaction has failed here
            \Session::flash('delete', trans('flash.PaymentFailed'));
            return redirect('/');
        }


    }
}
