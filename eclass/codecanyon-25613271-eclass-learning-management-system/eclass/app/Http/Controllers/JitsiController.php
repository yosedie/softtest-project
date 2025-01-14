<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\JitsiMeeting;
use Auth;
use App\User;
use App\Course;
use File;
use Redirect;
use App\Setting;
use Carbon\Carbon;
use App\Attandance;
use Spatie\Permission\Models\Role;

class JitsiController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:meetings.jitsi-meet.view', ['only' => ['jitsidashboard','jitsidetailpage']]);
        $this->middleware('permission:meetings.jitsi-meet.create', ['only' => ['jitsicreate', 'savejitsimeeting']]);
        $this->middleware('permission:meetings.jitsi-meet.edit', ['only' => ['status']]);
        $this->middleware('permission:meetings.jitsi-meet.delete', ['only' => ['deletemeeting']]);
    
    }  

    public function jitsidashboard()
    {
        $userid = Auth::user()->id;
        $jitsimeeting = JitsiMeeting::where('user_id', $userid)->orderBy('id', 'DESC')->get();
        return view('admin.jitsimeeting.dashboard', compact('jitsimeeting'));
    }

    public function jitsicreate()
    {
        if(Auth::User()->role == "admin"){
            $course = Course::where('status', '1')->get();
          }
          else{
            $course = Course::where('status', '1')->where('user_id', Auth::User()->id)->get();
          }
        return view('admin.jitsimeeting.create', compact('course'));
    }

    public function savejitsimeeting(Request $request){

        if(isset($request->link_by))
        {
            $link_by = 'course';
            $course_id = $request['course_id'];
        }
        else
        {
            $link_by = NULL;
            $course_id = NULL;
        }

        $userid = Auth::user()->id;
        $jitsimeeting = new JitsiMeeting();
        $jitsimeeting->meeting_title = $request->topic;
        $jitsimeeting->meeting_id = mt_rand(1000000000, 9999999999);
        $jitsimeeting->start_time = date('Y-m-d h:i:s',strtotime($request->start_time));
        $jitsimeeting->end_time = date('Y-m-d h:i:s',strtotime($request->end_time));
        $jitsimeeting->duration = $request->duration;
        $jitsimeeting->agenda = $request->agenda;
        $jitsimeeting->time_zone = $request->timezone;
        $jitsimeeting->user_id = $userid;
        $jitsimeeting->course_id = $course_id;
        $jitsimeeting->link_by = $link_by;

         // Handling paid meeting status and price
    $jitsimeeting->paid_meeting_toggle = $request->has('paid_meeting_toggle') ? 1 : 0;
    $jitsimeeting->paid_meeting_price = $jitsimeeting->paid_meeting_toggle ? $request->input('paid_meeting_price') : null;

        
        if ($request->hasFile('image'))
        {
            $path = 'images/jitsimeet/';

            if(!file_exists(public_path().'/'.$path)) {
                
                $path = 'images/jitsimeet/';
                File::makeDirectory(public_path().'/'.$path,0777,true);
            }

            $image = $request->file('image');
            $name = $image->getClientOriginalName();
            $destinationPath = public_path('images/jitsimeet');
            $image->move($destinationPath, $name);
            $jitsimeeting->image = $name;    
        }
        $jitsimeeting->save();
        return redirect('jitsi-dashboard')->with('success','Meeting created successfully');
    }

    public function joinMeetup($meetingid){

        if(Auth::check())
        {
            $gsetting = Setting::first();

            


            $userid = Auth::user()->id;
            $jitsimeetings = JitsiMeeting::
            where([
               
                ['meeting_id', '=', $meetingid]
            ])
            ->first();

            if($gsetting->attandance_enable == 1)
            {

              $date = Carbon::now();
              //Get date
              $date->toDateString();

              $courseAttandance = Attandance::where('user_id', Auth::User()->id)->where('date','=', $date->toDateString())->first();

                if(!$courseAttandance)
                {
                    $attanded = Attandance::create([
                        'user_id'    => Auth::user()->id,
                        'jitsi_id'  => $jitsimeetings->id,
                        'instructor_id' => $jitsimeetings->user_id,
                        'date'     => $date->toDateString(),
                        'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                        ]
                    );
                }
            }

            return view('admin.jitsimeeting.jitsimeet', compact('jitsimeetings'));

        }
        
        return Redirect::route('login')->withInput()->with('delete', trans('flash.PleaseLogin'));

    }

    public function deletemeeting($meetingid)
    { 
        $userid = Auth::user()->id;
        $jitsimeetings = JitsiMeeting::where([
            ['user_id', '=', $userid],
            ['meeting_id', '=', $meetingid]
        ])->delete();
        return redirect()->back()->with('success','Meeting Deleted successfully !');
    }

    public function jitsidetailpage(Request $request, $id)
    {
       
        $jitsimeet = JitsiMeeting::where('id', $id)->first();
        
        if(!$jitsimeet){
            return redirect('/')->with('delete','Meeting is ended !');
        }
        $setting = Setting::first();
        if($setting->theme == '1'){
        return view('front.jitsimeet_detail', compact('jitsimeet'));
        }
        return view('theme_2.front.jitsimeet_detail', compact('jitsimeet'));
    }
}
