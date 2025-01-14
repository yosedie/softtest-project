<?php

namespace App\Http\Controllers;

use App\AdminSupport;
use App\SupportType;
use App\Mail\SupportTicketCreated;
use Illuminate\Support\Facades\Mail;
use App\Mail\SupportReplyNotification;
use Session;
use Auth;
use App\User;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AdminSupportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:support.manage', ['only' => ['index']]);
        $this->middleware('permission:support.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:support.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:support.delete', ['only' => ['destroy']]);

        $this->middleware('permission:support_admin.manage', ['only' => ['supportadmin','supportcreate','SupportReply','Supportdestroy','Supportbulk_delete']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supporttype = SupportType::get();
        return view("front.support",compact('supporttype'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSupportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "category" => "required",
            "priority" => "required",
            "subject" => "required",
            "message" => "required",

        ]);
        $randomNumber = 'TIC' . rand(100000, 999999);
        $support = new AdminSupport();
        $support->user_id = $request->filled('user_id') ? $request->input('user_id') : Auth::user()->id;
        $support->ticket_id = $randomNumber;
        $support['category'] = strip_tags($request->category);
        $support->status ="0";
        $support['priority'] = strip_tags($request->priority);
        $support['subject'] = strip_tags($request->subject);
        $support['message'] = strip_tags($request->message);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('images/support_issue', $filename);
            $support->image = $filename;
        }
        $support->save();

        $adminEmails = User::where('role', 'Admin')->pluck('email')->toArray();
        Mail::to($adminEmails)->send(new SupportTicketCreated($support));

        if(Auth::user()->role == 'Admin' || Auth::user()->role == 'admin'){
            return redirect()->route('support_admin.index')->with('success', 'Data has been added to admin support.');
        } else {
            return redirect()->route('supportuser')->with('success', 'Data has been added to user support.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function show(Support $support)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Support::find($id);       

        if ($data) {
            $res = $data->delete();
            if($res){
                return back()->with('error', trans('Item has been delete Successfully'));
            
            } else {
                return back()->with('error', trans('Try Again'));
            }
            
        } else {
            return back()->with('error', trans('Try Again'));
        }
    }

    public function viewTicket($ticket_id){
        $ticket = UserSupport::where('ticket_id', $ticket_id)->firstOrFail();
        if ($ticket->user_id == Auth::id() or Auth::user()->type == 'admin'){
            return view('panel.support.view', compact('ticket'));
        }else{
            return  back()->with(['message' => 'Unauthorized', 'type' => 'error']);
        }
    }

    public function viewTicketSendMessage(Request $request){
        $user = Auth::user();
        $ticket = UserSupport::where('ticket_id', $request->ticket_id)->firstOrFail();
        if ($user->type == 'admin'){
            $ticket->status = 'Answered';
            $ticket->save();

            $message = new UserSupportMessage();
            $message->user_support_id = $ticket->id;
            $message->sender = 'admin';
            $message->message = $request->message;
            $message->save();
        }else{
            $ticket->status = 'Waiting for answer';
            $ticket->save();
            $message = new UserSupportMessage();
            $message->user_support_id = $ticket->id;
            $message->sender = 'user';
            $message->message = $request->message;
            $message->save();
            createActivity(Auth::id(), 'Support request waiting for your answer', null,  route('dashboard.support.view', $ticket->ticket_id));
        }
    }


    public function supportadmin()
    {
        $supports = AdminSupport::all();
        $users = User::where('role','User')->orderBy('id' ,'desc')->get();
        $supportstypes = SupportType::all();
        return view('admin.support.support_admin',compact('supports','users','supportstypes'));
    }

    public function supportcreate()
    {
        $supporttype = SupportType::get();
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Admin');
        })
        ->orderBy('id', 'desc')
        ->get();
        return view('admin.support.support_admin_create',compact('supporttype','users'));
    }


    public function SupportReply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required'

        ]);
        $support = AdminSupport::find($id);
        $support->reply = $request->input('reply');
        $support->reply_to = "Admin";
        $support->status = "1";
        $support->save();
        Mail::to($support->user->email)->send(new SupportReplyNotification($support));

        return redirect('support_admin')->with('success', 'Data has been updated.');
    }

    function Supportdestroy($id)
    {
        $support = AdminSupport::find($id);
        $support->delete();
        return redirect('support_admin')->with('success', 'Data Deleted Successfully');
    }

    function Supportbulk_delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('warning', 'Atleast one item is required to be checked');
        }
        else{
            AdminSupport::whereIn('id',$request->checked)->delete();
            return redirect('support_admin')->with('success','Data Delete Successfully');
        }
    }
    
}
