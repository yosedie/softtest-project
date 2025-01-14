<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Language;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Course;
use App\Googlemeet;
use App\JitsiMeeting;
use App\Meeting;
use App\BBL;
use App\WidgetSetting;
use Auth;
use App\UserBankDetail;
use App\WatchCourse;
use Carbon\Carbon;
use App\ManualPayment;
use App\Attandance;
use App\Currency;
use App\Wallet;
use App\WalletTransactions;
use App\Affiliate;
use App\Institute;
use Modules\Homework\Models\Homework;
use Modules\Homework\Models\SubmitHomework;
use App\CourseProgress;
use PDF;
use Module;
use Modules\Resume\Models\Acedemic;
use Modules\Resume\Models\Personalinfo;
use Modules\Resume\Models\Project;
use Modules\Resume\Models\Workexp;
use Modules\Resume\Models\Postjob;
use Modules\Resume\Models\Applyjob;
use App\Setting;
use App\User;
use App\Order;
use App\SeekarPackage;
use App\BundleCourse;
use Session;
use App\PendingPayout;
use App\CompletedPayout;
use App\Compare;


class OtherApiController extends Controller
{
    public function siteLanguage(Request $request)
    {

    	$validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

    	$language = Language::get();

        return response()->json(array('language'=>$language), 200);
    }

    public function search(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'searchTerm' => 'required'
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if($errors->first('searchTerm')){
                return response()->json(['message' => $errors->first('searchTerm'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $searchTerm = $request->searchTerm;

        $coursequery = Course::query()->with('user');

        if(isset($searchTerm))
        {
            $search_data = collect();

            $lang =app()->getLocale();

            if($lang == 'ar' || $lang == 'ur')
            {

                $course_title = $coursequery->where('title->'.app()->getLocale(), 'LIKE', '%'.$searchTerm.'%')->paginate(10);
                 
            }
            else{
                
                 $course_title = $coursequery->where('title', 'LIKE', "%$searchTerm%")->where('status','=',1)->paginate(10);

            }
        

            if (isset($course_title) && count($course_title) > 0)
            {
                
                $search_data->push($course_title);
                                

            }

            $course_tags = $coursequery->where('level_tags', 'LIKE', "%$searchTerm%")->where('status','=',1)->paginate(10);

            if (isset($course_tags) && count($course_tags) > 0)
            {
                
                $search_data->push($course_tags);
                                

            }

            $search_data = $search_data->flatten();

            $courses = Course::search($searchTerm)->with('user')->paginate(10);

            return response()->json(array('courses'=>$courses), 200);
        }
        else
        {
            return response()->json(array('message' => 'No searchTerm found', 'status' => 'fail'), 200);
        }
    }

    public function meetings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $zoom_meeting = Meeting::where('course_id','=', NULL)->get();
        $bigblue_meeting = BBL::where('course_id','=', NULL)->get();
        $google_meet = Googlemeet::where('course_id','=', NULL)->get();
        $jitsi_meeting = JitsiMeeting::where('course_id','=', NULL)->get();



        $array_zoom = array($zoom_meeting);
        $array_jitsi = array($jitsi_meeting);

        foreach(array_merge($array_zoom,$array_jitsi) as $item)
        {
           $all_categories[] = array(
                $item,
            );
        }
    


        return response()->json(array('result' => $all_categories,'zoom_meeting' => $zoom_meeting, 'bigblue_meeting' => $bigblue_meeting, 'jitsi_meeting' => $jitsi_meeting, 'google_meet' => $google_meet ), 200);
    }

    public function userbankdetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }


        $user = Auth::user();
        $banks = UserBankDetail::where('user_id', $user->id)->get();


        return response()->json(array('user_bankdetail' => $banks), 200);


    }

    public function addbankdetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'bank_name' => 'required',
            'ifcs_code' => 'required',
            'account_number' => 'required',
            'account_holder_name' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }

            if($errors->first('bank_name')){
                return response()->json(['message' => $errors->first('bank_name'), 'status' => 'fail']);
            }

            if($errors->first('ifcs_code')){
                return response()->json(['message' => $errors->first('ifcs_code'), 'status' => 'fail']);
            }

            if($errors->first('account_number')){
                return response()->json(['message' => $errors->first('account_number'), 'status' => 'fail']);
            }

            if($errors->first('account_holder_name')){
                return response()->json(['message' => $errors->first('account_holder_name'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::user();

        $bank = new UserBankDetail;
        $bank->user_id = $user->id;
        $bank->bank_name = $request->bank_name;
        $bank->ifcs_code = $request->ifcs_code;
        $bank->account_number = $request->account_number;
        $bank->account_holder_name = $request->account_holder_name;
        $bank->bank_enable = 1;

        $bank->save();


        return response()->json(array('message' => 'Your bank detail has been added successfully', 'status' => 'success'), 200);
    }

    public function updatebankdetail(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }

        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::user();

        if (UserBankDetail::where('id', $id)->exists()) {
            $data = UserBankDetail::find($id);

            $data->user_id = isset($request->user_id) ? $request->user_id : $data->user_id;
            $data->bank_name = isset($request->bank_name) ? $request->bank_name : $data->bank_name;
            $data->ifcs_code = isset($request->ifcs_code) ? $request->ifcs_code : $data->ifcs_code;
            $data->account_number = isset($request->account_number) ? $request->account_number : $data->account_number;
            $data->account_holder_name = isset($request->account_holder_name) ? $request->account_holder_name : $data->account_holder_name;

            $data->status = isset($request->bank_enable) ? $request->bank_enable : $data->bank_enable;
            $data->save();

            return response()->json([
              "message" => "updated successfully",
              'record'=>$data
            ]);
        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }


        return response()->json(array('message' => 'Your bank detail has been added successfully', 'status' => 'success'), 200);
    }


    public function updatelanguage(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (UserBankDetail::where('id', $id)->exists()) {
            $userBank = UserBankDetail::find($id);

            $userBank->bank_name = isset($request->bank_name) ? $request->bank_name : $userBank->bank_name;
            $userBank->ifcs_code = isset($request->ifcs_code) ? $request->ifcs_code : $userBank->ifcs_code;
            $userBank->account_number = isset($request->account_number) ? $request->account_number : $userBank->account_number;
            $userBank->account_holder_name = isset($request->account_holder_name) ? $request->account_holder_name : $userBank->account_holder_name;

            $userBank->save();

            return response()->json([
              "message" => "records updated successfully",
              'userBank'=>$userBank
            ]);
        } 
        else {
            return response()->json([
              "message" => "record not found"
            ], 404);
        }
    }

    public function widget(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }


        $widget = WidgetSetting::first();

        return response()->json(array('widget' => $widget), 200);
    }

    public function addwatchlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }

            if($errors->first('course_id')){
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::user();

        $watch = WatchCourse::create([
            'user_id'    => $user->id,
            'course_id'  => $request->course_id,
            'start_time' => \Carbon\Carbon::now()->toDateTimeString(),
            'active'     => '1',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]
        );

        return response()->json(array('watchlist' => $watch), 200);
    }

    public function viewwatchlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::user();

        $watch = WatchCourse::where('user_id', $user->id)->get();

        return response()->json(array('watchlist' => $watch), 200);
    }

    public function deletewatchlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required'
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }

            if($errors->first('course_id')){
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::user();

        if(WatchCourse::where('course_id', $request->course_id)->where('user_id', $user->id)->exists()) {
            WatchCourse::where('course_id', $request->course_id)->where('user_id', $user->id)->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "record not found"
            ], 404);
        }
    }

    public function manual(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        } 

        $payments = ManualPayment::get();

        $result = array();

        foreach ($payments as $data) {

            $result[] = array(
                'id' => $data->id,
                'name' => $data->name,
                'detail' => strip_tags($data->detail),
                'image' => $data->image,
                'image_path' => url('images/manualpayment/'.$data->image),
                'status' => $data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('manual_payment' => $result), 200);

    }


    public function attandance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }
        $user = Auth::user();
        $date = Carbon::now();
            //Get date
        $date->toDateString();
        $zoom = Meeting::where('id', $request->meeting_id)->first();
        if($request->meeting_type == '1')
        {
            $courseAttandance = Attandance::where('user_id', $user->id)->where('zoom_id', $request->meeting_id)->first();
            if(!$courseAttandance)
            {
                $attanded = Attandance::create([
                    'user_id'    => Auth::user()->id,
                    'zoom_id'  => $zoom->id,
                    'instructor_id' => $zoom->user_id,
                    'date'     => $date->toDateString(),
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ]
                );
                return response()->json(array('attanded'=>$attanded));
            }
        }
        $googlemeet = Googlemeet::where('id', $request->meeting_id)->first();
        if($request->meeting_type == '2')
        {
            $courseAttandance = Attandance::where('user_id', $user->id)->where('googlemeet_id', $request->meeting_id)->first();
            if(!$courseAttandance)
            {
                $attanded = Attandance::create([
                    'user_id'    => Auth::user()->id,
                    'zoom_id'  => $googlemeet->id,
                    'instructor_id' => $googlemeet->user_id,
                    'date'     => $date->toDateString(),
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ]
                );
                return response()->json(array('attanded'=>$attanded));
            }
        }
        $jitsimeetings = JitsiMeeting::where('meeting_id', '=', $request->meeting_id)->first();
        if($request->meeting_type == '3')
        {
            $courseAttandance = Attandance::where('user_id', $user->id)->where('jitsi_id', $request->meeting_id)->first();
            if(!$courseAttandance)
            {
                $attanded = Attandance::create([
                    'user_id'    => Auth::user()->id,
                    'zoom_id'  => $jitsimeetings->id,
                    'instructor_id' => $jitsimeetings->user_id,
                    'date'     => $date->toDateString(),
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ]
                );
                return response()->json(array('attanded'=>$attanded));
            }
        }
        $bigblue = BBL::where('meetingid',$request->meeting_id)->first();
        if($request->meeting_type == '4')
        {
            $courseAttandance = Attandance::where('user_id', $user->id)->where('bbl_id', $request->meeting_id)->first();
            if(!$courseAttandance)
            {
                $attanded = Attandance::create([
                    'user_id'    => Auth::user()->id,
                    'zoom_id'  => $bigblue->id,
                    'instructor_id' => $bigblue->user_id,
                    'date'     => $date->toDateString(),
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ]
                );
                return response()->json(array('attanded'=>$attanded));
            }
        }
    }


    public function currencies(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $currencies = Currency::get();

        return response()->json(array('currencies'=>$currencies), 200);
    }

   public function currency_rates(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'price' => 'required',
            'currency_from' => 'required',
            'currency_to' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['Secret Key is required']);
        }
        if ($validator->fails('price')) {
           return response()->json(['message' => $errors->fails('price'), 'status' => 'fail']);
        }
        if ($validator->fails('currency_from')) {
                return response()->json(['message' => $errors->fails('currency_from'), 'status' => 'fail']);
        }
        if ($validator->fails('currency_to')) {
                return response()->json(['message' => $errors->fails('currency_to'), 'status' => 'fail']);
        }
        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $currency = currency($request->price, $from = $request->currency_from, $to = $request->currency_to, $format = false);
        return response()->json(array('currency'=>$currency), 200);
    }

    public function getWallet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $user = Auth::user();
        $wallet = Wallet::where('user_id', $user->id)->get();
        return response()->json(array('walletdetails' => $wallet), 200);
    }

    public function getWalletTransactions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $user = Auth::user();
        $WalletTransactions = WalletTransactions::where('user_id', $user->id)->get();
        return response()->json(array('WalletTransactions' => $WalletTransactions), 200);
    }

    public function getAffiliate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $user = Auth::user();
        $Affiliate = Affiliate::get();
        return response()->json(array('Affiliate' => $Affiliate), 200);
    }

    public function getInstitute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $user = Auth::user();
        $Institute = Institute::where('user_id', $user->id)->get();
        return response()->json(array('Institute' => $Institute), 200);
    }

    public function getHomework(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'course_id' => 'required'
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }

            if($errors->first('course_id')){
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $user = Auth::user();
       
        $Homework = Homework::select('homework.id as id','homework.title as title','homework.description as description','homework.pdf as pdf','homework.compulsory as compulsory', 'submit_homework.homework as homework','submit_homework.remark as remark','submit_homework.marks as marks',\DB::raw('(CASE 
        WHEN submit_homework.id IS NULL THEN "0" ELSE "1" END) AS is_submit'),DB::raw("DATEDIFF(homework.endtime,CURDATE())AS Days"))->
        leftJoin('submit_homework','submit_homework.homework_id','=','homework.id')->where('homework.status','=', 1)->where('homework.course_id', $request->course_id)->get();

        return response()->json(array('Homework' => $Homework), 200);
    }


    public function submitHomework(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'homework_id' => 'required',
    		'course_id' => 'required',
    		'detail' => 'required',
    		'homework' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('homework_id')){
                return response()->json(['message' => $errors->first('homework_id'), 'status' => 'fail']);
            }

            if($errors->first('course_id')){
                return response()->json(['message' => $errors->first('course_id'), 'status' => 'fail']);
            }

            if($errors->first('detail')){
                return response()->json(['message' => $errors->first('detail'), 'status' => 'fail']);
            }

            if($errors->first('homework')){
                return response()->json(['message' => $errors->first('homework'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::user();
        $filename = '';
        if($file = $request->file('homework'))
        {
            
          $filename = time().$file->getClientOriginalName();
          $file->move('files/Homework/',$filename);
          $courseclass['homework'] = $filename;
        }
        $submitHomework = SubmitHomework::create([
            'user_id'    => $user->id,
            'homework_id' => $request->homework_id,
            'course_id'  => $request->course_id,
            'detail'  => $request->detail,
            'homework' => $filename,
            ]
        );
        return response()->json(array('submitHomework' => $submitHomework), 200);
    }


    public function getSpecificHomework(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        if (Homework::where('id', $id)->exists()) {
            $user = Auth::user();
            $Homework = Homework::select('homework.id as id','homework.pdf as pdf')->where('id', $id)->get();
            return response()->json(array('Homework' => $Homework), 200);
        }
        else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }

    public function getAnswer(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        if (Homework::where('id', $id)->exists()) {
            $user = Auth::user();
            $Homework = SubmitHomework::select('submit_homework.id as id','submit_homework.homework as answer')->where('id', $id)->get();
            return response()->json(array('Answer' => $Homework), 200);
        }
        else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }

    public function getCertificate(Request $request, $course_id)
    {
        $user = Auth::user();

        $random = $request.'CR-'.uniqid();

        $serial_no = $random;

        $whatIWant = strtok($random, 'CR-'); 
    
        $progress = CourseProgress::where('user_id', $user->id)->where('course_id', $course_id)->first();

        $course = Course::where('id', $progress->course_id)->first();

        if($progress == NULL)
        {
            return response()->json(['Please Complete your course to get certificate !'], 400); 
        }
        
        
        $pdf = PDF::loadView('front.certificate.download', compact('course', 'progress', 'serial_no'), [], 
        [ 
          'title' => 'Certificate', 
          'orientation' => 'L'
        ]);
        
        // $pdf->save(storage_path().'/app/pdf/certificate.pdf');
        
        return $pdf->download('certificate.pdf');

    }
    
    public function homeModules(){

        $setting = Setting::first();
        $is_homemodule = 0;
        $is_resumemodules = 0;
        $is_certicifate = 0;
        $is_forum = 0;
        // $home_modules = array();
        if(Module::has('Homework') &&  Module::find('Homework')->isEnabled()){
            $is_homemodule=1;
        }
        if(Module::has('Resume') &&  Module::find('Resume')->isEnabled()){
            $is_resumemodules=1;
        }
        if(Module::has('Certificate') &&  Module::find('Certificate')->isEnabled()){
            $is_certicifate=1;
        }
        if(Module::has('Forum') &&  Module::find('Forum')->isEnabled() && $setting->forum_enable==1){
            $is_forum=1;
        }
        // $home_modules = array('Homework'=> $is_homemodule, 'Resume'=> $is_resumemodules, 'Certificate'=> $is_certicifate, 'forum'=> $is_forum);
        return response()->json(array('Homework'=> $is_homemodule, 'Resume'=> $is_resumemodules, 'Certificate'=> $is_certicifate, 'Forum'=> $is_forum), 200);
    }

    public function addResumeDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'profession' => 'required',
            'country' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'skill' => 'required',
            'strength' => 'required',
            'interest' => 'required',
            'objective' => 'required',
            'language' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }

            if($errors->first('fname')){
                return response()->json(['message' => $errors->first('fname'), 'status' => 'fail']);
            }

            if($errors->first('lname')){
                return response()->json(['message' => $errors->first('lname'), 'status' => 'fail']);
            }

            if($errors->first('profession')){
                return response()->json(['message' => $errors->first('profession'), 'status' => 'fail']);
            }

            if($errors->first('country')){
                return response()->json(['message' => $errors->first('country'), 'status' => 'fail']);
            }

            if($errors->first('address')){
                return response()->json(['message' => $errors->first('address'), 'status' => 'fail']);
            }
            
            if($errors->first('phone')){
                return response()->json(['message' => $errors->first('phone'), 'status' => 'fail']);
            }

            if($errors->first('email')){
                return response()->json(['message' => $errors->first('email'), 'status' => 'fail']);
            }

            if($errors->first('skill')){
                return response()->json(['message' => $errors->first('skill'), 'status' => 'fail']);
            }

            if($errors->first('strength')){
                return response()->json(['message' => $errors->first('strength'), 'status' => 'fail']);
            }

            if($errors->first('interest')){
                return response()->json(['message' => $errors->first('interest'), 'status' => 'fail']);
            }

            if($errors->first('objective')){
                return response()->json(['message' => $errors->first('objective'), 'status' => 'fail']);
            }

            if($errors->first('language')){
                return response()->json(['message' => $errors->first('language'), 'status' => 'fail']);
            }
        }

        $persoanl['fname']      = strip_tags($request->fname);
        $persoanl['lname']      = strip_tags($request->lname);
        $persoanl['profession'] = strip_tags($request->profession);
        $persoanl['country']    = strip_tags($request->country);
        $persoanl['address']    = strip_tags($request->address);
        $persoanl['phone']      = strip_tags($request->phone);
        $persoanl['email']      = strip_tags($request->email);
        $persoanl['skill']      = strip_tags($request->skill);
        $persoanl['strength']   = strip_tags($request->strength);
        $persoanl['interest']   = strip_tags($request->interest);
        $persoanl['objective']  = strip_tags($request->objective);
        $persoanl['language']   = strip_tags($request->language);
        if ($file = $request->file('photo'))
        {
            $validator = Validator::make(
                [
                    'file' => strip_tags($request->photo),
                    'extension' => strtolower($request->photo->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required',
                    'extension' => 'required|in:jpg,png',
                ]
            );
            if ($validator->fails()) {
                return back()->withErrors(__('Invalid file !'));
            }
            if ($file = $request->file('photo')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('files/resume', $name);
                $persoanl['image'] = $name;
            }
        }
    
        /** foreach for acedmic **/
        if(!empty($request->course))
        {
            foreach ($request->course as $key => $course) {
                
            Acedemic::create([
                'user_id'       => Auth::user()->id,
                'course'        => strip_tags($request->course[$key]),
                'school'        => strip_tags($request->school[$key]),
                'marks'         => strip_tags($request->marks[$key]),
                'yearofpassing' => strip_tags($request->yearofpassing[$key]),
                ]);
            }
        }
        /** foreach for workexp **/
        if(!empty($request->startdate))
        {
        foreach ($request->startdate as $key => $course) {
            Workexp::create([
                'user_id'       => Auth::user()->id,
                'startdate'     => strip_tags($request->startdate[$key]),
                'enddate'       => strip_tags($request->enddate[$key]),
                'city'          => strip_tags($request->city[$key]),
                'state'         => strip_tags($request->state[$key]),
                'jobtitle'      => strip_tags($request->jobtitle[$key]),
                'employer'      => strip_tags($request->employer[$key]),
                ]);
            }
        }

        /** foreach for project **/
        if(!empty($request->projecttitle))
        {
        foreach ($request->projecttitle as $key => $course) {
            Project::create([
                'user_id' => Auth::user()->id,
                'projecttitle' => strip_tags($request->projecttitle[$key]),
                'role' => strip_tags($request->role[$key]),
                'description' => strip_tags($request->description[$key]),
               ]);
            }
        }
        $data=Personalinfo::create($persoanl);
        
        return response()->json(array('Create Resume Details' => $data), 200);
    }


    public function updateResumeDetails(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('fname')){
                return response()->json(['message' => $errors->first('fname'), 'status' => 'fail']);
            }

            if($errors->first('lname')){
                return response()->json(['message' => $errors->first('lname'), 'status' => 'fail']);
            }

            if($errors->first('country')){
                return response()->json(['message' => $errors->first('country'), 'status' => 'fail']);
            }

            if($errors->first('state')){
                return response()->json(['message' => $errors->first('state'), 'status' => 'fail']);
            }
            
            if($errors->first('city')){
                return response()->json(['message' => $errors->first('city'), 'status' => 'fail']);
            }

            if($errors->first('address')){
                return response()->json(['message' => $errors->first('address'), 'status' => 'fail']);
            }

            if($errors->first('phone')){
                return response()->json(['message' => $errors->first('phone'), 'status' => 'fail']);
            }

            if($errors->first('email')){
                return response()->json(['message' => $errors->first('email'), 'status' => 'fail']);
            }
        }
        $persoanl['fname']      = strip_tags($request->fname);
        $persoanl['lname']      = strip_tags($request->lname);
        $persoanl['phone']      = strip_tags($request->phone);
        $persoanl['email']      = strip_tags($request->email);
        $persoanl['address']    = strip_tags($request->address);
        $persoanl['country']    = strip_tags($request->country);
        $persoanl['state']      = strip_tags($request->state);
        $persoanl['city']       = strip_tags($request->city);
        if(isset($request->profession))
        $persoanl['profession'] = strip_tags($request->profession);
        if(isset($request->working_at))
        $persoanl['working_at'] = strip_tags($request->working_at);
        if(isset($request->pin))
        $persoanl['pin']        = strip_tags($request->pin);
        if(isset($request->dob))
        $persoanl['dob']        = strip_tags($request->dob);
        if(isset($request->language))
        $persoanl['language']   = $request->language;
        if(isset($request->english_lavel))
        $persoanl['english_lavel'] = strip_tags($request->english_lavel);
        if(isset($request->strength))
        $persoanl['strength']   = $request->strength;
        if(isset($request->interest))
        $persoanl['interest']   = $request->interest;
        if(isset($request->objective))
        $persoanl['objective']  = strip_tags($request->objective);
        if(isset($request->job_category_id))
        $persoanl['job_category_id']  = strip_tags($request->job_category_id);
        if(isset($request->job_radius))
        $persoanl['job_radius']  = strip_tags($request->job_radius);
        if(isset($request->salary))
        $persoanl['salary']  = strip_tags($request->salary);
        if(isset($request->shift))
        $persoanl['shift']  = strip_tags($request->shift);
        if(isset($request->gender))
        $persoanl['gender']  = strip_tags($request->gender);
        if(isset($request->skill_LMS))
        $persoanl['skill_LMS']  = $request->skill_LMS;
        if(isset($request->skill))
        $persoanl['skill']  = $request->skill;

        if ($file = $request->file('photo'))
        {
            $validator = Validator::make(
                [
                    'file' => strip_tags($request->photo),
                    'extension' => strtolower($request->photo->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required',
                    'extension' => 'required|in:jpg,png',
                ]
            );
            if ($validator->fails()) {
                return back()->withErrors(__('Invalid file !'));
            }
            if ($file = $request->file('photo')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('files/resume', $name);
                $persoanl['image'] = $name;
            }
        }

        if ($recording = $request->file('recording')) {
            $name = time() . $recording->getClientOriginalName();
            $recording->move('files/resume', $name);
            $persoanl['recording'] = $name;
        }
        
        $data = Personalinfo::where('user_id', $id)->first();
        if(isset($data)){
            $data->update($persoanl);
        } else {
            $persoanl['user_id'] = Auth::user()->id;
            $data = Personalinfo::create($persoanl);
        }
    
        /** foreach for acedmic **/
        if(!empty($request->course))
        {
            Acedemic::where('personalinfo_id', $data->id)->delete();
            foreach ($request->course as $key => $course) {
                $acedmc['user_id'] = Auth::user()->id;
                $acedmc['personalinfo_id'] = $data->id;
                if(isset($request->course[$key])) 
                $acedmc['course'] = strip_tags($request->course[$key]);
                if(isset($request->school[$key])) 
                $acedmc['school'] = strip_tags($request->school[$key]);
                if(isset($request->marks[$key])) 
                $acedmc['marks'] = strip_tags($request->marks[$key]);
                if(isset($request->yearofpassing[$key])) 
                $acedmc['yearofpassing'] = strip_tags($request->yearofpassing[$key]);
                Acedemic::create($acedmc);
            }
        }
        /** foreach for workexp **/
        $total_experience = 0;
        if(!empty($request->startdate))
        {
        Workexp::where('personalinfo_id', $data->id)->delete();
        foreach ($request->startdate as $key => $course) {
            $total_experience += $request->experience[$key]?$request->experience[$key]:'';
            $wexp['user_id']       = Auth::user()->id;
            $wexp['personalinfo_id'] = $data->id;
            if(isset($request->startdate[$key]))
            $wexp['startdate'] = $request->startdate[$key];
            if(isset($request->enddate[$key]))
            $wexp['enddate'] = $request->enddate[$key];
            if(isset($request->work_city[$key]))
            $wexp['city'] = $request->work_city[$key];
            if(isset($request->work_state[$key]))
            $wexp['state'] = $request->work_state[$key];
            if(isset($request->jobtitle[$key]))
            $wexp['jobtitle'] = $request->jobtitle[$key];
            if(isset($request->employer[$key]))
            $wexp['employer'] = $request->employer[$key];
            if(isset($request->experience[$key]))
            $wexp['experience'] = $request->experience[$key];
            Workexp::create($wexp);
            }
        }

        /** foreach for project **/
        if(!empty($request->projecttitle))
        {
        Project::where('personalinfo_id', $data->id)->delete();
        foreach ($request->projecttitle as $key => $course) {
            $projects['user_id'] = Auth::user()->id;
            $projects['personalinfo_id'] = $data->id;
            if(isset($request->projecttitle[$key]))
            $projects['projecttitle'] = strip_tags($request->projecttitle[$key]);
            if(isset($request->role[$key]))
            $projects['role'] = strip_tags($request->role[$key]);
            if(isset($request->description[$key]))
            $projects['description'] = strip_tags($request->description[$key]);
            Project::create($projects);
            }
        }

        if($total_experience > 0){
            $exp['total_experience'] = $total_experience;
            Personalinfo::where('id', $data->id)->update($exp);
        }
        
        Session::flash('success', __('Resume edit successfully'));
        return response()->json(array('Update Resume Details' => $data), 200);
    }

    public function get_state_city()
    {
        $datas['countries'] = Country::all();

        $datas['state'] = State::all();

        $datas['city'] = City::all();

        $datas['jobcategory'] = Jobcategory::all();
        return response()->json(array('Data' => $datas), 200);
    }

    public function viewResumeDetails(Request $request, $id)
    {
        //return $request->id;
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
       
        $persoanl = Personalinfo::where('user_id', $request->id)->first();
        $result['id'] = $persoanl->id ?? 0;
        $result['user_id'] = $request->id;
        $result['job_category_id'] = $persoanl->job_category_id ?? '';
        $result['fname'] = $persoanl->fname ?? '';
        $result['lname'] = $persoanl->lname ?? '';
        $result['profession'] = $persoanl->profession ?? '';
        $result['working_at'] = $persoanl->working_at ?? '';
        $result['country'] = $persoanl->country ?? '';
        $result['country_name'] = $persoanl->user->country->name ?? '';
        $result['state'] = $persoanl->state ?? '';
        $result['state_name'] = $persoanl->user->state->name ?? '';
        $result['city'] = $persoanl->city ?? '';
        $result['city_name'] = $persoanl->user->city->name ?? '';
        $result['pin'] = $persoanl->pin ?? '';
        $result['dob'] = $persoanl->dob ?? '';
        if(isset($persoanl->image))
        $result['image'] = url('files/resume/'.$persoanl->image);
        $result['keyword'] = $persoanl->keyword ?? '';
        $result['experience'] = $persoanl->experience ?? '';
        $result['salary'] = $persoanl->salary ?? '';
        $result['shift'] = $persoanl->shift ?? '';
        $result['address'] = $persoanl->address ?? '';
        $result['phone'] = $persoanl->phone ?? '';
        $result['email'] = $persoanl->email ?? '';
        $result['skill'] = $persoanl->skill ?? '';
        $result['skill_LMS'] = $persoanl->skill_LMS ?? '';
        $result['strength'] = $persoanl->strength ?? '';        
        $result['interest'] = $persoanl->interest ?? '';
        $result['objective'] = $persoanl->objective ?? '';
        $result['language'] = $persoanl->language ?? '';
        $result['english_lavel'] = $persoanl->english_lavel ?? '';
        $result['job_radius'] = $persoanl->job_radius ?? '';
        $result['status'] = $persoanl->status ?? '';
        $result['verified'] = $persoanl->verified ?? '';
        $result['message'] = $persoanl->message ?? '';
        $result['gender'] = $persoanl->gender ?? '';
        $result['created_at'] = $persoanl->created_at ?? '';
        $result['updated_at'] = $persoanl->updated_at ?? '';


        
        $works = Workexp::where('user_id', $request->id)->get();
        $education = Acedemic::where('user_id', $request->id)->get();
        $project = Project::where('user_id', $request->id)->get();
        $skill = Skill::where('personalinfo_id', $request->id)->get();
        return response()->json(array('Data' => array('persoanl' => $result, "works" => $works, "education" => $education, "project" => $project , "skill" => $skill)), 200);
            
        }


    public function createPostJob(Request $request)
    {
        $request->validate([
            'companyname' => 'required',
            'title' => 'required',
            'description' => 'required',
            'experience' => 'required',
            'minexp' => 'required',
            'maxexp' => 'required',
            'location' => 'required',
            'requirement' => 'required',
            'role' => 'required',
            'industry_type' => 'required',
            'employment_type' => 'required',
            'skills' => 'required',
        ]);

        $job['user_id'] = Auth::user()->id;
        $job['companyname'] = strip_tags($request->companyname);
        $job['title'] = strip_tags($request->title);
        $job['description'] = clean($request->description);
        $job['experience'] = strip_tags($request->experience);
        $job['min_experience'] = strip_tags($request->minexp);
        $job['max_experience'] = strip_tags($request->maxexp);
        $job['location'] = strip_tags($request->location);
        $job['requirement'] = strip_tags($request->requirement);
        $job['role'] = strip_tags($request->role);
        $job['industry_type'] = strip_tags($request->industry_type);
        $job['employment_type'] = strip_tags($request->employment_type);
        $job['salary'] = strip_tags($request->salary);
        $job['min_salary'] = strip_tags($request->minsalary);
        $job['max_salary'] = strip_tags($request->maxsalary);
        $job['skills'] = strip_tags($request->skills);

        if ($file = $request->file('image')) {

            $validator = Validator::make(
                [
                    'file' => strip_tags($request->image),
                    'extension' => strtolower($request->image->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required',
                    'extension' => 'required|in:jpg,png',
                ]
            );

            if ($validator->fails()) {
                return back()->withErrors(__('Invalid file !'));
            }

            if ($file = $request->file('image')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('files/job', $name);
                $job['image'] = $name;
            }
        }

        Postjob::create($job);
        $data=Postjob::create($job);
        return response()->json(array('Create Resume Details' => $data), 200);
    }

    public function JobList(Request $request, $id)
    {
        return $request;
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $jobs = Postjob::where('user_id', $id)->get();
        return response()->json(array("Posted Jobs" => $jobs), 200);
    }

    public function updateJobList(Request $request, $id)
    {
        $request->validate([
            'companyname' => 'required',
            'title' => 'required',
            'description' => 'required',
            'experience' => 'required',
            'minexp' => 'required',
            'maxexp' => 'required',
            'location' => 'required',
            'requirement' => 'required',
            'role' => 'required',
            'industry_type' => 'required',
            'employment_type' => 'required',
            'skills' => 'required',
        ]);

        $data = Postjob::where('id', $id)->first();
        $job['user_id'] = Auth::user()->id;
        $job['companyname'] = strip_tags($request->companyname);
        $job['title'] = strip_tags($request->title);
        $job['description'] = clean($request->description);
        $job['experience'] = strip_tags($request->experience);
        $job['min_experience'] = strip_tags($request->minexp);
        $job['max_experience'] = strip_tags($request->maxexp);
        $job['years'] = strip_tags($request->years);
        $job['location'] = strip_tags($request->location);
        $job['requirement'] = strip_tags($request->requirement);
        $job['role'] = strip_tags($request->role);
        $job['industry_type'] = strip_tags($request->industry_type);
        $job['employment_type'] = strip_tags($request->employment_type);
        $job['salary'] = strip_tags($request->salary);
        $job['min_salary'] = strip_tags($request->minsalary);
        $job['max_salary'] = strip_tags($request->maxsalary);
        $job['skills'] = strip_tags($request->skills);

        if ($file = $request->file('image')) {

            $validator = Validator::make(
                [
                    'file' => strip_tags($request->image),
                    'extension' => strtolower($request->image->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required',
                    'extension' => 'required|in:jpg,png',
                ]
            );

            if ($validator->fails()) {
                return back()->withErrors(__('Invalid file !'));
            }

            if ($file = $request->file('image')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('files/job', $name);
                $job['image'] = $name;
            }
        }
        
        $data->update($job);
        // Session::flash('success', __('Job update successfully'));
        return response()->json(array("Update Posted Jobs" => $data), 200);

    }


    public function Jobview(Request $request, $jobid)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $jobs = Postjob::where('id', $jobid)->get();
       // $job = Postjob::findorfail($jobid);
        return response()->json(array("view Jobs" => $jobs), 200);
    }

    public function jobdestroy(Request $request,$id)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);


        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $job = Postjob::where('id', $id)->first();
        if(!empty($job)){
            $job->postjob()->delete();
            $job->delete();
            return response()->json(['message' => 'Delete Successfully', 'status' => 'success']);
        }else{
            return response()->json(['message' => 'data not found', 'status' => 'fail']);  
        }    
    }


    public function userstatus(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);


        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::user();

        $job = Postjob::where('id', strip_tags($request->id))->where('user_id', $user->id)->first();
        if(!empty($job)){
            $job->status = strip_tags($request->status);
            $job->save();
            return response()->json(['message' => 'update status successfully', 'status' => 'success']);
        }else{
            return response()->json(['message' => 'data not found', 'status' => 'fail']);   
        }    
    }


    public function searchfind(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        
        /* Intitialize Query Builder */
        $postjob = Postjob::query();

        if ($request->search) {

            $result = $postjob->where("skills", "LIKE", '%' . strip_tags($request->search) . '%')
                ->orWhere("companyname", "LIKE", '%' . strip_tags($request->search) . '%')
                ->orWhere("title", "LIKE", '%' . strip_tags($request->search) . '%');

        } else {
            $result = $postjob->where('status', '1')
                ->where('approved', '1')
                ->orderBy('id', 'DESC');
        }
        
            $result = $postjob->paginate(10);
          return response()->json(array("List of Jobs" => $result), 200);
   
    }

    public function locationfilter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        
        if ($request->location) {

            $result = Postjob::whereIN('location', $request->location)
                ->where('status', '1')
                ->where('approved', '1')
                ->paginate(10);

        } else {
            $result = Postjob::where('status', '1')
                ->where('approved', '1')
                ->paginate(10);

        }
      
        return response()->json(array("List of Jobs" => $result), 200);
    }

    public function allcompanylist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        
        $result = Postjob::select('companyname')->distinct()->get();
       
      
        return response()->json(array("List of Company" => $result), 200);
    }


    public function allcountrystatelist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        
        $result = Postjob::select('location')->distinct()->where('status', '1')
        ->where('approved', '1')->get();
       
        return response()->json(array("List of Countrystates" => $result), 200);
    }

    public function viewjobcreatedbyuser(Request $request, $jobid)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
        $user = Auth::user();

        $jobs = Postjob::where('id', $jobid)->where('user_id', $user->id)->get();
       // $job = Postjob::findorfail($jobid);
        return response()->json(array("view Jobs" => $jobs), 200);
    }

    public function applyJobs(Request $request,$jobid)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
            'skills' => 'required',
            'experience' => 'required',
            'years' => 'required',

        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
            if($errors->first('skills')){
                return response()->json(['message' => $errors->first('skills'), 'status' => 'fail']);
            }
            if($errors->first('experiense')){
                return response()->json(['message' => $errors->first('experiense'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }


        $applyjob['skills'] = strip_tags($request->skills);
        $applyjob['experience'] = strip_tags($request->experience);
        $applyjob['years'] = strip_tags($request->years);
        $applyjob['job_id'] = $jobid;
        $applyjob['user_id'] = Auth::user()->id;

        if ($file = $request->file('pdf')) {

            $validator = Validator::make(
                [
                    'file' => strip_tags($request->pdf),
                    'extension' => strtolower($request->pdf->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required',
                    'extension' => 'required|in:pdf',
                ]
            );

            if ($validator->fails()) {
                return back()->withErrors(__('Invalid file !'));
            }

            if ($file = $request->file('pdf')) {
                $name = time() . $file->getClientOriginalName();
                $file->move('files/applyjob', $name);
                $applyjob['pdf'] = $name;
            }
        }


        $applyjobs= Applyjob::create($applyjob);
        return response()->json(array("List of Apply Jobs" => $applyjobs), 200);
    }


     /**
     *  This function holds the functionality to  apply for job delete.
     *  @return response true
     *  @param $id
     */
    public function applyjobdestroy(Request $request,$id)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);


        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

       // Applyjob::where('id', $id)->delete();
        $user = Auth::user();
        $desjob = Applyjob::where('id', $id)->where('user_id',$user->id)->first();
        if(!empty($desjob)){
            $desjob->postjob()->delete();
            $desjob->delete();
            return response()->json(['message' => 'Delete Successfully', 'status' => 'success']);
        }else{
            return response()->json(['message' => 'data not found', 'status' => 'fail']);  
        }  
        
    }


    public function applyjoblist(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);


        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

       // Applyjob::where('id', $id)->delete();
        $user = Auth::user();
        $applyjob = Applyjob::where('user_id',$user->id)->get();
        if(!empty($applyjob)){
            return response()->json(array("List of apply jobs" => $applyjob), 200);
        }else{
            return response()->json(['message' => 'data not found', 'status' => 'fail']);  
        }  
        
    }
    public function Alljobs(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }
                $user = Auth::user();

        $jobs = Postjob::where('status', 1)->get();
        $result = array();

        foreach ($jobs as $data) {

            $result[] = array(
                'id' => $data->id,
                'user_id' => $data->user_id,
                'user_name' => $data->user->fname,
                'companyname' => $data->companyname,
                'jobtitle' => $data->jobtitle,
                'job_type' => $data->job_type,
                'job_categories'=>$data->job_categories,
                'jobskill'=>$data->jobskill,
                'industries' => $data->industries,
                'country_id' => $data->country_id,
                'country_name'=>$data->country->name,
                'state_id' => $data->state_id,
                'state_name'=>$data->state->name,
                'city_id' => $data->city_id,
                'city_name'=>$data->city->name,
                'address' => $data->address,
                'detail' => $data->detail,
                'description'=>$data->description,
                'industry_type'=>$data->industry_type,
                'employment_type' => $data->employment_type,
                'image' => url('files/job/'.$data->image),
                'min_salary' => $data->min_salary,
                'max_salary' => $data->max_salary,
                'salary' => $data->salary,
                'job_shift' => $data->job_shift,
                'application_form'=>$data->application_form,
                'fee_changed'=>$data->fee_changed,
                'incentive' => $data->incentive,
                'functionalareas' => $data->functionalareas,
                'careerlevel' => $data->careerlevel,
                'min_edu' => $data->min_edu,
                'english_level' => $data->english_level,
                'language' => $data->language,
                'gender'=>$data->gender,
                'exp'=>$data->exp,
                'marital_status'=>$data->marital_status,
                'vehical' => $data->vehical,
                'driving_license' => $data->driving_license,
                'functional_area' => $data->functional_area,
                'career_level' => $data->career_level,
                'industry' => $data->industry,
                'degree_level' => $data->degree_level,
                'major_subjects'=>$data->major_subjects,
                'result_type'=>$data->result_type,
                'pdf' => $data->pdf,
                'message' => $data->message,
                'varified' => $data->varified,
                'status' => $data->status,
                'approved' => $data->approved,
                'location' => $data->location,
                'is_plan'=>$data->is_plan,
                'opening'=>$data->opening,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('Job'=>$result));  
    }
    
    public function progress_report()
    {
        $user = User::all();
        $datas = [];
        foreach ($user as $key => $value) {
            $data['id'] = $value->id;
            $data['name'] = $value->fname.' '.$value->lname;
            $data['image'] =  url('images/user_img/'.$value->user_img);
            array_push($datas, $data);
        }
        return response()->json(array("Progress report" => $datas), 200);
    }
    
    public function progress_report_view($id)
    {
        $progress = CourseProgress::where('user_id',$id)->get();
        $datas = [];
        foreach($progress as $key => $item){
            if(isset($item->all_chapter_id) && isset($item->mark_chapter_id)){
                $total_class = $item->all_chapter_id;
                $total_count = count($total_class);
                $total_per = 100;
                $read_class = $item->mark_chapter_id;
                $read_count =  count($read_class);
                $progres_total = ($read_count/$total_count) * 100;
            } else {
                $progres_total = 0;
            }

            if(isset($item->course_id)){
                $data['id'] = $item->id;
                $data['user'] = $item->user->fname;
                $data['courses'] = $item->courses->title;
                $data['courses_user_id'] = $item->courses->user_id;
                $data['progress'] = $progres_total;
                array_push($datas, $data);
            }
        }

        return response()->json(array("Progress report View" => $datas), 200);
    }
    
    public function payment_setting(Request $request)
    {
        if($request->user_id && $request->type){
            $user = User::where('id', $request->user_id)->first();

            if($request->type == "paytm")
            {
                $user->paytm_mobile = $request->paytm_mobile;
                $user->prefer_pay_method = "paytm";
            }
    
            if($request->type == "paypal")
            {
                $user->paypal_email = $request->paypal_email;
                $user->prefer_pay_method = "paypal";
            }
    
            if($request->type == "bank")
            {
                $user->bank_acc_name = $request->bank_acc_name;
                $user->bank_acc_no = $request->bank_acc_no;
                $user->ifsc_code = $request->ifsc_code;
                $user->bank_name = $request->bank_name;
                $user->prefer_pay_method = "banktransfer";
            }        
    
            $user->save();
            return response()->json(array("Updated Successfully" => $user), 200);
        } else {
            return response()->json(['message' => 'Please pass required field', 'status' => 'fail']); 
        }

    }

    public function userenroll($user_id)
    {
        $orders = Order::where('instructor_id',$user_id)->get();
        // return count($orders);
        $datas = [];
        foreach ($orders as $key => $order) {
            $data['id'] = $order->id;
            $data['course_id'] = $order->course_id;
            $data['course_tittle'] = Course::whereId($order->course_id)->value('title');
            $data['user_id'] = $order->user_id;
            $data['user'] = User::whereId($order->user_id)->value('fname').' '.User::whereId($order->user_id)->value('lname');
            $data['order_id'] = $order->order_id;
            $data['transaction_id'] = $order->transaction_id;
            $data['payment_method'] = $order->payment_method;
            $data['total_amount'] = $order->total_amount;
            $data['coupon_discount'] = $order->coupon_discount;
            $data['currency'] = $order->currency;
            $data['currency_icon'] = $order->currency_icon;
            $data['status'] = $order->status;
            $data['duration'] = $order->duration;
            $data['duration_type'] = $order->duration_type;
            $data['enroll_start'] = $order->enroll_start;
            $data['enroll_expire'] = $order->enroll_expire;
            $data['instructor_revenue'] = $order->instructor_revenue;
            $data['bundle_id'] = $order->bundle_id;
            $data['proof'] = $order->proof;
            $data['sale_id'] = $order->sale_id;
            $data['price_id'] = $order->price_id;
            $data['subscription_id'] = $order->subscription_id;
            $data['customer_id'] = $order->customer_id;
            $data['subscription_status'] = $order->subscription_status;
            $data['refunded'] = $order->refunded;
            array_push($datas, $data);
        }

        if(!empty($datas)){
            return response()->json(array("Enroll Users" => $datas), 200);
        }else{
            return response()->json(['message' => 'No any enroll users', 'status' => 'fail']);  
        } 
    }
    
    // public function view_order($id)
    // {
    //     $data['setting'] = Setting::first();
    //     $data['order'] = DB::table('orders')
    //                         ->leftjoin('bundle_courses', 'orders.bundle_id', '=', 'bundle_courses.id')
    //                         ->where('orders.id', $id)
    //                         ->get();

    //     if(!empty($data)){
    //         return response()->json(array("Order view" => $data), 200);
    //     }else{
    //         return response()->json(['message' => 'data not found', 'status' => 'fail']);  
    //     }
    // }
    
    public function delete_order($id)
    {
        if(DB::table('orders')->where('id',$id)->exists()) {
            DB::table('orders')->where('id',$id)->delete();
            DB::table('pending_payouts')->where('order_id',$id)->delete();
            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "record not found"
            ], 404);
        }
    }
    
    public function refund_order()
    {
        $refunds = DB::table('refund_courses')
                    ->leftjoin('courses', 'refund_courses.course_id', '=', 'courses.id')
                    ->leftjoin('users', 'refund_courses.user_id', '=', 'users.id')
                    ->get();
        if(isset($refunds)){
            return response()->json(array("Refund Orders" => $refunds), 200);
        }else{
            return response()->json(['message' => 'No any refund orders', 'status' => 'fail']);  
        } 
    }
    
    public function users()
    {
        $users = User::all();
        if(isset($users)){
            return response()->json(array("Users" => $users), 200);
        }else{
            return response()->json(['message' => 'No any users', 'status' => 'fail']);  
        } 
    }
    
    public function get_bundle()
    {
        $bundles = BundleCourse::get();
        $datas = [];
        foreach ($bundles as $key => $value) {
            $data['id'] = $value->id;
            $data['user_id'] = $value->user_id;
            $data['course_id'] = $value->course_id;
            $data['title'] = $value->title;
            $data['detail'] = strip_tags($value->detail);
            $data['price'] = $value->price;
            $data['discount_price'] = $value->discount_price;
            $data['type'] = $value->type;
            $data['slug'] = $value->slug;
            $data['status'] = $value->status;
            $data['featured'] = $value->featured;
            $data['preview_image'] =  url('images/bundle/'.$value->preview_image);
            $data['billing_interval'] = $value->billing_interval;
            $data['price_id'] = $value->price_id;
            $data['product_id'] = $value->product_id;
            $data['subscription_mode'] = $value->subscription_mode;
            $data['is_subscription_enabled'] = $value->is_subscription_enabled;
            $data['duration'] = $value->duration;
            $data['duration_type'] = $value->duration_type;
            $data['short_detail'] = $value->short_detail;
            array_push($datas, $data);
        }
        if(isset($datas)){
            return response()->json(array("Bundle" => $datas), 200);
        }else{
            return response()->json(['message' => 'No any bundle', 'status' => 'fail']);  
        } 
    }
    
    public function get_cource_bundle_by_user($user_id)
    {
        $orders = Order::where('user_id', $user_id)->get();
        $enrolledCourses = [];
        $enrolledBundles = [];

        $enrolledCourseIds = [];
        $enrolledBundleIds = [];

        foreach ($orders as $order) {
            if ($order->course_id !== null) {
                array_push($enrolledCourseIds, $order->course_id);
                array_push($enrolledCourses, $order->courses);
            } else {
                array_push($enrolledBundleIds, $order->bundle_id);
                array_push($enrolledBundles, $order->bundle);
            }
        }

        $data['courses'] = $enrolledCourses;
        $data['bundles'] = $enrolledBundles;

        if(isset($data)){
            return response()->json(array("User Bundle and Cource" => $data), 200);
        }else{
            return response()->json(['message' => 'No any bundle and cource', 'status' => 'fail']);  
        } 
    }
    
    public function create_enroll(Request $request)
    {
        if(isset($request->bundle_id) || isset($request->course_id)){
            if (isset($request->bundle_id)) {
                $selectedBundle = BundleCourse::findOrFail($request->bundle_id);
                if($selectedBundle->is_subscription_enabled) {
                    $subscription_status = 'active';
                }
    
                $bundle = BundleCourse::where('id', $request->bundle_id)->first();
    
                $created = Order::create([
                    'bundle_id' => $request->bundle_id,
                    'user_id' => $request->user_id,
                    'instructor_id' => $bundle->user_id,
                    'subscription_status'=>$subscription_status,
                    'payment_method' => 'Admin Enroll',
                    'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                ]);
            }
    
            if (isset($request->course_id)) {
    
                $course = Course::where('id', $request->course_id)->first();
    
                $created = Order::create([
                    'course_id' => $request->course_id,
                    'user_id' => $request->user_id,
                    'instructor_id' => $course->user_id,
                    'payment_method' => 'Admin Enroll',
                    'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                ]);
            }
            if(isset($created)){
                return response()->json(array("order created successful" => $created), 200);
            }else{
                return response()->json(['message' => 'data not found', 'status' => 'fail']);  
            }
        } else {
            return response()->json(['message' => 'Please pass required field', 'status' => 'fail']);
        }
    }
    
    public function pending_payout()
    {
        $payout = PendingPayout::where('user_id', Auth::User()->id)->where('status', '0')->get();
        if(isset($payout)){
            $result = array();

        foreach ($payout as $data) {

            $result[] = array(
                'id' => $data->id,
                'user_id' => $data->user_id,
                'user_name' => $data->user->fname,
                'course_id' => $data->course_id,
                'course_name' => $data->courses->title,
                'order_id' => $data->order_id,
                'transaction_id' => $data->transaction_id,
                'total_amount' => $data->total_amount,
                'instructor_revenue' => $data->instructor_revenue,
                'currency'=> $data->currency,
                'currency_icon'=>$data->currency_icon,
                'status'=> $data->status,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('payout'=>$result), 200); 

        }else{
            return response()->json(['message' => 'data not found', 'status' => 'fail']);  
        }       
    }
    
    public function complete_payout()
    {
        //return $auth = Auth::User()->id;
        $payout = CompletedPayout::where('user_id', Auth::User()->id)->get();
        if(isset($payout)){
               $result = array();

        foreach ($payout as $data) {

            $result[] = array(
                'id' => $data->id,
                'user_id' => $data->user_id,
                'user_name' => $data->user->fname,
                'payer_id' => $data->payer_id,
                'pay_total' => $data->pay_total,
                'order_id' => $data->order_id,
                'payment_method' => $data->payment_method,
                'pay_status' => $data->pay_status,
                'currency'=> $data->currency,
                'currency_icon'=>$data->currency_icon,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('completed'=>$result), 200); 
        }else{
            return response()->json(['message' => 'data not found', 'status' => 'fail']);  
        } 
    }
    public function seekercondition(Request $request){
          $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);


        if ($validator->fails()) {

            $errors = $validator->errors();

            if($errors->first('secret')){
                return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !']);
        }

        $user = Auth::user();
        $applyjob = Applyjob::where('user_id',$user->id)->get();
        if(!empty($applyjob)){
            return response()->json(array("List of apply jobs" => $applyjob), 200);
        }else{
            return response()->json(['message' => 'data not found', 'status' => 'fail']);  
        }  
    }
    public function vieworder(Request $request,$id){
        
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }

        if (Order::where('id', $id)->exists()) {
            $data = Order::where('id', $id)->first();

            $result = array();

            $result[] = array(
                'id' => $data->id,
                'course_id' => $data->course_id,
                'course_name' => $data->courses->title,
                'user_id' => $data->user_id,
                'user_name' => $data->user->fname,
                'email'=> $data->email,
                'currency' => $data->currency,
                'currency_icon' => $data->currency_icon,
                'total_amount' => $data->total_amount,
                'address' => $data->user->address,
                'country' => $data->user->country->name,
                'state' => $data->user->state->name,
                'mobile' => $data->user->mobile,
                'lname' => $data->user->lname,
                'order_id' => $data->order_id,
            'transaction_id' => $data->transaction_id,
            'payment_method' => $data->payment_method,
            'total_amount' => $data->total_amount,
            'coupon_discount' => $data->coupon_discount,
            'currency' => $data->currency,
            'currency_icon' => $data->currency_icon,
            'status' => $data->status,
            'duration' => $data->duration,
            'duration_type' => $data->duration_type,
            'enroll_start' => $data->enroll_start,
            'enroll_expire' => $data->enroll_expire,
            'instructor_revenue' => $data->instructor_revenue,
            'bundle_id' => $data->bundle_id,
            'proof' => $data->proof,
            'sale_id' => $data->sale_id,
            'price_id' => $data->price_id,
            'subscription_id' => $data->subscription_id,
            'customer_id' => $data->customer_id,
            'subscription_status' => $data->subscription_status,
            'refunded' => $data->refunded,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
            return response()->json(array('data'=>$result), 200);
        } else {
            return response()->json([
              "message" => "data not found"
            ], 404);
        }
    }
    public function pendingdelete(Request $request, $id){
        
        $validator = Validator::make($request->all(), [
            'secret' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['Secret Key is required'], 402);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['Invalid Secret Key !'], 400);
        }
        
        if(PendingPayout::where('id', $id)->exists()) {
            $data = PendingPayout::find($id);

            $data->delete();

            return response()->json([
              "message" => "records deleted"
            ]);

        } else {
            return response()->json([
              "message" => "PendingPayout not found"
            ], 404);
        }
    }
    public function completeview($id){
        $payout = CompletedPayout::where('id', $id)->get();
        if(isset($payout)){
               $result = array();

        foreach ($payout as $data) {

            $result[] = array(
                'id' => $data->id,
                'user_id' => $data->user_id,
                'user_name' => $data->user->fname,
                'lname' => $data->user->lname,
                'payer_id' => $data->payer_id,
                'pay_total' => $data->pay_total,
                'order_id' => $data->order_id,
                 'address' => $data->user->address,
                'country' => $data->user->country->name,
                'state' => $data->user->state->name,
                'mobile' => $data->user->mobile,
                'payment_method' => $data->payment_method,
                'pay_status' => $data->pay_status,
                'currency'=> $data->currency,
                'currency_icon'=>$data->currency_icon,
                'date'=>Carbon::now(),
                'email'=>$data->user->email,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            );
        }

        return response()->json(array('completed'=>$result), 200); 
        }else{
            return response()->json(['message' => 'data not found', 'status' => 'fail']);  
        } 
    }
    public function seekerpackage(Request $request){
        $validator = Validator::make($request->all(), [
               'secret' => 'required',
           ]);
   
           if ($validator->fails()) {
               return response()->json(['Secret Key is required'], 402);
           }
   
           $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
   
           if (!$key) {
               return response()->json(['Invalid Secret Key !'], 400);
           }
   
            $package = SeekarPackage::get();
   
   
           $result = array();
   
           foreach ($package as $data) {
   
               $result[] = array(
                   'id' => $data->id,
                   'package_name' => $data->package_name,
                   'detail'=>$data->detail,
                   'duration_type' => $data->duration_type,
                   'duration' => $data->duration,
                     'price'=>$data->price,
                     'type'=>$data->type,
                     'discount_price'=>$data->discount_price,
                     'apply_job'=>$data->apply_job,
                     'status'=>$data->status,
                   'created_at' => $data->created_at,
                   'updated_at' => $data->updated_at,
               );
           }
   
           return response()->json(array('seekerpackage'=>$result));
   }    
       public function condition(Request $request){
           //return 'x';
             $validator = Validator::make($request->all(), [
               'secret' => 'required',
           ]);
   
   
           if ($validator->fails()) {
   
               $errors = $validator->errors();
   
               if($errors->first('secret')){
                   return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
               }
           }
   
           $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
   
           if (!$key) {
               return response()->json(['Invalid Secret Key !']);
           }
   
       
           $cource_package = Order::where('user_id', Auth::user()->id)->whereDate('enroll_start','<=', date('Y-m-d'))->whereDate('enroll_expire','>=', date('Y-m-d'))->first();
           if(isset($cource_package)){
               return response()->json(['course' => 'purchased', 'status' => 'success']);
           }else{
               return response()->json(['course' => 'unpurchased', 'status' => 'fail']);  
           }  
       }
       public function jobreport(Request $request){
            $validator = Validator::make($request->all(), [
               'secret' => 'required',
           ]);
           if ($validator->fails()) {
   
               $errors = $validator->errors();
   
               if($errors->first('secret')){
                   return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
               }
           }
   
           $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
   
           if (!$key) {
               return response()->json(['Invalid Secret Key !']);
           }
   
           $auth = Auth::user();
           $cource_package = Payment::where('user_id',$auth->id)->get();
           if(isset($cource_package)){
               $result = array();
   
           foreach ($cource_package as $data) {
   
               $result[] = array(
                   'id' => $data->id,
                   'user_id' => $data->user_id,
                   'user_name'=>$data->user->fname,
                   'seekar_package_id' => $data->seekar_package_id,
                   'transaction_id' => $data->transaction_id,
                     'order_id'=>$data->order_id,
                     'total_amount'=>$data->total_amount,
                     'currency'=>$data->currency,
                     'currency_icon'=>$data->currency_icon,
                        'duration'=>$data->duration,
                     'duration_type'=>$data->duration_type,
                     'enroll_start'=>$data->enroll_start,
                     'enroll_expire'=>$data->enroll_expire,
                     'job_allowed'=>$data->job_allowed,
                     'payment_method'=>$data->payment_method,
                   'created_at' => $data->created_at,
                   'updated_at' => $data->updated_at,
               );
           }
           return response()->json(array('course_package'=>$result));
           }else{
                   return response()->json('Course can not be purchased', 201);
           }  
       }
       public function seekerpurchase(Request $request,$id){
          
           $user = Auth::user();
           $carts = SeekarPackage::where('id', $request->id)->first();
   
           $currency = Currency::where('default', '=', '1')->first();
           $created_order = new Payment;
           $created_order->seekar_package_id = $request->id;
           $created_order->user_id = $user->id;
           $created_order->order_id = $request->order_id;
           $created_order->transaction_id = $request->transaction_id;
           $created_order->payment_method = $request->payment_method;
           $created_order->total_amount = $request->total_amount;
           $created_order->currency = $request->currency;
           $created_order->duration_type = $carts['duration_type'];
           $created_order->duration = $carts['duration'];
            if($created_order->duration_type == 1)
               {
                   //return 'x';
                 $days = $created_order->duration * 30;
                         $todayDate = date('Y-m-d');
                         $sum_date= $days;
                         $expireDate = date("Y-m-d", strtotime("+ $days day"));
                     }
               
               else
               {
                   //return 'y';
                 $created_order->duration_type = 0 ;
                 $todayDate = 'Null';
                 $expireDate = 'Null';
               }
           $created_order->enroll_start = $todayDate;
           $created_order->enroll_expire = $expireDate;
           $created_order->currency_icon = $currency->currency_icon;
           $created_order->save();
   
           return response()->json([
               "message" => "ordered successfully",
               'order'=>$created_order
           ]);
       }
       public function resumedownload(Request $request, $id){
           
           $personal = Personalinfo::first();
           $works = Workexp::where('personalinfo_id', $request->id)->get();
           $educations = Acedemic::where('personalinfo_id', $request->id)->get();
           $projects = Project::where('personalinfo_id', $request->id)->get();
           $skill = Skill::where('personalinfo_id', $request->id)->get();
           $pdf = PDF::loadView('resume::front.download', compact('personal', 'projects', 'works','educations','skill'));
           
           
            //$pdf->save(storage_path().'/pdf/certificate.pdf');
           
           return $pdf->download('resume.pdf');
       }
       public function userverification(Request $request, $id){
        $validator = Validator::make($request->all(), [
           'secret' => 'required',
       ]);
       if ($validator->fails()) {

           $errors = $validator->errors();

           if($errors->first('secret')){
               return response()->json(['message' => $errors->first('secret'), 'status' => 'fail']);
           }
       }

       $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

       if (!$key) {
           return response()->json(['Invalid Secret Key !']);
       }

       $auth = Auth::user();
       $user = User::where('id',$id)->get();
       if(isset($user)){
           $result = array();

       foreach ($user as $data) {

           $result[] = array(
               'id' => $data->id,
               'user_id' => $data->user_id,
               'user_name'=>$data->fname,
               'voter_ID' => $data->voter_ID,
               'aadhar_noaadhar_no' => $data->aadhar_no,
                 'driving_licence'=>$data->driving_licence,
                 'voter_ID_doc_image'=> url('images/user_img/'.$data->voter_ID_doc_image),
                 'aadhar_doc_image'=> url('images/user_img/'.$data->aadhar_doc_image),
                 'driving_licence_document_image'=> url('images/user_img/'.$data->driving_licence_document_image),
                 'is_verify'=> $data->is_verify,
               'created_at' => $data->created_at,
               'updated_at' => $data->updated_at,
           );
       }
       return response()->json(array('user'=>$result));
       }else{
               return response()->json('User can not be found', 201);
       }  
   }
       public function updateuserverification(Request $request, $id)
       {
           $validator = Validator::make($request->all(), [
             'secret' => 'required',
           ]);
   
           if ($validator->fails()) {
               return response()->json(['Secret Key is required'], 402);
           }
   
           $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();
   
           if (!$key) {
               return response()->json(['Invalid Secret Key !'], 400);
           }
           
           if (User::where('id', $id)->exists()) {
               $user = User::find($id);
   
               if($file = $request->file('voter_ID_doc_image'))
               {
   
                   $path = 'images/user_img/';
   
                   if(!file_exists(public_path().'/'.$path)) {
                       
                       $path = 'images/user_img/';
                       File::makeDirectory(public_path().'/'.$path,0777,true);
                   }   
   
                   if($user->voter_ID_doc_image != null) {
                       $content = @file_get_contents(public_path().'/images/user_img/'.$user->voter_ID_doc_image);
                       if ($content) {
                           unlink(public_path().'/images/user_img/'.$user->voter_ID_doc_image);
                       }
                   }
                   
                   $optimizeImage = Image::make($file);
                   $optimizePath = public_path().'/images/user_img/';
                   $image = time().$file->getClientOriginalName();
                   $optimizeImage->save($optimizePath.$image, 72);
   
                   $user['voter_ID_doc_image'] = $image;
               }
               if($file = $request->file('aadhar_doc_image'))
               {
   
                   $path = 'images/user_img/';
   
                   if(!file_exists(public_path().'/'.$path)) {
                       
                       $path = 'images/user_img/';
                       File::makeDirectory(public_path().'/'.$path,0777,true);
                   }   
   
                   if($user->aadhar_doc_image != null) {
                       $content = @file_get_contents(public_path().'/images/user_img/'.$user->aadhar_doc_image);
                       if ($content) {
                           unlink(public_path().'/images/user_img/'.$user->aadhar_doc_image);
                       }
                   }
   
                   $optimizeImage = Image::make($file);
                   $optimizePath = public_path().'/images/user_img/';
                   $image = time().$file->getClientOriginalName();
                   $optimizeImage->save($optimizePath.$image, 72);
   
                   $user['aadhar_doc_image'] = $image;
               }
               if($file = $request->file('driving_licence_document_image'))
               {
   
                   $path = 'images/user_img/';
   
                   if(!file_exists(public_path().'/'.$path)) {
                       
                       $path = 'images/user_img/';
                       File::makeDirectory(public_path().'/'.$path,0777,true);
                   }   
   
                   if($user->driving_licence_document_image != null) {
                       $content = @file_get_contents(public_path().'/images/user_img/'.$user->driving_licence_document_image);
                       if ($content) {
                           unlink(public_path().'/images/user_img/'.$user->driving_licence_document_image);
                       }
                   }
   
                   $optimizeImage = Image::make($file);
                   $optimizePath = public_path().'/images/user_img/';
                   $image = time().$file->getClientOriginalName();
                   $optimizeImage->save($optimizePath.$image, 72);
   
                   $user['driving_licence_document_image'] = $image;
               }
   
               $user->voter_ID = isset($request->voter_ID) ? $request->voter_ID : $user->voter_ID;
               $user->aadhar_no = isset($request->aadhar_no) ? $request->aadhar_no : $user->aadhar_no;
               $user->driving_licence = isset($request->driving_licence	) ? $request->driving_licence : $user->driving_licence;
               $user->status = isset($request->status) ? $request->status : $user->status;
               
               $user->save();
   
           
   
               return response()->json([
                   "message" => "records updated successfully", 'user'=>$user
               ], 200);
   
               return response()->json(array('user'=>$user), 200);
           } else {
               return response()->json([
                   "message" => "User not found"
               ], 404);
           }
       }
       public function institueprofile(Request $request){
        $validator = Validator::make($request->all(), [
         'secret' => 'required',
     ]);

     if ($validator->fails()) {
         return response()->json(['Secret Key is required']);
     }

     $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

     if (!$key) {
         return response()->json(['Invalid Secret Key !']);
     }

     $data = Institute::where('status', 1)->get();
     
         $result = array();
     foreach ($data as $institute) {

         $result[] = array(
             'id' => $institute->id,
             'title' => $institute->title,
             'detail' => $institute->detail,
             'image' =>  url('files/institute/'.$institute->image),
             'skill' => $institute->skill,
              'slug' => $institute->slug,
              'email' => $institute->email,
              'created_at' => $institute->created_at,
             'updated_at' => $institute->updated_at,
         );
     }

     return response()->json(array('institute' => $result), 200);
    }
     public function instituteslug(Request $request, $id){
     $validator = Validator::make($request->all(), [
         'secret' => 'required',
     ]);

     if ($validator->fails()) {
         return response()->json(['Secret Key is required']);
     }

     $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

     if (!$key) {
         return response()->json(['Invalid Secret Key !']);
     }

     $course = Course::where('institude_id',$id)->get();
     $institute = Institute::where('id',$id)->first();
     
         $result = array();
     

         $result[] = array(
             'id' => $institute->id,
             'title' => $institute->title,
             'detail' => $institute->detail,
             'image' =>  url('files/institute/'.$institute->image),
             'email' => $institute->email,
             'mobile' => $institute->mobile,
             'skill' => $institute->skill,
              'slug' => $institute->slug,
              'status' =>$institute->status,
              'verified' => $institute->verified,
              'affilated' =>$institute->affilated_by,
              'created_at' => $institute->created_at,
             'updated_at' => $institute->updated_at,
         );
         

     return response()->json(array('institute' => $result,'course' => $course), 200);
 }
 public function compareget(Request $request){
     
     $validator = Validator::make($request->all(), [
         'secret' => 'required',
     ]);

     if ($validator->fails()) {
         return response()->json(['Secret Key is required']);
     }

     $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

     if (!$key) {
         return response()->json(['Invalid Secret Key !']);
     }
     $compare = Compare::where('user_id', Auth::user()->id)->with('compares')->get();
     return response()->json(array('compare' => $compare), 200);
 }
 public function compareadd(Request $request){
      $validator = Validator::make($request->all(), [
         'secret' => 'required',
     ]);

     if ($validator->fails()) {
         return response()->json(['Secret Key is required'], 402);
     }

     $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

     if (!$key) {
         return response()->json(['Invalid Secret Key !'], 400);
     }

     $this->validate($request,[
         "user_id" => "required",
         "course_id" => "required",
     ]);

     $compare = new Compare;

     $compare->user_id =$request->user_id;
     $compare->course_id = $request->course_id;
     $compare->save();

     return response()->json([
         "message" => "Compare added"
     ], 200);
    }
 public function comparedestroy(Request $request, $id){
     $validator = Validator::make($request->all(), [
         'secret' => 'required',
     ]);

     if ($validator->fails()) {
         return response()->json(['Secret Key is required'], 402);
     }

     $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

     if (!$key) {
         return response()->json(['Invalid Secret Key !'], 400);
     }

     if(Compare::where('id', $id)->exists()) {
         $compare = Compare::find($id);
         $compare->delete();

         return response()->json([
           "message" => "records deleted"
         ]);

     } else {
         return response()->json([
           "message" => "Compare not found"
         ], 404);
     }
 }
 public function affilatedashboard(Request $request){
    $validator = Validator::make($request->all(), [
        'secret' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['Secret Key is required']);
    }

    $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

    if (!$key) {
        return response()->json(['Invalid Secret Key !']);
    }
     $user = auth()->user();
    $wallet = Wallet::where('user_id',$user->id)->value('balance');
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
    $path= url('/register') . '/?ref=' . Auth::user()->affiliate_id;

    return response()->json(array('wallet' => $wallet>0?$wallet:"0",'path' => $path), 200);
}
public function walletcheckout(Request $request){
    $validator = Validator::make($request->all(), [
        'secret' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['Secret Key is required'], 402);
    }

    $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

    if (!$key) {
        return response()->json(['Invalid Secret Key !'], 400);
    }

    $wallet_transaction = new WalletTransactions;
    $wallet_transaction->wallet_id = 1;
    $wallet_transaction->user_id = Auth::User()->id;
    $wallet_transaction->transaction_id = $request->transaction_id;
    $wallet_transaction->payment_method = $request->payment_method;
    $wallet_transaction->total_amount = $request->total_amount;
    $wallet_transaction->currency = $request->currency;
    $wallet_transaction->currency_icon = $request->currency_icon;
    $wallet_transaction->type = 'Credit';
    $wallet_transaction->detail = $request->detail;
     $wallet_transaction->save();
    
    $wallet = Wallet::where('user_id',Auth::User()->id)->first();
    
    

    if($wallet){
        $params['balance'] = $wallet->balance+$request->total_amount;
          
        $wallet->update($params);
    } else {
        $params['balance'] = $request->total_amount;
        $params['user_id'] = Auth::User()->id;
        $params['status'] = '1';
        Wallet::create($params);
    }
    return response()->json([
        "message" => "Wallet money added successfully"
    ], 200);
}
}