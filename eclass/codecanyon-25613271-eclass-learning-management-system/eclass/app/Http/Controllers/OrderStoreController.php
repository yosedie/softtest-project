<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
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
use App\Mail\AdminMailOnOrder;
use App\Helpers\TwilioMsg;
use App\Setting;
use App\Notifications\AdminOrder;
use App\Mail\GiftOrder;
use App\PaidMettings;
use App\Meeting;
use App\BBL;
use App\JitsiMeeting;
use App\Googlemeet;

class OrderStoreController extends Controller
{
    public function orderstore($txn_id, $payment_method, $sale_id = NULL, $file = NULL, $payment_status = NULL, $auth_user_id=NULL,$meeting_id)
    {

        if(Session::get('one_order_course') !== null && Session::get('one_order_user') !== null)
        {
            return $this->oneorder($txn_id, $payment_method, $sale_id, $file, $payment_status, $auth_user_id);
        }

        $gsettings = Setting::first();

        $current_date = Carbon::now();

        $currency = Currency::where('default', '=', '1')->first();


        if($payment_status == '0')
        {
            $pay_status =  '0';
        }
        else
        {
            $pay_status =  1;
        }


        if($auth_user_id != NULL)
        {
            $carts = Cart::where('user_id', $auth_user_id)->get();
        }
        else{

            $carts = Cart::where('user_id',Auth::User()->id)->get();

        }

        // Retrieve payment amount, meeting ID, and meeting type from the session
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
                'transaction_id' => $txn_id, // Ensure $txn_id is defined
                'meeting_id' => $meeting_id,
                'course_id' => $course_id,
                'type' => $meeting_type,
                'user_id' => Auth::id(), // Use Auth::id() for cleaner code
                'amount' => $pay_amount,
                'currency' => $currency->code, // Ensure $currency is defined
                'currency_symbol' => $currency->symbol,
                'payment_method' => $payment_method, // Ensure $payment_method is defined
                'status' => $pay_status, // Ensure $pay_status is defined
            ]);

            // Clear the session data after storing
            session()->forget(['meeting_id', 'meeting_price', 'meeting_type']);
        }

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


            if($payment_method == 'Free Enroll')
            {
                $pay_amount = NULL;
            }
            else{
                $pay_amount = $pay_amount;
            }

           
                   
            $created_order = Order::create([
                'course_id' => $course_id,
                'user_id' => Auth::User()->id,
                'instructor_id' => $instructor_id,
                'order_id' => '#' . sprintf("%08d", intval($number) + 1),
                'transaction_id' => $txn_id,
                'payment_method' => $payment_method,
                'total_amount' => $pay_amount ?? '0',
                'coupon_discount' => $cpn_discount,
                'currency' => $currency->code,
                'currency_icon' => $currency->symbol,
                'duration' => $duration,
                'enroll_start' => $todayDate,
                'enroll_expire' => $expireDate,
                'instructor_revenue' => $instructor_payout,
                'bundle_id' => $bundle_id,
                'sale_id' => $sale_id,
                'status' => $pay_status,
                'proof' => $file,
                'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                ]
            );
            
            Wishlist::where('user_id',Auth::User()->id)->where('course_id', $cart->course_id)->delete();

            Cart::where('user_id',Auth::User()->id)->delete();


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
                                'transaction_id' => $txn_id,
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
                if (env('MAIL_USERNAME')!=null) {
                    try{
                        
                        /*sending user email*/
                        $x = 'You are successfully enrolled in a course';
                        $order = $created_order;
                        Mail::to(Auth::User()->email)->send(new SendOrderMail($x, $order));


                        /*sending admin email*/
                        if(isset(($cart->courses)))
                        {
                            $x = 'User Enrolled in course '. $cart->courses->title;
                            $order = $created_order;
                            Mail::to($cart->courses->user->email)->send(new AdminMailOnOrder($x, $order)); 
                        }
                        


                    }catch(\Swift_TransportException $e){
                        
                    }

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

                    $enroll = Order::where('user_id', Auth::User()->id)->where('course_id', $cart->course_id)->first();

                    if($enroll != NULL)
                    {
                        $user = User::where('id', $enroll->user_id)->first();
                        Notification::send($user,new UserEnroll($course));
                        
                    }

                    $order_id = $created_order->order_id;
                    $url = route('view.order', $created_order->id);

                    if($cor != NULL)
                    {
                        $user = User::where('id', $cor->user_id)->first();
                        Notification::send($user,new AdminOrder($course, $order_id, $url));
                        
                    }
                }

            }
            
           
        }
        return redirect('confirmation');
    }


    public function oneorder($txn_id, $payment_method, $sale_id = NULL, $file = NULL, $payment_status = NULL, $auth_user_id=NULL)
    {

        $course_id = Session::get('one_order_course');

        $user_id = Session::get('one_order_user');

        $course = Course::where('id', $course_id)->first();

        $user = User::where('id', $user_id)->first();


        $gsettings = Setting::first();

        $current_date = Carbon::now();

        $currency = Currency::where('default', '=', '1')->first();


        if($payment_status == '0')
        {
            $pay_status =  '0';
        }
        else
        {
            $pay_status =  1;
        }



            if ($course->discount_price != 0)
            {
                $pay_amount =  $course->discount_price;
            }
            else
            {
                $pay_amount =  $course->price;
            }

            
            $cpn_discount =  NULL;
            


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

            

                if($course->duration_type == "m")
                {
                    
                    if($course->duration != NULL && $course->duration !='')
                    {
                        $days = $course->duration * 30;
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

                    if($course->duration != NULL && $course->duration !='')
                    {
                        $days = $course->duration;
                        $todayDate = date('Y-m-d');
                        $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                    }
                    else{
                        $todayDate = NULL;
                        $expireDate = NULL;
                    }

                }


                $setting = InstructorSetting::first();


                if($course->instructor_revenue != NULL)
                {
                    $x_amount = $pay_amount * $course->instructor_revenue;
                    $instructor_payout = $x_amount / 100;
                }
                else
                {

                    if(isset($setting))
                    {
                        if($course->user->role == "instructor")
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
                $course_id = $course->id;
                
                $duration = $course->duration;
                $instructor_id = $course->user_id;
            

           
                   
            $created_order = Order::create([
                'course_id' => $course_id,
                'user_id' => $user->id,
                'instructor_id' => $instructor_id,
                'order_id' => '#' . sprintf("%08d", intval($number) + 1),
                'transaction_id' => $txn_id,
                'payment_method' => $payment_method,
                'total_amount' => $pay_amount,
                'coupon_discount' => $cpn_discount,
                'currency' => $currency->code,
                'currency_icon' => $currency->symbol,
                'duration' => $duration,
                'enroll_start' => $todayDate,
                'enroll_expire' => $expireDate,
                'instructor_revenue' => $instructor_payout,
                'bundle_id' => $bundle_id,
                'sale_id' => $sale_id,
                'status' => $pay_status,
                'proof' => $file,
                'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                ]
            );
            
            

            if($instructor_payout != 0)
            {
                if($created_order)
                {
                    
                    if($course->user->role == "instructor")
                    {
                        $created_payout = PendingPayout::create([
                            'user_id' => $course->user_id,
                            'course_id' => $course->id,
                            'order_id' => $created_order->id,
                            'transaction_id' => $txn_id,
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

            if($created_order){
                if ($gsettings->twilio_enable == '1') {

                    try{
                        $recipients = Auth::user()->mobile;
                        
        
                        $msg = 'Hey'. ' ' .Auth::user()->fname . ' '.
                                'You\'r successfully enrolled in '. $course->title .
                                'Thanks'. ' ' . config('app.name');
                    
                        TwilioMsg::sendMessage($msg, $recipients);

                    }catch(\Exception $e){
                        
                    }

                }
            }
            


            if($created_order){
                if (env('MAIL_USERNAME')!=null) {
                    try{
                        
                        /*sending user email*/
                        $x = 'You are successfully enrolled in a course';
                        $order = $created_order;
                        Mail::to($user->email)->send(new SendOrderMail($x, $order));


                        /*sending user email*/
                        $x = 'A Gift for you !!';
                        $order = $created_order;
                        $order_id = $order->order_id;
                        Mail::to($user->email)->send(new GiftOrder($x, $order,$order_id,$course));


                        /*sending admin email*/
                        $x = 'User Enrolled in course'. $course->title;
                        $order = $created_order;
                        Mail::to($course->user->email)->send(new AdminMailOnOrder($x, $order));


                    }catch(\Swift_TransportException $e){
                        
                    }

                }
            }

            

            if($created_order){
                // Notification when user enroll
                $cor = Course::where('id', $course->id)->first();

                $course = [
                  'title' => $cor->title,
                  'image' => $cor->preview_image,
                ];

                

                if($user_id != NULL)
                {
                    $user = User::where('id', $user_id)->first();
                    Notification::send($user,new UserEnroll($course));
                    
                }

                $order_id = $created_order->order_id;
                $url = route('view.order', $created_order->id);

                if($cor != NULL)
                {
                    $user = User::where('id', $cor->user_id)->first();
                    Notification::send($user,new AdminOrder($course, $order_id, $url));
                    
                }
            }



        session()->forget('one_order_course');

        session()->forget('one_order_user');

        \Session::flash('delete', 'Payment successfull');
            return redirect('/');

    }


}