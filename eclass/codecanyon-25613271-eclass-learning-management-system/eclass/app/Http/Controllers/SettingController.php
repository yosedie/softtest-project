<?php

namespace App\Http\Controllers;

use App\Setting;
use Auth;
use Image;
use DotenvEditor;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request as IlluminateRequest;
use App\Themenew;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:settings.manage', ['only' => ['genreal','store','extraupdate','updateMailSetting','updateSeo','storeCSS','storeJS','slfb','slgl','slgit','slamazon','sllinkedin','sltwitter']]);
        $this->middleware('permission:login-signup.manage', ['only' => ['login', 'loginupdate']]);    
    }
    public function genreal()
    {
        $env_files = [
            'APP_URL' => env('APP_URL'),
            'APP_DEBUG' => env('APP_DEBUG'),
            'MAIL_FROM_NAME' => env('MAIL_FROM_NAME'),
            'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
            'MAIL_DRIVER' => env('MAIL_DRIVER'),
            'MAIL_HOST' => env('MAIL_HOST'),
            'MAIL_PORT' => env('MAIL_PORT'),
            'MAIL_USERNAME' => env('MAIL_USERNAME'),
            'MAIL_PASSWORD' => env('MAIL_PASSWORD'),
            'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION'),
            'FACEBOOK_CLIENT_ID' => env('FACEBOOK_CLIENT_ID'),
            'FACEBOOK_CLIENT_SECRET' => env('FACEBOOK_CLIENT_SECRET'),
            'FACEBOOK_CALLBACK_URL' => env('FACEBOOK_CALLBACK_URL'),
            'GOOGLE_CLIENT_ID' => env('GOOGLE_CLIENT_ID'),
            'GOOGLE_CLIENT_SECRET' => env('GOOGLE_CLIENT_SECRET'),
            'GOOGLE_CALLBACK_URL' => env('GOOGLE_CALLBACK_URL'),
            'GITLAB_CLIENT_ID' => env('GITLAB_CLIENT_ID'),
            'GITLAB_CLIENT_SECRET' => env('GITLAB_CLIENT_SECRET'),
            'GITLAB_CALLBACK_URL' => env('GITLAB_CALLBACK_URL'),
            'AMAZON_LOGIN_ID' => env('AMAZON_LOGIN_ID'),
            'AMAZON_LOGIN_SECRET' => env('AMAZON_LOGIN_SECRET'),
            'AMAZON_LOGIN_REDIRECT' => env('AMAZON_LOGIN_REDIRECT'),
            'LINKEDIN_CLIENT_ID' => env('LINKEDIN_CLIENT_ID'),
            'LINKEDIN_CLIENT_SECRET' => env('LINKEDIN_CLIENT_SECRET'),
            'LINKEDIN_CALLBACK_URL' => env('LINKEDIN_CALLBACK_URL'),
            'TWITTER_CLIENT_ID' => env('TWITTER_CLIENT_ID'),
            'TWITTER_CLIENT_SECRET' => env('TWITTER_CLIENT_SECRET'),
            'TWITTER_CALLBACK_URL' => env('TWITTER_CALLBACK_URL'),

        ];
        $setting = Setting::first();
        $css = @file_get_contents("css/custom-style.css");
        $js = @file_get_contents("js/custom-js.js");
        return view('admin.setting.setting', compact('css', 'js', 'setting', 'env_files'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_title' => 'required',
            'APP_URL' => 'required',
        ],
            [
                'project_title.required' => 'Project Title is required',
                'APP_URL.required' => 'App URL is required',
            ]
        );

        $active = @file_get_contents(public_path() . '/config.txt');

        if (!$active) {
            $putS = 1;
            @file_put_contents(public_path() . '/config.txt', $putS);
        }

        $d = \Request::getHost();
        $domain = str_replace("www.", "", $d);

		return $this->extraupdate($request);
    }

    public function extraupdate($request)
    {
        
        if (config('app.demolock') == 1) {
            return back()->with('delete', 'Disabled in demo');
        }

        $setting = Setting::first();

        if (config('app.demolock') == 0) {
            $setting->project_title = $request->project_title;
        }

        $setting->rightclick = $request->rightclick;
        $setting->inspect = $request->inspect;
        $setting->cpy_txt = $request->cpy_txt;
        $setting->wel_email = $request->wel_email;
        $setting->default_address = $request->default_address;
        $setting->default_phone = $request->default_phone;
        $setting->feature_amount = $request->feature_amount;
        $setting->map_url = $request->map_url;
        // $setting->map_long = $request->map_long;
        $setting->promo_text = $request->promo_text;
        $setting->promo_link = $request->promo_link;
        $setting->map_api = $request->map_api;
        $setting->chat_bubble = $request->chat_bubble;
        $setting->app_link = $request->app_link;
        $setting->play_link = $request->play_link;
        $setting->donation_link = $request->donation_link;
        $setting->category_enable = $request->category_enable ? 1 : 0;
        $setting->watch_enable = $request->watch_enable ? 1 : 0;
        $setting->watch_time = $request->watch_time;
        $setting->api_enable = $request->api_enable ? 1 : 0;
        $setting->screenshot_enable = $request->screenshot_enable ? 1 : 0;
        $setting->instagram_url = $request->instagram_url;
        $setting->facebook_url = $request->facebook_url;
        $setting->youtube_url = $request->youtube_url;
        $setting->twitter_url = $request->twitter_url;

        $twilio_sid = env('TWILIO_SID');
        $twilio_auth_token = env('TWILIO_AUTH_TOKEN');
        $twilio_number = env('TWILIO_NUMBER');
        // Check if Twilio credentials are present and OTP enable checkbox is checked
        $otpEnabled = $request->otp_enable && $twilio_sid && $twilio_auth_token && $twilio_number;
        // Update setting based on OTP enable condition
        $setting->otp_enable = $otpEnabled ? '1' : '0';
        // Check if Twilio credentials are missing and OTP enable checkbox is checked
        if ($request->otp_enable && (!$twilio_sid || !$twilio_auth_token || !$twilio_number)) {
            return redirect('/twilio/settings');
        }
        $setting->api_key = encrypt($request->api_key);

        $env_update = DotenvEditor::setKeys([

            'APP_NAME' => $request->project_title,
            'APP_URL' => $request->APP_URL,
            'PRICE_DISPLAY_FORMAT' => $request->PRICE_DISPLAY_FORMAT ? 'comma' : 'decimal',

        ]);

        $env_update->save();

        if (isset($request->APP_DEBUG)) {

            DotenvEditor::setKey('APP_DEBUG', 'true')->save();

        } else {

            DotenvEditor::setKey('APP_DEBUG', 'false')->save();

        }

        if (config('app.demolock') == 0) {

            if (Auth::user()->role == 'admin') {
                if ($request->logo != null) {

                    $setting->logo = $request->logo;

                } else {
                    $setting->logo = $setting->logo;
                }

                if ($request->preloader_logo != null) {

                    $setting->preloader_logo = $request->preloader_logo;

                } else {
                    $setting->preloader_logo = $setting->preloader_logo;
                }

                if ($request->favicon != null) {

                    $setting->favicon = $request->favicon;

                } else {
                    $setting->favicon = $setting->favicon;
                }

                if ($request->footer_logo != null) {

                    $setting->footer_logo = $request->footer_logo;

                } else {
                    $setting->footer_logo = $setting->footer_logo;
                }
            }

            if ($file = $request->file('logo')) {
                $name = 'logo' . uniqid() . '.' . $file->getClientOriginalExtension();

                if ($setting->logo != "") {
                    $content = @file_get_contents(public_path() . '/images/logo/' . $setting->logo);

                    if ($content) {
                        unlink(public_path() . '/images/logo/' . $setting->logo);
                    }
                }

                $file->move('images/logo', $name);
                $setting->logo = $name;
            }

            if ($file = $request->file('preloader_logo')) {

                $name = 'preloader_logo' . uniqid() . '.' . $file->getClientOriginalExtension();

                if ($setting->logo != null) {
                    $content = @file_get_contents(public_path() . '/images/logo/' . $setting->preloader_logo);
                    if ($content) {
                        unlink(public_path() . '/images/logo/' . $setting->preloader_logo);
                    }
                }
                $file->move('images/logo', $name);
                $setting->preloader_logo = $name;

            }

            if ($file = $request->file('footer_logo')) {

                $name = 'footer_logo' . uniqid() . '.' . $file->getClientOriginalExtension();

                if ($setting->logo != null) {
                    $content = @file_get_contents(public_path() . '/images/logo/' . $setting->footer_logo);
                    if ($content) {
                        unlink(public_path() . '/images/logo/' . $setting->footer_logo);
                    }
                }
                $file->move('images/logo', $name);
                $setting->footer_logo = $name;

                $setting->logo_type = 'L';
            }

            if ($file = $request->file('favicon')) {
                $name = 'favicon' . uniqid() . '.' . $file->getClientOriginalExtension();

                if ($setting->favicon != null) {
                    $content = @file_get_contents(public_path() . '/images/favicon/' . $setting->favicon);
                    if ($content) {
                        unlink(public_path() . '/images/favicon/' . $setting->favicon);
                    }
                }
                $file->move('images/favicon', $name);
                $setting->favicon = $name;

            }

        }

        if ($file = $request->file('contact_image')) {
            $name = 'contact.png';
            if ($setting->contact_image != null) {
                $content = @file_get_contents(public_path() . '/images/contact/' . $setting->contact_image);
                if ($content) {
                    unlink(public_path() . '/images/contact/' . $setting->contact_image);
                }
            }
            $file->move('images/contact', $name);
            $setting['contact_image'] = $name;
            $setting->update([
                'contact_image' => $setting['contact_image'],
            ]);
        }

        $setting->donation_enable = isset($request->donation_enable) ? 1 : 0;
        $setting->guest_enable = isset($request->guest_enable) ? 1 : 0;

        if (isset($request->jitsimeet_enable)) {
            $setting->jitsimeet_enable = 1;
        } else {
            $setting->jitsimeet_enable = 0;
        }

        if (isset($request->cookie_enable)) {
            $setting->cookie_enable = 1;
        } else {
            $setting->cookie_enable = 0;
        }

        if (isset($request->googlemeet_enable)) {
            $setting->googlemeet_enable = 1;
        } else {
            $setting->googlemeet_enable = 0;
        }

        if (isset($request->activity_enable)) {
            $setting->activity_enable = 1;
        } else {
            $setting->activity_enable = 0;
        }

        if (isset($request->attandance_enable)) {
            $setting->attandance_enable = 1;
        } else {
            $setting->attandance_enable = 0;
        }

        if (isset($request->currency_swipe)) {
            $setting->currency_swipe = 1;
        } else {
            $setting->currency_swipe = 0;
        }

        if (isset($request->app_download)) {
            $setting->app_download = 1;
        } else {
            $setting->app_download = 0;
        }

        if (isset($request->play_download)) {
            $setting->play_download = 1;
        } else {
            $setting->play_download = 0;
        }

        if (isset($request->project_logo)) {
            $setting->logo_type = 'L';
        } else {
            $setting->logo_type = 'T';
        }

        if (isset($request->rightclick)) {
            $setting->rightclick = 0;
        } else {
            $setting->rightclick = 1;
        }

        if (isset($request->inspect)) {
            $setting->inspect = 0;
        } else {
            $setting->inspect = 1;
        }

        if (isset($request->w_email_enable)) {
            if (env('MAIL_USERNAME') != null) {
                $setting->w_email_enable = '1';
            } else {
                return back()->with('delete', trans('flash.UpdateMail'));
            }
        } else {
            $setting->w_email_enable = '0';
        }

        if (isset($request->verify_enable)) {
            if (env('MAIL_USERNAME') != null) {
                $setting->verify_enable = '1';
            } else {
                return back()->with('delete', trans('flash.UpdateMail'));
            }
        } else {
            $setting->verify_enable = '0';
        }

        if (isset($request->instructor_enable)) {
            $setting->instructor_enable = '1';
        } else {
            $setting->instructor_enable = '0';
        }

        if (isset($request->cat_enable)) {
            $setting->cat_enable = '1';
        } else {
            $setting->cat_enable = '0';
        }

        if (isset($request->preloader_enable)) {
            $setting->preloader_enable = '1';
        } else {
            $setting->preloader_enable = '0';
        }

        if (isset($request->zoom_enable)) {
            $setting->zoom_enable = 1;
        } else {
            $setting->zoom_enable = 0;
        }

        if (isset($request->bbl_enable)) {
            $setting->bbl_enable = 1;
        } else {
            $setting->bbl_enable = 0;
        }

        if (isset($request->mobile_enable)) {
            $setting->mobile_enable = 1;
        } else {
            $setting->mobile_enable = 0;
        }

        if (isset($request->map_enable)) {
            $setting->map_enable = 'map';
        } else {
            $setting->map_enable = 'image';
        }

        if (isset($request->promo_enable)) {
            $setting->promo_enable = 1;
        } else {
            $setting->promo_enable = 0;
        }

        if (isset($request->certificate_enable)) {
            $setting->certificate_enable = 1;
        } else {
            $setting->certificate_enable = 0;
        }

        if (isset($request->device_enable)) {
            $setting->device_control = 1;
        } else {
            $setting->device_control = 0;
        }

        if (isset($request->ipblock_enable)) {
            $setting->ipblock_enable = 1;
        } else {
            $setting->ipblock_enable = 0;
        }

        if (isset($request->assignment_enable)) {
            $setting->assignment_enable = 1;
        } else {
            $setting->assignment_enable = 0;
        }

        if (isset($request->appointment_enable)) {
            $setting->appointment_enable = 1;
        } else {
            $setting->appointment_enable = 0;
        }

        if (isset($request->hide_identity)) {
            $setting->hide_identity = 1;
        } else {
            $setting->hide_identity = 0;
        }

        if (isset($request->course_hover)) {
            $setting->course_hover = 1;
        } else {
            $setting->course_hover = 0;
        }
        $setting->save();
        return redirect()->route('gen.set')->with('success', trans('UpdatedSuccessfully'));
    }

    public function updateMailSetting(Request $request)
    {

        $input = $request->all();
        $setting = Setting::first();

        if (config('app.demolock') == 0) {

            $env_update = DotenvEditor::setKeys([

                'APP_NAME' => $request->APP_NAME,
                'APP_URL' => $request->APP_URL,
                'MAIL_FROM_NAME' => $request->MAIL_FROM_NAME,
                'MAIL_FROM_ADDRESS' => $request->MAIL_FROM_ADDRESS,
                'MAIL_DRIVER' => $request->MAIL_DRIVER,
                'MAIL_HOST' => $request->MAIL_HOST,
                'MAIL_PORT' => $request->MAIL_PORT,
                'MAIL_USERNAME' => $request->MAIL_USERNAME,
                'MAIL_PASSWORD' => $request->MAIL_PASSWORD,
                'MAIL_ENCRYPTION' => $request->MAIL_ENCRYPTION,

            ]);

            $env_update->save();

            if ($env_update) {
                return back()->with('updated', trans('flash.settingssaved'));
            } else {
                return back()->with('deleted', trans('flash.settingsnotsaved'));
            }

        } else {
            return back()->with('delete', 'You can\'t update in Demo');
        }
    }

    public function updateSeo(Request $request)
    {

        $setting = Setting::first();
        $setting->meta_data_desc = $request->meta_data_desc;
        $setting->meta_data_keyword = $request->meta_data_keyword;
        $setting->google_ana = $request->google_ana;
        $setting->fb_pixel = $request->fb_pixel;
        $setting->google_search_console = $request->google_search_console;
        $setting->save();
        return redirect()->route('gen.set')->with('success', trans('UpdatedSuccessfully'));
    }

    public function storeCSS(Request $request)
    {

        $css = $request->css;
        file_put_contents("css/custom-style.css", $css . PHP_EOL);
        return redirect()->route('gen.set')->with('success', trans('UpdatedSuccessfully'));
    }

    public function storeJS(Request $request)
    {

        $js = $request->js;
        file_put_contents("js/custom-js.js", $js . PHP_EOL);
        return redirect()->route('gen.set')->with('success', trans('UpdatedSuccessfully'));
    }

    public function slfb(Request $request)
    {
        $setting = Setting::first();

        if (isset($request->fb_enable)) {
            $setting->fb_login_enable = "1";
        } else {
            $setting->fb_login_enable = "0";
        }

        $env_update = DotenvEditor::setKeys([

            'FACEBOOK_CLIENT_ID' => $request->FACEBOOK_CLIENT_ID,
            'FACEBOOK_CLIENT_SECRET' => $request->FACEBOOK_CLIENT_SECRET,
            'FACEBOOK_CALLBACK_URL' => $request->FACEBOOK_CALLBACK_URL,

        ]);

        $env_update->save();

        $setting->save();

        return redirect()->route('gen.set')->with('success', trans('UpdatedSuccessfully'));
    }

    public function slgl(Request $request)
    {
        $setting = Setting::first();

        if (isset($request->google_enable)) {
            $setting->google_login_enable = "1";
        } else {
            $setting->google_login_enable = "0";
        }

        $env_update = DotenvEditor::setKeys([

            'GOOGLE_CLIENT_ID' => $request->GOOGLE_CLIENT_ID,
            'GOOGLE_CLIENT_SECRET' => $request->GOOGLE_CLIENT_SECRET,
            'GOOGLE_CALLBACK_URL' => $request->GOOGLE_CALLBACK_URL,

        ]);

        $env_update->save();

        $setting->save();

        return redirect()->route('gen.set')->with('success', trans('UpdatedSuccessfully'));
    }

    public function slgit(Request $request)
    {
        $setting = Setting::first();

        if (isset($request->gitlab_enable)) {
            $setting->gitlab_login_enable = "1";
        } else {
            $setting->gitlab_login_enable = "0";
        }

        $env_update = DotenvEditor::setKeys([

            'GITLAB_CLIENT_ID' => $request->GITLAB_CLIENT_ID,
            'GITLAB_CLIENT_SECRET' => $request->GITLAB_CLIENT_SECRET,
            'GITLAB_CALLBACK_URL' => $request->GITLAB_CALLBACK_URL,

        ]);

        $env_update->save();

        $setting->save();

        return redirect()->route('gen.set')->with('success', trans('UpdatedSuccessfully'));
    }

    public function slamazon(Request $request)
    {
        $setting = Setting::first();

        if (isset($request->amazon_enable)) {
            $setting->amazon_enable = "1";
        } else {
            $setting->amazon_enable = "0";
        }

        $env_update = DotenvEditor::setKeys([

            'AMAZON_LOGIN_ID' => $request->AMAZON_LOGIN_ID,
            'AMAZON_LOGIN_SECRET' => $request->AMAZON_LOGIN_SECRET,
            'AMAZON_LOGIN_REDIRECT' => $request->AMAZON_LOGIN_REDIRECT,

        ]);

        $env_update->save();

        $setting->save();

        return redirect()->route('gen.set')->with('success', trans('UpdatedSuccessfully'));
    }

    public function sllinkedin(Request $request)
    {
        $setting = Setting::first();

        if (isset($request->linkedin_enable)) {
            $setting->linkedin_enable = "1";
        } else {
            $setting->linkedin_enable = "0";
        }

        $env_update = DotenvEditor::setKeys([

            'LINKEDIN_CLIENT_ID' => $request->LINKEDIN_CLIENT_ID,
            'LINKEDIN_CLIENT_SECRET' => $request->LINKEDIN_CLIENT_SECRET,
            'LINKEDIN_CALLBACK_URL' => $request->LINKEDIN_CALLBACK_URL,

        ]);

        $env_update->save();

        $setting->save();

        return redirect()->route('gen.set')->with('success', trans('UpdatedSuccessfully'));
    }

    public function sltwitter(Request $request)
    {
        $setting = Setting::first();

        if (isset($request->twitter_enable)) {
            $setting->twitter_enable = "1";
        } else {
            $setting->twitter_enable = "0";
        }

        $env_update = DotenvEditor::setKeys([

            'TWITTER_CLIENT_ID' => $request->TWITTER_CLIENT_ID,
            'TWITTER_CLIENT_SECRET' => $request->TWITTER_CLIENT_SECRET,
            'TWITTER_CALLBACK_URL' => $request->TWITTER_CALLBACK_URL,

        ]);

        $env_update->save();

        $setting->save();

        return redirect()->route('gen.set')->with('success', trans('UpdatedSuccessfully'));
    }

    public function login()
    {
       $setting = Setting::first();
        return view('admin.setting.login',compact('setting'));
    }

    public function loginupdate(Request $request)
    {
        $login = Setting::all();
        try {

            $login = Setting::first();
            $input = array_filter($request->all());
            if ($login) {
                $input['text'] = strip_tags($request->text);

                if ($file = $request->file('img')) {
            
                  if($login->img != null) {
                    $content = @file_get_contents(public_path().'/images/login/'.$login->img);
                    if ($content) {
                      unlink(public_path().'/images/login/'.$login->img);
                    }
                  }
      
                  $optimizeImage = Image::make($file);
                  $optimizePath = public_path().'/images/login/';
                  $image = time().$file->getClientOriginalName();
                  $optimizeImage->save($optimizePath.$image, 72);
              

                  $input['img'] = $image;
                  
                }
                $login->update($input);

            } else {

                $login = new Setting;

                $login['text'] = strip_tags($request->text);
                if($file = $request->file('img')) 
          {        
            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/images/login/';
            $image = time().$file->getClientOriginalName();
            $optimizeImage->save($optimizePath.$image, 72);

            $input['img'] = $image;
            
          }
                $login->create($input);
            }
            return redirect()->route('settings.login')->with('success', trans('UpdatedSuccessfully'));

        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }
    public function adminsetting(Request $request)
    {
    
        try {

            $asetting = Setting::first();
            // $input = array_filter($request->all());
            if ($asetting) {
                $asetting->sidebar_enable = isset($request->sidebar_enable) ? 1 : 0;
                $asetting->instructor_sidebar = isset($request->instructor_sidebar) ? 1 : 0;
                $asetting->save();

            } else {

                $asetting = new Setting;
                $asetting->sidebar_enable = isset($request->sidebar_enable) ? 1 : 0;
                $asetting->instructor_sidebar = isset($request->instructor_sidebar) ? 1 : 0;
                $asetting->save();
            }
            return redirect()->route('gen.set')->with('success', trans('UpdatedSuccessfully'));

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function index()
    {
        $setting = Setting::first();
        return view("admin.themenew.setting",compact("setting"));
    }
 
    public function update(Request $request)
    {
        if (config('app.demolock') == 1) {
            return back()->with('delete', 'Disabled in demo');
        }

        try {

            $setting = Setting::first();
             $input = array_filter($request->all());
            if ($setting) {
                $setting->theme = $request->theme;
                $setting->save();

            } else {

                $setting = new Setting;
                $setting->theme = $request->theme;
                $setting->save();
            }
            return redirect()->route('themenew.index')->with('success', trans('UpdatedSuccessfully'));

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function sendEmail(Request $request)
{
    
    $testEmail = $request->input('sender_email');
    Mail::to($testEmail)->send(new TestMail());
    return back()->with('success', 'Email sent successfully.');
}
}
