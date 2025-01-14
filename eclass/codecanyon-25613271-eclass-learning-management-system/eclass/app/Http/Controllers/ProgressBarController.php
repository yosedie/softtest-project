<?php

namespace App\Http\Controllers;

use App\FileUpload as AppFileUpload;
use Illuminate\Http\Request;
use App\FileUpload;

class ProgressBarController extends Controller
{
    public function index()
    {
        return view('welcomes');
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
