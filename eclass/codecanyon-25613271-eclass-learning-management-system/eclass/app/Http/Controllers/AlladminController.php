<?php

namespace App\Http\Controllers;

use App\Alladmin;
use App\User;
use App\Allstate;
use App\Allcity;
use App\Allcountry;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Role;
use App\HasRoles;
use Image;
use Auth;
use App\Wishlist;
use App\Cart;
use App\Order;
use App\ReviewRating;
use App\Question;
use App\Answer;
use App\State;
use App\City;
use App\Country;
use App\Course;
use App\Meeting;
use App\BundleCourse;
use App\BBL;
use App\Instructor;
use App\CourseProgress;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;


class AlladminController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
        $this->middleware('permission:Alladmin.view', ['only' => ['viewAllUser']]);
        $this->middleware('permission:Alladmin.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:Alladmin.edit', ['only' => ['edit', 'update','status']]);
        $this->middleware('permission:Alladmin.delete', ['only' => ['destroy', 'bulk_delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function viewAllUser(Request $request)
    {

         $data = User::select('*')->where('role', 'admin');
        if ($request->ajax()) {
            
            return DataTables::of($data)
                    ->addIndexColumn()
                   
                    ->editColumn('image','admin.alladmin.image')
                    ->editColumn('name','admin.alladmin.detail')
                    ->editColumn('loginasuser', 'admin.alladmin.login')
                    ->editColumn('status','admin.alladmin.status')
                    ->editColumn('action', 'admin.alladmin.action')
                    ->rawColumns(['image','name','loginasuser','status','action'])
                    ->make(true);
        }
        return view('admin.alladmin.index');
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {

        $cities = Allcity::all();
        $states = Allstate::all();
        $countries = Country::all();
        return view('admin.alladmin.adduser')->with(['cities' => $cities, 'states' => $states, 'countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        if (config('app.demolock') == 1) {
            return back()->with('delete', 'Disabled in demo');
        }
        $data = $this->validate($request, [
            'fname' => 'required',
            'lname' => 'required',
            'mobile' => 'required|regex:/[0-9]{9}/',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|max:20',
            'role' => 'required',
            'user_img' => 'mimes:jpg,jpeg,png,bmp,tiff,webp',
        ]);


        $input = $request->all();
        if ($file = $request->file('user_img')) 
        {            
            $optimizeImage = Image::make($file);
            $optimizePath = public_path().'/images/user_img/';
            $image = time().$file->getClientOriginalName();
            $optimizeImage->save($optimizePath.$image, 72);
            $input['user_img'] = $image;
            
        }

        $input['status'] = isset($request->status)  ? 1 : 0;
         $input['password'] = Hash::make($request->password);
        $input['detail'] = $request->detail;
        $input['email_verified_at'] = \Carbon\Carbon::now()->toDateTimeString();           
        $data = User::create($input);
        $data->save(); 

        Session::flash('success', trans('flash.AddedSuccessfully'));
        return redirect('user');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */

    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $cities = City::all();
        $states = State::all();
        $countries = Country::all();
        $user = User::findorfail($id);
        if(Auth::User()->role == 'admin')
        {
          $user = User::findorfail($id);
        }
        else{
          $user = User::where('id', Auth::User()->id)->first();
        }
        $cities = City::find($user->city_id);
        $states = Allstate::find($user->state_id);
        $countries = Allcountry::find($user->country_id);
        return view('admin.alladmin.edit',compact('cities','states','countries','user','cities','states','countries'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        if (config('app.demolock') == 1) {
            return back()->with('delete', 'Disabled in demo');
        }
        $this->validate($request,[
            'user_img' => 'mimes:jpg,jpeg,png,bmp,tiff'
        ]);

        if(Auth::User()->role == 'admin')
        {
          $user = User::findorfail($id);
        }
        else{
          $user = User::where('id', Auth::User()->id)->first();
        }

        $request->validate([
              'email' => 'required|email|unique:users,email,'.$user->id,
          ]);


        if(config('app.demolock') == 0){

          $input = $request->all();
          

          if($file = $request->file('user_img')) {

              if($user->user_img != null) {
                  $content = @file_get_contents(public_path().'/images/user_img/'.$user->user_img);
                  if ($content) {
                    unlink(public_path().'/images/user_img/'.$user->user_img);
                  }
              }

              $optimizeImage = Image::make($file);
              $optimizePath = public_path().'/images/user_img/';
              $image = time().$file->getClientOriginalName();
              $optimizeImage->save($optimizePath.$image, 72);
              $input['user_img'] = $image;
            
          }


          $verified = \Carbon\Carbon::now()->toDateTimeString();


          if(isset($request->verified)){
            
            $input['email_verified_at'] = $verified;
          }
          else{

            
            $input['email_verified_at'] = NULL;
          }


          if(isset($request->update_pass)){
            
              $input['password'] = Hash::make($request->password);
          }
          else{
              $input['password'] = $user->password;
          }

          if(isset($request->status))
          {
              $input['status'] = '1';
          }
          else
          {
              $input['status'] = '0';
          }

          $user->update($input);

          Session::flash('success', trans('flash.UpdatedSuccessfully'));


        }
        else
        {
          return back()->with('delete', trans('flash.DemoCannotupdate'));
        }

        return redirect()->route('alladmin.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = User::find($id);
        
        if(config('app.demolock') == 0){

            if ($user->user_img != null)
            {
                    
                $image_file = @file_get_contents(public_path().'/images/user_img/'.$user->user_img);

                if($image_file)
                {
                    unlink(public_path().'/images/user_img/'.$user->user_img);
                }
            }

            $value = $user->delete();
            Course::where('user_id', $id)->delete();
            Wishlist::where('user_id', $id)->delete();
            Cart::where('user_id', $id)->delete();
            Order::where('user_id', $id)->delete();
            ReviewRating::where('user_id', $id)->delete();
            Question::where('user_id', $id)->delete();
            Answer::where('ans_user_id', $id)->delete();
            Meeting::where('user_id', $id)->delete();
            BundleCourse::where('user_id', $id)->delete();
            BBL::where('instructor_id', $id)->delete();
            Instructor::where('user_id', $id)->delete();
            CourseProgress::where('user_id', $id)->delete();

            if($value)
            {
                session()->flash('delete',trans('flash.DeletedSuccessfully'));
                return redirect('user');
            }
        }
        else
        {
            return back()->with('delete',trans('flash.DemoCannotupdate'));
        }
    }
    
    public function bulk_delete(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('warning', 'Atleast one item is required to be checked');
           
        }
        else{
            User::whereIn('id',$request->checked)->delete();
            
            Session::flash('success',trans('Deleted Successfully'));
            return redirect()->back();
            
        }
    }
    
    public function status(Request $request)
    {
        $user = User::find($request->id);
        $user->status = $request->status;
        $user->save();
        return back()->with('success',trans('flash.UpdatedSuccessfully'));
        
        
    }
    public function login($id)
    {
        $user = User::findOrFail($id);
        Auth::login($user);
        Session::flash('success', trans('LoginSuccessfully'));
        return redirect('/');
    }
}
