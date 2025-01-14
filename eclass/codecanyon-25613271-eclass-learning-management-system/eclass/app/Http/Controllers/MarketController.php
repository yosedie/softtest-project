<?php

namespace App\Http\Controllers;
use App\Order;
use App\Coupon;
use App\WalletTransactions;
use App\Course;
use Auth;
use App\BundleCourse;
use App\Currency;
use App\Meeting;
use App\JitsiMeeting;
use App\BBL;
use App\Googlemeet;
Use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;

class MarketController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:marketing-dashboard.manage', ['only' => ['index']]);
    
      
    }
    public function index(){

        $user_order_count =  DB::table('users')
        ->select('users.fname', DB::raw('COUNT(orders.user_id) AS order_count'), DB::raw('SUM(total_amount) as total_amount'))
        ->join('orders', 'users.id', '=', 'orders.user_id')
        ->groupBy('users.id')
        ->orderBy('order_count', 'DESC')
        ->take(5)
        ->get();

        $currencies = Currency::where('default','1')->value('symbol');

        $order_total = array(
            Order::whereMonth('created_at', '01')
                ->whereYear('created_at', date('Y'))->sum('total_amount'),
            Order::whereMonth('created_at', '02')
                ->whereYear('created_at', date('Y'))->sum('total_amount'),
            Order::whereMonth('created_at', '03')
                ->whereYear('created_at', date('Y'))->sum('total_amount'),
            Order::whereMonth('created_at', '04')
                ->whereYear('created_at', date('Y'))->sum('total_amount'),
            Order::whereMonth('created_at', '05')
                ->whereYear('created_at', date('Y'))->sum('total_amount'),
            Order::whereMonth('created_at', '06')
                ->whereYear('created_at', date('Y'))->sum('total_amount'),
            Order::whereMonth('created_at', '07')
                ->whereYear('created_at', date('Y'))->sum('total_amount'),
            Order::whereMonth('created_at', '08')
                ->whereYear('created_at', date('Y'))->sum('total_amount'),
            Order::whereMonth('created_at', '09')
                ->whereYear('created_at', date('Y'))->sum('total_amount'),
            Order::whereMonth('created_at', '10')
                ->whereYear('created_at', date('Y'))->sum('total_amount'),
            Order::whereMonth('created_at', '11')
                ->whereYear('created_at', date('Y'))->sum('total_amount'),
            Order::whereMonth('created_at', '12')
                ->whereYear('created_at', date('Y'))->sum('total_amount')
            );
            
            $featured       =       Course::where('featured' ,1)->count();
            $coupan         =       Coupon::where('expirydate' ,'<' ,Carbon::now())->count();
            $total          =       DB::table('wallet_transactions')->sum('total_amount');
            $total_order    =       DB::table('orders')->sum('total_amount');
            $order          =       Order::select('user_id')->get();
            $users          =       User::whereNotIn('id',$order)->count();
            $ins_payment    =       DB::table('pending_payouts')->sum('instructor_revenue');
            $total_amount   =       DB::table('pending_payouts')->sum('total_amount');
            $admin_payment  =       $total_amount - $ins_payment;
            $admin_amount   =       DB::table('orders')->where('user_id',Auth::user()->id)->sum('total_amount');
            $admin_total    =       $admin_amount + $admin_payment;
            $course         =       Course::count();
            $bundle_course  =       BundleCourse::count();
            $meeting        =       Meeting::count();
            $jitsi          =       JitsiMeeting::count();
            $bbl            =       BBL::count();
            $google         =       Googlemeet::count();
           
            $total_meeting  =       $meeting + $jitsi + $bbl + $google;
            $graph          =       [$course,$bundle_course,$total_meeting];

            return view('admin.marketing.dashboard',compact('order_total','featured','coupan','total',
                                                        'total_order','users','ins_payment','admin_total',
                                                        'graph','user_order_count','currencies'));
    }
}
