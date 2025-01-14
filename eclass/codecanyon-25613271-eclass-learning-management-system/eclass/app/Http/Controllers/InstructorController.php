<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Charts\OrderChart;
use App\Order;
use App\User;
use App\CompletedPayout;
use App\Charts\InstrctorPayoutChart;
use DB;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;

class InstructorController extends Controller
{
    public function __construct()
    {
		$this->middleware('permission:dashboard.manage', ['only' => ['index']]);
    }

    public function index()
    {   
    //    return auth()->user()->getRoleNames()->toArray();
        if(Auth::User()->role == "instructor")
        {
            $userenroll = array(
                Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '01')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //January
                Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '02')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //Feb
                Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '03')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //March
                Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '04')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //April
                Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '05')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //May
                Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '06')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //June
                Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '07')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //July
                Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '08')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //August
                Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '09')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //September
                Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '10')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //October
                Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '11')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //November
                Order::where('instructor_id', Auth::user()->id)->whereMonth('created_at', '12')->where('status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //December
            );

            $userEnrolled = new OrderChart;
            $userEnrolled->labels(['January', 'Febuary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
            $userEnrolled->label('Enrolled Users')->title('Total Orders in ' . date('Y'))->dataset('Monthly Enrolled Users', 'area', $userenroll)->options([
                'fill' => 'true',
                'shadow' => true,
                'borderWidth' => '2',
                'color' => '#f9616d',
               
            ]);


            $completed = array(
                CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '01')->where('pay_status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //January
                CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '02')->where('pay_status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //Feb
                CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '03')->where('pay_status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //March
                CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '04')->where('pay_status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //April
                CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '05')->where('pay_status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //May
                CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '06')->where('pay_status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //June
                CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '07')->where('pay_status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //July
                CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '08')->where('pay_status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //August
                CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '09')->where('pay_status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //September
                CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '10')->where('pay_status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //October
                CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '11')->where('pay_status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //November
                CompletedPayout::where('user_id', Auth::user()->id)->whereMonth('created_at', '12')->where('pay_status', '1')
                    ->whereYear('created_at', date('Y'))
                    ->count(), //December
            );


            $payout = new InstrctorPayoutChart;
            $payout->labels(['January', 'Febuary', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
            // $payout->label('My Payout')->title('Total Payout in ' . date('Y'))->dataset('Monthly Payout', 'bar', $completed)

            $payout->title('Monthly Registered Users in ' . date('Y'))->dataset('Monthly Registered Users', 'bar', $completed)
            ->backgroundColor("rgba(80,111,228,0.4)")
            ->color("rgba(80,111,228,0.4)")
            ->dashed([0])
            ->fill(true)
            ->linetension(0.1);
              $users =   CompletedPayout::select(DB::raw("COUNT(*) as count"))
                ->whereYear('created_at',date('Y'))
                ->groupBy(DB::raw("Month(created_at)"))
                ->pluck('count');
                
            $months =  CompletedPayout::select(DB::raw("Month(created_at) as month"))
                    ->whereYear('created_at',date('Y'))
                    ->groupBy(DB::raw("Month(created_at)"))
                    ->pluck('month');

            $datas = [0,0,0,0,0,0,0,0,0,0,0,0];
            foreach($months as $index => $month)
            {
                $datas[$month-1] = $users[$index];
            }  



            $users =    Order::select(DB::raw("COUNT(*) as count"))
                ->whereYear('created_at',date('Y'))
                ->groupBy(DB::raw("Month(created_at)"))
                ->pluck('count');
                
            $months =   Order::select(DB::raw("Month(created_at) as month"))
                    ->whereYear('created_at',date('Y'))
                    ->groupBy(DB::raw("Month(created_at)"))
                    ->pluck('month');

            $datas1 = [0,0,0,0,0,0,0,0,0,0,0,0];
            foreach($months as $index => $month)
            {
                $datas1[$month-1] = $users[$index];
            }  

            return view('instructor.dashboard', compact('userEnrolled', 'payout','datas','datas1'));
        }
        else
        {
            return back()->with('success',trans('flash.NotFound'));
        }
    }


	
}
