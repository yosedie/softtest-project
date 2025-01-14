<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;
use Carbon;
use App\Cart;
use Auth;
use Session;
use DB;

class ApplyCouponController extends Controller
{
    public function applycoupon(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon)->first();
        $mytime = Carbon\Carbon::now();
        $date = $mytime->toDateTimeString();

        if (isset($coupon)) {
            if ($coupon->expirydate >= $date) {
                if ($coupon->maxusage != 0) {
                    if ($coupon->link_by == 'course') {

                        return $this->validCouponForCourse($coupon);
                    } elseif ($coupon->link_by == 'cart') {

                        return $this->validCouponForCart($coupon);
                    } elseif ($coupon->link_by == 'category') {

                        return $this->validCouponForCategory($coupon);
                    } elseif ($coupon->link_by == 'bundle') {
                        return $this->validCouponForBundle($coupon);
                    }
                } else {
                    return back()->with('fail', 'Coupon max limit reached !');
                }
            } else {
                return back()->with('fail', 'Coupon Expired !');
            }
        } else {
            return back()->with('fail', 'Invalid Coupon !');
        }
    }

    public function validCouponForCourse($coupon)
    {
        $cart = Cart::where('course_id', '=', $coupon['course_id'])->where('user_id', '=', Auth::user()->id)->first();


        $per = 0;

        if (isset($cart)) {
            if ($cart->course_id == $coupon->course_id) {

                if ($coupon->distype == 'per') {
                    $per = $cart->offer_price * $coupon->amount / 100;
                } else {
                    $per = $coupon->amount;
                }



                // Putting a session//
                Session::put('coupanapplied', ['code' => $coupon->code, 'cpnid' => $coupon->id, 'discount' => $per, 'msg' => "$coupon->code is applied !", 'appliedOn' => 'course']);

                Cart::where('course_id', '=', $coupon['course_id'])->where('user_id', '=', Auth::user()
                    ->id)
                    ->update(['distype' => 'course', 'disamount' => $per ,'coupon_id' =>  $coupon->id]);
                Cart::where('course_id', '!=', $coupon['course_id'])->where('user_id', '=', Auth::user()
                    ->id)
                    ->update(['distype' => NULL, 'disamount' => NULL]);

                DB::table('coupons')->where('code', '=', $coupon['code'])->decrement('maxusage', 1);

                return back();
            } else {
                return back()
                    ->with('fail', 'Sorry no product found in your cart for this coupon !');
            }
        } else {
            return back()->with('fail', 'Sorry no product found in your cart for this coupon !');
        }
    }

    public function validCouponForBundle($coupon)
    {
        $cart = Cart::where('bundle_id', '=', $coupon['bundle_id'])->where('user_id', '=', Auth::user()->id)->first();

        $per = 0;

        if (isset($cart)) {
            if ($cart->bundle_id == $coupon->bundle_id) {

                if ($coupon->distype == 'per') {
                    $per = $cart->offer_price * $coupon->amount / 100;
                } else {
                    $per = $coupon->amount;
                }

                // Putting a session//
                Session::put(
                    'coupanapplied',
                    [
                        'code' => $coupon->code,
                        'cpnid' => $coupon->id,
                        'discount' => $per,
                        'msg' => "$coupon->code is applied !",
                        'appliedOn' => 'bundle',
                        'bundle_id' => $cart->bundle_id ,
                    ]
                );

                $cart->update(['distype' => 'bundle', 'disamount' => $per, 'coupon_id' =>  $coupon->id]);

                Cart::where('bundle_id', '!=', $coupon['bundle_id'])->where('user_id', '=', Auth::user()
                    ->id)
                    ->update(['distype' => NULL, 'disamount' => NULL]);

                DB::table('coupons')->where('code', '=', $coupon['code'])->decrement('maxusage', 1);

                return back();
            } else {
                return back()
                    ->with('fail', 'Sorry no product found in your cart for this coupon !');
            }
        } else {
            return back()->with('fail', 'Sorry no product found in your cart for this coupon !');
        }
    }

    public function validCouponForCart($coupon)
    {
        $cart = Cart::where('user_id', '=', Auth::user()->id)->get();

        $total = 0;

        if (isset($cart)) {

            foreach ($cart as $key => $c) {
                if ($c->offer_price != 0) {
                    $total = $total + $c->offer_price;
                } else {
                    $total = $total + $c->price;
                }
            }
            if ($coupon->minamount != 0) {

                if ($total >= $coupon->minamount) {
                    //check cart amount
                    $totaldiscount = 0;
                    $per = 0;

                    foreach ($cart as $key => $c) {

                        if ($coupon->distype == 'per') {

                            if ($c->offer_price != 0) {
                                $per = $c->offer_price * $coupon->amount / 100;
                                $totaldiscount = $totaldiscount + $per;
                            } else {
                                $per = $c->price * $coupon->amount / 100;
                                $totaldiscount = $totaldiscount + $per;
                            }
                        } else {

                            if ($c->offer_price != 0) {
                                $per = $coupon->amount / count($cart);
                                $totaldiscount = $totaldiscount + $per;
                            } else {
                                $per = $coupon->amount / count($cart);
                                $totaldiscount = $totaldiscount + $per;
                            }
                        }
                        // return $per;

                        Cart::where('id', '=', $c->id)
                            ->update(['distype' => 'cart', 'disamount' => $per, 'coupon_id' =>  $coupon->id]);
                    }

                    //Putting a session//
                    Session::put('coupanapplied', ['code' => $coupon->code, 'cpnid' => $coupon->id, 'discount' => $totaldiscount, 'msg' => "$coupon->code Applied Successfully !", 'appliedOn' => 'cart']);

                    DB::table('coupons')->where('code', '=', $coupon['code'])->decrement('maxusage', 1);

                    //end return success with discounted amount
                    return back();
                } else {
                    return back()
                        ->with('fail', 'For Apply this coupon your cart total should be ' . $coupon->minamount . ' or greater !');
                }
            } else {

                //check cart amount
                $totaldiscount = 0;
                $per = 0;

                foreach ($cart as $key => $c) {

                    if ($coupon->distype == 'per') {

                        if ($c->offer_price != 0) {
                            $per = $c->offer_price * $coupon->amount / 100;
                            $totaldiscount = $totaldiscount + $per;
                        } else {
                            $per = $c->price * $coupon->amount / 100;
                            $totaldiscount = $totaldiscount + $per;
                        }
                    } else {

                        if ($c->offer_price != 0) {
                            $per = $coupon->amount / count($cart);
                            $totaldiscount = $totaldiscount + $per;
                        } else {
                            $per = $coupon->amount / count($cart);
                            $totaldiscount = $totaldiscount + $per;
                        }
                    }

                    Cart::where('id', '=', $c->id)
                        ->update(['distype' => 'cart', 'disamount' => $per,'coupon_id' =>  $coupon->id]);
                }

                //Putting a session//
                Session::put('coupanapplied', ['code' => $coupon->code, 'cpnid' => $coupon->id, 'discount' => $totaldiscount, 'msg' => "$coupon->code Applied Successfully !", 'appliedOn' => 'cart']);

                DB::table('coupons')->where('code', '=', $coupon['code'])->decrement('maxusage', 1);

                //end return success with discounted amount
                return back();
            }
        }
    }

    public function validCouponForCategory($coupon)
    {

        $cart = Cart::where('user_id', '=', Auth::user()->id)->where('course_id', '!=', NULL)->get();

        $catcart = collect();

        foreach ($cart as $row) {

            if ($row
                ->courses
                ->category->id == $coupon->category_id
            ) {
                $catcart->push($row);
            }
        }

        if (count($catcart) > 0) {

            $total = 0;
            $totaldiscount = 0;
            $distotal = 0;

            foreach ($catcart as $key => $row) {
                if ($row->offer_price != 0) {
                    $total = $total + $row->offer_price;
                } else {
                    $total = $total + $row->price;
                }
            }



            foreach ($catcart as $key => $c) {

                $per = 0;

                if ($coupon->distype == 'per') {

                    if ($c->offer_price != 0) {

                        $per = $c->offer_price * $coupon->amount / 100;
                        $totaldiscount = $totaldiscount + $per;
                    } else {
                        $per = $c->price * $coupon->amount / 100;
                        $totaldiscount = $totaldiscount + $per;
                    }
                } else {

                    if ($c->offer_price != 0) {
                        $per = $coupon->amount / count($catcart);
                        $totaldiscount = $totaldiscount + $per;
                    } else {
                        $per = $coupon->amount / count($catcart);
                        $totaldiscount = $totaldiscount + $per;
                    }
                }

                Cart::where('id', '=', $c->id)
                    ->where('user_id', Auth::user()
                        ->id)
                    ->update(['distype' => 'category', 'disamount' => $per,'coupon_id' =>  $coupon->id]);

                Cart::where('category_id', '!=', $c->courses->category['id'])->where('user_id', '=', Auth::user()
                    ->id)
                    ->update(['distype' => NULL, 'disamount' => NULL]);
            }


            if ($coupon->minamount != 0) {

                if ($total >= $coupon->minamount) {

                    //Putting a session//
                    Session::put('coupanapplied', ['code' => $coupon->code, 'cpnid' => $coupon->id, 'discount' => $totaldiscount, 'msg' => "$coupon->code Applied Successfully !", 'appliedOn' => 'category']);

                    DB::table('coupons')->where('code', '=', $coupon['code'])->decrement('maxusage', 1);

                    return back();
                } else {
                    Cart::where('user_id', Auth::user()
                        ->id)
                        ->update(['distype' => NULL, 'disamount' => NULL]);
                    return back()
                        ->with('fail', 'For Apply this coupon your cart total should be ' . $coupon->minamount . ' or greater !');
                }
            } else {
                //Putting a session//
                Session::put('coupanapplied', ['code' => $coupon->code, 'cpnid' => $coupon->id, 'discount' => $totaldiscount, 'msg' => "$coupon->code Applied Successfully !", 'appliedOn' => 'category']);

                DB::table('coupons')->where('code', '=', $coupon['code'])->decrement('maxusage', 1);

                return back();
            }
        } else {
            return back()
                ->with('fail', 'Sorry no matching product found in your cart for this coupon !');
        }
    }
    public function remove($cpnid)
    {

        Session::forget('coupanapplied');

        DB::table('coupons')->where('id', $cpnid)->increment('maxusage', 1);

        Cart::where('user_id', '=', Auth::user()->id)
            ->update(['distype' => NULL, 'disamount' => NULL]);
        return back()
            ->with('fail', 'Coupon Removed !');
    }
}
