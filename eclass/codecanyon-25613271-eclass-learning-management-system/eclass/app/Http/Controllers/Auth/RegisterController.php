<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Mail\WelcomeUser;
use Illuminate\Support\Facades\Mail;
use App\Setting;
use Spatie\Activitylog\Contracts\Activity;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Affiliate;
use App\Wallet;
use Illuminate\Support\Str;
use Module;
use Illuminate\Support\Facades\Schema;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function showRegisterForm()
    {
        $setting = Setting::first();
        if($setting->theme == '1'){
        return view('auth.register'); // Adjust if your view is in a different path
        }
        return view('theme_2.front.auth.register');
    }
    protected function validator(array $data)
    {

        $setting = Setting::first();

        if($setting->captcha_enable == 1){
            return Validator::make($data, [
                'fname' => ['required', 'string', 'max:255'],
                'lname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
                'g-recaptcha-response' => 'required|captcha',
                'mobile' => ['regex:/^([0-9\s\-\+\(\)]*)$/', 'max:17'],
                'term' => 'required',
            ]);
        }
        else{

            return Validator::make($data, [
                'fname' => ['required', 'string', 'max:255'],
                'lname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
                'mobile' => ['regex:/^([0-9\s\-\+\(\)]*)$/', 'max:17'],
                'term' => 'required',
            ]);

        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function create(array $data)
    {
    
        $setting = Setting::first();

        if($setting->mobile_enable == 1)
        {
            $mobile = $data['mobile'];
        }
        else
        {
            $mobile = NULL;
        }

        if($setting->verify_enable == 0)
        {
            $verified = \Carbon\Carbon::now()->toDateTimeString();
        }
        else
        {
            $verified = NULL;
        }

        if(Schema::hasTable('affiliate') && Schema::hasTable('wallet_settings'))
        {
            $affiliate = Affiliate::first();
        }
        else
        {
            $affiliate = NULL;
        }

        
        if(Schema::hasTable('affiliate') && Schema::hasTable('wallet_settings'))
        {
            if(isset($affiliate) && $affiliate->status == 1)
            {
                $refercode = User::createReferCode();
                if (Cookie::get('referral') !== null)
                {
                    $referred_by = Cookie::get('referral');

                }
                else
                {
                    $referred_by = NULL;
                }
                
            }
            else
            {
                $refercode = NULL;
                $referred_by = NULL;
            }
        }
        else
        {
            $refercode = NULL;
            $referred_by = NULL;
        }


        if(Schema::hasTable('affiliate') && Schema::hasTable('wallet_settings'))
        { 
            $user = User::create([

                'fname' => $data['fname'],
                'lname' => $data['lname'],
                'email' => $data['email'],
                'mobile' => $mobile,
                'email_verified_at'  => $verified,
                'password' => Hash::make($data['password']),
                'referred_by' => $referred_by,
                'affiliate_id' => $refercode,
            ]);
        }
        else{


            $user = User::create([

                'fname' => $data['fname'],
                'lname' => $data['lname'],
                'email' => $data['email'],
                'mobile' => $mobile,
                'email_verified_at'  => $verified,
                'password' => Hash::make($data['password']),
            ]);

        }

        $user->assignRole('User');
        
        


        if(Schema::hasTable('affiliate') && Schema::hasTable('wallet_settings'))
        {
            if(isset($affiliate) && $affiliate->status == 1)
            { 
                $affiliate_user = User::where('affiliate_id', $user->referred_by)->first();

                if(isset($affiliate_user) && $affiliate_user == !NULL)
                {
                    $user_wallet = Wallet::where('user_id', $affiliate_user->id)->first();

                    if(isset($user_wallet))
                    {

                        Wallet::where('user_id', $affiliate_user->id)
                        ->update(['balance' => $user_wallet->balance + $affiliate->point_per_referral ]);
                        

                    }else{
                        

                        Wallet::create([
                            'user_id' => $affiliate_user->id,
                            'balance' => $affiliate->point_per_referral, 
                        ]);

                    }
                }
            }
        }

        if(Cookie::get('referral') !== null)
        {
            Cookie::queue(Cookie::forget('referral'));
        }
        


        if(isset($setting->activity_enable))
        {
            if($setting->activity_enable == '1')
            {
                $project = new User();

                activity()
                   ->useLog('Register')
                   ->performedOn($project)
                   ->causedBy($user->id)
                   ->withProperties(['customProperty' => 'Register'])
                   ->log('User Register')
                   ->subject('Register');

            }
        }
        

        if($setting->w_email_enable == 1){
            try{
               
                Mail::to($data['email'])->send(new WelcomeUser($user));
               
            }
            catch(\Swift_TransportException $e){
                    return $e;
            }
        }
        

        return $user;
    }

    

}
