<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wallet;
use App\setting;
use App\WalletTransactions;
use DB;

class AffilateDashboardController extends Controller
{
    public function report(){
        $user = auth()->user();
        $wallet = Wallet::where('user_id',$user->id)->get();
         $wallettransaction = WalletTransactions::where('user_id',$user->id)->select(DB::raw("Month(created_at) as month"))
        ->whereYear('created_at',date('Y'))
        ->where('type','Credit')
        ->groupBy(DB::raw("Month(created_at)"))
        ->pluck('month');
        $string1 =str_replace('[','',$wallettransaction);
        $wallettransaction =str_replace(']','',$string1);

         $wallettransactions = WalletTransactions::where('user_id',$user->id)->select(DB::raw("Month(created_at) as month"))
        ->whereYear('created_at',date('Y'))
        ->where('type','Debit')
        ->groupBy(DB::raw("Month(created_at)"))
        ->pluck('month');
        $setting = Setting::first();
        if($setting->theme == '1'){
        return view('front.affiliate.dashboard',compact('wallet','wallettransaction','wallettransactions'));
        }
        return view('theme_2.front.affiliate.dashboard',compact('wallet','wallettransaction','wallettransactions'));

    }
}
