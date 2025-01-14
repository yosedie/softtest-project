<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Setting;
use Hash;
use Illuminate\Support\Facades\Cookie;
use Session;

class TwoFactorAuthController extends Controller
{
    public function show2faForm()
    {
    	// $affilates = Affiliates::first();

    	$user = \Auth::user();

        $google2fa_url = "";

        // initialise the 2FA class
        $google2fa = app('pragmarx.google2fa');

        if($user->google2fa_secret == ''){

            // // generate a new secret key for the user
            $user->google2fa_secret = $google2fa->generateSecretKey();

            // // save the user
            $user->save();
        }

        // generate the QR image
        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $user->google2fa_secret
        );


        $setting = Setting::first();
        if($setting->theme == '1'){
        return view('google2fa.view', compact('QR_Image'));
        } else {
        return view('theme_2.front.google2fa.view',compact('QR_Image'));
       }
    }

    
    public function generate2faSecret(Request $request){

    	$user = \Auth::user();


        $google2fa = app('pragmarx.google2fa');

        // generate a new secret key for the user
        $user->google2fa_secret = $google2fa->generateSecretKey();

        // save the user
        $user->save();

        
            
        return back();
    }

    public function enable2fa(Request $request)
    {

        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');

        $secret = $request->input('one_time_password');
        $valid = $google2fa->verifyKey($user->google2fa_secret, $secret);

        if($valid){
            $user->google2fa_enable = 1;
            $user->save();
            return back()->with('success',"2FA is enabled successfully.");
        }else{
            return back()->with('delete',"Invalid verification Code, Please try again.");
        }
    }

    public function disable2fa(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches  
            Session::flash('success','Your password does not matches with your account password. Please try again');
            return back();
        }
        $validatedData = $request->validate([
            'current-password' => 'required',
        ]);
        $user = Auth::user();
        $user->google2fa_enable = 0;
        $user->google2fa_secret = NULL;
        $user->save();
        return redirect('/2fa')->with('success',"2FA is now disabled.");
    }

    public function verify(Request $request){
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $secret = $request->input('password');
        $valid = $google2fa->verifyKey($user->google2fa_secret, $secret);
        if($valid){
            Cookie::queue('two_fa',1);
            return redirect()->intended('/');
        }else{
            return back()->withErrors(['password' => 'Invalid pin !']);
        }
    }   
}
