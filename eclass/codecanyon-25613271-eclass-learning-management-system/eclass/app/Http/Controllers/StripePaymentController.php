<?php

namespace App\Http\Controllers;

use App\BundleCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use Validator;
use DB;
use Auth;
use App\Cart;
use App\Coupon;
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
use Illuminate\Support\Facades\Log;
use App\Mail\AdminMailOnOrder;
use TwilioMsg;
use App\Setting;


class StripePaymentController extends Controller
{
    /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */
    public function stripe()
    {
        return view('pages.checkout.show');
    }

    /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */
    public function cancelSubscription(Request $request)
    {
        try {

            Log::debug('<==cancelSubscription');

            $redirectTo =   isset($request['redirect_to']) ? $request['redirect_to'] : 'all/purchase';

            Log::debug('redirect to ' . $redirectTo);

            $orderId = $request['order_id'];

            Log::debug('Found orderId ' .$orderId);

            $order = Order::findOrFail($orderId);

            Log::debug('Found order ' .$order);

            Log::debug('Payment method: '.$order->payment_method);

            $status = 'canceled';

            if ($order->payment_method !== 'Admin Enroll') {
                if (!(isset($order->subscription_id) && isset($order->customer_id))) {
                    throw new \Exception('stripe customer and subscription id is required. CustomerId: ' . $order->customer_id . ', SubscriptionId: ' . $order->subscription_id);
                }

                $subscriptionId = $order->subscription_id;

                if (isset($subscriptionId)) {
                    Log::debug('unsubscribing order ' . $orderId . ', subscriptionId : ' . $subscriptionId);

                    $stripe = $this->getStripe();

                    $cancelledSubscription = $stripe->subscriptions->cancel($subscriptionId);

                    $status = $cancelledSubscription['status'];

                    Log::debug('Unsubscribing in stripe successfully: ' . $subscriptionId . '. Stripe Subscription Status: ' . $status);
                }
            }

            Log::debug('Payment method: '.$order->payment_method);
            $order->status = 0;
            $order->subscription_status =  $status;
            $bundle_title = $order->bundle->title;

            $order->save();

            Log::debug('Unsubscribe order successfully: ' . $order->id);
            \Session::flash('success', trans('flash.UnsubscribeSuccess'));

            Log::debug('==>cancelSubscription');


            if ($order->subscription_status === 'canceled') {
                if (env('MAIL_USERNAME') != null) {
                    try {
                        /*sending email*/
                        $x = 'You are successfully unsubscribed from ' . $bundle_title;
                        Mail::to(Auth::User()->email)->send(new SendOrderMail($x, $order));
                    } catch (\Swift_TransportException $e) {
                        Session::flash('deleted', trans('flash.PaymentMailError'));

                        return redirect($redirectTo);
                    }
                }
            }

            return redirect($redirectTo);
        } catch (\Exception $e) {
            Log::error($e->getTraceAsString());

            \Session::flash('delete', trans('flash.UnsubscribeFailed'));

            return redirect($redirectTo);
        }
    }

    /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */
    public function payStripe(Request $request)
    {
        $user = Auth::User();
        if (!isset($request->stripeToken)) {
            return redirect('all/cart')->with(__('Token is not generate correctly'));
        }

        Log::debug('Customer Detail: ' . print_r([$user->email], TRUE));
        try {
            $carts = Cart::where('user_id', Auth::User()->id)->get();
            $cartDetails = $this->getCartDetails($request->amount, $carts);
            $stripeDetails = $this->getStripeDetailsWithCustomer($request);

            $this->processOneTimePaymentOrder($stripeDetails, $cartDetails);
            $this->processSubscriptionOrders($stripeDetails, $cartDetails);

            \Session::flash('success', trans('flash.PaymentSuccess'));

            return redirect('/');
        } catch (\Exception $e) {
            return $e->getMessage()."\\\\\\".$e->getTraceAsString();
            Log::error($e->getTraceAsString());
            \Session::flash('delete', trans('flash.PaymentFailed'));

            return redirect('/');
        }
    }


    #region OneTime Purchage
    private function processOneTimePaymentOrder($stripeDetails, $cartDetails)
    {
        Log::debug('<==processOneTimePaymentOrder');
        $oneTimePaymentCartItems = $cartDetails['oneTimePaymentCartItems'];
        $oneTimePaymentAmount =  $cartDetails['totalOneTimePaymentAmount'];
        $cartItemsCount = count($oneTimePaymentCartItems);
        $isExist = $cartItemsCount > 0;

        if (!$isExist) {
            return;
        }
        Log::debug($cartItemsCount . ' one time payment cart items found.');

        $charge = $this->chargeOneTimeViaStripe($stripeDetails, $oneTimePaymentAmount);

        foreach ($oneTimePaymentCartItems as $oneTimePaymentCartItem) {
            $newOrderId = $this->getNextOrderId();
            $this->createOrderAndSendEmailForOneTimePayment($oneTimePaymentCartItem, $charge['id'], $newOrderId);
        }

        Log::debug('==>processOneTimePaymentOrder');
    }
    /**
     * Charging one time payment for the cart items which are not subscription based.
     */

    private function createOrderAndSendEmailForOneTimePayment($cart, $stripeChargeId, $newOrderId)
    {
        Log::debug('<==createOrderAndSendEmailForOneTimePayment');


        $txn_id = $stripeChargeId;

        $payment_method = 'Stripe';

        $checkout = new OrderStoreController;

        return $checkout->orderstore($txn_id, $payment_method);

        Log::debug('==>createOrderAndSendEmailForOneTimePayment');
    }
    #endregion

    #region Subscription Plan
    private function processSubscriptionOrders($stripeDetails, $cartDetails)
    {
        Log::debug('<==processSubscriptionOrders');
        $isSubscriptionCartItemExist =  $cartDetails['isSubscriptionCartItemExist'];

        if (!$isSubscriptionCartItemExist) {
            return;
        }

        $subscriptionCartItems = $cartDetails['subscriptionCartItems'];

        foreach ($subscriptionCartItems as $subscriptionCartItem) {
            $newOrderId = $this->getNextOrderId();
            $subscription = $this->subscribeInStripe($stripeDetails, $subscriptionCartItem, $newOrderId);
            $this->createOrderAndSendEmailForSubscriptionBundle($subscriptionCartItem, $subscription, $newOrderId);
        }
        Log::debug('==>processSubscriptionOrders');
    }

    private function createOrderAndSendEmailForSubscriptionBundle($cart, $stripeSubscription, $newOrderId)
    {
        Log::debug('<==createOrderAndSendEmailForSubscriptionBundle');
        $currency = Currency::where('default', '=', '1')->first();

        $gsettings = Setting::first();

        if ($cart->type != 1) {
            Log::debug('Can not subscribe since this cart item does not have bundle course.');

            return;
        }

        if ($cart->offer_price != 0) {
            $pay_amount =  $cart->offer_price;
        } else {
            $pay_amount =  $cart->price;
        }

        if ($cart->disamount != 0 || $cart->disamount != NULL) {
            $cpn_discount =  $cart->disamount;
        } else {
            $cpn_discount =  '';
        }

        $bundle = $cart->bundle;
        $bundle_title = $bundle->title;
        $bundle_id = $cart->bundle_id;
        $bundle_course_id = $bundle->course_id;
        $duration = $bundle->billing_interval;
        $customer_id = $stripeSubscription['customer'];
        $price_id = $bundle->price_id;
        $subscription_status = $stripeSubscription['status'];
        $subscription_id = $stripeSubscription['id'];
        $enrollStartDate = date("Y-m-d H:i:s", $stripeSubscription['current_period_start']);
        $enrollExpireDate = date("Y-m-d H:i:s", $stripeSubscription['current_period_end']);
        $instructor_id = $bundle->user_id;

        Log::debug('creating new order (' . $newOrderId . ') for subscription cart Item with title ' . $bundle_title);

        $created_order = Order::create([
            'bundle_course_id' => $bundle_course_id,
            'bundle_id' => $bundle_id,
            'coupon_discount' => $cpn_discount,
            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            'currency' => $currency->code,
            'currency_icon' => $currency->symbol,
            'duration' => $duration,
            'enroll_start' => $enrollStartDate,
            'enroll_expire' => $enrollExpireDate,
            'instructor_id' => $instructor_id,
            'order_id' => $newOrderId,
            'total_amount' => $pay_amount,
            'customer_id' => $customer_id,
            'transaction_id' => $subscription_id,
            'user_id' => Auth::User()->id,

            'payment_method' => 'Stripe',
            'price_id' => $price_id,
            'subscription_id' => $subscription_id,
            'customer_id' => $customer_id,
            'subscription_status' => $subscription_status,
        ]);

        Wishlist::where('user_id', Auth::User()->id)->where('course_id', $cart->course_id)->delete();

        Cart::where('user_id', Auth::User()->id)->where('course_id', $cart->course_id)->delete();

        if ($created_order) {
            if (env('MAIL_USERNAME') != null) {
                try {
                    /*sending email*/
                    $x = 'You are successfully enrolled to ' . $bundle_title;
                    $order = $created_order;
                    Mail::to(Auth::User()->email)->send(new SendOrderMail($x, $order));

                    $x = 'User Enrolled in course '. $cart->courses->title;
                    $order = $created_order;
                    Mail::to($cart->courses->user->email)->send(new AdminMailOnOrder($x, $order));

                } catch (\Swift_TransportException $e) {
                    
                }
            }
        }

        Log::debug('==>createOrderAndSendEmailForSubscriptionBundle');
    }
    #endregion


    #region STRIPE METHODS
    /**
     * create stripe subscription for recurring payment bundle
     */
    private function subscribeInStripe($stripeDetails, $cartItem, $newOrderId)
    {
        Log::debug('<==subscribeInStripe');
        $stripe = $stripeDetails['stripe'];
        $customerId = $stripeDetails['customerId'];
        $bundle = $cartItem->bundle;
        $bundle_id = $bundle->id;
        $bundle_title = $bundle->title;

        $metadata =  ['order_id' => $newOrderId, 'course_title' => $bundle_title, 'bundle_id' => $bundle_id];
        Log::debug('going to subscribe in stripe');

        $subscriptionArgs = [
            'customer' => $customerId,
            'items' => [['price' =>  $bundle->price_id]],
            "metadata" => $metadata,
            'coupon' => isset($cartItem->coupon) ? $cartItem->coupon->stripe_coupon_id : null
        ];

        Log::debug('Creating Subscription in Stripe: ' . print_r($subscriptionArgs, TRUE));
        $subscription = $stripe->subscriptions->create($subscriptionArgs);

        Log::debug('Subscription created in stripe: ' . $subscription['id']);

        Log::debug('==>subscribeInStripe');

        return $subscription;
    }

    private function getStripe()
    {
        return new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }

    private function getStripeDetailsWithCustomer(Request $request)
    {
        $stripe = $this->getStripe();

        // $token = $stripe->tokens->create([
        //     'card' => [
        //         'number'    => $request->get('card_no'),
        //         'exp_month' => $request->get('expiry_month'),
        //         'exp_year'  => $request->get('expiry_year'),
        //         'cvc'       => $request->get('cvv'),
        //     ],
        // ]);

        // if (!isset($token['id'])) {
        //     return Redirect::to('strips')->with('Token is not generate correct');
        // }

        $tokenId = $request->get('stripeToken');
        $customer = $this->createCustomerInStripe($stripe, $tokenId);

        return ['stripe' => $stripe, 'tokenId' => $tokenId, 'customer' => $customer, 'customerId' => $customer['id']];
    }

    private function createCustomerInStripe($stripe, $tokenId, $description = null)
    {
        Log::debug('<==createCustomerInStripe');

        $user = Auth::User();
        // create customer in stripe
        $customer = $stripe->customers->create([
            'email' => $user->email,
            'name' => $user->fname . ' ' . $user->lname,
            'description' => $description,
            'source' => $tokenId,
        ]);
        Log::debug('Customer created in stripe : ' . $customer['id']);

        Log::debug('==>createCustomerInStripe');

        return $customer;
    }

    private function chargeOneTimeViaStripe($stripeDetails, $amount)
    {
        Log::debug('<==chargeOneTimeViaStripe');
        Log::debug('Charging one time payment for the cart items which are not subscription based.');
        $stripe = $stripeDetails['stripe'];
        $customerId = $stripeDetails['customerId'];
        $currency = Currency::where('default', '=', '1')->first();
        $description = 'Enrolling in one time paid courses';

        $charge = $stripe->charges->create([
            'currency' => $currency->code,
            'amount'   =>   $amount * 100,
            'description' => $description,
            'customer' => $customerId,
        ]);

        Log::debug('==>chargeOneTimeViaStripe');

        return $charge;
    }
    #endregion


    #region COMMON HELPERS
    /**
     * Remove the price of the subscription bundles from total amount.
     */
    private function getCartDetails($amount, $carts)
    {
        Log::debug('<==getCartDetails');

        $totalAmountForAllSubscriptionCartItems = 0;
        $oneTimePaymentCartItems = [];
        $subscriptionCartItems = [];

        foreach ($carts as $cart) {
            $isBundleType = isset($cart->bundle_id) && $cart->bundle_id !== null;

            if ($isBundleType) {
                $bundle = $cart->bundle;
                Log::debug('cart item is of type bundle bundle_id: ' . $cart->bundle_id);

                $isSubscriptionTypeBundle = $bundle && isset($bundle->is_subscription_enabled) && $bundle->is_subscription_enabled == 1;

                if ($isSubscriptionTypeBundle) {
                    Log::debug($cart->bundle->title . ' cart item is of type subscription bundle: ' .  $cart->bundle_id);
                    $totalAmountForAllSubscriptionCartItems +=  $cart->offer_price;
                    array_push($subscriptionCartItems, $cart);
                } else {
                    Log::debug($cart->bundle->title . ' cart item is onetime payment bundle: ' . $cart->bundle_id);
                    array_push($oneTimePaymentCartItems, $cart);
                }
            } else {
                Log::debug($cart->courses->title . ' cart item is onetime payment course: ' . $cart->course_id);
                array_push($oneTimePaymentCartItems, $cart);
            }
        }
        $totalOneTimePaymentAmount = $amount - $totalAmountForAllSubscriptionCartItems;
        $isSubscriptionCartItemExist = count($subscriptionCartItems) > 0;
        Log::debug('Total amount' . $amount);
        Log::debug('Total Subscription amount: ' . $totalAmountForAllSubscriptionCartItems);
        Log::debug('Total OneTime amount: ' . $totalAmountForAllSubscriptionCartItems);
        if (sizeof($oneTimePaymentCartItems) < 1 &&  sizeof($subscriptionCartItems) < 1) {
            Log::debug('cart is empty');

            throw new \Exception('Cart Item Is Empty');
        }

        $details = array('totalOneTimePaymentAmount' => $totalOneTimePaymentAmount,  'isSubscriptionCartItemExist' => $isSubscriptionCartItemExist, 'oneTimePaymentCartItems' => $oneTimePaymentCartItems, 'subscriptionCartItems' => $subscriptionCartItems);

        // Log::debug('Returning cart details: ' . print_r($details, TRUE));
        Log::debug('==>getCartDetails');

        return $details;
    }

    private function getNextOrderId()
    {
        $lastOrder = Order::orderBy('created_at', 'desc')->first();

        if (!$lastOrder) {
            // We get here if there is no order at all
            // If there is no number set it to 0, which will be 1 at the end.
            $number = 0;
        } else {
            $number = substr($lastOrder->order_id, 3);
        }

        $orderId = '#' . sprintf("%08d", intval($number) + 1);

        Log::debug('created new order id : ' . $orderId);

        return $orderId;
    }
    #endregion
}