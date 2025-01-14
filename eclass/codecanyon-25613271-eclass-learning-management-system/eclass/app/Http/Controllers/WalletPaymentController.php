<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Crypt;
use Session;
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
use App\InstructorSetting;
use App\PendingPayout;
use App\Mail\AdminMailOnOrder;
use TwilioMsg;
use App\Setting;
use App\WalletTransactions;

class WalletPaymentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | WalletPaymentController
    |--------------------------------------------------------------------------
    |
    | This controller holds the logics and functionality of order checkout using wallet system.
    |
     */

    /**
     * This functions holds the functionality of create order using wallet payments
     */

    public function walletpayment(Request $request)
    {

       
        /** Get the default currency */
        
        $currency = Currency::where('default', '=', '1')->first();
        $gsettings = Setting::first();

        /** Get the logged in user cart */

        $carts = Cart::where('user_id',auth()->id())->get();
           
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

                /** Get the last order */

                $lastOrder = Order::orderBy('created_at', 'desc')->first();

                if( ! $lastOrder )
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

                /** Create order after successful checkout */
            
                $created_order = Order::create([
                    'course_id' => $course_id,
                    'user_id' => auth()->id(),
                    'instructor_id' => $instructor_id,
                    'order_id' => '#' . sprintf("%08d", intval($number) + 1),
                    'transaction_id' => str_random(32),
                    'payment_method' => 'Wallet',
                    'total_amount' => $pay_amount,
                    'coupon_discount' => $cpn_discount,
                    'currency' => $currency->code,
                    'currency_icon' => $currency->symbol,
                    'duration' => $duration,
                    'enroll_start' => $todayDate,
                    'enroll_expire' => $expireDate,
                    'status' => 0,
                    'bundle_id' => $bundle_id,
                    'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                    ]
                );



            $created_order->save();

            $pay = strip_tags(Crypt::decrypt($request->amount));

            if($created_order)
             {

                /** Update the user wallet balance after payment */

                if (auth()->user()->wallet->status == 1) {

                    auth()->user()->wallet()->update([
                        'balance' => auth()->user()->wallet->balance - $pay,
                    ]);

                }

                /** Create the transcation history */

                $wallet_transaction = WalletTransactions::create([
                    'wallet_id' => auth()->user()->wallet->id,
                    'user_id' => Auth::User()->id,
                    'transaction_id' => $created_order->transaction_id,
                    'payment_method' => 'Wallet',
                    'total_amount' => $pay_amount,
                    'currency' => $created_order->currency,
                    'currency_icon' => $currency->symbol,
                    'type' => 'Debit',
                    'detail' => 'Payment for order ID' . $created_order->order_id,

                    ]
                );

            }

            /** Deleete course from wishlist after successful payment */

            Wishlist::where('user_id',Auth::User()->id)->where('course_id', $cart->course_id)->delete();

             /** Deleete purchased course from user cart after successful payment */

            Cart::where('user_id',Auth::User()->id)->where('course_id', $cart->course_id)->delete();

            /* Create instructor payout if any */

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
                                'transaction_id' => $created_order->transaction_id,
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

            /** Sending SMS to logged in user via Twillo */

            if($created_order){
                if ($gsettings->twilio_enable == '1') {

                    try{
                        $recipients = Auth::user()->mobile;
                        

                        $msg = __('Hey'. ' ' .Auth::user()->fname . ' '.
                                'You\'r successfully enrolled in '. $cart->courses->title .
                                'Thanks'. ' ' . config('app.name'));
                    
                        TwilioMsg::sendMessage($msg, $recipients);

                    }catch(\Exception $e){
                        /** Logging the exception */
                        \Log::error(__('Twillo sms eror :').$e->getMessage());
                    }

                }
            }
            

            if($created_order){
                if (env('MAIL_USERNAME') != null) {
                    try{
                        
                        /*Sending email*/
                        $x = __('You are successfully enrolled in a course');
                        $order = $created_order;
                        Mail::to(Auth::User()->email)->send(new SendOrderMail($x, $order));

                        /*sending admin email*/
                        $x = __('User Enrolled in course '). $cart->courses->title;
                        $order = $created_order;
                        Mail::to($cart->courses->user->email)->send(new AdminMailOnOrder($x, $order));


                    }catch(\Exception $e){
                        Session::flash('deleted',__('flash.PaymentMailError'));
                        return redirect('confirmation');
                    }
                }
            }

            /** Enroll user into the purchased course */

            if($cart->type == 0)
            {

                if($created_order){
                    // Notification when user enroll
                    $cor = Course::where('id', $cart->course_id)->first();

                    $course = [
                      'title' => $cor->title,
                      'image' => $cor->preview_image,
                    ];

                    /** Get the enrolled orders list */

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

        /** @return to confirmation page */

        return redirect('confirmation');
        
    }
}
