<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PendingPayout;
use App\Order;
use Session;
use Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;


class RevenueReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:report.revenue-admin-report.manage', ['only' => ['report','bulk_delete_admin','extraupdate']]);
        $this->middleware('permission:report.revenue-instructor-report.manage', ['only' => ['instructorReport', 'bulk_delete_instructor']]);    
    }
    public function report()
    {
        $orders = Order::where('status', '1')->where('total_amount', '!=', 'Free')->whereNotNull('total_amount')->get();
    	// $revenue = PendingPayout::where('status', '1')->get();
    	return view('admin.revenue.report.admin', compact('orders'));

    }

    public function instructorReport()
    {
    	$revenue = PendingPayout::get();
    	return view('admin.revenue.report.instructor', compact('revenue'));
    	
    }

     // This function performs bulk delete action
    public function bulk_delete_admin(Request $request)
    {
    
         $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
                return back()->with('warning', 'Atleast one item is required to be checked');
               
            }
            else{
                Order::whereIn('id',$request->checked)->delete();
                
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }    
    }

   // This function performs bulk delete action
   public function bulk_delete_instructor(Request $request)
    {
    
         $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
                return back()->with('warning', 'Atleast one item is required to be checked');
               
            }
            else{
                PendingPayout::whereIn('id',$request->checked)->delete();
                
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }    
    }
}
