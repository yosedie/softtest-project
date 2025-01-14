<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Instructor;
use DB;
use App\User;
use Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class InstructorRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:instructorrequest.view', ['only' => ['index']]);
        $this->middleware('permission:instructorrequest.create', ['only' => ['create','store']]);
        $this->middleware('permission:instructorrequest.edit', ['only' => ['edit','update']]);

    }
    public function index()
    {
        $items = Instructor::where('status', '0')->get();
        return view('admin.instructor.instructor_request.index',compact('items'));
    }

    public function create()
    {
        $data = Instructor::all();
        return view('admin.instructor.instructor_request.create',compact('data'));
    }

    public function edit($id)
    {
        $show = Instructor::where('id', $id)->first();
        return view('admin.instructor.instructor_request.view',compact('show'));
    }

    public function update(Request $request, $id)
    {

        $data = Instructor::findorfail($id);
        $input['status'] = $request->status;
        
        if($data->status == 1)
        {
            $show = User::where('id', $request->user_id)->first();
            $input['role'] = 'user';
            
            User::where('id', $request->user_id)
                    ->update(['role' => 'user']);
            Instructor::where('user_id', $request->user_id)
                    ->update(['status' => 0]);
            
        }
        else
        { 
            $show = User::where('id', $request->user_id)->first();
             $abc['role'] = $show->assignRole($request->role);
            User::where('id', $request->user_id)
                    ->update(['role' => $request->role]);
            Instructor::where('user_id', $request->user_id)
                    ->update(['status' => 1]);
            
        }

        $show = User::where('id', $request->user_id)->first();
        $input['detail'] = $request->detail;
        $input['mobile'] = $request->mobile;
        
        User::where('id', $request->user_id)
                    ->update(['detail' => $request->detail, 'mobile' => $request->mobile ]);

        return redirect()->route('requestinstructor.index');
    }

    public function destroy($id)
    {
        DB::table('instructors')->where('id',$id)->delete();
        return back();
    }

    public function allinstructor()
    {
        //  $items = User::select('*')->where('role', 'instructor')->get();
        $items = Instructor::all();
        return view('admin.instructor.all_instructor.index',compact('items'));
    }

    public function instructorpage()
    {
       
        return view('front.instructor');
    }


    public function instructor(Request $request)
    {
        $users = Instructor::where('user_id', $request->user_id)->get();

        if(!$users->isEmpty()){
            return back()->with('delete',trans('flash.AlreadyRequested'));  
        }
        else{


            $request->validate([
              'file' => 'mimes:jpeg,png,jpg,bmp,webp,zip,pdf',
              'image' => 'mimes:jpg,jpeg,png,bmp,webp'
            ]);

            $input = $request->all();


            if($file = $request->file('image'))
            {
                

                $validator = Validator::make(
                    [
                        'file' => $request->image,
                        'extension' => strtolower($request->image->getClientOriginalExtension()),
                    ],
                    [
                        'file' => 'required',
                        'extension' => 'required|in:jpg,jpeg,bmp,png,webp',
                    ]
                );

                if ($validator->fails()) {
                    return back()->withErrors('Invalid file !');
                }

                if ($file = $request->file('image'))
                {
                    $name = time().$file->getClientOriginalName();
                    $file->move('images/instructor', $name);
                    $input['image'] = $name;
                }
            }


            if($file = $request->file('file'))
            {
                

                $validator = Validator::make(
                    [
                        'file' => $request->file,
                        'extension' => strtolower($request->file->getClientOriginalExtension()),
                    ],
                    [
                        'file' => 'required',
                        'extension' => 'required|in:jpeg,png,jpg,bmp,webp,zip,pdf',
                    ]
                );

                if ($validator->fails()) {
                    return back()->withErrors('Invalid file !');
                }

                if($file = $request->file('file'))
                {
                    $name = time().$file->getClientOriginalName();
                    $file->move('files/instructor/',$name);
                    $input['file'] = $name;
                }
            }
             $data = Instructor::create($input);
            $data->save(); 
        }

        return back()->with('success',trans('flash.RequestSuccessfully'));

    }
}
