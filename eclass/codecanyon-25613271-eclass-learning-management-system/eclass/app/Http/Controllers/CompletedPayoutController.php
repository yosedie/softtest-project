<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompletedPayout;
use Auth;
use PDF;
use Redirect;
use Spatie\Permission\Models\Role;

class CompletedPayoutController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:instructor-completed-payout.manage', ['only' => ['show','view','pdfdownload']]);
    
    
    }
    public function show()
    {
        if(Auth::check())
        {
            if(Auth::user()->role == 'admin')
            {
                $payout = CompletedPayout::get();
            }
            else
            {
                $payout = CompletedPayout::where('user_id', Auth::User()->id)->get();
            }
            return view('admin.revenue.completed', compact('payout'));

        }

        return Redirect::route('login')->withInput()->with('delete', trans('flash.PleaseLogin'));
        
    }

    public function view($id)
    {
    	$payout = CompletedPayout::where('id', $id)->first();
    	return view('admin.revenue.view', compact('payout'));
    }

    public function pdfdownload($id){

        $payout = CompletedPayout::where('id', $id)->first();


        $pdf = PDF::loadView('admin.revenue.download', compact('payout'), [], 
        [ 
          'title' => 'Invoice', 
          'orientation' => 'L'
        ]
        );

        return $pdf->download('invoice.pdf');

    }
}
