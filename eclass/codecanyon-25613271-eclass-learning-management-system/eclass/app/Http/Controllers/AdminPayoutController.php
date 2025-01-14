<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PendingPayout;
use App\User;
use Validator;
use Spatie\Permission\Models\Role;
use Auth;
use App\CompletedPayout;



class AdminPayoutController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:instructor-pending-payout.manage', ['only' => ['index','pending','paid','bulk_payout']]);
    
    }
    public function index()
    {
        if(Auth::check())
        {
            if(Auth::user()->role == 'admin')
            {
                $payout = CompletedPayout::get();
                $users = User::where('role', 'instructor')->get();

            }
            else
            {
                $payout = CompletedPayout::where('user_id', Auth::User()->id)->get();
                $users = User::where('role', 'instructor')->get();

            }
    	return view('admin.revenue.index', compact('users','payout'));

    }
    return Redirect::route('login')->withInput()->with('delete', trans('flash.PleaseLogin'));

}

    public function pending($id)
    {
    	$payout = PendingPayout::where('user_id', $id)->where('status', '0')->get();
    	return view('admin.revenue.pending', compact('payout', 'id'));
    }

    public function paid($id)
    {
        $payout = PendingPayout::where('user_id', $id)->where('status', '1')->get();
        return view('admin.revenue.paid', compact('payout', 'id'));
    }


    public function bulk_payout(Request $request, $id)
    {
        
        $user = User::where('id', $id)->first();

        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);

        if ($validator->fails()) {

            return back()->with('delete', trans('flash.Pleaseselectpayout'));
        }

        $payout = PendingPayout::all();

        $allchecked =  $request->checked;


        $total = 0;

        foreach ($request->checked as $checked) {

            $payout = PendingPayout::findOrFail($checked);
            
            $total = $total + $payout->instructor_revenue;

        }

        return view('admin.revenue.payment', compact('total', 'user', 'allchecked', 'payout'));
    }
}