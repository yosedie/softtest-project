<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use App\Googlemeet;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Course;
use File;
use App\Setting;
use App\Attandance;
use Spatie\Permission\Models\Role;


class GoogleMeetController extends Controller
{
    protected $client;

    public function __construct()
    {
    
        $this->middleware('permission:meetings.google-meet.view', ['only' => ['allgooglemeeting','googlemeetdetailpage']]);
        $this->middleware('permission:meetings.google-meet.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:meetings.google-meet.edit', ['only' => ['edit','updatemeeting']]);
        $this->middleware('permission:meetings.google-meet.delete', ['only' => ['delete','oauth','googleupdatefile']]);
        $this->middleware('permission:meetings.google-meet.settings', ['only' => ['googlemeetsetting']]);
        $this->middleware('permission:meetings.google-meet.dashboard', ['only' => ['dashboard']]);
        $this->middleware(function ($request, $next) {

            $this->projects = Auth::user()->email;

            $auth_email = $this->projects;

            $path = 'files/googlemeet'.'/'.$auth_email;

            $credentialsFile = public_path().'/'.$path.'/'.'client_secret.json';

            if(file_exists(public_path().'/'.$path.'/'.'client_secret.json')) {
                $client = new Google_Client();
                $client->setAuthConfig($credentialsFile);
                $client->addScope(Google_Service_Calendar::CALENDAR);
                $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false)));
                $client->setHttpClient($guzzleClient);
                $this->client = $client;
            }

            return $next($request);

        });

        
    }

    public function dashboard()
    {
        $auth_email = Auth::user()->email;
        $path = 'files/googlemeet'.'/'.$auth_email;
        if(file_exists(public_path().'/'.$path.'/'.'client_secret.json')) {
            try {
                session_start();
                if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
                    $this->client->setAccessToken($_SESSION['access_token']);
                    $service = new Google_Service_Calendar($this->client);
                    $calendarId = 'primary';
                    $results = $service->events->listEvents($calendarId);
                    $allgooglemeet = Googlemeet::where('user_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->get();
                    return view('googlemeet.index',compact('allgooglemeet'));
                   
                } else {
                   
                    return redirect()->route('googleMeetCallBack');
                }
            }catch(\Exception $ex){
                \Session::flash('delete', $ex->getMessage());
                return redirect()->route('googlemeet.setting');
            }
        }
        else{

            return redirect()->route('googlemeet.setting')->with('delete','Please update settings !');

        }  
    }

    public function create()
    {
        if(Auth::User()->role == "admin"){
            $course = Course::where('status', '1')->get();
          }
          else{
            $course = Course::where('status', '1')->where('user_id', Auth::User()->id)->get();
          }
        return view('googlemeet.create', compact('course'));
    }

    public function store(Request $request)
    {
        // return $request;
        session_start();
        $userid = Auth::user()->id;
        $title = $request->topic;
        $startDateTime = Carbon::parse($request->start_time)->toRfc3339String();
        $endDateTime = Carbon::parse($request->end_time)->toRfc3339String();
        $duration = $request->duration;
        $description = $request->agenda;
        $timezone = $request->timezone;
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Calendar($this->client);

            $calendarId = 'primary';
            $event = new Google_Service_Calendar_Event([
                'summary' => $title,
                'description' => $description,
                'start' => ['dateTime' => $startDateTime],
                'end' => ['dateTime' => $endDateTime],
                'reminders' => ['useDefault' => true],
            ]);
        
            $conference = new \Google_Service_Calendar_ConferenceData();
            $conferenceRequest = new \Google_Service_Calendar_CreateConferenceRequest();
            $conferenceRequest->setRequestId('randomString123');
            $conference->setCreateRequest($conferenceRequest);
            $event->setConferenceData($conference);
            $results = $service->events->insert($calendarId, $event,['conferenceDataVersion' => 1]);
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
            $googlemeet = new Googlemeet();
            $googlemeet->meeting_id = $results->id;
            $googlemeet->meeting_title = $results->summary;
            $googlemeet->start_time = $startDateTime;
            $googlemeet->end_time = $endDateTime;
            $googlemeet->meet_url = $results->hangoutLink;
            $googlemeet->agenda = $results->description;
            $googlemeet->duration = $request->duration;
            $googlemeet->timezone = $request->timezone;
            $googlemeet->course_id = $request->course_id;
            $googlemeet->user_id = $userid;
            $googlemeet->link_by = $link_by;
           // Determine if the meeting is paid or not
            $isPaidMeeting = $request->has('paid_meeting_toggle') ? 1 : 0;
            // Set the paid_meeting_price if it's a paid meeting
            $paidMeetingPrice = $isPaidMeeting ? $request->input('paid_meeting_price') : null;
            // Set the isPaidMeeting and paid_meeting_price fields
            $googlemeet->paid_meeting_toggle = $isPaidMeeting;
            $googlemeet->paid_meeting_price = $paidMeetingPrice;
            
            if ($request->hasFile('image'))
            {
                $path = 'images/googlemeet/profile_image/';

                if(!file_exists(public_path().'/'.$path)) {
                    
                    $path = 'images/googlemeet/profile_image/';
                    File::makeDirectory(public_path().'/'.$path,0777,true);
                }

                $image = $request->file('image');
                $name = $image->getClientOriginalName();
                $destinationPath = public_path('images/googlemeet/profile_image');
                $image->move($destinationPath, $name);
                $googlemeet->image = $name;    
            }
            if ($googlemeet->save()) {
                return redirect()->route('googlemeet.index')->with('success','Meeting Schedule successfully !');
            }
            return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
        } else {
            return redirect()->route('oauthCallback');
        }
    }

    public function allgooglemeeting(){
        $allgooglemeet = Googlemeet::where('user_id', '=', Auth::user()->id)->orderBy('id', 'DESC')->get();
        return view('googlemeet.meeting',compact('allgooglemeet'));
    }

    public function oauth()
    {
        
        $auth_email = Auth::user()->email;

        $path = 'files/googlemeet'.'/'.$auth_email;

        $credentialsFile = public_path().'/'.$path.'/'.'client_secret.json';

        if(file_exists(public_path().'/'.$path.'/'.'client_secret.json')) {

            session_start();
            $rurl = action('GoogleMeetController@oauth');
            $client = new Google_Client();
            $client->setAuthConfig($credentialsFile);
            $client->setRedirectUri($rurl);
            $client->addScope(Google_Service_Calendar::CALENDAR);
            $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false)));
            $client->setHttpClient($guzzleClient);
           
            if (!isset($_GET['code'])) {
                $auth_url = $client->createAuthUrl();
                $filtered_url = filter_var($auth_url, FILTER_SANITIZE_URL);
                return redirect($filtered_url);
            } else {
                $client->authenticate($_GET['code']);
                $_SESSION['access_token'] = $client->getAccessToken();
                return redirect()->route('googlemeet.index');
            }

        } 
        else{

            return redirect()->route('googlemeet.setting')->with('delete','Please update settings !');

        }  
    }

    public function delete($eventId)
    {
        session_start();
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);
            $service = new Google_Service_Calendar($this->client);

            $service->events->delete('primary', $eventId);

            Googlemeet::where('meeting_id',$eventId)->delete();
            return redirect()->route('googlemeet.index')->with('success','Meeting Deleted successfully !');

        } else {
            return redirect()->route('oauthCallback');
        } 
    }

    public function googlemeetdetailpage(Request $request, $id)
    {
        $googlemeet = Googlemeet::where('id', $id)->first();
        if(!$googlemeet){
            return redirect('/')->with('delete','Meeting is ended !');
        }

        $gsetting = Setting::first();
        
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
                    'googlemeet_id'  => $googlemeet->id,
                    'instructor_id' => $googlemeet->user_id,
                    'date'     => $date->toDateString(),
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    ]
                );
            }
        }

        $setting = Setting::first();
        if($setting->theme == '1'){
        return view('front.google_meet_detail', compact('googlemeet'));
        }
        return view('theme_2.front.google_meet_detail', compact('googlemeet'));
        
    }

    public function edit($id)
    {
        if(Auth::User()->role == "admin"){
            $course = Course::where('status', '1')->get();
          }
          else{
            $course = Course::where('status', '1')->where('user_id', Auth::User()->id)->get();
          }
        $googlemeetedit = Googlemeet::where('meeting_id', $id)->first();
        return view('googlemeet.edit',compact('googlemeetedit', 'course'));
    }

public function updatemeeting(Request $request, $eventId)
{
    session_start();
    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
        $this->client->setAccessToken($_SESSION['access_token']);
        $service = new Google_Service_Calendar($this->client);

        try {
            $startDateTime = Carbon::parse($request->start_date)->toRfc3339String();
            $eventDuration = 30; // minutes

            // Calculate endDateTime based on the start_date and eventDuration if end_date is not provided
            if ($request->has('end_date')) {
                $endDateTime = Carbon::parse($request->end_date)->toRfc3339String();
            } else {
                $endDateTime = Carbon::parse($request->start_date)->addMinutes($eventDuration)->toRfc3339String();
            }

            // Retrieve the event from the API
            $event = $service->events->get('primary', $eventId);

            // Update event details
            $event->setSummary($request->topic);
            $event->setDescription($request->description);

            // Set start time with timezone
            $start = new Google_Service_Calendar_EventDateTime();
            $start->setDateTime($startDateTime);
            $start->setTimeZone($request->timezone); // Ensure timezone is set
            $event->setStart($start);

            // Set end time with timezone
            $end = new Google_Service_Calendar_EventDateTime();
            $end->setDateTime($endDateTime);
            $end->setTimeZone($request->timezone); // Ensure timezone is set
            $event->setEnd($end);

            // Update the event in Google Calendar
            $updatedEvent = $service->events->update('primary', $event->getId(), $event);

            if (!$updatedEvent) {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
            }

            // Update data into the database
            $link_by = $request->has('link_by') ? 'course' : null;
            $course_id = $request->input('course_id', null);

            // Check if an image file is uploaded
            $image = null;
            if ($request->hasFile('image')) {
                $path = 'images/googlemeet/profile_image/';
                if (!file_exists(public_path().'/'.$path)) {
                    File::makeDirectory(public_path().'/'.$path, 0777, true);
                }
                $imageFile = $request->file('image');
                $imageName = $imageFile->getClientOriginalName();
                $destinationPath = public_path('images/googlemeet/profile_image');
                $imageFile->move($destinationPath, $imageName);
                $image = $imageName;
            }
	 $startDateTime = Carbon::parse($request->start_time)->toRfc3339String();
        $endDateTime = Carbon::parse($request->end_time)->toRfc3339String();
            // Update the meeting in the database
            Googlemeet::where('meeting_id', $eventId)->update([
                'start_time' => $startDateTime,
                'end_time' => $endDateTime,
                'meeting_title' => $request->topic,
                'agenda' => $request->description,
                'duration' => $request->duration,
                'timezone' => $request->timezone,
                'link_by' => $link_by,
                'course_id' => $course_id,
                'image' => $image,
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]);

            return redirect()->route('googlemeet.index')->with('success', 'Meeting updated successfully!');
        } catch (Google_Service_Exception $e) {
            // Log the error and return a response
            \Log::error('Google Calendar API error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Google Calendar API error: ' . $e->getMessage()]);
        } catch (Exception $e) {
            // Log the error and return a response
            \Log::error('Error updating meeting: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Error updating meeting: ' . $e->getMessage()]);
        }
    } else {
        return redirect()->route('oauthCallback');
    }
}




    public function googlemeetsetting()
    {
        return view('googlemeet.setting');
    }

    public function googleupdatefile(Request $request){
        $data = $this->validate($request, [
            'file' => 'required',
        ]);
        $file = $request->file;
        $filext = $file->clientExtension();
        if($request->file != '' && 'json' == $filext){   
        // $file = $request->file;
        $extension =  $file->clientExtension();
        $renamefile = 'client_secret.'.$extension;
        }
        // ===
        if($renamefile != ''){
            $auth_email = Auth::user()->email;
            $path = 'files/googlemeet'.'/'.$auth_email;
            if(!file_exists(public_path().'/'.$path)) {
                $path = 'files/googlemeet'.'/'.$auth_email;
                // $path = 'images/category/';
                File::makeDirectory(public_path().'/'.$path,0777,true);
            }  
            //code for remove old file
                $file_old = $path.$renamefile; 
                if(file_exists($file_old)){
                    unlink($file_old);    
                }
                $query = $file->move($path, $renamefile); 
            if($query){
                return redirect()->route('googlemeet.setting')->with('success','Token details updated successfully !');
            }else{
                return back()->with('delete','Error updating details !');
            }
       }
    }
}