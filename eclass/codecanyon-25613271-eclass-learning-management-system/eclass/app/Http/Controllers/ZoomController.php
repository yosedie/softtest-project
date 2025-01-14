<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Meeting;
use DateTime;
use DateTimeZone;
use App\Categories;
use App\Course;
use Illuminate\Support\Facades\Log;
use File;
use Image;
use App\Setting;
use Carbon\Carbon;
use App\Attandance;
use Spatie\Permission\Models\Role;
use DotenvEditor;
use Exception;


class ZoomController extends Controller
{
  public function __construct()
    {
        $this->middleware('permission:meetings.zoom-meetings.view', ['only' => ['dashboard','show']]);
        $this->middleware('permission:meetings.zoom-meetings.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:meetings.zoom-meetings.edit', ['only' => ['edit', 'updateToken','setting','updatemeeting']]);
        $this->middleware('permission:meetings.zoom-meetings.delete', ['only' => ['delete', 'bulk_delete']]);
    }
    public function test() {
      $client_id =  env('ZOOM_CLIENT_KEY');
      $client_secret = env('ZOOM_CLIENT_SECRET');
      $account_id = env('ZOOM_ACCOUNT_ID');
  
      $credentials = base64_encode("$client_id:$client_secret");
      $token_url = "https://zoom.us/oauth/token?grant_type=account_credentials&account_id=$account_id";
  
      $headers = array(
          "Authorization: Basic $credentials",
          "Content-Type: application/x-www-form-urlencoded"
      );
  
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $token_url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
      $response = curl_exec($ch);
      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);
  
      if ($httpcode == 200) {
          $json_response = json_decode($response, true);
          return $json_response['access_token'];
      } else {
          throw new Exception("Error fetching bearer token: $response");
      }
    }

    public function fetchUserInfo() {
      // Get access token using test() function
      $accessToken = $this->test();
  
      // User's Zoom ID or email
      $userId = env('ZOOM_EMAIL'); // Replace this with the actual Zoom ID or email
  
      // Zoom API endpoint
      $endpoint = "https://api.zoom.us/v2/users/$userId";
  
      // Prepare cURL request
      $curl = curl_init();
      curl_setopt_array($curl, array(
          CURLOPT_URL => $endpoint,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_HTTPHEADER => array(
              "Authorization: Bearer $accessToken"
          ),
      ));
  
      // Execute cURL request
      $response = curl_exec($curl);
      $err = curl_error($curl);
  
      // Close cURL session
      curl_close($curl);
  
      if (!$err) {
          // Decode JSON response
          $userData = json_decode($response, true);
  
          // Check if the response contains user data
          if (isset($userData['first_name']) && isset($userData['last_name'])) {
              // Fetch first name and last name from the response
              $firstName = $userData['first_name'];
              $lastName = $userData['last_name'];
  
              // Now you can use $firstName and $lastName as needed
              echo "First Name: " . $firstName . "<br>";
              echo "Last Name: " . $lastName . "<br>";
          } else {
              // Response does not contain expected user data
              echo "Zoom API Error: Unexpected response format.";
          }
      } else {
          // cURL request failed
          echo "cURL Error: " . $err;
      }
  }
  public function dashboard(Request $request){
   
    $token = $this->test();

    if(Auth::user()->role == 'admin' || Auth::user()->role == 'instructor'){
        $email = env('ZOOM_EMAIL');
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.zoom.us/v2/users/$email",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer $token"
            ),
        ));

        $profile = curl_exec($curl);
        $profile = json_decode($profile, true);
        $err = curl_error($curl);
        curl_close($curl);

        if(isset($profile['code']) && $profile['code'] != 200){
            \Session::flash('delete', $profile['message']);
            return redirect()->route('zoom.setting');
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.zoom.us/v2/users/$email/meetings?page_number=1&page_size=30&type=scheduled",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer $token"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $response = json_decode($response, true);

        if(isset($response['code']) && $response['code'] != 200){
            \Session::flash('delete', $response['message']);
            return redirect()->route('zoom.setting');
        }

        curl_close($curl);

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($response['meetings']);
        $itemCollection = $itemCollection->sortByDesc('created_at');
        $perPage = 30;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $paginatedItems = new LengthAwarePaginator($currentPageItems, count($itemCollection) , $perPage);
        $paginatedItems->setPath($request->url());

        if ($err) {
            return view('admin.zoom.index')->with('deleted',$err);
        } else {
             $meetings =  $paginatedItems;
            return view('admin.zoom.index',compact('meetings','profile'));
        }
    } else {
        return abort(403, 'Unauthorized action.');
    }
}


    public function updateToken(Request $request){
      $env_update = DotenvEditor::setKeys([
        'ZOOM_CLIENT_KEY' => $request->ZOOM_CLIENT_KEY,
        'ZOOM_CLIENT_SECRET' => $request->ZOOM_CLIENT_SECRET,
        'ZOOM_ACCOUNT_ID' => $request->ZOOM_ACCOUNT_ID,
        'ZOOM_EMAIL' => $request->ZOOM_EMAIL,
    ]);
        $env_update->save();
      if ($env_update) {
        return redirect()->route('zoom.index')->with('success','Token details updated successfully !');
      } else {
        return back()->with('deleted','Error updating details !');
      }
    }

    public function setting(){

      ini_set("zlib.output_compression", "Off");
      return view('admin.zoom.setting');
    }

    public function create(){
      if(Auth::User()->role == "admin"){
        $course = Course::where('status', '1')->get();
      }
      else{
        $course = Course::where('status', '1')->where('user_id', Auth::User()->id)->get();
      }
      
      return view('admin.zoom.create', compact('course'));
    }

    public function delete($id){
      $curl = curl_init();
      $client_id =  env('ZOOM_CLIENT_KEY');
      $token = $this->test();
      curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.zoom.us/v2/meetings/$id",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "DELETE",
      CURLOPT_HTTPHEADER => array(
        "authorization: Bearer $token"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if($response == ''){
      Meeting::where('meeting_id', $id)->delete();
      return redirect()->route('zoom.index')->with('success','Meeting Deleted successfully !');
    }else{
      return back()->with('deleted',$response);
    }



    }

    public function store(Request $request){
      
      // return $request;

      $request->validate([
        'topic' => 'required',
      ]);
      if($file = $request->file('image')) 
        { 
          
          $path = 'images/zoom/';

          if(!file_exists(public_path().'/'.$path)) {
            
            $path = 'images/zoom/';
            File::makeDirectory(public_path().'/'.$path,0777,true);
          }    
          $optimizeImage = Image::make($file);
          $optimizePath = public_path().'/images/zoom/';
          $image = time().$file->getClientOriginalName();
          $optimizeImage->save($optimizePath.$image, 72);

          $input['image'] = $image;

          $zoom_image = $image;
          
        }
        else
        {
          $zoom_image = NULL;
        }
        $token = $this->test();
         $start_time = date('Y-m-d\TH:i:s', strtotime($request->start_time));

         if($request->timezone == 'None'){
          $timezone = '';
         }else{
          $timezone = $request->timezone;
         }

         if(isset($request->host_video)){
            $host_video = "true";
         }else{
            $host_video = "false";
         }
         
         if(isset($request->host_video)){
            $participant_video = "true";
         }else{
            $participant_video = "false";
         }

         if(isset($request->join_before_host)){
            $join_before_host = "true";
         }else{
            $join_before_host = "false";
         }
         
         if(isset($request->mute_upon_entry)){
            $mute_upon_entry  = "true";
         }else{
           $mute_upon_entry  = "false";
         }

       
         
         if(isset($request->registrants_email_notification)){
           $registrants_email_notification = "true";
         }else{
            $registrants_email_notification = "false";
         }

         if(isset($request->recurring)){
          $start_time = '';
          $duration = '';
          $type  = "3";
         }else{
          $start_time = date('Y-m-d\TH:i:s', strtotime(str_replace('-','',$request->start_time)));
          $duration = $request->duration;
          $type  = "2";
         }

         $email = env('ZOOM_EMAIL');
         $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.zoom.us/v2/users/$email/meetings",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"topic\":\"$request->topic\",\"type\":\"$type\",\"start_time\":\"$start_time\",\"duration\":\"$duration\",\"timezone\":\"$timezone\",\"password\":\"$request->password\",\"agenda\":\"$request->agenda\",\"settings\":{\"host_video\":\"$host_video\",\"participant_video\":\"$participant_video\",\"cn_meeting\":\"false\",\"in_meeting\":\"false\",\"join_before_host\":\"$join_before_host\",\"mute_upon_entry\":\"$mute_upon_entry\",\"watermark\":\"false\",\"use_pmi\":\"false\",\"approval_type\":\"1\",\"registration_type\":\"2\",\"audio\":\"both\",\"auto_recording\":\"none\",\"enforce_login\":\"false\",\"enforce_login_domains\":\"\",\"alternative_hosts\":\"\",\"global_dial_in_countries\":[\"\"],\"registrants_email_notification\":\"$registrants_email_notification\"}}",
            CURLOPT_HTTPHEADER => array(
              "authorization: Bearer $token",
              "content-type: application/json",
              "accept: application/json" // fsms adding to get error in json
            ),
          ));
         
           $response = curl_exec($curl);
          $err = curl_error($curl);
         
          $response = json_decode($response,true);
          
          curl_close($curl);
 
          if(isset($response['code'])){
            if($response['code'] != 200){
                 Log::debug('==ZOOM ERROR==: '.print_r($response, TRUE));
                 return redirect()->route('zoom.index')->with('delete',$response['message'].'Error: '.array_values($response['errors'])[0]['message']);
              }
          }

          

          $utc = isset($response['start_time']) ? $response['start_time'] : NULL;
          $dt = new DateTime($utc);
          
          //fsms adding log
          Log::debug('timezone coming from Zoom  Meeting is: '. $response['timezone']);
         
          
          
          $tz = new DateTimeZone($response['timezone']); // or whatever zone you're after
          
          
          $dt->setTimezone($tz);
          
          $meeting_time = $dt->format('Y-m-d H:i:s');


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

          if(isset($response['settings']['contact_email']))
          {
            $owner_id = $response['settings']['contact_email'];
          }
          else
          {
            $owner_id = $response['host_email'];
          }

          $isPaidMeeting = $request->has('paid_meeting_toggle') ? 1 : 0;
          $paidMeetingPrice = $isPaidMeeting ? $request->input('paid_meeting_price') : null;

          $created_meeting = Meeting::create([
              'meeting_id' => $response['id'],
              'user_id' => Auth::User()->id,
              'owner_id' => $owner_id,
              'meeting_title' => $response['topic'],
              'start_time' => $meeting_time,
              'zoom_url' => $response['start_url'],
              'link_by' => $link_by,
              'course_id' => $course_id,
              'type' => $response['type'],
              'agenda' => $response['agenda'],
              'image' => $zoom_image,
              'paid_meeting_toggle' => $isPaidMeeting,
              'paid_meeting_price' => $paidMeetingPrice,
              'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
              'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
              ]
          );
          

          return redirect()->route('zoom.show',$response['id'])->with('success',"Meeting Created successfully !");
    }

    public function edit($mettingid){

        ini_set("zlib.output_compression", "Off");

        $curl = curl_init();
        $token = $this->test();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.zoom.us/v2/meetings/$mettingid",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "authorization: Bearer $token"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $response = json_decode($response,true);

        if(isset($response['code']) && $response['code'] != 200){
            return redirect()->route('zoom.index')->with('delete',$response['message']);
        }

        $meeting = Meeting::where('meeting_id', $mettingid)->first();


       
        if(Auth::User()->role == "admin"){
          $course = Course::where('status', '1')->get();
        }
        else{
          $course = Course::where('status', '1')->where('user_id', Auth::User()->id)->get();
        }

        return view('admin.zoom.edit',compact('response', 'meeting', 'course'));


    }

    public function updatemeeting(Request $request,$meetingid){
      $request->validate([
            'topic' => 'required',
        ]);
        $start_time = date('Y-m-d\TH:i:s', strtotime($request->start_time));

         $timezone = $request->timezone;
         if(isset($request->host_video)){
            $host_video = "true";
         }else{
            $host_video = "false";
         }
         
         if(isset($request->host_video)){
            $participant_video = "true";
         }else{
            $participant_video = "false";
         }

         if(isset($request->join_before_host)){
            $join_before_host = "true";
         }else{
            $join_before_host = "false";
         }
         
         if(isset($request->mute_upon_entry)){
            $mute_upon_entry  = "true";
         }else{
           $mute_upon_entry  = "false";
         }
         
         if(isset($request->registrants_email_notification)){
           $registrants_email_notification = "true";
         }else{
            $registrants_email_notification = "false";
         }

         if(isset($request->recurring)){
          $start_time = '';
          $duration = '';
          $type  = "3";
         }else{
          $start_time = date('Y-m-d\TH:i:s', strtotime($request->start_time));
          $duration = $request->duration;
          $type  = "2";
         }
         
         $token = $this->test();
         $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.zoom.us/v2/meetings/$meetingid",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PATCH",
            CURLOPT_POSTFIELDS => "{\"topic\":\"$request->topic\",\"type\":\"$type\",\"start_time\":\"$start_time\",\"duration\":\"$request->duration\",\"timezone\":\"$timezone\",\"password\":\"$request->password\",\"agenda\":\"$request->agenda\",\"settings\":{\"host_video\":\"$host_video\",\"participant_video\":\"$participant_video\",\"cn_meeting\":\"false\",\"in_meeting\":\"false\",\"join_before_host\":\"$join_before_host\",\"mute_upon_entry\":\"$mute_upon_entry\",\"watermark\":\"false\",\"use_pmi\":\"false\",\"approval_type\":\"1\",\"registration_type\":\"2\",\"audio\":\"both\",\"auto_recording\":\"none\",\"enforce_login\":\"false\",\"enforce_login_domains\":\"\",\"alternative_hosts\":\"\",\"global_dial_in_countries\":[\"\"],\"registrants_email_notification\":\"$registrants_email_notification\"}}",
            CURLOPT_HTTPHEADER => array(
              "authorization: Bearer $token",
              "content-type: application/json"
            ),
          ));


         

          $response = curl_exec($curl);
          $err = curl_error($curl);

          curl_close($curl);

          $response = json_decode($response,true);

          if(isset($response['code']) && $response['code'] != 200){
                return redirect()->route('zoom.index')->with('delete',$response['message']);
          }

          

          $utc = $request['start_time'];
          $dt = new DateTime($utc);
          $tz = new DateTimeZone($request['timezone']); // or whatever zone you're after
          $dt->setTimezone($tz);
          $meeting_time = $dt->format('Y-m-d H:i:s');


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


          if($file = $request->file('image'))
          {
            // return $request;

              $path = 'images/zoom/';

              if(!file_exists(public_path().'/'.$path)) {
                
                $path = 'images/zoom/';
                File::makeDirectory(public_path().'/'.$path,0777,true);
              }   

              if($request->image != null) {
                  $content = @file_get_contents(public_path().'/images/zoom/'.$request->image);
                  if ($content) {
                    unlink(public_path().'/images/zoom/'.$request->image);
                  }
              }

              $optimizeImage = Image::make($file);
              $optimizePath = public_path().'/images/zoom/';
              $image = time().$file->getClientOriginalName();
              $optimizeImage->save($optimizePath.$image, 72);

              $input['image'] = $image;
              $zoom_image = $image;
          
        }
        else
        {
          $zoom_image = NULL;
        }
        $isPaidMeeting = $request->has('paid_meeting_toggle') ? 1 : 0;
        $paidMeetingPrice = $isPaidMeeting ? $request->input('paid_meeting_price') : null;
          Meeting::where('meeting_id', $meetingid)->update(
            array(
                
                'start_time'=> $meeting_time,
                'meeting_title'=> $request['topic'],
                'link_by'=> $link_by,
                'course_id'=> $course_id,
                'agenda' => $request['agenda'],
                'image' => $zoom_image,
                'paid_meeting_toggle' => $isPaidMeeting,
                'paid_meeting_price' => $paidMeetingPrice,
                'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            )
          );


          return redirect()->route('zoom.index')->with('success','Meeting Updated successfully !');
    }

    public function show($meetingid){
      $client_id =  env('ZOOM_CLIENT_KEY');
      $client_secret = env('ZOOM_CLIENT_SECRET');
      $account_id = env('ZOOM_ACCOUNT_ID');
  
      $credentials = base64_encode("$client_id:$client_secret");
      $token_url = "https://zoom.us/oauth/token?grant_type=account_credentials&account_id=$account_id";
      $headers = array(
          "Authorization: Basic $credentials",
          "Content-Type: application/x-www-form-urlencoded"
      );
  
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $token_url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
      $response = curl_exec($ch);
      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);
  
      $json_response = json_decode($response, true);
      $token = $json_response['access_token'];
       $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.zoom.us/v2/meetings/$meetingid",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "authorization: Bearer $token"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

         $response = json_decode($response,true);

        if(isset($response['code']) && $response['code'] != 200){
            return redirect()->route('zoom.index')->with('delete',$response['message']);
        }

        return view('admin.zoom.show',compact('response'));
    }



    public function detailpage(Request $request, $id)
    {
        $zoom = Meeting::where('id', $id)->first();
        if(!$zoom){
            return redirect('/')->with('delete','Meeting is ended !');
        }
        $gsetting = Setting::first();

        if(Auth::check())
        {

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
                      'zoom_id'  => $zoom->id,
                      'instructor_id' => $zoom->user_id,
                      'date'     => $date->toDateString(),
                      'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                      'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                      ]
                  );
              }
          }

        }
        $setting = Setting::first();
        if($setting->theme == '1'){
        return view('front.zoom_detail', compact('zoom'));
        }
        return view('theme_2.front.zoom_detail', compact('zoom'));

    }




}