<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\BundleCourse;
use Illuminate\Http\Request;
use App\Coupon;
use App\Categories;
use App\Course;
use App\Currency;
use Illuminate\Support\Facades\Validator;
use Session;
use Spatie\Permission\Models\Role;


class CouponController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:coupons.view', ['only' => ['index']]);
        $this->middleware('permission:coupons.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:coupons.edit', ['only' => ['edit', 'update','status']]);
        $this->middleware('permission:coupons.delete', ['only' => ['destroy', 'bulk_delete']]);
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupans = Coupon::orderBy('id', 'DESC')->get();
        return view("admin.coupan.index", compact("coupans"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Categories::all();
        $product = Course::all();
        $coupon_code = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 7);
        return view("admin.coupan.add", compact('coupon_code', 'category', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        try {
            $input = $request->all();
            $newc = new Coupon;

            if ($request->link_by == 'product') {
                $input['minamount'] = null;
            } else {
                $input['pro_id'] = null;
            }

            if ($request->show_to_users == 'on') {
                $input['show_to_users'] = 1;
            } else {
                $input['show_to_users'] = 0;
            }

            // stripe coupon creation
            $input = $this->processSubscriptionCoupon($input);

            $newc->create($input);

            \Session::flash('success', 'Coupon Creation Successful');

            return redirect("coupon")->with('success', trans('flash.CreatedSuccessfully'));
        } catch (\Exception $e) {
            Log::error($e->getTraceAsString());

            return redirect("coupon")->with('delete', trans('flash.CouponFailed'));
        }
    }

    /**
     * only create coupon in stripe for subscription bundle
     * dont allow edit of this coupon since stripe by design dont allow editing coupons
     */
    private function processSubscriptionCoupon($input)
    {
        if (isset($input['bundle_id'])) {
            $bundle = BundleCourse::where('id', $input['bundle_id'])->first();
            Log::debug('checking for coupon');
            
            if ($bundle->is_subscription_enabled && isset($bundle->product_id)) {
                Log::debug('going to create coupon in stripe');
                return $this->createCouponInStripe($input, $bundle);
            }
        }

        return $input;
    }

    private function createCouponInStripe($input, $bundle)
    {
        $stripe = $this->getStripe();

        $couponCreateArgs = [];

        $couponCreateArgs['name'] = $input['code'];

        if ($input['distype'] == 'per') {
            $couponCreateArgs['percent_off'] = $input['amount'];
        } else {
            $currency = Currency::where('default', '=', '1')->first();
            $couponCreateArgs['currency'] = $currency->code;
            $couponCreateArgs['amount_off'] =  $input['amount']*100;
        }

        $couponCreateArgs['applies_to'] = ['products' => [$bundle->product_id]];

        $couponCreateArgs['duration'] = 'forever';

        $couponCreateArgs['max_redemptions'] = $input['maxusage'];

        $couponCreateArgs['redeem_by'] = \Carbon\Carbon::createFromDate($input['expirydate'])->timestamp;

        Log::debug('creating coupon in stripe for subscription course: ' . print_r($couponCreateArgs, TRUE));

        $coupon = $stripe->coupons->create($couponCreateArgs);
        Log::debug('stripe coupon created: ' . $coupon['id']);

        $input['stripe_coupon_id'] = $coupon['id'];

        return $input;
    }

    private function getStripe()
    {
        return new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $coupan = Coupon::findOrFail($id);
        return view("admin.coupan.edit", compact("coupan"));
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $newc = Coupon::find($id);

        if ($request->link_by == 'product') {
            $input['minamount'] = NULL;
        } else {
            $input['pro_id'] = NULL;
        }

        if ($request->show_to_users == 'on') {
            $input['show_to_users'] = 1;
        } else {
            $input['show_to_users'] = 0;
        }

        $newc->update($input);

        return redirect("coupon")->with('success', trans('flash.UpdatedSuccessfully'));
    }

    public function destroy($id)
    {
        try {
            $newc = Coupon::find($id);
            if (isset($newc)) {
                $this->deleteCouponInStripe($newc);
                $newc->delete();
                return back()->with('success', trans('flash.DeletedSuccessfully'));
            } else {
                return back()->with('delete', trans('flash.NotFound'));
            }
        } catch (\Exception $e) {
            Log::error($e->getTraceAsString());
            return back()->with('delete', 'Coupon Delete Failed!');
        }
    }
    /**
     * If bundle with subscription then delete coupon in stripe
     */
    private function deleteCouponInStripe($coupon)
    {
        if (!isset($coupon->stripe_coupon_id)) {
            return;
        }

        $this->getStripe()->coupons->delete($coupon->stripe_coupon_id);

        Log::debug('Stripe coupon deleted: ' . $coupon->stripe_coupon_id);
    }

    public function bulk_delete(Request $request)
    {
    
         $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
                return back()->with('warning', 'Atleast one item is required to be checked');
               
            }
            else{
                Coupon::whereIn('id',$request->checked)->delete();
                
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }    
    }
        public function report(){

    }
   
    
}
