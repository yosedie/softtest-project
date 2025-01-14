<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\NoticeCreated;
use Illuminate\Support\Facades\Mail;
use App\NoticeBoard;
use App\Course;
use DB;
use App\User;

class NoticeBoardController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:notice.view', ['only' => ['index']]);
        $this->middleware('permission:notice.create', ['only' => [ 'store','resendNotice']]);
        $this->middleware('permission:notice.edit', ['only' => ['edit','update','noticestatus']]);
        $this->middleware('permission:notice.delete', ['only' => ['destroy','bulk_delete']]);
    
    }

    public function index()
    {
        $notices = NoticeBoard::all();
        return view('admin.course.noticeboard.index', compact('notices'));
    }

    public function create()
    {

    }

    public function store(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'course_id' => 'required|exists:courses,id',
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'status' => 'nullable|boolean', // Validate status if provided
    ]);

    // Determine the status based on presence in request
    $status = $request->has('status') ? '1' : '0';

    // Create the notice
    $notice = NoticeBoard::create([
        'course_id' => $request->course_id,
        'title' => $request->title,
        'content' => $request->content,
        'status' => $status, // Set status based on presence in request
    ]);

    // Send email only if status is '1'
    if ($status === '1') {
        $users = User::where('role', 'user')->get(); // Adjust this if your role column has a different name or value
        foreach ($users as $user) {
            Mail::to($user->email)->send(new NoticeCreated($notice));
        }
    }

    return redirect()->back()->with('success', 'Notice created' . ($status === '1' ? ' and email sent' : '') . ' successfully.');
}


    public function show($id)
    {
    }

    public function edit($id)
    {
        $notice = NoticeBoard::find($id);
        $courses = Course::all();
        return view('admin.course.noticeboard.edit', compact('notice','courses'));
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'nullable|boolean', // Validate status if provided
        ]);
    
        // Find the NoticeBoard record by ID
        $noticeBoard = NoticeBoard::find($id);
    
        // Update the NoticeBoard entry
        $noticeBoard->update([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->has('status') ? '1' : '0', // Set status based on presence in request
        ]);
    
        return redirect()->back()->with('success', 'Notice updated successfully.');
    }
    

    public function destroy($id)
    {
        $notice = NoticeBoard::findOrFail($id);
        $notice->delete();
        return redirect()->back()->with('success', 'Notice Deleted successfully.');
    }

    public function bulk_delete(Request $request)
    {
        $validator = Validator::make($request->all(), ['checked' => 'required']);
        if ($validator->fails()) {
        return back()->with('error',trans('Please select field to be deleted.'));
        }
        NoticeBoard::whereIn('id',$request->checked)->delete();

        return back()->with('error',trans('Selected Notice has been deleted.'));      
    }

    public function noticestatus($id)
{
    $notice = NoticeBoard::findOrFail($id);

    // Toggle the status
    $newStatus = $notice->status == 0 ? 1 : 0;
    $notice->update(['status' => $newStatus]);

    // Return a JSON response
    return response()->json(['success' => true, 'status' => $newStatus]);
}

public function resendNotice($id)
{
    // Find the notice by ID
    $notice = NoticeBoard::find($id);

    if (!$notice) {
        return redirect()->back()->with('error', 'Notice not found.');
    }

    if ($notice->status != '1') {
        return redirect()->back()->with('error', 'Notice status is not active.');
    }

    // Fetch users to whom the notice should be sent
    $users = User::where('role', 'user')->get();

    foreach ($users as $user) {
        Mail::to($user->email)->send(new NoticeCreated($notice));
    }

    return redirect()->back()->with('success', 'Notice resent successfully.');
}
}
