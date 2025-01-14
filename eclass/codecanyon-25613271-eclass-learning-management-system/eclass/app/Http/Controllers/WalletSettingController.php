<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WalletSettings;
use App\WalletTransactions;
use Session;
use Spatie\Permission\Models\Role;


class WalletSettingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | WalletSettingController
    |--------------------------------------------------------------------------
    |
    | This controller holds the logics and functionality of wallet settings.
    |
     */

    /**
     * @return view of wallet settings
     */
    public function __construct()
    {
        $this->middleware('permission:wallet-setting.manage', ['only' => ['index','update']]);
        $this->middleware('permission:wallet-transactions.manage', ['only' => ['transactions']]);
    }
    public function index()
    {
        $settings = WalletSettings::first();
        $wallet_transactions = WalletTransactions::get();
        return view('admin.wallet.index', compact('settings', 'wallet_transactions'));
    }

    /**
     * This function holds the funncality to update wallet settings.  
     */

    public function update(Request $request)
    {
        
        try{

            /** Get the wallet settings */

            $settings = WalletSettings::first();
            $input = $request->all();

            if($settings){

                if (!isset($input['status'])) {
                    $input['status'] = 0;
                }
                else{
                    $input['status'] = 1;   
                }

                if (!isset($input['paytm_enable'])) {
                    $input['paytm_enable'] = 0;
                }
                else{
                    $input['paytm_enable'] = 1;   
                }

                if (!isset($input['paypal_enable'])) {
                    $input['paypal_enable'] = 0;
                }
                else{
                    $input['paypal_enable'] = 1;   
                }
               

                if (!isset($input['stripe_enable'])) {
                    $input['stripe_enable'] = 0;
                }
                else{
                    $input['stripe_enable'] = 1;   
                }
            

                $settings->update($input);

            }else{

                /** Create new wallet settings if not exist */

                $settings = new WalletSettings;

                
                
                if (!isset($input['status'])) {
                    $input['status'] = 0;
                }
                else{
                    $input['status'] = 1;   
                }

                if (!isset($input['paytm_enable'])) {
                    $input['paytm_enable'] = 0;
                }
                else{
                    $input['paytm_enable'] = 1;   
                }

                if (!isset($input['paypal_enable'])) {
                    $input['paypal_enable'] = 0;
                }
                else{
                    $input['paypal_enable'] = 1;   
                }

                if (!isset($input['stripe_enable'])) {
                    $input['stripe_enable'] = 0;
                }
                else{
                    $input['stripe_enable'] = 1;   
                }



                $settings->create($input);
            }

            Session::flash('success',__('flash.UpdatedSuccessfully'));
            return back()->with('Saved successfully');
            
        }catch(\Exception $e){

            /** Catch the error and @return back to previous location with error message */

            \Session::flash('delete', $e->getMessage());
            return back();
        }
    }

    /**
     * This function holds the funncality to get all wallet transcations. 
     */

    public function transactions()
    {
        $wallet_transactions = WalletTransactions::get();
        return view('admin.wallet.transactions', compact('wallet_transactions'));
    }
}
