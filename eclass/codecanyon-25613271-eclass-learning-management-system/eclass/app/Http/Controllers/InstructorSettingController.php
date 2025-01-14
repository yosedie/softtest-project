<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InstructorSetting;
use App\User;
use Auth;
use App\Course;
use App\Googlemeet;
use App\JitsiMeeting;
use App\BBL;
use App\Meeting;
use Spatie\Permission\Models\Role;


class InstructorSettingController extends Controller
{
    
    public function __construct()
    {
    
        $this->middleware('permission:instructor-payout-setting.manage', ['only' => ['view','update']]);
       
    }
    public function view()
    {
    	$setting = InstructorSetting::first();
    	return view('admin.setting.instructor', compact('setting'));
    }

    public function update(Request $request)
    {

    	$setting = InstructorSetting::first();

        $input = $request->all();

        if(isset($setting))
        {

            if(isset($request->paytm_enable))
            {
                $input['paytm_enable'] = '1';
            }
            else
            {
                $input['paytm_enable'] = '0';
            }

            if(isset($request->paypal_enable))
            {
                $input['paypal_enable'] = '1';
            }
            else
            {
                $input['paypal_enable'] = '0';
            }

            if(isset($request->bank_enable))
            {
                $input['bank_enable'] = '1';
            }
            else
            {
                $input['bank_enable'] = '0';
            }

            $setting->update($input);
        }
        else
        {

            $data = InstructorSetting::create($input);

            if(isset($request->paytm_enable))
            {
              $data->paytm_enable = 1;
            }
            else
            {
              $data->paytm_enable = 0;
            }

            if(isset($request->paypal_enable))
            {
              $data->paypal_enable = 1;
            }
            else
            {
              $data->paypal_enable = 0;
            }

            if(isset($request->bank_enable))
            {
              $data->bank_enable = 1;
            }
            else
            {
              $data->bank_enable = 0;
            }
            $data->save();
        }

        
        return redirect()->route('instructor.settings')->with('success',trans('flash.UpdatedSuccessfully'));
    }


    public function instructor()
    {
        $user = User::where('id', Auth::User()->id)->first();
        return view('instructor.settings.pay_settings', compact('user'));
    }

    public function settings(Request $request, $id)
    {

        $user = User::where('id', $id)->first();

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
        return redirect()->route('instructor.pay')->with('success',trans('flash.UpdatedSuccessfully'));
    }

    public function instructorprofile($id)
    {

        $user = User::where('id', $id)->first();
        $course = Course::where('user_id', $user->id)->paginate(10);
        $live_1 = Meeting::where('user_id','=',$id)->count();
        $live_2 = Googlemeet::where('user_id','=',$id)->count();
        $live_3 = JitsiMeeting::where('user_id','=',$id)->count();
        $live_4 = BBL::where('instructor_id','=',$id)->count();
        $live_class = $live_1 + $live_2 + $live_3 + $live_4;
        return view('front.instructor', compact('user', 'course', 'live_class'));
    }
}
