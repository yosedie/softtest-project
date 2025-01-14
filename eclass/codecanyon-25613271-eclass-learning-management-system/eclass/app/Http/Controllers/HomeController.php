<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use App\Slider;
use App\SliderFacts;
use App\CategorySlider;
use App\Course;
use App\Meeting;
use Illuminate\Support\Facades\Redirect;
use App\BBL;
use App\BundleCourse;
use App\Testimonial;
use App\Trusted;
use App\Order;
use Auth;
use Session;
use App\Blog;
use App\Batch;
use Illuminate\Support\Facades\Schema;
use App\Setting;
use App\Advertisement;
use App\Dropdown;
use App\Googlemeet;
use App\JitsiMeeting;
use App\User;
use App\Page;
use Illuminate\Support\Facades\Cookie;
use Response;
use Config;
use App\Facts;
use DB;
use App\Institute;
use Module;
use App\Videosetting;
use Modules\Googleclassroom\Models\Googleclassroom;
use Spatie\Newsletter\Newsletter;
use App\Menu;
use App\FeatureCourse;
use App\Features;
use App\Featuresetting;
use App\GetStarted;
use Illuminate\Support\Facades\Mail;
use App\MobileSetting;
use App\Services;
use App\Servicesetting;
use App\Downloadqr;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use MailchimpMarketing\ApiClient;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware(['auth','verified']);
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     //old code
     private $mailchimp;

    public function __construct()
    {
        $this->mailchimp = new ApiClient();
        $this->mailchimp->setConfig([
            'apiKey' => env('MAILCHIMP_API_KEY'),
            'server' => env('MAILCHIMP_SERVER_PREFIX')
        ]);
    }
    public function index(Request $request)
    {
        if (env('IS_INSTALLED') == 0) {
            return redirect('db');

        }
        $setting_info = Setting::first();
        // return $setting_info;
        if($setting_info->verify_status =='0' || $setting_info->verify_status=='' || $setting_info->verify_status=='null'){
            // Session::put('vrfy_error', '');
            return view('verify');
        } else {
        $category = Categories::where('status', '1')->orderBy('position','ASC')->with('subcategory')->get();
        $sliders = Slider::where('status', '1')->orderBy('position', 'ASC')->get();
        $facts = SliderFacts::limit(3)->get();
        $instructors = User::select('*')->where('role', 'instructor')->where('status', '1')->get();

        $shareComponent = \Share::page(
            'https://eclass.mediacity.co.in/'
            )
        ->facebook()
        ->twitter()
        ->linkedin()
        ->telegram()
        ->whatsapp();
        $instruct = FeatureCourse::get();
        $discountcourse = Course::where('type','1')->where('status',1)->whereNotNUll('discount_price')->with('user')->latest()->take(10)->get();
        $categorie_ids = CategorySlider::first();
        $factsetting = Facts::limit(4)->where('status', '1')->get();
        $videosetting = Videosetting::first();
        $bestselling = Order::whereNotNUll('course_id')->with('courses','courses.user')->latest()->take(10)->get();
        if(isset($categorie_ids))
        {
            $categories = Categories::whereHas('courses')
            ->whereIn('id',$categorie_ids->category_id)
            ->where('status','1')
            ->get();
        }
        else{
            $categories = NULL;
        }
        $meetings = Meeting::whereHas('user')->with('user')->get();
        $bigblue = BBL::where('is_ended','!=',1)->with('user')->get();
        $testi = Testimonial::where('status', '1')->get();
        $trusted = Trusted::where('status', '1')->get();
        $blogs = Blog::where('status', '1')->orderBy('updated_at','DESC')->with('user')->get();
        $institute = Institute::where('status','1')->orderBy('updated_at','DESC')->get();
        if(Schema::hasTable('googlemeets')){
            $allgooglemeet = Googlemeet::orderBy('id', 'DESC')->with('user')->with('user')->get();
        }
        else{
            
            $allgooglemeet = NULL;
        }

        if(Schema::hasTable('jitsimeetings')){
            $jitsimeeting = JitsiMeeting::orderBy('id', 'DESC')->with('user')->with('user')->get();
        }
        else{
            $jitsimeeting = NULL;
        }
        if (Schema::hasColumn('bundle_courses', 'is_subscription_enabled'))
        {
            $bundles = BundleCourse::where('is_subscription_enabled', 0)->with('user')->latest()->take(10)->get();
            $subscriptionBundles = BundleCourse::where('is_subscription_enabled', 1)->with('user')->latest()->take(10)->get();
        }
        else{

            $bundles = NULL;
            $subscriptionBundles = NULL;

        }

        if(Schema::hasTable('batch')){
            $batches = Batch::where('status', '1')->get();
        }
        else{
            $batches = NULL;
        }

        if(Schema::hasTable('advertisements')){
            $advs = Advertisement::where('status','=',1)->get();
        }
        else{
            $advs = NULL;
        }
        
        $viewed = session()->get('courses.recently_viewed');

        if(isset($viewed))
        {
            $recent_course_id = array_unique($viewed); 
        }
        else{

            $recent_course_id = NULL;

        }

        if(Schema::hasTable('googleclassrooms') && Module::has('Googleclassroom') && Module::find('Googleclassroom')->isEnabled())
        {
            $googleclassrooms = Googleclassroom::orderBy('id', 'DESC')->where('link_by', NULL)->where('status', '1')->get();
        }
        else{
            
            $googleclassrooms = NULL;
        }


        $counter = 0;
        $recent_course = NULL;

        if($recent_course_id != NULL)
        {
            $recent_course_id = array_splice($recent_course_id, 0);
        }
        else
        {
            $recent_course_id = NULL;
        }

        if(Auth::check())
        {
            if( isset($recent_course_id) )
            {
                $recent_course = Course::whereIn('id', $recent_course_id)->where('status', '1')->count();
            }

        }
        $total_count=$recent_course;
        $ipaddress = $request->getClientIp();
        
        $geoip = geoip()->getLocation($ipaddress);
        $usercountry = strtoupper($geoip->country);
        $cors = Course::where('status', '1')->where('featured', '1')->with('user')->latest()->take(10)->get()->map(function($c) use($usercountry) {
                    
                    if($c->country != ''){
                        if(!in_array($usercountry,$c->country)){
                            return $c;
                        }
                    }else{
                        return $c;
                    }
                
        })->filter();
        $get_enable = GetStarted::first();
        $menus = Menu::get();
        $pages = Page::get();
        $services = Services::where('status','1')->get();
        $servicesetting = Servicesetting::first();
        $featuresetting = Featuresetting::first();
        $feature = Features::where('status','1')->get();
        $mobile = MobileSetting::first();
        if($mobile->setting_enable =='1'){
            $sliders = Slider::where('status', '1')->orderBy('position', 'ASC')->get();
            $factsetting = Facts::limit(4)->where('status', '1')->get();
            $videosetting = Videosetting::first();
            $get_enable = GetStarted::first();
            $trusted = Trusted::where('status', '1')->get();
            $services = Services::where('status','1')->get();
            $feature = Features::where('status','1')->get();
            $testi = Testimonial::where('status', '1')->get();
            $facts = SliderFacts::limit(3)->get();
            $servicesetting = Servicesetting::first();
            $featuresetting = Featuresetting::first();
            $qr = Downloadqr::first();
            return view('front.landing' ,compact('sliders', 'factsetting', 'videosetting', 'get_enable', 'trusted', 'services', 'feature', 'testi', 'facts','servicesetting','featuresetting','qr'));
        }
        else{
            $setting = Setting::first();
            if($setting->theme == '1'){
            return view('home', compact('category', 'sliders', 'facts', 'categories', 'cors', 'bundles','shareComponent', 'meetings', 'bigblue', 'testi', 'trusted', 'recent_course_id', 'blogs', 'subscriptionBundles', 'batches', 'recent_course', 'total_count', 'advs', 'allgooglemeet','jitsimeeting', 'googleclassrooms', 'usercountry','instructors','factsetting','videosetting','discountcourse','bestselling','menus','pages','instruct','institute','get_enable','services','feature','servicesetting','featuresetting'));
            }
            return view('theme_2.front.home', compact('category', 'sliders', 'facts', 'categories', 'cors', 'bundles','shareComponent', 'meetings', 'bigblue', 'testi', 'trusted', 'recent_course_id', 'blogs', 'subscriptionBundles', 'batches', 'recent_course', 'total_count', 'advs', 'allgooglemeet','jitsimeeting', 'googleclassrooms', 'usercountry','instructors','factsetting','videosetting','discountcourse','bestselling','menus','pages','instruct','institute','get_enable','services','feature','servicesetting','featuresetting'));
        }
        }
    }


    //query down in laravel debugger 
    // public function index(Request $request)
    // {
    //     if (env('IS_INSTALLED') == 0) {
    //         return redirect('db');
    //     }

    //     $setting_info = DB::table('settings')->first();
    //     if ($setting_info->verify_status == '0' || $setting_info->verify_status == '' || $setting_info->verify_status == 'null') {
    //         return view('verify');
    //     }

    //     $category = Categories::where('status', '1')->orderBy('position', 'ASC')->with('subcategory')->get();
    //     $sliders = Slider::where('status', '1')->orderBy('position', 'ASC')->get();
    //     $facts = SliderFacts::limit(3)->get();
    //     $instructors = User::where('role', 'instructor')->where('status', '1')->get();

    //     $shareComponent = \Share::page('https://eclass.mediacity.co.in/')
    //         ->facebook()
    //         ->twitter()
    //         ->linkedin()
    //         ->telegram()
    //         ->whatsapp();

    //     $instruct = FeatureCourse::all();
    //     $discountcourse = Course::where('type', '1')->where('status', 1)->whereNotNull('discount_price')->with('user')->latest()->take(10)->get();
    //     $categorie_ids = CategorySlider::first();
    //     $factsetting = Facts::limit(4)->where('status', '1')->get();
    //     $videosetting = Videosetting::first();
    //     $bestselling = Order::whereNotNull('course_id')->with('courses.user')->latest()->take(10)->get();
    //     $categories = $categorie_ids ? Categories::whereHas('courses')->whereIn('id', $categorie_ids->category_id)->where('status', '1')->get() : null;
    //     $meetings = Meeting::whereNull('link_by')->with('user')->get();
    //     $bigblue = BBL::where('is_ended', '!=', 1)->whereNull('link_by')->with('user')->get();
    //     $testi = Testimonial::where('status', '1')->get();
    //     $trusted = Trusted::where('status', '1')->get();
    //     $blogs = Blog::where('status', '1')->orderBy('updated_at', 'DESC')->with('user')->get();
    //     $institute = Institute::where('status', '1')->orderBy('updated_at', 'DESC')->get();
    //     $allgooglemeet = Schema::hasTable('googlemeets') ? Googlemeet::orderBy('id', 'DESC')->whereNull('link_by')->with('user')->get() : null;
    //     $jitsimeeting = Schema::hasTable('jitsimeetings') ? JitsiMeeting::orderBy('id', 'DESC')->whereNull('link_by')->with('user')->get() : null;
    //     $bundles = Schema::hasColumn('bundle_courses', 'is_subscription_enabled') ? BundleCourse::where('is_subscription_enabled', 0)->with('user')->latest()->take(10)->get() : null;
    //     $subscriptionBundles = Schema::hasColumn('bundle_courses', 'is_subscription_enabled') ? BundleCourse::where('is_subscription_enabled', 1)->with('user')->latest()->take(10)->get() : null;
    //     $batches = Schema::hasTable('batch') ? Batch::where('status', '1')->get() : null;
    //     $advs = Schema::hasTable('advertisements') ? Advertisement::where('status', 1)->get() : null;
    //     $viewed = session()->get('courses.recently_viewed');
    //     $recent_course_id = isset($viewed) ? array_unique($viewed) : null;
    //     $googleclassrooms = (Schema::hasTable('googleclassrooms') && Module::has('Googleclassroom') && Module::find('Googleclassroom')->isEnabled()) ? Googleclassroom::orderBy('id', 'DESC')->whereNull('link_by')->where('status', '1')->get() : null;
    //     $recent_course = null;
    //     if ($recent_course_id && Auth::check()) {
    //         $recent_course = Course::whereIn('id', $recent_course_id)->where('status', '1')->count();
    //     }

    //     $total_count = $recent_course;
    //     $ipaddress = $request->getClientIp();
    //     $geoip = geoip()->getLocation($ipaddress);
    //     $usercountry = strtoupper($geoip->country);

    //     $cors = Course::where('status', '1')->where('featured', '1')->with('user')->latest()->take(10)->get()->filter(function ($c) use ($usercountry) {
    //         return empty($c->country) || in_array($usercountry, $c->country);
    //     });

    //     $get_enable = GetStarted::first();
    //     $menus = Menu::all();
    //     $pages = Page::all();
    //     $services = Services::where('status', '1')->get();
    //     $servicesetting = Servicesetting::first();
    //     $featuresetting = Featuresetting::first();
    //     $feature = Features::where('status', '1')->get();
    //     $mobile = MobileSetting::first();

    //     if ($mobile->setting_enable == '1') {
    //         $qr = Downloadqr::first();
    //         return view('front.landing', compact('sliders', 'factsetting', 'videosetting', 'get_enable', 'trusted', 'services', 'feature', 'testi', 'facts', 'servicesetting', 'featuresetting', 'qr'));
    //     } else {
    //         $setting = Setting::first();
    //         $view = $setting->theme == '1' ? 'home' : 'theme_2.front.home';
    //         return view($view, compact(
    //             'category', 'sliders', 'facts', 'categories', 'cors', 'bundles', 'shareComponent', 
    //             'meetings', 'bigblue', 'testi', 'trusted', 'recent_course_id', 'blogs', 
    //             'subscriptionBundles', 'batches', 'recent_course', 'total_count', 'advs', 
    //             'allgooglemeet', 'jitsimeeting', 'googleclassrooms', 'usercountry', 'instructors', 
    //             'factsetting', 'videosetting', 'discountcourse', 'bestselling', 'menus', 
    //             'pages', 'instruct', 'institute', 'get_enable', 'services', 'feature', 
    //             'servicesetting', 'featuresetting'
    //         ));
    //     }
    // }

    public function store(Request $request)
    {
        $request->validate([
            'subscribed_email' => 'required|email'
        ]);

        try {
            if ($this->isEmailSubscribed($request->subscribed_email)) {
                return back()->withErrors(['msg' => 'Email already subscribed']);
            }

            $this->subscribeEmail($request->subscribed_email);

            return back()->with('success', 'Email subscribed successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    private function isEmailSubscribed($email)
    {
        $listId = env('MAILCHIMP_LIST_ID');
        $subscriberHash = md5(strtolower($email));

        try {
            $response = $this->mailchimp->lists->getListMember($listId, $subscriberHash);
            return $response->status === 'subscribed';
        } catch (\Exception $e) {
            return false;
        }
    }

    private function subscribeEmail($email)
    {
        $listId = env('MAILCHIMP_LIST_ID');

        $this->mailchimp->lists->addListMember($listId, [
            'email_address' => $email,
            'status' => 'subscribed',
        ]);
    }
    public function instituteslug(Request $request, $slug){
        $institute = Institute::where('slug',$slug)->first();
        $course = Course::where('institude_id',$institute->id)->get();
        $setting = Setting::first();
        if($setting->theme == '1'){
            return view('front.institute.slug',compact('institute','course'));
        }
        return view('theme_2.front.institute.slug', compact('institute','course'));
    }
    public function verifycode(Request $request){
       
        $d = $request->domain;
        $domain = str_replace("www.", "", $d);   
        $alldata = ['app_id' => "25613271", 'ip' => "127.0.0.1", 'domain' => $domain , 'code' => $request->code];
       
         $response = Http::post('https://mediacity.co.in/purchase/public/api/verifycode', [
             'app_id' => '25613271',
             'ip' => '127.0.0.1',
             'code' => $alldata['code'],
             'domain' => $alldata['domain']
         ]);
 
         $result = $response->json();
         if($response->successful()){
             if ($result['status'] == '1')
             {
             
                 $lic_json = array(
                 
                     'name'     => request()->user_id,
                     'code'     => $alldata['code'],
                     'type'     => __('envato'),
                     'domain'   => $alldata['domain'],
                     'lic_type' => __('regular'),
                     'token'    => $result['token']
                     
                 );
 
                 $file = json_encode($lic_json);
                 
                 $filename =  'license.json';
 
                 Storage::disk('local')->put('/keys/'.$filename,$file);
                 $setting = Setting::first();
                 $setting->verify_status = '1';
                 $setting->verify_message = $result['message'];
         
                 $setting->save();
                 return redirect('/');
             
             }
             else
             {
                 $message = $result['message'];
                 $setting = Setting::first();
                 $setting->verify_status = '0';
                 $setting->verify_message = $result['message'];
         
                 $setting->save();
                 Session::flash('error', trans('flash.Failed to Validate'));
                 Session::put('vrfy_error', 'Failed to Validate');
                 return back();
             }
         }else
         {
             $message = "Failed to validate";
             Session::flash('error', trans('flash.Failed to Validate'));
             Session::put('vrfy_error', 'Failed to Validate');
             return back();
 
         }
     }
}
