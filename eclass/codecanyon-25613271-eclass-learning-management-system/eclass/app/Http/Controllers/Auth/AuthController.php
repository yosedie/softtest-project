<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use App\User;
use File;
use App\Mail\WelcomeUser;
use Illuminate\Support\Facades\Mail;
use App\Setting;
use Twilio\Rest\Client;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use Illuminate\Support\Facades\Hash;
use Session;

class AuthController extends Controller
{
   /**
     * Redirect the user to the OAuth Provider.
     *
     * @return Response
     */
    

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */
    public function handleProviderCallback($provider, Request $request)
    {
        try{
            $user = Socialite::driver($provider)->user();
        }catch(\Exception $ex){
            if(!$request->has('code') || $request->has('denied')) {
                return redirect('/');
            }
            $user = Socialite::driver($provider)->stateless()->user();
        }
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect()->intended('/');
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        if($user->email == Null){
            $user->email = $user->id.'@facebook.com';
        }
        $authUser = User::where('email', $user->email)->first();
        $providerField = "{$provider}_id";
        if($authUser){
            if ($authUser->{$providerField} == $user->id) {
                $authUser->email_verified_at = \Carbon\Carbon::now()->toDateTimeString();
                $authUser->save();
                return $authUser;
            }
            else{
                $authUser->{$providerField} = $user->id;
                $authUser->email_verified_at = \Carbon\Carbon::now()->toDateTimeString();
                $authUser->save();
                return $authUser;
            }
        }

        if($user->avatar != NULL && $user->avatar != ""){
            $fileContents = @file_get_contents($user->getAvatar());
            $user_profile = File::put(public_path() . '/images/user_img/' . $user->getId() . ".jpg", $fileContents);
            $name = $user->getId() . ".jpg";
        }
        else {
            $name = NULL;
        }

        $verified = \Carbon\Carbon::now()->toDateTimeString();

        $setting = Setting::first();

        $auth_user = User::create([
            'fname'     => $user->name,
            'email'    => $user->email,
            'user_img'    => $name,
            'email_verified_at'  => $verified,
            $providerField => $user->id,
        ]);

        $auth_user->assignRole('User');
        
        if($setting->w_email_enable == 1){
            try{
               
                Mail::to($auth_user['email'])->send(new WelcomeUser($auth_user));
               
            }
            catch(\Swift_TransportException $e){

            }
        }
        return $auth_user;



    }
//     protected function verify(Request $request)
// {
//     $data = $request->validate([
//         'verification_code' => ['required', 'numeric'],
//         'phone_number' => ['required', 'string'],
//     ]);

//     // Validate and format phone number to E.164 format
//     $phoneUtil = PhoneNumberUtil::getInstance();
//     try {
//         $phoneNumberProto = $phoneUtil->parse($data['phone_number'], "US"); // Assuming default country as US
//         $formattedPhoneNumber = $phoneUtil->format($phoneNumberProto, PhoneNumberFormat::E164);
//     } catch (\libphonenumber\NumberParseException $e) {
//         return back()->with(['phone_number' => $data['phone_number'], 'error' => 'Invalid phone number format!']);
//     }

//     // Use test credentials for non-production environment
//     $token = getenv("TWILIO_AUTH_TOKEN");
//     $twilio_sid = getenv("TWILIO_SID");
//     $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");

//     $twilio = new Client($twilio_sid, $token);

//     try {
//         // Mock the verification response for test environment
//         if (env('APP_ENV') !== 'production') {
//             $verification = (object) ['valid' => $data['verification_code'] === '123456'];
//         } else {
//             // Actual Twilio verification call
//             $verification = $twilio->verify->v2->services($twilio_verify_sid)
//                 ->verificationChecks
//                 ->create([
//                     'code' => $data['verification_code'],
//                     'to' => $formattedPhoneNumber,
//                 ]);
//         }

//         if ($verification->valid) {
//             $user = tap(User::where('phone_number', $data['phone_number']))->update(['isVerified' => true]);
//             // Authenticate user
//             Auth::login($user->first());
//             return redirect()->route('home')->with(['message' => 'Phone number verified']);
//         }

//         return back()->with(['phone_number' => $data['phone_number'], 'error' => 'Invalid verification code entered!']);

//     } catch (RestException $e) {
//         return back()->with(['phone_number' => $data['phone_number'], 'error' => 'Verification failed! Please try again.']);
//     }
// }
    // public function sendOtp(Request $request)
    // {
    //     $request->validate([
    //         'phone_number' => 'required|string',
    //     ]);

    //     // Format the phone number
    //     $phoneUtil = PhoneNumberUtil::getInstance();
    //     try {
    //         $phoneNumberProto = $phoneUtil->parse($request->phone_number, null);
    //         $formattedPhoneNumber = $phoneUtil->format($phoneNumberProto, PhoneNumberFormat::E164);
    //     } catch (\libphonenumber\NumberParseException $e) {
    //         return response()->json(['success' => false, 'message' => 'Invalid phone number format']);
    //     }

    //     // Fetch the credentials from the environment
    //     $token = env("TWILIO_AUTH_TOKEN");
    //     $twilio_sid = env("TWILIO_SID");
    //     $twilio_verify_sid = env("TWILIO_VERIFY_SID");
    //      // Check if environment variables are correctly loaded
    //      if (!$token || !$twilio_sid || !$twilio_verify_sid) {
    //         return response()->json(['success' => false, 'message' => 'Twilio credentials are not set correctly']);
    //     }
    //     // Instantiate the Twilio client
    //     $twilio = new Client($twilio_sid, $token);
    //     try {
    //         $twilio->verify->v2->services($twilio_verify_sid)
    //             ->verifications
    //             ->create($formattedPhoneNumber, "sms");
    //         return response()->json(['success' => true]);
    //     } catch (\Exception $e) {
    //         return response()->json(['success' => false, 'message' => 'Failed to send OTP: ' . $e->getMessage()]);
    //     }
    // }


    public function sendOtp(Request $request)
    {
        // Validate the request
        $request->validate([
            'phone_number' => 'required|string',
            'country_code' => 'required|string',
        ]);

        // Retrieve recipient number and country code from the request
        $recipientNumber = $request->input('phone_number');
        $countryCode = $request->input('country_code');
        
        // Ensure recipient number is prefixed with 'whatsapp:' if not already
        if (strpos($recipientNumber, 'whatsapp:') === false) {
            $fullRecipientNumber = 'whatsapp:' . $countryCode . $recipientNumber;
        } else {
            $fullRecipientNumber = 'whatsapp:' . $countryCode . substr($recipientNumber, 9); // Remove 'whatsapp:' prefix
        }

        // Ensure the full recipient number starts with '+'
        if ($fullRecipientNumber[8] !== '+') {
            $fullRecipientNumber = 'whatsapp:+' . substr($fullRecipientNumber, 9);
        }
         // Store the fullRecipientNumber in the session
        Session::put('fullRecipientNumber', $fullRecipientNumber);
        // Fetch the credentials from the environment
        $token = env("TWILIO_AUTH_TOKEN");
        $twilio_sid = env("TWILIO_SID");
        $twilio_verify_sid = env("TWILIO_VERIFY_SID");

        // Check if environment variables are correctly loaded
        if (!$token || !$twilio_sid || !$twilio_verify_sid) {
            return response()->json(['success' => false, 'message' => 'Twilio credentials are not set correctly']);
        }

        // Format the phone number using libphonenumber
        $phoneUtil = PhoneNumberUtil::getInstance();
        try {
            $phoneNumberProto = $phoneUtil->parse($fullRecipientNumber, null);
            $formattedPhoneNumber = $phoneUtil->format($phoneNumberProto, PhoneNumberFormat::E164);
        } catch (\libphonenumber\NumberParseException $e) {
            return response()->json(['success' => false, 'message' => 'Invalid phone number format']);
        }

        // Instantiate the Twilio client
        $twilio = new Client($twilio_sid, $token);
        try {
            $twilio->verify->v2->services($twilio_verify_sid)
                ->verifications
                ->create($formattedPhoneNumber, "sms");
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to send OTP: ' . $e->getMessage()]);
        }
    }


    public function verifyOtp(Request $request)
    {
        //return $request;
        $request->validate([
            'verification_code' => 'required|numeric',
            'phone_number' => 'string',
        ]);
        $fullRecipientNumber = Session::get('fullRecipientNumber');
        // Format the phone number
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $phoneUtil = PhoneNumberUtil::getInstance();
        try {
            $phoneNumberProto = $phoneUtil->parse($fullRecipientNumber, null);
            $formattedPhoneNumber = $phoneUtil->format($phoneNumberProto, PhoneNumberFormat::E164);
        } catch (\libphonenumber\NumberParseException $e) {
            return response()->json(['success' => false, 'message' => 'Invalid phone number format']);
        }
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);

        try {
            $verification = $twilio->verify->v2->services($twilio_verify_sid)
                ->verificationChecks
                ->create([
                    'code' => $request->verification_code,
                    'to' => $formattedPhoneNumber,
                ]);
        
            if ($verification->valid) {
                $password = '123456';
                $phoneNumberWithoutCountryCode = substr($formattedPhoneNumber, 3); // Assuming the country code length is always 3
                $user = User::where('mobile',$phoneNumberWithoutCountryCode)->first();
                if ($user) {
                    // If user exists, log in the user
                    Auth::login($user);
                    // Redirect the user to the home page or any other desired page
                    return redirect()->route('home')->with(['message' => 'Login successful']);
                } else {
                $user = User::create([
                    'fname' => $phoneNumberWithoutCountryCode, // Example first name
                    'lname' => null,  // Example last name
                    'email' => $phoneNumberWithoutCountryCode.'@gmail.com',
                    'mobile' =>  $phoneNumberWithoutCountryCode,
                    'email_verified_at'  => now(),
                    'password' => Hash::make($password),
                ]);
                $user->assignRole('User');
                Auth::login($user);
                }
                    return redirect()->route('home')->with(['message' => 'Register successfully']);
                } else {
                // Phone number verification failed
                return response()->json(['success' => false, 'message' => 'Invalid verification code entered! ']);
            }
        } catch (\Exception $e) {
            // Handle Twilio verification exception
            // For example, log the error and return an error response
            return response()->json(['success' => false, 'message' => 'Failed to verify phone number!: ' . $e->getMessage()]);
        }
    }
}