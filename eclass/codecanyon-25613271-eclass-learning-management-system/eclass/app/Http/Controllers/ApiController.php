<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use DotenvEditor;
use Module;
use Spatie\Permission\Models\Role;


class ApiController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:payment-setting-credentials.manage', ['only' => ['setApiView', 'changeEnvKeys']]);
    
    }
    public function setApiView()
    {
        $setting = Setting::first();
        $env_files = [
            'STRIPE_KEY' => env('STRIPE_KEY'),
            'STRIPE_SECRET' => env('STRIPE_SECRET'),
            'PAYPAL_CLIENT_ID' => env('PAYPAL_CLIENT_ID'),
            'PAYPAL_SECRET' => env('PAYPAL_SECRET'),
            'PAYPAL_MODE' => env('PAYPAL_MODE'),
            'IM_API_KEY' => env('IM_API_KEY'),
            'IM_AUTH_TOKEN' => env('IM_AUTH_TOKEN'),
            'IM_URL' => env('IM_URL'),
            'RAZORPAY_KEY' => env('RAZORPAY_KEY'),
            'RAZORPAY_SECRET' => env('RAZORPAY_SECRET'),
            'PAYSTACK_PUBLIC_KEY' => env('PAYSTACK_PUBLIC_KEY'),
            'PAYSTACK_SECRET_KEY' => env('PAYSTACK_SECRET_KEY'),
            'PAYSTACK_PAYMENT_URL' => env('PAYSTACK_PAYMENT_URL'),
            'PAYSTACK_MERCHANT_EMAIL' => env('PAYSTACK_MERCHANT_EMAIL'),
            'PAYTM_ENVIRONMENT' => env('PAYTM_ENVIRONMENT'),
            'PAYTM_MERCHANT_ID' => env('PAYTM_MERCHANT_ID'),
            'PAYTM_MERCHANT_KEY' => env('PAYTM_MERCHANT_KEY'),
            'PAYTM_MERCHANT_WEBSITE' => env('PAYTM_MERCHANT_WEBSITE'),
            'PAYTM_CHANNEL' => env('PAYTM_CHANNEL'),
            'PAYTM_INDUSTRY_TYPE' => env('PAYTM_INDUSTRY_TYPE'),
            'NOCAPTCHA_SITEKEY' => env('NOCAPTCHA_SITEKEY'),
            'NOCAPTCHA_SECRET' => env('NOCAPTCHA_SECRET'),
            'AWS_ACCESS_KEY_ID' => env('AWS_ACCESS_KEY_ID'),
            'AWS_SECRET_ACCESS_KEY' => env('AWS_SECRET_ACCESS_KEY'),
            'AWS_DEFAULT_REGION' => env('AWS_DEFAULT_REGION'),
            'AWS_BUCKET' => env('AWS_BUCKET'),
            'AWS_URL' => env('AWS_URL'),
            'IM_REFUND_URL' => env('IM_REFUND_URL'),
            'API_DOMAIN_URL' => env('API_DOMAIN_URL'), 
            'STORE_ID' => env('STORE_ID'),
            'STORE_PASSWORD' => env('STORE_PASSWORD'),
            'IS_LOCALHOST' => env('IS_LOCALHOST'),
            'YOUTUBE_API_KEY' => env('YOUTUBE_API_KEY'),
            'VIMEO_CLIENT' => env('VIMEO_CLIENT'),
            'VIMEO_SECRET' => env('VIMEO_SECRET'),
            'VIMEO_ACCESS' => env('VIMEO_ACCESS'),
            'AAMARPAY_STORE_ID' => env('AAMARPAY_STORE_ID'),
            'AAMARPAY_KEY' => env('AAMARPAY_KEY'),
            'AAMARPAY_SANDBOX' => env('AAMARPAY_SANDBOX'),
            'BRAINTREE_ENV' => env('BRAINTREE_ENV'),
            'BRAINTREE_MERCHANT_ID' => env('BRAINTREE_MERCHANT_ID'),
            'BRAINTREE_PUBLIC_KEY' => env('BRAINTREE_PUBLIC_KEY'),
            'BRAINTREE_PRIVATE_KEY' => env('BRAINTREE_PRIVATE_KEY'),
            'GOOGLE_TAG_MANAGER_ID' => env('GOOGLE_TAG_MANAGER_ID'),
            'GOOGLE_TAG_MANAGER_ENABLED' => env('GOOGLE_TAG_MANAGER_ENABLED'),
            'PAYFLEXI_PUBLIC_KEY' => env('PAYFLEXI_PUBLIC_KEY'),
            'PAYFLEXI_SECRET_KEY' => env('PAYFLEXI_SECRET_KEY'),
            'PAYFLEXI_PAYMENT_GATEWAY' => env('PAYFLEXI_PAYMENT_GATEWAY'),
            'PAYFLEXI_MODE' => env('PAYFLEXI_MODE'),
            'ESEWA_MERCHANT_ID' => env('ESEWA_MERCHANT_ID'),
            'ESEWA_MODE' => env('ESEWA_MODE'),
            'SMANAGER_CLIENT_ID' => env('SMANAGER_CLIENT_ID'),
            'SMANAGER_CLIENT_SECRET' => env('SMANAGER_CLIENT_SECRET'),
            'SMANAGER_URL' => env('SMANAGER_URL'),
            'ENABLE_PAYTAB' => env('ENABLE_PAYTAB'),
            'PAYTAB_PROFILE_ID' => env('PAYTAB_PROFILE_ID'),
            'PAYTAB_SERVER_KEY' => env('PAYTAB_SERVER_KEY'),
            'ENABLE_DPOPAYMENT' => env('ENABLE_DPOPAYMENT'),
            'SERVICE_TYPE' => env('SERVICE_TYPE'),
            'COMPANY_TOKEN' => env('COMPANY_TOKEN'),
            'DPO_SANDBOX' => env('DPO_SANDBOX'),
            'AUTHORIZE_NET_ENABLE' => env('AUTHORIZE_NET_ENABLE'),
            'API_LOGIN_ID' => env('API_LOGIN_ID'),
            'TRANSCATION_KEY' => env('TRANSCATION_KEY'),
            'AUTHORIZE_NET_MODE' => env('AUTHORIZE_NET_MODE'),
            'BKASH_APP_KEY' => env('BKASH_APP_KEY'),
            'BKASH_APP_SECRET' => env('BKASH_APP_SECRET'),
            'BKASH_USER_NAME' => env('BKASH_USER_NAME'),
            'BKASH_PASSWORD' => env('BKASH_PASSWORD'),
            'ENABLE_BKASH' => env('ENABLE_BKASH'),
            'BKASH_SANDBOX_MODE' => env('BKASH_SANDBOX_MODE'),
            'MID_TRANS_CLIENT_KEY' => env('MID_TRANS_CLIENT_KEY'),
            'MID_TRANS_SERVER_KEY' => env('MID_TRANS_SERVER_KEY'),
            'MID_TRANS_MODE' => env('MID_TRANS_MODE'),
            'MID_TRANS_ENABLE' => env('MID_TRANS_ENABLE'),
            'SQUARE_PAY_ENABLE' => env('SQUARE_PAY_ENABLE'),
            'SQUARE_PAY_LOCATION_ID' => env('SQUARE_PAY_LOCATION_ID'),
            'SQUARE_ACCESS_TOKEN' => env('SQUARE_ACCESS_TOKEN'),
            'SQUARE_APPLICATION_ID' => env('SQUARE_APPLICATION_ID'),
            'WORLDPAY_CLIENT_KEY' => env('WORLDPAY_CLIENT_KEY'),
            'WORLDPAY_SECRET_KEY' => env('WORLDPAY_SECRET_KEY'),
            'WORLDPAY_ENABLE' => env('WORLDPAY_ENABLE'),
            'WASABI_KEY' => env( 'WASABI_KEY'),
            'WASABI_SECRET'=> env('WASABI_SECRET'),
            'WASABI_BUCKET'=> env('WASABI_BUCKET'),
            'WASABI_REGION' => env('WASABI_REGION'),
            'BUNNY_REGION' => env('BUNNY_REGION'),
            'BUNNYCDN_STORAGE_ZONE_NAME' => env('BUNNYCDN_STORAGE_ZONE_NAME'),
            'BUNNYCDN_API_KEY' => env('BUNNYCDN_API_KEY'),
            'BUNNYCDN_PULL_ZONE' => env('BUNNYCDN_PULL_ZONE'),
        ];

        

        return view('admin.setting.api', compact('env_files', 'setting'));
    }

    public function changeEnvKeys(Request $request)
    {

        $input = $request->all();
        $setting = Setting::first();


        $addenv_keys = DotenvEditor::setKeys([

            'STRIPE_KEY' => $input['STRIPE_KEY'],
            'STRIPE_SECRET' => $input['STRIPE_SECRET'],
            'PAYPAL_CLIENT_ID' => $input['PAYPAL_CLIENT_ID'],
            'PAYPAL_SECRET' => $input['PAYPAL_SECRET'],
            'PAYPAL_MODE' => $input['PAYPAL_MODE'],
            'IM_API_KEY' => $input['IM_API_KEY'],
            'IM_AUTH_TOKEN' => $input['IM_AUTH_TOKEN'],
            'IM_URL' => $input['IM_URL'],
            'RAZORPAY_KEY' => $input['RAZORPAY_KEY'],
            'RAZORPAY_SECRET' => $input['RAZORPAY_SECRET'],
            'PAYSTACK_PUBLIC_KEY' => $input['PAYSTACK_PUBLIC_KEY'],
            'PAYSTACK_SECRET_KEY' => $input['PAYSTACK_SECRET_KEY'],
            'PAYSTACK_PAYMENT_URL' => $input['PAYSTACK_PAYMENT_URL'],
            'PAYSTACK_MERCHANT_EMAIL' => $input['PAYSTACK_MERCHANT_EMAIL'],
            'PAYTM_ENVIRONMENT' => $input['PAYTM_ENVIRONMENT'],
            'PAYTM_MERCHANT_ID' => $input['PAYTM_MERCHANT_ID'],
            'PAYTM_MERCHANT_KEY' => $input['PAYTM_MERCHANT_KEY'],
            'PAYTM_MERCHANT_WEBSITE' => $input['PAYTM_MERCHANT_WEBSITE'],
            'PAYTM_CHANNEL' => $input['PAYTM_CHANNEL'],
            'PAYTM_INDUSTRY_TYPE' => $input['PAYTM_INDUSTRY_TYPE'],
            'NOCAPTCHA_SITEKEY' => $input['NOCAPTCHA_SITEKEY'],
            'NOCAPTCHA_SECRET' => $input['NOCAPTCHA_SECRET'],
            'AWS_ACCESS_KEY_ID' => $input['AWS_ACCESS_KEY_ID'],
            'AWS_SECRET_ACCESS_KEY' => $input['AWS_SECRET_ACCESS_KEY'],
            'AWS_DEFAULT_REGION' => $input['AWS_DEFAULT_REGION'],
            'AWS_BUCKET' => $input['AWS_BUCKET'],
            'AWS_URL' => $input['AWS_URL'],
            'PAYU_MERCHANT_KEY' => $input['PAYU_MERCHANT_KEY'],
            'PAYU_MERCHANT_SALT' => $input['PAYU_MERCHANT_SALT'],
            'PAYU_AUTH_HEADER' => $input['PAYU_AUTH_HEADER'],
            'PAYU_MONEY_TRUE' => isset($request->payu_money) ? "true" : "false",
            'MOLLIE_KEY' => $input['MOLLIE_KEY'],
            'CASHFREE_APP_ID' => $input['CASHFREE_APP_ID'],
            'CASHFREE_SECRET_KEY' => $input['CASHFREE_SECRET_KEY'],
            'CASHFREE_END_POINT' => $input['CASHFREE_END_POINT'],
            'SKRILL_MERCHANT_EMAIL' => $input['SKRILL_MERCHANT_EMAIL'],
            'SKRILL_API_PASSWORD' => $input['SKRILL_API_PASSWORD'],
            'SKRILL_LOGO_URL' => $input['SKRILL_LOGO_URL'],
            'RAVE_PUBLIC_KEY' => $input['RAVE_PUBLIC_KEY'],
             'RAVE_SECRET_KEY' => $input['RAVE_SECRET_KEY'],
            'RAVE_ENVIRONMENT' => $input['RAVE_ENVIRONMENT'],
            'RAVE_LOGO' => $input['RAVE_LOGO'],
            'RAVE_PREFIX' => $input['RAVE_PREFIX'],
            'RAVE_COUNTRY' => $input['RAVE_COUNTRY'],
            'OMISE_PUBLIC_KEY' => $input['OMISE_PUBLIC_KEY'],
            'OMISE_SECRET_KEY' => $input['OMISE_SECRET_KEY'],
            'OMISE_API_VERSION' => $input['OMISE_API_VERSION'],
            'PAYHERE_MERCHANT_ID' => $input['PAYHERE_MERCHANT_ID'],
            'PAYHERE_BUISNESS_APP_CODE' => $input['PAYHERE_BUISNESS_APP_CODE'],
            'PAYHERE_APP_SECRET' => $input['PAYHERE_APP_SECRET'],
            'PAYHERE_MODE' => $input['PAYHERE_MODE'],
            'IYZIPAY_BASE_URL' => $input['IYZIPAY_BASE_URL'],
            'IYZIPAY_API_KEY' => $input['IYZIPAY_API_KEY'],
            'IYZIPAY_SECRET_KEY' => $input['IYZIPAY_SECRET_KEY'],
            'IM_REFUND_URL' => $input['IM_REFUND_URL'],
            'API_DOMAIN_URL' => $input['API_DOMAIN_URL'], 
            'STORE_ID' => $input['STORE_ID'], 
            'STORE_PASSWORD' => $input['STORE_PASSWORD'],
            'IS_LOCALHOST' => isset($request->IS_LOCALHOST) ? 'true' : 'false',
            'YOUTUBE_API_KEY' => $input['YOUTUBE_API_KEY'],
            'VIMEO_CLIENT' => $input['VIMEO_CLIENT'], 
            'VIMEO_SECRET' => $input['VIMEO_SECRET'], 
            'VIMEO_ACCESS' => $input['VIMEO_ACCESS'],
            'AAMARPAY_SANDBOX' => isset($request->AAMARPAY_SANDBOX) ? "true" : "false",
            'GOOGLE_TAG_MANAGER_ENABLED' => isset($request->GOOGLE_TAG_MANAGER_ENABLED) ? "true" : "false",


            'AAMARPAY_STORE_ID' => $request->AAMARPAY_STORE_ID,
            'AAMARPAY_KEY' => $request->AAMARPAY_KEY,
            'AAMARPAY_SANDBOX' => '',
            'BRAINTREE_ENV' => $request->BRAINTREE_ENV,
            'BRAINTREE_MERCHANT_ID' => $request->BRAINTREE_MERCHANT_ID,
            'BRAINTREE_PUBLIC_KEY' => $request->BRAINTREE_PUBLIC_KEY,
            'BRAINTREE_PRIVATE_KEY' => $request->BRAINTREE_PRIVATE_KEY,
            'GOOGLE_TAG_MANAGER_ID' => $request->GOOGLE_TAG_MANAGER_ID,
            'GOOGLE_TAG_MANAGER_ENABLED' => $request->GOOGLE_TAG_MANAGER_ENABLED,
            'PAYFLEXI_PUBLIC_KEY' => $request->PAYFLEXI_PUBLIC_KEY,
            'PAYFLEXI_SECRET_KEY' => $request->PAYFLEXI_SECRET_KEY,
            'PAYFLEXI_PAYMENT_GATEWAY' => $request->PAYFLEXI_PAYMENT_GATEWAY,
            'PAYFLEXI_MODE' => $request->PAYFLEXI_MODE,
            'ESEWA_MERCHANT_ID' => $request->ESEWA_MERCHANT_ID,
            'ESEWA_MODE' => $request->ESEWA_MODE,
            'SMANAGER_CLIENT_ID' => $request->SMANAGER_CLIENT_ID,
            'SMANAGER_CLIENT_SECRET' => $request->SMANAGER_CLIENT_SECRET,
            'SMANAGER_URL' => $request->SMANAGER_URL,
            'ENABLE_PAYTAB' => isset($request->ENABLE_PAYTAB) ? 1 : 0,
            'PAYTAB_PROFILE_ID' => $request->PAYTAB_PROFILE_ID,
            'PAYTAB_SERVER_KEY' => $request->PAYTAB_SERVER_KEY,
            'ENABLE_DPOPAYMENT' => isset($request->ENABLE_DPOPAYMENT) ? 1 : 0,
            'SERVICE_TYPE' => strip_tags($request->SERVICE_TYPE),
            'COMPANY_TOKEN' => strip_tags($request->COMPANY_TOKEN),
            'DPO_SANDBOX' => isset($request->DPO_SANDBOX) ? 1 : 0,
            'API_LOGIN_ID' => $request['API_LOGIN_ID'], 
            'TRANSCATION_KEY' => $request['TRANSCATION_KEY'],
            'AUTHORIZE_NET_MODE' => isset($request->AUTHORIZE_NET_MODE) ? "sandbox" : "live",
            'AUTHORIZE_NET_ENABLE' => isset($request->AUTHORIZE_NET_ENABLE) ? 1 : 0,
            'BKASH_APP_KEY' => strip_tags($request->BKASH_APP_KEY),
            'BKASH_APP_SECRET' => strip_tags($request->BKASH_APP_SECRET),
            'BKASH_USER_NAME' => strip_tags($request->BKASH_USER_NAME),
            'BKASH_PASSWORD' => strip_tags($request->BKASH_PASSWORD),
            'ENABLE_BKASH' => isset($request->ENABLE_BKASH) ? 1 : 0,
            'BKASH_SANDBOX_MODE' => isset($request->BKASH_SANDBOX_MODE) ? 1 : 0,
            'MID_TRANS_CLIENT_KEY' => $request['MID_TRANS_CLIENT_KEY'],
            'MID_TRANS_SERVER_KEY' => $request['MID_TRANS_SERVER_KEY'],
            'MID_TRANS_MODE' => $request->MID_TRANS_MODE ? 'live' : 'sandbox',
            'MID_TRANS_ENABLE' => $request->MID_TRANS_ENABLE ? 1 : 0,
            'SQUARE_PAY_ENABLE' => $request->SQUARE_PAY_ENABLE ? 1 : 0,
            'SQUARE_PAY_LOCATION_ID' => $request->SQUARE_PAY_LOCATION_ID,
            'SQUARE_ACCESS_TOKEN' => $request->SQUARE_ACCESS_TOKEN,
            'SQUARE_APPLICATION_ID' => $request->SQUARE_APPLICATION_ID,
            'WORLDPAY_CLIENT_KEY' => $request['WORLDPAY_CLIENT_KEY'], 
            'WORLDPAY_SECRET_KEY' => $request['WORLDPAY_SECRET_KEY'],
            'WORLDPAY_ENABLE' => $request->WORLDPAY_ENABLE ? 1 : 0,
            'RAVE_SECRET_HASH' => $request['RAVE_SECRET_HASH'],
            'WASABI_KEY' => $input['WASABI_KEY'],
            'WASABI_SECRET' => $input['WASABI_SECRET'],
            'WASABI_BUCKET' => $input['WASABI_BUCKET'],
            'WASABI_REGION' => $input['WASABI_REGION'],
            'BUNNY_REGION' => $input['BUNNY_REGION'],
            'BUNNYCDN_STORAGE_ZONE_NAME' => $input['BUNNYCDN_STORAGE_ZONE_NAME'],
            'BUNNYCDN_API_KEY' => $input['BUNNYCDN_API_KEY'],
            'BUNNYCDN_PULL_ZONE' => $input['BUNNYCDN_PULL_ZONE'],
           

        ]);

        $addenv_keys->save();

      
        
        if(Module::has('Esewa') && Module::find('Esewa')->isEnabled())
        {

            if (isset($request->esewa_check)) {
                $setting->esewa_enable = "1";
            } else {
                $setting->esewa_enable = "0";
            }
        }

        if(Module::has('Smanager') && Module::find('Smanager')->isEnabled())
        {

            if (isset($request->smanager_check)) {
                $setting->smanager_enable = "1";
            } else {
                $setting->smanager_enable = "0";
            }
        }



        if (isset($request->payflexi_check)) {
            $setting->payflexi_enable = "1";
        } else {
            $setting->payflexi_enable = "0";
        }


        if (isset($request->aamarpay_enable)) {
            $setting->aamarpay_enable = "1";
        } else {
            $setting->aamarpay_enable = "0";
        }


        if (isset($request->youtube_enable)) {
            $setting->youtube_enable = "1";
        } else {
            $setting->youtube_enable = "0";
        }

        if (isset($request->vimeo_enable)) {
            $setting->vimeo_enable = "1";
        } else {
            $setting->vimeo_enable = "0";
        }


        if (isset($request->ssl_enable)) {
            $setting->ssl_enable = "1";
        } else {
            $setting->ssl_enable = "0";
        }


        if (isset($request->iyzico_enable)) {
            $setting->iyzico_enable = "1";
        } else {
            $setting->iyzico_enable = "0";
        }


        if (isset($request->enable_payhere)) {
            $setting->enable_payhere = "1";
        } else {
            $setting->enable_payhere = "0";
        }

        if (isset($request->enable_omise)) {
            $setting->enable_omise = "1";
        } else {
            $setting->enable_omise = "0";
        }

        if (isset($request->enable_payu)) {
            $setting->enable_payu = 1;
        } else {
            $setting->enable_payu = 0;
        }

        if (isset($request->enable_moli)) {
            $setting->enable_moli = 1;
        } else {
            $setting->enable_moli = 0;
        }

        if (isset($request->enable_skrill)) {
            $setting->enable_skrill = 1;
        } else {
            $setting->enable_skrill = 0;
        }

        if (isset($request->enable_cashfree)) {
            $setting->enable_cashfree = 1;
        } else {
            $setting->enable_cashfree = 0;
        }

        if (isset($request->enable_rave)) {
            $setting->enable_rave = "1";
        } else {
            $setting->enable_rave = "0";
        }

        if (isset($request->stripe_check)) {
            $setting->stripe_enable = "1";
        } else {
            $setting->stripe_enable = "0";
        }

        if (isset($request->paypal_check)) {
            $setting->paypal_enable = "1";
        } else {
            $setting->paypal_enable = "0";
        }

        if (isset($request->instamojo_check)) {
            $setting->instamojo_enable = "1";
        } else {
            $setting->instamojo_enable = "0";
        }

        if (isset($request->braintree_check)) {
            $setting->braintree_enable = "1";
        } else {
            $setting->braintree_enable = "0";
        }

        if (isset($request->razor_check)) {
            $setting->razorpay_enable = "1";
        } else {
            $setting->razorpay_enable = "0";
        }

        if (isset($request->paystack_check)) {
            $setting->paystack_enable = "1";
        } else {
            $setting->paystack_enable = "0";
        }

        if (isset($request->paytm_check)) {
            $setting->paytm_enable = "1";
        } else {
            $setting->paytm_enable = "0";
        }

        if (isset($request->captcha_check)) {
            $setting->captcha_enable = "1";
        } else {
            $setting->captcha_enable = "0";
        }

        if (isset($request->aws_check)) {
            $setting->aws_enable = "1";
        } else {
            $setting->aws_enable = "0";
        }
        if (isset($request->wasabi_check)) {
            $setting->wasabi_enable = "1";
        } else {
            $setting->wasabi_enable = "0";
        }
        if (isset($request->bunny_check)) {
            $setting->bunny_enable = "1";
        } else {
            $setting->bunny_enable = "0";
        }
        $setting->save();

        if ($addenv_keys) {
            return back()->with('success', trans('flash.settingssaved'));
        } else {
            return back()->with('delete', trans('flash.settingsnotsaved'));
        }
    }


    


}
