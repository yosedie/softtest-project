<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Setting;
use Mail;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Validator;
use Session;
use Spatie\Permission\Models\Role;

class ContactUsController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:contact-us.manage', ['only' => ['index','edit','update','destroy','bulk_delete']]);
     
    }
	public function index()
	{
		$items = Contact::all();
    	return view('admin.contact.index',compact('items'));
	}

	public function edit($id)
	{
    	$show = Contact::where('id', $id)->first();
    	return view('admin.contact.view',compact('show'));
	}

	public function update(Request $request, $id)
	{
		$data = Contact::findorfail($id);
        $input = $request->all();
        $data->update($input);
        Session::flash('success', trans('flash.UpdatedSuccessfully'));
		return redirect()->route('usermessage.index');
	}

	public function destroy($id)
	{
		Contact::where('id',$id)->delete();
			Session::flash('delete', trans('flash.DeletedSuccessfully'));
        return redirect()->route('usermessage.index');
	}

    public function usermessage(Request $request)
    {
        $setting = Setting::first();
 
        if($setting->captcha_enable == 1){

        	$data = $this->validate($request,[
                'fname' => 'required',
                'email' => 'required',
                'mobile' => 'required',
                'message' => 'required',
                'g-recaptcha-response' => 'required|captcha',
            ]);

        }else{

            $data = $this->validate($request,[
                'fname' => 'required',
                'email' => 'required',
                'mobile' => 'required',
                'message' => 'required',
            ]);

        }


        $created_contact = Contact::create([
            'fname' => $request->fname,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'message' => $request->message,
            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
            ]
        );


        $setting = Setting::first();



        if($created_contact)
        {
            if($setting->wel_email != NULL) 
            {
                if (env('MAIL_USERNAME')!=null) 
                {
                    try{
                        
                        /*sending email*/
                        $x = 'Hi';
                        $contact = $created_contact;
                        Mail::to($setting['wel_email'])->send(new ContactMail($x, $contact));


                    }catch(\Swift_TransportException $e){
                        
                        
                    }
                }
            }
        }
        
        
        
        return back()->with('success',trans('flash.RequestSuccessfully'));
    }

    // This function performs bulk delete action
    public function bulk_delete(Request $request)
    {
    
         $validator = Validator::make($request->all(), [
                'checked' => 'required',
            ]);
    
            if ($validator->fails()) {
    
                return back()->with('warning', 'Atleast one item is required to be checked');
               
            }
            else{
                Contact::whereIn('id',$request->checked)->delete();
                
                Session::flash('success',trans('Deleted Successfully'));
                return redirect()->back();
                
            }    
    }
        public function front(){
            $setting = Setting::first();
            if($setting->theme == '1'){
            return view('front.contact');
            }
            return view('theme_2.front.contact');
    
        }
}
