<?php

use App\FaqStudent;
use App\FaqInstructor;
use App\User;
use App\Setting;
use App\CourseClass;
use App\Course;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AdminSupportController;
use App\Http\Controllers\SupportTypeController;
use App\Http\Controllers\DeleteAccountController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/currency/position',function(){
    $user = User::find(1);
    $user->assignRole('Admin');
    return 'x';
});
Route::get('/test','TestController@test');


Route::get('/phpinfo',function(){
    return phpinfo();
});

Route::get('/verify', function () {
    return view('auth.otp');
})->name('verify');
Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('sendOtp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verifyOtp');
Route::get('trans',function(){
    $result =  @file_get_contents(resource_path() .'/lang/en.json');
    $result = json_decode($result);
   
    $x = array();
    
    foreach($result as $key => $value){
       $x[$key] = $key;
    }
   
    @file_put_contents(resource_path() .'/lang/en.json',json_encode($x,JSON_PRETTY_PRINT));
   
    return 'done';
  });
 // Show the login form (GET request)
Route::get('/login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');

// Handle the login request (POST request)
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')->name('login.post');
Route::get('/registers', 'App\Http\Controllers\Auth\RegisterController@showRegisterForm')->name('register');

    Route::get('/clear-cache',function(){
    \Artisan::call('config:clear');
    \Artisan::call('cache:clear');
    \Artisan::call('view:cache');
    \Artisan::call('view:clear');
    Alert::success('Cache has been cleared !')->persistent('Close')->autoclose(6000);
    return back();
});
    Route::get('db','InstallerController@db')->name('db');
    Route::post('db/next','InstallerController@dbcheck')->name('db.next');
    Route::get('server','InstallerController@server')->name('server');
    Route::post('server/check','InstallerController@finalstep')->name('server.check');
    Route::post('/verifycode','HomeController@verifycode');
    Route::middleware(['web'])->group(function () {
    Route::post('guest/login', 'GuestController@guestlogin')->name('guest.login');
    Route::view('/accessdenied','accessdenied')->name('inactive');
    Route::get('/offline','GuestController@offlineview');
    Route::resource('roles','Roles\RolesController');
    Route::view('permission','per');
    Route::view('permission/bulk','perbulk');
    Route::post('permission/bulk','Roles\RolesController@bulkPermission');
    Route::post('permission','Roles\RolesController@createPermission');
    Route::get('bigblue/api/callback','BigBlueController@logout');
    //Updater Routes
    Route::get('/ota/update', 'OtaUpdateController@getotaview')->name('ota.update');
    Route::post('/ota/proccess', 'OtaUpdateController@update')->name('update.proccess');
    Route::get('update/process', 'OtaUpdateController@updateprocess')->name('update.process');
    Route::get('manual/process', 'OtaUpdateController@manualprocess')->name('manual.process');
    Route::post('/change-domain','AdminController@changedomain');
    Route::view('/ipblock','ipblock')->name('ip.block');
    Route::get('show/comingsoon','ComingSoonController@comingsoonpage')
        ->name('comingsoon.show');

    Route::get('getsecretkey', 'GenerateApiController@getkey')->name('get.api.key')->middleware('is_admin');
    Route::post('createkey', 'GenerateApiController@createKey')->middleware('is_admin')->name('apikey.create');
    Route::post('/verify-2fa','TwoFactorAuthController@verify')->middleware('auth');
    Route::middleware(['switch_languages', 'ip_block'])->group(function () {
    // Auth Routes
    Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
    if(env('DEFAULT_THEME') == 'classic')
    {
        
         Route::get('instructor/view', 'FrontinstructorController@index')->name('allinstructor/view');
            Route::get('instructor/profile/{id}', 'FrontinstructorController@profile')->name('allinstructor/profile');
            Route::get('profile/{id}', 'FrontinstructorController@Allprofile')->name('all/profile');
            Route::get('front/feature', 'FeaturesController@front')->name('front.feature');
            Route::middleware(['IsInstalled','is_verified', 'maintanance_mode'])->group(function () {
            Route::get('studentprofile', 'StudentprofileController@index')->name('studentprofile');
            Route::get('/', 'HomeController@index');
            Route::get('/home', 'HomeController@index')->name('home');
            Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');
         }); 
    }
    Route::middleware(['is_admin'])->group(function() {
        Route::get('/admin/show/configuration/{Theme}', 'ConfigurationController@index')->name('configuration.show');
        Route::post('/admin/update/configuration/{Theme}', 'ConfigurationController@update')->name('configuration.update');
        Route::post('/admin/re-generate/theme/key', 'ConfigurationController@reGenerate')->name('regen.key');
    });
    Route::post('/admin/get/theme/key', 'ConfigurationController@getSecret')->name('get.key');
    Auth::routes(['verify' => true]);
    Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
    Route::prefix('admins')->group(function (){
        Route::get('/', 'AdminController@index')->name('admin.index');
        
    });

    Route::get('/support/user', [AdminSupportController::class, 'index'])->name('supportuser');
    Route::post('/support_admin', [AdminSupportController::class, 'store'])->name('supportadmin.store');
    Route::post('/account/delete', 'DeleteAccountController@store')->name('account.delete');
    Route::get('language-switch/{local}', 'LanguageSwitchController@languageSwitch')->name('languageSwitch');

    Route::middleware(['is_active', 'auth', 'maintanance_mode'])->group(function () {

        Route::middleware(['is_admin'])->group(function () {
            //ChatGptController
            Route::post('openai/text','ChatgptController@text');
            Route::post('openai/image','ChatgptController@image');
            Route::get("admin/dropdown","CourseController@upload_info");
            Route::get('database/import', 'DatabaseController@demoimport')->name('import.view');
            Route::post('admin/import/demo', 'DatabaseController@importdatabase')->name('import.database');
            Route::post('admin/reset/demo', 'DatabaseController@resetdatabase')->name('reset.database');

            // Player Settings
            Route::get('/admin/playersetting','PlayerSettingController@get')->name('player.set');
            Route::post('/admin/playersetting/update','PlayerSettingController@update')->name('player.update');

            Route::get('admin/ads','AdsController@getAds')->name('ads');
            Route::post('admin/ads/insert','AdsController@store')->name('ad.store');

            Route::get('admin/ads/setting','AdsController@getAdsSettings')->name('ad.setting');

            Route::put('admin/ads/timer','AdsController@updateAd')->name('ad.update');

            Route::put('admin/ads/pop','AdsController@updatePopAd')->name('ad.pop.update');

            Route::delete('admin/ads/delete/{id}','AdsController@delete')->name('ad.delete');

            Route::get('admin/ads/create','AdsController@create')->name('ad.create');

            Route::get('admin/ads/edit/{id}','AdsController@showEdit')->name('ad.edit');

            Route::put('admin/ads/edit/{id}','AdsController@updateADSOLO')->name('ad.update.solo');

            Route::put('admin/ads/video/{id}','AdsController@updateVideoAD')->name('ad.update.video');

            Route::post('admin/ads/bulk_delete', 'AdsController@bulk_delete');

            Route::post('quickupdate/coursestatus','QuickUpdateController@courseQuick')->name('course.quick');
            Route::post('quickupdate/involvementrequest','QuickUpdateController@involvementrequest')->name('involvementrequest.quick');
            Route::post('quickupdate/involvementcourse','QuickUpdateController@involvementcourse')->name('involvementcourse.quick');
            Route::post('/quickupdate/directory','QuickUpdateController@directory')->name('directory.quick');
            Route::post('/quickudate/course','QuickUpdateController@courseabc')->name('course.featured');

            Route::post('/quickupdate/slider','QuickUpdateController@sliderQuick')->name('slider.quick');
            Route::post('/quickupdate/truested','QuickUpdateController@truested')->name('truested.quick');
            Route::post('/quickupdate/instructorrequest','QuickUpdateController@instructorrequest')->name('instructorrequest.quick');
            Route::post('/quickupdate/advertisement','QuickUpdateController@advertisement')->name('advertisement.quick');

            Route::post('/quickupdate/user/{id}','QuickUpdateController@userQuick')->name('user.quick');
            



            



            // SupportTypeController Routes
            Route::get('/admin/support/type', [SupportTypeController::class, 'show'])->name('supporttype.show');
            Route::get('/admin/support/create', [SupportTypeController::class, 'create'])->name('supporttype.create');
            Route::post('/admin/support/type', [SupportTypeController::class, 'store'])->name('supporttype.store');
            Route::get('/admin/support/type/{id}/edit', [SupportTypeController::class, 'edit'])->name('supporttype.edit');
            Route::put('/admin/support/type/{id}', [SupportTypeController::class, 'update'])->name('supporttype.update');
            Route::delete('/admin/support/type/{id}/delete', [SupportTypeController::class, 'destroy'])->name('supporttype.destroy');
            Route::post('/admin/support/type/bulk_delete', [SupportTypeController::class, 'bulk_delete'])->name('supporttype.bulk_delete');

            //  AdminSupportController Admin Routes
            Route::get('/support_admin', [AdminSupportController::class, 'supportadmin'])->name('support_admin.index');
            Route::get('/support_admin/create', [AdminSupportController::class, 'supportcreate'])->name('supportadmin.create');
            Route::put('/support_reply/{id}', [AdminSupportController::class, 'SupportReply'])->name('support_reply.update');
            Route::delete('/support_admin/{id}/delete', [AdminSupportController::class, 'Supportdestroy'])->name('support_admin.destroy');
            Route::post('/support_admin/bulk_delete', [AdminSupportController::class, 'Supportbulk_delete'])->name('support_admin.bulk_delete');

            Route::get('admin/user-requests', [DeleteAccountController::class, 'useraccountdelete'])->name('user-requests');
            Route::post('admin/users-bulk-delete', [DeleteAccountController::class, 'bulk_delete'])->name('users-bulk-delete');
            Route::delete('admin/user-delete/{id}', [DeleteAccountController::class, 'delete'])->name('user-delete');

         
            Route::post('/quickupdate/category/{id}','QuickUpdateController@categoryQuick')->name('category.quick');
            Route::post('/quickupdate/language/{id}','QuickUpdateController@languageQuick')->name('language.quick');
            Route::post('/quickupdate/pag/{id}','QuickUpdateController@pageQuick')->name('page.quick');
            Route::post('/quickupdate/what/{id}','QuickUpdateController@whatQuick')->name('what.quick');
            Route::post('/quickupdate/ansr/{id}','QuickUpdateController@ansrQuick')->name('ansr.quick');
            Route::post('/quickupdate/Chapter/{id}','QuickUpdateController@ChapterQuick')->name('Chapter.quick');
            Route::post('/quickupdate/subcategory/{id}','QuickUpdateController@subcategoryQuick')->name('subcategory.quick');
            Route::post('/quickupdate/childcategory/{id}','QuickUpdateController@childcategoryQuick')->name('childcategory.quick');
            Route::post('/quickupdate/y/{id}','QuickUpdateController@categoryfQuick')->name('categoryf.quick');
            Route::post('/quickupdate/blog_status/{id}','QuickUpdateController@blog_statusQuick')->name('blog.status.quick');
            Route::post('/quickupdate/blog_approved/{id}','QuickUpdateController@blog_approvedQuick')->name('blog.approved.quick');
            Route::post('/quickupdate/status/{id}','QuickUpdateController@reviewstatusQuick')->name('reviewstatus.quick');
            Route::post('/quickupdate/approved/{id}','QuickUpdateController@reviewapprovedQuick')->name('reviewapproved.quick');
            Route::post('/quickupdate/featured/{id}','QuickUpdateController@reviewfeaturedQuick')->name('reviewfeatured.quick');
            Route::post('/quickupdate/faq/{id}','QuickUpdateController@faqQuick')->name('faq.quick');
            Route::post('/quickupdate/faqinstructor/{id}','QuickUpdateController@faqInstructorQuick')->name('faqInstructor.quick');
            Route::post('/quickupdate/order/{id}','QuickUpdateController@orderQuick')->name('order.quick');

            Route::prefix('user')->group(function (){
            Route::get('/','UserController@viewAllUser')->name('user.index');
            Route::get('/adduser','UserController@create')->name('user.add');
            Route::post('/insertuser','UserController@store')->name('user.store');
            Route::get('edit/{id}','UserController@edit')->name('user.edit');
            Route::put('/edit/{id}','UserController@update')->name('user.update');   
            Route::delete('delete/{id}','UserController@destroy')->name('user.delete');
            Route::post('csvfileupload','UserController@csvfileupload')->name('user.csvfileupload');
            Route::get('import', 'UserController@import')->name('user.import');
            Route::post('verifaction/store', 'UserProfileController@verifaction_store')->name('verifaction.store');           
            Route::get('verify/user', 'UserController@verify_user')->name('user.verify');
            Route::get('user/verify','UserController@change_user_verify')->name('verifed_user');
            Route::post('user/blocked','UserController@user_blocked')->name('user_blocked');
            });
            Route::resource('contactreason','ContactreasonController');
            Route::resource('service','ServicesController');
            Route::resource('alumini','AluminiController');
            Route::post('alumini/bulk_delete', 'AluminiController@bulk_delete')->name('alumini.bulk_delete');
            Route::resource('feature','FeaturesController');
            Route::resource("admin/country","CountryController");
            Route::post('country/bulk_delete', 'CountryController@bulk_delete')->name('country.bulk_delete');
            Route::resource("admin/state","StateController");
            Route::resource("admin/city","CityController");
            Route::get("get/state/country","CountryController@get_state_country");
            Route::resource('page','PageController');
            Route::get('page-status','PageController@status')->name('page.status');
            Route::resource('/testimonial','TestimonialController');
            Route::resource('slider','SliderController');
            Route::resource('trusted','TrustedController');
            Route::post('mailsetting/update','SettingController@updateMailSetting')->name('update.mail.set');
            Route::match(['get', 'post'], '/send-email', [SettingController::class, 'sendEmail'])->name('testsend.email');
            Route::get('settings','SettingController@genreal')->name('gen.set');
            Route::post('setting/store','SettingController@store')->name('setting.store');
            Route::post('setting/seo','SettingController@updateSeo')->name('seo.set');
            Route::post('setting/addcss','SettingController@storeCSS')->name('css.store');
            Route::post('setting/addjs','SettingController@storeJS')->name('js.store');
            Route::post('setting/sociallogin/fb','SettingController@slfb')->name('sl.fb');
            Route::post('setting/sociallogin/gl','SettingController@slgl')->name('sl.gl');
            Route::post('setting/sociallogin/git','SettingController@slgit')->name('sl.git');
            Route::post('setting/sociallogin/amazon','SettingController@slamazon')->name('sl.amazon');
            Route::post('setting/sociallogin/linkedin','SettingController@sllinkedin')->name('sl.linkedin');
            Route::post('setting/sociallogin/twitter','SettingController@sltwitter')->name('sl.twitter');
            Route::get('settings/login','SettingController@login')->name('settings.login');
            Route::post('setting/login/update','SettingController@loginupdate')->name('login.update');
            Route::get('videosetting','VideosettingController@index')->name('videosetting');
            Route::post('videosetting/update','VideosettingController@update')->name('videosetting.update');
            Route::get('mobileqr','DownloadqrController@index')->name('mobileqr');
            Route::post('mobileqr/update','DownloadqrController@update')->name('mobileqr.update');
            Route::get('upi','UpiController@index')->name('upi');
            Route::post('upi/update','UpiController@update')->name('upi.update');
            Route::get('setting/service','ServicesettingController@index')->name('service.settings');
            Route::post('update/servicesetting','ServicesettingController@update')->name('servicesetting.update');
            Route::get('setting/feature','FeaturesettingController@index')->name('feature.settings');
            Route::post('update/featuresetting','FeaturesettingController@update')->name('featuresetting.update');
            Route::resource('fact','FactsController');
            Route::get('fact/status','FactsController@status')->name('fact.status');
            Route::get('join/setting','JoinInstructorController@index')->name('join.instructor');
            Route::post('join/setting/update','JoinInstructorController@update')->name('join.update');
            Route::get('breadcrumb/setting','BreadcumController@index')->name('breadcrumb.setting');
            Route::post('breadcrumb/setting/update','BreadcumController@update')->name('breadcrumb.update');
            Route::get('/admin/api','ApiController@setApiView')->name('api.setApiView');
            Route::post('admin/api','ApiController@changeEnvKeys')->name('api.update');
            Route::put('/review/update/{id}','ReviewratingController@update')->name('review.update');
            Route::post('adminsetting/update','SettingController@adminsetting')->name('adminsetting.update');
            Route::get('/instructor/course/verify/{id}/{slug}','CourseController@instructorCourseVerify')->name('instructor.course.verify');
            Route::post('/instructor/course/notverify/{id}/{slug}','CourseController@instructorCourseNotVerify')->name('instructor.course.notverify');

            Route::get('/download-pdf/{id}/{filename}','CourseController@downloadPdf')->name('download.pdf');


            Route::get('/instructor/course/show/{id}/{slug}','CourseController@instructorCourseDetailPage')->name('instructor.course.show');
            Route::get('instructor/course', 'CourseController@instructor_course')->name('instructor/course');
            Route::post('instructor.cource.delete', 'CourseController@instructor_course_delete')->name('instructor.cource.delete');
            Route::resource('facts', 'SliderfactsController');
            Route::get('coursetext', 'CoursetextController@show');
            Route::get('user/openai', 'ChatgptController@useropenai');
            Route::post('openai-bulk-delete', 'ChatgptController@bulk_delete')->name('openai.bulk.delete');
            Route::delete('openai/delete/{id}','ChatgptController@delete')->name('openai.delete');
            Route::put('coursetext/update', 'CoursetextController@update');
            Route::get('getstarted', 'GetstartedController@show');
            Route::put('getstarted/update', 'GetstartedController@update');
            Route::get('terms', 'TermsController@show')->name('termscondition');
            Route::put('termscondition', 'TermsController@update');
            Route::get('policy', 'TermsController@showpolicy')->name('policy');
            Route::put('privacypolicy', 'TermsController@updatepolicy');
            Route::get('change/words','ChangewordController@index')->name('chnaeword.index');
            Route::get('change/json/{json}','ChangewordController@store')->name('changejson');
            Route::post('change/json/update','ChangewordController@update')->name('chngejson.update');

            
            Route::resource('reports','ReportReviewController');
            Route::get('comingsoon', 'ComingSoonController@show')->name('comingsoon.page');
            Route::put('comingsoonupdate', 'ComingSoonController@update');
            Route::resource('faq','FaqController');
            Route::resource('dropdown','DropdownController');

            Route::get('reposition/faq', 'FaqController@reposition')->name('faq_reposition');

            Route::resource('faqinstructor','FaqInstructorController');
            Route::get('reposition/faqinstructor', 'FaqInstructorController@reposition')->name('faqinstructor_reposition');
            Route::resource('carts', 'CartController');

            Route::get('currency', 'CurrencyController@show');
            Route::put('currency/update', 'CurrencyController@update');

            Route::get('widget', 'WidgetController@edit')->name('widget.setting');
            Route::put('widget/update', 'WidgetController@update');
            Route::post('admin/class/{id}/addsubtitle','SubtitleController@post')->name('add.subtitle');
            Route::post('admin/class/{id}/delete/subtitle','SubtitleController@delete')->name('del.subtitle');

            Route::get('frontslider', 'CategorySliderController@show')->name('category.slider');
            Route::put('frontslider/update', 'CategorySliderController@update');

            Route::resource('coupon','CouponController');
            Route::get('coupon/report', 'CouponController@report')->name('coupon.report');
            Route::get('all/instructor', 'InstructorRequestController@allinstructor')->name('all.instructor');
            Route::get('front/alumini', 'AluminiController@front')->name('front.alumini');
            Route::post('alumini/{user_id}/update','AluminiController@frontupdate')->name('alumini.update');

            Route::resource('admin/report/view','CourseReportController');

            Route::get('banktransfer', 'BankTransferController@show')->name('bank.transfer');
            Route::put('banktransfer/update', 'BankTransferController@update');

            Route::get('admin/lang', 'LanguageController@showlang')->name('show.lang');

            Route::get('admin/frontstatic/{local}', 'LanguageController@frontstaticword')->name('frontstatic.lang');

            Route::post('/admin/update/{lang}/frontTranslations/content','LanguageController@frontupdate')->name('static.trans.update');

            Route::get('admin/adminstatic/{local}', 'LanguageController@adminstaticword')->name('adminstatic.lang');

            Route::post('/admin/update/{lang}/adminTranslations/content','LanguageController@adminupdate')->name('admin.static.update');

            Route::get('admin/flashmsg/{local}', 'LanguageController@flashmsgword')->name('flashmsg.lang');

            Route::post('/flashmsg/update/{lang}/flashmsgTranslations/content','LanguageController@flashupdate')->name('flashmsg.update');

            Route::get('admin/pwa', 'PwaSettingController@index')->name('show.pwa');

            Route::post('/admin/pwa/update/manifest','PwaSettingController@updatemanifest')->name('manifest.update');

            Route::post('/admin/pwa/update/sw','PwaSettingController@updatesw')->name('sw.update');

            Route::post('/admin/pwa/update/icons','PwaSettingController@updateicons')->name('icons.update');

            Route::post('/admin/manualcity','CityController@addcity')->name('city.manual');

            Route::post('/admin/manualstate','StateController@addstate')->name('state.manual');

            Route::resource('user/question/report','QuestionReportController');


            // adsense routes
            Route::get('/admin/adsensesetting/','AdsenseController@index')->name('adsense');
            Route::put('/admin/adsensesetting','AdsenseController@update')->name('adsense.update');

            Route::get('admin/ipblock', 'IPBlockController@view')->name('ipblock.view');
            Route::post('admin/ipblock/update', 'IPBlockController@update')->name('ipblock.update');

            // sitemap routes
            Route::post('sitemap', 'SiteMapController@sitemap');
            Route::get('show/sitemap', 'SiteMapController@index')->name('show.sitemap');
            Route::post('download/sitemap', 'SiteMapController@download')->name('download.sitemap');

            // whatsapp button routes
            Route::get('whatsapp/settings', 'WhatsappButtonController@show')->name('whatsapp.button');
            Route::post('whatsapp/update', 'WhatsappButtonController@update')->name('whatsapp.update');

            Route::get('recordings/meeting','BigBlueController@getrecordings')->name('download.meeting');
            Route::resource('batch', 'BatchController');
            Route::get('batch','BatchController@front')->name('batch.front');
            Route::get('your-batch/{slug}', 'BatchController@batchfront')->name('batch.frontdetail');

            Route::resource('refundpolicy', 'RefundPolicyController');
            Route::resource('refundorder', 'RefundController');

            Route::get('admin/coloroption', 'ColorOptionController@index')->name('coloroption.view');
            Route::post('admin/coloroption/update', 'ColorOptionController@update')->name('coloroption.update');
            Route::get('admin/coloroption/reset', 'ColorOptionController@reset')->name('coloroption.reset');

            Route::get('database/backup', 'DatabaseController@index')->name('database.backup');
            Route::get('database/genrate', 'DatabaseController@genrate')->name('database.genrate');
            Route::post('database/delete', 'DatabaseController@deletebackup')->name('database.delete');
            Route::get('admincustomisation', 'AdmincustomisationController@index')->name('admincustomisation.view');
            Route::post('admincustomisation/update', 'AdmincustomisationController@update')->name('admincustomisation.update');
            Route::get('admincustomisation/reset', 'AdmincustomisationController@reset')->name('admincustomisation.reset');
            Route::get('database/download/{filename}', 'DatabaseController@download')->name('database.download');
            Route::post('database/dump', 'DatabaseController@update')->name('database.dump');

            Route::resource('advertisement','AdvertisementController');

            Route::resource('manualpayment','ManualPaymentController');
            Route::get('manualpayment-status','ManualPaymentController@status')->name('manualpayment.status');
            Route::post('manualpayment-bulk-delete', 'ManualPaymentController@bulk_delete')->name('manualpayment.bulk.delete');

            Route::get('order/enroll/{user_id}', 'OrderController@enrollUser')->name('order.enrolluserview');


            Route::resource('attandance','AttandanceController');
            Route::get('view/users/{id}', 'AttandanceController@enrolled')->name('enrolled.users');
            Route::get('user/attandance/{id}/{course}', 'AttandanceController@attandance')->name('user.attandance');
            Route::get('attand/report', 'AttandanceController@report')->name('attand.report');

            Route::get('/admin/push-notifications','OneSignalNotificationController@index')->name('onesignal.settings');
            Route::post('/admin/onesignal/keys','OneSignalNotificationController@updateKeys')->name('onesignal.update');
            Route::post('/admin/push-notifications','OneSignalNotificationController@push')->name('admin.push.notif');


            Route::get('quick/update', 'ReplaceFilesController@index')->name('quick.update');
            Route::post('replace', 'ReplaceFilesController@replace')->name('replace');

            Route::get('twilio/settings','TwilioController@index')->name('twilio.settings');
            Route::post('twilio/update','TwilioController@update')->name('twilio.update');


            Route::get('activity/users','UserActivityController@index')->name('activity.index');
            Route::delete('activity/delete/{id}','UserActivityController@delete')->name('activity.delete');

            Route::get('remove/public','SupportController@index')->name('remove.public');
            Route::post('add/content','SupportController@addcontent')->name('add.content');
            Route::post('create/file','SupportController@createfile')->name('create.file');

            Route::resource('subscription/plan','InstructorPlanController');
            Route::resource('orders/subscription', 'SubscribedOrdersController');

            

            Route::resource('directory','SeoDirectoryController');
            Route::get('/directory/show/{id}/{city}', 'SeoDirectoryController@view')->name('directory.view');

            Route::resource('previous-paper','PreviousPaperController');

            Route::resource('private-course','PrivateCourseController');
            Route::resource('meeting-recordings','MeetingRecordingController');

            Route::get('plan/subscribe/settings', 'SubscriptionEnableController@view')->name('plan.settings');
            Route::post('plan/subscribe/update', 'SubscriptionEnableController@settings')->name('plan.settings.update');

            Route::get('/admin/addon', 'AddonController@addon')->name('admin.addon');
            Route::get('/admin/add/addon', 'AddonController@addaddon')->name('add.addon');
            Route::post('/admin/install/addon', 'AddonController@installaddon')->name('install.addon');
            Route::post('/admin/addon/status/{module}', 'AddonController@status')->name('status.addon');
            Route::post('/admin/addon/delete/{module}', 'AddonController@delete')->name('addon.delete');

            Route::get('/admin/add/theme', 'ThemeController@addTheme')->name('add.theme');
            Route::post('/admin/install/theme', 'ThemeController@installTheme')->name('install.theme');
            Route::post('/admin/theme/delete/{module}', 'ThemeController@delete')->name('theme.delete');

            Route::get('/admin/revenue/report', 'RevenueReportController@report')->name('admin.revenue.report');
            Route::get('/revenue/report/instructor', 'RevenueReportController@instructorReport')->name('instructor.revenue.report');


            

            Route::prefix('wallet')->group(function () {

                Route::get('/settings', 'WalletSettingController@index')->name('wallet.settings');
                Route::post('/settings/update', 'WalletSettingController@update')->name('wallet.update');
                Route::get('/transactions', 'WalletSettingController@transactions')->name('wallet.transactions');
            });

            Route::get('affiliates', 'AffiliateController@index')->name('save.affiliates');
            Route::post('affiliates', 'AffiliateController@update')->name('affiliates.update');

            Route::get('/admin/themenew', 'SettingController@index')->name('themenew.index');
            Route::post('/admin/themenew/update', 'SettingController@update')->name('themenew.update');
            
            Route::get('theme/settings', 'ThemeController@index')->name('themesettings.index');
            Route::put('update/themesettings', 'ThemeController@update')->name('themesettings.update');

            });

            Route::post('/merge-quick-update', 'OtaUpdateController@mergeQuickupdate');

            Route::get('invoice/settings', 'InvoiceDesignController@index')->name('invoice.index');
            Route::post('update/invoice/settings', 'InvoiceDesignController@update')->name('invoice.update');

            Route::prefix('alluser')->group(function (){
                Route::get('/','AlluserController@viewAllUser')->name('allusers.index');
                Route::get('/alladduser','AlluserController@create')->name('alluser.add');
                Route::post('/allinsertuser','AlluserController@store')->name('alluser.store');
                Route::get('edit/{id}','AlluserController@edit')->name('alluser.edit');
                Route::put('/edit/{id}','AlluserController@update')->name('alluser.update');   
                Route::delete('delete/{id}','AlluserController@destroy')->name('alluser.delete');
                Route::get('user/login/{id}', 'AlluserController@login')->name('users/as/login');

            });

            Route::prefix('allinstructor')->group(function (){
                    
                Route::get('/','AllinstructorController@viewAllUser')->name('allinstructor.index');
                Route::get('/alladdinstructor','AllinstructorController@create')->name('allinstructor.add');
                Route::post('/allinsertinstructor','AllinstructorController@store')->name('allinstructor.store');
                Route::get('edit/{id}','AllinstructorController@edit')->name('allinstructor.edit');
                Route::put('/edit/{id}','AllinstructorController@update')->name('allinstructor.update');
                Route::delete('delete/{id}','AllinstructorController@destroy')->name('allinstructor.delete');
                Route::get('instructor/login/{id}', 'AllinstructorController@login')->name('instructoraslogin');

            });
            Route::prefix('alladmin')->group(function (){
                    
                Route::get('/','AlladminController@viewAllUser')->name('alladmin.index');
                Route::get('/alladdadmin','AlladminController@create')->name('alladmin.add');
                Route::post('/allinsertadmin','AlladminController@store')->name('alladmin.store');
                Route::get('edit/{id}','AlladminController@edit')->name('alladmin.edit');
                Route::put('/edit/{id}','AlladminController@update')->name('alladmin.update');
                Route::delete('delete/{id}','AlladminController@destroy')->name('alladmin.delete');
                Route::get('admin/login/{id}', 'AlladminController@login')->name('adminaslogin');

            });
            Route::get('/verification/ceritificate', 'CertificateController@verification')->name('certificate.index');
            Route::get('/report/certificate', 'CertificateController@report')->name('certificate.report');
            Route::resource('instructor/skills','InstructorskillController');
            Route::get('/device-logs','DeviceController@index')->name('device.logs');
            Route::resource('admin/flash-sales','FlashSaleController');
            Route::get('reposition/flash', 'FlashSaleController@sort')->name('flash_reposition');
            Route::get('/admin/fetch/search', 'FlashSaleController@fetch')->name('test.fetch');
            Route::get('flash/getDeals','FlashSaleController@getDeals')->name('flash.getDeals');
            Route::get('file-export', 'OrderController@fileImportExport')->name('order.fileexport');
            Route::get('financial-report', 'OrderController@order_report')->name('order.report');
              
            Route::get('market-dashboard', 'MarketController@index')->name('market.index');

        });

        Route::middleware(['admin_instructor','auth'])->group(function () {
            
                
            Route::prefix('zoom')->group(function (){
                Route::get('test','ZoomController@test')->name('zoom.test');
                Route::get('fetchUserInfo','ZoomController@fetchUserInfo')->name('zoom.fetchUserInfo');
                Route::get('setting','ZoomController@setting')->name('zoom.setting');
                Route::get('dashboard','ZoomController@dashboard')->name('zoom.index');
                Route::post('token/update','ZoomController@updateToken')->name('updateToken');
                Route::get('create/meeting','ZoomController@create')->name('meeting.create');
                Route::delete('delete/meeting/{id}','ZoomController@delete')->name('zoom.delete');
                Route::post('store/new/meeting','ZoomController@store')->name('zoom.store');
                Route::get('edit/meeting/{meetingid}','ZoomController@edit')->name('zoom.edit');
                Route::post('update/meeting/{meetingid}','ZoomController@updatemeeting')->name('zoom.update');
                Route::get('show/meeting/{meetingid}','ZoomController@show')->name('zoom.show');
            });
            

            
            Route::prefix('bigblue')->group(function (){
                Route::view('setting','admin.bbl.setting')->name('bbl.setting');
                Route::post('setting','BigBlueController@setting')->name('bbl.update.setting');
                Route::get('meetings','BigBlueController@index')->name('bbl.all.meeting');
                Route::view('meeting/create','admin.bbl.create')->name('bbl.create');
                Route::post('meeting/store','BigBlueController@store')->name('bbl.store');
                Route::get('meeting/edit/{meetingid}','BigBlueController@edit')->name('bbl.edit');
                Route::post('meeting/update/{meetingid}','BigBlueController@update')->name('bbl.update');
                Route::delete('meeting/delete/{id}','BigBlueController@delete')->name('bbl.delete');
                Route::get('api/create/meeting/{id}','BigBlueController@apiCreate')->name('api.create.meeting');

                
            });
                    

            // ====== jisti meeting start ==========
            Route::get('jitsi-dashboard', 'JitsiController@jitsidashboard')->name('jitsi.dashboard');
            Route::get('jitsi-create', 'JitsiController@jitsicreate')->name('jitsi.create');
            Route::post('jitsi-meeting-save', 'JitsiController@savejitsimeeting')->name('jitsi.meeting.save');
            Route::delete('delete-meeting/{id}', 'JitsiController@deletemeeting')->name('deletemeeting.jitsi');
            // ====== jisti meeting end =============

            Route::get('institute', 'InstituteController@index')->name('institute.index');
            Route::get('institute/create', 'InstituteController@create')->name('institute.create');
            Route::post('institute/save', 'InstituteController@save')->name('institute.save');
            Route::get('institute/edit/{id}', 'InstituteController@edit')->name('institute.edit');
            Route::post('institute/update/{id}', 'InstituteController@update')->name('institute.update');
            Route::delete('institute/delete/{id}', 'InstituteController@destroy')->name('institute.delete');
            Route::get('institute/verify', 'InstituteController@verify')->name('institute.verify');
            Route::get('/institute/status', 'InstituteController@status')->name('institute.status');

            Route::get('homepage/setting','HomesettingController@index')->name('homepage.setting');
            Route::post('homepage/setting/update','HomesettingController@update')->name('homepage.update');
            Route::get('mobile/setting','MobileSettingController@index')->name('mobile.setting');
            Route::post('mobile/setting/update','MobileSettingController@update')->name('mobile.update');
           
            Route::get('mailchimp/setting','MailchimpsettingController@index')->name('mailchimp.setting');
            Route::post('mailchimp/setting/update','MailchimpsettingController@update')->name('mailchimp.update');
            // ======== googlemeet start =============================
            Route::prefix('googlemeet')->group(function (){

                Route::get('dashboard','GoogleMeetController@dashboard')->name('googlemeet.index');
                Route::get('create/meeting','GoogleMeetController@create')->name('googlemeet.meeting.create');
                Route::post('store/new/meeting','GoogleMeetController@store')->name('googlemeet.store');
                Route::delete('delete/meeting/{id}','GoogleMeetController@delete')->name('googlemeet.delete');
                Route::get('edit/meeting/{meetingid}','GoogleMeetController@edit')->name('googlemeet.edit');
                Route::post('update/meeting/{meetingid}','GoogleMeetController@updatemeeting')->name('googlemeet.update');
                Route::post('googlement-token/update','GoogleMeetController@googleupdatefile')->name('googlemeet.updatefile');
            });

            Route::get('setting','GoogleMeetController@googlemeetsetting')->name('googlemeet.setting');
            Route::get('setting','GoogleMeetController@googlemeetsetting')->name('googlemeet.setting');
            Route::get('oauth', ['as' => 'googleMeetCallBack', 'uses' => 'GoogleMeetController@oauth']);

            Route::get('googlemeet/allmeeting', 'GoogleMeetController@allgooglemeeting')->name('googlemeet.allgooglemeeting');
            // ======== googlemeet end ===============================


            Route::prefix('user')->group(function (){
              Route::get('edit/{id}','UserController@edit')->name('user.edit');
              Route::put('/edit/{id}','UserController@update')->name('user.update');
              Route::get('useraslogin/{id}', 'UserController@login')->name('useraslogin');

            });
            Route::resource('question_book','QuestionBookController');


            Route::resource('category','CategoriesController');
            // Route::resource('services','ServiceController');
            Route::get('/category/{slug}','CategoriesController@show')->name('category.show'); 
            Route::get('reposition/category', 'CategoriesController@reposition')->name('category_reposition');
            Route::resource('subcategory','SubcategoryController');
            Route::resource('childcategory','ChildcategoryController');
            
            Route::resource('course','CourseController');
            Route::resource('courseinclude','CourseincludeController');
            Route::resource('coursechapter','CoursechapterController');

            Route::resource('noticeboard','NoticeBoardController');


            Route::resource('whatlearns','WhatlearnsController');
            Route::resource('relatedcourse','RelatedcourseController');
            Route::resource('questionanswer','QuestionanswerController');
            Route::resource('courseanswer', 'AnswerController');
            Route::resource('courseclass','CourseclassController');
            Route::post('/upload/video','CourseController@upload');
            Route::get("ai/tool","AiController@index");
            Route::resource('reviewrating','ReviewratingController');
            Route::resource('announsment','AnnounsmentController');
            Route::get('/course/create/{id}','CourseController@showCourse')->name('course.show');
            Route::post('/category/insert','CategoriesController@categoryStore')->name('cat.store');
            Route::post('/subcategory/insert','SubcategoryController@SubcategoryStore')->name('child.store');
            Route::get('send', 'CourseclassController@store')->name('notification');
            Route::resource('courselang','CourseLanguageController');
            Route::get("admin/gcat","CourseController@gcato");
            Route::get('instructor', 'InstructorController@index')->name('instructor.index');
            Route::resource('userenroll', 'InstructorEnrollController');
            Route::resource('instructorquestion', 'InstructorQuestionController');
            Route::resource('instructoranswer', 'InstructorAnswerController');
            Route::resource('coursereview', 'CourseReviewController');
            Route::resource('instructor/announcement', 'InstructorAnnouncementController');
            Route::resource('usermessage', 'ContactUsController');
            Route::resource('languages', 'LanguageController');
            Route::get('reposition/category', 'CategoriesController@reposition')->name('category_reposition');
            Route::post('reposition/class', 'CourseclassController@sort')->name('class-sort');
            Route::get('reposition/slider', 'SliderController@reposition')->name('slider_reposition');
            Route::post('reposition/chapter', 'CoursechapterController@sort')->name('chapter-sort');
            Route::resource('admin/quiztopic', 'QuizTopicController');
            Route::post('reposition/quiztopic', 'QuizTopicController@sort')->name('quiztopic-sort');
            Route::resource('/admin/questions', 'QuizController');
            Route::get('reposition/questions', 'QuizController@reposition')->name('questions_reposition');
            Route::resource('blog', 'BlogController');
            Route::resource('order', 'OrderController');
            Route::resource('featurecourse', 'FeatureCourseController');
            Route::post('/paywithpaytm', 'FeatureCourseController@order')->name('paywithpaytm');
            Route::get('/featurepayment/status', 'FeatureCourseController@paymentCallback');
            Route::post('featuredwithpaypal', 'FeatureCourseController@payWithpaypal')->name('featuredWithpaypal');
            Route::get('getfeaturedstatus', 'FeatureCourseController@getPaymentStatus')->name('featured');
            Route::resource('bundle', 'BundleCourseController');
            Route::resource('assignment', 'AssignmentController');
            Route::resource('appointment', 'AppointmentController');
            Route::get('view/order/admin/{id}', 'OrderController@vieworder')->name('view.order');
            Route::get('all/assignment', 'AssignmentController@view')->name('assignment.view');
            Route::get('view/assignment/{id}', 'AssignmentController@assignment')->name('list.assignment');
            Route::get('show/quizreport/{id}', 'QuizTopicController@showreport')->name('show.quizreport');
            // Involment routes
            Route::get('/admin/request/involve/','RequestInvolveController@index')->name('allrequestinvolve');
            Route::post('/admin/involve/create/{id}','InvolvementController@store')->name('involve.store');
            Route::get('/involve/request', 'InvolvementController@index')->name('involve.request.index');
            Route::post('/involve/request/edit/{id}', 'InvolvementController@update')->name('involve.request.edit');
            Route::delete('/involve/request/destroy/{id}', 'InvolvementController@destroy')->name('involve.request.destroy');
            Route::get('/involve/request/allinvolvements', 'InvolvementController@show')->name('involve.request');
            Route::get('payout/download/{id}', 'CompletedPayoutController@pdfdownload')->name('payout.download');
            Route::get('rejected/courses', 'CourseReviewController@rejected')->name('courses.reject');
            Route::get('rejected/view/{id}', 'CourseReviewController@rejectedview')->name('courses.view');
            Route::get('vacation', 'VacationController@view')->name('vacation.view');
            Route::put('vacation/update', 'VacationController@update')->name('vacation.update');
            Route::get('reset/vacation', 'VacationController@reset')->name('vacation.reset');
            Route::post('duplicate/{id}','CourseController@duplicate')->name('course.duplicate');
            //   STATUS OR DELETE SELECTED ROUTES
            Route::get('faq-status','FaqController@status')->name('faq.status');
            Route::post('faqinstructor-deleteAll', 'FaqInstructorController@bulk_delete')->name('faqinstructor.bulk.delete');
            Route::get('user/status','UserController@status')->name('user.status');
            Route::post('user/bulk_delete', 'UserController@bulk_delete')->name('user.bulk_delete');
            Route::post('coupon/bulk_delete', 'CouponController@bulk_delete')->name('coupon.bulk_delete');
            Route::get('courselanguage/status','CourseLanguageController@status')->name('courselanguage.status');
            Route::post('courselanguage/bulk_delete', 'CourseLanguageController@bulk_delete')->name('courselanguage.bulk_delete');
            Route::post('useractivity/bulk_delete', 'UserActivityController@bulk_delete')->name('useractivity.bulk_delete');
            Route::get('/quickupdate/slider','QuickUpdateController@sliderQuick')->name('slider.quick');
            Route::get('/quickupdate/testimonial','QuickUpdateController@testimonialQuick')->name('testimonial.quick');
            Route::get('bundlecourse/status','BundleCourseController@status')->name('bundlecourse.status');
            Route::post('batch/status','BatchController@status')->name('batch.status');
            Route::get('privatecourse/status','PrivateCourseController@status')->name('privatecourse.status');
            Route::get('categories/status','CategoriesController@status')->name('categories.status');
            Route::get('subcategories/status','SubcategoryController@status')->name('subcategories.status');
            Route::get('childcategories/status','ChildcategoryController@status')->name('childcategories.status');
            Route::get('courses/status','CourseController@status')->name('courses.status');
            Route::get('courseinclude/status','CourseincludeController@status')->name('courseinclude.status');
            Route::post('coursereview/bulk_delete', 'CourseReviewController@bulk_delete')->name('coursereview.bulk_delete');
            Route::post('bundlecourse/bulk_delete', 'BundleCourseController@bulk_delete')->name('bundlecourse.bulk_delete');
            Route::post('batch/bulk_delete', 'BatchController@bulk_delete')->name('batch.bulk_delete');
            Route::post('privatecourse/bulk_delete', 'PrivateCourseController@bulk_delete')->name('privatecourse.bulk_delete');
            Route::post('categories/bulk_delete', 'CategoriesController@bulk_delete')->name('categories.bulk_delete');
            Route::post('subcategories/bulk_delete', 'SubcategoryController@bulk_delete')->name('subcategories.bulk_delete');
            Route::post('childcategories/bulk_delete', 'ChildcategoryController@bulk_delete')->name('childcategories.bulk_delete');
            Route::post('contactus-bulk-delete', 'ContactUsController@bulk_delete')->name('contactus.bulk.delete');
            Route::get('faqinstructor-status','FaqInstructorController@status')->name('faqinstructor.status');
            Route::delete('faqinstructor-deleteAll', 'FaqInstructorController@deleteAll')->name('faqinstructor.bulk.delete');
            Route::post('page-bulk-delete', 'PageController@bulk_delete')->name('page.bulk.delete');Route::get('page-status','PageController@status')->name('page.status');
            Route::get('blog-status','BlogController@status')->name('blog.status');
            Route::get('blog-approved','BlogController@blogapproved')->name('blog.approved');
            Route::post('blog-bulk-delete', 'BlogController@bulk_delete')->name('blog.bulk.delete');
            Route::post('courseinclude/bulk_delete', 'CourseincludeController@bulk_delete')->name('courseinclude.bulk_delete');
            Route::post('learnsbulk/bulk_delete', 'WhatlearnsController@bulk_delete')->name('learnsbulk.bulk_delete');
            Route::post('coursechapter/bulk_delete', 'CoursechapterController@bulk_delete')->name('coursechapter.bulk_delete');

            Route::post('noticeboard/bulk_delete', 'NoticeBoardController@bulk_delete')->name('noticeboard.bulk_delete');

            Route::post('question_book/bulk_delete', 'QuestionBookController@bulk_delete')->name('question_book.bulk_delete');
            Route::get('/question-book/generate-pdf', 'QuestionBookController@generatePdf')->name('question_book.generate_pdf');
            Route::post('/import-question-book', 'QuestionBookController@import')->name('import.question.book');


            Route::post('courseclass/bulk_delete', 'CourseclassController@bulk_delete')->name('courseclass.bulk_delete');
            Route::post('relatedcourse/bulk_delete', 'RelatedcourseController@bulk_delete')->name('relatedcourse.bulk_delete');
            Route::post('questionanswer/bulk_delete', 'QuestionanswerController@bulk_delete')->name('questionanswer.bulk_delete');
            Route::post('reviewrating/bulk_delete', 'ReviewratingController@bulk_delete')->name('reviewrating.bulk_delete');
            Route::post('announcement/bulk_delete', 'InstructorAnnouncementController@bulk_delete')->name('announcement.bulk_delete');
            Route::post('previouspaper/bulk_delete', 'PreviousPaperController@bulk_delete')->name('previouspaper.bulk_delete');
            Route::post('quiztopic/bulk_delete', 'QuizTopicController@bulk_delete')->name('quiztopic.bulk_delete');
            Route::post('assignment/bulk_delete', 'AssignmentController@bulk_delete')->name('assignment.bulk_delete');
            Route::post('refundpolicybulk/bulk_delete', 'RefundPolicyController@bulk_delete')->name('refundpolicybulk.bulk_delete');
            Route::get('refundpolicystatus/status','RefundPolicyController@status')->name('refundpolicystatus.status');
            Route::get('restatus/status','CourseReviewController@status')->name('restatus.status');
            Route::post('admin/lang/bulk_delete', 'LanguageController@bulk_delete')->name('admin.lang.bulk_delete');
            Route::post('/admin/revenue/report/bulk_delete', 'RevenueReportController@bulk_delete_admin')->name('admin.revenue.bulk_delete');
            Route::post('/instructor/revenue/report/bulk_delete', 'RevenueReportController@bulk_delete_instructor')->name('instructor.revenue.bulk_delete');
            Route::post('SliderDeleteAll', 'BulkdeleteController@sliderdeleteAll')->name('slider.bulk.delete');
            Route::post('FactsSliderDeleteAll', 'BulkdeleteController@factssliderdeleteAll')->name('factsslider.bulk.delete');
            Route::post('TrustSliderDeleteAll', 'BulkdeleteController@trustsliderdeleteAll')->name('trustslider.bulk.delete');
            Route::post('TestimonalDeleteAll', 'BulkdeleteController@testimonaldeleteAll')->name('testimonal.bulk.delete');
            Route::post('AdvertismentDeleteAll', 'BulkdeleteController@advertismentdeleteAll')->name('advertisment.bulk.delete');
            Route::post('SeodirectoryDeleteAll', 'BulkdeleteController@seodirectorydeleteAll')->name('seodirectory.bulk.delete');
            Route::post('ReportedcourseDeleteAll', 'BulkdeleteController@reportedcoursedeleteAll')->name('reportedcourse.bulk.delete');
            Route::post('ReporteQuestionDeleteAll', 'BulkdeleteController@reportedquestiondeleteAll')->name('reportedquestion.bulk.delete');
            Route::post('CountryDeleteAll', 'BulkdeleteController@countrydeleteAll')->name('country.bulk.delete');
            Route::post('stateDeleteAll', 'BulkdeleteController@statedeleteAll')->name('state.bulk.delete');
            Route::post('cityDeleteAll', 'BulkdeleteController@citydeleteAll')->name('city.bulk.delete');
            Route::post('instructorrequestDeleteAll', 'BulkdeleteController@instructorrequestdeleteAll')->name('instructorrequest.bulk.delete');
            Route::post('instructorpendingdeleteAll', 'BulkdeleteController@instructorpendingdeleteAll')->name('instructorpendingdeleteAll.bulk.delete');
            Route::post('ZoommeetingsdeleteAll', 'BulkdeleteController@ZoommeetingdeleteAll')->name('ZoommeetingsdeleteAll.bulk.delete');
            Route::post('bblmeetingsdeleteAll', 'BulkdeleteController@bblmeetingdeleteAll')->name('bblmmeetingsdeleteAll.bulk.delete');
            Route::post('googlemeetingsdeleteAll', 'BulkdeleteController@googlemeetingdeleteAll')->name('googlemmeetingsdeleteAll.bulk.delete');
            Route::post('jitsimeetingsdeleteAll', 'BulkdeleteController@jitsimeetingdeleteAll')->name('jitsimeetingsdeleteAll.bulk.delete');
            Route::post('faq-Delete', 'FaqController@bulk_delete')->name('faq.bulk.delete');
            Route::get('questionstatus/status','InstructorQuestionController@status')->name('questionstatus.status');
            Route::post('questionbulk/bulk_delete', 'InstructorQuestionController@bulk_delete')->name('questionbulk.bulk_delete');
            Route::get('answerstatus/status','InstructorAnswerController@status')->name('answerstatus.status');
            Route::post('answerbulk/bulk_delete', 'InstructorAnswerController@bulk_delete')->name('answerbulk.bulk_delete');
            Route::post('appointment/bulk_delete', 'AppointmentController@bulk_delete')->name('appointment.bulk_delete');
            Route::post('featurecourse/bulk_delete', 'FeatureCourseController@bulk_delete')->name('featurecourse.bulk_delete');
            Route::post('batch/features','BatchController@features')->name('batch.features');
            Route::post('batch/deleteall', 'BatchController@batchdeleteAll')->name('batch.bulk_delete');
            Route::post('/quickupdate/privatecourse','QuickUpdateController@privatecourse')->name('privayecourse.quick');
            Route::get('bundlecourse/subscription/status','BundleCourseController@subscriptionstatus')->name('bundlecourse.subscription.status');
            Route::get('bundlecourse/featured/status','BundleCourseController@featuredstatus')->name('bundlecourse.featured.status');
            Route::get('/announcement/status/{id}','AnnounsmentController@announcementstatus')->name('announcement.status');
            Route::get('/appointment/status/{id}','AppointmentController@appointmentstatus')->name('appointment.status');
            Route::get('/course-class/status/{id}','CourseclassController@courseclassstatus')->name('course.class.status');
            Route::get('/course-class/featured/{id}','CourseclassController@courseclassfeatured')->name('course.class.featured');
            Route::get('/quickupdate-courceinclude/status/{id}','CourseincludeController@courceincludestatus')->name('courceinclude.quick.status');
            Route::get('/course-chapter/status/{id}','CoursechapterController@coursechapterstatus')->name('course.chapter.status');
            Route::get('/noticestatus/status/{id}','NoticeBoardController@noticestatus')->name('noticestatus.status');

            Route::get('/notice/resend/{id}','NoticeBoardController@resendNotice')->name('notice.resend');



            Route::get('/previous/paper/status/{id}','PreviousPaperController@previouspaperstatus')->name('previous.paper.status');
            Route::get('/quickupdate-questionanswer/status/{id}','QuestionanswerController@questionanswerstatus')->name('questionanswer.quick.status');
            Route::get('/quiz/topic/status/{id}','QuizTopicController@quiztopicstatus')->name('quiz.topic.status');
            Route::get('/quiz/topic/again/status/{id}','QuizTopicController@quiztopicagainstatus')->name('quiz.topic.again.status');
            Route::get('/quickupdate-relatedcourse/status/{id}','RelatedcourseController@relatedcoursestatus')->name('relatedcourse.quick.status');
            Route::get('/Review-rating/featured/{id}','ReviewratingController@reviewratingfeatured')->name('Review.rating.featured');
            Route::get('/Review-rating/status/{id}','ReviewratingController@reviewratingstatus')->name('Review.rating.status');
            Route::get('/Review-rating/approved/{id}','ReviewratingController@reviewratingapproved')->name('Review.rating.approved');
            Route::post('reports/bulk_delete', 'ReportReviewController@bulk_delete')->name('report.review.bulk_delete');
            Route::get('/quickupdate-what/status/{id}','QuickUpdateController@whatQuickstatus')->name('what.quick.status');
            Route::get('order-status','OrderController@status')->name('order.status');
            Route::get('cource-status','CourseController@courcestatus')->name('cource.status');
            Route::get('cource-featured-status','CourseController@courcefeatured')->name('cource.featured.status');
            Route::post('cource-bulk-delete', 'CourseController@bulk_delete')->name('cource.bulk.delete');
            Route::get('cat-status','CategoriesController@catstatus')->name('cat.status');
            Route::get('featured-status','CategoriesController@catfeatured')->name('cat.featured');
            Route::get('/admin/import/quiz', 'QuizController@importquiz')->name('import.quiz');
            Route::post('admin/import', 'QuizController@import')->name('import');
            Route::get('quiz/review', 'QuizController@quizreview')->name('quiz.review');
            Route::post('quizreview/approve', 'QuizController@quizreviewQuick')->name('quizreview.quick');
            Route::get('show/quiz/report', 'QuizTopicController@quizreport')->name('quizreport');
            Route::get('show/quiz/report/{id}', 'QuizTopicController@view')->name('quizre');
            Route::get('show/progress/report', 'CourseProgressController@progressreport')->name('progressreport');
            Route::get('progress/report/{id}', 'CourseProgressController@progressview')->name('preport');
            Route::get('verifaction', 'UserProfileController@verifaction')->name('verifaction');
        });
    });
    Route::middleware(['is_verified', '2fa', 'maintanance_mode','switch_languages'])->group(function () {
    Route::get('categories/{slug}', 'CategoriesController@categorypage')->name('category.page');
    Route::get('category/{categorySlug}/{slug}', 'CategoriesController@subcategorypage')->name('subcategory.page');
    Route::get('category/{categorySlug}/{subCategorySlug}/{slug}', 'CategoriesController@childcategorypage')->name('childcategory.page');
    Route::get('cart', 'CartController@cartpage')->name('cart.show');
    Route::get('currency-switch/{currency}', 'CurrencyController@CurrencySwitch')->name('CurrencySwitch');
    Route::get('search', 'SearchController@index')->name('search');
    Route::get('blogs','BlogController@blogpage')->name('blog.all');
    Route::get('courses','CourseController@Allcourse')->name('all.course');   
    Route::get('footer/alumini', 'AluminiController@footer')->name('footer.alumini');
    Route::get('footer/update/{id}','AluminiController@footerupdate')->name('footer.update'); 
    Route::get('show/help', 'FaqController@front')->name('help.show');
    Route::get('gotomycourse', 'CourseController@mycoursepage')->name('mycourse.show');
});

    Route::middleware(['is_verified', '2fa', 'maintanance_mode','switch_languages'])->group(function () {
    if(env('DEFAULT_THEME') == 'classic')
        { 
            Route::resource('requestinstructor', 'InstructorRequestController');
            Route::get('instructor/{id}/{name}', 'InstructorSettingController@instructorprofile')->name('instructor.profile');
            Route::post('rating/show/{id}','ReviewratingController@rating')->name('course.rating');
            Route::post('reports/insert/{id}','ReportReviewController@store')->name('report.review');
            Route::resource("admin/menu", "MenuController");
            Route::get('blogs/{slug}','BlogController@blogdetailpage')->name('blog.detail');
            Route::get('/generate-qrcode', [App\Http\Controllers\QrCodeController::class, 'index']);
            Route::get('pages/{slug}','PageController@showpage')->name('page.show');
            Route::post('show/wishlist/{id}','WishlistController@wishlist');
            Route::post('remove/wishlist/{id}','WishlistController@removewishlist');
            Route::get('enroll/show/{id}', 'EnrollmentController@enroll')->name('show.enroll');
            Route::get('/coursecontent/{slug}', 'CourseController@CourseContentPage')->name('course.content');
            Route::post('addquestion/{id}','QuestionanswerController@question');
            Route::post('addanswer/{id}','AnswerController@answer');
            Route::get('wishlist', 'WishlistController@wishlistpage')->name('wishlist.show');
            Route::post('delete/wishlist/{id}', 'WishlistController@deletewishlist');
            Route::post('addtocart', 'CartController@addtocart')->name('addtocart');
            Route::post('removefromcart/{id}','CartController@removefromcart')
              ->name('remove.item.cart');

            Route::get('gotocheckout', 'CheckoutController@checkoutpage');

            // Route::get('/checkoutmeeting', 'CheckoutController@checkoutMeeting')->name('checkoutmeeting');

            Route::get('/checkout', 'CheckoutController@checkoutpage')->name('checkoutpage');
            Route::get('/checkoutmeeting', 'CheckoutController@checkoutmeeting')->name('checkoutmeeting');

            Route::get('/view', 'DownloadController@getDownload');
            Route::get('/download/{id}', 'DownloadController@getDownload')->name('downloadPdf')->middleware('auth');
            Route::post('apply/instructor', 'InstructorRequestController@instructor')
            ->name('apply.instructor');
            Route::get('/user/movie/time/{endtime}/{movie_id}/{user_id}','TimeHistoryController@movie_time');
            Route::get('purchase', 'OrderController@purchasehistory')->name('purchase.show');
            Route::get('invoice/show/{id}', 'OrderController@invoice')->name('invoice.show');
            Route::get('profile/show/{id}', 'UserProfileController@userprofilepage')->name('profile.show');
            Route::put('/edit/{id}','UserProfileController@userprofile')->name('user.profile');
            Route::post('course/reports/{id}','CourseReportController@store')->name('course.report');
            Route::get('watch/course/{id}', 'WatchController@watch')->name('watchcourse');
            Route::get('watch/courseclass/{id}', 'WatchController@watchclass')->name('watchcourseclass');
            Route::get('audio/courseclass/{id}', 'WatchController@audioclass')->name('audiocourseclass');
            Route::get('language-switch/{local}', 'LanguageSwitchController@languageSwitch')->name('languageSwitch');
            Route::get("country/dropdown","CountryController@upload_info");
            Route::get("country/gcity","CountryController@gcity");
            Route::get("dropdowns","BatchController@upload_info");
            Route::view('terms_condition', 'terms_condition');
            Route::view('privacy_policy', 'privacy_policy');
            Route::get('detail/faq/{id}','HelpController@faqstudentpage')->name('faq.detail');
            Route::get('faqinstructor/detail/{id}','HelpController@faqinstructorpage')->name('faqinstructor.detail');
            Route::get('affilate/report','AffilateDashboardController@report')->name('affilate.report');
            Route::get('contact', 'ContactUsController@front')->name('contact.us');
            Route::post('contact/user', 'ContactUsController@usermessage')->name('contact.user');
            Route::get('tabcontent/{id}','TabController@show');
            Route::get('tabcontent1/{id}','TabController@show1');
            
            Route::post('paywithpaypal', 'PaypalController@payWithpaypal')->name('payWithpaypal');
            Route::get('getpaymentstatus', 'PaypalController@getPaymentStatus')->name('status');

            Route::get('event', 'InstaMojoController@index');
            Route::post('pay', 'InstaMojoController@pay');
            Route::get('/payment/pay-success', 'InstaMojoController@success');

            Route::get('stripe', 'StripePaymentController@stripe');
            Route::post('paytostripe', 'StripePaymentController@payStripe')->name('stripe.pay');

            

            Route::get('razorpay', 'RazorpayController@pay')->name('pay');
            Route::post('dopayment', 'RazorpayController@dopayment')->name('dopayment');

            Route::post('/paywithpaystack', 'PayStackController@redirectToGateway')->name('paywithpaystack');
            Route::get('callback', 'PayStackController@handleGatewayCallback')->name('paystack.callback'); 

            Route::post('/paywithpayment', 'PaytmController@order')->name('paywithpayment');
            Route::post('payment/status', 'PaytmController@paymentCallback');

            Route::post('process/banktransfer', 'BankTransferController@banktransfer');

            Route::post('apply/coupon', 'ApplyCouponController@applycoupon');

            Route::post('removecoupon/{id}','ApplyCouponController@remove')
              ->name('remove.coupon');
            
            Route::get('watchcourse/in/frame/{url}/{course_id}', 'WatchController@view')->name('watchinframe');

            Route::get('start_quiz/{id}', 'QuizStartController@quizstart')->name('start_quiz');
            Route::post('/start_quiz/store/{id}','QuizStartController@store')->name('start.quiz.store');
            Route::get('finish/{id}','QuizStartController@show')->name('start.quiz.show');

            Route::get('invoice/download/{id}', 'OrderController@pdfdownload')->name('invoice.download');

            Route::get('watch/lightbox/{id}', 'WatchController@lightbox')->name('lightbox');

            Route::post('question/reports/{id}','QuestionReportController@store')->name('question.report');

            Route::get('certificate/{slug}', 'CertificateController@show')->name('certificate.show');

            Route::get('certificate/download/{slug}', 'CertificateController@pdfdownload')->name('certificate.download');

           
            Route::get('tryagain/{id}', 'QuizStartController@tryagain')->name('tryagain');

        
            Route::post('course/checked/{id}', 'CourseProgressController@checked');
            Route::post('course/unchecked/{id}', 'CourseProgressController@unchecked');


            Route::post('bundle/cart/{id}', 'BundleCourseController@addtocart')->name('bundlecart');
            Route::get('bundle-course/{slug}', 'BundleCourseController@detailpage')->name('bundle.detail');
            Route::get('bundle/enroll/{id}', 'BundleCourseController@enroll')->name('bundle.enroll');

            Route::get('meeting/bbl/{id}', 'BigBlueController@detailpage')->name('bbl.detail');

            Route::get('join/meeting/{meetingid}','BigBlueController@joinview')->name('bbluserjoin');
            Route::post('api/join/meeting','BigBlueController@apiJoin')->name('bbl.api.join');

            Route::post('course/assignment/{id}', 'AssignmentController@submit')->name('assignment.submit');
            Route::post('assignment/delete/{id}', 'AssignmentController@delete');

            Route::post('course/appointment/{id}', 'AppointmentController@request')->name('appointment.request');
            Route::post('appointment/delete/{id}', 'AppointmentController@delete');

            Route::get('/activestatus', 'WatchCourseController@active');

            Route::get('active/courses', 'WatchCourseController@watchlist')->name('active.courses');
            Route::post('active/delete/{id}', 'WatchCourseController@delete')->name('active.delete');

            // payment routes
            Route::post('paywithpayu', 'PayUController@pay')->name('paywithpayu');
            Route::get('payu/payment/success', 'PayUController@success')->name('payu.success');

            Route::post('pay/via/cashfree', 'CashFreeController@pay')->name('cashfree.pay');
            Route::post('payviacashfree/success', 'CashFreeController@success');

            Route::post('payvia/moli/payment', 'MoliController@pay')->name('moli.pay');
            Route::get('/payviamoli/success', 'MoliController@success')->name('moli.pay.success');

            Route::post('payvia/skrill/payment', 'SkrillController@pay')->name('skrill.pay');
            Route::get('payvia/skrill/success', 'SkrillController@success');

           
            Route::post('pay/via/omise', 'OmiseController@pay')->name('pay.via.omise');

            Route::post('payment/notify', 'PayHereController@notifyUrl' )->name('payhere.notifyUrl');
            Route::get ('payment/cancelUrl', 'PayHereController@cancelUrl')->name('payhere.cancelUrl');
            Route::get( 'payment/returnUrl', 'PayHereController@returnUrl' )->name('payhere.returnUrl');

            Route::get('meeting/zoom/{id}', 'ZoomController@detailpage')->name('zoom.detail');

            Route::get('refund/proceed/{id}', 'OrderController@refundview')->name('refund.proceed');
            Route::post('refund/request/{id}', 'OrderController@refundrequest')->name('refund.request');

            Route::resource('bankdetail','UserBankController');
            Route::resource('email-template','EmailTemplateController');

            Route::post('iyzico/izy/payment', 'IyzController@pay')->name('izy.pay');
            Route::post('return/izy/success', 'IyzController@callback')->name('izy.callback');

            Route::get('confirmation', 'OrderController@confirmation' )->name('confirmation');

            Route::get('create-newsletter','NewsletterController@create');
            Route::post('store-newsletter','HomeController@store');

            Route::post('cancelsubscription', 'StripePaymentController@cancelSubscription')->name('stripe.cancelsubscription');

            Route::get('batch/detail/{id}', 'BatchController@detailpage')->name('batch.detail');
            Route::post('batch/cart/{id}', 'BatchController@batchcart')->name('batchcart');

            Route::post('/payvia/sslcommerze', 'SslCommerzPaymentController@index')->name('payvia.sslcommerze');
            Route::post('payvia/sslcommerze/success', 'SslCommerzPaymentController@success');
            Route::post('payvia/sslcommerze/fail', 'SslCommerzPaymentController@fail');
            Route::post('payvias/sslcommerze/cancel', 'SslCommerzPaymentController@cancel');
            Route::post('/payvia/sslcommerze/ipn', 'SslCommerzPaymentController@ipn');
            Route::post('/payvia/chargily', 'ChargilyPayController@initiatePayment')->name('payvia.chargily');

            Route::post('review/helpful/{id}', 'ReviewHelpfulController@store')->name('helpful');

            Route::get('/watchcourse/{user}/{code}/{id}','WatchApiController@watch_course');
            Route::get('/watchclass/{user}/{code}/{id}','WatchApiController@watch_class');

            Route::post('manualpay/pay', 'ManualPaymentController@checkout')->name('manualpay.checkout');

            Route::post('payment/success', 'AamarPayController@paymentSuccess')->name('payment.success');
            Route::post('payment/failed', 'AamarPayController@paymentFailed')->name('payment.failed');
            Route::get('payment/cancel', 'AamarPayController@paymentCancel')->name('payment.cancel');

            Route::post('/checkout', 'BraintreeController@payment')->name('payment.braintree');

            Route::get('sub_start_quiz/{id}', 'QuizStartController@subquizstart')->name('sub_start_quiz');
            Route::post('/sub_start_quiz/store/{id}','QuizStartController@sub_store')->name('sub.start.quiz.store');
            Route::get('sub_finish/{id}','QuizStartController@sub_show')->name('sub.start.quiz.show');

            Route::get('sub_tryagain/{id}', 'QuizStartController@subtryagain')->name('sub.tryagain');


            Route::get('plan/instructor/subscription', 'InstructorPlanController@planpage')->name('plan.page');
            Route::post('plan/checkout', 'InstructorPlanController@checkout')->name('plan.checkout');
            Route::post('subscribewithpaypal', 'PlanSubscribeController@paypal')->name('subscribewithpaypal');
            Route::get('callback/subscribewithpaypal', 'PlanSubscribeController@paypalcallback')->name('callbackpaypal');

            Route::post('plan/subscribe/paytm', 'PlanSubscribeController@paytm')->name('plansubscribepaytm');
            Route::post('/subscribeinstructor/status', 'PlanSubscribeController@paymentsubscribe');


            // ====== jisti meeting start ==========
            Route::get('meetup-conferencing/{meetup}','JitsiController@joinMeetup')->name('jitsi.meet');
            Route::get('meeting/jitsi/{id}', 'JitsiController@jitsidetailpage')->name('jitsipage.detail');
            // ====== jisti meeting end =============

            // ==== google meet route start ===================
            Route::get('meeting/googlemeet/{id}', 'GoogleMeetController@googlemeetdetailpage')->name('googlemeetdetailpage.detail');
            // ==== google meet route end =====================

            Route::group(['prefix'=>'2fa'], function(){
                Route::get('/','TwoFactorAuthController@show2faForm')->name('2fa.show');
                Route::post('/generateSecret','TwoFactorAuthController@generate2faSecret')->name('generate2faSecret');
                Route::post('/enable2fa','TwoFactorAuthController@enable2fa')->name('enable2fa');
                Route::post('/disable2fa','TwoFactorAuthController@disable2fa')->name('disable2fa');

            });
            Route::post('free/plan/checkout', 'PlanSubscribeController@freecheckout')->name('free.plan.checkout');

            Route::get('leaderboard', 'UserProfileController@leaderboard')->name('my.leaderboard');

            Route::get('gift/{id}/{slug}', 'GiftCourseController@giftview')->name('gift.view');
            Route::post('gift/checkout', 'GiftCourseController@giftcheckout')->name('gift.checkout');


            Route::post('follow', 'FollowersController@follow')->name('follow');

            Route::post('user/unfollow', 'FollowersController@unfollow')->name('unfollow');

            Route::get('buynow', 'EnrollmentController@buynow')->name('buynow');


            Route::get('front/service', 'ServicesController@front')->name('front.service');

            Route::get('admin/services', [ServiceController::class, 'index'])->name('admin.services.index');
            Route::get('admin/services/create', [ServiceController::class, 'create'])->name('admin.services.create');
            Route::post('admin/services', [ServiceController::class, 'store'])->name('admin.services.store');
            Route::get('admin/services/{service}/edit', [ServiceController::class, 'edit'])->name('admin.services.edit');
            Route::put('admin/services/{service}', [ServiceController::class, 'update'])->name('admin.services.update');
            Route::delete('admin/services/{service}', [ServiceController::class, 'destroy'])->name('admin.services.destroy');

            Route::prefix('wallet')->group(function () {

                Route::get('/', 'WalletController@index')->name('mywallet.index');
                Route::post('/payment', 'WalletController@checkout')->name('wallet.payment');
                Route::post('/add/paypal', 'WalletController@walletPayPal')->name('wallet.paypal');
                Route::get('/success/paypal', 'WalletController@walletpaypalSuccess')->name('wallet.paypal.success');

                Route::post('/add/paytm', 'WalletController@paytm')->name('wallet.paytm');
                Route::post('/status/paytm', 'WalletController@paymentwallet');

                Route::post('/checkout/wallet/payment', 'WalletPaymentController@walletpayment')->name('payment.wallet');
                Route::post('add/stripe', 'WalletController@payStripe')->name('stripe.wallet');

            });

            Route::get('get/affilates/link', 'AffiliateController@getlink')->name('get.affiliate');
            Route::post('generate/affilates/link', 'AffiliateController@generatelink')->name('generate.affiliate');
            Route::get('institute/{id}/{cour}', 'InstituteController@view')->name('institute.view');
            Route::post('institute/csvfileupload','InstituteController@csvfileupload')->name('institute.csvfileupload');
            Route::get('institute/import', 'InstituteController@import')->name('institute.import');
            Route::get('/institute/{slug}', 'HomeController@instituteslug')->name('ins.sluging');

            Route::post('compare/dataput', 'CompareController@dataput')->name('compare.dataput');
            Route::get('compare', 'CompareController@index')->name('compare.index');
            Route::get('compare/remove/{id}', 'CompareController@destroy')->name('compare.remove');
           
            Route::post('guest/addtocart/{id}', 'GuestController@addtocart')->name('guest.addtocart');
            Route::post('guest/removefromcart/{id}', 'GuestController@removefromcart')->name('guest.removefromcart');

            Route::get('guest/register', 'GuestController@userregister');
            Route::post('guest/checkout', 'GuestController@usercheckout')->name('guest.checkout');

            //Flutterrave route
            Route::post('/payvia/rave/payment', 'FlutterwaveController@initialize')->name('flutterrave.pay');
            Route::get('/rave/callback', 'FlutterwaveController@callback')->name('flutterrave.callback');

        }

        Route::get('follower/view', 'FollowersController@index')->name('follower.view');
        Route::get('featured-courses', 'ViewmoreController@featuredcourse')->name('featuredcourse.view');
        Route::get('bestselling-courses', 'ViewmoreController@bestselling')->name('bestselling.view');
        Route::get('bundles/view', 'ViewmoreController@bundle')->name('bundles.view');
        Route::get('discount-courses', 'ViewmoreController@topdiscounted')->name('topdiscounted.view');


        Route::get('admin/instructor/settings', 'InstructorSettingController@view')->name('instructor.settings');
        Route::post('admin/instructor/update', 'InstructorSettingController@update')->name('instructor.update');
        Route::get('add/settings', 'InstructorSettingController@instructor')->name('instructor.pay');
        Route::post('instructor/payout/{id}', 'InstructorSettingController@settings')->name('instructor.payout');
        Route::get('pending/payout', 'PayoutController@pending')->name('pending.payout');
        Route::get('admin/instructor', 'AdminPayoutController@index')->name('admin.instructor');
        Route::get('admin/pending/{id}', 'AdminPayoutController@pending')->name('admin.pending');
        Route::get('admin/paid/{id}', 'AdminPayoutController@paid')->name('admin.paid');
        Route::post('admin/payout/bulk_payout/{id}', 'AdminPayoutController@bulk_payout');
        Route::post('admin/paypal/{id}', 'PaymentController@paypal')->name('admin.paypal');
        Route::post('admin/banktransfer/{id}', 'PaymentController@banktransfer')->name('admin.banktransfer');
        Route::post('admin/paytm/{id}', 'PaymentController@paytm')->name('admin.paytm');

        Route::get('admin/completed/payout', 'CompletedPayoutController@show')->name('admin.completed');
        Route::get('payout/completed/view/{id}', 'CompletedPayoutController@view')->name('completed.view');
        Route::get('admin/meeting/show', 'MeetingController@index')->name('meeting.show');
        Route::delete('destroy/meeting/{id}','MeetingController@destroy')->name('zoom.destroy');
        Route::get('app/settings', 'AppSettingsController@index')->name('appsettings.index');
        Route::post('update/appsettings', 'AppSettingsController@update')->name('appsettings.update');
        Route::get('notifications/{id}', 'NotificationController@markAsRead')
        ->name('markAsRead');
        Route::get('delete/notifications', 'NotificationController@delete')
        ->name('deleteNotification');


        Route::get('courses/{slug}','CourseController@CourseDetailPage')->name('user.course.show');
        Route::get('answersheet/{id}', 'QuizTopicController@delete')->name('answersheet');

        Route::post('payvia/payflexi/payment', 'PayFlexiController@redirectToGateway')->name('payflexi.pay');
        Route::get('/payvia/payflexi/callback', 'PayFlexiController@callback')->name('payflexi.callback');
        Route::post('payvia/payflexi/webhook', 'PayFlexiController@webhook')->name('payflexi.webhook');

        Route::get('flash/deals', 'FlashDealsController@dealshow')->name('flash.deals');
        Route::get('deal/items/{id}', 'FlashDealsController@dealitems')->name('deal.items');

        Route::get('panel', 'UserProfileController@dashboard')->name('user.dashboard');

        Route::get('free/enroll/{price}', 'EnrollmentController@freeenroll')->name('free.enroll');


    });
    

  });

Route::get('test', 'TestController@test');


Route::get('/autocomplete/fetch', 'SearchController@fetch')->name('autocomplete.fetch');
Route::get('showfatchdata', 'SearchController@showcourse')->name('showcourse');

Route::get('set/goal/date','CourseController@set_goal_date')->name('set.goal.date');

Route::prefix('manage')->group(function() {
    Route::resource('currency', 'CurrencyExchangeController');

    Route::post('save/exchange/key','CurrencyExchangeController@saveSetting')->name('currency.exchanges.save');

    Route::post("/auto_update_currency", "CurrencyExchangeController@auto_update_currency")->name('auto.update.rates');
});




         