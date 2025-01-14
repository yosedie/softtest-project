<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BBL;
use BigBlueButton\BigBlueButton;
use BigBlueButton\Parameters\CreateMeetingParameters;
use BigBlueButton\Parameters\GetMeetingInfoParameters;
use BigBlueButton\Parameters\JoinMeetingParameters;
use BigBlueButton\Parameters\EndMeetingParameters;
use Auth;
use Crypt;
use App\Course;
use Cookie;
use App\User;
use BigBlueButton\Parameters\GetRecordingsParameters;
use App\Setting;
use Carbon\Carbon;
use App\Attandance;
use Spatie\Permission\Models\Role;


class BigBlueController extends Controller
{
    

    public function __construct()
    {
    
        $this->middleware('permission:meetings.big-blue.view', ['only' => ['index']]);
        $this->middleware('permission:meetings.big-blue.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:meetings.big-blue.edit', ['only' => ['edit', 'update','status']]);
        $this->middleware('permission:meetings.big-blue.delete', ['only' => ['destroy','delete']]);
        $this->middleware('permission:meetings.big-blue.recorded', ['only' => ['getrecordings']]);
        $this->middleware('permission:meetings.big-blue.settings', ['only' => ['setting']]);
       
    
    }
    public function index(){
        $meetings = BBL::orderBy('id','DESC')->where('is_ended','!=',1)->where('instructor_id',Auth::user()->id)->get();
        return view('admin.bbl.index',compact('meetings'));
    }

    public function create(){
        return view('admin.bbl.create');
    }

    public function edit($meetingid){
        $meeting = BBL::findorfail($meetingid);
        return view('admin.bbl.edit',compact('meeting'));
    }

    public function store(Request $request){
        $newmeeting = new BBL;
        $input = $request->all();

        $allmeeting = BBL::where('is_ended','!=',1)->get();

        foreach ($allmeeting as $key => $met) {
           if($request->meetingid == $met->meetingid){
                return back()->with('delete','Meeting is already active with this name !')->withInput();
           }
        }
        if($request->modpw == $request->attendeepw){
            return back()->with('delete','Attandee password and moderator password cannot be same !')->withInput();
        }

        if(isset($request->setMuteOnStart)){
            $input['setMuteOnStart'] = 1;
        }else{
            $input['setMuteOnStart'] = 0;
        }

        if(isset($request->allow_record)){
            $input['allow_record'] = 1;
        }else{
            $input['allow_record'] = 0;
        }

        if($request->setMaxParticipants == ''){
            $input['setMaxParticipants'] = '-1';
        }

        if(isset($request->disable_chat)){
            $input['disable_chat'] = 1;
        }else{
            $input['disable_chat'] = 0;
        } 

        if(isset($request->link_by))
        {
            $input['link_by'] = 'course';
            $input['course_id'] = $request['course_id'];
        }
        else
        {
            $input['link_by'] = NULL;
            $input['course_id'] = NULL;
        }

        $input['paid_meeting_toggle'] = $request->has('paid_meeting_toggle') ? 1 : 0;
        $input['paid_meeting_price'] = $input['paid_meeting_toggle'] ? $request->input('paid_meeting_price') : null;
    
        $input['start_time'] = Carbon::parse($request->start_time)->toRfc3339String();    

        $input['instructor_id'] = Auth::user()->id; 

        $newmeeting->create($input);
        
        return redirect()->route('bbl.all.meeting')->with('success',trans('flash.CreatedSuccessfully'));
    }

    public function update(Request $request,$id){
        $newmeeting = BBL::findorfail($id);
        $input = $request->all();

        if($request->modpw == $request->attendeepw){
            return back()->with('delete','Attandee password and moderator password cannot be same !')->withInput();
        }

        if(isset($request->setMuteOnStart)){
            $input['setMuteOnStart'] = 1;
        }else{
            $input['setMuteOnStart'] = 0;
        }

         if(isset($request->allow_record)){
            $input['allow_record'] = 1;
        }else{
            $input['allow_record'] = 0;
        }

        if($request->setMaxParticipants == ''){
            $input['setMaxParticipants'] = '-1';
        }

        if(isset($request->disable_chat)){
            $input['disable_chat'] = 1;
        }else{
            $input['disable_chat'] = 0;
        }

        if(isset($request->link_by))
        {
            $input['link_by'] = 'course';
            $input['course_id'] = $request['course_id'];
        }
        else
        {
            $input['link_by'] = NULL;
            $input['course_id'] = NULL;
        }          
        
        $input['paid_meeting_toggle'] = $request->has('paid_meeting_toggle') ? 1 : 0;
        $input['paid_meeting_price'] = $input['paid_meeting_toggle'] ? $request->input('paid_meeting_price') : null;
    

        $newmeeting->update($input);
        return redirect()->route('bbl.all.meeting')->with('success',trans('flash.UpdatedSuccessfully'));
    }

    public function delete($meetingid){
        $meeting = BBL::find($meetingid);

        if(isset($meeting)){
            $meeting->delete();
            return back()->with('deleted',trans('flash.DeletedSuccessfully'));
        }else{
            return back()->with('deleted','Meeting not found !');
        }
    }

    public function setting(Request $request){

        $env_update = $this->changeEnv([
          
          'BBB_SECURITY_SALT' => $request->BBB_SECURITY_SALT,
          'BBB_SERVER_BASE_URL' => $request->BBB_SERVER_BASE_URL
          
        ]);

        if($env_update){
            return back()->with('success','Settings Updated Successfully !');
        }else{
            return back()->with('deleted','Oops ! Please try again..');
        }
    }

    public function apiCreate($id){

        
        $bbb = new BigBlueButton();
        $m = BBL::find($id);
        $userid = Crypt::encrypt(Auth::user()->id);
        $meetingid = Crypt::encrypt($m->meetingid);
        $urlLogout = url('/bigblue/api/callback?meetingID='.$meetingid.'&user='.$userid);
        $createMeetingParams = new CreateMeetingParameters($m->meetingid, $m->meetingname);
        $createMeetingParams->setAttendeePassword($m->attendeepw);
        $createMeetingParams->setModeratorPassword($m->modpw);
        $createMeetingParams->setDuration($m->duration);
        $createMeetingParams->setMaxParticipants($m->setMaxParticipants);
        $createMeetingParams->setMuteOnStart($m->setMuteOnStart == 0 ? false : true);
        $createMeetingParams->setCopyright(date('Y').' | '.config('app.name'));

        if($m->welcomemsg != ''){
            $createMeetingParams->setWelcomeMessage($m->welcomemsg);
        }

        $createMeetingParams->setWebcamsOnlyForModerator(true);
        
        $createMeetingParams->setRecord($m->allow_record == 0 ? false : true);
        $createMeetingParams->setAllowStartStopRecording($m->allow_record == 0 ? false : true);
        $createMeetingParams->setAutoStartRecording($m->allow_record == 0 ? false : true);
        $createMeetingParams->setLogoutUrl($urlLogout);

        $response = $bbb->createMeeting($createMeetingParams);
        
        if ($response->getReturnCode() == 'FAILED') {

            return 'Can\'t create room! please contact our administrator.';

        } else {

            $joinMeetingParams = new JoinMeetingParameters($m->meetingid, $m->meetingname, $m->modpw);
            $joinMeetingParams->setUsername($m->presen_name);
            $joinMeetingParams->setRedirect(true);
            $url = $bbb->getJoinMeetingURL($joinMeetingParams);
            return redirect($url);
        }

     
    }

    public function logout(Request $request){

        $userid = Crypt::decrypt($request->user);
        $meetingid = Crypt::decrypt($request->meetingID);
        $findmeeting = BBL::where('meetingid','=',$meetingid)->first();

        if(isset($findmeeting)){

            $userid = Cookie::get('user_selection');
            $user = User::find($userid);

            if(isset($user))
            {
               $login = $user->id;
            }
            else{
                $login = Auth::user()->id;
            }

            if($findmeeting->instructor_id == $login){
                $findmeeting->is_ended = 1;
                $findmeeting->save();

                $bbb = new BigBlueButton();

                $endMeetingParams = new EndMeetingParameters($meetingid, $findmeeting->modpw);
                $response = $bbb->endMeeting($endMeetingParams);

                return redirect('/')->with('success','Meeting ended successfully !');
            }else{
                return redirect('/')->with('success','You logout from meeting successfully !');
            }

        }else{
            return redirect('/')->with('delete','No meeting exist with this id');
        }


    }

    public function joinview($meetingid){
         $m = BBL::where('meetingid',$meetingid)->first();
         if($m){
            return view('admin.bbl.joinmeeting',compact('m'));
         }else{
            return back()->with('deleted','404 Meeting Not found !');
         }
    }

    public function apiJoin(Request $request){
            
            $bbb = new BigBlueButton();
            $m = BBL::where('meetingid',$request->meetingid)->first();
                
            if($m){

                if($request->meetingid != $m->meetingid){
                    return back()->with('delete','The meeting ID that you supplied did not match any existing meetings')->withInput($request->except('password'));
                }

                if($request->password != $m->attendeepw){
                    return back()->with('delete','Invalid password Please try again!')->withInput($request->except('password'));
                }

                if($m->is_ended == 1){
                    return back()->with('delete','Meeting is already ended !')->withInput($request->except('password'));
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
                            'bbl_id'  => $m->id,
                            'instructor_id' => $m->instructor_id,
                            'date'     => $date->toDateString(),
                            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                            ]
                        );
                    }
                }



                $joinMeetingParams = new JoinMeetingParameters($m->meetingid, $m->meetingname, $request->password);
                $joinMeetingParams->setUsername($request->name);
                $joinMeetingParams->setRedirect(true);
                $url = $bbb->getJoinMeetingURL($joinMeetingParams);

                Cookie::queue('user_selection', Auth::user()->id, 100);
                return redirect($url);
            }else{
                return back()->with('delete','Meeting not found !');
            }

    }


    
    public function detailpage(Request $request, $id)
    {
        $bbl = BBL::where('id', $id)->where('is_ended','!=',1)->first();
        if(!$bbl){
            return redirect('/')->with('delete','Meeting is ended !');
        }
        $setting = Setting::first();
        if($setting->theme == '1'){
        return view('front.bbl_detail', compact('bbl'));
        }
        return view('theme_2.front.bbl_detail', compact('bbl'));
    }


    public function getrecordings(Request $request)
    {
        if(env('BBB_SECURITY_SALT') != NULL  && env('BBB_SERVER_BASE_URL') != NULL){

            $recordingParams = new GetRecordingsParameters();
            $bbb = new BigBlueButton();
            $response = $bbb->getRecordings($recordingParams);

            if ($response->getReturnCode() == 'SUCCESS') {
                foreach ($response->getRawXml()->recordings as $recording) {

                        $all_recordings = $recording;
                        
                }
            }
            else{

                return view('admin.bbl.setting')->with('delete','Recordings not found !');

            }


            return view('admin.bbl.recordings',compact('all_recordings'));
        }


        return view('admin.bbl.setting')->with('delete','Update your settings !');

        
    }


    protected function changeEnv($data = array())
    {
        if ( count($data) > 0 ) {

            // Read .env-file
            $env = file_get_contents(base_path() . '/.env');

            // Split string on every " " and write into array
            $env = preg_split('/\s+/', $env);;

            // Loop through given data
            foreach((array)$data as $key => $value){
              // Loop through .env-data
              foreach($env as $env_key => $env_value){
                // Turn the value into an array and stop after the first split
                // So it's not possible to split e.g. the App-Key by accident
                $entry = explode("=", $env_value, 2);

                // Check, if new key fits the actual .env-key
                if($entry[0] == $key){
                    // If yes, overwrite it with the new one
                    $env[$env_key] = $key . "=" . $value;
                } else {
                    // If not, keep the old one
                    $env[$env_key] = $env_value;
                }
              }
            }

            // Turn the array back to an String
            $env = implode("\n\n", $env);

            // And overwrite the .env with the new data
            file_put_contents(base_path() . '/.env', $env);

            return true;

        } else {

          return false;
        }
    }   
}
