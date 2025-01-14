<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Auth;
use TwilioMsg;
use App\Notifications\AdminOrder;
use App\Notifications\UserEnroll;
use App\User;
use App\Course;
use App\FileUpload;
use Notification;


class TestController extends Controller
{
	public function test(Request $request)
   	{
		
      return view('test');
   	}
	   public function uploadToServer(Request $request)
	   {
		
		   $request->validate([
			   'file' => 'required',
		   ]);
		   
		  $name = time().'.'.request()->file->getClientOriginalExtension();
	 
		  $request->file->move(public_path('uploads'), $name);
	
		  $file = new FileUpload();
		  $file->name = $name;
		  $file->save();
	 
		   return response()->json(['success'=>'Successfully uploaded.']);
	   }
}
