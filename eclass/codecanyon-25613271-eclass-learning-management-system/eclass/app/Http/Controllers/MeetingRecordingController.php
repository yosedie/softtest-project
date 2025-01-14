<?php

namespace App\Http\Controllers;

use App\MeetingRecording;
use Illuminate\Http\Request;
use Session;
use Spatie\Permission\Models\Role;

class MeetingRecordingController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    
        $this->middleware('permission:meetings.meeting-recordings.view', ['only' => ['index','show']]);
        $this->middleware('permission:meetings.meeting-recordings.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:meetings.meeting-recordings.edit', ['only' => ['update','status']]);
        $this->middleware('permission:meetings.meeting-recordings.delete', ['only' => ['destroy']]);
    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recordings = MeetingRecording::get();
        return view('admin.meeting_recording.index', compact('recordings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.meeting_recording.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request,[
            'title' => 'required',
            'url' => 'required',
        ]);


        $input = $request->all();
        $data = MeetingRecording::create($input);
        
        $data->save();

        Session::flash('success',trans('flash.AddedSuccessfully'));
        return redirect('meeting-recordings');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MeetingRecording  $meetingRecording
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recording = MeetingRecording::find($id);
        return view('admin.meeting_recording.edit',compact('recording'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MeetingRecording  $meetingRecording
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MeetingRecording  $meetingRecording
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validate($request,[
            'title' => 'required',
            'url' => 'required',
        ]);

        $data = MeetingRecording::findorfail($id);
        $input = $request->all();

        

        $data->update($input);

        Session::flash('success',trans('flash.UpdatedSuccessfully')); 
        return redirect('meeting-recordings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MeetingRecording  $meetingRecording
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('meeting_recordings')->where('id',$id)->delete();
        return back(); 
    }
}
