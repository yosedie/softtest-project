<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Course;
use App\setting;
use Session;
use App\User;

class EnrollmentController extends Controller
{

    public function enroll(Request $request,$id)
    {
        $course = Course::where('id', $id)->first();

        DB::table('orders')->insert(
            array(
                'user_id' => Auth::User()->id,
                'instructor_id' => $course->user_id,
                'course_id' => $id,
                'total_amount' => 'Free',
                'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            )
        );

        return back()->with('success',trans('flash.EnrolledSuccessfully'));
    }

    public function buynow(Request $request)
{
    // Get course and user based on provided IDs
    $user_check = User::where('id', $request->query('user_id'))->first();
    $course = Course::where('id', $request->query('course_id'))->first();
    
    // Cart is based on the course
    $cart = Course::where('id', $request->query('course_id'))->first();

    // Initialize totals and discounts
    $price_total = 0;
    $offer_total = 0;

    if ($course->discount_price != 0 || $course->discount_price != null) {
        $offer_total += $course->discount_price;
    } else {
        $offer_total += $course->price;
    }

    $price_total += $course->price;

    // Calculate offer amount and percentage
    $offer_amount = $price_total - $offer_total;
    $offer_percent = ($offer_amount / $price_total) * 100;

    // Cart total
    $cart_total = $offer_total;
    $one_course = 1;

    // Store course and user in the session
    Session::put('one_order_course', $course->id);
    Session::put('one_order_user', $user_check->id);

    // Retrieve setting
    $setting = setting::first();

    // Render checkout view based on theme
    if ($setting->theme == '1') {
        return view('front.checkout', compact('course', 'cart', 'price_total', 'offer_total', 'offer_percent', 'cart_total', 'one_course'));
    } else {
        return view('theme_2.front.checkout', compact('course', 'cart', 'price_total', 'offer_total', 'offer_percent', 'cart_total', 'one_course'));
    }
}



    public function freeenroll(Request $request, $price)
{
    try {
        $txn_id = uniqid();
        $payment_method = 'Free Enroll';

        // Gather the other required parameters
        $userId = $request->user()->id; // assuming the user is authenticated
        $courseId = $request->input('course_id'); // get course_id from the request
        $quantity = 1; // for free enrollments, this might be a fixed value
        $discount = 0; // assuming there is no discount for free enrollments

        // Create a new instance of OrderStoreController
        $checkout = new OrderStoreController;

        // Call the orderstore method
        return $checkout->orderstore($txn_id, $payment_method, $userId, $courseId, $quantity, $discount, $price);
    } catch (\Exception $e) {
        // Log the error message for debugging purposes
        \Log::error('Free enrollment error: ' . $e->getMessage());

        // Return an error response
        return response()->json(['error' => 'Unable to complete enrollment. Please try again later.'], 500);
    }
}

}
   